<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Loader
 *
 * Taruh file ini di application/core/MY_Loader.php.
 * Menambahkan $this->load->service('Nama_service') supaya proyek bisa
 * punya lapisan Service terpisah dari Model, tanpa keluar dari konvensi
 * CodeIgniter 3. Lihat references/architecture.md untuk alasan desainnya.
 */
class MY_Loader extends CI_Loader
{
    /**
     * @param string      $name        Nama file/kelas di application/services/, mis. 'Pegawai_service'
     * @param string|null $object_name Nama property di controller, default: lowercase($name)
     */
    public function service($name, $object_name = null)
    {
        $path = APPPATH . 'services/' . $name . '.php';

        if (!file_exists($path)) {
            show_error("Service '{$name}' tidak ditemukan di application/services/{$name}.php");
        }

        require_once $path;

        if (!class_exists($name)) {
            show_error("File {$name}.php ditemukan tapi tidak berisi class bernama {$name}.");
        }

        $object_name = $object_name ?: strtolower($name);

        $CI =& get_instance();
        if (isset($CI->$object_name)) {
            // Sudah pernah di-load, jangan buat instance baru.
            return $this;
        }
        $CI->$object_name = new $name();

        return $this;
    }
}
