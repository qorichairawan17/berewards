<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting_service
 * Service Layer for Handling Application Satker Settings and Configuration.
 * PHP 5.6+ and CodeIgniter 3 Compatible.
 */
class Setting_service {

    /**
     * CodeIgniter Super Object Instance
     * @var CI_Controller
     */
    protected $CI;

    /**
     * Cached settings array
     * @var array|null
     */
    protected $settings_cache = NULL;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    /**
     * Get all satker setting parameters.
     *
     * @return array
     */
    public function get_settings()
    {
        if ($this->settings_cache !== NULL) {
            return $this->settings_cache;
        }

        $default_settings = array(
            'id_setting'         => 1,
            'nama_satker'        => 'Pengadilan Negeri Lubuk Pakam Kelas I-A',
            'kode_satker'        => 'W2.U4',
            'tingkat_pengadilan' => 'Pengadilan Negeri Kelas I-A',
            'alamat'             => 'Jl. Jenderal Sudirman No. 18, Lubuk Pakam, Kabupaten Deli Serdang, Sumatera Utara 20511',
            'telepon'            => '(061) 7951234 / 7955678',
            'email'              => 'info@pn-lubukpakam.go.id',
            'website'            => 'https://pn-lubukpakam.go.id',
            'nama_ketua'         => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
            'nip_ketua'          => '19700115 199503 1 001',
            'nama_panitera'      => 'Bambang Wijaya, S.H., M.H.',
            'nip_panitera'       => '19720520 199803 1 002',
            'nama_sekretaris'    => 'Drs. Muhammad Rizky',
            'nip_sekretaris'     => '19740810 200103 1 003',
            'logo'               => 'assets/icons/logo.png',
            'format_nomor_sk'    => 'W2.U4/{NO}/SK.SPK/{BLN}/{THN}'
        );

        if ($this->CI->db->table_exists('pengaturan')) {
            $row = $this->CI->db->get_where('pengaturan', array('id_setting' => 1))->row_array();
            if ($row) {
                foreach ($default_settings as $key => $val) {
                    if (array_key_exists($key, $row) && $row[$key] !== NULL && $row[$key] !== '') {
                        $default_settings[$key] = $row[$key];
                    }
                }
            }
        }

        $this->settings_cache = $default_settings;
        return $this->settings_cache;
    }

    /**
     * Get a specific setting parameter by key.
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function get($key, $default = NULL)
    {
        $settings = $this->get_settings();
        if (array_key_exists($key, $settings)) {
            return $settings[$key];
        }
        return $default;
    }

    /**
     * Update satker settings data and record audit log.
     *
     * @param array $data
     * @return bool
     */
    public function update_settings($data)
    {
        if (empty($data) || !is_array($data)) {
            return FALSE;
        }

        $old_settings = $this->get_settings();
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($this->CI->db->table_exists('pengaturan')) {
            $exists = $this->CI->db->get_where('pengaturan', array('id_setting' => 1))->row_array();
            if ($exists) {
                $this->CI->db->where('id_setting', 1);
                $result = $this->CI->db->update('pengaturan', $data);
            } else {
                $data['id_setting'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $result = $this->CI->db->insert('pengaturan', $data);
            }

            if ($result) {
                $this->settings_cache = NULL;

                if (!isset($this->CI->audit_service)) {
                    $this->CI->load->service('audit_service');
                }

                if (isset($this->CI->audit_service)) {
                    $this->CI->audit_service->log_change('pengaturan', 'UPDATE', 1, $old_settings, $data, 'Pengaturan Sistem');
                }

                return TRUE;
            }
        }

        return FALSE;
    }
}
