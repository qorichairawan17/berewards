<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Audit_service
 * Service Layer for System Audit Trail Logging and Table Data Change Tracking.
 * PHP 5.6+ and CodeIgniter 3 Compatible.
 */
class Audit_service {

    /**
     * CodeIgniter Super Object Instance
     * @var CI_Controller
     */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
    }

    /**
     * Log a general user or system activity into audit_trail table.
     *
     * @param string      $modul
     * @param string      $aktivitas
     * @param string      $status
     * @param int|null    $id_user
     * @param string|null $username
     * @param string|null $nama_user
     * @param string|null $role
     * @return bool
     */
    public function log_activity($modul, $aktivitas, $status = 'Sukses', $id_user = NULL, $username = NULL, $nama_user = NULL, $role = NULL)
    {
        // Resolve user credentials from active session if not explicitly passed
        if ($id_user === NULL) {
            $id_user = $this->CI->session->userdata('user_id');
        }
        if (empty($username)) {
            $username = $this->CI->session->userdata('username');
        }
        if (empty($nama_user)) {
            $nama_user = $this->CI->session->userdata('nama_lengkap');
        }
        if (empty($role)) {
            $role = $this->CI->session->userdata('role');
        }

        // Fallback for unauthenticated activities
        if (empty($username)) {
            $username = 'SYSTEM/GUEST';
        }

        if ($this->CI->db->table_exists('audit_trail')) {
            $data = array(
                'timestamp'  => date('Y-m-d H:i:s'),
                'id_user'    => !empty($id_user) ? (int) $id_user : NULL,
                'username'   => $username,
                'nama_user'  => $nama_user,
                'role'       => $role,
                'modul'      => $modul,
                'aktivitas'  => $aktivitas,
                'ip_address' => $this->CI->input->ip_address(),
                'user_agent' => substr((string) $this->CI->input->user_agent(), 0, 255),
                'status'     => $status,
                'created_at' => date('Y-m-d H:i:s')
            );

            return $this->CI->db->insert('audit_trail', $data);
        }

        return FALSE;
    }

    /**
     * Log table data modifications (INSERT, UPDATE, DELETE) with field diff details.
     *
     * @param string      $table_name Name of modified table
     * @param string      $action     INSERT | UPDATE | DELETE
     * @param int|string  $record_id  Primary key value of modified record
     * @param array       $old_data   Data array before change
     * @param array       $new_data   Data array after change
     * @param string|null $modul     Custom module label
     * @return bool
     */
    public function log_change($table_name, $action, $record_id, $old_data = array(), $new_data = array(), $modul = NULL)
    {
        $action = strtoupper($action);

        if (empty($modul)) {
            $modul = 'Manajemen ' . ucfirst($table_name);
        }

        $description = '';

        if ($action === 'INSERT') {
            $description = 'Menambahkan data baru pada tabel [' . $table_name . '] (ID: ' . $record_id . ')';
            if (!empty($new_data)) {
                $description .= ' dengan rincian: ' . $this->format_array_summary($new_data);
            }
        } elseif ($action === 'UPDATE') {
            $diffs = $this->calculate_data_diff($old_data, $new_data);
            if (!empty($diffs)) {
                $description = 'Memperbarui data pada tabel [' . $table_name . '] (ID: ' . $record_id . '). Perubahan: ' . implode('; ', $diffs);
            } else {
                $description = 'Memperbarui data pada tabel [' . $table_name . '] (ID: ' . $record_id . ') tanpa perubahan nilai.';
            }
        } elseif ($action === 'DELETE') {
            $description = 'Menghapus data dari tabel [' . $table_name . '] (ID: ' . $record_id . ')';
            if (!empty($old_data)) {
                $description .= '. Data terhapus: ' . $this->format_array_summary($old_data);
            }
        } else {
            $description = 'Melakukan tindakan [' . $action . '] pada tabel [' . $table_name . '] (ID: ' . $record_id . ')';
        }

        return $this->log_activity($modul, $description, 'Sukses');
    }

    /**
     * Calculate difference between old data and new data array.
     *
     * @param array $old_data
     * @param array $new_data
     * @return array Array of diff strings
     */
    protected function calculate_data_diff($old_data, $new_data)
    {
        $diffs = array();

        if (!is_array($old_data)) {
            $old_data = array();
        }
        if (!is_array($new_data)) {
            $new_data = array();
        }

        $ignore_keys = array('updated_at', 'created_at', 'password');

        foreach ($new_data as $key => $new_val) {
            if (in_array($key, $ignore_keys)) {
                continue;
            }

            $old_val = isset($old_data[$key]) ? $old_data[$key] : null;

            if ((string) $old_val !== (string) $new_val) {
                $old_str = is_null($old_val) ? 'NULL' : '"' . $old_val . '"';
                $new_str = is_null($new_val) ? 'NULL' : '"' . $new_val . '"';
                $diffs[] = '[' . $key . ']: ' . $old_str . ' -> ' . $new_str;
            }
        }

        return $diffs;
    }

    /**
     * Format array for human readable summary output.
     *
     * @param array $data
     * @return string
     */
    protected function format_array_summary($data)
    {
        if (!is_array($data) || empty($data)) {
            return '-';
        }

        $items = array();
        $count = 0;
        foreach ($data as $key => $val) {
            if ($key === 'password') {
                $val = '********';
            }
            if ($count >= 4) {
                $items[] = '...';
                break;
            }
            $items[] = '[' . $key . ' = ' . (is_scalar($val) ? $val : json_encode($val)) . ']';
            $count++;
        }

        return implode(', ', $items);
    }
}
