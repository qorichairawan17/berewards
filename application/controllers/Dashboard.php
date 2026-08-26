<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 * Controller for Main Dashboard of BeRewards SPK TOPSIS Application.
 * Extends Auth_Controller for automatic login guard and inherits MY_Controller capabilities.
 * 
 * @author BeRewards Core Engine
 * @version 1.2.0
 */
class Dashboard extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('Dashboard_service');
    }

    /**
     * Display Main Dashboard with aggregated KPI, Top Winners, and Recent Feed.
     *
     * @return void
     */
    public function index()
    {
        $dashboard_data = $this->dashboard_service->get_dashboard_data();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Dashboard SPK Reward',
            'page_heading' => 'Dashboard SPK Reward TOPSIS',
            'active_menu'  => 'dashboard',
            'content_view' => 'admin/dashboard',
            'view_data'    => $dashboard_data
        ));
    }

    /**
     * AJAX endpoint to fetch real-time KPI & activity stats.
     *
     * @return void
     */
    public function stats()
    {
        $stats = $this->dashboard_service->get_dashboard_data();
        $this->json_response($stats);
    }
}
