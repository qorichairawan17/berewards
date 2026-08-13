<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Timpenilai
 * Intermediary Controller for Tim Penilai (SK Penetapan & Anggota) module.
 * Following Clean Architecture: strictly thin controller that delegates all business logic,
 * validation, PDF uploading, and DB operations to Tim_penilai_service.
 */
class Timpenilai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Ensure user session is authenticated if session is set up
        if ($this->session->userdata('logged_in') !== TRUE && $this->uri->segment(1) === 'admin') {
            redirect('signin');
        }

        // Load Service Layers
        $this->load->service('Tim_penilai_service');
        $this->load->service('Pegawai_service');
        $this->load->service('Setting_service');
    }

    /**
     * Display SK Tim Penilai listing main page with dynamic statistics.
     */
    public function index()
    {
        $sk_list      = $this->tim_penilai_service->get_all_sk();
        $stats        = $this->tim_penilai_service->get_stats();
        $pegawai_list = $this->pegawai_service->get_all_pegawai(TRUE);
        $settings     = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Tim Penilai — BeRewards',
            'page_heading' => 'Manajemen Tim Penilai SPK TOPSIS',
            'active_menu'  => 'timpenilai',
            'content_view' => 'admin/tim_penilai',
            'extra_css'    => array(
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/libs/flatpickr/flatpickr.min.css'
            ),
            'extra_js'     => array(
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js',
                'assets/libs/flatpickr/flatpickr.min.js'
            ),
            'view_data'    => array(
                'sk_list'      => $sk_list,
                'stats'        => $stats,
                'pegawai_list' => $pegawai_list,
                'settings'     => $settings
            )
        ));
    }

    /**
     * Display SK detail & personel team composition view.
     *
     * @param int $id
     */
    public function detail($id = 1)
    {
        $sk_detail_result = $this->tim_penilai_service->get_sk_detail($id);
        $sk_list          = $this->tim_penilai_service->get_all_sk();
        $settings         = $this->setting_service->get_settings();

        $selected_sk = ($sk_detail_result['status']) ? $sk_detail_result['data'] : (!empty($sk_list) ? $sk_list[0] : NULL);

        $this->load->view('templates/layout', array(
            'page_title'   => 'Detail Tim Penilai — BeRewards',
            'page_heading' => 'Rincian SK & Personel Tim Penilai',
            'active_menu'  => 'timpenilai',
            'content_view' => 'admin/tim_penilai_detail',
            'extra_css'    => array(),
            'extra_js'     => array(),
            'view_data'    => array(
                'sk_info'  => $selected_sk,
                'sk_list'  => $sk_list,
                'settings' => $settings
            )
        ));
    }

    /**
     * JSON Endpoint to return SK list and stats for AJAX table reload.
     */
    public function data()
    {
        $response = array(
            'status'   => TRUE,
            'data'     => $this->tim_penilai_service->get_all_sk(),
            'stats'    => $this->tim_penilai_service->get_stats(),
            'settings' => $this->setting_service->get_settings()
        );

        $this->json_response($response);
    }

    /**
     * AJAX POST Endpoint for saving (insert / update) SK Tim Penilai data.
     */
    public function simpan()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS-clean POST data
        $files      = $_FILES;

        $result = $this->tim_penilai_service->simpan_sk($input_data, $files);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for deleting SK Tim Penilai.
     *
     * @param int|null $id
     */
    public function hapus($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_sk');
        }

        $result = $this->tim_penilai_service->hapus_sk($id);
        $this->json_response($result);
    }

    /**
     * Private helper to output JSON response with updated CSRF token.
     *
     * @param array $data
     */
    private function json_response($data)
    {
        if (is_array($data)) {
            $data['csrf_token_name'] = $this->security->get_csrf_token_name();
            $data['csrf_hash']       = $this->security->get_csrf_hash();
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
