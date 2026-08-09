<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller
{
    public function index()
    {
        // 10 Data Sample Audit Log Aktivitas Pengguna (PN Lubuk Pakam)
        $audit_list = array(
            array(
                'id_audit' => 1,
                'timestamp' => '2026-08-09 14:15:22',
                'username' => 'superadmin',
                'nama_user' => 'Administrator Utama',
                'role' => 'Superadmin',
                'modul' => 'Manajemen Pengguna',
                'aktivitas' => 'Menambahkan akun pengguna baru: panitera.dian',
                'ip_address' => '192.168.1.10',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 2,
                'timestamp' => '2026-08-09 13:50:00',
                'username' => 'kasub.kepegawaian',
                'nama_user' => 'Dewi Sartika, S.H.',
                'role' => 'Administrator',
                'modul' => 'Data Pegawai',
                'aktivitas' => 'Memperbarui data & foto profil pegawai NIP 19750812 200003 1 001',
                'ip_address' => '192.168.1.24',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 3,
                'timestamp' => '2026-08-09 11:30:15',
                'username' => 'panitera',
                'nama_user' => 'Bambang Wijaya, S.H., M.H.',
                'role' => 'Tim Penilai',
                'modul' => 'Penilaian & TOPSIS',
                'aktivitas' => 'Memproses kalkulasi TOPSIS periode Triwulan II 2026 ke status FINAL',
                'ip_address' => '192.168.1.15',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 4,
                'timestamp' => '2026-08-09 11:20:30',
                'username' => 'panitera',
                'nama_user' => 'Bambang Wijaya, S.H., M.H.',
                'role' => 'Tim Penilai',
                'modul' => 'Penilaian & TOPSIS',
                'aktivitas' => 'Menginput nilai alternative kriteria C1-C4 pegawai Rina Agustina, S.H., M.H.',
                'ip_address' => '192.168.1.15',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 5,
                'timestamp' => '2026-08-09 09:30:10',
                'username' => 'ketua.pn',
                'nama_user' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'role' => 'Pimpinan',
                'modul' => 'Laporan & Berita Acara',
                'aktivitas' => 'Mengesahkan Berita Acara W2.U4/01/BA.SPK/06/2026',
                'ip_address' => '192.168.1.2',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 6,
                'timestamp' => '2026-08-09 08:15:00',
                'username' => 'sekretaris',
                'nama_user' => 'Drs. Muhammad Rizky',
                'role' => 'Tim Penilai',
                'modul' => 'Kriteria Penilaian',
                'aktivitas' => 'Memperbarui bobot kriteria C2 Perkara (Benefit, w=0.30)',
                'ip_address' => '192.168.1.18',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 7,
                'timestamp' => '2026-08-08 16:45:00',
                'username' => 'wakil.pn',
                'nama_user' => 'Hj. Fitriani, S.H., M.H.',
                'role' => 'Pimpinan',
                'modul' => 'Showroom Pratinjau',
                'aktivitas' => 'Membuka showroom pratinjau 3D kandidat reward Triwulan II 2026',
                'ip_address' => '192.168.1.3',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 8,
                'timestamp' => '2026-08-08 14:10:22',
                'username' => 'hakim.rina',
                'nama_user' => 'Rina Agustina, S.H., M.H.',
                'role' => 'Tim Penilai',
                'modul' => 'Autentikasi Login',
                'aktivitas' => 'Gagal login: Kombinasi password tidak sesuai (2x percobaan)',
                'ip_address' => '192.168.1.45',
                'status' => 'Gagal'
            ),
            array(
                'id_audit' => 9,
                'timestamp' => '2026-08-07 15:20:00',
                'username' => 'hakim.rina',
                'nama_user' => 'Rina Agustina, S.H., M.H.',
                'role' => 'Tim Penilai',
                'modul' => 'Autentikasi Login',
                'aktivitas' => 'Berhasil login ke dalam sistem BeRewards',
                'ip_address' => '192.168.1.45',
                'status' => 'Sukses'
            ),
            array(
                'id_audit' => 10,
                'timestamp' => '2026-08-06 10:05:00',
                'username' => 'panitera.dian',
                'nama_user' => 'Dian Pratiwi, S.H., M.Kn.',
                'role' => 'Tim Penilai',
                'modul' => 'Periode Penilaian',
                'aktivitas' => 'Menambahkan periode penilaian baru: Triwulan III 2026',
                'ip_address' => '192.168.1.22',
                'status' => 'Sukses'
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Audit Trail',
            'page_heading' => 'Audit Trail Aktivitas Sistem',
            'active_menu' => 'audit',
            'content_view' => 'admin/audit',
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
                'audit_list' => $audit_list
            )
        ));
    }
}
