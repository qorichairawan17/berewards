<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Periode
 * Intermediary Controller for Periode Penilaian (Evaluation Cycles) module.
 * Following Clean Architecture: strictly thin controller that delegates all business logic,
 * validation, and DB operations to Periode_service.
 */
class Periode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Ensure user session is authenticated if session is set up
        if ($this->session->userdata('logged_in') !== TRUE && $this->uri->segment(1) === 'admin') {
            redirect('signin');
        }

        // Load Service Layers
        $this->load->service('Periode_service');
        $this->load->service('Setting_service');
    }

    /**
     * Display Master Periode Penilaian main listing page with KPI statistics.
     */
    public function index()
    {
        $periode_list = $this->periode_service->get_all_periode();
        $stats        = $this->periode_service->get_stats();
        $settings     = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Periode Penilaian — BeRewards',
            'page_heading' => 'Manajemen Periode Penilaian TOPSIS',
            'active_menu'  => 'periode',
            'content_view' => 'admin/periode',
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
                'periode_list' => $periode_list,
                'stats'        => $stats,
                'settings'     => $settings
            )
        ));
    }

    /**
     * JSON Endpoint to return period list and stats for AJAX reload.
     */
    public function data()
    {
        $response = array(
            'status'   => TRUE,
            'data'     => $this->periode_service->get_all_periode(),
            'stats'    => $this->periode_service->get_stats(),
            'settings' => $this->setting_service->get_settings()
        );

        $this->json_response($response);
    }

    /**
     * JSON Endpoint to return single period detail by ID.
     *
     * @param int|null $id
     */
    public function detail($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_periode');
        }

        $result = $this->periode_service->get_periode_detail($id);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for saving (insert / update) period data.
     */
    public function simpan()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS-clean POST data
        $result     = $this->periode_service->simpan_periode($input_data);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for deleting/deactivating period.
     *
     * @param int|null $id
     */
    public function hapus($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_periode');
        }

        $result = $this->periode_service->hapus_periode($id);
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
