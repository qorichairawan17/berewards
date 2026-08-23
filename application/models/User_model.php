<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User_model
 * Data Access Layer for the pengguna table with referensi_pegawai relationship.
 * Follows CodeIgniter 3 Query Builder standards and Clean Code principles.
 */
class User_model extends CI_Model
{
    protected $table         = 'pengguna';
    protected $table_pegawai = 'referensi_pegawai';
    protected $primary_key   = 'id_user';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all user records joined with referensi_pegawai, with optional active filter.
     *
     * @param bool $aktif_only
     * @return array
     */
    public function get_all_users($aktif_only = FALSE)
    {
        $this->db->select('p.*, rp.nip, rp.nama AS nama_pegawai, rp.jabatan, rp.kategori, rp.pangkat, rp.golongan, rp.foto AS foto_pegawai');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_pegawai . ' rp', 'p.id_pegawai = rp.id_pegawai', 'left');

        if ($aktif_only) {
            $this->db->where('p.aktif', 1);
        }
        $this->db->order_by('p.id_user', 'ASC');

        $users = $this->db->get()->result_array();

        foreach ($users as &$u) {
            $u['nama_user']  = !empty($u['nama_lengkap']) ? $u['nama_lengkap'] : $u['nama_pegawai'];
            $u['status']     = (int)$u['aktif'];
            $u['role_label'] = $this->format_role_label($u['role']);
        }

        return $users;
    }

    /**
     * Get single user record by ID joined with referensi_pegawai.
     *
     * @param int $id_user
     * @return array|null
     */
    public function get_user_by_id($id_user)
    {
        $this->db->select('p.*, rp.nip, rp.nama AS nama_pegawai, rp.jabatan, rp.kategori, rp.pangkat, rp.golongan, rp.foto AS foto_pegawai');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_pegawai . ' rp', 'p.id_pegawai = rp.id_pegawai', 'left');
        $this->db->where('p.' . $this->primary_key, (int)$id_user);

        $user = $this->db->get()->row_array();
        if ($user) {
            $user['nama_user']  = !empty($user['nama_lengkap']) ? $user['nama_lengkap'] : $user['nama_pegawai'];
            $user['status']     = (int)$user['aktif'];
            $user['role_label'] = $this->format_role_label($user['role']);
        }
        return $user;
    }

    /**
     * Get single user record by username.
     *
     * @param string $username
     * @return array|null
     */
    public function get_user_by_username($username)
    {
        $this->db->select('p.*, rp.nip, rp.nama AS nama_pegawai, rp.jabatan, rp.kategori, rp.pangkat, rp.golongan, rp.foto AS foto_pegawai');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_pegawai . ' rp', 'p.id_pegawai = rp.id_pegawai', 'left');
        $this->db->where('p.username', trim($username));

        $user = $this->db->get()->row_array();
        if ($user) {
            $user['nama_user']  = !empty($user['nama_lengkap']) ? $user['nama_lengkap'] : $user['nama_pegawai'];
            $user['status']     = (int)$user['aktif'];
            $user['role_label'] = $this->format_role_label($user['role']);
        }
        return $user;
    }

    /**
     * Check if a username already exists.
     *
     * @param string   $username
     * @param int|null $exclude_id
     * @return bool
     */
    public function check_username_exists($username, $exclude_id = NULL)
    {
        $this->db->from($this->table);
        $this->db->where('username', trim($username));
        if (!empty($exclude_id)) {
            $this->db->where($this->primary_key . ' !=', (int)$exclude_id);
        }
        return $this->db->count_all_results() > 0;
    }

    /**
     * Check if an email already exists.
     *
     * @param string   $email
     * @param int|null $exclude_id
     * @return bool
     */
    public function check_email_exists($email, $exclude_id = NULL)
    {
        if (empty($email)) {
            return FALSE;
        }

        $this->db->from($this->table);
        $this->db->where('email', trim($email));
        if (!empty($exclude_id)) {
            $this->db->where($this->primary_key . ' !=', (int)$exclude_id);
        }
        return $this->db->count_all_results() > 0;
    }

    /**
     * Check if an employee (id_pegawai) is already linked to another active user.
     *
     * @param int      $id_pegawai
     * @param int|null $exclude_id_user
     * @return bool
     */
    public function check_pegawai_linked($id_pegawai, $exclude_id_user = NULL)
    {
        if (empty($id_pegawai)) {
            return FALSE;
        }

        $this->db->from($this->table);
        $this->db->where('id_pegawai', (int)$id_pegawai);
        $this->db->where('aktif', 1);
        if (!empty($exclude_id_user)) {
            $this->db->where($this->primary_key . ' !=', (int)$exclude_id_user);
        }
        return $this->db->count_all_results() > 0;
    }

    /**
     * Retrieve active employees list for selection dropdown.
     *
     * @return array
     */
    public function get_pegawai_options()
    {
        $this->db->from($this->table_pegawai);
        $this->db->where('aktif', 1);
        $this->db->order_by('kategori', 'ASC');
        $this->db->order_by('nama', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Insert new user record.
     *
     * @param array $data
     * @return int|bool Inserted ID or FALSE
     */
    public function insert_user($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        $success = $this->db->insert($this->table, $data);
        return $success ? $this->db->insert_id() : FALSE;
    }

    /**
     * Update user record.
     *
     * @param int   $id_user
     * @param array $data
     * @return bool
     */
    public function update_user($id_user, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, (int)$id_user);
        return $this->db->update($this->table, $data);
    }

    /**
     * Soft-deactivate or delete user record.
     *
     * @param int  $id_user
     * @param bool $hard_delete
     * @return bool
     */
    public function delete_user($id_user, $hard_delete = FALSE)
    {
        $id_user = (int)$id_user;
        if ($hard_delete) {
            $this->db->where($this->primary_key, $id_user);
            return $this->db->delete($this->table);
        } else {
            $this->db->where($this->primary_key, $id_user);
            return $this->db->update($this->table, array('aktif' => 0, 'updated_at' => date('Y-m-d H:i:s')));
        }
    }

    /**
     * Get summary KPI statistics for User Management module.
     *
     * @return array
     */
    public function get_stats()
    {
        $total_user    = $this->db->count_all_results($this->table);
        $total_admin   = $this->db->where_in('role', array('superadmin', 'administrator'))->where('aktif', 1)->count_all_results($this->table);
        $total_penilai = $this->db->where_in('role', array('tim_penilai', 'pimpinan'))->where('aktif', 1)->count_all_results($this->table);
        $total_aktif   = $this->db->where('aktif', 1)->count_all_results($this->table);

        return array(
            'total_user'    => $total_user,
            'total_admin'   => $total_admin,
            'total_penilai' => $total_penilai,
            'total_aktif'   => $total_aktif
        );
    }

    /**
     * Helper to format human-readable role label.
     *
     * @param string $role
     * @return string
     */
    public function format_role_label($role)
    {
        $role = strtolower(trim($role));
        switch ($role) {
            case 'superadmin':
                return 'Superadmin';
            case 'administrator':
                return 'Administrator';
            case 'tim_penilai':
                return 'Tim Penilai';
            case 'pimpinan':
                return 'Pimpinan';
            default:
                return ucfirst($role);
        }
    }
}
