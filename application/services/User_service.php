<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User_service
 * Service Layer for handling User Management business logic, validation,
 * employee relationship integration, password hashing, and audit logging.
 * Decouples logic from Controllers and Models in accordance with Clean Architecture principles.
 */
class User_service
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
        $this->CI->load->model('User_model');
        $this->CI->load->library('form_validation');

        // Optional load Audit_service if present
        if (!isset($this->CI->audit_service)) {
            if (method_exists($this->CI->load, 'service')) {
                @$this->CI->load->service('audit_service');
            }
        }
    }

    /**
     * Fetch all user records with linked employee details.
     *
     * @param bool $aktif_only
     * @return array
     */
    public function get_all_users($aktif_only = FALSE)
    {
        return $this->CI->User_model->get_all_users($aktif_only);
    }

    /**
     * Fetch active employees list for selection dropdown.
     *
     * @return array
     */
    public function get_pegawai_options()
    {
        return $this->CI->User_model->get_pegawai_options();
    }

    /**
     * Fetch KPI card summary statistics for User module.
     *
     * @return array
     */
    public function get_stats()
    {
        return $this->CI->User_model->get_stats();
    }

    /**
     * Fetch single user detail record by ID.
     *
     * @param int $id_user
     * @return array
     */
    public function get_user_detail($id_user)
    {
        $id_user = (int)$id_user;
        if ($id_user <= 0) {
            return array('status' => FALSE, 'message' => 'ID Pengguna tidak valid.');
        }

        $user = $this->CI->User_model->get_user_by_id($id_user);
        if (!$user) {
            return array('status' => FALSE, 'message' => 'Data Pengguna tidak ditemukan.');
        }

        // Strip sensitive password hash before sending to client
        unset($user['password']);

        return array('status' => TRUE, 'data' => $user);
    }

    /**
     * Save (insert or update) user record linked with an employee.
     *
     * @param array $input Data array from $_POST
     * @return array Response payload array
     */
    public function simpan_user($input)
    {
        $id_user = !empty($input['id_user']) ? (int)$input['id_user'] : NULL;

        // Normalize nama field from either nama_user or nama_lengkap
        if (isset($input['nama_user']) && !isset($input['nama_lengkap'])) {
            $input['nama_lengkap'] = $input['nama_user'];
        }

        // Normalize status/aktif field
        if (isset($input['status']) && !isset($input['aktif'])) {
            $input['aktif'] = $input['status'];
        }

        // Normalize role to lowercase
        if (isset($input['role'])) {
            $raw_role = strtolower(str_replace(' ', '_', trim($input['role'])));
            $input['role'] = $raw_role;
        }

        // Set Form Validation Rules
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('id_pegawai', 'Pegawai Terkait', 'required|numeric');
        $this->CI->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[50]');
        $this->CI->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        if (!empty($input['email'])) {
            $this->CI->form_validation->set_rules('email', 'Email Instansi', 'trim|valid_email');
        }
        $this->CI->form_validation->set_rules('role', 'Hak Akses Role', 'required|trim|in_list[superadmin,administrator,tim_penilai,pimpinan]');
        $this->CI->form_validation->set_rules('aktif', 'Status Akun', 'required|in_list[0,1]');

        if (empty($id_user)) {
            $this->CI->form_validation->set_rules('password', 'Kata Sandi', 'required|min_length[4]');
        } else {
            if (!empty($input['password'])) {
                $this->CI->form_validation->set_rules('password', 'Kata Sandi', 'min_length[4]');
            }
        }

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $id_pegawai   = (int)$input['id_pegawai'];
        $username     = trim($input['username']);
        $nama_lengkap = trim($input['nama_lengkap']);
        $email        = !empty($input['email']) ? trim($input['email']) : NULL;
        $role         = trim($input['role']);
        $aktif        = (int)$input['aktif'];

        // Verify Pegawai exists
        $pegawai = $this->CI->db->get_where('referensi_pegawai', array('id_pegawai' => $id_pegawai))->row_array();
        if (!$pegawai) {
            return array(
                'status'  => FALSE,
                'message' => 'Data Pegawai yang dipilih tidak ditemukan dalam database.'
            );
        }

        // Validate Pegawai is not already linked to another active user
        if ($this->CI->User_model->check_pegawai_linked($id_pegawai, $id_user)) {
            return array(
                'status'  => FALSE,
                'message' => 'Pegawai "' . html_escape($pegawai['nama']) . '" sudah terhubung dengan akun pengguna lain.'
            );
        }

        // Validate Username Uniqueness
        if ($this->CI->User_model->check_username_exists($username, $id_user)) {
            return array(
                'status'  => FALSE,
                'message' => 'Username (' . html_escape($username) . ') sudah terdaftar dalam sistem.'
            );
        }

        // Validate Email Uniqueness if provided
        if (!empty($email) && $this->CI->User_model->check_email_exists($email, $id_user)) {
            return array(
                'status'  => FALSE,
                'message' => 'Email (' . html_escape($email) . ') sudah terdaftar dalam sistem.'
            );
        }

        // Build Data Payload
        $data = array(
            'id_pegawai'   => $id_pegawai,
            'username'     => $username,
            'nama_lengkap' => $nama_lengkap,
            'email'        => $email,
            'role'         => $role,
            'aktif'        => $aktif
        );

        // Hash password if provided
        if (!empty($input['password'])) {
            $data['password'] = password_hash(trim($input['password']), PASSWORD_BCRYPT);
        }

        $old_user = NULL;
        if (!empty($id_user)) {
            $old_user = $this->CI->User_model->get_user_by_id($id_user);
        }

        // Execute Database Transaction
        $this->CI->db->trans_start();

        if (!empty($id_user)) {
            // Update Operation
            $this->CI->User_model->update_user($id_user, $data);
            $target_id = $id_user;
            $act_msg   = 'Memperbarui data Pengguna (' . $username . ' - ' . $nama_lengkap . ') terhubung dengan Pegawai (' . $pegawai['nama'] . ')';
        } else {
            // Insert Operation
            $target_id = $this->CI->User_model->insert_user($data);
            $act_msg   = 'Menambahkan Pengguna baru (' . $username . ' - ' . $nama_lengkap . ') terhubung dengan Pegawai (' . $pegawai['nama'] . ')';
        }

        $this->CI->db->trans_complete();

        if ($this->CI->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'message' => 'Gagal menyimpan data Pengguna ke database.');
        }

        if (isset($this->CI->audit_service)) {
            if (!empty($id_user)) {
                $this->CI->audit_service->log_update(
                    'pengguna',
                    $id_user,
                    $old_user ?: array(),
                    $data,
                    'Manajemen Pengguna',
                    $act_msg
                );
            } else {
                $this->CI->audit_service->log_insert(
                    'pengguna',
                    $target_id,
                    $data,
                    'Manajemen Pengguna',
                    $act_msg
                );
            }
        }

        return array(
            'status'  => TRUE,
            'message' => 'Data Pengguna (' . html_escape($username) . ') berhasil disimpan.'
        );
    }

    /**
     * Deactivate/delete user record.
     *
     * @param int $id_user
     * @return array
     */
    public function hapus_user($id_user)
    {
        $id_user = (int)$id_user;
        if ($id_user <= 0) {
            return array('status' => FALSE, 'message' => 'ID Pengguna tidak valid.');
        }

        // Prevent self-deletion of active user
        $current_user_id = (int)$this->CI->session->userdata('user_id');
        if ($current_user_id > 0 && $id_user === $current_user_id) {
            return array('status' => FALSE, 'message' => 'Anda tidak dapat menonaktifkan akun yang sedang aktif digunakan.');
        }

        $user = $this->CI->User_model->get_user_by_id($id_user);
        if (!$user) {
            return array('status' => FALSE, 'message' => 'Data Pengguna tidak ditemukan.');
        }

        $deleted = $this->CI->User_model->delete_user($id_user, FALSE);
        if (!$deleted) {
            return array('status' => FALSE, 'message' => 'Gagal menonaktifkan data Pengguna.');
        }

        if (isset($this->CI->audit_service)) {
            $new_state = $user;
            $new_state['aktif'] = 0;
            $this->CI->audit_service->log_update(
                'pengguna',
                $id_user,
                $user,
                $new_state,
                'Manajemen Pengguna',
                'Menonaktifkan Akun Pengguna ' . $user['username'] . ' (' . $user['nama_lengkap'] . ')'
            );
        }

        return array(
            'status'  => TRUE,
            'message' => 'Akun Pengguna (' . html_escape($user['username']) . ') telah dinonaktifkan.'
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
