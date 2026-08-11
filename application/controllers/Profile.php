<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Profile
 * Mengelola tampilan halaman "Profil Saya" pengguna sistem BeRewards.
 */
class Profile extends CI_Controller
{
    public function index()
    {
        // Sample data profil pengguna (Administrator Utama / Superadmin)
        $user_profile = array(
            'id_user'       => 1,
            'username'      => 'superadmin',
            'nama_lengkap'  => 'Administrator Utama',
            'nip'           => '19880315 201201 1 002',
            'nik'           => '1207021503880001',
            'email'         => 'admin.spk@pn-lubukpakam.go.id',
            'no_hp'         => '0812-6490-8812',
            'jabatan'       => 'Analis Tata Taksana / Pengelola Sistem SPK',
            'unit_kerja'    => 'Pengadilan Negeri Lubuk Pakam Kelas I-A',
            'role'          => 'Superadmin',
            'status_akun'   => 'Aktif',
            'tgl_bergabung' => '2020-01-15',
            'last_login'    => '2026-08-11 14:15:22',
            'ip_address'    => '192.168.1.105',
            'browser'       => 'Chrome 127.0 (Windows 11)',
            'foto'          => 'assets/images/users/user-1.jpg'
        );

        $stats = array(
            'total_proses'  => 12,
            'total_pegawai' => 45,
            'periode_aktif' => 'Triwulan III 2026',
            'keamanan'      => 'Optimal'
        );

        $activity_logs = array(
            array(
                'aktivitas' => 'Login ke Sistem BeRewards',
                'waktu'     => '2026-08-11 14:15:22',
                'ip'        => '192.168.1.105',
                'perangkat' => 'Chrome di Windows 11',
                'status'    => 'Sukses'
            ),
            array(
                'aktivitas' => 'Menggenerasi Laporan Berita Acara TOPSIS',
                'waktu'     => '2026-08-09 11:45:00',
                'ip'        => '192.168.1.105',
                'perangkat' => 'Chrome di Windows 11',
                'status'    => 'Sukses'
            ),
            array(
                'aktivitas' => 'Memperbarui Master Data Pegawai',
                'waktu'     => '2026-08-08 09:30:15',
                'ip'        => '192.168.1.105',
                'perangkat' => 'Chrome di Windows 11',
                'status'    => 'Sukses'
            ),
            array(
                'aktivitas' => 'Login ke Sistem BeRewards',
                'waktu'     => '2026-08-07 16:20:10',
                'ip'        => '192.168.1.102',
                'perangkat' => 'Firefox di Windows 11',
                'status'    => 'Sukses'
            )
        );

        $this->load->view('templates/layout', array(
            'page_title'   => 'Profil Saya — BeRewards',
            'page_heading' => 'Profil Saya',
            'active_menu'  => 'profile',
            'content_view' => 'admin/profile',
            'extra_css'    => array(),
            'extra_js'     => array(),
            'view_data'    => array(
                'user'          => $user_profile,
                'stats'         => $stats,
                'activity_logs' => $activity_logs
            )
        ));
    }
}
