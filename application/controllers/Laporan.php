<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Laporan
 * 
 * Thin Controller untuk mengelola dokumen Berita Acara Penetapan Reward TOPSIS.
 * Mendelegasikan seluruh business logic dan ekspor dokumen ke Laporan_service
 * dan Export_word_service sesuai arsitektur Clean Code.
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('Laporan_service');
        $this->load->service('Setting_service');
        $this->load->service('Tim_penilai_service');
        $this->load->service('Periode_service');
    }

    /**
     * Halaman Utama Modul Laporan & Berita Acara.
     */
    public function index()
    {
        $laporan_list = $this->laporan_service->get_laporan_list();
        $stats        = $this->laporan_service->get_stats();
        $form_options = $this->laporan_service->get_form_options();
        $settings     = $this->setting_service->get_settings();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Laporan & Berita Acara',
            'page_heading' => 'Laporan Berita Acara Hasil TOPSIS',
            'active_menu'  => 'laporan',
            'content_view' => 'admin/laporan',
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
                'laporan_list' => $laporan_list,
                'stats'        => $stats,
                'form_options' => $form_options,
                'satker'       => $settings['satker'],
                'pimpinan'     => $settings['pimpinan'],
                'app'          => $settings['app']
            )
        ));
    }

    /**
     * Endpoint JSON data Berita Acara untuk AJAX DataTables / Sinkronisasi.
     */
    public function data()
    {
        $list  = $this->laporan_service->get_laporan_list();
        $stats = $this->laporan_service->get_stats();

        $this->json_response(array(
            'status' => TRUE,
            'data'   => $list,
            'stats'  => $stats
        ));
    }

    /**
     * Endpoint JSON options untuk formulir modal tambah Berita Acara.
     */
    public function options()
    {
        $options = $this->laporan_service->get_form_options();
        $this->json_response(array(
            'status' => TRUE,
            'data'   => $options
        ));
    }

    /**
     * Endpoint AJAX untuk membuat / menerbitkan Berita Acara baru.
     */
    public function simpan()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            $this->json_response(array('status' => FALSE, 'message' => 'Metode request tidak diizinkan.'), 405);
            return;
        }

        $input = $this->input->post(NULL, TRUE);
        $result = $this->laporan_service->create_laporan($input);

        $http_code = $result['status'] ? 200 : 400;
        $this->json_response($result, $http_code);
    }

    /**
     * Endpoint AJAX untuk memperbarui Berita Acara yang sudah ada.
     */
    public function update()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            $this->json_response(array('status' => FALSE, 'message' => 'Metode request tidak diizinkan.'), 405);
            return;
        }

        $id_laporan = (int)$this->input->post('id_laporan', TRUE);
        $input      = $this->input->post(NULL, TRUE);
        $result     = $this->laporan_service->update_laporan($id_laporan, $input);

        $http_code = $result['status'] ? 200 : 400;
        $this->json_response($result, $http_code);
    }

    /**
     * Endpoint AJAX untuk menghapus / mengarsipkan Berita Acara.
     */
    public function delete()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            $this->json_response(array('status' => FALSE, 'message' => 'Metode request tidak diizinkan.'), 405);
            return;
        }

        $id_laporan = (int)$this->input->post('id_laporan', TRUE);
        $result     = $this->laporan_service->delete_laporan($id_laporan);

        $http_code = $result['status'] ? 200 : 400;
        $this->json_response($result, $http_code);
    }

    /**
     * Ekspor Berita Acara ke file Word (.docx) berdasarkan ID Laporan.
     * 
     * @param int $id_laporan
     */
    public function export($id_laporan = 0)
    {
        $id = (int)$id_laporan;
        if ($id <= 0) {
            show_error('ID Berita Acara tidak valid.', 400, 'Export Error');
        }

        $this->laporan_service->export_berita_acara($id);
    }

    /**
     * Ekspor Berita Acara langsung dari Sesi Perhitungan TOPSIS (id_proses).
     * 
     * @param int $id_proses
     */
    public function export_proses($id_proses = 0)
    {
        $id = (int)$id_proses;
        if ($id <= 0) {
            show_error('ID Sesi TOPSIS tidak valid.', 400, 'Export Error');
        }

        $this->laporan_service->export_berita_acara_proses($id);
    }

    /**
     * Halaman Showroom Pratinjau Kandidat Reward.
     * 
     * @param int $id_laporan
     */
    public function preview($id_laporan = 0)
    {
        $laporan_list = $this->laporan_service->get_laporan_list();
        $selected     = NULL;

        $id = (int)$id_laporan;
        if ($id > 0) {
            $selected = $this->laporan_service->get_laporan_detail($id);
        }

        if (!$selected && !empty($laporan_list)) {
            $selected = $this->laporan_service->get_laporan_detail($laporan_list[0]['id_laporan']);
        }

        $this->load->view('templates/layout', array(
            'page_title'   => 'Showroom Pratinjau Kandidat Reward',
            'page_heading' => 'Showroom Pratinjau Kandidat Reward',
            'active_menu'  => 'laporan',
            'content_view' => 'admin/laporan_preview',
            'extra_css'    => array(),
            'extra_js'     => array(),
            'view_data'    => array(
                'laporan_list' => $laporan_list,
                'laporan_info' => $selected
            )
        ));
    }

    /**
     * Private helper pengiriman respon JSON dengan CSRF token injection.
     * 
     * @param array $data
     * @param int   $http_status
     */
    private function json_response(array $data, $http_status = 200)
    {
        $data['csrf_token_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash']       = $this->security->get_csrf_hash();

        $this->output
             ->set_status_header($http_status)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
