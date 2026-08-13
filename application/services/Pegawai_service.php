<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Pegawai_service
 * Service Layer for handling employee business logic, validations, photo uploads, and audit logging.
 * Decouples logic from Controllers and Models in accordance with Clean Architecture principles.
 */
class Pegawai_service
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
     * Fetch all employee records with default photo fallbacks.
     *
     * @param bool $only_active
     * @return array
     */
    public function get_all_pegawai($only_active = FALSE)
    {
        $list = $this->CI->Pegawai_model->get_all($only_active);

        // Assign default photo fallback if empty or file doesn't exist
        foreach ($list as &$row) {
            $row['foto'] = $this->resolve_photo_path($row['foto'], $row['id_pegawai']);
        }

        return $list;
    }

    /**
     * Fetch summary statistics of employees by category.
     *
     * @return array
     */
    public function get_pegawai_stats()
    {
        return $this->CI->Pegawai_model->get_stats();
    }

    /**
     * Fetch a single employee record by ID with photo fallback.
     *
     * @param int $id
     * @return array
     */
    public function get_pegawai_by_id($id)
    {
        $id = (int)$id;
        if ($id <= 0) {
            return array('status' => FALSE, 'message' => 'ID Pegawai tidak valid.');
        }

        $row = $this->CI->Pegawai_model->get_by_id($id);
        if (!$row) {
            return array('status' => FALSE, 'message' => 'Data pegawai tidak ditemukan.');
        }

        $row['foto'] = $this->resolve_photo_path($row['foto'], $row['id_pegawai']);

        return array('status' => TRUE, 'data' => $row);
    }

    /**
     * Process employee creation or update with validation and photo upload.
     *
     * @param array $input Data array from $_POST
     * @param array $files File array from $_FILES
     * @return array Response payload array ['status' => bool, 'message' => string]
     */
    public function simpan_pegawai($input, $files = array())
    {
        $id_pegawai = !empty($input['id_pegawai']) ? (int)$input['id_pegawai'] : NULL;

        // Set Form Validation Rules
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('nip', 'NIP Pegawai', 'required|trim');
        $this->CI->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->CI->form_validation->set_rules('kategori', 'Kategori Pegawai', 'required|trim|in_list[Hakim,Panitera Pengganti,Jurusita,Staf]');
        $this->CI->form_validation->set_rules('pangkat', 'Pangkat', 'trim');
        $this->CI->form_validation->set_rules('golongan', 'Golongan', 'trim');
        $this->CI->form_validation->set_rules('jabatan', 'Jabatan', 'trim');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $nip = trim($input['nip']);

        // Check NIP uniqueness
        if ($this->CI->Pegawai_model->check_nip_exists($nip, $id_pegawai)) {
            return array(
                'status'  => FALSE,
                'message' => 'NIP ' . html_escape($nip) . ' sudah terdaftar dalam sistem.'
            );
        }

        // Handle profile photo upload if provided
        $foto_path = NULL;
        if (!empty($files['foto']['name'])) {
            $upload_result = $this->handle_photo_upload('foto');
            if (!$upload_result['status']) {
                return $upload_result;
            }
            $foto_path = $upload_result['file_path'];
        }

        // Build data array
        $data = array(
            'nip'      => $nip,
            'nama'     => trim($input['nama']),
            'pangkat'  => !empty($input['pangkat']) ? trim($input['pangkat']) : NULL,
            'golongan' => !empty($input['golongan']) ? trim($input['golongan']) : NULL,
            'jabatan'  => !empty($input['jabatan']) ? trim($input['jabatan']) : NULL,
            'kategori' => trim($input['kategori']),
            'aktif'    => isset($input['aktif']) ? (int)$input['aktif'] : 1,
        );

        if ($foto_path !== NULL) {
            $data['foto'] = $foto_path;
        }

        if (!empty($id_pegawai)) {
            // Update Operation
            $updated = $this->CI->Pegawai_model->update($id_pegawai, $data);
            if (!$updated) {
                return array('status' => FALSE, 'message' => 'Gagal memperbarui data pegawai.');
            }

            $this->log_audit('Pegawai', 'Memperbarui data pegawai NIP ' . $nip . ' (' . $data['nama'] . ')');
            return array(
                'status'  => TRUE,
                'message' => 'Data pegawai ' . html_escape($data['nama']) . ' berhasil diperbarui.'
            );
        } else {
            // Insert Operation
            $inserted_id = $this->CI->Pegawai_model->insert($data);
            if (!$inserted_id) {
                return array('status' => FALSE, 'message' => 'Gagal menambahkan data pegawai baru.');
            }

            $this->log_audit('Pegawai', 'Menambahkan pegawai baru NIP ' . $nip . ' (' . $data['nama'] . ')');
            return array(
                'status'  => TRUE,
                'message' => 'Data pegawai baru ' . html_escape($data['nama']) . ' berhasil ditambahkan.'
            );
        }
    }

    /**
     * Delete or soft-deactivate an employee record.
     *
     * @param int $id
     * @return array
     */
    public function hapus_pegawai($id)
    {
        $id = (int)$id;
        if ($id <= 0) {
            return array('status' => FALSE, 'message' => 'ID Pegawai tidak valid.');
        }

        $pegawai = $this->CI->Pegawai_model->get_by_id($id);
        if (!$pegawai) {
            return array('status' => FALSE, 'message' => 'Data pegawai tidak ditemukan.');
        }

        // Check historical TOPSIS integrity
        if ($this->CI->Pegawai_model->is_used_in_topsis($id)) {
            $this->CI->Pegawai_model->set_active_status($id, 0);
            $this->log_audit('Pegawai', 'Menonaktifkan pegawai NIP ' . $pegawai['nip'] . ' karena memiliki riwayat TOPSIS');
            return array(
                'status'  => TRUE,
                'message' => 'Pegawai ' . html_escape($pegawai['nama']) . ' memiliki riwayat penilaian TOPSIS. Data berhasil dinonaktifkan (Status: Nonaktif).'
            );
        }

        // Hard delete if no TOPSIS history exists
        $deleted = $this->CI->Pegawai_model->delete($id);
        if (!$deleted) {
            return array('status' => FALSE, 'message' => 'Gagal menghapus data pegawai.');
        }

        $this->log_audit('Pegawai', 'Menghapus data pegawai NIP ' . $pegawai['nip'] . ' (' . $pegawai['nama'] . ')');
        return array(
            'status'  => TRUE,
            'message' => 'Data pegawai ' . html_escape($pegawai['nama']) . ' berhasil dihapus.'
        );
    }

    /**
     * Private helper to process profile picture uploads via CI Upload library.
     *
     * @param string $field_name
     * @return array
     */
    private function handle_photo_upload($field_name)
    {
        $upload_dir = FCPATH . 'assets/uploads/pegawai/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, TRUE);
        }

        $config = array(
            'upload_path'   => $upload_dir,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048, // 2MB
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
            'file_path' => 'assets/uploads/pegawai/' . $upload_data['file_name']
        );
    }

    /**
     * Private helper to resolve a valid photo path or return a default placeholder.
     *
     * @param string|null $photo
     * @param int         $id
     * @return string
     */
    private function resolve_photo_path($photo, $id)
    {
        if (!empty($photo) && file_exists(FCPATH . $photo)) {
            return $photo;
        }

        return NULL;
    }

    /**
     * Private helper to log audit trail if audit_service is loaded.
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
