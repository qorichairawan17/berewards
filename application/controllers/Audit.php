<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Audit
 * Intermediary Controller for System Audit Trail and Transaction Log module.
 * Strictly thin controller delegating business logic and diff analysis to Audit_service.
 * PHP 5.6+ and CodeIgniter 3 Compatible.
 */
class Audit extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load Service Layer
        $this->load->service('Audit_service');
    }

    /**
     * Display Audit Trail main log viewer with dynamic stats and transaction history.
     */
    public function index()
    {
        $audit_list = $this->audit_service->get_audit_logs(300);
        $stats      = $this->audit_service->get_audit_stats();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Audit Trail',
            'page_heading' => 'Audit Trail Aktivitas Sistem',
            'active_menu'  => 'audit',
            'content_view' => 'admin/audit',
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
                'audit_list' => $audit_list,
                'stats'      => $stats
            )
        ));
    }

    /**
     * JSON Endpoint to fetch full details of a specific audit log including Before & After diff.
     *
     * @param int|null $id
     */
    public function detail($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_audit');
        }

        $result = $this->audit_service->get_audit_detail($id);
        $this->json_response($result);
    }

    /**
     * JSON Endpoint for AJAX table reloads or live filtering.
     */
    public function data()
    {
        $filters = array(
            'modul'      => $this->input->get_post('modul', TRUE),
            'status'     => $this->input->get_post('status', TRUE),
            'tipe_aksi'  => $this->input->get_post('tipe_aksi', TRUE),
            'search'     => $this->input->get_post('search', TRUE),
            'date_from'  => $this->input->get_post('date_from', TRUE),
            'date_to'    => $this->input->get_post('date_to', TRUE)
        );

        // Remove empty filter parameters
        $filters = array_filter($filters, function($value) {
            return ($value !== NULL && $value !== '');
        });

        $limit  = (int) $this->input->get_post('limit') ?: 300;
        $offset = (int) $this->input->get_post('offset') ?: 0;

        $response = array(
            'status' => TRUE,
            'data'   => $this->audit_service->get_audit_logs($limit, $offset, $filters),
            'stats'  => $this->audit_service->get_audit_stats()
        );

        $this->json_response($response);
    }
}
