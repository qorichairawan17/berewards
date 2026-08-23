<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Audit_model
 * Data Access Layer for System Audit Trail Logging.
 * Follows CI3 Clean Architecture principles (strictly data access/query builder).
 * PHP 5.6+ and CodeIgniter 3 Compatible.
 */
class Audit_model extends CI_Model {

    /**
     * Table name
     * @var string
     */
    protected $table = 'audit_trail';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->ensure_schema();
    }

    /**
     * Ensure table audit_trail has all required columns for before & after diff tracking.
     * Runs lightweight check and dynamically adds missing columns without data loss.
     *
     * @return void
     */
    public function ensure_schema()
    {
        if (!$this->db->table_exists($this->table)) {
            return;
        }

        $fields = $this->db->list_fields($this->table);

        if (!in_array('tipe_aksi', $fields)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `tipe_aksi` VARCHAR(50) NULL DEFAULT 'ACTIVITY' AFTER `modul`");
        }
        if (!in_array('tabel_terkait', $fields)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `tabel_terkait` VARCHAR(100) NULL AFTER `tipe_aksi`");
        }
        if (!in_array('id_record', $fields)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `id_record` VARCHAR(50) NULL AFTER `tabel_terkait`");
        }
        if (!in_array('data_sebelum', $fields)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `data_sebelum` LONGTEXT NULL AFTER `id_record`");
        }
        if (!in_array('data_sesudah', $fields)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `data_sesudah` LONGTEXT NULL AFTER `data_sebelum`");
        }
    }

    /**
     * Fetch audit trail logs with optional filtering, limit, and offset.
     *
     * @param int   $limit
     * @param int   $offset
     * @param array $filters
     * @return array
     */
    public function get_audit_list($limit = 200, $offset = 0, $filters = array())
    {
        $this->apply_filters($filters);

        $this->db->order_by('timestamp', 'DESC');
        $this->db->order_by('id_audit', 'DESC');

        if ($limit > 0) {
            $this->db->limit((int)$limit, (int)$offset);
        }

        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Count total audit trail logs matching filters.
     *
     * @param array $filters
     * @return int
     */
    public function get_audit_count($filters = array())
    {
        $this->apply_filters($filters);
        return (int) $this->db->count_all_results($this->table);
    }

    /**
     * Fetch a single audit trail log by ID.
     *
     * @param int $id_audit
     * @return array|null
     */
    public function get_audit_by_id($id_audit)
    {
        $id_audit = (int)$id_audit;
        if ($id_audit <= 0) {
            return NULL;
        }

        $query = $this->db->get_where($this->table, array('id_audit' => $id_audit));
        return $query->row_array();
    }

    /**
     * Fetch KPI statistics for Audit Trail dashboard cards.
     *
     * @return array
     */
    public function get_stats()
    {
        if (!$this->db->table_exists($this->table)) {
            return array(
                'total_logs'   => 0,
                'total_sukses' => 0,
                'total_gagal'  => 0,
                'total_user'   => 0
            );
        }

        // Total logs
        $total_logs = (int) $this->db->count_all($this->table);

        // Sukses count
        $this->db->where('status', 'Sukses');
        $total_sukses = (int) $this->db->count_all_results($this->table);

        // Gagal / Peringatan count
        $this->db->where_in('status', array('Gagal', 'Peringatan'));
        $total_gagal = (int) $this->db->count_all_results($this->table);

        // Unique users involved
        $this->db->select('COUNT(DISTINCT(username)) as user_count');
        $query_user = $this->db->get($this->table);
        $row_user = $query_user->row_array();
        $total_user = !empty($row_user['user_count']) ? (int)$row_user['user_count'] : 0;

        return array(
            'total_logs'   => $total_logs,
            'total_sukses' => $total_sukses,
            'total_gagal'  => $total_gagal,
            'total_user'   => $total_user
        );
    }

    /**
     * Insert a new audit log record.
     *
     * @param array $data
     * @return int|bool Inserted ID or FALSE on failure
     */
    public function insert_audit($data)
    {
        if (empty($data) || !is_array($data)) {
            return FALSE;
        }

        if (empty($data['timestamp'])) {
            $data['timestamp'] = date('Y-m-d H:i:s');
        }
        if (empty($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $inserted = $this->db->insert($this->table, $data);
        if ($inserted) {
            return $this->db->insert_id();
        }

        return FALSE;
    }

    /**
     * Get distinct module list for filtering dropdown.
     *
     * @return array
     */
    public function get_distinct_modules()
    {
        $this->db->distinct();
        $this->db->select('modul');
        $this->db->order_by('modul', 'ASC');
        $query = $this->db->get($this->table);
        return array_column($query->result_array(), 'modul');
    }

    /**
     * Helper to apply common query filters.
     *
     * @param array $filters
     * @return void
     */
    protected function apply_filters($filters)
    {
        if (empty($filters) || !is_array($filters)) {
            return;
        }

        if (!empty($filters['modul'])) {
            $this->db->where('modul', trim($filters['modul']));
        }

        if (!empty($filters['status'])) {
            $this->db->where('status', trim($filters['status']));
        }

        if (!empty($filters['tipe_aksi'])) {
            $this->db->where('tipe_aksi', trim($filters['tipe_aksi']));
        }

        if (!empty($filters['username'])) {
            $this->db->where('username', trim($filters['username']));
        }

        if (!empty($filters['id_user'])) {
            $this->db->where('id_user', (int)$filters['id_user']);
        }

        if (!empty($filters['tabel_terkait'])) {
            $this->db->where('tabel_terkait', trim($filters['tabel_terkait']));
        }

        if (!empty($filters['search'])) {
            $s = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('aktivitas', $s);
            $this->db->or_like('nama_user', $s);
            $this->db->or_like('username', $s);
            $this->db->or_like('modul', $s);
            $this->db->or_like('ip_address', $s);
            $this->db->or_like('tipe_aksi', $s);
            $this->db->group_end();
        }

        if (!empty($filters['date_from'])) {
            $this->db->where('timestamp >=', $filters['date_from'] . ' 00:00:00');
        }

        if (!empty($filters['date_to'])) {
            $this->db->where('timestamp <=', $filters['date_to'] . ' 23:59:59');
        }
    }
}
