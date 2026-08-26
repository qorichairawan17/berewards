<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Controller
 * Base Controller for BeRewards SPK TOPSIS Application.
 * Centralizes common helpers, JSON rendering with CSRF token injection, and Middleware bindings.
 */
class MY_Controller extends CI_Controller
{
    /**
     * Active authenticated user dataset or NULL
     * @var array|null
     */
    public $current_user = NULL;

    public function __construct()
    {
        parent::__construct();

        // Ensure database and session are initialized
        $this->load->database();
        $this->load->library('session');

        // Load Auth_middleware from application/middleware/
        if (method_exists($this->load, 'middleware')) {
            $this->load->middleware('Auth_middleware');
        } else {
            $this->load->library('Auth_middleware');
        }

        // Cache current authenticated user info
        if (isset($this->auth_middleware) && $this->auth_middleware->is_logged_in()) {
            $this->current_user = $this->auth_middleware->user();
        }
    }

    /**
     * Run middleware guard manually inside controller methods.
     *
     * @param string|array|null $allowed_roles
     * @return bool
     */
    protected function middleware($allowed_roles = NULL)
    {
        return $this->auth_middleware->guard($allowed_roles);
    }

    /**
     * Require specific roles for a specific controller or action.
     *
     * @param string|array $roles
     * @return bool
     */
    protected function require_roles($roles)
    {
        return $this->auth_middleware->require_roles($roles);
    }

    /**
     * Helper to return standard JSON response with fresh CSRF token.
     *
     * @param array|mixed $data
     * @param int   $http_status
     * @return void
     */
    protected function json_response($data, $http_status = 200)
    {
        if (isset($this->security) && is_array($data)) {
            $data['csrf_token_name'] = $this->security->get_csrf_token_name();
            $data['csrf_hash']       = $this->security->get_csrf_hash();
        }

        $this->output
             ->set_status_header($http_status)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
             ->_display();
        exit;
    }
}

/**
 * Class Auth_Controller
 * Guarded Controller: Automatically ensures the user is logged in before any action is executed.
 * Can be subclassed by all protected modules (Dashboard, Pegawai, Kriteria, Periode, Tim Penilai, Proses, Laporan, Setting, User, Profile, Audit).
 */
class Auth_Controller extends MY_Controller
{
    /**
     * Optional role restrictions for the entire controller (e.g. ['superadmin', 'administrator'])
     * @var array|string|null
     */
    protected $allowed_roles = NULL;

    public function __construct()
    {
        parent::__construct();

        // Automatically enforce authentication middleware guard
        $this->auth_middleware->guard($this->allowed_roles);
    }
}

/**
 * Class Guest_Controller
 * Guest-only Controller: Ensures that already logged-in users cannot access guest pages (e.g. Signin page).
 * Automatically redirects authenticated users to the Dashboard.
 */
class Guest_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Enforce guest-only middleware filter
        $this->auth_middleware->guest_only('dashboard');
    }
}
