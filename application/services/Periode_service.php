<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Periode_service
 * Service Layer for handling Periode Penilaian business logic, validation,
 * date range integrity checks, and audit logging.
 * Decouples logic from Controllers and Models in accordance with Clean Architecture principles.
 */
class Periode_service
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
        $this->CI->load->model('Periode_model');
        $this->CI->load->library('form_validation');

        // Optional load Audit_service if present
        if (!isset($this->CI->audit_service)) {
            if (method_exists($this->CI->load, 'service')) {
                @$this->CI->load->service('audit_service');
            }
        }
    }

    /**
     * Fetch all period records.
     *
     * @param bool $aktif_only
     * @return array
     */
    public function get_all_periode($aktif_only = FALSE)
    {
        return $this->CI->Periode_model->get_all_periode($aktif_only);
    }

    /**
     * Fetch KPI card summary statistics for Periode module.
     *
     * @return array
     */
    public function get_stats()
    {
        return $this->CI->Periode_model->get_stats();
    }

    /**
     * Fetch single period detail record by ID.
     *
     * @param int $id_periode
     * @return array
     */
    public function get_periode_detail($id_periode)
    {
        $id_periode = (int)$id_periode;
        if ($id_periode <= 0) {
            return array('status' => FALSE, 'message' => 'ID Periode tidak valid.');
        }

        $periode = $this->CI->Periode_model->get_periode_by_id($id_periode);
        if (!$periode) {
            return array('status' => FALSE, 'message' => 'Data Periode Penilaian tidak ditemukan.');
        }

        return array('status' => TRUE, 'data' => $periode);
    }

    /**
     * Save (insert or update) period record.
     *
     * @param array $input Data array from $_POST
     * @return array Response payload array
     */
    public function simpan_periode($input)
    {
        $id_periode = !empty($input['id_periode']) ? (int)$input['id_periode'] : NULL;

        // Set Form Validation Rules
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('nama_periode', 'Nama Periode', 'required|trim');
        $this->CI->form_validation->set_rules('jenis_periode', 'Jenis Siklus', 'required|trim|in_list[bulanan,triwulan,semester,tahunan]');
        $this->CI->form_validation->set_rules('tahun', 'Tahun Anggaran', 'required|numeric');
        $this->CI->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required|trim');
        $this->CI->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required|trim');
        $this->CI->form_validation->set_rules('status', 'Status Akses', 'required|trim|in_list[buka,tutup]');

        if (!$this->CI->form_validation->run()) {
            return array(
                'status'  => FALSE,
                'message' => strip_tags(validation_errors('<div>', '</div>'))
            );
        }

        $nama_periode    = trim($input['nama_periode']);
        $jenis_periode   = trim($input['jenis_periode']);
        $tahun           = (int)$input['tahun'];
        $tanggal_mulai   = trim($input['tanggal_mulai']);
        $tanggal_selesai = trim($input['tanggal_selesai']);
        $status          = trim($input['status']);
        $keterangan      = !empty($input['keterangan']) ? trim($input['keterangan']) : NULL;
        $user_id         = $this->CI->session->userdata('user_id');

        // Validate Date Range
        if (strtotime($tanggal_mulai) > strtotime($tanggal_selesai)) {
            return array(
                'status'  => FALSE,
                'message' => 'Tanggal Mulai tidak boleh lebih besar dari Tanggal Selesai.'
            );
        }

        // Build Data Array
        $data = array(
            'nama_periode'    => $nama_periode,
            'jenis_periode'   => $jenis_periode,
            'tahun'           => $tahun,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'keterangan'      => $keterangan,
            'status'          => $status,
            'aktif'           => 1
        );

        if (!empty($user_id)) {
            $data['created_by'] = (int)$user_id;
        }

        // Execute Database Transaction
        $this->CI->db->trans_start();

        if (!empty($id_periode)) {
            // Update Operation
            $this->CI->Periode_model->update_periode($id_periode, $data);
            $act_msg = 'Memperbarui Periode Penilaian (' . $nama_periode . ')';
        } else {
            // Insert Operation
            $this->CI->Periode_model->insert_periode($data);
            $act_msg = 'Menambahkan Periode Penilaian baru (' . $nama_periode . ')';
        }

        $this->CI->db->trans_complete();

        if ($this->CI->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'message' => 'Gagal menyimpan data Periode Penilaian ke database.');
        }

        $this->log_audit('Periode Penilaian', $act_msg);

        return array(
            'status'  => TRUE,
            'message' => 'Periode Penilaian (' . html_escape($nama_periode) . ') berhasil disimpan.'
        );
    }

    /**
     * Deactivate/delete period record.
     *
     * @param int $id_periode
     * @return array
     */
    public function hapus_periode($id_periode)
    {
        $id_periode = (int)$id_periode;
        if ($id_periode <= 0) {
            return array('status' => FALSE, 'message' => 'ID Periode tidak valid.');
        }

        $periode = $this->CI->Periode_model->get_periode_by_id($id_periode);
        if (!$periode) {
            return array('status' => FALSE, 'message' => 'Data Periode Penilaian tidak ditemukan.');
        }

        $deleted = $this->CI->Periode_model->delete_periode($id_periode, FALSE);
        if (!$deleted) {
            return array('status' => FALSE, 'message' => 'Gagal menonaktifkan data Periode Penilaian.');
        }

        $this->log_audit('Periode Penilaian', 'Menonaktifkan Periode ' . $periode['nama_periode']);

        return array(
            'status'  => TRUE,
            'message' => 'Periode Penilaian (' . html_escape($periode['nama_periode']) . ') telah ditutup/dinonaktifkan.'
        );
    }

    /**
     * Private helper to log audit trail.
     *
     * @param string $modul
     * @param string $aktivitas
     * @return void
     */
    private function log_audit($modul, $aktivitas)
    {
        if (isset($this->CI->audit_service)) {
            $user_id   = $this->CI->session->userdata('user_id');
            $username  = $this->CI->session->userdata('username');
            $nama_user = $this->CI->session->userdata('nama_lengkap');
            $role      = $this->CI->session->userdata('role');
            @$this->CI->audit_service->log_activity($modul, $aktivitas, 'Sukses', $user_id, $username, $nama_user, $role);
        }
    }
}
