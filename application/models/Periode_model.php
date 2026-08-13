<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Periode_model
 * Data Access Layer for the periode table.
 * Follows CodeIgniter 3 Query Builder standards and Clean Code principles.
 */
class Periode_model extends CI_Model
{
    protected $table       = 'periode';
    protected $primary_key = 'id_periode';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all period records with optional active filter.
     *
     * @param bool $aktif_only
     * @return array
     */
    public function get_all_periode($aktif_only = FALSE)
    {
        $this->db->from($this->table);
        if ($aktif_only) {
            $this->db->where('aktif', 1);
        }
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('tanggal_mulai', 'DESC');
        $this->db->order_by('id_periode', 'DESC');

        return $this->db->get()->result_array();
    }

    /**
     * Get single period record by ID.
     *
     * @param int $id_periode
     * @return array|null
     */
    public function get_periode_by_id($id_periode)
    {
        return $this->db->get_where($this->table, array($this->primary_key => (int)$id_periode))->row_array();
    }

    /**
     * Insert period header record.
     *
     * @param array $data
     * @return int|bool Inserted ID or FALSE
     */
    public function insert_periode($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        $success = $this->db->insert($this->table, $data);
        return $success ? $this->db->insert_id() : FALSE;
    }

    /**
     * Update period record.
     *
     * @param int   $id_periode
     * @param array $data
     * @return bool
     */
    public function update_periode($id_periode, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, (int)$id_periode);
        return $this->db->update($this->table, $data);
    }

    /**
     * Soft-deactivate or delete period record.
     *
     * @param int  $id_periode
     * @param bool $hard_delete
     * @return bool
     */
    public function delete_periode($id_periode, $hard_delete = FALSE)
    {
        $id_periode = (int)$id_periode;
        if ($hard_delete) {
            $this->db->where($this->primary_key, $id_periode);
            return $this->db->delete($this->table);
        } else {
            $this->db->where($this->primary_key, $id_periode);
            return $this->db->update($this->table, array('aktif' => 0, 'updated_at' => date('Y-m-d H:i:s')));
        }
    }

    /**
     * Get summary KPI statistics for Periode module.
     *
     * @return array
     */
    public function get_stats()
    {
        $total_periode  = $this->db->where('aktif', 1)->count_all_results($this->table);
        $total_buka     = $this->db->where('aktif', 1)->where('status', 'buka')->count_all_results($this->table);
        $total_tutup    = $this->db->where('aktif', 1)->where('status', 'tutup')->count_all_results($this->table);
        $tahun_berjalan = (int)date('Y');

        return array(
            'total_periode'  => $total_periode,
            'total_buka'     => $total_buka,
            'total_tutup'    => $total_tutup,
            'tahun_berjalan' => $tahun_berjalan
        );
    }
}
