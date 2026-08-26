<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User
 * Controller for User Management and Authentication Logic.
 * Following Clean Architecture: strictly thin controller that delegates all business logic,
 * validation, and DB operations to User_service and Auth_service.
 * PHP 5.6+ and CodeIgniter 3 Compatible.
 */
class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Enforce Authentication and RBAC on management actions
        $action = $this->router->fetch_method();
        if (!in_array($action, array('authenticate', 'logout'), TRUE)) {
            $this->auth_middleware->guard(array('superadmin', 'administrator'));
        }

        // Load Service Layers
        $this->load->service('User_service');
        $this->load->service('Setting_service');
    }

    /**
     * User Management Listing Page
     */
    public function index()
    {
        $user_list    = $this->user_service->get_all_users();
        $pegawai_list = $this->user_service->get_pegawai_options();
        $stats        = $this->user_service->get_stats();
        $settings     = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Manajemen Pengguna — BeRewards',
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
                'user_list'    => $user_list,
                'pegawai_list' => $pegawai_list,
                'stats'        => $stats,
                'settings'     => $settings
            )
        ));
    }

    /**
     * JSON Endpoint to return user list, employee options, and stats for AJAX reload.
     */
    public function data()
    {
        $response = array(
            'status'       => TRUE,
            'data'         => $this->user_service->get_all_users(),
            'pegawai_list' => $this->user_service->get_pegawai_options(),
            'stats'        => $this->user_service->get_stats(),
            'settings'     => $this->setting_service->get_settings()
        );

        $this->json_response($response);
    }

    /**
     * JSON Endpoint to return single user detail by ID.
     *
     * @param int|null $id
     */
    public function detail($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_user');
        }

        $result = $this->user_service->get_user_detail($id);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for saving (insert / update) user data.
     */
    public function simpan()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS-clean POST data
        $result     = $this->user_service->simpan_user($input_data);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for deleting/deactivating user.
     *
     * @param int|null $id
     */
    public function hapus($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_user');
        }

        $result = $this->user_service->hapus_user($id);
        $this->json_response($result);
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
            $redirect_url = $this->session->userdata('intended_url');
            if (!empty($redirect_url)) {
                $this->session->unset_userdata('intended_url');
            } else {
                $redirect_url = site_url('dashboard');
            }

            $response = array(
                'status'     => 'success',
                'code'       => 'SUCCESS',
                'message'    => $result['message'],
                'redirect'   => $redirect_url,
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
