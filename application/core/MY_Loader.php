<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Loader — Ekstensi CI_Loader untuk mendukung Service layer.
 *
 * Menambahkan method $this->load->service('NamaService') sehingga
 * service file di application/services/ dapat di-load persis seperti model.
 *
 * Contoh penggunaan di Controller:
 *   $this->load->service('Laporan_service');
 *   $this->laporan_service->export_berita_acara($data);
 */
class MY_Loader extends CI_Loader
{
    /**
     * Load sebuah Service dari application/services/.
     *
     * @param  string      $service    Nama file/class service (case-insensitive).
     * @param  string|null $object_name Nama property yang dipakai di Controller.
     *                                  Default: nama class service (huruf kecil).
     * @return void
     */
    public function service($service, $object_name = null)
    {
        // Normalkan nama service
        $service = trim($service);

        // Path ke file service
        $path = APPPATH . 'services/' . $service . '.php';

        if (!file_exists($path)) {
            show_error(
                'Service file tidak ditemukan: <strong>' . $path . '</strong>',
                500,
                'Service Not Found'
            );
        }

        require_once $path;

        // Class name = nama file (konvensi sama seperti Model CI3)
        $class_name = $service;

        // Nama property di Controller
        if (empty($object_name)) {
            $object_name = strtolower($class_name);
        }

        $CI =& get_instance();

        // Hindari double-load
        if (isset($CI->$object_name)) {
            return;
        }

        $CI->$object_name = new $class_name();
    }
}
