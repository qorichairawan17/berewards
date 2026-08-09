<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin_Controller
 *
 * Taruh di application/core/Admin_Controller.php. Semua controller di
 * application/controllers/admin/ extend kelas ini (bukan CI_Controller
 * langsung) supaya cek sesi & role terpusat di satu tempat.
 * Lihat references/architecture.md dan references/rbac.md.
 */
class Admin_Controller extends CI_Controller
{
    /** @var string 'superadmin' | 'administrator' */
    protected $role;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }

        $this->role = $this->session->userdata('role');

        // Tersedia di semua view admin tanpa perlu di-pass manual tiap controller.
        $this->data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
        $this->data['role']         = $this->role;
    }

    /**
     * Panggil di constructor controller yang HANYA boleh diakses Superadmin,
     * mis. controller Kelola Pengguna. Lihat references/rbac.md untuk daftar
     * modul mana saja yang perlu ini (saat ini hanya modul Pengguna).
     */
    protected function hanya_superadmin()
    {
        if ($this->role !== 'superadmin') {
            show_error('Anda tidak memiliki akses ke halaman ini. Hubungi Superadmin jika ini seharusnya bisa diakses.', 403, 'Akses Ditolak');
        }
    }

    /**
     * Helper seragam untuk response AJAX supaya format JSON konsisten
     * di semua controller (status, message, data opsional).
     */
    protected function json($status, $message, $data = null)
    {
        $payload = ['status' => (bool) $status, 'message' => $message];
        if ($data !== null) {
            $payload['data'] = $data;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }
}
