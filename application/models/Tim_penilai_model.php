<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Tim_penilai_model
 * Data Access Layer for tim_penilai_sk and tim_penilai_anggota tables.
 * Follows CodeIgniter 3 Query Builder standards and Clean Code principles.
 */
class Tim_penilai_model extends CI_Model
{
    protected $table_sk      = 'tim_penilai_sk';
    protected $table_anggota = 'tim_penilai_anggota';
    protected $primary_key   = 'id_sk';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all SK headers with Ketua, Sekretaris, and members summary.
     *
     * @return array
     */
    public function get_all_sk()
    {
        $this->db->from($this->table_sk);
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('created_at', 'DESC');
        $sk_list = $this->db->get()->result_array();

        foreach ($sk_list as &$sk) {
            $id_sk = $sk['id_sk'];
            $sk['ketua']      = $this->get_personel_by_peran($id_sk, 'Ketua');
            $sk['sekretaris'] = $this->get_personel_by_peran($id_sk, 'Sekretaris');
            $sk['anggota']    = $this->get_anggota_by_sk($id_sk, array('Anggota'));
            $sk['dokumen_sk'] = $this->format_dokumen_sk($sk['file_sk'], $sk['created_at']);
        }

        return $sk_list;
    }

    /**
     * Get single SK header by ID.
     *
     * @param int $id_sk
     * @return array|null
     */
    public function get_sk_by_id($id_sk)
    {
        $sk = $this->db->get_where($this->table_sk, array($this->primary_key => (int)$id_sk))->row_array();
        if (!$sk) {
            return NULL;
        }

        $id_sk = (int)$id_sk;
        $sk['ketua']      = $this->get_personel_by_peran($id_sk, 'Ketua');
        $sk['sekretaris'] = $this->get_personel_by_peran($id_sk, 'Sekretaris');
        $sk['anggota']    = $this->get_anggota_by_sk($id_sk, array('Anggota'));
        $sk['dokumen_sk'] = $this->format_dokumen_sk($sk['file_sk'], $sk['created_at']);

        return $sk;
    }

    /**
     * Private helper to format document SK metadata array.
     *
     * @param string|null $file_sk
     * @param string|null $created_at
     * @return array
     */
    private function format_dokumen_sk($file_sk, $created_at)
    {
        $file_path = !empty($file_sk) ? $file_sk : NULL;
        $ukuran_label = '1.5 MB';

        if (!empty($file_path) && file_exists(FCPATH . $file_path)) {
            $bytes = filesize(FCPATH . $file_path);
            if ($bytes >= 1048576) {
                $ukuran_label = round($bytes / 1048576, 1) . ' MB';
            } else {
                $ukuran_label = round($bytes / 1024, 0) . ' KB';
            }
        }

        return array(
            'nama_file'  => !empty($file_path) ? basename($file_path) : 'SK_Tim_Penilai.pdf',
            'file_path'  => $file_path,
            'ukuran'     => $ukuran_label,
            'tgl_upload' => !empty($created_at) ? $created_at : date('Y-m-d H:i:s')
        );
    }

    /**
     * Get all member rows for an SK.
     *
     * @param int        $id_sk
     * @param array|null $peran_filter Optional filter by peran ('Ketua', 'Sekretaris', 'Anggota')
     * @return array
     */
    public function get_anggota_by_sk($id_sk, $peran_filter = NULL)
    {
        $this->db->select('a.*, p.foto, p.pangkat, p.golongan, p.jabatan as jabatan_pegawai');
        $this->db->from($this->table_anggota . ' a');
        $this->db->join('referensi_pegawai p', 'p.id_pegawai = a.id_pegawai', 'left');
        $this->db->where('a.id_sk', (int)$id_sk);

        if (!empty($peran_filter) && is_array($peran_filter)) {
            $this->db->where_in('a.peran_tim', $peran_filter);
        }

        $this->db->order_by('a.id_anggota', 'ASC');
        $results = $this->db->get()->result_array();

        foreach ($results as &$row) {
            $row['nama']      = $row['nama_personel'];
            $row['jabatan']   = !empty($row['jabatan_instansi']) ? $row['jabatan_instansi'] : $row['jabatan_pegawai'];
            $row['penilaian'] = $row['kategori_penilaian'];
        }

        return $results;
    }

    /**
     * Get single personel by peran for an SK.
     *
     * @param int    $id_sk
     * @param string $peran ('Ketua' or 'Sekretaris')
     * @return array|null
     */
    public function get_personel_by_peran($id_sk, $peran)
    {
        $members = $this->get_anggota_by_sk($id_sk, array($peran));
        return !empty($members) ? $members[0] : NULL;
    }

    /**
     * Check if a No SK already exists.
     *
     * @param string   $no_sk
     * @param int|null $exclude_id
     * @return bool
     */
    public function check_nosk_exists($no_sk, $exclude_id = NULL)
    {
        $this->db->from($this->table_sk);
        $this->db->where('no_sk', trim($no_sk));
        if (!empty($exclude_id)) {
            $this->db->where($this->primary_key . ' !=', (int)$exclude_id);
        }
        return $this->db->count_all_results() > 0;
    }

    /**
     * Insert SK header record.
     *
     * @param array $data
     * @return int|bool Inserted ID or FALSE
     */
    public function insert_sk($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        $success = $this->db->insert($this->table_sk, $data);
        return $success ? $this->db->insert_id() : FALSE;
    }

    /**
     * Update SK header record.
     *
     * @param int   $id_sk
     * @param array $data
     * @return bool
     */
    public function update_sk($id_sk, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, (int)$id_sk);
        return $this->db->update($this->table_sk, $data);
    }

    /**
     * Delete SK header record (cascade deletes members if FK defined).
     *
     * @param int $id_sk
     * @return bool
     */
    public function delete_sk($id_sk)
    {
        $id_sk = (int)$id_sk;
        $this->db->where('id_sk', $id_sk)->delete($this->table_anggota);
        $this->db->where($this->primary_key, $id_sk);
        return $this->db->delete($this->table_sk);
    }

    /**
     * Sync/replace all members for a given SK.
     *
     * @param int   $id_sk
     * @param array $anggota_list Array of member arrays
     * @return bool
     */
    public function sync_anggota($id_sk, $anggota_list)
    {
        $id_sk = (int)$id_sk;
        $this->db->where('id_sk', $id_sk)->delete($this->table_anggota);

        if (empty($anggota_list) || !is_array($anggota_list)) {
            return TRUE;
        }

        $now = date('Y-m-d H:i:s');
        foreach ($anggota_list as &$item) {
            $item['id_sk']      = $id_sk;
            $item['created_at'] = $now;
        }

        return $this->db->insert_batch($this->table_anggota, $anggota_list);
    }

    /**
     * Get summary KPI statistics for Tim Penilai module.
     *
     * @return array
     */
    public function get_stats()
    {
        $total_sk       = $this->db->count_all($this->table_sk);
        $sk_aktif       = $this->db->where('status', 'Aktif')->count_all_results($this->table_sk);
        $total_personel = $this->db->count_all($this->table_anggota);
        $pdf_uploaded   = $this->db->where('file_sk IS NOT NULL AND file_sk != ""')->count_all_results($this->table_sk);

        return array(
            'total_sk'       => $total_sk,
            'sk_aktif'       => $sk_aktif,
            'total_personel' => $total_personel,
            'pdf_uploaded'   => $pdf_uploaded
        );
    }
}
