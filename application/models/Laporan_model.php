<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Laporan_model
 * 
 * Data Access Layer untuk modul Laporan & Berita Acara Penetapan Reward TOPSIS.
 * Mengelola interaksi basis data pada tabel:
 * - laporan_ba (Header dokumen Berita Acara)
 * - topsis_proses (Sesi perhitungan TOPSIS terkait)
 * - periode (Periode penilaian terkait)
 * - tim_penilai_sk (SK Tim Penilai terkait)
 * - hasil_topsis & topsis_proses_alternatif (Hasil skor preferensi & perankingan)
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Laporan_model extends CI_Model
{
    protected $table_laporan     = 'laporan_ba';
    protected $table_proses      = 'topsis_proses';
    protected $table_periode     = 'periode';
    protected $table_sk          = 'tim_penilai_sk';
    protected $table_hasil       = 'hasil_topsis';
    protected $table_alternatif  = 'topsis_proses_alternatif';
    protected $table_pegawai     = 'referensi_pegawai';
    protected $primary_key       = 'id_laporan';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil seluruh daftar Berita Acara beserta informasi periode,
     * SK Tim Penilai, dan top 3 kandidat hasil TOPSIS.
     * 
     * @param array $filter Filter opsional (status, kategori, id_periode)
     * @return array
     */
    public function get_all_laporan(array $filter = array())
    {
        $this->db->select('l.*, p.nama_periode, p.jenis_periode, p.tahun, sk.no_sk, sk.perihal AS perihal_sk');
        $this->db->from($this->table_laporan . ' l');
        $this->db->join($this->table_periode . ' p', 'l.id_periode = p.id_periode', 'left');
        $this->db->join($this->table_sk . ' sk', 'l.id_sk = sk.id_sk', 'left');

        if (!empty($filter['status'])) {
            $this->db->where('l.status', $filter['status']);
        }
        if (!empty($filter['kategori'])) {
            $this->db->where('l.kategori', $filter['kategori']);
        }
        if (!empty($filter['id_periode'])) {
            $this->db->where('l.id_periode', (int)$filter['id_periode']);
        }

        $this->db->order_by('l.tanggal_terbit', 'DESC');
        $this->db->order_by('l.id_laporan', 'DESC');
        $list = $this->db->get()->result_array();

        foreach ($list as &$row) {
            $id_proses = (int)$row['id_proses'];
            $row['top_3'] = $this->get_top_candidates($id_proses, 3);
        }

        return $list;
    }

    /**
     * Mengambil detail satu data Berita Acara berdasarkan ID.
     * 
     * @param int $id_laporan
     * @return array|null
     */
    public function get_laporan_by_id($id_laporan)
    {
        $id = (int)$id_laporan;
        if ($id <= 0) {
            return NULL;
        }

        $this->db->select('l.*, p.nama_periode, p.jenis_periode, p.tahun, p.tanggal_mulai, p.tanggal_selesai, sk.no_sk, sk.perihal AS perihal_sk, sk.tanggal_sk, tp.catatan AS catatan_proses');
        $this->db->from($this->table_laporan . ' l');
        $this->db->join($this->table_periode . ' p', 'l.id_periode = p.id_periode', 'left');
        $this->db->join($this->table_sk . ' sk', 'l.id_sk = sk.id_sk', 'left');
        $this->db->join($this->table_proses . ' tp', 'l.id_proses = tp.id_proses', 'left');
        $this->db->where('l.id_laporan', $id);
        $row = $this->db->get()->row_array();

        if (!$row) {
            return NULL;
        }

        $id_proses = (int)$row['id_proses'];
        $row['top_3']         = $this->get_top_candidates($id_proses, 3);
        $row['all_candidates'] = $this->get_all_ranked_candidates($id_proses);

        return $row;
    }

    /**
     * Mengambil data Berita Acara berdasarkan ID Proses TOPSIS.
     * 
     * @param int $id_proses
     * @return array|null
     */
    public function get_laporan_by_proses($id_proses)
    {
        $id = (int)$id_proses;
        if ($id <= 0) {
            return NULL;
        }

        return $this->db->get_where($this->table_laporan, array('id_proses' => $id))->row_array();
    }

    /**
     * Mengambil kandidat terbaik teratas (misalnya Top 3) dari sesi TOPSIS.
     * 
     * @param int $id_proses
     * @param int $limit
     * @return array
     */
    public function get_top_candidates($id_proses, $limit = 3)
    {
        $id = (int)$id_proses;
        if ($id <= 0) {
            return array();
        }

        $this->db->select('ht.ranking AS rank, ht.d_positif AS dplus, ht.d_negatif AS dminus, ht.nilai_preferensi AS skor, pa.nama_snapshot AS nama, pa.nip_snapshot AS nip, pa.jabatan_snapshot AS jabatan, pa.pangkat_snapshot AS pangkat, pa.golongan_snapshot AS golongan, rp.kategori, rp.foto');
        $this->db->from($this->table_hasil . ' ht');
        $this->db->join($this->table_alternatif . ' pa', 'ht.id_proses_alternatif = pa.id_proses_alternatif', 'left');
        $this->db->join($this->table_pegawai . ' rp', 'ht.id_pegawai = rp.id_pegawai', 'left');
        $this->db->where('ht.id_proses', $id);
        $this->db->order_by('ht.ranking', 'ASC');
        $this->db->limit((int)$limit);
        $rows = $this->db->get()->result_array();

        foreach ($rows as &$r) {
            $r['rank']     = (int)$r['rank'];
            $r['skor']     = (float)$r['skor'];
            $r['dplus']    = (float)$r['dplus'];
            $r['dminus']   = (float)$r['dminus'];
            $r['kategori'] = !empty($r['kategori']) ? $r['kategori'] : (!empty($r['jabatan']) ? $r['jabatan'] : '-');
            $r['foto']     = !empty($r['foto']) ? $r['foto'] : 'assets/images/users/user-1.jpg';
        }

        return $rows;
    }

    /**
     * Mengambil seluruh kandidat yang diranking pada sesi TOPSIS.
     * 
     * @param int $id_proses
     * @return array
     */
    public function get_all_ranked_candidates($id_proses)
    {
        $id = (int)$id_proses;
        if ($id <= 0) {
            return array();
        }

        $this->db->select('ht.ranking AS rank, ht.d_positif AS dplus, ht.d_negatif AS dminus, ht.nilai_preferensi AS skor, pa.nama_snapshot AS nama, pa.nip_snapshot AS nip, pa.jabatan_snapshot AS jabatan, pa.pangkat_snapshot AS pangkat, pa.golongan_snapshot AS golongan, rp.kategori, rp.foto');
        $this->db->from($this->table_hasil . ' ht');
        $this->db->join($this->table_alternatif . ' pa', 'ht.id_proses_alternatif = pa.id_proses_alternatif', 'left');
        $this->db->join($this->table_pegawai . ' rp', 'ht.id_pegawai = rp.id_pegawai', 'left');
        $this->db->where('ht.id_proses', $id);
        $this->db->order_by('ht.ranking', 'ASC');
        $rows = $this->db->get()->result_array();

        foreach ($rows as &$r) {
            $r['rank']     = (int)$r['rank'];
            $r['skor']     = (float)$r['skor'];
            $r['dplus']    = (float)$r['dplus'];
            $r['dminus']   = (float)$r['dminus'];
            $r['kategori'] = !empty($r['kategori']) ? $r['kategori'] : (!empty($r['jabatan']) ? $r['jabatan'] : '-');
            $r['foto']     = !empty($r['foto']) ? $r['foto'] : 'assets/images/users/user-1.jpg';
        }

        return $rows;
    }

    /**
     * Menyimpan data Berita Acara baru.
     * 
     * @param array $data
     * @return int|bool ID yang di-insert atau FALSE
     */
    public function insert_laporan(array $data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table_laporan, $data);
        return $this->db->insert_id();
    }

    /**
     * Memperbarui data Berita Acara.
     * 
     * @param int   $id_laporan
     * @param array $data
     * @return bool
     */
    public function update_laporan($id_laporan, array $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, (int)$id_laporan);
        return $this->db->update($this->table_laporan, $data);
    }

    /**
     * Menghapus record Berita Acara.
     * 
     * @param int $id_laporan
     * @return bool
     */
    public function delete_laporan($id_laporan)
    {
        $this->db->where($this->primary_key, (int)$id_laporan);
        return $this->db->delete($this->table_laporan);
    }

    /**
     * Mengambil daftar sesi TOPSIS yang berstatus 'final' dan telah memiliki
     * hasil kalkulasi yang dapat dijadikan dokumen Berita Acara.
     * 
     * @return array
     */
    public function get_available_topsis_proses()
    {
        $this->db->select('tp.id_proses, tp.id_periode, tp.kategori, tp.tanggal_proses, tp.status, p.nama_periode, p.tahun, p.jenis_periode');
        $this->db->from($this->table_proses . ' tp');
        $this->db->join($this->table_periode . ' p', 'tp.id_periode = p.id_periode', 'left');
        $this->db->where('LOWER(tp.status)', 'final');
        $this->db->order_by('tp.id_proses', 'DESC');
        $list = $this->db->get()->result_array();

        $available = array();
        foreach ($list as $row) {
            $id_proses = (int)$row['id_proses'];

            // Ambil pemenang rank 1
            $winner = $this->db->select('ht.nilai_preferensi, pa.nama_snapshot, pa.nip_snapshot, pa.id_pegawai')
                               ->from($this->table_hasil . ' ht')
                               ->join($this->table_alternatif . ' pa', 'ht.id_proses_alternatif = pa.id_proses_alternatif', 'left')
                               ->where('ht.id_proses', $id_proses)
                               ->where('ht.ranking', 1)
                               ->get()
                               ->row_array();

            if ($winner) {
                $row['pemenang_nama']  = $winner['nama_snapshot'];
                $row['pemenang_nip']   = $winner['nip_snapshot'];
                $row['id_pemenang']    = (int)$winner['id_pegawai'];
                $row['skor_topsis']    = (float)$winner['nilai_preferensi'];
                $row['has_laporan']    = ($this->db->where('id_proses', $id_proses)->count_all_results($this->table_laporan) > 0);
                $available[] = $row;
            }
        }

        return $available;
    }

    /**
     * Menghasilkan nomor urut BA baru untuk tahun berjalan.
     * 
     * @param string $format_template Template format nomor BA
     * @param string $kode_wilayah Kode wilayah satker
     * @param string $bulan_romawi Bulan romawi saat ini
     * @param string $tahun Tahun saat ini
     * @return string
     */
    public function generate_nomor_ba($format_template = '', $kode_wilayah = 'W2.U4', $bulan_romawi = 'VIII', $tahun = '2026')
    {
        $count = $this->db->where('YEAR(tanggal_terbit)', (int)$tahun)->count_all_results($this->table_laporan);
        $next_no = str_pad($count + 1, 2, '0', STR_PAD_LEFT);

        if (empty($format_template)) {
            $format_template = '[KODE_WILAYAH]/[NO_URUT]/BA.SPK/[BULAN_ROMAWI]/[TAHUN]';
        }

        $search = array('[KODE_WILAYAH]', '[NO_URUT]', '[BULAN_ROMAWI]', '[TAHUN]', '{KODE}', '{NO}', '{BLN}', '{THN}');
        $replace = array($kode_wilayah, $next_no, $bulan_romawi, $tahun, $kode_wilayah, $next_no, $bulan_romawi, $tahun);

        return str_replace($search, $replace, $format_template);
    }

    /**
     * Mengambil statistik ringkasan 4 KPI card untuk halaman Laporan & Berita Acara.
     * 
     * @return array
     */
    public function get_stats()
    {
        $total_ba   = $this->db->count_all($this->table_laporan);
        $disahkan   = $this->db->where('status', 'Disahkan')->count_all_results($this->table_laporan);
        $draft      = $this->db->where('status', 'Draft')->count_all_results($this->table_laporan);
        $arsip      = $this->db->where('status', 'Arsip')->count_all_results($this->table_laporan);

        // Ambil periode terakhir
        $latest = $this->db->select('p.nama_periode, p.tahun')
                           ->from($this->table_laporan . ' l')
                           ->join($this->table_periode . ' p', 'l.id_periode = p.id_periode', 'left')
                           ->order_by('l.tanggal_terbit', 'DESC')
                           ->get()
                           ->row_array();

        return array(
            'total_ba'        => $total_ba,
            'disahkan'        => $disahkan,
            'draft'           => $draft,
            'arsip'           => $arsip,
            'periode_terkini' => $latest ? $latest['nama_periode'] : 'Belum Ada'
        );
    }
}
