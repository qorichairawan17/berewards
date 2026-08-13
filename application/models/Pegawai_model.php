<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Pegawai_model
 * Data Access Layer for referensi_pegawai table.
 * Follows CodeIgniter 3 Query Builder standards and Clean Code principles.
 */
class Pegawai_model extends CI_Model
{
    /**
     * Database table name
     * @var string
     */
    protected $table = 'referensi_pegawai';

    /**
     * Primary key column name
     * @var string
     */
    protected $primary_key = 'id_pegawai';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all employees, optionally filtered by active status.
     *
     * @param bool $only_active
     * @return array
     */
    public function get_all($only_active = FALSE)
    {
        $this->db->from($this->table);
        if ($only_active) {
            $this->db->where('aktif', 1);
        }
        $this->db->order_by('kategori', 'ASC');
        $this->db->order_by('nama', 'ASC');
        
        return $this->db->get()->result_array();
    }

    /**
     * Get a single employee record by primary key ID.
     *
     * @param int $id
     * @return array|null
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array($this->primary_key => (int)$id))->row_array();
    }

    /**
     * Get a single employee record by NIP.
     *
     * @param string $nip
     * @return array|null
     */
    public function get_by_nip($nip)
    {
        return $this->db->get_where($this->table, array('nip' => trim($nip)))->row_array();
    }

    /**
     * Check if a NIP already exists in the table (excluding specified ID for edits).
     *
     * @param string   $nip
     * @param int|null $exclude_id
     * @return bool
     */
    public function check_nip_exists($nip, $exclude_id = NULL)
    {
        $this->db->from($this->table);
        $this->db->where('nip', trim($nip));
        if (!empty($exclude_id)) {
            $this->db->where($this->primary_key . ' !=', (int)$exclude_id);
        }
        return $this->db->count_all_results() > 0;
    }

    /**
     * Insert a new employee record.
     *
     * @param array $data
     * @return int|bool Inserted ID or FALSE on failure
     */
    public function insert($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        $success = $this->db->insert($this->table, $data);
        return $success ? $this->db->insert_id() : FALSE;
    }

    /**
     * Update an existing employee record by ID.
     *
     * @param int   $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, (int)$id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Toggle or set the active status of an employee.
     *
     * @param int $id
     * @param int $status (1 = active, 0 = inactive)
     * @return bool
     */
    public function set_active_status($id, $status = 0)
    {
        return $this->update($id, array('aktif' => (int)$status));
    }

    /**
     * Hard delete an employee record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $this->db->where($this->primary_key, (int)$id);
        return $this->db->delete($this->table);
    }

    /**
     * Check if employee is used in TOPSIS process snapshot table (if exists).
     *
     * @param int $id_pegawai
     * @return bool
     */
    public function is_used_in_topsis($id_pegawai)
    {
        if ($this->db->table_exists('topsis_proses_alternatif')) {
            $count = $this->db->where('id_pegawai', (int)$id_pegawai)->count_all_results('topsis_proses_alternatif');
            return $count > 0;
        }
        return FALSE;
    }

    /**
     * Calculate summary statistics of employees by category.
     *
     * @return array
     */
    public function get_stats()
    {
        $total         = $this->db->count_all($this->table);
        $hakim         = $this->db->where('kategori', 'Hakim')->count_all_results($this->table);
        $panitera      = $this->db->where('kategori', 'Panitera Pengganti')->count_all_results($this->table);
        $jurusita      = $this->db->where('kategori', 'Jurusita')->count_all_results($this->table);
        $staf          = $this->db->where('kategori', 'Staf')->count_all_results($this->table);
        $jurusita_staf = $jurusita + $staf;

        return array(
            'total'         => $total,
            'hakim'         => $hakim,
            'panitera'      => $panitera,
            'jurusita'      => $jurusita,
            'staf'          => $staf,
            'jurusita_staf' => $jurusita_staf
        );
    }
}
