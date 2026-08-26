<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends Guest_Controller
{
    public function index()
    {
        $this->load->library('setting_service');

        $settings = $this->setting_service->get_settings();

        $this->load->view('auth/signin', array(
            'page_title' => 'Masuk',
            'settings'   => $settings
        ));
    }
}
