<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller
{
    public function index()
    {
        // 10 Data Sample Kriteria Penilaian TOPSIS (PN Lubuk Pakam)
        $kriteria_list = array(
            array(
                'id_kriteria' => 1,
                'kode' => 'C1_HKM',
                'nama_kriteria' => 'Kedisiplinan Kehadiran & Jam Kerja',
                'kategori' => 'Hakim',
                'bobot' => 20.00,
                'jenis_data' => 'kuantitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 2,
                'kode' => 'C2_HKM',
                'nama_kriteria' => 'Penyelesaian Perkara SIPP (Kepatuhan Waktu)',
                'kategori' => 'Hakim',
                'bobot' => 35.00,
                'jenis_data' => 'kuantitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 3,
                'kode' => 'C3_HKM',
                'nama_kriteria' => 'Integritas & Kepatuhan Kode Etik',
                'kategori' => 'Hakim',
                'bobot' => 25.00,
                'jenis_data' => 'kualitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 4,
                'kode' => 'C4_HKM',
                'nama_kriteria' => 'Tunggakan Minutasi Perkara',
                'kategori' => 'Hakim',
                'bobot' => 20.00,
                'jenis_data' => 'kuantitatif',
                'tipe_atribut' => 'cost',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 5,
                'kode' => 'C1_PP',
                'nama_kriteria' => 'Kecepatan Minutasi Berkas Perkara',
                'kategori' => 'Panitera Pengganti',
                'bobot' => 30.00,
                'jenis_data' => 'kuantitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 6,
                'kode' => 'C2_PP',
                'nama_kriteria' => 'Kepatuhan Penginputan e-Court & SIPP',
                'kategori' => 'Panitera Pengganti',
                'bobot' => 30.00,
                'jenis_data' => 'kualitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 7,
                'kode' => 'C3_PP',
                'nama_kriteria' => 'Kedisiplinan & Ketertiban Berkas Persidangan',
                'kategori' => 'Panitera Pengganti',
                'bobot' => 40.00,
                'jenis_data' => 'kualitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 8,
                'kode' => 'C1_JS',
                'nama_kriteria' => 'Kecepatan Penyampaian Relaas Panggilan',
                'kategori' => 'Jurusita',
                'bobot' => 50.00,
                'jenis_data' => 'kuantitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 9,
                'kode' => 'C2_JS',
                'nama_kriteria' => 'Akurasi & Validitas Upload Berita Acara Relaas',
                'kategori' => 'Jurusita',
                'bobot' => 50.00,
                'jenis_data' => 'kualitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            ),
            array(
                'id_kriteria' => 10,
                'kode' => 'C1_STF',
                'nama_kriteria' => 'Capaian Kinerja Pegawai (SKP) & Pelayanan Public',
                'kategori' => 'Staf',
                'bobot' => 100.00,
                'jenis_data' => 'kualitatif',
                'tipe_atribut' => 'benefit',
                'aktif' => 1
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Kriteria Penilaian',
            'page_heading' => 'Kriteria Penilaian',
            'active_menu' => 'kriteria',
            'content_view' => 'admin/kriteria',
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
                'kriteria_list' => $kriteria_list
            )
        ));
    }
}
