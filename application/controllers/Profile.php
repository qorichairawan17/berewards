<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Profile
 * Mengelola tampilan dan aksi pembaruan "Profil Saya" pengguna sistem BeRewards.
 * Mengimplementasikan Service Layer Profile_service untuk arsitektur Clean Code.
 */
class Profile extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (method_exists($this->load, 'service')) {
            $this->load->service('Profile_service');
        } else {
            $this->load->library('Profile_service');
        }
    }

    /**
     * Halaman Utama Profil Pengguna
     */
    public function index()
    {
        $id_user = $this->profile_service->get_current_user_id();
        $profile_data = $this->profile_service->get_profile_data($id_user);

        $this->load->view('templates/layout', array(
            'page_title' => 'Profil Saya — BeRewards',
            'page_heading' => 'Profil Saya',
            'active_menu' => 'profile',
            'content_view' => 'admin/profile',
            'extra_css' => array(),
            'extra_js' => array(),
            'view_data' => array(
                'user' => $profile_data['user'],
                'stats' => $profile_data['stats'],
                'activity_logs' => $profile_data['activity_logs']
            )
        ));
    }

    /**
     * Endpoint AJAX GET: Mengambil data profil pengguna dalam format JSON
     */
    public function data()
    {
        $id_user = $this->profile_service->get_current_user_id();
        $result = $this->profile_service->get_profile_data($id_user);
        $this->json_response($result);
    }

    /**
     * Endpoint AJAX POST: Memperbarui Data Informasi Profil & Kontak
     */
    public function update()
    {
        $id_user = $this->profile_service->get_current_user_id();
        $input_data = $this->input->post(NULL, TRUE);

        $result = $this->profile_service->update_profile($id_user, $input_data);
        $this->json_response($result);
    }

    /**
     * Endpoint AJAX POST: Memperbarui Kata Sandi / Password Akun
     */
    public function update_password()
    {
        $id_user = $this->profile_service->get_current_user_id();
        $input_data = $this->input->post(NULL, TRUE);

        $result = $this->profile_service->update_password($id_user, $input_data);
        $this->json_response($result);
    }
}
