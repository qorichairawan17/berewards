<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function index()
    {
        // 10 Data Sample Pegawai Pengadilan Negeri Lubuk Pakam dengan Foto Profil
        $pegawai_list = array(
            array(
                'id_pegawai' => 1,
                'nip' => '19750812 200003 1 001',
                'nama' => 'Rina Agustina, S.H., M.H.',
                'pangkat' => 'Pembina Utama Muda',
                'golongan' => 'IV/c',
                'jabatan' => 'Hakim Utama',
                'kategori' => 'Hakim',
                'foto' => 'assets/images/users/user-10.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 2,
                'nip' => '19800315 200501 1 004',
                'nama' => 'Ahmad Faisal, S.H.',
                'pangkat' => 'Pembina Tingkat I',
                'golongan' => 'IV/b',
                'jabatan' => 'Hakim Pratama',
                'kategori' => 'Hakim',
                'foto' => 'assets/images/users/user-2.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 3,
                'nip' => '19830130 200804 1 003',
                'nama' => 'Rizky Ramadhan, S.H.',
                'pangkat' => 'Pembina',
                'golongan' => 'IV/a',
                'jabatan' => 'Hakim Pratama Muda',
                'kategori' => 'Hakim',
                'foto' => 'assets/images/users/user-3.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 4,
                'nip' => '19850620 200902 2 008',
                'nama' => 'Dian Pratiwi, S.H., M.Kn.',
                'pangkat' => 'Pembina',
                'golongan' => 'IV/a',
                'jabatan' => 'Panitera Pengganti Muda',
                'kategori' => 'Panitera Pengganti',
                'foto' => 'assets/images/users/user-4.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 5,
                'nip' => '19881110 201101 1 005',
                'nama' => 'Budi Santoso, S.H.',
                'pangkat' => 'Penata Tingkat I',
                'golongan' => 'III/d',
                'jabatan' => 'Panitera Pengganti',
                'kategori' => 'Panitera Pengganti',
                'foto' => 'assets/images/users/user-5.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 6,
                'nip' => '19900225 201403 2 006',
                'nama' => 'Siti Aminah, A.Md.',
                'pangkat' => 'Penata',
                'golongan' => 'III/c',
                'jabatan' => 'Panitera Pengganti Pertama',
                'kategori' => 'Panitera Pengganti',
                'foto' => 'assets/images/users/user-6.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 7,
                'nip' => '19910514 201502 1 007',
                'nama' => 'Eko Prasetyo, S.H.',
                'pangkat' => 'Penata Muda Tingkat I',
                'golongan' => 'III/b',
                'jabatan' => 'Jurusita Utama',
                'kategori' => 'Jurusita',
                'foto' => 'assets/images/users/user-7.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 8,
                'nip' => '19930708 201601 2 003',
                'nama' => 'Nurfadillah, S.E.',
                'pangkat' => 'Penata Muda',
                'golongan' => 'III/a',
                'jabatan' => 'Jurusita Pengganti',
                'kategori' => 'Jurusita',
                'foto' => 'assets/images/users/user-8.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 9,
                'nip' => '19920919 201703 1 002',
                'nama' => 'Hendra Wijaya, S.H.',
                'pangkat' => 'Penata Muda Tingkat I',
                'golongan' => 'III/b',
                'jabatan' => 'Staf Kepaniteraan Pidana',
                'kategori' => 'Staf',
                'foto' => 'assets/images/users/user-9.jpg',
                'aktif' => 1
            ),
            array(
                'id_pegawai' => 10,
                'nip' => '19941201 201802 2 009',
                'nama' => 'Dewi Sartika, S.H.',
                'pangkat' => 'Penata Muda',
                'golongan' => 'III/a',
                'jabatan' => 'Staf Kesekretariatan & Kepegawaian',
                'kategori' => 'Staf',
                'foto' => 'assets/images/users/user-11.jpg',
                'aktif' => 1
            )
        );

        $this->load->view('templates/layout', array(
            'page_title' => 'Data Pegawai',
            'page_heading' => 'Data Pegawai',
            'active_menu' => 'pegawai',
            'content_view' => 'admin/pegawai',
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
                'pegawai_list' => $pegawai_list
            )
        ));
    }
}
