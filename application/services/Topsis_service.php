<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Topsis_service
 * 
 * Service Layer untuk Penilaian Kinerja & Sistem Pendukung Keputusan (SPK) TOPSIS.
 * Menghubungkan Controller dengan Model dan Algoritma Matematis TOPSIS.
 * 
 * Prinsip Desain:
 * 1. Clean Architecture: Seluruh logika bisnis, validasi, orkestrasian kalkulasi,
 *    dan rekam jejak audit (Audit Trail) terpusat di service ini.
 * 2. Controller tetap tipis (Thin Controller) dan Model hanya menangani query basis data.
 * 3. Mesin matematis TOPSIS murni didelegasikan ke Topsis_algorithm_service.
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Topsis_service
{
    /**
     * @var CI_Controller
     */
    protected $CI;

    /**
     * @var Topsis_algorithm_service
     */
    protected $algorithm_service;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Topsis_model');
        $this->CI->load->model('Periode_model');
        $this->CI->load->model('Pegawai_model');
        $this->CI->load->model('Kriteria_model');
        $this->CI->load->library('form_validation');

        // Load Topsis_algorithm_service
        require_once APPPATH . 'services/Topsis_algorithm_service.php';
        $this->algorithm_service = new Topsis_algorithm_service();

        // Optional Audit_service
        if (!isset($this->CI->audit_service)) {
            if (method_exists($this->CI->load, 'service')) {
                @$this->CI->load->service('audit_service');
            }
        }
    }

    /**
     * Mengambil daftar seluruh sesi penilaian TOPSIS untuk tampilan tabel utama.
     * 
     * @return array
     */
    public function get_sesi_list()
    {
        return $this->CI->Topsis_model->get_all_proses();
    }

    /**
     * Mengambil opsi periode penilaian aktif untuk modal buat sesi baru.
     * 
     * @return array
     */
    public function get_periode_options()
    {
        return $this->CI->Periode_model->get_all_periode();
    }

    /**
     * Mengambil opsi pegawai aktif untuk modal input nilai alternatif.
     * 
     * @param string|null $kategori
     * @return array
     */
    public function get_pegawai_options($kategori = NULL)
    {
        return $this->CI->Pegawai_model->get_all(TRUE);
    }

    /**
     * Membuat sesi penilaian baru (Status: DRAFT), menyalin snapshot kriteria,
     * dan menginisialisasi kandidat pegawai awal.
     * 
     * @param array $input Data dari $_POST
     * @return array Response payload
     */
    public function buat_sesi($input)
    {
        // Validasi Form
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('id_periode', 'Periode Penilaian', 'required|numeric');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $id_periode      = (int)$input['id_periode'];
        $kategori_target = isset($input['kategori_target']) ? trim($input['kategori_target']) : 'Semua';
        $catatan         = isset($input['catatan']) ? trim($input['catatan']) : '';
        $user_id         = (int)$this->CI->session->userdata('user_id');

        // Cek apakah periode valid
        $periode = $this->CI->Periode_model->get_periode_by_id($id_periode);
        if (!$periode) {
            return array('status' => FALSE, 'message' => 'Periode penilaian yang dipilih tidak ditemukan.');
        }

        // Siapkan data proses
        $data_proses = array(
            'id_periode'     => $id_periode,
            'kategori'       => ($kategori_target !== 'Semua') ? $kategori_target : NULL,
            'tanggal_proses' => NULL,
            'status'         => 'draft',
            'catatan'        => !empty($catatan) ? $catatan : 'Sesi Penilaian ' . $periode['nama_periode'],
            'created_by'     => ($user_id > 0) ? $user_id : 1,
            'created_at'     => date('Y-m-d H:i:s')
        );

        $this->CI->db->trans_start();

        $id_proses = $this->CI->Topsis_model->insert_proses($data_proses);
        if (!$id_proses) {
            $this->CI->db->trans_rollback();
            return array('status' => FALSE, 'message' => 'Gagal membuat sesi penilaian baru.');
        }

        // 1. Salin Snapshot Kriteria dari master kriteria
        $this->CI->Topsis_model->copy_master_kriteria_to_proses($id_proses, $kategori_target);

        // 2. Salin Snapshot Pegawai kandidat alternatif
        $this->CI->Topsis_model->copy_pegawai_to_proses_alternatif($id_proses, $kategori_target);

        $this->CI->db->trans_complete();

        if ($this->CI->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'message' => 'Gagal menginisialisasi kriteria dan alternatif sesi.');
        }

        $this->log_audit('Penilaian & TOPSIS', 'Membuat sesi penilaian baru untuk ' . $periode['nama_periode'] . ' (Status: Draft)');

        return array(
            'status'    => TRUE,
            'id_proses' => $id_proses,
            'message'   => 'Sesi penilaian untuk ' . $periode['nama_periode'] . ' berhasil dibuat (Status: Draft).'
        );
    }

    /**
     * Mengambil seluruh rincian detail sesi penilaian TOPSIS (Header, Kriteria,
     * Alternatif, Matriks X, Matriks Y, Solusi Ideal, dan Hasil Perankingan).
     * 
     * @param int $id_proses_or_periode ID proses atau ID periode
     * @return array Struktur data lengkap untuk view admin/proses_detail
     */
    public function get_detail_sesi($id_proses_or_periode)
    {
        $id = (int)$id_proses_or_periode;

        // Coba cari by id_proses terlebih dahulu
        $proses = $this->CI->Topsis_model->get_proses_by_id($id);
        if (!$proses) {
            // Fallback: cari by id_periode
            $proses = $this->CI->Topsis_model->get_proses_by_periode($id);
        }

        if (!$proses) {
            // Jika belum ada sama sekali, buat sesi draft otomatis untuk periode tersebut
            $periode = $this->CI->Periode_model->get_periode_by_id($id);
            if ($periode) {
                $create_res = $this->buat_sesi(array('id_periode' => $id, 'kategori_target' => 'Semua'));
                if ($create_res['status']) {
                    $proses = $this->CI->Topsis_model->get_proses_by_id($create_res['id_proses']);
                }
            }
        }

        if (!$proses) {
            return array('status' => FALSE, 'message' => 'Data sesi penilaian tidak ditemukan.');
        }

        $id_proses = (int)$proses['id_proses'];

        // 1. Ambil Kriteria Snapshot
        $kriteria_list = $this->CI->Topsis_model->get_kriteria_by_proses($id_proses);

        // 2. Ambil Alternatif Snapshot
        $alternatif_list = $this->CI->Topsis_model->get_alternatif_by_proses($id_proses);

        // 3. Ambil Matriks Penilaian Mentah (X)
        $penilaian_matrix = $this->CI->Topsis_model->get_penilaian_matrix($id_proses);

        // 4. Ambil Hasil TOPSIS tersimpan
        $hasil_topsis = $this->CI->Topsis_model->get_hasil_topsis($id_proses);

        // 5. Jika ada data alternatif dan kriteria, jalankan perhitungan matematis
        //    untuk mendapatkan matriks antara (Matriks X, R, Y, A+, A-)
        $calc_data = NULL;
        if (!empty($alternatif_list) && !empty($kriteria_list)) {
            $formatted_alts = array();
            foreach ($alternatif_list as $alt) {
                $formatted_alts[] = array(
                    'id'       => (int)$alt['id_proses_alternatif'],
                    'nama'     => $alt['nama_snapshot'],
                    'nip'      => $alt['nip_snapshot'],
                    'jabatan'  => $alt['jabatan_snapshot'],
                    'kategori' => $alt['kategori']
                );
            }

            $formatted_krits = array();
            foreach ($kriteria_list as $kr) {
                $formatted_krits[] = array(
                    'id'           => (int)$kr['id_proses_kriteria'],
                    'kode'         => $kr['kode'],
                    'nama'         => $kr['nama_kriteria'],
                    'bobot'        => (float)$kr['bobot'],
                    'tipe_atribut' => $kr['tipe_atribut'],
                    'jenis_data'   => $kr['jenis_data']
                );
            }

            try {
                $calc_data = $this->algorithm_service->calculate($formatted_alts, $formatted_krits, $penilaian_matrix);
            } catch (Exception $e) {
                $calc_data = NULL;
            }
        }

        // 6. Siapkan data KPI stats
        $stats = $this->CI->Topsis_model->get_stats($id_proses);

        // 7. Ambil opsi periode dan master pegawai
        $periode_options = $this->CI->Periode_model->get_all_periode();
        $pegawai_options = $this->CI->Pegawai_model->get_all(TRUE);

        return array(
            'status'               => TRUE,
            'periode_info'         => $proses,
            'id_proses'            => $id_proses,
            'kriteria_list'        => $kriteria_list,
            'alternatif_list'      => $alternatif_list,
            'penilaian_matrix'     => $penilaian_matrix,
            'hasil_topsis_pegawai' => !empty($hasil_topsis) ? $hasil_topsis : (isset($calc_data['rankings']) ? $calc_data['rankings'] : array()),
            'matrices'             => $calc_data,
            'stats'                => $stats,
            'periode_options'      => $periode_options,
            'pegawai_options'      => $pegawai_options
        );
    }

    /**
     * Menyimpan nilai evaluasi kriteria alternatif pegawai.
     * 
     * @param array $input Data POST
     * @return array Response payload
     */
    public function simpan_nilai_alternatif($input)
    {
        $id_proses            = !empty($input['id_proses']) ? (int)$input['id_proses'] : NULL;
        $id_proses_alternatif = !empty($input['id_proses_alternatif']) ? (int)$input['id_proses_alternatif'] : NULL;
        $id_pegawai           = !empty($input['id_pegawai']) ? (int)$input['id_pegawai'] : NULL;

        if (empty($id_proses)) {
            return array('status' => FALSE, 'message' => 'ID Sesi Penilaian tidak valid.');
        }

        // Jika id_proses_alternatif belum ada tapi ada id_pegawai, buatkan record alternatif
        if (empty($id_proses_alternatif) && !empty($id_pegawai)) {
            // Cek apakah alternatif sudah ada
            $existing_alt = $this->CI->db->where('id_proses', $id_proses)
                                         ->where('id_pegawai', $id_pegawai)
                                         ->get('topsis_proses_alternatif')
                                         ->row_array();
            if ($existing_alt) {
                $id_proses_alternatif = (int)$existing_alt['id_proses_alternatif'];
            } else {
                $id_proses_alternatif = $this->CI->Topsis_model->insert_alternatif_from_pegawai($id_proses, $id_pegawai);
            }
        }

        if (empty($id_proses_alternatif)) {
            return array('status' => FALSE, 'message' => 'Pegawai alternatif belum dipilih atau tidak valid.');
        }

        // Ambil daftar kriteria pada sesi ini
        $kriteria_list = $this->CI->Topsis_model->get_kriteria_by_proses($id_proses);
        if (empty($kriteria_list)) {
            return array('status' => FALSE, 'message' => 'Kriteria sesi penilaian tidak ditemukan.');
        }

        // Kumpulkan nilai kriteria dari POST input
        $scores = array();
        foreach ($kriteria_list as $index => $kr) {
            $krit_id = (int)$kr['id_proses_kriteria'];
            $key_id  = 'c_' . $krit_id;
            $key_idx = 'c' . ($index + 1);

            $val = NULL;
            if (isset($input[$key_id])) {
                $val = (float)$input[$key_id];
            } elseif (isset($input[$key_idx])) {
                $val = (float)$input[$key_idx];
            } elseif (isset($input['nilai_' . $krit_id])) {
                $val = (float)$input['nilai_' . $krit_id];
            }

            if ($val !== NULL) {
                $scores[$krit_id] = $val;
            }
        }

        if (empty($scores)) {
            return array('status' => FALSE, 'message' => 'Tidak ada nilai kriteria yang dikirimkan.');
        }

        // Simpan nilai ke tabel penilaian
        $saved = $this->CI->Topsis_model->save_alternatif_scores($id_proses, $id_proses_alternatif, $scores);
        if (!$saved) {
            return array('status' => FALSE, 'message' => 'Gagal menyimpan nilai kriteria ke database.');
        }

        $alt = $this->CI->db->get_where('topsis_proses_alternatif', array('id_proses_alternatif' => $id_proses_alternatif))->row_array();
        $nama_alt = $alt ? $alt['nama_snapshot'] : 'Alternatif #' . $id_proses_alternatif;

        $this->log_audit('Penilaian & TOPSIS', 'Menyimpan nilai kriteria untuk kandidat: ' . $nama_alt);

        return array(
            'status'  => TRUE,
            'message' => 'Nilai kriteria untuk ' . $nama_alt . ' berhasil disimpan.'
        );
    }

    /**
     * Memproses kalkulasi matematis TOPSIS lengkap dan memfinalisasi sesi proses.
     * 
     * @param int $id_proses
     * @return array Response payload dengan hasil ranking dan preferensi
     */
    public function proses_hitung_topsis($id_proses)
    {
        $id_proses = (int)$id_proses;
        if ($id_proses <= 0) {
            return array('status' => FALSE, 'message' => 'ID Sesi Penilaian tidak valid.');
        }

        $proses = $this->CI->Topsis_model->get_proses_by_id($id_proses);
        if (!$proses) {
            return array('status' => FALSE, 'message' => 'Data sesi proses tidak ditemukan.');
        }

        // 1. Ambil kriteria snapshot
        $kriteria_list = $this->CI->Topsis_model->get_kriteria_by_proses($id_proses);
        if (empty($kriteria_list)) {
            return array('status' => FALSE, 'message' => 'Kriteria penilaian belum dikonfigurasi untuk sesi ini.');
        }

        // 2. Ambil alternatif snapshot
        $alternatif_list = $this->CI->Topsis_model->get_alternatif_by_proses($id_proses);
        if (count($alternatif_list) < 2) {
            return array('status' => FALSE, 'message' => 'Diperlukan minimal 2 alternatif pegawai untuk menjalankan perankingan TOPSIS.');
        }

        // 3. Ambil matriks penilaian mentah
        $penilaian_matrix = $this->CI->Topsis_model->get_penilaian_matrix($id_proses);

        // Format data untuk Topsis_algorithm_service
        $formatted_alts = array();
        foreach ($alternatif_list as $alt) {
            $formatted_alts[] = array(
                'id'       => (int)$alt['id_proses_alternatif'],
                'nama'     => $alt['nama_snapshot'],
                'nip'      => $alt['nip_snapshot'],
                'jabatan'  => $alt['jabatan_snapshot'],
                'kategori' => $alt['kategori']
            );
        }

        $formatted_krits = array();
        foreach ($kriteria_list as $kr) {
            $formatted_krits[] = array(
                'id'           => (int)$kr['id_proses_kriteria'],
                'kode'         => $kr['kode'],
                'nama'         => $kr['nama_kriteria'],
                'bobot'        => (float)$kr['bobot'],
                'tipe_atribut' => $kr['tipe_atribut'],
                'jenis_data'   => $kr['jenis_data']
            );
        }

        // Jalankan Algoritma TOPSIS
        try {
            $calc_result = $this->algorithm_service->calculate($formatted_alts, $formatted_krits, $penilaian_matrix);
        } catch (Exception $e) {
            return array('status' => FALSE, 'message' => 'Kesalahan saat menghitung TOPSIS: ' . $e->getMessage());
        }

        // Simpan Hasil ke tabel hasil_topsis
        $this->CI->db->trans_start();

        $this->CI->Topsis_model->save_hasil_topsis_batch($id_proses, $calc_result['rankings']);

        // Update status proses menjadi FINAL
        $this->CI->Topsis_model->update_proses($id_proses, array(
            'status'         => 'final',
            'tanggal_proses' => date('Y-m-d H:i:s')
        ));

        $this->CI->db->trans_complete();

        if ($this->CI->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'message' => 'Gagal menyimpan hasil kalkulasi TOPSIS ke database.');
        }

        $winner_name = !empty($calc_result['winner']['nama']) ? $calc_result['winner']['nama'] : 'Pemenang';
        $winner_score = !empty($calc_result['winner']['nilai_preferensi']) ? number_format($calc_result['winner']['nilai_preferensi'], 4) : '0';

        $this->log_audit(
            'Penilaian & TOPSIS',
            'Memproses kalkulasi TOPSIS periode ' . $proses['nama_periode'] . ' ke status FINAL (Winner: ' . $winner_name . ' - Skor: ' . $winner_score . ')'
        );

        return array(
            'status'        => TRUE,
            'message'       => 'Perhitungan TOPSIS berhasil diproses! Pemenang Rank #1: ' . $winner_name . ' (Skor: ' . $winner_score . '). Status sesi resmi menjadi FINAL.',
            'winner'        => $calc_result['winner'],
            'rankings'      => $calc_result['rankings'],
            'status_topsis' => 'Final'
        );
    }

    /**
     * Menghapus sesi penilaian dan mereset seluruh kalkulasi.
     * 
     * @param int $id_proses
     * @return array
     */
    public function hapus_sesi($id_proses)
    {
        $id_proses = (int)$id_proses;
        if ($id_proses <= 0) {
            return array('status' => FALSE, 'message' => 'ID Sesi Penilaian tidak valid.');
        }

        $proses = $this->CI->Topsis_model->get_proses_by_id($id_proses);
        if (!$proses) {
            return array('status' => FALSE, 'message' => 'Data sesi proses tidak ditemukan.');
        }

        $deleted = $this->CI->Topsis_model->delete_proses($id_proses);
        if (!$deleted) {
            return array('status' => FALSE, 'message' => 'Gagal menghapus data sesi penilaian.');
        }

        $this->log_audit('Penilaian & TOPSIS', 'Menghapus sesi penilaian: ' . $proses['nama_periode']);

        return array(
            'status'  => TRUE,
            'message' => 'Sesi penilaian untuk ' . $proses['nama_periode'] . ' berhasil dihapus.'
        );
    }

    /**
     * Helper privat untuk mencatat log aktivitas sistem.
     * 
     * @param string $modul
     * @param string $aktivitas
     * @return void
     */
    private function log_audit($modul, $aktivitas)
    {
        if (isset($this->CI->audit_service)) {
            $user_id   = $this->CI->session->userdata('user_id');
            $username  = $this->CI->session->userdata('username');
            $nama_user = $this->CI->session->userdata('nama_lengkap');
            $role      = $this->CI->session->userdata('role');
            @$this->CI->audit_service->log_activity($modul, $aktivitas, 'Sukses', $user_id, $username, $nama_user, $role);
        }
    }
}
