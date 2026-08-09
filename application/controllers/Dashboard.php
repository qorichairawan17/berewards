<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function index()
    {
        $kpi = array(
            'total_pegawai' => 10,
            'total_kriteria' => 10,
            'periode_aktif' => 6,
            'ba_disahkan' => 6,
            'total_user' => 10,
            'audit_log' => 10
        );

        $top_winners = array(
            array(
                'kategori' => 'Hakim',
                'nama' => 'Rina Agustina, S.H., M.H.',
                'nip' => '19750812 200003 1 001',
                'skor' => 0.9420,
                'foto' => 'assets/images/users/user-10.jpg',
                'periode' => 'Triwulan II 2026'
            ),
            array(
                'kategori' => 'Panitera Pengganti',
                'nama' => 'Dian Pratiwi, S.H., M.Kn.',
                'nip' => '19850620 200902 2 008',
                'skor' => 0.8850,
                'foto' => 'assets/images/users/user-4.jpg',
                'periode' => 'Triwulan II 2026'
            ),
            array(
                'kategori' => 'Jurusita',
                'nama' => 'Eko Prasetyo, S.H.',
                'nip' => '19910514 201502 1 007',
                'skor' => 0.8640,
                'foto' => 'assets/images/users/user-7.jpg',
                'periode' => 'Triwulan II 2026'
            ),
            array(
                'kategori' => 'Staf',
                'nama' => 'Dewi Sartika, S.H.',
                'nip' => '19941201 201802 2 009',
                'skor' => 0.8210,
                'foto' => 'assets/images/users/user-11.jpg',
                'periode' => 'Triwulan II 2026'
            )
        );

        $recent_activities = array(
            array(
                'timestamp' => '2026-08-09 14:15:22',
                'user' => 'superadmin',
                'nama' => 'Administrator Utama',
                'modul' => 'Manajemen Pengguna',
                'aktivitas' => 'Menambahkan akun pengguna baru panitera.dian dengan role Tim Penilai',
                'status' => 'Sukses'
            ),
            array(
                'timestamp' => '2026-08-09 13:50:00',
                'user' => 'kasub.kepegawaian',
                'nama' => 'Dewi Sartika, S.H.',
                'modul' => 'Data Pegawai',
                'aktivitas' => 'Memperbarui foto profil & data NIP 19750812 200003 1 001',
                'status' => 'Sukses'
            ),
            array(
                'timestamp' => '2026-08-09 11:30:15',
                'user' => 'panitera',
                'nama' => 'Bambang Wijaya, S.H., M.H.',
                'modul' => 'Penilaian & TOPSIS',
                'aktivitas' => 'Mengkalkulasi TOPSIS periode Triwulan II 2026 ke status FINAL',
                'status' => 'Sukses'
            ),
            array(
                'timestamp' => '2026-08-09 09:30:10',
                'user' => 'ketua.pn',
                'nama' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'modul' => 'Laporan & Berita Acara',
                'aktivitas' => 'Mengesahkan Berita Acara Nomor W2.U4/01/BA.SPK/06/2026',
                'status' => 'Sukses'
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Dashboard SPK Reward',
            'page_heading' => 'Dashboard SPK Reward TOPSIS',
            'active_menu' => 'dashboard',
            'content_view' => 'admin/dashboard',
            'view_data' => array(
                'kpi' => $kpi,
                'top_winners' => $top_winners,
                'recent_activities' => $recent_activities
            )
        ));
    }
}
