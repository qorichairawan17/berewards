<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load database safely
        @$this->load->database();
    }

    public function index()
    {
        $migration_files = array(
            array(
                'version'      => 1,
                'file_name'    => '001_create_employee_data_table.php',
                'class_name'   => 'Migration_Create_employee_data_table',
                'target_table' => 'employee_data',
                'description'  => 'Membuat tabel master employee_data beserta kunci indeks dan data sampel awal pegawai PN Lubuk Pakam.'
            ),
            array(
                'version'      => 2,
                'file_name'    => '002_create_settings_table.php',
                'class_name'   => 'Migration_Create_settings_table',
                'target_table' => 'settings',
                'description'  => 'Membuat tabel konfigurasi aplikasi settings untuk profil satker, susunan pimpinan pengadilan, dan format kop surat.'
            )
        );

        $db_connected = FALSE;
        $current_version = 0;
        $employee_table_exists = FALSE;
        $employee_count = 0;
        $settings_table_exists = FALSE;
        $db_driver = 'MySQLi';
        $db_name = 'berewards';

        if (isset($this->db) && isset($this->db->conn_id) && $this->db->conn_id !== FALSE) {
            $db_connected = TRUE;
            $db_driver    = $this->db->dbdriver;
            $db_name      = $this->db->database;

            if ($this->db->table_exists('migrations')) {
                $row = $this->db->get('migrations')->row();
                if ($row && isset($row->version)) {
                    $current_version = (int) $row->version;
                }
            }

            if ($this->db->table_exists('employee_data')) {
                $employee_table_exists = TRUE;
                $employee_count = $this->db->count_all('employee_data');
            }

            if ($this->db->table_exists('settings')) {
                $settings_table_exists = TRUE;
            }
        }

        $this->load->view('admin/migration_standalone', array(
            'migration_files'       => $migration_files,
            'current_version'       => $current_version,
            'employee_table_exists' => $employee_table_exists,
            'employee_count'        => $employee_count,
            'settings_table_exists' => $settings_table_exists,
            'db_connected'          => $db_connected,
            'db_driver'             => $db_driver,
            'db_name'               => $db_name
        ));
    }

    public function execute($version = 1)
    {
        $version = (int) $version;
        $this->load->library('migration');
        $result = $this->migration->version($version);

        if ($result === FALSE) {
            $error = $this->migration->error_string();
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => $error));
                return;
            }
            $this->session->set_flashdata('error', 'Gagal menjalankan migrasi: ' . $error);
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array(
                    'status'  => 'success',
                    'message' => 'Migrasi skema tabel employee_data berhasil dijalankan ke versi ' . $version . '.'
                ));
                return;
            }
            $this->session->set_flashdata('success', 'Migrasi skema tabel employee_data berhasil dijalankan.');
        }

        redirect('migration');
    }

    public function rollback()
    {
        $this->load->library('migration');
        $result = $this->migration->version(0);

        if ($result === FALSE) {
            $error = $this->migration->error_string();
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => $error));
                return;
            }
            $this->session->set_flashdata('error', 'Gagal melakukan rollback: ' . $error);
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array(
                    'status'  => 'success',
                    'message' => 'Rollback skema tabel employee_data berhasil dilaksanakan.'
                ));
                return;
            }
            $this->session->set_flashdata('success', 'Rollback skema tabel employee_data berhasil dilaksanakan.');
        }

        redirect('migration');
    }

    public function status()
    {
        $current_version = 0;
        $employee_table_exists = FALSE;
        $employee_count = 0;
        $settings_table_exists = FALSE;
        $db_name = 'berewards';

        if (isset($this->db) && isset($this->db->conn_id) && $this->db->conn_id !== FALSE) {
            $db_name = $this->db->database;
            if ($this->db->table_exists('migrations')) {
                $row = $this->db->get('migrations')->row();
                if ($row && isset($row->version)) {
                    $current_version = (int) $row->version;
                }
            }

            if ($this->db->table_exists('employee_data')) {
                $employee_table_exists = TRUE;
                $employee_count = $this->db->count_all('employee_data');
            }

            if ($this->db->table_exists('settings')) {
                $settings_table_exists = TRUE;
            }
        }

        echo json_encode(array(
            'status'                => 'success',
            'current_version'       => $current_version,
            'employee_table_exists' => $employee_table_exists,
            'employee_count'        => $employee_count,
            'settings_table_exists' => $settings_table_exists,
            'db_name'               => $db_name
        ));
    }
}
