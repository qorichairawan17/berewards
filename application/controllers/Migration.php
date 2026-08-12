<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Standalone Migration Manager
 * Mengelola eksekusi dan rollback skema database SPK Reward TOPSIS.
 */
class Migration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function index()
    {
        $migration_files = array(
            array(
                'version'      => 1,
                'file_name'    => '001_create_referensi_pegawai_table.php',
                'class_name'   => 'Migration_Create_referensi_pegawai_table',
                'target_table' => 'referensi_pegawai',
                'description'  => 'Membuat tabel master referensi_pegawai beserta kunci indeks dan data sampel awal pegawai PN Lubuk Pakam.'
            ),
            array(
                'version'      => 2,
                'file_name'    => '002_create_pengaturan_table.php',
                'class_name'   => 'Migration_Create_pengaturan_table',
                'target_table' => 'pengaturan',
                'description'  => 'Membuat tabel konfigurasi aplikasi pengaturan untuk profil satker, susunan pimpinan pengadilan, dan format kop surat.'
            ),
            array(
                'version'      => 3,
                'file_name'    => '003_create_pengguna_table.php',
                'class_name'   => 'Migration_Create_pengguna_table',
                'target_table' => 'pengguna',
                'description'  => 'Membuat tabel pengguna untuk hak akses login sistem (Superadmin, Administrator, Tim Penilai, Pimpinan).'
            ),
            array(
                'version'      => 4,
                'file_name'    => '004_create_tim_penilai_tables.php',
                'class_name'   => 'Migration_Create_tim_penilai_tables',
                'target_table' => 'tim_penilai_sk',
                'description'  => 'Membuat tabel header tim_penilai_sk dan detail tim_penilai_anggota dengan Foreign Key ke referensi_pegawai.'
            ),
            array(
                'version'      => 5,
                'file_name'    => '005_create_kriteria_tables.php',
                'class_name'   => 'Migration_Create_kriteria_tables',
                'target_table' => 'kriteria',
                'description'  => 'Membuat tabel kriteria dan skala_kriteria dengan Foreign Key untuk parameter kriteria penilaian TOPSIS.'
            ),
            array(
                'version'      => 6,
                'file_name'    => '006_create_periode_table.php',
                'class_name'   => 'Migration_Create_periode_table',
                'target_table' => 'periode',
                'description'  => 'Membuat tabel periode penilaian reward dengan Foreign Key ke pengguna (siklus bulanan, triwulan, semester, dan tahunan).'
            ),
            array(
                'version'      => 7,
                'file_name'    => '007_create_assessment_tables.php',
                'class_name'   => 'Migration_Create_assessment_tables',
                'target_table' => 'topsis_proses',
                'description'  => 'Membuat tabel topsis_proses, topsis_proses_kriteria, topsis_proses_alternatif, penilaian, dan hasil_topsis dengan relasi Foreign Key lengkap.'
            ),
            array(
                'version'      => 8,
                'file_name'    => '008_create_laporan_ba_table.php',
                'class_name'   => 'Migration_Create_laporan_ba_table',
                'target_table' => 'laporan_ba',
                'description'  => 'Membuat tabel laporan_ba untuk pengesahan Berita Acara penetapan penerima reward TOPSIS dengan Foreign Keys ke topsis_proses, periode, tim_penilai_sk, referensi_pegawai, dan pengguna.'
            ),
            array(
                'version'      => 9,
                'file_name'    => '009_create_audit_trail_table.php',
                'class_name'   => 'Migration_Create_audit_trail_table',
                'target_table' => 'audit_trail',
                'description'  => 'Membuat tabel audit_trail untuk pencatatan log aktivitas pengguna dan rekam jejak audit sistem dengan Foreign Key ke pengguna.'
            )
        );

        $db_connected = FALSE;
        $current_version = 0;
        $referensi_pegawai_table_exists = FALSE;
        $referensi_pegawai_count = 0;
        $pengaturan_table_exists = FALSE;
        $pengguna_table_exists = FALSE;
        $pengguna_count = 0;
        $tim_penilai_table_exists = FALSE;
        $tim_penilai_count = 0;
        $kriteria_table_exists = FALSE;
        $kriteria_count = 0;
        $periode_table_exists = FALSE;
        $periode_count = 0;
        $topsis_proses_table_exists = FALSE;
        $topsis_proses_count = 0;
        $laporan_ba_table_exists = FALSE;
        $laporan_ba_count = 0;
        $audit_trail_table_exists = FALSE;
        $audit_trail_count = 0;
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

            if ($this->db->table_exists('referensi_pegawai')) {
                $referensi_pegawai_table_exists = TRUE;
                $referensi_pegawai_count = $this->db->count_all('referensi_pegawai');
            }

            if ($this->db->table_exists('pengaturan')) {
                $pengaturan_table_exists = TRUE;
            }

            if ($this->db->table_exists('pengguna')) {
                $pengguna_table_exists = TRUE;
                $pengguna_count = $this->db->count_all('pengguna');
            }

            if ($this->db->table_exists('tim_penilai_sk')) {
                $tim_penilai_table_exists = TRUE;
                $tim_penilai_count = $this->db->count_all('tim_penilai_sk');
            }

            if ($this->db->table_exists('kriteria')) {
                $kriteria_table_exists = TRUE;
                $kriteria_count = $this->db->count_all('kriteria');
            }

            if ($this->db->table_exists('periode')) {
                $periode_table_exists = TRUE;
                $periode_count = $this->db->count_all('periode');
            }

            if ($this->db->table_exists('topsis_proses')) {
                $topsis_proses_table_exists = TRUE;
                $topsis_proses_count = $this->db->count_all('topsis_proses');
            }

            if ($this->db->table_exists('laporan_ba')) {
                $laporan_ba_table_exists = TRUE;
                $laporan_ba_count = $this->db->count_all('laporan_ba');
            }

            if ($this->db->table_exists('audit_trail')) {
                $audit_trail_table_exists = TRUE;
                $audit_trail_count = $this->db->count_all('audit_trail');
            }
        }

        $this->load->view('admin/migration_standalone', array(
            'migration_files'                => $migration_files,
            'current_version'                => $current_version,
            'latest_version'                 => count($migration_files),
            'referensi_pegawai_table_exists' => $referensi_pegawai_table_exists,
            'referensi_pegawai_count'        => $referensi_pegawai_count,
            'pengaturan_table_exists'        => $pengaturan_table_exists,
            'pengguna_table_exists'          => $pengguna_table_exists,
            'pengguna_count'                 => $pengguna_count,
            'tim_penilai_table_exists'       => $tim_penilai_table_exists,
            'tim_penilai_count'              => $tim_penilai_count,
            'kriteria_table_exists'          => $kriteria_table_exists,
            'kriteria_count'                 => $kriteria_count,
            'periode_table_exists'           => $periode_table_exists,
            'periode_count'                  => $periode_count,
            'topsis_proses_table_exists'     => $topsis_proses_table_exists,
            'topsis_proses_count'            => $topsis_proses_count,
            'laporan_ba_table_exists'        => $laporan_ba_table_exists,
            'laporan_ba_count'               => $laporan_ba_count,
            'audit_trail_table_exists'       => $audit_trail_table_exists,
            'audit_trail_count'              => $audit_trail_count,
            'db_connected'                   => $db_connected,
            'db_driver'                      => $db_driver,
            'db_name'                        => $db_name
        ));
    }

    public function execute($target_version = NULL)
    {
        $this->load->library('migration');

        if ($target_version !== NULL) {
            $version = (int) $target_version;
            $result = $this->migration->version($version);
        } else {
            $result = $this->migration->current();
            $version = $this->config->item('migration_version');
        }

        if ($result === FALSE) {
            $error = $this->migration->error_string();
            if ($this->input->is_cli_request()) {
                echo "MIGRATION ERROR: " . $error . "\n";
                return;
            }
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => $error));
                return;
            }
            $this->session->set_flashdata('error', $error);
        } else {
            if ($this->input->is_cli_request()) {
                echo "MIGRATION SUCCESS: Version " . $version . " (Result: " . var_export($result, true) . ")\n";
                return;
            }
            if ($this->input->is_ajax_request()) {
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Migrasi skema tabel berhasil dijalankan ke versi ' . $version . '.',
                    'current_version' => $version
                ));
                return;
            }
            $this->session->set_flashdata('success', 'Migrasi skema tabel berhasil dijalankan.');
        }

        redirect('migration');
    }

    public function rollback($target_version = 0)
    {
        $this->load->library('migration');
        $version = (int) $target_version;

        $result = $this->migration->version($version);

        if ($result === FALSE) {
            $error = $this->migration->error_string();
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => $error));
                return;
            }
            $this->session->set_flashdata('error', $error);
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Rollback skema tabel berhasil dilaksanakan ke versi ' . $version . '.',
                    'current_version' => $version
                ));
                return;
            }
            $this->session->set_flashdata('success', 'Rollback skema tabel berhasil dilaksanakan.');
        }

        redirect('migration');
    }

    public function status()
    {
        $current_version = 0;
        $referensi_pegawai_table_exists = FALSE;
        $referensi_pegawai_count = 0;
        $pengaturan_table_exists = FALSE;
        $pengguna_table_exists = FALSE;
        $pengguna_count = 0;
        $tim_penilai_table_exists = FALSE;
        $tim_penilai_count = 0;
        $kriteria_table_exists = FALSE;
        $kriteria_count = 0;
        $periode_table_exists = FALSE;
        $periode_count = 0;
        $topsis_proses_table_exists = FALSE;
        $topsis_proses_count = 0;
        $laporan_ba_table_exists = FALSE;
        $laporan_ba_count = 0;
        $audit_trail_table_exists = FALSE;
        $audit_trail_count = 0;
        $db_name = 'berewards';

        if (isset($this->db) && isset($this->db->conn_id) && $this->db->conn_id !== FALSE) {
            $db_name = $this->db->database;
            if ($this->db->table_exists('migrations')) {
                $row = $this->db->get('migrations')->row();
                if ($row && isset($row->version)) {
                    $current_version = (int) $row->version;
                }
            }

            if ($this->db->table_exists('referensi_pegawai')) {
                $referensi_pegawai_table_exists = TRUE;
                $referensi_pegawai_count = $this->db->count_all('referensi_pegawai');
            }

            if ($this->db->table_exists('pengaturan')) {
                $pengaturan_table_exists = TRUE;
            }

            if ($this->db->table_exists('pengguna')) {
                $pengguna_table_exists = TRUE;
                $pengguna_count = $this->db->count_all('pengguna');
            }

            if ($this->db->table_exists('tim_penilai_sk')) {
                $tim_penilai_table_exists = TRUE;
                $tim_penilai_count = $this->db->count_all('tim_penilai_sk');
            }

            if ($this->db->table_exists('kriteria')) {
                $kriteria_table_exists = TRUE;
                $kriteria_count = $this->db->count_all('kriteria');
            }

            if ($this->db->table_exists('periode')) {
                $periode_table_exists = TRUE;
                $periode_count = $this->db->count_all('periode');
            }

            if ($this->db->table_exists('topsis_proses')) {
                $topsis_proses_table_exists = TRUE;
                $topsis_proses_count = $this->db->count_all('topsis_proses');
            }

            if ($this->db->table_exists('laporan_ba')) {
                $laporan_ba_table_exists = TRUE;
                $laporan_ba_count = $this->db->count_all('laporan_ba');
            }

            if ($this->db->table_exists('audit_trail')) {
                $audit_trail_table_exists = TRUE;
                $audit_trail_count = $this->db->count_all('audit_trail');
            }
        }

        echo json_encode(array(
            'status'                         => 'success',
            'current_version'                => $current_version,
            'referensi_pegawai_table_exists' => $referensi_pegawai_table_exists,
            'referensi_pegawai_count'        => $referensi_pegawai_count,
            'pengaturan_table_exists'        => $pengaturan_table_exists,
            'pengguna_table_exists'          => $pengguna_table_exists,
            'pengguna_count'                 => $pengguna_count,
            'tim_penilai_table_exists'       => $tim_penilai_table_exists,
            'tim_penilai_count'              => $tim_penilai_count,
            'kriteria_table_exists'          => $kriteria_table_exists,
            'kriteria_count'                 => $kriteria_count,
            'periode_table_exists'           => $periode_table_exists,
            'periode_count'                  => $periode_count,
            'topsis_proses_table_exists'     => $topsis_proses_table_exists,
            'topsis_proses_count'            => $topsis_proses_count,
            'laporan_ba_table_exists'        => $laporan_ba_table_exists,
            'laporan_ba_count'               => $laporan_ba_count,
            'audit_trail_table_exists'       => $audit_trail_table_exists,
            'audit_trail_count'              => $audit_trail_count,
            'db_name'                        => $db_name
        ));
    }
}
