<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User
 * Controller for User Management and Authentication Logic.
 * PHP 5.6+ and CodeIgniter 3 Compatible.
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('auth_service');
    }

    /**
     * User Management Listing Page
     */
    public function index()
    {
        // Sample list fallback if table is empty
        $user_list = array();

        if ($this->db->table_exists('pengguna')) {
            $query = $this->db->get('pengguna');
            if ($query && $query->num_rows() > 0) {
                $user_list = $query->result_array();
            }
        }

        if (empty($user_list)) {
            $user_list = array(
                array(
                    'id_user'    => 1,
                    'username'   => 'superadmin',
                    'nama_user'  => 'Super Administrator SPK',
                    'email'      => 'superadmin@pn-lubukpakam.go.id',
                    'role'       => 'Superadmin',
                    'status'     => 1,
                    'last_login' => date('Y-m-d H:i:s')
                ),
                array(
                    'id_user'    => 2,
                    'username'   => 'admin_kepeg',
                    'nama_user'  => 'Admin Kepegawaian & Ortala',
                    'email'      => 'kepegawaian@pn-lubukpakam.go.id',
                    'role'       => 'Administrator',
                    'status'     => 1,
                    'last_login' => date('Y-m-d H:i:s')
                ),
                array(
                    'id_user'    => 3,
                    'username'   => 'ketua_pn',
                    'nama_user'  => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'email'      => 'ketua@pn-lubukpakam.go.id',
                    'role'       => 'Pimpinan',
                    'status'     => 1,
                    'last_login' => date('Y-m-d H:i:s')
                )
            );
        }

        $this->load->view('templates/layout', array(
            'page_title'   => 'Manajemen Pengguna',
            'page_heading' => 'Manajemen Pengguna Sistem',
            'active_menu'  => 'user',
            'content_view' => 'admin/user',
            'extra_css'    => array(
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'
            ),
            'extra_js'     => array(
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ),
            'view_data'    => array(
                'user_list' => $user_list
            )
        ));
    }

    /**
     * Ajax Authentication Handler (Login Process)
     */
    public function authenticate()
    {
        // Enforce JSON response header
        $this->output->set_content_type('application/json');

        // Get Input Data
        $username = trim((string) $this->input->post('username', TRUE));
        $password = trim((string) $this->input->post('password', TRUE));
        $remember = (bool) $this->input->post('remember');

        $errors = array();

        if (empty($username)) {
            $errors['username'] = 'Nama pengguna wajib diisi.';
        } elseif (strlen($username) < 3) {
            $errors['username'] = 'Nama pengguna minimal 3 karakter.';
        } elseif (strlen($username) > 50) {
            $errors['username'] = 'Nama pengguna maksimal 50 karakter.';
        }

        if (empty($password)) {
            $errors['password'] = 'Kata sandi wajib diisi.';
        } elseif (strlen($password) < 4) {
            $errors['password'] = 'Kata sandi minimal 4 karakter.';
        }

        if (!empty($errors)) {
            $username_err = isset($errors['username']) ? $errors['username'] : '';
            $password_err = isset($errors['password']) ? $errors['password'] : '';
            $first_error  = !empty($username_err) ? $username_err : $password_err;

            $response = array(
                'status'     => 'error',
                'code'       => 'VALIDATION_ERROR',
                'message'    => $first_error,
                'errors'     => array(
                    'username' => $username_err,
                    'password' => $password_err
                ),
                'csrf_token' => $this->security->get_csrf_hash(),
                'toast'      => array(
                    'type'    => 'danger',
                    'title'   => 'Validasi Gagal',
                    'message' => $first_error
                )
            );
            $this->output->set_output(json_encode($response));
            return;
        }

        // Execute Auth_service Layer
        $result = $this->auth_service->authenticate($username, $password, $remember);

        if ($result['status'] === TRUE) {
            $response = array(
                'status'     => 'success',
                'code'       => 'SUCCESS',
                'message'    => $result['message'],
                'redirect'   => site_url('dashboard'),
                'csrf_token' => $this->security->get_csrf_hash(),
                'toast'      => array(
                    'type'    => 'success',
                    'title'   => 'Autentikasi Berhasil',
                    'message' => 'Selamat datang kembali, ' . $result['user']['nama_lengkap'] . '!'
                )
            );
        } else {
            $toast_type = ($result['code'] === 'INACTIVE_USER') ? 'warning' : 'danger';
            $toast_title = ($result['code'] === 'INACTIVE_USER') ? 'Akun Nonaktif' : 'Autentikasi Gagal';

            $response = array(
                'status'     => 'error',
                'code'       => $result['code'],
                'message'    => $result['message'],
                'csrf_token' => $this->security->get_csrf_hash(),
                'toast'      => array(
                    'type'    => $toast_type,
                    'title'   => $toast_title,
                    'message' => $result['message']
                )
            );
        }

        $this->output->set_output(json_encode($response));
    }

    /**
     * Alias route method for login POST
     */
    public function login()
    {
        if ($this->input->method() === 'post') {
            $this->authenticate();
        } else {
            redirect('signin');
        }
    }

    /**
     * Logout Handler
     */
    public function logout()
    {
        $this->auth_service->logout();
        $this->session->set_flashdata('success', 'Anda telah berhasil keluar dari sistem BeRewards.');
        redirect('signin');
    }
}
