<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode extends CI_Controller
{
    public function index()
    {
        // 10 Data Sample Periode Penilaian (PN Lubuk Pakam)
        $periode_list = array(
            array(
                'id_periode' => 1,
                'nama_periode' => 'Triwulan II 2026',
                'jenis_periode' => 'triwulan',
                'tahun' => 2026,
                'tanggal_mulai' => '2026-04-01',
                'tanggal_selesai' => '2026-06-30',
                'keterangan' => 'Periode penilaian kinerja reward Triwulan II T.A. 2026',
                'status' => 'buka',
                'aktif' => 1
            ),
            array(
                'id_periode' => 2,
                'nama_periode' => 'Triwulan I 2026',
                'jenis_periode' => 'triwulan',
                'tahun' => 2026,
                'tanggal_mulai' => '2026-01-01',
                'tanggal_selesai' => '2026-03-31',
                'keterangan' => 'Periode penilaian Triwulan I T.A. 2026 (Selesai/Final)',
                'status' => 'tutup',
                'aktif' => 1
            ),
            array(
                'id_periode' => 3,
                'nama_periode' => 'Semester I 2026',
                'jenis_periode' => 'semester',
                'tahun' => 2026,
                'tanggal_mulai' => '2026-01-01',
                'tanggal_selesai' => '2026-06-30',
                'keterangan' => 'Penilaian gabungan Semester I T.A. 2026',
                'status' => 'buka',
                'aktif' => 1
            ),
            array(
                'id_periode' => 4,
                'nama_periode' => 'Triwulan IV 2025',
                'jenis_periode' => 'triwulan',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-10-01',
                'tanggal_selesai' => '2025-12-31',
                'keterangan' => 'Periode akhir tahun T.A. 2025',
                'status' => 'tutup',
                'aktif' => 1
            ),
            array(
                'id_periode' => 5,
                'nama_periode' => 'Triwulan III 2025',
                'jenis_periode' => 'triwulan',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2025-09-30',
                'keterangan' => 'Penilaian Triwulan III T.A. 2025',
                'status' => 'tutup',
                'aktif' => 1
            ),
            array(
                'id_periode' => 6,
                'nama_periode' => 'Semester II 2025',
                'jenis_periode' => 'semester',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2025-12-31',
                'keterangan' => 'Penilaian Semester II T.A. 2025',
                'status' => 'tutup',
                'aktif' => 1
            ),
            array(
                'id_periode' => 7,
                'nama_periode' => 'Tahunan 2025',
                'jenis_periode' => 'tahunan',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-12-31',
                'keterangan' => 'Penilaian Tahunan Pegawai Terbaik T.A. 2025',
                'status' => 'tutup',
                'aktif' => 1
            ),
            array(
                'id_periode' => 8,
                'nama_periode' => 'Triwulan II 2025',
                'jenis_periode' => 'triwulan',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-04-01',
                'tanggal_selesai' => '2025-06-30',
                'keterangan' => 'Penilaian Triwulan II T.A. 2025',
                'status' => 'tutup',
                'aktif' => 1
            ),
            array(
                'id_periode' => 9,
                'nama_periode' => 'Triwulan I 2025',
                'jenis_periode' => 'triwulan',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-03-31',
                'keterangan' => 'Penilaian Triwulan I T.A. 2025',
                'status' => 'tutup',
                'aktif' => 1
            ),
            array(
                'id_periode' => 10,
                'nama_periode' => 'Triwulan III 2026 (Draft)',
                'jenis_periode' => 'triwulan',
                'tahun' => 2026,
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2026-09-30',
                'keterangan' => 'Persiapan Periode Mendatang T.A. 2026',
                'status' => 'buka',
                'aktif' => 1
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Periode Penilaian',
            'page_heading' => 'Periode Penilaian',
            'active_menu' => 'periode',
            'content_view' => 'admin/periode',
            'extra_css' => array(
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/libs/flatpickr/flatpickr.min.css'
            ),
            'extra_js' => array(
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js',
                'assets/libs/flatpickr/flatpickr.min.js'
            ),
            'view_data' => array(
                'periode_list' => $periode_list
            )
        ));
    }
}
