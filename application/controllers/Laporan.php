<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function index()
    {
        // 10 Data Sample Berita Acara & Laporan Hasil TOPSIS (PN Lubuk Pakam)
        $laporan_list = array(
            array(
                'id_laporan' => 1,
                'no_ba' => 'W2.U4/01/BA.SPK/06/2026',
                'nama_periode' => 'Triwulan II 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Rina Agustina, S.H., M.H.',
                'pemenang_nip' => '19750812 200003 1 001',
                'kategori' => 'Hakim',
                'skor_topsis' => 0.9420,
                'tanggal_terbit' => '2026-06-30',
                'status' => 'Disahkan',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 2,
                'no_ba' => 'W2.U4/02/BA.SPK/06/2026',
                'nama_periode' => 'Triwulan II 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Dian Pratiwi, S.H., M.Kn.',
                'pemenang_nip' => '19850620 200902 2 008',
                'kategori' => 'Panitera Pengganti',
                'skor_topsis' => 0.8850,
                'tanggal_terbit' => '2026-06-30',
                'status' => 'Disahkan',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 3,
                'no_ba' => 'W2.U4/03/BA.SPK/06/2026',
                'nama_periode' => 'Triwulan II 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Eko Prasetyo, S.H.',
                'pemenang_nip' => '19910514 201502 1 007',
                'kategori' => 'Jurusita',
                'skor_topsis' => 0.8640,
                'tanggal_terbit' => '2026-06-30',
                'status' => 'Disahkan',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 4,
                'no_ba' => 'W2.U4/04/BA.SPK/06/2026',
                'nama_periode' => 'Triwulan II 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Dewi Sartika, S.H.',
                'pemenang_nip' => '19941201 201802 2 009',
                'kategori' => 'Staf',
                'skor_topsis' => 0.8210,
                'tanggal_terbit' => '2026-06-30',
                'status' => 'Disahkan',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 5,
                'no_ba' => 'W2.U4/01/BA.SPK/03/2026',
                'nama_periode' => 'Triwulan I 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Ahmad Faisal, S.H.',
                'pemenang_nip' => '19800315 200501 1 004',
                'kategori' => 'Hakim',
                'skor_topsis' => 0.9105,
                'tanggal_terbit' => '2026-03-31',
                'status' => 'Disahkan',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 6,
                'no_ba' => 'W2.U4/02/BA.SPK/03/2026',
                'nama_periode' => 'Triwulan I 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Budi Santoso, S.H.',
                'pemenang_nip' => '19881110 201101 1 005',
                'kategori' => 'Panitera Pengganti',
                'skor_topsis' => 0.8740,
                'tanggal_terbit' => '2026-03-31',
                'status' => 'Disahkan',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 7,
                'no_ba' => 'W2.U4/04/BA.SPK/12/2025',
                'nama_periode' => 'Triwulan IV 2025',
                'tahun' => 2025,
                'pemenang_nama' => 'Eko Prasetyo, S.H.',
                'pemenang_nip' => '19910514 201502 1 007',
                'kategori' => 'Jurusita',
                'skor_topsis' => 0.8870,
                'tanggal_terbit' => '2025-12-31',
                'status' => 'Arsip',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 8,
                'no_ba' => 'W2.U4/05/BA.SPK/12/2025',
                'nama_periode' => 'Tahunan 2025',
                'tahun' => 2025,
                'pemenang_nama' => 'Dewi Sartika, S.H.',
                'pemenang_nip' => '19941201 201802 2 009',
                'kategori' => 'Staf',
                'skor_topsis' => 0.9230,
                'tanggal_terbit' => '2025-12-31',
                'status' => 'Arsip',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 9,
                'no_ba' => 'W2.U4/03/BA.SPK/09/2025',
                'nama_periode' => 'Triwulan III 2025',
                'tahun' => 2025,
                'pemenang_nama' => 'Rizky Ramadhan, S.H.',
                'pemenang_nip' => '19830130 200804 1 003',
                'kategori' => 'Hakim',
                'skor_topsis' => 0.8650,
                'tanggal_terbit' => '2025-09-30',
                'status' => 'Arsip',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            array(
                'id_laporan' => 10,
                'no_ba' => 'W2.U4/01/BA.SPK/07/2026',
                'nama_periode' => 'Semester I 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Dian Pratiwi, S.H., M.Kn.',
                'pemenang_nip' => '19850620 200902 2 008',
                'kategori' => 'Panitera Pengganti',
                'skor_topsis' => 0.8950,
                'tanggal_terbit' => '2026-07-01',
                'status' => 'Draft',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Laporan & Berita Acara',
            'page_heading' => 'Laporan & Berita Acara TOPSIS',
            'active_menu' => 'laporan',
            'content_view' => 'admin/laporan',
            'extra_css' => array(
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'
            ),
            'extra_js' => array(
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ),
            'view_data' => array(
                'laporan_list' => $laporan_list
            )
        ));
    }
}
