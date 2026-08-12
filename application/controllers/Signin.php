<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller
{
    public function index()
    {
        $this->load->library('auth_service');
        $this->load->library('setting_service');

        if ($this->auth_service->is_authenticated()) {
            redirect('dashboard');
            return;
        }

        $settings = $this->setting_service->get_settings();

        $this->load->view('auth/signin', array(
            'page_title' => 'Masuk',
            'settings'   => $settings
        ));
    }
}
