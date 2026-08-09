<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    private function get_laporan_data()
    {
        return array(
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
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'top_3' => array(
                    array('rank' => 1, 'nama' => 'Rina Agustina, S.H., M.H.', 'nip' => '19750812 200003 1 001', 'kategori' => 'Hakim', 'skor' => 0.9420, 'dplus' => 0.0350, 'dminus' => 0.5820, 'foto' => 'assets/images/users/user-10.jpg'),
                    array('rank' => 2, 'nama' => 'Ahmad Faisal, S.H.', 'nip' => '19800315 200501 1 004', 'kategori' => 'Hakim', 'skor' => 0.8120, 'dplus' => 0.0890, 'dminus' => 0.4910, 'foto' => 'assets/images/users/user-2.jpg'),
                    array('rank' => 3, 'nama' => 'Rizky Ramadhan, S.H.', 'nip' => '19830130 200804 1 003', 'kategori' => 'Hakim', 'skor' => 0.7650, 'dplus' => 0.1240, 'dminus' => 0.4050, 'foto' => 'assets/images/users/user-3.jpg')
                )
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
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'top_3' => array(
                    array('rank' => 1, 'nama' => 'Dian Pratiwi, S.H., M.Kn.', 'nip' => '19850620 200902 2 008', 'kategori' => 'Panitera Pengganti', 'skor' => 0.8850, 'dplus' => 0.0420, 'dminus' => 0.5100, 'foto' => 'assets/images/users/user-4.jpg'),
                    array('rank' => 2, 'nama' => 'Budi Santoso, S.H.', 'nip' => '19881110 201101 1 005', 'kategori' => 'Panitera Pengganti', 'skor' => 0.7950, 'dplus' => 0.0980, 'dminus' => 0.4420, 'foto' => 'assets/images/users/user-5.jpg'),
                    array('rank' => 3, 'nama' => 'Siti Aminah, A.Md.', 'nip' => '19900225 201403 2 006', 'kategori' => 'Panitera Pengganti', 'skor' => 0.7420, 'dplus' => 0.1350, 'dminus' => 0.3850, 'foto' => 'assets/images/users/user-6.jpg')
                )
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
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'top_3' => array(
                    array('rank' => 1, 'nama' => 'Eko Prasetyo, S.H.', 'nip' => '19910514 201502 1 007', 'kategori' => 'Jurusita', 'skor' => 0.8640, 'dplus' => 0.0510, 'dminus' => 0.4950, 'foto' => 'assets/images/users/user-7.jpg'),
                    array('rank' => 2, 'nama' => 'Nurfadillah, S.E.', 'nip' => '19930708 201601 2 003', 'kategori' => 'Jurusita', 'skor' => 0.7810, 'dplus' => 0.1020, 'dminus' => 0.4200, 'foto' => 'assets/images/users/user-8.jpg'),
                    array('rank' => 3, 'nama' => 'Hendra Wijaya, S.H.', 'nip' => '19920919 201703 1 002', 'kategori' => 'Jurusita', 'skor' => 0.7200, 'dplus' => 0.1480, 'dminus' => 0.3600, 'foto' => 'assets/images/users/user-9.jpg')
                )
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
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'top_3' => array(
                    array('rank' => 1, 'nama' => 'Dewi Sartika, S.H.', 'nip' => '19941201 201802 2 009', 'kategori' => 'Staf', 'skor' => 0.8210, 'dplus' => 0.0620, 'dminus' => 0.4600, 'foto' => 'assets/images/users/user-11.jpg'),
                    array('rank' => 2, 'nama' => 'Hendra Wijaya, S.H.', 'nip' => '19920919 201703 1 002', 'kategori' => 'Staf', 'skor' => 0.7580, 'dplus' => 0.1150, 'dminus' => 0.3950, 'foto' => 'assets/images/users/user-9.jpg'),
                    array('rank' => 3, 'nama' => 'Nurfadillah, S.E.', 'nip' => '19930708 201601 2 003', 'kategori' => 'Staf', 'skor' => 0.7100, 'dplus' => 0.1520, 'dminus' => 0.3500, 'foto' => 'assets/images/users/user-8.jpg')
                )
            ),
            array(
                'id_laporan' => 5,
                'no_ba' => 'W2.U4/05/BA.SPK/03/2026',
                'nama_periode' => 'Triwulan I 2026',
                'tahun' => 2026,
                'pemenang_nama' => 'Ahmad Faisal, S.H.',
                'pemenang_nip' => '19800315 200501 1 004',
                'kategori' => 'Hakim',
                'skor_topsis' => 0.9150,
                'tanggal_terbit' => '2026-03-31',
                'status' => 'Disahkan',
                'ketua_panitia' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'top_3' => array(
                    array('rank' => 1, 'nama' => 'Ahmad Faisal, S.H.', 'nip' => '19800315 200501 1 004', 'kategori' => 'Hakim', 'skor' => 0.9150, 'dplus' => 0.0380, 'dminus' => 0.5500, 'foto' => 'assets/images/users/user-2.jpg'),
                    array('rank' => 2, 'nama' => 'Rina Agustina, S.H., M.H.', 'nip' => '19750812 200003 1 001', 'kategori' => 'Hakim', 'skor' => 0.8400, 'dplus' => 0.0750, 'dminus' => 0.4800, 'foto' => 'assets/images/users/user-10.jpg'),
                    array('rank' => 3, 'nama' => 'Rizky Ramadhan, S.H.', 'nip' => '19830130 200804 1 003', 'kategori' => 'Hakim', 'skor' => 0.7720, 'dplus' => 0.1200, 'dminus' => 0.4100, 'foto' => 'assets/images/users/user-3.jpg')
                )
            )
        );
    }

    public function index()
    {
        $laporan_list = $this->get_laporan_data();

        $this->load->view('templates/layout', array(
            'page_title' => 'Laporan & Berita Acara',
            'page_heading' => 'Laporan Berita Acara Hasil TOPSIS',
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

    /**
     * Export Berita Acara ke format Word (.docx).
     *
     * URL: laporan/export/{id}
     * Memanggil Laporan_service::export_berita_acara() yang mengirim
     * file langsung ke browser sebagai unduhan.
     *
     * @param int $id  ID laporan yang akan diekspor.
     */
    public function export($id = 0)
    {
        $id = (int) $id;

        if ($id <= 0) {
            show_error('ID laporan tidak valid.', 400, 'Export Error');
        }

        // Cari data laporan berdasarkan ID
        $laporan_list    = $this->get_laporan_data();
        $laporan_data    = null;

        foreach ($laporan_list as $row) {
            if ($row['id_laporan'] === $id) {
                $laporan_data = $row;
                break;
            }
        }

        if (!$laporan_data) {
            show_error('Data laporan dengan ID ' . $id . ' tidak ditemukan.', 404, 'Export Error');
        }

        // Delegasikan pembuatan dokumen ke service layer
        $this->load->service('Laporan_service');
        $this->laporan_service->export_berita_acara($laporan_data);
        // export_berita_acara() memanggil exit, tidak ada kode yang dijalankan setelahnya
    }

    public function preview($id = 1)
    {
        $laporan_list = $this->get_laporan_data();
        $selected_laporan = null;

        foreach ($laporan_list as $row) {
            if ($row['id_laporan'] == $id) {
                $selected_laporan = $row;
                break;
            }
        }

        if (!$selected_laporan) {
            $selected_laporan = $laporan_list[0];
        }

        $this->load->view('templates/layout', array(
            'page_title' => 'Showroom Pratinjau Kandidat Reward',
            'page_heading' => 'Showroom Pratinjau Kandidat Reward',
            'active_menu' => 'laporan',
            'content_view' => 'admin/laporan_preview',
            'extra_css' => array(),
            'extra_js' => array(),
            'view_data' => array(
                'laporan_list' => $laporan_list,
                'laporan_info' => $selected_laporan
            )
        ));
    }
}
