<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth_middleware
 * Reusable Middleware Layer for Authentication Guards, Role-Based Access Control (RBAC),
 * Guest-only Filters, and Automatic Session Interception.
 * Stored in dedicated directory: application/middleware/
 */
class Auth_middleware
{
    /**
     * CodeIgniter Super Object Instance
     * @var CI_Controller
     */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');

        // Ensure Auth_service is loaded
        if (!isset($this->CI->auth_service)) {
            if (method_exists($this->CI->load, 'service')) {
                @$this->CI->load->service('auth_service');
            } else {
                @$this->CI->load->library('auth_service');
            }
        }
    }

    /**
     * Primary Guard: Enforce authenticated session with optional Role Authorization.
     *
     * @param string|array|null $allowed_roles Optional list of allowed roles (e.g. 'superadmin' or ['superadmin', 'administrator'])
     * @return bool Returns TRUE if authorized; otherwise halts execution with redirect/JSON.
     */
    public function guard($allowed_roles = NULL)
    {
        // 1. Check if user is logged in
        if (!$this->is_logged_in()) {
            $this->handle_unauthenticated();
            return FALSE;
        }

        // 2. Check role authorization if specified
        if (!empty($allowed_roles)) {
            if (!$this->has_role($allowed_roles)) {
                $this->handle_forbidden();
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Alias for guard().
     *
     * @param string|array|null $allowed_roles
     * @return bool
     */
    public function require_auth($allowed_roles = NULL)
    {
        return $this->guard($allowed_roles);
    }

    /**
     * Enforce specific roles requirement for already logged-in users.
     *
     * @param string|array $roles
     * @return bool
     */
    public function require_roles($roles)
    {
        return $this->guard($roles);
    }

    /**
     * Guest-only filter: Prevents logged-in users from accessing guest pages (e.g. Signin page).
     * Redirects authenticated users directly to the Dashboard.
     *
     * @param string $redirect_to Route to redirect to if logged in (default: 'dashboard')
     * @return bool
     */
    public function guest_only($redirect_to = 'dashboard')
    {
        if ($this->is_logged_in()) {
            if ($this->is_ajax()) {
                $this->json_response(array(
                    'status'   => TRUE,
                    'code'     => 'ALREADY_AUTHENTICATED',
                    'message'  => 'Anda sudah dalam keadaan masuk.',
                    'redirect' => site_url($redirect_to)
                ), 200);
            }

            redirect($redirect_to);
            exit;
        }

        return TRUE;
    }

    /**
     * Check whether current session is authenticated.
     *
     * @return bool
     */
    public function is_logged_in()
    {
        return (bool) $this->CI->session->userdata('logged_in');
    }

    /**
     * Check whether current user has any of the given roles.
     *
     * @param string|array $roles
     * @return bool
     */
    public function has_role($roles)
    {
        if (!$this->is_logged_in()) {
            return FALSE;
        }

        $user_role = strtolower(trim((string)$this->CI->session->userdata('role')));

        if (is_string($roles)) {
            $roles = array_map('trim', explode(',', $roles));
        }

        if (is_array($roles)) {
            $normalized_roles = array_map('strtolower', array_map('trim', $roles));
            return in_array($user_role, $normalized_roles, TRUE);
        }

        return FALSE;
    }

    /**
     * Get active user session information array.
     *
     * @return array|null
     */
    public function user()
    {
        if (!$this->is_logged_in()) {
            return NULL;
        }

        return array(
            'id_user'      => (int) $this->CI->session->userdata('user_id'),
            'id_pegawai'   => $this->CI->session->userdata('id_pegawai'),
            'username'     => $this->CI->session->userdata('username'),
            'nama_lengkap' => $this->CI->session->userdata('nama_lengkap'),
            'email'        => $this->CI->session->userdata('email'),
            'role'         => $this->CI->session->userdata('role'),
            'role_label'   => $this->CI->session->userdata('role_label'),
            'avatar'       => $this->CI->session->userdata('avatar')
        );
    }

    /**
     * Get current user ID.
     *
     * @return int|null
     */
    public function id()
    {
        return $this->is_logged_in() ? (int)$this->CI->session->userdata('user_id') : NULL;
    }

    /**
     * Get current user Role.
     *
     * @return string|null
     */
    public function role()
    {
        return $this->is_logged_in() ? (string)$this->CI->session->userdata('role') : NULL;
    }

    /**
     * Handle unauthenticated response (AJAX 401 JSON or Web redirect to signin).
     *
     * @return void
     */
    protected function handle_unauthenticated()
    {
        if ($this->is_ajax()) {
            $this->json_response(array(
                'status'   => FALSE,
                'code'     => 'UNAUTHENTICATED',
                'message'  => 'Sesi Anda telah berakhir atau belum masuk. Silakan login kembali.',
                'redirect' => site_url('signin')
            ), 401);
        }

        // Store target intended URL for redirection after successful login
        if ($this->CI->input->method(FALSE) === 'get') {
            $target_url = current_url();
            if (!empty($_SERVER['QUERY_STRING'])) {
                $target_url .= '?' . $_SERVER['QUERY_STRING'];
            }
            $this->CI->session->set_userdata('intended_url', $target_url);
        }

        // Set flash notification
        $this->CI->session->set_flashdata('toast_type', 'warning');
        $this->CI->session->set_flashdata('toast_title', 'Akses Dibatasi');
        $this->CI->session->set_flashdata('toast_message', 'Silakan masuk ke akun Anda terlebih dahulu untuk mengakses sistem BeRewards.');

        redirect('signin');
        exit;
    }

    /**
     * Handle forbidden/unauthorized role access (AJAX 403 JSON or Web redirect).
     *
     * @return void
     */
    protected function handle_forbidden()
    {
        if ($this->is_ajax()) {
            $this->json_response(array(
                'status'   => FALSE,
                'code'     => 'FORBIDDEN',
                'message'  => 'Anda tidak memiliki hak akses (role) yang memadai untuk membuka fitur ini.',
                'redirect' => site_url('dashboard')
            ), 403);
        }

        $this->CI->session->set_flashdata('toast_type', 'danger');
        $this->CI->session->set_flashdata('toast_title', 'Akses Ditolak');
        $this->CI->session->set_flashdata('toast_message', 'Akun Anda tidak memiliki izin untuk membuka halaman tersebut.');

        redirect('dashboard');
        exit;
    }

    /**
     * Detect if request is AJAX / XHR / JSON.
     *
     * @return bool
     */
    protected function is_ajax()
    {
        return (
            $this->CI->input->is_ajax_request() ||
            (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== FALSE) ||
            (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE)
        );
    }

    /**
     * Output standardized JSON response and terminate.
     *
     * @param array $data
     * @param int   $status_code
     * @return void
     */
    protected function json_response(array $data, $status_code = 200)
    {
        if (isset($this->CI->security)) {
            $data['csrf_token_name'] = $this->CI->security->get_csrf_token_name();
            $data['csrf_hash']       = $this->CI->security->get_csrf_hash();
        }

        $this->CI->output
             ->set_status_header($status_code)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
             ->_display();
        exit;
    }
}
