<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses extends CI_Controller
{
    /**
     * Halaman Utama: Daftar Periode Penilaian TOPSIS
     */
    public function index()
    {
        // Sample Data Daftar Periode Penilaian yang memiliki kalkulasi TOPSIS
        $periode_penilaian_list = array(
            array(
                'id_periode' => 1,
                'nama_periode' => 'Triwulan II 2026',
                'jenis_periode' => 'triwulan',
                'tahun' => 2026,
                'jumlah_terpenilai' => 10,
                'pemenang_nama' => 'Rina Agustina, S.H., M.H.',
                'pemenang_kategori' => 'Hakim Utama',
                'skor_tertinggi' => 0.9420,
                'status_topsis' => 'Final',
                'tanggal_kalkulasi' => '2026-06-25 14:30:00'
            ),
            array(
                'id_periode' => 2,
                'nama_periode' => 'Triwulan I 2026',
                'jenis_periode' => 'triwulan',
                'tahun' => 2026,
                'jumlah_terpenilai' => 10,
                'pemenang_nama' => 'Ahmad Faisal, S.H.',
                'pemenang_kategori' => 'Hakim Pratama',
                'skor_tertinggi' => 0.9105,
                'status_topsis' => 'Final',
                'tanggal_kalkulasi' => '2026-03-28 10:15:00'
            ),
            array(
                'id_periode' => 3,
                'nama_periode' => 'Semester I 2026',
                'jenis_periode' => 'semester',
                'tahun' => 2026,
                'jumlah_terpenilai' => 10,
                'pemenang_nama' => 'Dian Pratiwi, S.H., M.Kn.',
                'pemenang_kategori' => 'Panitera Pengganti',
                'skor_tertinggi' => 0.8950,
                'status_topsis' => 'Draft',
                'tanggal_kalkulasi' => '2026-06-30 09:00:00'
            ),
            array(
                'id_periode' => 4,
                'nama_periode' => 'Triwulan IV 2025',
                'jenis_periode' => 'triwulan',
                'tahun' => 2025,
                'jumlah_terpenilai' => 10,
                'pemenang_nama' => 'Eko Prasetyo, S.H.',
                'pemenang_kategori' => 'Jurusita Utama',
                'skor_tertinggi' => 0.8870,
                'status_topsis' => 'Final',
                'tanggal_kalkulasi' => '2025-12-29 16:45:00'
            ),
            array(
                'id_periode' => 5,
                'nama_periode' => 'Tahunan 2025',
                'jenis_periode' => 'tahunan',
                'tahun' => 2025,
                'jumlah_terpenilai' => 10,
                'pemenang_nama' => 'Dewi Sartika, S.H.',
                'pemenang_kategori' => 'Staf Kesekretariatan',
                'skor_tertinggi' => 0.9230,
                'status_topsis' => 'Final',
                'tanggal_kalkulasi' => '2025-12-30 11:20:00'
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Penilaian & TOPSIS',
            'page_heading' => 'Penilaian & Perhitungan TOPSIS',
            'active_menu' => 'proses',
            'content_view' => 'admin/proses',
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
                'periode_penilaian_list' => $periode_penilaian_list
            )
        ));
    }

    /**
     * Halaman Detail: Rincian Penilaian Pegawai & Hasil TOPSIS Per Periode
     */
    public function detail($id_periode = 1)
    {
        // Header Periode Terpilih
        $periode_info = array(
            'id_periode' => $id_periode,
            'nama_periode' => ($id_periode == 2 ? 'Triwulan I 2026' : ($id_periode == 3 ? 'Semester I 2026' : 'Triwulan II 2026')),
            'jenis_periode' => 'triwulan',
            'tahun' => 2026,
            'tanggal_mulai' => '2026-04-01',
            'tanggal_selesai' => '2026-06-30',
            'status_topsis' => 'Final',
            'tanggal_kalkulasi' => '2026-06-25 14:30:00'
        );

        // 10 Data Hasil Penilaian & Peringkat TOPSIS Pegawai
        $hasil_topsis_pegawai = array(
            array(
                'id_penilaian' => 1,
                'id_pegawai' => 1,
                'nama_pegawai' => 'Rina Agustina, S.H., M.H.',
                'nip' => '19750812 200003 1 001',
                'jabatan' => 'Hakim Utama',
                'kategori' => 'Hakim',
                'c1_nilai' => 4.8,
                'c2_nilai' => 95.5,
                'c3_nilai' => 4.9,
                'c4_nilai' => 0,
                'd_plus' => 0.0215,
                'd_minus' => 0.3482,
                'skor_topsis' => 0.9420,
                'peringkat' => 1
            ),
            array(
                'id_penilaian' => 2,
                'id_pegawai' => 4,
                'nama_pegawai' => 'Dian Pratiwi, S.H., M.Kn.',
                'nip' => '19850620 200902 2 008',
                'jabatan' => 'Panitera Pengganti Muda',
                'kategori' => 'Panitera Pengganti',
                'c1_nilai' => 4.7,
                'c2_nilai' => 92.0,
                'c3_nilai' => 4.8,
                'c4_nilai' => 1,
                'd_plus' => 0.0412,
                'd_minus' => 0.3175,
                'skor_topsis' => 0.8850,
                'peringkat' => 2
            ),
            array(
                'id_penilaian' => 3,
                'id_pegawai' => 7,
                'nama_pegawai' => 'Eko Prasetyo, S.H.',
                'nip' => '19910514 201502 1 007',
                'jabatan' => 'Jurusita Utama',
                'kategori' => 'Jurusita',
                'c1_nilai' => 4.6,
                'c2_nilai' => 90.0,
                'c3_nilai' => 4.7,
                'c4_nilai' => 0,
                'd_plus' => 0.0489,
                'd_minus' => 0.3105,
                'skor_topsis' => 0.8640,
                'peringkat' => 3
            ),
            array(
                'id_penilaian' => 4,
                'id_pegawai' => 10,
                'nama_pegawai' => 'Dewi Sartika, S.H.',
                'nip' => '19941201 201802 2 009',
                'jabatan' => 'Staf Kesekretariatan',
                'kategori' => 'Staf',
                'c1_nilai' => 4.5,
                'c2_nilai' => 88.5,
                'c3_nilai' => 4.6,
                'c4_nilai' => 0,
                'd_plus' => 0.0620,
                'd_minus' => 0.2841,
                'skor_topsis' => 0.8210,
                'peringkat' => 4
            ),
            array(
                'id_penilaian' => 5,
                'id_pegawai' => 2,
                'nama_pegawai' => 'Ahmad Faisal, S.H.',
                'nip' => '19800315 200501 1 004',
                'jabatan' => 'Hakim Pratama',
                'kategori' => 'Hakim',
                'c1_nilai' => 4.4,
                'c2_nilai' => 86.0,
                'c3_nilai' => 4.5,
                'c4_nilai' => 2,
                'd_plus' => 0.0715,
                'd_minus' => 0.2770,
                'skor_topsis' => 0.7950,
                'peringkat' => 5
            ),
            array(
                'id_penilaian' => 6,
                'id_pegawai' => 5,
                'nama_pegawai' => 'Budi Santoso, S.H.',
                'nip' => '19881110 201101 1 005',
                'jabatan' => 'Panitera Pengganti',
                'kategori' => 'Panitera Pengganti',
                'c1_nilai' => 4.3,
                'c2_nilai' => 84.0,
                'c3_nilai' => 4.4,
                'c4_nilai' => 1,
                'd_plus' => 0.0890,
                'd_minus' => 0.2571,
                'skor_topsis' => 0.7430,
                'peringkat' => 6
            ),
            array(
                'id_penilaian' => 7,
                'id_pegawai' => 3,
                'nama_pegawai' => 'Rizky Ramadhan, S.H.',
                'nip' => '19830130 200804 1 003',
                'jabatan' => 'Hakim Pratama Muda',
                'kategori' => 'Hakim',
                'c1_nilai' => 4.2,
                'c2_nilai' => 82.5,
                'c3_nilai' => 4.3,
                'c4_nilai' => 3,
                'd_plus' => 0.1012,
                'd_minus' => 0.2478,
                'skor_topsis' => 0.7100,
                'peringkat' => 7
            ),
            array(
                'id_penilaian' => 8,
                'id_pegawai' => 6,
                'nama_pegawai' => 'Siti Aminah, A.Md.',
                'nip' => '19900225 201403 2 006',
                'jabatan' => 'Panitera Pengganti Pertama',
                'kategori' => 'Panitera Pengganti',
                'c1_nilai' => 4.0,
                'c2_nilai' => 80.0,
                'c3_nilai' => 4.2,
                'c4_nilai' => 2,
                'd_plus' => 0.1190,
                'd_minus' => 0.2291,
                'skor_topsis' => 0.6580,
                'peringkat' => 8
            ),
            array(
                'id_penilaian' => 9,
                'id_pegawai' => 9,
                'nama_pegawai' => 'Hendra Wijaya, S.H.',
                'nip' => '19920919 201703 1 002',
                'jabatan' => 'Staf Kepaniteraan Pidana',
                'kategori' => 'Staf',
                'c1_nilai' => 3.9,
                'c2_nilai' => 78.0,
                'c3_nilai' => 4.0,
                'c4_nilai' => 4,
                'd_plus' => 0.1432,
                'd_minus' => 0.2054,
                'skor_topsis' => 0.5890,
                'peringkat' => 9
            ),
            array(
                'id_penilaian' => 10,
                'id_pegawai' => 8,
                'nama_pegawai' => 'Nurfadillah, S.E.',
                'nip' => '19930708 201601 2 003',
                'jabatan' => 'Jurusita Pengganti',
                'kategori' => 'Jurusita',
                'c1_nilai' => 3.8,
                'c2_nilai' => 75.0,
                'c3_nilai' => 3.9,
                'c4_nilai' => 5,
                'd_plus' => 0.1701,
                'd_minus' => 0.1785,
                'skor_topsis' => 0.5120,
                'peringkat' => 10
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Detail Hasil TOPSIS — ' . $periode_info['nama_periode'],
            'page_heading' => 'Hasil Perhitungan TOPSIS ' . $periode_info['nama_periode'],
            'active_menu' => 'proses',
            'content_view' => 'admin/proses_detail',
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
                'periode_info' => $periode_info,
                'hasil_topsis_pegawai' => $hasil_topsis_pegawai
            )
        ));
    }
}
