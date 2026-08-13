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

        // Auto-generate default 5-point rating scale for qualitative data if not present
        if ($jenis_data === 'kualitatif') {
            $existing_skala = $this->CI->Kriteria_model->get_skala_by_kriteria($target_id);
            if (empty($existing_skala)) {
                $default_skala = array(
                    array('label' => 'Sangat Baik',  'nilai' => 5.00, 'urutan' => 1),
                    array('label' => 'Baik',         'nilai' => 4.00, 'urutan' => 2),
                    array('label' => 'Cukup',        'nilai' => 3.00, 'urutan' => 3),
                    array('label' => 'Kurang',       'nilai' => 2.00, 'urutan' => 4),
                    array('label' => 'Sangat Kurang','nilai' => 1.00, 'urutan' => 5)
                );
                $this->CI->Kriteria_model->save_skala($target_id, $default_skala);
            }
        }

        $this->CI->db->trans_complete();

        if ($this->CI->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'message' => 'Gagal menyimpan data Kriteria Penilaian ke database.');
        }

        $this->log_audit('Kriteria Penilaian', $act_msg);

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

        $this->log_audit('Kriteria Penilaian', 'Menonaktifkan Kriteria ' . $kriteria['kode'] . ' - ' . $kriteria['nama_kriteria']);

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
