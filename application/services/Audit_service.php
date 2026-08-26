<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Audit_service
 * Service Layer for System Audit Trail Logging and Table Data Change Tracking (Before vs After).
 * Implements Clean Architecture and transparency for all user and system operations.
 * PHP 5.6+ and CodeIgniter 3 Compatible.
 */
class Audit_service
{

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
        $this->CI->load->model('Audit_model');
    }

    /**
     * Log a general user or system activity into audit_trail table.
     *
     * @param string            $modul
     * @param string            $aktivitas
     * @param string            $status
     * @param int|null          $id_user
     * @param string|null       $username
     * @param string|null       $nama_user
     * @param string|null       $role
     * @param string            $tipe_aksi
     * @param string|null       $tabel_terkait
     * @param string|int|null   $id_record
     * @param array|string|null $data_sebelum
     * @param array|string|null $data_sesudah
     * @return int|bool
     */
    public function log_activity(
        $modul,
        $aktivitas,
        $status = 'Sukses',
        $id_user = NULL,
        $username = NULL,
        $nama_user = NULL,
        $role = NULL,
        $tipe_aksi = 'ACTIVITY',
        $tabel_terkait = NULL,
        $id_record = NULL,
        $data_sebelum = NULL,
        $data_sesudah = NULL
    ) {
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
        if (empty($nama_user)) {
            $nama_user = 'Pengunjung Sistem';
        }
        if (empty($role)) {
            $role = 'Tamu';
        }

        // Prepare JSON strings for before & after data
        $sebelum_json = NULL;
        if (!empty($data_sebelum)) {
            $clean_sebelum = is_array($data_sebelum) ? $this->sanitize_sensitive_data($data_sebelum) : $data_sebelum;
            $sebelum_json = is_string($clean_sebelum) ? $clean_sebelum : json_encode($clean_sebelum, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $sesudah_json = NULL;
        if (!empty($data_sesudah)) {
            $clean_sesudah = is_array($data_sesudah) ? $this->sanitize_sensitive_data($data_sesudah) : $data_sesudah;
            $sesudah_json = is_string($clean_sesudah) ? $clean_sesudah : json_encode($clean_sesudah, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $ip_address = $this->CI->input->ip_address();
        if (empty($ip_address)) {
            $ip_address = '127.0.0.1';
        }

        $user_agent = (string) $this->CI->input->user_agent();
        if (empty($user_agent)) {
            $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) BeRewards/1.0';
        }

        $data = array(
            'timestamp' => date('Y-m-d H:i:s'),
            'id_user' => !empty($id_user) ? (int) $id_user : NULL,
            'username' => substr($username, 0, 50),
            'nama_user' => substr($nama_user, 0, 150),
            'role' => substr($role, 0, 50),
            'modul' => substr($modul, 0, 100),
            'tipe_aksi' => strtoupper(substr($tipe_aksi, 0, 50)),
            'tabel_terkait' => !empty($tabel_terkait) ? substr($tabel_terkait, 0, 100) : NULL,
            'id_record' => !empty($id_record) ? (string) $id_record : NULL,
            'data_sebelum' => $sebelum_json,
            'data_sesudah' => $sesudah_json,
            'aktivitas' => $aktivitas,
            'ip_address' => substr($ip_address, 0, 45),
            'user_agent' => substr($user_agent, 0, 255),
            'status' => in_array($status, array('Sukses', 'Gagal', 'Peringatan')) ? $status : 'Sukses',
            'created_at' => date('Y-m-d H:i:s')
        );

        return $this->CI->Audit_model->insert_audit($data);
    }

    /**
     * Log record INSERT operation with detailed new data snapshot.
     *
     * @param string      $table_name
     * @param int|string  $record_id
     * @param array       $new_data
     * @param string|null $modul
     * @param string|null $custom_desc
     * @return int|bool
     */
    public function log_insert($table_name, $record_id, $new_data = array(), $modul = NULL, $custom_desc = NULL)
    {
        if (empty($modul)) {
            $modul = 'Manajemen ' . ucwords(str_replace('_', ' ', $table_name));
        }

        $description = !empty($custom_desc)
            ? $custom_desc
            : 'Menambahkan data baru pada tabel [' . $table_name . '] (ID: ' . $record_id . ')';

        $summary = $this->format_array_summary($new_data);
        if ($summary !== '-' && empty($custom_desc)) {
            $description .= ' dengan rincian: ' . $summary;
        }

        return $this->log_activity(
            $modul,
            $description,
            'Sukses',
            NULL,
            NULL,
            NULL,
            NULL,
            'INSERT',
            $table_name,
            $record_id,
            NULL,
            $new_data
        );
    }

    /**
     * Log record UPDATE operation with field-by-field diff comparison and old vs new snapshots.
     *
     * @param string      $table_name
     * @param int|string  $record_id
     * @param array       $old_data
     * @param array       $new_data
     * @param string|null $modul
     * @param string|null $custom_desc
     * @return int|bool
     */
    public function log_update($table_name, $record_id, $old_data = array(), $new_data = array(), $modul = NULL, $custom_desc = NULL)
    {
        if (empty($modul)) {
            $modul = 'Manajemen ' . ucwords(str_replace('_', ' ', $table_name));
        }

        $diffs = $this->calculate_data_diff($old_data, $new_data);

        if (!empty($custom_desc)) {
            $description = $custom_desc;
            if (!empty($diffs)) {
                $description .= ' (Perubahan: ' . implode('; ', array_slice($diffs, 0, 4)) . (count($diffs) > 4 ? '; ...' : '') . ')';
            }
        } else {
            if (!empty($diffs)) {
                $description = 'Memperbarui data pada tabel [' . $table_name . '] (ID: ' . $record_id . '). Perubahan: ' . implode('; ', array_slice($diffs, 0, 5));
                if (count($diffs) > 5) {
                    $description .= ' (+ ' . (count($diffs) - 5) . ' field lainnya)';
                }
            } else {
                $description = 'Menyimpan pembaruan data pada tabel [' . $table_name . '] (ID: ' . $record_id . ') tanpa perubahan nilai.';
            }
        }

        return $this->log_activity(
            $modul,
            $description,
            'Sukses',
            NULL,
            NULL,
            NULL,
            NULL,
            'UPDATE',
            $table_name,
            $record_id,
            $old_data,
            $new_data
        );
    }

    /**
     * Log record DELETE or deactivation operation with old data snapshot.
     *
     * @param string      $table_name
     * @param int|string  $record_id
     * @param array       $old_data
     * @param string|null $modul
     * @param string|null $custom_desc
     * @return int|bool
     */
    public function log_delete($table_name, $record_id, $old_data = array(), $modul = NULL, $custom_desc = NULL)
    {
        if (empty($modul)) {
            $modul = 'Manajemen ' . ucwords(str_replace('_', ' ', $table_name));
        }

        $description = !empty($custom_desc)
            ? $custom_desc
            : 'Menghapus data dari tabel [' . $table_name . '] (ID: ' . $record_id . ')';

        $summary = $this->format_array_summary($old_data);
        if ($summary !== '-' && empty($custom_desc)) {
            $description .= '. Data terhapus: ' . $summary;
        }

        return $this->log_activity(
            $modul,
            $description,
            'Sukses',
            NULL,
            NULL,
            NULL,
            NULL,
            'DELETE',
            $table_name,
            $record_id,
            $old_data,
            NULL
        );
    }

    /**
     * Backwards-compatible alias for log_activity/log_update.
     *
     * @param string      $table_name
     * @param string      $action
     * @param int|string  $record_id
     * @param array       $old_data
     * @param array       $new_data
     * @param string|null $modul
     * @return bool
     */
    public function log_change($table_name, $action, $record_id, $old_data = array(), $new_data = array(), $modul = NULL)
    {
        $action = strtoupper($action);
        if ($action === 'INSERT') {
            return (bool) $this->log_insert($table_name, $record_id, $new_data, $modul);
        } elseif ($action === 'UPDATE') {
            return (bool) $this->log_update($table_name, $record_id, $old_data, $new_data, $modul);
        } elseif ($action === 'DELETE') {
            return (bool) $this->log_delete($table_name, $record_id, $old_data, $modul);
        }

        return (bool) $this->log_activity($modul ?: 'Aktivitas Data', 'Aksi ' . $action . ' pada tabel ' . $table_name, 'Sukses');
    }

    /**
     * Get list of audit logs formatted for presentation.
     *
     * @param int   $limit
     * @param int   $offset
     * @param array $filters
     * @return array
     */
    public function get_audit_logs($limit = 200, $offset = 0, $filters = array())
    {
        $rows = $this->CI->Audit_model->get_audit_list($limit, $offset, $filters);

        foreach ($rows as &$row) {
            $row['has_diff'] = (!empty($row['data_sebelum']) || !empty($row['data_sesudah']));
            if (empty($row['tipe_aksi'])) {
                $row['tipe_aksi'] = $this->infer_action_type($row['aktivitas'], $row['modul']);
            }
        }

        return $rows;
    }

    /**
     * Get KPI summary statistics for Audit Trail dashboard.
     *
     * @return array
     */
    public function get_audit_stats()
    {
        return $this->CI->Audit_model->get_stats();
    }

    /**
     * Fetch complete audit detail by ID including decoded Before & After data and diff matrix.
     *
     * @param int $id_audit
     * @return array
     */
    public function get_audit_detail($id_audit)
    {
        $id_audit = (int) $id_audit;
        if ($id_audit <= 0) {
            return array('status' => FALSE, 'message' => 'ID Audit tidak valid.');
        }

        $row = $this->CI->Audit_model->get_audit_by_id($id_audit);
        if (!$row) {
            return array('status' => FALSE, 'message' => 'Data log audit tidak ditemukan.');
        }

        // Decode JSON payloads
        $data_sebelum = !empty($row['data_sebelum']) ? json_decode($row['data_sebelum'], TRUE) : NULL;
        $data_sesudah = !empty($row['data_sesudah']) ? json_decode($row['data_sesudah'], TRUE) : NULL;

        if (empty($row['tipe_aksi'])) {
            $row['tipe_aksi'] = $this->infer_action_type($row['aktivitas'], $row['modul']);
        }

        // Generate field-by-field comparison matrix
        $comparison_matrix = $this->generate_comparison_matrix($data_sebelum, $data_sesudah);

        $response_data = array(
            'id_audit' => (int) $row['id_audit'],
            'timestamp' => $row['timestamp'],
            'formatted_time' => date('d M Y, H:i:s', strtotime($row['timestamp'])),
            'id_user' => $row['id_user'],
            'username' => $row['username'],
            'nama_user' => !empty($row['nama_user']) ? $row['nama_user'] : $row['username'],
            'role' => !empty($row['role']) ? ucfirst(str_replace('_', ' ', $row['role'])) : 'Tamu',
            'modul' => $row['modul'],
            'tipe_aksi' => $row['tipe_aksi'],
            'tabel_terkait' => $row['tabel_terkait'],
            'id_record' => $row['id_record'],
            'aktivitas' => $row['aktivitas'],
            'ip_address' => $row['ip_address'],
            'user_agent' => $row['user_agent'],
            'status' => $row['status'],
            'has_changes' => !empty($comparison_matrix),
            'comparison_matrix' => $comparison_matrix,
            'data_sebelum' => $data_sebelum,
            'data_sesudah' => $data_sesudah,
            'raw_metadata' => array(
                'system' => 'SPK BeRewards PN Lubuk Pakam',
                'environment' => ENVIRONMENT,
                'log_id' => (int) $row['id_audit'],
                'recorded_at' => $row['created_at'] ?: $row['timestamp'],
                'client_ip' => $row['ip_address'],
                'user_agent' => $row['user_agent'],
                'audit_version' => '2.0.0-PROD'
            )
        );

        return array(
            'status' => TRUE,
            'data' => $response_data
        );
    }

    /**
     * Generate field-by-field comparison matrix between old and new state.
     *
     * @param array|null $old_data
     * @param array|null $new_data
     * @return array
     */
    protected function generate_comparison_matrix($old_data, $new_data)
    {
        if (empty($old_data) && empty($new_data)) {
            return array();
        }

        if (!is_array($old_data))
            $old_data = array();
        if (!is_array($new_data))
            $new_data = array();

        $all_keys = array_unique(array_merge(array_keys($old_data), array_keys($new_data)));
        $matrix = array();

        $ignore_keys = array('created_at', 'updated_at', 'last_login');

        foreach ($all_keys as $key) {
            if (in_array($key, $ignore_keys)) {
                continue;
            }

            $old_val = isset($old_data[$key]) ? $old_data[$key] : NULL;
            $new_val = isset($new_data[$key]) ? $new_data[$key] : NULL;

            // Format values for human readability
            $old_display = $this->format_field_value($old_val, $key);
            $new_display = $this->format_field_value($new_val, $key);

            $is_changed = ((string) $old_val !== (string) $new_val);

            $status_label = 'Tetap';
            $badge_class = 'bg-secondary';

            if (!isset($old_data[$key]) && isset($new_data[$key])) {
                $status_label = 'Ditambahkan';
                $badge_class = 'bg-success';
                $is_changed = TRUE;
            } elseif (isset($old_data[$key]) && !isset($new_data[$key])) {
                $status_label = 'Dihapus';
                $badge_class = 'bg-danger';
                $is_changed = TRUE;
            } elseif ($is_changed) {
                $status_label = 'Diubah';
                $badge_class = 'bg-warning text-dark';
            }

            $matrix[] = array(
                'field_key' => $key,
                'field_label' => ucwords(str_replace('_', ' ', $key)),
                'old_value' => $old_display,
                'new_value' => $new_display,
                'is_changed' => $is_changed,
                'status_label' => $status_label,
                'badge_class' => $badge_class
            );
        }

        return $matrix;
    }

    /**
     * Format field value for clean display in comparison matrix.
     *
     * @param mixed  $val
     * @param string $key
     * @return string
     */
    protected function format_field_value($val, $key = '')
    {
        if (is_null($val)) {
            return '<span class="text-muted fst-italic">NULL / Kosong</span>';
        }

        if ($key === 'password') {
            return '<span class="badge bg-secondary font-monospace">•••••••• (Tersandi)</span>';
        }

        if (is_bool($val)) {
            return $val ? 'TRUE (1)' : 'FALSE (0)';
        }

        if (is_array($val) || is_object($val)) {
            return '<pre class="mb-0 fs-11 p-1 bg-light rounded">' . html_escape(json_encode($val, JSON_PRETTY_PRINT)) . '</pre>';
        }

        $str = (string) $val;
        if ($str === '') {
            return '<span class="text-muted fst-italic">(String Kosong)</span>';
        }

        if ($key === 'aktif' || $key === 'status') {
            if ($str === '1' || $str === 'buka' || $str === 'Aktif' || $str === 'Sukses') {
                return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5">' . html_escape($str) . '</span>';
            } elseif ($str === '0' || $str === 'tutup' || $str === 'Nonaktif' || $str === 'Gagal') {
                return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-0.5">' . html_escape($str) . '</span>';
            }
        }

        return html_escape($str);
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

    /**
     * Sanitize array by masking passwords and large binary data before JSON storage.
     *
     * @param array $data
     * @return array
     */
    protected function sanitize_sensitive_data($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $clean = array();
        foreach ($data as $k => $v) {
            if ($k === 'password') {
                $clean[$k] = '******** (HASHED)';
            } else {
                $clean[$k] = $v;
            }
        }

        return $clean;
    }

    /**
     * Infer action type if empty in legacy records.
     *
     * @param string $aktivitas
     * @param string $modul
     * @return string
     */
    protected function infer_action_type($aktivitas, $modul)
    {
        $act = strtolower($aktivitas);
        if (strpos($act, 'login') !== FALSE) {
            return 'LOGIN';
        } elseif (strpos($act, 'logout') !== FALSE || strpos($act, 'keluar') !== FALSE) {
            return 'LOGOUT';
        } elseif (strpos($act, 'menambahkan') !== FALSE || strpos($act, 'tambah') !== FALSE || strpos($act, 'insert') !== FALSE) {
            return 'INSERT';
        } elseif (strpos($act, 'memperbarui') !== FALSE || strpos($act, 'ubah') !== FALSE || strpos($act, 'update') !== FALSE || strpos($act, 'edit') !== FALSE) {
            return 'UPDATE';
        } elseif (strpos($act, 'menghapus') !== FALSE || strpos($act, 'hapus') !== FALSE || strpos($act, 'delete') !== FALSE || strpos($act, 'nonaktif') !== FALSE) {
            return 'DELETE';
        } elseif (strpos($act, 'topsis') !== FALSE || strpos($act, 'kalkulasi') !== FALSE || strpos($act, 'hitung') !== FALSE) {
            return 'PROSES_TOPSIS';
        } elseif (strpos($act, 'sah') !== FALSE || strpos($act, 'mengesahkan') !== FALSE || strpos($act, 'export') !== FALSE || strpos($act, 'cetak') !== FALSE) {
            return 'EXPORT';
        }

        return 'ACTIVITY';
    }
}
