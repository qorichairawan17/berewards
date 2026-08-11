<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Setting
 * Mengelola tampilan halaman Pengaturan Satuan Kerja & Aplikasi BeRewards.
 */
class Setting extends CI_Controller
{
    public function index()
    {
        // Sample Data Informasi Satuan Kerja Pengadilan
        $satker_info = array(
            'nama_satker'        => 'Pengadilan Negeri Lubuk Pakam Kelas I-A',
            'singkatan'          => 'PN Lubuk Pakam',
            'kode_satker'        => '005021',
            'kode_wilayah'       => 'W2.U4',
            'kelas_pengadilan'   => 'Kelas I-A',
            'pengadilan_tinggi'  => 'Pengadilan Tinggi Medan',
            'alamat'             => 'Jl. Kemerdekaan No. 173, Lubuk Pakam, Kab. Deli Serdang',
            'kota'               => 'Lubuk Pakam',
            'provinsi'           => 'Sumatera Utara',
            'kode_pos'           => '20517',
            'telepon'            => '(061) 7952181',
            'fax'                => '(061) 7952182',
            'email'              => 'pn.lubukpakam@gmail.com',
            'website'            => 'https://pn-lubukpakam.go.id',
            'logo'               => 'assets/icons/logo.png'
        );

        // Sample Data Susunan Pimpinan Pengadilan
        $pimpinan_list = array(
            'ketua' => array(
                'jabatan' => 'Ketua Pengadilan Negeri',
                'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'nip'     => '19680512 199303 1 001',
                'pangkat' => 'Pembina Utama Muda (IV/c)',
                'foto'    => 'assets/images/users/user-1.jpg'
            ),
            'wakil_ketua' => array(
                'jabatan' => 'Wakil Ketua Pengadilan Negeri',
                'nama'    => 'Hj. Fitriani, S.H., M.H.',
                'nip'     => '19720820 199703 2 002',
                'pangkat' => 'Pembina Tk. I (IV/b)',
                'foto'    => 'assets/images/users/user-2.jpg'
            ),
            'panitera' => array(
                'jabatan' => 'Panitera Pengadilan Negeri',
                'nama'    => 'Bambang Wijaya, S.H., M.H.',
                'nip'     => '19750310 199903 1 003',
                'pangkat' => 'Pembina (IV/a)',
                'foto'    => 'assets/images/users/user-4.jpg'
            ),
            'sekretaris' => array(
                'jabatan' => 'Sekretaris Pengadilan Negeri',
                'nama'    => 'Drs. Muhammad Rizky',
                'nip'     => '19781115 200212 1 004',
                'pangkat' => 'Pembina (IV/a)',
                'foto'    => 'assets/images/users/user-5.jpg'
            )
        );

        // Sample Data Konfigurasi Aplikasi & Kop Surat
        $app_config = array(
            'nama_aplikasi'   => 'BeRewards',
            'deskripsi'       => 'Sistem Pendukung Keputusan Penentuan Reward Pegawai Metode TOPSIS',
            'kop_line1'       => 'PENGADILAN NEGERI LUBUK PAKAM KELAS I-A',
            'kop_line2'       => 'JL. KEMERDEKAAN NO. 173, LUBUK PAKAM, DELI SERDANG 20517',
            'format_nomor_ba' => '[KODE_WILAYAH]/[NO_URUT]/BA.SPK/[BULAN_ROMAWI]/[TAHUN]',
            'metode'          => 'TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)',
            'status'          => 'Aktif & Terkonfigurasi'
        );

        $this->load->view('templates/layout', array(
            'page_title'   => 'Pengaturan Aplikasi — BeRewards',
            'page_heading' => 'Pengaturan Satuan Kerja & Aplikasi',
            'active_menu'  => 'setting',
            'content_view' => 'admin/setting',
            'extra_css'    => array(),
            'extra_js'     => array(),
            'view_data'    => array(
                'satker'   => $satker_info,
                'pimpinan' => $pimpinan_list,
                'app'      => $app_config
            )
        ));
    }
}
