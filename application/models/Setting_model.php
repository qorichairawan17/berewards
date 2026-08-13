<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting_model
 * Data Access Layer for application settings (pengaturan table).
 * Follows CodeIgniter 3 Query Builder standards and Clean Code principles.
 */
class Setting_model extends CI_Model
{
    protected $table = 'pengaturan';
    protected $primary_key = 'id_setting';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Check if pengaturan table exists in database.
     *
     * @return bool
     */
    public function table_exists()
    {
        return $this->db->table_exists($this->table);
    }

    /**
     * Get single setting record row from database by ID.
     *
     * @param int $id
     * @return array|null
     */
    public function get_setting_row($id = 1)
    {
        if (!$this->table_exists()) {
            return NULL;
        }

        return $this->db->get_where($this->table, array($this->primary_key => (int)$id))->row_array();
    }

    /**
     * Save (insert or update) setting record row.
     *
     * @param array $data
     * @param int   $id
     * @return bool
     */
    public function save_setting_row($data, $id = 1)
    {
        if (!$this->table_exists() || empty($data) || !is_array($data)) {
            return FALSE;
        }

        $id = (int)$id;
        $exists = $this->db->get_where($this->table, array($this->primary_key => $id))->row_array();

        if ($exists) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where($this->primary_key, $id);
            return $this->db->update($this->table, $data);
        } else {
            $data[$this->primary_key] = $id;
            if (!isset($data['created_at'])) {
                $data['created_at'] = date('Y-m-d H:i:s');
            }
            return $this->db->insert($this->table, $data);
        }
    }
}
