<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting
 * 
 * Thin Controller for Managing Court Satker Profile, Judicial Leadership Directory,
 * SPK & Document Word Configurations, and Official Seal/Logo Uploads.
 * Strictly adheres to Clean Architecture: delegates all business logic, validation,
 * upload handling, and DB operations to Setting_service.
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Setting extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load Service Layers
        $this->load->service('Setting_service');
    }

    /**
     * Display Application & Satker Settings page.
     */
    public function index()
    {
        $settings = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Pengaturan Satuan Kerja & Aplikasi — BeRewards',
            'page_heading' => 'Pengaturan Satuan Kerja & Konfigurasi SPK',
            'active_menu'  => 'setting',
            'content_view' => 'admin/setting',
            'extra_css'    => array(),
            'extra_js'     => array(),
            'view_data'    => array(
                'settings' => $settings,
                'satker'   => isset($settings['satker']) ? $settings['satker'] : array(),
                'pimpinan' => isset($settings['pimpinan']) ? $settings['pimpinan'] : array(),
                'app'      => isset($settings['app']) ? $settings['app'] : array()
            )
        ));
    }

    /**
     * JSON Endpoint to return current settings for dynamic reload.
     */
    public function data()
    {
        $settings = $this->setting_service->get_settings(TRUE);
        $this->json_response(array(
            'status'   => TRUE,
            'settings' => $settings
        ));
    }

    /**
     * AJAX POST Endpoint to save Satker Profile & Identity.
     */
    public function simpan_satker()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS Clean
        $result     = $this->setting_service->simpan_satker($input_data);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint to save Leadership Personnel Directory.
     */
    public function simpan_pimpinan()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS Clean
        $result     = $this->setting_service->simpan_pimpinan($input_data);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint to save SPK & Word Document Header Configuration.
     */
    public function simpan_app()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS Clean
        $result     = $this->setting_service->simpan_app_config($input_data);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint to upload Court Official Logo.
     */
    public function upload_logo()
    {
        $result = $this->setting_service->upload_logo('logo');
        $this->json_response($result);
    }
}

