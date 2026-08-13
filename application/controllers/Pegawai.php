<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Pegawai
 * Intermediary Controller for Employee Data Management module.
 * Following Clean Architecture: strictly thin controller that delegates all business logic,
 * validation, file uploading, and DB operations to Pegawai_service.
 */
class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Ensure user session is authenticated if session is set up
        if ($this->session->userdata('logged_in') !== TRUE && $this->uri->segment(1) === 'admin') {
            redirect('signin');
        }

        // Load Service Layer
        $this->load->service('Pegawai_service');
    }

    /**
     * Display Employee Management main page with dynamic data list and category statistics.
     */
    public function index()
    {
        $pegawai_list = $this->pegawai_service->get_all_pegawai();
        $stats        = $this->pegawai_service->get_pegawai_stats();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Data Pegawai',
            'page_heading' => 'Data Pegawai',
            'active_menu'  => 'pegawai',
            'content_view' => 'admin/pegawai',
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
                'pegawai_list' => $pegawai_list,
                'stats'        => $stats
            )
        ));
    }

    /**
     * JSON Endpoint to return employee list and stats for AJAX table reload.
     */
    public function data()
    {
        $response = array(
            'status' => TRUE,
            'data'   => $this->pegawai_service->get_all_pegawai(),
            'stats'  => $this->pegawai_service->get_pegawai_stats()
        );

        $this->json_response($response);
    }

    /**
     * JSON Endpoint to fetch single employee detail by ID.
     *
     * @param int|null $id
     */
    public function detail($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_pegawai');
        }

        $result = $this->pegawai_service->get_pegawai_by_id($id);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for saving (insert / update) employee data.
     */
    public function simpan()
    {
        $input_data = $this->input->post(NULL, TRUE); // XSS-clean POST data
        $files      = $_FILES;

        $result = $this->pegawai_service->simpan_pegawai($input_data, $files);
        $this->json_response($result);
    }

    /**
     * AJAX POST Endpoint for deleting / soft-deactivating employee.
     *
     * @param int|null $id
     */
    public function hapus($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_pegawai');
        }

        $result = $this->pegawai_service->hapus_pegawai($id);
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
