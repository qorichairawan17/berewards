<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Proses
 * 
 * Controller Penilaian Kinerja & Sistem Pendukung Keputusan (SPK) TOPSIS.
 * Mengikuti Clean Architecture: Controller tipis (Thin Controller) yang semata-mata
 * menjembatani antarmuka View, Model, dan Business Service Layer (Topsis_service).
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Proses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        // Load Service Layers
        $this->load->service('Topsis_service');
        $this->load->service('Setting_service');
    }

    /**
     * Halaman Utama: Daftar Sesi Penilaian TOPSIS
     */
    public function index()
    {
        // Require Login
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('signin');
        }

        $periode_penilaian_list = $this->topsis_service->get_sesi_list();
        $periode_options        = $this->topsis_service->get_periode_options();
        $settings               = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Penilaian & TOPSIS — BeRewards',
            'page_heading' => 'Penilaian & Perhitungan TOPSIS',
            'active_menu'  => 'proses',
            'content_view' => 'admin/proses',
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
                'periode_penilaian_list' => $periode_penilaian_list,
                'periode_options'        => $periode_options,
                'settings'               => $settings
            )
        ));
    }

    /**
     * Halaman Detail: Rincian Penilaian Pegawai & Hasil TOPSIS Per Sesi / Periode
     * 
     * @param int $id_periode_or_proses
     */
    public function detail($id_periode_or_proses = 1)
    {
        // Require Login
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('signin');
        }

        $detail_data = $this->topsis_service->get_detail_sesi($id_periode_or_proses);
        if (!$detail_data['status']) {
            $this->session->set_flashdata('error', $detail_data['message']);
            redirect('proses');
        }

        $settings = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Detail Hasil TOPSIS — ' . $detail_data['periode_info']['nama_periode'],
            'page_heading' => 'Hasil Perhitungan TOPSIS ' . $detail_data['periode_info']['nama_periode'],
            'active_menu'  => 'proses',
            'content_view' => 'admin/proses_detail',
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
            'view_data'    => array_merge($detail_data, array('settings' => $settings))
        ));
    }

    /**
     * Endpoint AJAX POST: Membuat Sesi Penilaian Baru (Status Draft)
     */
    public function simpan_sesi()
    {
        $input_data = $this->input->post(NULL, TRUE);
        $result     = $this->topsis_service->buat_sesi($input_data);
        $this->json_response($result);
    }

    /**
     * Endpoint AJAX POST: Menyimpan Nilai Kriteria Alternatif Pegawai
     */
    public function simpan_nilai()
    {
        $input_data = $this->input->post(NULL, TRUE);
        $result     = $this->topsis_service->simpan_nilai_alternatif($input_data);
        $this->json_response($result);
    }

    /**
     * Endpoint AJAX POST: Menjalankan Kalkulasi Lengkap Metode TOPSIS & Finalisasi Status
     */
    public function hitung()
    {
        $id_proses = $this->input->post('id_proses');
        if (empty($id_proses)) {
            $id_proses = $this->input->get('id_proses');
        }

        $result = $this->topsis_service->proses_hitung_topsis((int)$id_proses);
        $this->json_response($result);
    }

    /**
     * Endpoint AJAX POST: Menghapus Sesi Penilaian
     * 
     * @param int|null $id
     */
    public function hapus($id = NULL)
    {
        if (empty($id)) {
            $id = $this->input->post('id_proses');
        }

        $result = $this->topsis_service->hapus_sesi((int)$id);
        $this->json_response($result);
    }

    /**
     * Endpoint AJAX JSON: Mengambil Data Detail untuk Pembaruan Real-time
     * 
     * @param int $id_proses
     */
    public function data_detail($id_proses)
    {
        $detail_data = $this->topsis_service->get_detail_sesi($id_proses);
        $this->json_response($detail_data);
    }

    /**
     * Private Helper: Mengirim response JSON dengan sinkronisasi CSRF Token.
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
