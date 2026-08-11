<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Timpenilai
 * Mengelola data Tim Penilai (SK Penetapan Tim Penilai SPK Reward TOPSIS).
 */
class Timpenilai extends CI_Controller
{
    /**
     * Data Sample 10 SK Tim Penilai Pengadilan Negeri Lubuk Pakam
     */
    private function get_sample_data()
    {
        return array(
            array(
                'id_sk'        => 1,
                'no_sk'        => 'W2.U4/01/SK.TIM-SPK/01/2026',
                'tahun'       => 2026,
                'tanggal_sk'  => '2026-01-05',
                'perihal'     => 'SK Penetapan Tim Penilai SPK Penentuan Reward Pegawai Tahun 2026',
                'status'      => 'Aktif',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri / Ketua Tim Penilai',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan / Sekretaris Tim',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(
                    array(
                        'nama' => 'Hj. Fitriani, S.H., M.H.',
                        'nip'  => '19720820 199703 2 002',
                        'jabatan' => 'Wakil Ketua Pengadilan Negeri',
                        'penilaian' => 'Penilai Kategori Hakim'
                    ),
                    array(
                        'nama' => 'Bambang Wijaya, S.H., M.H.',
                        'nip'  => '19750310 199903 1 003',
                        'jabatan' => 'Panitera Pengadilan Negeri',
                        'penilaian' => 'Penilai Kategori Panitera Pengganti'
                    ),
                    array(
                        'nama' => 'Dewi Sartika, S.H.',
                        'nip'  => '19941201 201802 2 009',
                        'jabatan' => 'Kasubbag Kepegawaian & Ortala',
                        'penilaian' => 'Penilai Kategori Jurusita & Staf'
                    )
                ),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2026.pdf',
                    'ukuran'    => '1.8 MB',
                    'tgl_upload'=> '2026-01-05 10:30:00'
                )
            ),
            array(
                'id_sk'        => 2,
                'no_sk'        => 'W2.U4/15/SK.TIM-SPK/07/2025',
                'tahun'       => 2025,
                'tanggal_sk'  => '2025-07-01',
                'perihal'     => 'SK Tim Penilai SPK Reward Semester II Tahun 2025',
                'status'      => 'Selesai',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(
                    array(
                        'nama' => 'Hj. Fitriani, S.H., M.H.',
                        'nip'  => '19720820 199703 2 002',
                        'jabatan' => 'Wakil Ketua Pengadilan Negeri',
                        'penilaian' => 'Penilai Kategori Hakim & Panitera'
                    ),
                    array(
                        'nama' => 'Bambang Wijaya, S.H., M.H.',
                        'nip'  => '19750310 199903 1 003',
                        'jabatan' => 'Panitera Pengadilan Negeri',
                        'penilaian' => 'Penilai Kategori Jurusita & Staf'
                    )
                ),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2025_Sem2.pdf',
                    'ukuran'    => '1.5 MB',
                    'tgl_upload'=> '2025-07-01 09:15:00'
                )
            ),
            array(
                'id_sk'        => 3,
                'no_sk'        => 'W2.U4/02/SK.TIM-SPK/01/2025',
                'tahun'       => 2025,
                'tanggal_sk'  => '2025-01-06',
                'perihal'     => 'SK Tim Penilai SPK Reward Semester I Tahun 2025',
                'status'      => 'Selesai',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(
                    array(
                        'nama' => 'Bambang Wijaya, S.H., M.H.',
                        'nip'  => '19750310 199903 1 003',
                        'jabatan' => 'Panitera Pengadilan Negeri',
                        'penilaian' => 'Penilai Kategori Kepaniteraan'
                    )
                ),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2025_Sem1.pdf',
                    'ukuran'    => '1.4 MB',
                    'tgl_upload'=> '2025-01-06 11:20:00'
                )
            ),
            array(
                'id_sk'        => 4,
                'no_sk'        => 'W2.U4/18/SK.TIM-SPK/07/2024',
                'tahun'       => 2024,
                'tanggal_sk'  => '2024-07-02',
                'perihal'     => 'SK Tim Evaluasi Penentuan Reward Periode II 2024',
                'status'      => 'Arsip',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(
                    array(
                        'nama' => 'Dewi Sartika, S.H.',
                        'nip'  => '19941201 201802 2 009',
                        'jabatan' => 'Kasubbag Kepegawaian',
                        'penilaian' => 'Penilai Kategori Kesekretariatan'
                    )
                ),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2024_Sem2.pdf',
                    'ukuran'    => '1.6 MB',
                    'tgl_upload'=> '2024-07-02 14:00:00'
                )
            ),
            array(
                'id_sk'        => 5,
                'no_sk'        => 'W2.U4/04/SK.TIM-SPK/01/2024',
                'tahun'       => 2024,
                'tanggal_sk'  => '2024-01-08',
                'perihal'     => 'SK Tim Evaluasi Penentuan Reward Periode I 2024',
                'status'      => 'Arsip',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2024_Sem1.pdf',
                    'ukuran'    => '1.3 MB',
                    'tgl_upload'=> '2024-01-08 09:45:00'
                )
            ),
            array(
                'id_sk'        => 6,
                'no_sk'        => 'W2.U4/20/SK.TIM-SPK/07/2023',
                'tahun'       => 2023,
                'tanggal_sk'  => '2023-07-03',
                'perihal'     => 'SK Tim Penilai Kinerja & Reward Pegawai Tahunan 2023',
                'status'      => 'Arsip',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2023.pdf',
                    'ukuran'    => '1.2 MB',
                    'tgl_upload'=> '2023-07-03 10:10:00'
                )
            ),
            array(
                'id_sk'        => 7,
                'no_sk'        => 'W2.U4/05/SK.TIM-SPK/01/2023',
                'tahun'       => 2023,
                'tanggal_sk'  => '2023-01-09',
                'perihal'     => 'SK Tim Penilai Kinerja & Reward Pegawai Semester I 2023',
                'status'      => 'Arsip',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2023_Sem1.pdf',
                    'ukuran'    => '1.1 MB',
                    'tgl_upload'=> '2023-01-09 11:00:00'
                )
            ),
            array(
                'id_sk'        => 8,
                'no_sk'        => 'W2.U4/12/SK.TIM-SPK/07/2022',
                'tahun'       => 2022,
                'tanggal_sk'  => '2022-07-04',
                'perihal'     => 'SK Tim Penilai Kinerja & Reward Pegawai Semester II 2022',
                'status'      => 'Arsip',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2022_Sem2.pdf',
                    'ukuran'    => '1.5 MB',
                    'tgl_upload'=> '2022-07-04 15:30:00'
                )
            ),
            array(
                'id_sk'        => 9,
                'no_sk'        => 'W2.U4/03/SK.TIM-SPK/01/2022',
                'tahun'       => 2022,
                'tanggal_sk'  => '2022-01-10',
                'perihal'     => 'SK Tim Penilai Kinerja & Reward Pegawai Semester I 2022',
                'status'      => 'Arsip',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2022_Sem1.pdf',
                    'ukuran'    => '1.2 MB',
                    'tgl_upload'=> '2022-01-10 08:45:00'
                )
            ),
            array(
                'id_sk'        => 10,
                'no_sk'        => 'W2.U4/01/SK.TIM-SPK/01/2021',
                'tahun'       => 2021,
                'tanggal_sk'  => '2021-01-11',
                'perihal'     => 'SK Pembentukan Tim Penilai Reward Tahunan 2021',
                'status'      => 'Arsip',
                'ketua'       => array(
                    'nama'    => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                    'nip'     => '19680512 199303 1 001',
                    'jabatan' => 'Ketua Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-1.jpg'
                ),
                'sekretaris'  => array(
                    'nama'    => 'Drs. Muhammad Rizky',
                    'nip'     => '19781115 200212 1 004',
                    'jabatan' => 'Sekretaris Pengadilan Negeri',
                    'foto'    => 'assets/images/users/user-5.jpg'
                ),
                'anggota'     => array(),
                'dokumen_sk'  => array(
                    'nama_file' => 'SK_Tim_Penilai_TOPSIS_2021.pdf',
                    'ukuran'    => '1.0 MB',
                    'tgl_upload'=> '2021-01-11 09:00:00'
                )
            )
        );
    }

    public function index()
    {
        $sk_list = $this->get_sample_data();

        $this->load->view('templates/layout', array(
            'page_title'   => 'Tim Penilai — BeRewards',
            'page_heading' => 'Manajemen Tim Penilai SPK TOPSIS',
            'active_menu'  => 'timpenilai',
            'content_view' => 'admin/tim_penilai',
            'extra_css'    => array(
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'
            ),
            'extra_js'     => array(
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ),
            'view_data'    => array(
                'sk_list' => $sk_list
            )
        ));
    }

    public function detail($id = 1)
    {
        $sk_list = $this->get_sample_data();
        $selected_sk = null;

        foreach ($sk_list as $row) {
            if ($row['id_sk'] == $id) {
                $selected_sk = $row;
                break;
            }
        }

        if (!$selected_sk) {
            $selected_sk = $sk_list[0];
        }

        $this->load->view('templates/layout', array(
            'page_title'   => 'Detail Tim Penilai — BeRewards',
            'page_heading' => 'Rincian SK & Personel Tim Penilai',
            'active_menu'  => 'timpenilai',
            'content_view' => 'admin/tim_penilai_detail',
            'extra_css'    => array(),
            'extra_js'     => array(),
            'view_data'    => array(
                'sk_info'  => $selected_sk,
                'sk_list'  => $sk_list
            )
        ));
    }
}
