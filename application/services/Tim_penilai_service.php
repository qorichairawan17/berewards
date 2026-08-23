<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Tim_penilai_service
 * Service Layer for handling Tim Penilai business logic, member dynamic syncing,
 * PDF document uploads, and audit logging.
 * Decouples logic from Controllers and Models in accordance with Clean Architecture principles.
 */
class Tim_penilai_service
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
        $this->CI->load->model('Tim_penilai_model');
        $this->CI->load->model('Pegawai_model');
        $this->CI->load->library('form_validation');

        // Optional load Audit_service if present
        if (!isset($this->CI->audit_service)) {
            if (method_exists($this->CI->load, 'service')) {
                @$this->CI->load->service('audit_service');
            }
        }
    }

    /**
     * Fetch all SK Tim Penilai records.
     *
     * @return array
     */
    public function get_all_sk()
    {
        return $this->CI->Tim_penilai_model->get_all_sk();
    }

    /**
     * Fetch KPI card summary statistics for Tim Penilai.
     *
     * @return array
     */
    public function get_stats()
    {
        return $this->CI->Tim_penilai_model->get_stats();
    }

    /**
     * Fetch single SK detail record by ID.
     *
     * @param int $id_sk
     * @return array
     */
    public function get_sk_detail($id_sk)
    {
        $id_sk = (int)$id_sk;
        if ($id_sk <= 0) {
            return array('status' => FALSE, 'message' => 'ID SK tidak valid.');
        }

        $sk = $this->CI->Tim_penilai_model->get_sk_by_id($id_sk);
        if (!$sk) {
            return array('status' => FALSE, 'message' => 'Dokumen SK Tim Penilai tidak ditemukan.');
        }

        return array('status' => TRUE, 'data' => $sk);
    }

    /**
     * Save (insert or update) SK Tim Penilai and its members.
     *
     * @param array $input Data array from $_POST
     * @param array $files File array from $_FILES
     * @return array Response payload array
     */
    public function simpan_sk($input, $files = array())
    {
        $id_sk = !empty($input['id_sk']) ? (int)$input['id_sk'] : NULL;

        // Set Form Validation Rules
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('no_sk', 'Nomor SK', 'required|trim');
        $this->CI->form_validation->set_rules('tahun', 'Tahun Evaluasi', 'required|numeric');
        $this->CI->form_validation->set_rules('tanggal_sk', 'Tanggal Terbit SK', 'required|trim');
        $this->CI->form_validation->set_rules('perihal', 'Perihal SK', 'required|trim');
        $this->CI->form_validation->set_rules('status', 'Status SK', 'required|trim|in_list[Aktif,Selesai,Arsip]');
        $this->CI->form_validation->set_rules('id_ketua', 'Ketua Tim Penilai', 'required|numeric');
        $this->CI->form_validation->set_rules('id_sekretaris', 'Sekretaris Tim Penilai', 'required|numeric');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $no_sk = trim($input['no_sk']);

        // Check No SK uniqueness
        if ($this->CI->Tim_penilai_model->check_nosk_exists($no_sk, $id_sk)) {
            return array(
                'status'  => FALSE,
                'message' => 'Nomor SK ' . html_escape($no_sk) . ' sudah terdaftar dalam sistem.'
            );
        }

        // Handle PDF File Upload if provided
        $file_sk_path = NULL;
        if (!empty($files['file_sk']['name'])) {
            $upload_result = $this->handle_pdf_upload('file_sk');
            if (!$upload_result['status']) {
                return $upload_result;
            }
            $file_sk_path = $upload_result['file_path'];
        }

        // Build Header SK Data array
        $sk_data = array(
            'no_sk'      => $no_sk,
            'tahun'      => (int)$input['tahun'],
            'tanggal_sk' => trim($input['tanggal_sk']),
            'perihal'    => trim($input['perihal']),
            'status'     => trim($input['status'])
        );

        if ($file_sk_path !== NULL) {
            $sk_data['file_sk'] = $file_sk_path;
        }

        // Build Anggota List (Ketua, Sekretaris, + Anggota Fleksibel)
        $anggota_list = array();

        // 1. Ketua Row
        $id_ketua = (int)$input['id_ketua'];
        $ketua_pegawai = $this->CI->Pegawai_model->get_by_id($id_ketua);
        if ($ketua_pegawai) {
            $anggota_list[] = array(
                'id_pegawai'         => $id_ketua,
                'nama_personel'      => $ketua_pegawai['nama'],
                'nip'                => $ketua_pegawai['nip'],
                'jabatan_instansi'   => !empty($ketua_pegawai['jabatan']) ? $ketua_pegawai['jabatan'] : 'Ketua Pengadilan Negeri',
                'peran_tim'          => 'Ketua',
                'kategori_penilaian' => 'Penanggung Jawab Utama'
            );
        }

        // 2. Sekretaris Row
        $id_sekretaris = (int)$input['id_sekretaris'];
        $sekretaris_pegawai = $this->CI->Pegawai_model->get_by_id($id_sekretaris);
        if ($sekretaris_pegawai) {
            $anggota_list[] = array(
                'id_pegawai'         => $id_sekretaris,
                'nama_personel'      => $sekretaris_pegawai['nama'],
                'nip'                => $sekretaris_pegawai['nip'],
                'jabatan_instansi'   => !empty($sekretaris_pegawai['jabatan']) ? $sekretaris_pegawai['jabatan'] : 'Sekretaris Pengadilan Negeri',
                'peran_tim'          => 'Sekretaris',
                'kategori_penilaian' => 'Sekretaris Pengelola Tim'
            );
        }

        // 3. Additional Dynamic Members Row (anggota_pegawai[])
        if (!empty($input['anggota_pegawai']) && is_array($input['anggota_pegawai'])) {
            foreach ($input['anggota_pegawai'] as $index => $id_peg_anggota) {
                $id_peg_anggota = (int)$id_peg_anggota;
                if ($id_peg_anggota <= 0 || $id_peg_anggota === $id_ketua || $id_peg_anggota === $id_sekretaris) {
                    continue; // Skip invalid or duplicate Ketua/Sekretaris
                }

                $peg = $this->CI->Pegawai_model->get_by_id($id_peg_anggota);
                if (!$peg) continue;

                // Resolve selected checkboxes for this member row
                $kategori_selected = array();
                $field_key = 'add_kategori_' . ($index + 1);
                if (!empty($input[$field_key]) && is_array($input[$field_key])) {
                    $kategori_selected = $input[$field_key];
                } elseif (!empty($input['anggota_kategori'][$index]) && is_array($input['anggota_kategori'][$index])) {
                    $kategori_selected = $input['anggota_kategori'][$index];
                }

                $kategori_label = !empty($kategori_selected) 
                    ? 'Penilai Kategori ' . implode(', ', $kategori_selected)
                    : 'Penilai Kategori General';

                $anggota_list[] = array(
                    'id_pegawai'         => $id_peg_anggota,
                    'nama_personel'      => $peg['nama'],
                    'nip'                => $peg['nip'],
                    'jabatan_instansi'   => !empty($peg['jabatan']) ? $peg['jabatan'] : 'Hakim / Pejabat PN',
                    'peran_tim'          => 'Anggota',
                    'kategori_penilaian' => $kategori_label
                );
            }
        }

        $old_sk = NULL;
        if (!empty($id_sk)) {
            $old_sk = $this->CI->Tim_penilai_model->get_sk_by_id($id_sk);
        }

        // Execute Database Transaction
        $this->CI->db->trans_start();

        if (!empty($id_sk)) {
            // Update Operation
            $this->CI->Tim_penilai_model->update_sk($id_sk, $sk_data);
            $this->CI->Tim_penilai_model->sync_anggota($id_sk, $anggota_list);
            $target_id = $id_sk;
            $act_msg   = 'Memperbarui SK Tim Penilai ' . $no_sk;
        } else {
            // Insert Operation
            $target_id = $this->CI->Tim_penilai_model->insert_sk($sk_data);
            $this->CI->Tim_penilai_model->sync_anggota($target_id, $anggota_list);
            $act_msg   = 'Menambahkan SK Tim Penilai baru ' . $no_sk;
        }

        $this->CI->db->trans_complete();

        if ($this->CI->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'message' => 'Gagal menyimpan data SK Tim Penilai ke database.');
        }

        if (isset($this->CI->audit_service)) {
            $full_new_data = $sk_data;
            $full_new_data['anggota'] = $anggota_list;

            if (!empty($id_sk)) {
                $this->CI->audit_service->log_update(
                    'tim_penilai_sk',
                    $id_sk,
                    $old_sk ?: array(),
                    $full_new_data,
                    'Tim Penilai',
                    $act_msg
                );
            } else {
                $this->CI->audit_service->log_insert(
                    'tim_penilai_sk',
                    $target_id,
                    $full_new_data,
                    'Tim Penilai',
                    $act_msg
                );
            }
        }

        return array(
            'status'  => TRUE,
            'message' => 'SK Tim Penilai (' . html_escape($no_sk) . ') berhasil disimpan.'
        );
    }

    /**
     * Delete SK Tim Penilai record and associated PDF file.
     *
     * @param int $id_sk
     * @return array
     */
    public function hapus_sk($id_sk)
    {
        $id_sk = (int)$id_sk;
        if ($id_sk <= 0) {
            return array('status' => FALSE, 'message' => 'ID SK tidak valid.');
        }

        $sk = $this->CI->Tim_penilai_model->get_sk_by_id($id_sk);
        if (!$sk) {
            return array('status' => FALSE, 'message' => 'Dokumen SK tidak ditemukan.');
        }

        // Delete physical PDF file if present on server
        if (!empty($sk['file_sk']) && file_exists(FCPATH . $sk['file_sk'])) {
            @unlink(FCPATH . $sk['file_sk']);
        }

        $deleted = $this->CI->Tim_penilai_model->delete_sk($id_sk);
        if (!$deleted) {
            return array('status' => FALSE, 'message' => 'Gagal menghapus dokumen SK Tim Penilai.');
        }

        if (isset($this->CI->audit_service)) {
            $this->CI->audit_service->log_delete(
                'tim_penilai_sk',
                $id_sk,
                $sk,
                'Tim Penilai',
                'Menghapus SK Tim Penilai ' . $sk['no_sk']
            );
        }

        return array(
            'status'  => TRUE,
            'message' => 'Dokumen SK (' . html_escape($sk['no_sk']) . ') berhasil dihapus.'
        );
    }

    /**
     * Private helper to upload PDF document via CI Upload library.
     *
     * @param string $field_name
     * @return array
     */
    private function handle_pdf_upload($field_name)
    {
        $upload_dir = FCPATH . 'uploads/sk/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, TRUE);
        }

        $config = array(
            'upload_path'   => $upload_dir,
            'allowed_types' => 'pdf',
            'max_size'      => 5120, // 5MB
            'encrypt_name'  => TRUE
        );

        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);

        if (!$this->CI->upload->do_upload($field_name)) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags($this->CI->upload->display_errors('', ''))
            );
        }

        $upload_data = $this->CI->upload->data();
        return array(
            'status'    => TRUE,
            'file_path' => 'uploads/sk/' . $upload_data['file_name']
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
