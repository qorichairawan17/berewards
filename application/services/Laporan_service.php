<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Laporan_service
 * 
 * Service Layer untuk mengelola seluruh alur logika bisnis Laporan & Berita Acara
 * Penetapan Reward Pegawai Pengadilan Negeri menggunakan Metode TOPSIS.
 * 
 * Mengorelasikan data dari:
 * - Tim_penilai_service (SK Tim Penilai & Penandatangan)
 * - Periode_service (Periode Penilaian Kinerja)
 * - Topsis_model & Topsis_service (Sesi Perhitungan & Hasil Skor Preferensi)
 * - Setting_service (Identitas Satker, Kop Surat, dan Pimpinan Pengadilan)
 * - Export_word_service (Penerbitan Dokumen .docx)
 * 
 * Sesuai prinsip Clean Architecture dan pemisahan tanggung jawab (SoC).
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Laporan_service
{
    /**
     * CodeIgniter Super Object
     * @var CI_Controller
     */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Laporan_model');
        $this->CI->load->model('Topsis_model');
        $this->CI->load->model('Periode_model');
        $this->CI->load->model('Tim_penilai_model');
        $this->CI->load->library('form_validation');

        // Load Service pendukung
        if (!isset($this->CI->setting_service)) {
            $this->CI->load->service('Setting_service');
        }
        if (!isset($this->CI->tim_penilai_service)) {
            $this->CI->load->service('Tim_penilai_service');
        }
        if (!isset($this->CI->export_word_service)) {
            $this->CI->load->service('Export_word_service');
        }
        if (!isset($this->CI->audit_service)) {
            @$this->CI->load->service('audit_service');
        }
    }

    /**
     * Mengambil daftar seluruh Berita Acara yang tersimpan di database.
     * 
     * @param array $filter Filter opsional
     * @return array
     */
    public function get_laporan_list(array $filter = array())
    {
        return $this->CI->Laporan_model->get_all_laporan($filter);
    }

    /**
     * Mengambil detail satu Berita Acara beserta informasi lengkapnya.
     * 
     * @param int $id_laporan
     * @return array|null
     */
    public function get_laporan_detail($id_laporan)
    {
        $id = (int)$id_laporan;
        if ($id <= 0) {
            return NULL;
        }

        $laporan = $this->CI->Laporan_model->get_laporan_by_id($id);
        if (!$laporan) {
            return NULL;
        }

        // Ambil info pimpinan dan satker dari Setting_service
        $settings = $this->CI->setting_service->get_settings();
        $laporan['satker']   = $settings['satker'];
        $laporan['pimpinan'] = $settings['pimpinan'];

        // Ambil info SK Tim Penilai jika ada
        if (!empty($laporan['id_sk'])) {
            $sk_res = $this->CI->tim_penilai_service->get_sk_detail((int)$laporan['id_sk']);
            if ($sk_res && !empty($sk_res['status'])) {
                $laporan['tim_penilai'] = $sk_res['data'];
            }
        }

        return $laporan;
    }

    /**
     * Mengambil opsi-opsi untuk form tambah Berita Acara:
     * - Sesi TOPSIS yang berstatus 'final'
     * - SK Tim Penilai yang berstatus 'Aktif' dari Tim_penilai_service
     * - Daftar Ketua Tim Penilai dari Tim_penilai_service
     * - Auto-generated Nomor Berita Acara
     * 
     * @return array
     */
    public function get_form_options()
    {
        $settings     = $this->CI->setting_service->get_settings();
        $satker       = $settings['satker'];
        $app          = $settings['app'];

        $proses_list  = $this->CI->Laporan_model->get_available_topsis_proses();
        $sk_list      = $this->CI->tim_penilai_service->get_all_sk();
        $active_sk    = $this->CI->tim_penilai_service->get_active_sk();
        $ketua_list   = $this->CI->tim_penilai_service->get_ketua_list();
        $active_ketua = $this->CI->tim_penilai_service->get_active_ketua();
        $periode_list = $this->CI->Periode_model->get_all_periode();

        // Hitung nomor BA rekomendasi
        $bulan_romawi = $this->_get_bulan_romawi((int)date('n'));
        $nomor_ba_auto = $this->CI->Laporan_model->generate_nomor_ba(
            !empty($app['format_nomor_ba']) ? $app['format_nomor_ba'] : '',
            !empty($satker['kode_wilayah']) ? $satker['kode_wilayah'] : 'W2.U4',
            $bulan_romawi,
            date('Y')
        );

        $default_ketua = !empty($active_ketua['nama']) ? $active_ketua['nama'] : (!empty($satker['nama_ketua']) ? $satker['nama_ketua'] : '');

        return array(
            'available_proses' => $proses_list,
            'sk_list'          => $sk_list,
            'active_sk'        => $active_sk,
            'ketua_list'       => $ketua_list,
            'active_ketua'     => $active_ketua,
            'periode_list'     => $periode_list,
            'nomor_ba_auto'    => $nomor_ba_auto,
            'default_ketua'    => $default_ketua
        );
    }

    /**
     * Membuat Berita Acara baru dari form input AJAX.
     * 
     * @param array $input Data $_POST
     * @return array Response payload array
     */
    public function create_laporan(array $input)
    {
        $id_proses = isset($input['id_proses']) ? (int)$input['id_proses'] : 0;
        if ($id_proses <= 0) {
            return array('status' => FALSE, 'message' => 'Sesi Penilaian TOPSIS wajib dipilih.');
        }

        // Ambil data sesi proses TOPSIS
        $proses = $this->CI->Topsis_model->get_proses_by_id($id_proses);
        if (!$proses) {
            return array('status' => FALSE, 'message' => 'Sesi proses TOPSIS tidak ditemukan.');
        }

        // Ambil pemenang rank #1 dari sesi ini
        $winner = $this->CI->db->select('ht.*, pa.nama_snapshot, pa.nip_snapshot, pa.id_pegawai')
                               ->from('hasil_topsis ht')
                               ->join('topsis_proses_alternatif pa', 'ht.id_proses_alternatif = pa.id_proses_alternatif', 'left')
                               ->where('ht.id_proses', $id_proses)
                               ->where('ht.ranking', 1)
                               ->get()
                               ->row_array();

        if (!$winner) {
            return array('status' => FALSE, 'message' => 'Sesi proses TOPSIS ini belum memiliki hasil perhitungan atau pemenang rank #1.');
        }

        $no_ba = !empty($input['no_ba']) ? trim($input['no_ba']) : '';
        if (empty($no_ba)) {
            return array('status' => FALSE, 'message' => 'Nomor Berita Acara wajib diisi.');
        }

        // Cek duplikasi no_ba
        $exists = $this->CI->db->where('no_ba', $no_ba)->count_all_results('laporan_ba');
        if ($exists > 0) {
            return array('status' => FALSE, 'message' => 'Nomor Berita Acara ' . $no_ba . ' sudah pernah diterbitkan.');
        }

        $id_sk = !empty($input['id_sk']) ? (int)$input['id_sk'] : NULL;
        if (!$id_sk) {
            // Cari SK Aktif otomatis via Tim_penilai_service
            $sk_aktif = $this->CI->tim_penilai_service->get_active_sk();
            if ($sk_aktif) {
                $id_sk = (int)$sk_aktif['id_sk'];
            }
        }

        // Ambil nama Ketua Penilai dari Tim_penilai_service
        $ketua_panitia = '';
        if ($id_sk) {
            $ketua_info = $this->CI->tim_penilai_service->get_ketua_by_sk($id_sk);
            if ($ketua_info && !empty($ketua_info['nama'])) {
                $ketua_panitia = $ketua_info['nama'];
            }
        }
        if (empty($ketua_panitia) && !empty($input['ketua_panitia'])) {
            $ketua_panitia = trim($input['ketua_panitia']);
        }
        if (empty($ketua_panitia)) {
            $active_ketua = $this->CI->tim_penilai_service->get_active_ketua();
            $ketua_panitia = !empty($active_ketua['nama']) ? $active_ketua['nama'] : '';
        }

        $tanggal_terbit = !empty($input['tanggal_terbit']) ? trim($input['tanggal_terbit']) : date('Y-m-d');
        $status         = !empty($input['status']) ? trim($input['status']) : 'Disahkan';

        $data_insert = array(
            'no_ba'          => $no_ba,
            'id_proses'      => $id_proses,
            'id_periode'     => (int)$proses['id_periode'],
            'id_sk'          => $id_sk,
            'kategori'       => !empty($input['kategori']) ? $input['kategori'] : $proses['kategori'],
            'id_pemenang'    => (int)$winner['id_pegawai'],
            'pemenang_nama'  => $winner['nama_snapshot'],
            'pemenang_nip'   => $winner['nip_snapshot'],
            'skor_topsis'    => (float)$winner['nilai_preferensi'],
            'tanggal_terbit' => $tanggal_terbit,
            'status'         => $status,
            'ketua_panitia'  => $ketua_panitia,
            'created_by'     => $this->CI->session->userdata('user_id') ? $this->CI->session->userdata('user_id') : 1
        );

        $id_new = $this->CI->Laporan_model->insert_laporan($data_insert);
        if ($id_new) {
            $this->_log_audit('BUAT_BERITA_ACARA', 'Menerbitkan Berita Acara Penetapan Reward No. ' . $no_ba . ' untuk sesi TOPSIS ID #' . $id_proses);
            return array(
                'status'     => TRUE,
                'message'    => 'Berita Acara Penetapan Reward TOPSIS berhasil diterbitkan.',
                'id_laporan' => $id_new
            );
        }

        return array('status' => FALSE, 'message' => 'Gagal menyimpan Berita Acara ke basis data.');
    }

    /**
     * Memperbarui data Berita Acara dari form edit.
     * 
     * @param int   $id_laporan
     * @param array $input
     * @return array
     */
    public function update_laporan($id_laporan, array $input)
    {
        $id = (int)$id_laporan;
        if ($id <= 0) {
            return array('status' => FALSE, 'message' => 'ID Berita Acara tidak valid.');
        }

        $existing = $this->CI->Laporan_model->get_laporan_by_id($id);
        if (!$existing) {
            return array('status' => FALSE, 'message' => 'Dokumen Berita Acara tidak ditemukan.');
        }

        $no_ba = !empty($input['no_ba']) ? trim($input['no_ba']) : $existing['no_ba'];
        
        // Cek duplikasi jika no_ba diubah
        if ($no_ba !== $existing['no_ba']) {
            $exists = $this->CI->db->where('no_ba', $no_ba)->where('id_laporan !=', $id)->count_all_results('laporan_ba');
            if ($exists > 0) {
                return array('status' => FALSE, 'message' => 'Nomor Berita Acara ' . $no_ba . ' sudah digunakan pada dokumen lain.');
            }
        }

        $id_sk = !empty($input['id_sk']) ? (int)$input['id_sk'] : (!empty($existing['id_sk']) ? (int)$existing['id_sk'] : NULL);
        $ketua_panitia = !empty($input['ketua_panitia']) ? trim($input['ketua_panitia']) : '';

        // Sinkronisasi Ketua dari Tim_penilai_service
        if ($id_sk) {
            $ketua_info = $this->CI->tim_penilai_service->get_ketua_by_sk($id_sk);
            if ($ketua_info && !empty($ketua_info['nama'])) {
                if (empty($ketua_panitia) || (isset($input['id_sk']) && (int)$input['id_sk'] !== (int)$existing['id_sk'])) {
                    $ketua_panitia = $ketua_info['nama'];
                }
            }
        }
        if (empty($ketua_panitia)) {
            $ketua_panitia = $existing['ketua_panitia'];
        }

        $data_update = array(
            'no_ba'          => $no_ba,
            'status'         => !empty($input['status']) ? trim($input['status']) : $existing['status'],
            'tanggal_terbit' => !empty($input['tanggal_terbit']) ? trim($input['tanggal_terbit']) : $existing['tanggal_terbit'],
            'ketua_panitia'  => $ketua_panitia
        );

        if ($id_sk) {
            $data_update['id_sk'] = $id_sk;
        }

        $res = $this->CI->Laporan_model->update_laporan($id, $data_update);
        if ($res) {
            $this->_log_audit('UPDATE_BERITA_ACARA', 'Memperbarui dokumen Berita Acara No. ' . $no_ba);
            return array('status' => TRUE, 'message' => 'Dokumen Berita Acara berhasil diperbarui.');
        }

        return array('status' => FALSE, 'message' => 'Gagal memperbarui Berita Acara.');
    }

    /**
     * Menghapus atau mengarsipkan Berita Acara.
     * 
     * @param int $id_laporan
     * @return array
     */
    public function delete_laporan($id_laporan)
    {
        $id = (int)$id_laporan;
        if ($id <= 0) {
            return array('status' => FALSE, 'message' => 'ID Berita Acara tidak valid.');
        }

        $existing = $this->CI->Laporan_model->get_laporan_by_id($id);
        if (!$existing) {
            return array('status' => FALSE, 'message' => 'Dokumen Berita Acara tidak ditemukan.');
        }

        $res = $this->CI->Laporan_model->delete_laporan($id);
        if ($res) {
            $this->_log_audit('HAPUS_BERITA_ACARA', 'Menghapus dokumen Berita Acara No. ' . $existing['no_ba']);
            return array('status' => TRUE, 'message' => 'Dokumen Berita Acara berhasil dihapus.');
        }

        return array('status' => FALSE, 'message' => 'Gagal menghapus dokumen Berita Acara.');
    }

    /**
     * Mengekspor Berita Acara ke format Microsoft Word (.docx).
     * 
     * @param int $id_laporan
     * @return void
     */
    public function export_berita_acara($id_laporan)
    {
        $id = (int)$id_laporan;
        if ($id <= 0) {
            show_error('ID Berita Acara tidak valid.', 400, 'Export Error');
        }

        $laporan = $this->get_laporan_detail($id);
        if (!$laporan) {
            show_error('Data Berita Acara tidak ditemukan.', 404, 'Export Error');
        }

        $settings    = $this->CI->setting_service->get_settings();
        $satker      = $settings['satker'];
        $pimpinan    = $settings['pimpinan'];
        $tim_penilai = isset($laporan['tim_penilai']) ? $laporan['tim_penilai'] : array();

        $this->CI->export_word_service->export_berita_acara($laporan, $satker, $pimpinan, $tim_penilai);
    }

    /**
     * Mengekspor Berita Acara langsung dari Sesi Proses TOPSIS (meskipun belum di-insert manual).
     * 
     * @param int $id_proses
     * @return void
     */
    public function export_berita_acara_proses($id_proses)
    {
        $id_p = (int)$id_proses;
        if ($id_p <= 0) {
            show_error('ID Sesi TOPSIS tidak valid.', 400, 'Export Error');
        }

        // Cek apakah sudah ada di laporan_ba
        $laporan = $this->CI->Laporan_model->get_laporan_by_proses($id_p);
        if ($laporan) {
            $this->export_berita_acara($laporan['id_laporan']);
            return;
        }

        // Jika belum tersimpan di laporan_ba, konstruksi data on-the-fly
        $proses = $this->CI->Topsis_model->get_proses_by_id($id_p);
        if (!$proses) {
            show_error('Sesi kalkulasi TOPSIS tidak ditemukan.', 404, 'Export Error');
        }

        $candidates = $this->CI->Laporan_model->get_all_ranked_candidates($id_p);
        if (empty($candidates)) {
            show_error('Sesi TOPSIS ini belum memiliki hasil perankingan. Silakan jalankan proses perhitungan TOPSIS terlebih dahulu.', 400, 'Export Error');
        }

        $settings = $this->CI->setting_service->get_settings();
        $satker   = $settings['satker'];
        $app      = $settings['app'];

        $sk_aktif = $this->CI->tim_penilai_service->get_active_sk();
        $id_sk    = $sk_aktif ? (int)$sk_aktif['id_sk'] : NULL;
        $tim_p    = $sk_aktif ? $sk_aktif : array();

        $bulan_romawi = $this->_get_bulan_romawi((int)date('n'));
        $no_ba = $this->CI->Laporan_model->generate_nomor_ba(
            !empty($app['format_nomor_ba']) ? $app['format_nomor_ba'] : '',
            !empty($satker['kode_wilayah']) ? $satker['kode_wilayah'] : 'W2.U4',
            $bulan_romawi,
            date('Y')
        );

        $winner = $candidates[0];

        $laporan_data = array(
            'no_ba'          => $no_ba,
            'id_proses'      => $id_p,
            'id_periode'     => (int)$proses['id_periode'],
            'nama_periode'   => $proses['nama_periode'],
            'kategori'       => $proses['kategori'],
            'pemenang_nama'  => $winner['nama'],
            'pemenang_nip'   => $winner['nip'],
            'skor_topsis'    => (float)$winner['skor'],
            'tanggal_terbit' => date('Y-m-d'),
            'status'         => 'Disahkan',
            'ketua_panitia'  => $tim_p && !empty($tim_p['ketua']) ? $tim_p['ketua']['nama'] : (!empty($satker['nama_ketua']) ? $satker['nama_ketua'] : ''),
            'no_sk'          => $tim_p && !empty($tim_p['no_sk']) ? $tim_p['no_sk'] : '',
            'all_candidates' => $candidates,
            'top_3'          => array_slice($candidates, 0, 3)
        );

        $this->CI->export_word_service->export_berita_acara($laporan_data, $satker, $settings['pimpinan'], $tim_p);
    }

    /**
     * Mengambil data lengkap Showroom Pratinjau TOPSIS (Kandidat Teratas, Nilai Preferensi,
     * Jarak Solusi Positif/Negatif, dan Rincian Evaluasi Kriteria) untuk Modal & Page Showroom.
     * 
     * @param mixed $id_target ID Laporan (laporan_X) atau ID Proses TOPSIS (proses_X / integer)
     * @return array
     */
    public function get_showroom_data($id_target = 0)
    {
        $id_str = (string)$id_target;
        $id_clean = (int)preg_replace('/[^0-9]/', '', $id_str);

        $id_proses  = 0;
        $id_laporan = 0;
        $laporan    = NULL;
        $proses     = NULL;

        if (strpos($id_str, 'laporan_') !== false || ($id_clean > 0 && strpos($id_str, 'proses_') === false)) {
            $laporan = $this->CI->Laporan_model->get_laporan_by_id($id_clean);
            if ($laporan) {
                $id_laporan = (int)$laporan['id_laporan'];
                $id_proses  = (int)$laporan['id_proses'];
            }
        }

        if (!$id_proses && (strpos($id_str, 'proses_') !== false || $id_clean > 0)) {
            $proses = $this->CI->Topsis_model->get_proses_by_id($id_clean);
            if ($proses) {
                $id_proses = (int)$proses['id_proses'];
            }
        }

        if (!$id_proses) {
            // Fallback: cari sesi proses TOPSIS final teranyar
            $avail = $this->CI->Laporan_model->get_available_topsis_proses();
            if (!empty($avail)) {
                $id_proses = (int)$avail[0]['id_proses'];
            }
        }

        if (!$id_proses) {
            return array(
                'status'  => FALSE,
                'message' => 'Belum ada sesi penilaian TOPSIS dengan hasil perankingan final yang tersedia.'
            );
        }

        if (!$proses) {
            $proses = $this->CI->Topsis_model->get_proses_by_id($id_proses);
        }

        $candidates    = $this->CI->Laporan_model->get_all_ranked_candidates($id_proses);
        $kriteria_list = $this->CI->Topsis_model->get_kriteria_by_proses($id_proses);
        $matrix        = $this->CI->Topsis_model->get_penilaian_matrix($id_proses);

        // Ambil top 3 kandidat
        $top_3 = array_slice($candidates, 0, 3);

        // Palet warna progress bar kriteria dinamis
        $progress_colors = array('bg-primary', 'bg-info', 'bg-success', 'bg-warning', 'bg-danger', 'bg-secondary', 'bg-dark');

        // Lengkapi setiap kandidat dengan nilai kriteria
        foreach ($top_3 as &$cand) {
            $alt_id = isset($cand['id_proses_alternatif']) ? (int)$cand['id_proses_alternatif'] : 0;
            if (!$alt_id) {
                $alt_row = $this->CI->db->get_where('topsis_proses_alternatif', array(
                    'id_proses'     => $id_proses,
                    'nama_snapshot' => $cand['nama']
                ))->row_array();
                $alt_id = $alt_row ? (int)$alt_row['id_proses_alternatif'] : 0;
            }

            $cand_kriteria = array();
            $total_score_sum = 0;
            foreach ($kriteria_list as $k_idx => $kr) {
                $kr_id = (int)$kr['id_proses_kriteria'];
                $val   = isset($matrix[$alt_id][$kr_id]) ? (float)$matrix[$alt_id][$kr_id] : 0.0;
                $color = isset($progress_colors[$k_idx % count($progress_colors)]) ? $progress_colors[$k_idx % count($progress_colors)] : 'bg-primary';

                $cand_kriteria[] = array(
                    'id_proses_kriteria' => $kr_id,
                    'kode'               => $kr['kode'],
                    'nama'               => $kr['nama_kriteria'],
                    'bobot'              => (float)$kr['bobot'],
                    'tipe_atribut'       => $kr['tipe_atribut'],
                    'nilai'              => $val,
                    'color'              => $color
                );
                $total_score_sum += $val;
            }

            // Hitung persentase untuk progress bar stacked
            foreach ($cand_kriteria as &$ck) {
                $ck['percent'] = ($total_score_sum > 0) ? round(($ck['nilai'] / $total_score_sum) * 100, 1) : round(100 / max(1, count($cand_kriteria)), 1);
            }

            $cand['kriteria_scores'] = $cand_kriteria;
        }

        return array(
            'status'       => TRUE,
            'id_proses'    => $id_proses,
            'id_laporan'   => $id_laporan,
            'nama_periode' => !empty($proses['nama_periode']) ? $proses['nama_periode'] : 'Periode Penilaian',
            'kategori'     => !empty($proses['kategori']) ? $proses['kategori'] : 'Semua',
            'tahun'        => !empty($proses['tahun']) ? $proses['tahun'] : date('Y'),
            'kriteria'     => $kriteria_list,
            'candidates'   => $top_3
        );
    }

    /**
     * Mengambil statistik KPI untuk view Laporan & Berita Acara.
     * 
     * @return array
     */
    public function get_stats()
    {
        return $this->CI->Laporan_model->get_stats();
    }

    /**
     * Helper konversi angka bulan ke Romawi (I s/d XII).
     * 
     * @param int $month
     * @return string
     */
    private function _get_bulan_romawi($month)
    {
        $romawi = array(
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        );
        return isset($romawi[$month]) ? $romawi[$month] : 'VIII';
    }

    /**
     * Helper audit trail logging.
     * 
     * @param string $action
     * @param string $details
     * @return void
     */
    private function _log_audit($action, $details)
    {
        if (isset($this->CI->audit_service)) {
            @$this->CI->audit_service->log_activity(
                $this->CI->session->userdata('user_id') ? $this->CI->session->userdata('user_id') : 1,
                $this->CI->session->userdata('username') ? $this->CI->session->userdata('username') : 'System',
                $this->CI->session->userdata('role') ? $this->CI->session->userdata('role') : 'Administrator',
                $action,
                $details,
                $this->CI->input->ip_address()
            );
        }
    }
}
