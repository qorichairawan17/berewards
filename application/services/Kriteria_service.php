<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Kriteria_service
 * Service Layer for handling Kriteria Penilaian TOPSIS business logic, validation,
 * qualitative scale option generation, and audit logging.
 * Decouples logic from Controllers and Models in accordance with Clean Architecture principles.
 */
class Kriteria_service
{
    /**
     * CodeIgniter Super Object Instance
     * @var CI_Controller
     */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Kriteria_model');
        $this->CI->load->library('form_validation');

        // Optional load Audit_service if present
        if (!isset($this->CI->audit_service)) {
            if (method_exists($this->CI->load, 'service')) {
                @$this->CI->load->service('audit_service');
            }
        }
    }

    /**
     * Fetch all kriteria records.
     *
     * @param string|null $kategori
     * @param bool        $aktif_only
     * @return array
     */
    public function get_all_kriteria($kategori = NULL, $aktif_only = FALSE)
    {
        return $this->CI->Kriteria_model->get_all_kriteria($kategori, $aktif_only);
    }

    /**
     * Fetch KPI card summary statistics for Kriteria module.
     *
     * @return array
     */
    public function get_stats()
    {
        return $this->CI->Kriteria_model->get_stats();
    }

    /**
     * Fetch single kriteria detail record by ID.
     *
     * @param int $id_kriteria
     * @return array
     */
    public function get_kriteria_detail($id_kriteria)
    {
        $id_kriteria = (int)$id_kriteria;
        if ($id_kriteria <= 0) {
            return array('status' => FALSE, 'message' => 'ID Kriteria tidak valid.');
        }

        $kriteria = $this->CI->Kriteria_model->get_kriteria_by_id($id_kriteria);
        if (!$kriteria) {
            return array('status' => FALSE, 'message' => 'Data Kriteria Penilaian tidak ditemukan.');
        }

        return array('status' => TRUE, 'data' => $kriteria);
    }

    /**
     * Save (insert or update) kriteria and sync qualitative rating scale.
     *
     * @param array $input Data array from $_POST
     * @return array Response payload array
     */
    public function simpan_kriteria($input)
    {
        $id_kriteria = !empty($input['id_kriteria']) ? (int)$input['id_kriteria'] : NULL;

        // Set Form Validation Rules
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('kode', 'Kode Kriteria', 'required|trim');
        $this->CI->form_validation->set_rules('nama_kriteria', 'Nama Kriteria', 'required|trim');
        $this->CI->form_validation->set_rules('kategori', 'Kategori Pegawai', 'required|trim|in_list[Hakim,Panitera Pengganti,Jurusita,Staf]');
        $this->CI->form_validation->set_rules('bobot', 'Bobot Kriteria', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->CI->form_validation->set_rules('jenis_data', 'Jenis Data', 'required|trim|in_list[kualitatif,kuantitatif]');
        $this->CI->form_validation->set_rules('tipe_atribut', 'Tipe Atribut', 'required|trim|in_list[benefit,cost]');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $kode          = trim($input['kode']);
        $nama_kriteria = trim($input['nama_kriteria']);
        $kategori      = trim($input['kategori']);
        $bobot         = (float)$input['bobot'];
        $jenis_data    = trim($input['jenis_data']);
        $tipe_atribut  = trim($input['tipe_atribut']);

        // Check Kode uniqueness
        if ($this->CI->Kriteria_model->check_kode_exists($kode, $id_kriteria)) {
            return array(
                'status'  => FALSE,
                'message' => 'Kode Kriteria (' . html_escape($kode) . ') sudah terdaftar dalam sistem.'
            );
        }

        // Build Data Array
        $data = array(
            'kode'          => $kode,
            'nama_kriteria' => $nama_kriteria,
            'kategori'      => $kategori,
            'bobot'         => $bobot,
            'jenis_data'    => $jenis_data,
            'tipe_atribut'  => $tipe_atribut,
            'aktif'         => 1
        );

        $old_kriteria = NULL;
        if (!empty($id_kriteria)) {
            $old_kriteria = $this->CI->Kriteria_model->get_kriteria_by_id($id_kriteria);
        }

        // Execute Database Transaction
        $this->CI->db->trans_start();

        if (!empty($id_kriteria)) {
            // Update Operation
            $this->CI->Kriteria_model->update_kriteria($id_kriteria, $data);
            $target_id = $id_kriteria;
            $act_msg   = 'Memperbarui Kriteria Penilaian TOPSIS (' . $kode . ' - ' . $nama_kriteria . ')';
        } else {
            // Insert Operation
            $target_id = $this->CI->Kriteria_model->insert_kriteria($data);
            $act_msg   = 'Menambahkan Kriteria Penilaian TOPSIS baru (' . $kode . ' - ' . $nama_kriteria . ')';
        }

        // Handle Sub Kriteria / Skala Penilaian Kualitatif
        if ($jenis_data === 'kualitatif') {
            $submitted_skala = array();

            // Cek apakah ada data sub kriteria dari input form (array atau json)
            if (!empty($input['skala_sub_kriteria']) && is_array($input['skala_sub_kriteria'])) {
                $sub_arr = $input['skala_sub_kriteria'];
                $val_arr = isset($input['skala_nilai']) ? $input['skala_nilai'] : array();
                $ket_arr = isset($input['skala_keterangan']) ? $input['skala_keterangan'] : array();

                foreach ($sub_arr as $idx => $sub_item) {
                    $sub_text = trim($sub_item);
                    if ($sub_text === '') continue;

                    $val_item = isset($val_arr[$idx]) && is_numeric($val_arr[$idx]) ? (float)$val_arr[$idx] : (float)(5 - $idx);
                    $ket_item = isset($ket_arr[$idx]) ? trim($ket_arr[$idx]) : '';

                    $submitted_skala[] = array(
                        'sub_kriteria' => $sub_text,
                        'nilai'        => $val_item,
                        'keterangan'   => $ket_item,
                        'label'        => !empty($ket_item) ? $ket_item : $sub_text,
                        'urutan'       => $idx + 1
                    );
                }
            } elseif (!empty($input['skala_json'])) {
                $decoded = json_decode($input['skala_json'], TRUE);
                if (is_array($decoded)) {
                    $submitted_skala = $decoded;
                }
            }

            if (!empty($submitted_skala)) {
                $this->CI->Kriteria_model->save_skala($target_id, $submitted_skala);
            } else {
                $existing_skala = $this->CI->Kriteria_model->get_skala_by_kriteria($target_id);
                if (empty($existing_skala)) {
                    $default_skala = array(
                        array('sub_kriteria' => 'Sangat Memenuhi Standar & Tanpa Pelanggaran', 'nilai' => 5.00, 'keterangan' => 'Sangat Baik',  'urutan' => 1),
                        array('sub_kriteria' => 'Memenuhi Standar dengan Baik',               'nilai' => 4.00, 'keterangan' => 'Baik',         'urutan' => 2),
                        array('sub_kriteria' => 'Cukup Memenuhi Standar Operasional',         'nilai' => 3.00, 'keterangan' => 'Cukup Baik',   'urutan' => 3),
                        array('sub_kriteria' => 'Terdapat Beberapa Catatan Keterlambatan',    'nilai' => 2.00, 'keterangan' => 'Kurang Baik',  'urutan' => 4),
                        array('sub_kriteria' => 'Tidak Memenuhi Standar / Pelanggaran',       'nilai' => 1.00, 'keterangan' => 'Buruk',        'urutan' => 5)
                    );
                    $this->CI->Kriteria_model->save_skala($target_id, $default_skala);
                }
            }
        } else {
            // Jika jenis data kuantitatif, bersihkan opsi skala kriteria
            $this->CI->Kriteria_model->save_skala($target_id, array());
        }

        $this->CI->db->trans_complete();

        if ($this->CI->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'message' => 'Gagal menyimpan data Kriteria Penilaian ke database.');
        }

        if (isset($this->CI->audit_service)) {
            if (!empty($id_kriteria)) {
                $this->CI->audit_service->log_update(
                    'kriteria',
                    $id_kriteria,
                    $old_kriteria ?: array(),
                    $data,
                    'Kriteria Penilaian',
                    $act_msg
                );
            } else {
                $this->CI->audit_service->log_insert(
                    'kriteria',
                    $target_id,
                    $data,
                    'Kriteria Penilaian',
                    $act_msg
                );
            }
        }

        return array(
            'status'  => TRUE,
            'message' => 'Kriteria Penilaian (' . html_escape($kode) . ') berhasil disimpan.'
        );
    }

    /**
     * Deactivate/delete kriteria record.
     *
     * @param int $id_kriteria
     * @return array
     */
    public function hapus_kriteria($id_kriteria)
    {
        $id_kriteria = (int)$id_kriteria;
        if ($id_kriteria <= 0) {
            return array('status' => FALSE, 'message' => 'ID Kriteria tidak valid.');
        }

        $kriteria = $this->CI->Kriteria_model->get_kriteria_by_id($id_kriteria);
        if (!$kriteria) {
            return array('status' => FALSE, 'message' => 'Data Kriteria Penilaian tidak ditemukan.');
        }

        $deleted = $this->CI->Kriteria_model->delete_kriteria($id_kriteria, FALSE);
        if (!$deleted) {
            return array('status' => FALSE, 'message' => 'Gagal menonaktifkan data Kriteria Penilaian.');
        }

        if (isset($this->CI->audit_service)) {
            $new_state = $kriteria;
            $new_state['aktif'] = 0;
            $this->CI->audit_service->log_update(
                'kriteria',
                $id_kriteria,
                $kriteria,
                $new_state,
                'Kriteria Penilaian',
                'Menonaktifkan Kriteria ' . $kriteria['kode'] . ' - ' . $kriteria['nama_kriteria']
            );
        }

        return array(
            'status'  => TRUE,
            'message' => 'Kriteria (' . html_escape($kriteria['kode']) . ') telah dinonaktifkan dari referensi.'
        );
    }

    /**
     * Private helper to log audit trail.
     *
     * @param string $modul
     * @param string $aktivitas
     * @return void
     */
    private function log_audit($modul, $aktivitas)
    {
        if (isset($this->CI->audit_service)) {
            $user_id   = $this->CI->session->userdata('user_id');
            $username  = $this->CI->session->userdata('username');
            $nama_user = $this->CI->session->userdata('nama_lengkap');
            $role      = $this->CI->session->userdata('role');
            @$this->CI->audit_service->log_activity($modul, $aktivitas, 'Sukses', $user_id, $username, $nama_user, $role);
        }
    }
}
