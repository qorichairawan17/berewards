<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting_service
 * 
 * Service Layer for managing Application & Satuan Kerja (Satker) Settings,
 * Judicial Leadership Directory, Document/Word Header Kop Configurations, and Logo Uploads.
 * Following Clean Architecture: Encapsulates all business logic, server-side validation,
 * file management, and audit logging.
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Setting_service
{
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
        $this->CI->load->model('Setting_model');
        $this->CI->load->library('form_validation');

        // Load Audit_service if available
        if (!isset($this->CI->audit_service)) {
            if (method_exists($this->CI->load, 'service')) {
                @$this->CI->load->service('audit_service');
            }
        }
    }

    /**
     * Get all satker setting parameters in a complete structured format.
     *
     * @param bool $force_refresh
     * @return array
     */
    public function get_settings($force_refresh = FALSE)
    {
        if (!$force_refresh && $this->settings_cache !== NULL) {
            return $this->settings_cache;
        }

        // Default standard configuration template
        $default = array(
            'id_setting'          => 1,
            'nama_satker'         => 'Pengadilan Negeri Lubuk Pakam Kelas I-A',
            'singkatan'           => 'PN Lubuk Pakam',
            'kode_satker'         => '005021',
            'kode_wilayah'        => 'W2.U4',
            'tingkat_pengadilan'  => 'Pengadilan Negeri Kelas I-A',
            'kelas_pengadilan'    => 'Kelas I-A',
            'pengadilan_tinggi'   => 'Pengadilan Tinggi Medan',
            'alamat'              => 'Jl. Sisingamangaraja No. 182, Lubuk Pakam, Kabupaten Deli Serdang, Sumatera Utara 20511',
            'kota'                => 'Lubuk Pakam',
            'provinsi'            => 'Sumatera Utara',
            'kode_pos'            => '20511',
            'telepon'             => '(061) 7951234',
            'fax'                 => '(061) 7952182',
            'email'               => 'pn.lubukpakam@mahkamahagung.go.id',
            'website'             => 'https://pn-lubukpakam.go.id',
            'nama_ketua'          => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
            'nip_ketua'           => '19680512 199303 1 001',
            'pangkat_ketua'       => 'Pembina Utama Muda (IV/c)',
            'nama_wakil_ketua'    => 'Hj. Fitriani, S.H., M.H.',
            'nip_wakil_ketua'     => '19720820 199703 2 002',
            'pangkat_wakil_ketua' => 'Pembina Tk. I (IV/b)',
            'nama_panitera'       => 'Bambang Wijaya, S.H., M.H.',
            'nip_panitera'        => '19750310 199903 1 003',
            'pangkat_panitera'    => 'Pembina (IV/a)',
            'nama_sekretaris'     => 'Drs. Muhammad Rizky',
            'nip_sekretaris'      => '19781115 200212 1 004',
            'pangkat_sekretaris'  => 'Pembina (IV/a)',
            'logo'                => 'assets/images/logo-pn.png',
            'kop_line1'           => 'PENGADILAN NEGERI LUBUK PAKAM KELAS I-A',
            'kop_line2'           => 'JL. SISINGAMANGARAJA NO. 182, LUBUK PAKAM, DELI SERDANG 20511',
            'format_nomor_sk'     => 'W2.U4/{NO}/SK.TIM-SPK/{BLN}/{THN}',
            'format_nomor_ba'     => '[KODE_WILAYAH]/[NO_URUT]/BA.SPK/[BULAN_ROMAWI]/[TAHUN]',
            'metode'              => 'TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)'
        );

        $db_row = $this->CI->Setting_model->get_setting_row(1);
        if (!empty($db_row) && is_array($db_row)) {
            foreach ($default as $key => $val) {
                if (array_key_exists($key, $db_row) && $db_row[$key] !== NULL && $db_row[$key] !== '') {
                    $default[$key] = $db_row[$key];
                }
            }
        }

        // Structure into clean sub-arrays for template views
        $satker = array(
            'nama_satker'        => $default['nama_satker'],
            'singkatan'          => $default['singkatan'],
            'kode_satker'        => $default['kode_satker'],
            'kode_wilayah'       => $default['kode_wilayah'],
            'tingkat_pengadilan' => $default['tingkat_pengadilan'],
            'kelas_pengadilan'   => $default['kelas_pengadilan'],
            'pengadilan_tinggi'  => $default['pengadilan_tinggi'],
            'alamat'             => $default['alamat'],
            'kota'               => $default['kota'],
            'provinsi'           => $default['provinsi'],
            'kode_pos'           => $default['kode_pos'],
            'telepon'            => $default['telepon'],
            'fax'                => $default['fax'],
            'email'              => $default['email'],
            'website'            => $default['website'],
            'logo'               => $default['logo']
        );

        $pimpinan = array(
            'ketua' => array(
                'jabatan' => 'Ketua Pengadilan Negeri',
                'nama'    => $default['nama_ketua'],
                'nip'     => $default['nip_ketua'],
                'pangkat' => $default['pangkat_ketua'],
                'foto'    => 'assets/images/users/user-1.jpg'
            ),
            'wakil_ketua' => array(
                'jabatan' => 'Wakil Ketua Pengadilan Negeri',
                'nama'    => $default['nama_wakil_ketua'],
                'nip'     => $default['nip_wakil_ketua'],
                'pangkat' => $default['pangkat_wakil_ketua'],
                'foto'    => 'assets/images/users/user-2.jpg'
            ),
            'panitera' => array(
                'jabatan' => 'Panitera Pengadilan Negeri',
                'nama'    => $default['nama_panitera'],
                'nip'     => $default['nip_panitera'],
                'pangkat' => $default['pangkat_panitera'],
                'foto'    => 'assets/images/users/user-4.jpg'
            ),
            'sekretaris' => array(
                'jabatan' => 'Sekretaris Pengadilan Negeri',
                'nama'    => $default['nama_sekretaris'],
                'nip'     => $default['nip_sekretaris'],
                'pangkat' => $default['pangkat_sekretaris'],
                'foto'    => 'assets/images/users/user-5.jpg'
            )
        );

        $app = array(
            'nama_aplikasi'   => 'BeRewards',
            'deskripsi'       => 'Sistem Pendukung Keputusan Penentuan Reward Pegawai Metode TOPSIS',
            'kop_line1'       => $default['kop_line1'],
            'kop_line2'       => $default['kop_line2'],
            'format_nomor_sk' => $default['format_nomor_sk'],
            'format_nomor_ba' => $default['format_nomor_ba'],
            'metode'          => $default['metode'],
            'status'          => 'Aktif & Terkonfigurasi'
        );

        $result = array_merge($default, array(
            'satker'   => $satker,
            'pimpinan' => $pimpinan,
            'app'      => $app
        ));

        $this->settings_cache = $result;
        return $this->settings_cache;
    }

    /**
     * Get single setting value by key with fallback.
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
     * Save/Update Satker Profile configuration.
     *
     * @param array $input POST payload
     * @return array Status payload
     */
    public function simpan_satker($input)
    {
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('nama_satker', 'Nama Satuan Kerja', 'required|trim');
        $this->CI->form_validation->set_rules('singkatan', 'Singkatan Satker', 'required|trim');
        $this->CI->form_validation->set_rules('kode_satker', 'Kode Satker', 'required|trim');
        $this->CI->form_validation->set_rules('kode_wilayah', 'Kode Wilayah', 'required|trim');
        $this->CI->form_validation->set_rules('kelas_pengadilan', 'Kelas Pengadilan', 'required|trim');
        $this->CI->form_validation->set_rules('alamat', 'Alamat Satker', 'required|trim');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $data = array(
            'nama_satker'        => trim($input['nama_satker']),
            'singkatan'          => trim($input['singkatan']),
            'kode_satker'        => trim($input['kode_satker']),
            'kode_wilayah'       => trim($input['kode_wilayah']),
            'tingkat_pengadilan' => isset($input['tingkat_pengadilan']) ? trim($input['tingkat_pengadilan']) : ('Pengadilan Negeri ' . trim($input['kelas_pengadilan'])),
            'kelas_pengadilan'   => trim($input['kelas_pengadilan']),
            'pengadilan_tinggi'  => isset($input['pengadilan_tinggi']) ? trim($input['pengadilan_tinggi']) : '',
            'alamat'             => trim($input['alamat']),
            'kota'               => isset($input['kota']) ? trim($input['kota']) : '',
            'provinsi'           => isset($input['provinsi']) ? trim($input['provinsi']) : '',
            'kode_pos'           => isset($input['kode_pos']) ? trim($input['kode_pos']) : '',
            'telepon'            => isset($input['telepon']) ? trim($input['telepon']) : '',
            'fax'                => isset($input['fax']) ? trim($input['fax']) : '',
            'email'              => isset($input['email']) ? trim($input['email']) : '',
            'website'            => isset($input['website']) ? trim($input['website']) : ''
        );

        $saved = $this->update_settings($data, 'Memperbarui Profil Satuan Kerja');
        if (!$saved) {
            return array('status' => FALSE, 'message' => 'Gagal memperbarui profil satuan kerja.');
        }

        return array(
            'status'  => TRUE,
            'message' => 'Profil & Identitas Satuan Kerja berhasil diperbarui.'
        );
    }

    /**
     * Save/Update Leadership Personnel data.
     *
     * @param array $input POST payload
     * @return array Status payload
     */
    public function simpan_pimpinan($input)
    {
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('nama_ketua', 'Nama Ketua Pengadilan', 'required|trim');
        $this->CI->form_validation->set_rules('nip_ketua', 'NIP Ketua Pengadilan', 'required|trim');
        $this->CI->form_validation->set_rules('nama_panitera', 'Nama Panitera', 'required|trim');
        $this->CI->form_validation->set_rules('nip_panitera', 'NIP Panitera', 'required|trim');
        $this->CI->form_validation->set_rules('nama_sekretaris', 'Nama Sekretaris', 'required|trim');
        $this->CI->form_validation->set_rules('nip_sekretaris', 'NIP Sekretaris', 'required|trim');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $data = array(
            'nama_ketua'          => trim($input['nama_ketua']),
            'nip_ketua'           => trim($input['nip_ketua']),
            'pangkat_ketua'       => isset($input['pangkat_ketua']) ? trim($input['pangkat_ketua']) : '',
            'nama_wakil_ketua'    => isset($input['nama_wakil_ketua']) ? trim($input['nama_wakil_ketua']) : '',
            'nip_wakil_ketua'     => isset($input['nip_wakil_ketua']) ? trim($input['nip_wakil_ketua']) : '',
            'pangkat_wakil_ketua' => isset($input['pangkat_wakil_ketua']) ? trim($input['pangkat_wakil_ketua']) : '',
            'nama_panitera'       => trim($input['nama_panitera']),
            'nip_panitera'        => trim($input['nip_panitera']),
            'pangkat_panitera'    => isset($input['pangkat_panitera']) ? trim($input['pangkat_panitera']) : '',
            'nama_sekretaris'     => trim($input['nama_sekretaris']),
            'nip_sekretaris'      => trim($input['nip_sekretaris']),
            'pangkat_sekretaris'  => isset($input['pangkat_sekretaris']) ? trim($input['pangkat_sekretaris']) : ''
        );

        $saved = $this->update_settings($data, 'Memperbarui Susunan Pimpinan Pengadilan');
        if (!$saved) {
            return array('status' => FALSE, 'message' => 'Gagal memperbarui susunan pimpinan pengadilan.');
        }

        return array(
            'status'  => TRUE,
            'message' => 'Susunan Pejabat Pimpinan Pengadilan berhasil diperbarui.'
        );
    }

    /**
     * Save/Update SPK parameters & Document Word Header Kop text.
     *
     * @param array $input POST payload
     * @return array Status payload
     */
    public function simpan_app_config($input)
    {
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('kop_line1', 'Teks Kop Surat Baris 1', 'required|trim');
        $this->CI->form_validation->set_rules('kop_line2', 'Teks Kop Surat Baris 2', 'required|trim');
        $this->CI->form_validation->set_rules('format_nomor_ba', 'Format Nomor Berita Acara', 'required|trim');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $data = array(
            'kop_line1'       => trim($input['kop_line1']),
            'kop_line2'       => trim($input['kop_line2']),
            'format_nomor_ba' => trim($input['format_nomor_ba'])
        );

        if (!empty($input['format_nomor_sk'])) {
            $data['format_nomor_sk'] = trim($input['format_nomor_sk']);
        }

        $saved = $this->update_settings($data, 'Memperbarui Konfigurasi SPK & Kop Berita Acara');
        if (!$saved) {
            return array('status' => FALSE, 'message' => 'Gagal memperbarui konfigurasi SPK & Kop Surat.');
        }

        return array(
            'status'  => TRUE,
            'message' => 'Konfigurasi Mesin TOPSIS & Cetakan Dokumen berhasil diperbarui.'
        );
    }

    /**
     * Upload and update court Satker logo.
     *
     * @param string $file_field Name of $_FILES field
     * @return array
     */
    public function upload_logo($file_field = 'logo')
    {
        if (empty($_FILES[$file_field]['name'])) {
            return array('status' => FALSE, 'message' => 'Silakan pilih file logo terlebih dahulu.');
        }

        $upload_path = FCPATH . 'assets/images/';
        if (!is_dir($upload_path)) {
            @mkdir($upload_path, 0777, TRUE);
        }

        $config = array(
            'upload_path'   => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|svg',
            'max_size'      => 2048, // 2MB
            'file_name'     => 'logo-satker-' . time(),
            'overwrite'     => TRUE
        );

        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);

        if (!$this->CI->upload->do_upload($file_field)) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags($this->CI->upload->display_errors())
            );
        }

        $upload_data = $this->CI->upload->data();
        $relative_path = 'assets/images/' . $upload_data['file_name'];

        $this->update_settings(array('logo' => $relative_path), 'Mengunggah Logo Resmi Satuan Kerja');

        return array(
            'status'    => TRUE,
            'message'   => 'Logo Resmi Satuan Kerja berhasil diunggah dan diperbarui.',
            'logo_path' => $relative_path,
            'logo_url'  => base_url($relative_path)
        );
    }

    /**
     * Core update method with cache busting and audit logging.
     *
     * @param array  $data
     * @param string $action_desc
     * @return bool
     */
    public function update_settings($data, $action_desc = 'Memperbarui Pengaturan Sistem')
    {
        if (empty($data) || !is_array($data)) {
            return FALSE;
        }

        $old_settings = $this->get_settings(TRUE);
        $result = $this->CI->Setting_model->save_setting_row($data, 1);

        if ($result) {
            $this->settings_cache = NULL;

            // Log activity to audit trail
            if (isset($this->CI->audit_service)) {
                if (method_exists($this->CI->audit_service, 'log_update')) {
                    @$this->CI->audit_service->log_update(
                        'pengaturan',
                        1,
                        $old_settings,
                        $data,
                        'Pengaturan Sistem',
                        $action_desc
                    );
                } elseif (method_exists($this->CI->audit_service, 'log_change')) {
                    @$this->CI->audit_service->log_change(
                        'pengaturan',
                        'UPDATE',
                        1,
                        $old_settings,
                        $data,
                        'Pengaturan Sistem'
                    );
                }
            }

            return TRUE;
        }

        return FALSE;
    }
}

