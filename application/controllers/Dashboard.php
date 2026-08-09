<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function index()
    {
        $this->load->view('templates/layout', array(
            'page_title' => 'Dashboard',
            'page_heading' => 'Dashboard',
            'active_menu' => 'dashboard',
            'content_view' => 'admin/dashboard',
            'view_data' => array(),
        ));
    }
}
