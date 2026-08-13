<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Kriteria_model
 * Data Access Layer for kriteria and skala_kriteria tables.
 * Follows CodeIgniter 3 Query Builder standards and Clean Code principles.
 */
class Kriteria_model extends CI_Model
{
    protected $table_kriteria = 'kriteria';
    protected $table_skala    = 'skala_kriteria';
    protected $primary_key    = 'id_kriteria';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all kriteria records with optional kategori filter and active filter.
     *
     * @param string|null $kategori
     * @param bool        $aktif_only
     * @return array
     */
    public function get_all_kriteria($kategori = NULL, $aktif_only = FALSE)
    {
        $this->db->from($this->table_kriteria);
        if (!empty($kategori)) {
            $this->db->where('kategori', trim($kategori));
        }
        if ($aktif_only) {
            $this->db->where('aktif', 1);
        }
        $this->db->order_by('kategori', 'ASC');
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('kode', 'ASC');

        $kriteria_list = $this->db->get()->result_array();

        foreach ($kriteria_list as &$row) {
            if ($row['jenis_data'] === 'kualitatif') {
                $row['skala_list'] = $this->get_skala_by_kriteria($row['id_kriteria']);
            } else {
                $row['skala_list'] = array();
            }
        }

        return $kriteria_list;
    }

    /**
     * Get single kriteria record by ID.
     *
     * @param int $id_kriteria
     * @return array|null
     */
    public function get_kriteria_by_id($id_kriteria)
    {
        $kriteria = $this->db->get_where($this->table_kriteria, array($this->primary_key => (int)$id_kriteria))->row_array();
        if (!$kriteria) {
            return NULL;
        }

        if ($kriteria['jenis_data'] === 'kualitatif') {
            $kriteria['skala_list'] = $this->get_skala_by_kriteria($kriteria['id_kriteria']);
        } else {
            $kriteria['skala_list'] = array();
        }

        return $kriteria;
    }

    /**
     * Check if a Kode Kriteria already exists.
     *
     * @param string   $kode
     * @param int|null $exclude_id
     * @return bool
     */
    public function check_kode_exists($kode, $exclude_id = NULL)
    {
        $this->db->from($this->table_kriteria);
        $this->db->where('kode', trim($kode));
        if (!empty($exclude_id)) {
            $this->db->where($this->primary_key . ' !=', (int)$exclude_id);
        }
        return $this->db->count_all_results() > 0;
    }

    /**
     * Insert kriteria header record.
     *
     * @param array $data
     * @return int|bool Inserted ID or FALSE
     */
    public function insert_kriteria($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        $success = $this->db->insert($this->table_kriteria, $data);
        return $success ? $this->db->insert_id() : FALSE;
    }

    /**
     * Update kriteria header record.
     *
     * @param int   $id_kriteria
     * @param array $data
     * @return bool
     */
    public function update_kriteria($id_kriteria, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, (int)$id_kriteria);
        return $this->db->update($this->table_kriteria, $data);
    }

    /**
     * Delete/soft-deactivate kriteria record.
     *
     * @param int  $id_kriteria
     * @param bool $hard_delete
     * @return bool
     */
    public function delete_kriteria($id_kriteria, $hard_delete = FALSE)
    {
        $id_kriteria = (int)$id_kriteria;
        if ($hard_delete) {
            $this->db->where('id_kriteria', $id_kriteria)->delete($this->table_skala);
            $this->db->where($this->primary_key, $id_kriteria);
            return $this->db->delete($this->table_kriteria);
        } else {
            $this->db->where($this->primary_key, $id_kriteria);
            return $this->db->update($this->table_kriteria, array('aktif' => 0, 'updated_at' => date('Y-m-d H:i:s')));
        }
    }

    /**
     * Get rating scale options for a kriteria.
     *
     * @param int $id_kriteria
     * @return array
     */
    public function get_skala_by_kriteria($id_kriteria)
    {
        $this->db->from($this->table_skala);
        $this->db->where('id_kriteria', (int)$id_kriteria);
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('nilai', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Save (sync) rating scale options for qualitative kriteria.
     *
     * @param int   $id_kriteria
     * @param array $skala_list
     * @return bool
     */
    public function save_skala($id_kriteria, $skala_list)
    {
        $id_kriteria = (int)$id_kriteria;
        $this->db->where('id_kriteria', $id_kriteria)->delete($this->table_skala);

        if (empty($skala_list) || !is_array($skala_list)) {
            return TRUE;
        }

        $now = date('Y-m-d H:i:s');
        foreach ($skala_list as &$row) {
            $row['id_kriteria'] = $id_kriteria;
            $row['created_at']  = $now;
        }

        return $this->db->insert_batch($this->table_skala, $skala_list);
    }

    /**
     * Get summary KPI statistics for Kriteria module.
     *
     * @return array
     */
    public function get_stats()
    {
        $total_kriteria   = $this->db->where('aktif', 1)->count_all_results($this->table_kriteria);
        $total_benefit    = $this->db->where('aktif', 1)->where('tipe_atribut', 'benefit')->count_all_results($this->table_kriteria);
        $total_cost       = $this->db->where('aktif', 1)->where('tipe_atribut', 'cost')->count_all_results($this->table_kriteria);
        $total_kualitatif = $this->db->where('aktif', 1)->where('jenis_data', 'kualitatif')->count_all_results($this->table_kriteria);

        return array(
            'total_kriteria'   => $total_kriteria,
            'total_benefit'    => $total_benefit,
            'total_cost'       => $total_cost,
            'total_kualitatif' => $total_kualitatif
        );
    }
}
