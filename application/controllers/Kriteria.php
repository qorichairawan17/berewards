<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Kriteria
 * Intermediary Controller for Kriteria Penilaian TOPSIS module.
 * Following Clean Architecture: strictly thin controller that delegates all business logic,
 * validation, and DB operations to Kriteria_service.
 */
class Kriteria extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Ensure user session is authenticated if session is set up
        if ($this->session->userdata('logged_in') !== TRUE && $this->uri->segment(1) === 'admin') {
            redirect('signin');
        }

        // Load Service Layers
        $this->load->service('Kriteria_service');
        $this->load->service('Setting_service');
    }

    /**
     * Display Master Kriteria Penilaian main listing page with KPI statistics.
     */
    public function index()
    {
        $kriteria_list = $this->kriteria_service->get_all_kriteria();
        $stats         = $this->kriteria_service->get_stats();
        $settings      = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Kriteria Penilaian — BeRewards',
            'page_heading' => 'Master Kriteria Penilaian TOPSIS',
            'active_menu'  => 'kriteria',
            'content_view' => 'admin/kriteria',
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
                'kriteria_list' => $kriteria_list,
                'stats'         => $stats,
                'settings'      => $settings
            )
        ));
    }

    /**
     * JSON Endpoint to return kriteria list and stats for AJAX reload.
     */
    public function data()
    {
        $response = array(
            'status'   => TRUE,
            'data'     => $this->kriteria_service->get_all_kriteria(),
            'stats'    => $this->kriteria_service->get_stats(),
            'settings' => $this->setting_service->get_settings()
        );

        $this->json_response($response);
    }

    /**
     * JSON Endpoint to return single kriteria detail by ID.
     *
     * @param int|null $id
     */
    public function detail($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_kriteria');
        }

        $result = $this->kriteria_service->get_kriteria_detail($id);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for saving (insert / update) kriteria data.
     */
    public function simpan()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS-clean POST data
        $result     = $this->kriteria_service->simpan_kriteria($input_data);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for deleting/deactivating kriteria.
     *
     * @param int|null $id
     */
    public function hapus($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_kriteria');
        }

        $result = $this->kriteria_service->hapus_kriteria($id);
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
