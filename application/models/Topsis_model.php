<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Topsis_model
 * 
 * Data Access Layer untuk modul Penilaian & Sistem Pendukung Keputusan (SPK) TOPSIS.
 * Mengelola interaksi basis data pada tabel:
 * - topsis_proses (Header sesi penilaian)
 * - topsis_proses_kriteria (Snapshot kriteria per sesi)
 * - topsis_proses_alternatif (Snapshot alternatif pegawai per sesi)
 * - penilaian (Matriks keputusan X nilai mentah)
 * - hasil_topsis (Hasil perankingan, jarak D+/D-, dan preferensi Vi)
 * 
 * Sesuai prinsip Clean Code dan CodeIgniter 3 Query Builder.
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Topsis_model extends CI_Model
{
    protected $table_proses      = 'topsis_proses';
    protected $table_kriteria    = 'topsis_proses_kriteria';
    protected $table_alternatif  = 'topsis_proses_alternatif';
    protected $table_penilaian   = 'penilaian';
    protected $table_hasil       = 'hasil_topsis';
    protected $table_periode     = 'periode';
    protected $table_pegawai     = 'referensi_pegawai';
    protected $table_master_krit = 'kriteria';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // =========================================================================
    // 1. MANAJEMEN SESI PENILAIAN (topsis_proses)
    // =========================================================================

    /**
     * Mengambil seluruh daftar sesi penilaian TOPSIS beserta informasi periode,
     * jumlah kandidat terpenilai, pemenang rank #1, dan skor tertinggi.
     * 
     * @return array
     */
    public function get_all_proses()
    {
        $this->db->select('tp.*, p.nama_periode, p.jenis_periode, p.tahun, p.tanggal_mulai, p.tanggal_selesai, p.status AS status_periode');
        $this->db->from($this->table_proses . ' tp');
        $this->db->join($this->table_periode . ' p', 'tp.id_periode = p.id_periode', 'left');
        $this->db->order_by('tp.id_proses', 'DESC');
        $proses_list = $this->db->get()->result_array();

        foreach ($proses_list as &$row) {
            $id_proses = (int)$row['id_proses'];

            // Hitung jumlah alternatif kandidat dalam sesi ini
            $row['jumlah_terpenilai'] = $this->db->where('id_proses', $id_proses)
                                                 ->count_all_results($this->table_alternatif);

            // Ambil pemenang rank 1 jika sudah ada hasil TOPSIS
            $winner = $this->db->select('ht.*, pa.nama_snapshot, pa.nip_snapshot, pa.jabatan_snapshot')
                               ->from($this->table_hasil . ' ht')
                               ->join($this->table_alternatif . ' pa', 'ht.id_proses_alternatif = pa.id_proses_alternatif', 'left')
                               ->where('ht.id_proses', $id_proses)
                               ->where('ht.ranking', 1)
                               ->get()
                               ->row_array();

            if ($winner) {
                $row['pemenang_nama']     = $winner['nama_snapshot'];
                $row['pemenang_nip']      = $winner['nip_snapshot'];
                $row['pemenang_kategori'] = $winner['jabatan_snapshot'];
                $row['skor_tertinggi']    = (float)$winner['nilai_preferensi'];
            } else {
                $row['pemenang_nama']     = '-';
                $row['pemenang_nip']      = '-';
                $row['pemenang_kategori'] = '-';
                $row['skor_tertinggi']    = 0.0;
            }

            // Normalisasi status TOPSIS untuk tampilan (Final / Draft)
            $row['status_topsis'] = (strtolower($row['status']) === 'final') ? 'Final' : 'Draft';
            $row['tanggal_kalkulasi'] = !empty($row['tanggal_proses']) ? $row['tanggal_proses'] : $row['created_at'];
        }

        return $proses_list;
    }

    /**
     * Mengambil data single sesi proses berdasarkan primary key id_proses.
     * 
     * @param int $id_proses
     * @return array|null
     */
    public function get_proses_by_id($id_proses)
    {
        $this->db->select('tp.*, p.nama_periode, p.jenis_periode, p.tahun, p.tanggal_mulai, p.tanggal_selesai, p.status AS status_periode');
        $this->db->from($this->table_proses . ' tp');
        $this->db->join($this->table_periode . ' p', 'tp.id_periode = p.id_periode', 'left');
        $this->db->where('tp.id_proses', (int)$id_proses);
        $row = $this->db->get()->row_array();

        if ($row) {
            $row['status_topsis'] = (strtolower($row['status']) === 'final') ? 'Final' : 'Draft';
            $row['tanggal_kalkulasi'] = !empty($row['tanggal_proses']) ? $row['tanggal_proses'] : $row['created_at'];
        }

        return $row;
    }

    /**
     * Mengambil data sesi proses berdasarkan id_periode (atau membuat draft otomatis jika belum ada).
     * 
     * @param int $id_periode
     * @return array|null
     */
    public function get_proses_by_periode($id_periode)
    {
        $this->db->select('tp.*, p.nama_periode, p.jenis_periode, p.tahun, p.tanggal_mulai, p.tanggal_selesai, p.status AS status_periode');
        $this->db->from($this->table_proses . ' tp');
        $this->db->join($this->table_periode . ' p', 'tp.id_periode = p.id_periode', 'left');
        $this->db->where('tp.id_periode', (int)$id_periode);
        $this->db->order_by('tp.id_proses', 'DESC');
        $row = $this->db->get()->row_array();

        if ($row) {
            $row['status_topsis'] = (strtolower($row['status']) === 'final') ? 'Final' : 'Draft';
            $row['tanggal_kalkulasi'] = !empty($row['tanggal_proses']) ? $row['tanggal_proses'] : $row['created_at'];
        }

        return $row;
    }

    /**
     * Membuat record sesi penilaian baru pada tabel topsis_proses.
     * 
     * @param array $data
     * @return int|bool Insert ID atau FALSE
     */
    public function insert_proses($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        $success = $this->db->insert($this->table_proses, $data);
        return $success ? $this->db->insert_id() : FALSE;
    }

    /**
     * Mengupdate record sesi penilaian.
     * 
     * @param int   $id_proses
     * @param array $data
     * @return bool
     */
    public function update_proses($id_proses, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id_proses', (int)$id_proses);
        return $this->db->update($this->table_proses, $data);
    }

    /**
     * Menghapus sesi penilaian dan cascading seluruh tabel terkait.
     * 
     * @param int $id_proses
     * @return bool
     */
    public function delete_proses($id_proses)
    {
        $id = (int)$id_proses;
        $this->db->trans_start();
        $this->db->where('id_proses', $id)->delete($this->table_hasil);
        $this->db->where('id_proses', $id)->delete($this->table_penilaian);
        $this->db->where('id_proses', $id)->delete($this->table_alternatif);
        $this->db->where('id_proses', $id)->delete($this->table_kriteria);
        $this->db->where('id_proses', $id)->delete($this->table_proses);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // =========================================================================
    // 2. MANAJEMEN SNAPSHOT KRITERIA (topsis_proses_kriteria)
    // =========================================================================

    /**
     * Mengambil daftar kriteria snapshot untuk sesi proses tertentu.
     * 
     * @param int $id_proses
     * @return array
     */
    public function get_kriteria_by_proses($id_proses)
    {
        $this->db->from($this->table_kriteria);
        $this->db->where('id_proses', (int)$id_proses);
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('id_proses_kriteria', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Menyalin kriteria aktif dari master tabel kriteria ke snapshot topsis_proses_kriteria.
     * 
     * @param int         $id_proses
     * @param string|null $kategori Filter kategori ('Hakim', 'Panitera Pengganti', 'Jurusita', 'Staf', atau NULL/Semua)
     * @return int Jumlah kriteria yang disalin
     */
    public function copy_master_kriteria_to_proses($id_proses, $kategori = NULL)
    {
        $this->db->from($this->table_master_krit);
        $this->db->where('aktif', 1);
        if (!empty($kategori) && strtolower($kategori) !== 'semua') {
            $this->db->where('kategori', $kategori);
        }
        $this->db->order_by('urutan', 'ASC');
        $master_kriteria = $this->db->get()->result_array();

        if (empty($master_kriteria)) {
            // Fallback: ambil semua kriteria aktif jika filter kategori tidak menghasilkan data
            $this->db->from($this->table_master_krit);
            $this->db->where('aktif', 1);
            $this->db->order_by('urutan', 'ASC');
            $master_kriteria = $this->db->get()->result_array();
        }

        $inserted = 0;
        foreach ($master_kriteria as $mk) {
            $snapshot_data = array(
                'id_proses'       => (int)$id_proses,
                'ref_kriteria_id' => (int)$mk['id_kriteria'],
                'kode'            => $mk['kode'],
                'nama_kriteria'   => $mk['nama_kriteria'],
                'jenis_data'      => $mk['jenis_data'],
                'tipe_atribut'    => $mk['tipe_atribut'],
                'bobot'           => $mk['bobot'],
                'urutan'          => $mk['urutan'],
                'created_at'      => date('Y-m-d H:i:s')
            );
            if ($this->db->insert($this->table_kriteria, $snapshot_data)) {
                $inserted++;
            }
        }

        return $inserted;
    }

    // =========================================================================
    // 3. MANAJEMEN SNAPSHOT ALTERNATIF (topsis_proses_alternatif)
    // =========================================================================

    /**
     * Mengambil daftar alternatif kandidat pegawai pada sesi proses.
     * 
     * @param int $id_proses
     * @return array
     */
    public function get_alternatif_by_proses($id_proses)
    {
        $this->db->select('pa.*, rp.kategori, rp.foto');
        $this->db->from($this->table_alternatif . ' pa');
        $this->db->join($this->table_pegawai . ' rp', 'pa.id_pegawai = rp.id_pegawai', 'left');
        $this->db->where('pa.id_proses', (int)$id_proses);
        $this->db->order_by('pa.id_proses_alternatif', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Menambahkan single kandidat pegawai ke snapshot alternatif.
     * 
     * @param int $id_proses
     * @param int $id_pegawai
     * @return int|bool ID alternatif baru atau FALSE
     */
    public function insert_alternatif_from_pegawai($id_proses, $id_pegawai)
    {
        // Cek apakah sudah ada di sesi ini
        $exists = $this->db->where('id_proses', (int)$id_proses)
                           ->where('id_pegawai', (int)$id_pegawai)
                           ->count_all_results($this->table_alternatif);
        if ($exists > 0) {
            return FALSE;
        }

        $pegawai = $this->db->get_where($this->table_pegawai, array('id_pegawai' => (int)$id_pegawai))->row_array();
        if (!$pegawai) {
            return FALSE;
        }

        $data = array(
            'id_proses'         => (int)$id_proses,
            'id_pegawai'        => (int)$pegawai['id_pegawai'],
            'nip_snapshot'      => $pegawai['nip'],
            'nama_snapshot'     => $pegawai['nama'],
            'pangkat_snapshot'  => $pegawai['pangkat'],
            'golongan_snapshot' => $pegawai['golongan'],
            'jabatan_snapshot'  => $pegawai['jabatan'],
            'created_at'        => date('Y-m-d H:i:s')
        );

        $this->db->insert($this->table_alternatif, $data);
        return $this->db->insert_id();
    }

    /**
     * Menyalin seluruh pegawai aktif ke snapshot alternatif proses.
     * 
     * @param int         $id_proses
     * @param string|null $kategori
     * @return int Jumlah alternatif yang disalin
     */
    public function copy_pegawai_to_proses_alternatif($id_proses, $kategori = NULL)
    {
        $this->db->from($this->table_pegawai);
        $this->db->where('aktif', 1);
        if (!empty($kategori) && strtolower($kategori) !== 'semua') {
            $this->db->where('kategori', $kategori);
        }
        $this->db->order_by('id_pegawai', 'ASC');
        $pegawai_list = $this->db->get()->result_array();

        $inserted = 0;
        foreach ($pegawai_list as $p) {
            $ins_id = $this->insert_alternatif_from_pegawai($id_proses, $p['id_pegawai']);
            if ($ins_id) {
                $inserted++;
            }
        }

        return $inserted;
    }

    /**
     * Menghapus alternatif dari sesi proses beserta nilai dan hasil terkait.
     * 
     * @param int $id_proses_alternatif
     * @return bool
     */
    public function delete_alternatif($id_proses_alternatif)
    {
        $id = (int)$id_proses_alternatif;
        $this->db->trans_start();
        $this->db->where('id_proses_alternatif', $id)->delete($this->table_hasil);
        $this->db->where('id_proses_alternatif', $id)->delete($this->table_penilaian);
        $this->db->where('id_proses_alternatif', $id)->delete($this->table_alternatif);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // =========================================================================
    // 4. MANAJEMEN MATRIKS PENILAIAN (penilaian)
    // =========================================================================

    /**
     * Mengambil matriks penilaian mentah X untuk sesi proses tertentu.
     * 
     * @param int $id_proses
     * @return array Matriks terformat: [id_proses_alternatif => [id_proses_kriteria => nilai]]
     */
    public function get_penilaian_matrix($id_proses)
    {
        $this->db->from($this->table_penilaian);
        $this->db->where('id_proses', (int)$id_proses);
        $rows = $this->db->get()->result_array();

        $matrix = array();
        foreach ($rows as $r) {
            $alt_id  = (int)$r['id_proses_alternatif'];
            $krit_id = (int)$r['id_proses_kriteria'];
            $matrix[$alt_id][$krit_id] = (float)$r['nilai'];
        }

        return $matrix;
    }

    /**
     * Menyimpan atau mengupdate nilai alternatif per kriteria ke tabel penilaian.
     * 
     * @param int   $id_proses
     * @param int   $id_proses_alternatif
     * @param int   $id_proses_kriteria
     * @param float $nilai
     * @param int|null $id_pegawai
     * @param int|null $id_kriteria
     * @return bool
     */
    public function save_single_penilaian($id_proses, $id_proses_alternatif, $id_proses_kriteria, $nilai, $id_pegawai = NULL, $id_kriteria = NULL)
    {
        $id_proses            = (int)$id_proses;
        $id_proses_alternatif = (int)$id_proses_alternatif;
        $id_proses_kriteria   = (int)$id_proses_kriteria;
        $nilai                = (float)$nilai;

        // Cek apakah record sudah ada
        $existing = $this->db->where('id_proses_alternatif', $id_proses_alternatif)
                             ->where('id_proses_kriteria', $id_proses_kriteria)
                             ->get($this->table_penilaian)
                             ->row_array();

        if ($existing) {
            $this->db->where('id_penilaian', $existing['id_penilaian']);
            return $this->db->update($this->table_penilaian, array(
                'nilai'      => $nilai,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        } else {
            return $this->db->insert($this->table_penilaian, array(
                'id_proses'            => $id_proses,
                'id_proses_alternatif' => $id_proses_alternatif,
                'id_proses_kriteria'   => $id_proses_kriteria,
                'id_pegawai'           => $id_pegawai,
                'id_kriteria'          => $id_kriteria,
                'nilai'                => $nilai,
                'created_at'           => date('Y-m-d H:i:s')
            ));
        }
    }

    /**
     * Menyimpan batch nilai kriteria untuk satu alternatif.
     * 
     * @param int   $id_proses
     * @param int   $id_proses_alternatif
     * @param array $scores Array format [id_proses_kriteria => nilai]
     * @return bool
     */
    public function save_alternatif_scores($id_proses, $id_proses_alternatif, array $scores)
    {
        $id_proses            = (int)$id_proses;
        $id_proses_alternatif = (int)$id_proses_alternatif;

        // Ambil info alternatif untuk mendapatkan id_pegawai
        $alt = $this->db->get_where($this->table_alternatif, array('id_proses_alternatif' => $id_proses_alternatif))->row_array();
        $id_pegawai = $alt ? (int)$alt['id_pegawai'] : NULL;

        $this->db->trans_start();
        foreach ($scores as $id_proses_kriteria => $nilai) {
            // Ambil info ref_kriteria_id
            $krit = $this->db->get_where($this->table_kriteria, array('id_proses_kriteria' => (int)$id_proses_kriteria))->row_array();
            $id_kriteria = $krit ? (int)$krit['ref_kriteria_id'] : NULL;

            $this->save_single_penilaian($id_proses, $id_proses_alternatif, $id_proses_kriteria, $nilai, $id_pegawai, $id_kriteria);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // =========================================================================
    // 5. MANAJEMEN HASIL KALKULASI TOPSIS (hasil_topsis)
    // =========================================================================

    /**
     * Mengambil daftar hasil perankingan TOPSIS untuk sesi proses tertentu.
     * 
     * @param int $id_proses
     * @return array
     */
    public function get_hasil_topsis($id_proses)
    {
        $this->db->select('ht.*, pa.nama_snapshot AS nama_pegawai, pa.nip_snapshot AS nip, pa.jabatan_snapshot AS jabatan, rp.kategori, rp.foto');
        $this->db->from($this->table_hasil . ' ht');
        $this->db->join($this->table_alternatif . ' pa', 'ht.id_proses_alternatif = pa.id_proses_alternatif', 'left');
        $this->db->join($this->table_pegawai . ' rp', 'ht.id_pegawai = rp.id_pegawai', 'left');
        $this->db->where('ht.id_proses', (int)$id_proses);
        $this->db->order_by('ht.ranking', 'ASC');
        $rows = $this->db->get()->result_array();

        // Format field untuk view kompatibilitas
        foreach ($rows as &$r) {
            $r['id_penilaian'] = $r['id_hasil'];
            $r['d_plus']       = (float)$r['d_positif'];
            $r['d_minus']      = (float)$r['d_negatif'];
            $r['skor_topsis']  = (float)$r['nilai_preferensi'];
            $r['peringkat']    = (int)$r['ranking'];
        }

        return $rows;
    }

    /**
     * Menyimpan batch hasil kalkulasi TOPSIS ke tabel hasil_topsis.
     * 
     * @param int   $id_proses
     * @param array $rankings Array ranking dari Topsis_algorithm_service::calculate()
     * @return bool
     */
    public function save_hasil_topsis_batch($id_proses, array $rankings)
    {
        $id_proses = (int)$id_proses;

        $this->db->trans_start();

        // Bersihkan hasil lama jika ada
        $this->db->where('id_proses', $id_proses)->delete($this->table_hasil);

        $batch_data = array();
        foreach ($rankings as $item) {
            // Ambil id_pegawai dari tabel alternatif
            $alt_id = (int)$item['id'];
            $alt = $this->db->get_where($this->table_alternatif, array('id_proses_alternatif' => $alt_id))->row_array();
            $id_peg = $alt ? (int)$alt['id_pegawai'] : NULL;

            $batch_data[] = array(
                'id_proses'            => $id_proses,
                'id_proses_alternatif' => $alt_id,
                'id_pegawai'           => $id_peg,
                'd_positif'            => (float)$item['d_plus'],
                'd_negatif'            => (float)$item['d_minus'],
                'nilai_preferensi'     => (float)$item['nilai_preferensi'],
                'ranking'              => (int)$item['ranking'],
                'created_at'           => date('Y-m-d H:i:s')
            );
        }

        if (!empty($batch_data)) {
            $this->db->insert_batch($this->table_hasil, $batch_data);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // =========================================================================
    // 6. STATISTIK KPI UNTUK VIEW
    // =========================================================================

    /**
     * Mengambil statistik ringkasan 4 KPI card untuk halaman detail proses.
     * 
     * @param int $id_proses
     * @return array
     */
    public function get_stats($id_proses)
    {
        $id_proses = (int)$id_proses;
        $total_alternatif = $this->db->where('id_proses', $id_proses)->count_all_results($this->table_alternatif);

        $winner = $this->db->select('ht.*, pa.nama_snapshot')
                           ->from($this->table_hasil . ' ht')
                           ->join($this->table_alternatif . ' pa', 'ht.id_proses_alternatif = pa.id_proses_alternatif', 'left')
                           ->where('ht.id_proses', $id_proses)
                           ->where('ht.ranking', 1)
                           ->get()
                           ->row_array();

        $proses = $this->get_proses_by_id($id_proses);

        return array(
            'total_terpenilai' => $total_alternatif,
            'skor_tertinggi'   => $winner ? number_format($winner['nilai_preferensi'], 4) : '0.0000',
            'pemenang_singkat' => $winner ? $winner['nama_snapshot'] : '-',
            'periode_label'    => $proses ? $proses['nama_periode'] : 'TW II 2026',
            'tahun'            => $proses ? $proses['tahun'] : date('Y'),
            'status_topsis'    => $proses ? $proses['status_topsis'] : 'Draft'
        );
    }
}
