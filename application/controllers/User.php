<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function index()
    {
        // 10 Data Sample Pengguna Sistem (PN Lubuk Pakam)
        $user_list = array(
            array(
                'id_user' => 1,
                'username' => 'superadmin',
                'nama_user' => 'Administrator Utama',
                'email' => 'admin.spk@pn-lubukpakam.go.id',
                'role' => 'Superadmin',
                'status' => 1,
                'last_login' => '2026-08-09 14:15:22'
            ),
            array(
                'id_user' => 2,
                'username' => 'ketua.pn',
                'nama_user' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'email' => 'ketua@pn-lubukpakam.go.id',
                'role' => 'Pimpinan',
                'status' => 1,
                'last_login' => '2026-08-09 09:30:10'
            ),
            array(
                'id_user' => 3,
                'username' => 'wakil.pn',
                'nama_user' => 'Hj. Fitriani, S.H., M.H.',
                'email' => 'wakil@pn-lubukpakam.go.id',
                'role' => 'Pimpinan',
                'status' => 1,
                'last_login' => '2026-08-08 16:45:00'
            ),
            array(
                'id_user' => 4,
                'username' => 'panitera',
                'nama_user' => 'Bambang Wijaya, S.H., M.H.',
                'email' => 'panitera@pn-lubukpakam.go.id',
                'role' => 'Tim Penilai',
                'status' => 1,
                'last_login' => '2026-08-09 11:20:30'
            ),
            array(
                'id_user' => 5,
                'username' => 'sekretaris',
                'nama_user' => 'Drs. Muhammad Rizky',
                'email' => 'sekretaris@pn-lubukpakam.go.id',
                'role' => 'Tim Penilai',
                'status' => 1,
                'last_login' => '2026-08-09 08:10:15'
            ),
            array(
                'id_user' => 6,
                'username' => 'kasub.kepegawaian',
                'nama_user' => 'Dewi Sartika, S.H.',
                'email' => 'kepegawaian@pn-lubukpakam.go.id',
                'role' => 'Administrator',
                'status' => 1,
                'last_login' => '2026-08-09 13:50:00'
            ),
            array(
                'id_user' => 7,
                'username' => 'hakim.rina',
                'nama_user' => 'Rina Agustina, S.H., M.H.',
                'email' => 'rina.agustina@pn-lubukpakam.go.id',
                'role' => 'Tim Penilai',
                'status' => 1,
                'last_login' => '2026-08-07 15:20:00'
            ),
            array(
                'id_user' => 8,
                'username' => 'panitera.dian',
                'nama_user' => 'Dian Pratiwi, S.H., M.Kn.',
                'email' => 'dian.pratiwi@pn-lubukpakam.go.id',
                'role' => 'Tim Penilai',
                'status' => 1,
                'last_login' => '2026-08-06 10:05:00'
            ),
            array(
                'id_user' => 9,
                'username' => 'jurusita.eko',
                'nama_user' => 'Eko Prasetyo, S.H.',
                'email' => 'eko.prasetyo@pn-lubukpakam.go.id',
                'role' => 'Tim Penilai',
                'status' => 1,
                'last_login' => '2026-08-05 14:40:00'
            ),
            array(
                'id_user' => 10,
                'username' => 'staf.hendra',
                'nama_user' => 'Hendra Wijaya, S.H.',
                'email' => 'hendra.wijaya@pn-lubukpakam.go.id',
                'role' => 'Administrator',
                'status' => 0,
                'last_login' => '2026-07-20 09:15:00'
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Manajemen Pengguna',
            'page_heading' => 'Manajemen Pengguna Sistem',
            'active_menu' => 'user',
            'content_view' => 'admin/user',
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
                'user_list' => $user_list
            )
        ));
    }
}
