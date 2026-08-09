# Arsitektur CodeIgniter 3 — Controller / Model / Service / View

CodeIgniter 3 secara bawaan hanya punya Controller-Model-View. Supaya
logika bisnis (validasi, orkestrasi TOPSIS, generate laporan) tidak
menumpuk di Controller atau bocor ke Model, tambahkan **lapisan Service**
sebagai kelas PHP biasa yang di-load lewat `MY_Loader`.

## Prinsip pembagian tanggung jawab

- **Controller** — tipis. Terima request, cek hak akses (lihat
  `references/rbac.md`), panggil satu/dua method Service, kembalikan
  view atau JSON. Tidak ada query SQL, tidak ada logika perhitungan di sini.
- **Service** — isi otak aplikasi. Validasi input, orkestrasi antar
  Model (mis. "buat proses TOPSIS" = insert header + snapshot kriteria +
  snapshot alternatif dalam satu transaksi), panggil `Topsis_service`
  untuk hitung, siapkan data untuk export Word. Service boleh memanggil
  banyak Model.
- **Model** — akses data murni. Query Builder CI3, tidak ada logika bisnis
  di sini selain query itu sendiri.
- **View** — presentasi saja. Tidak ada query, tidak ada logika bisnis;
  paling jauh looping/format tampilan.

Kenapa dipisah begini? Karena TOPSIS punya logika yang akan dipakai dari
beberapa tempat (jalankan proses baru, preview ulang, export laporan) —
kalau logikanya nempel di satu Controller, tiga tempat itu akan
duplikasi kode atau saling panggil Controller lain (anti-pattern di CI3).
Dengan Service, semua tempat itu tinggal `$this->load->service('...')`.

## Struktur folder

```
application/
├── controllers/
│   ├── Auth.php                     -- login/logout, publik
│   └── admin/
│       ├── Dashboard.php
│       ├── Pegawai.php              -- CRUD referensi_pegawai
│       ├── Kriteria.php             -- CRUD kriteria + skala_kriteria
│       ├── Periode.php              -- CRUD periode
│       ├── Proses.php               -- buat proses, pilih alternatif, input penilaian, jalankan hitung
│       ├── Laporan.php              -- preview hasil + export Berita Acara (.docx)
│       └── User.php                 -- CRUD akun (SUPERADMIN ONLY, lihat rbac.md)
├── models/
│   ├── Pegawai_model.php
│   ├── Kriteria_model.php
│   ├── Skala_kriteria_model.php
│   ├── Periode_model.php
│   ├── Proses_model.php
│   ├── Penilaian_model.php
│   ├── Hasil_model.php
│   └── User_model.php
├── services/                        -- BUKAN folder bawaan CI3, lihat MY_Loader di bawah
│   ├── Pegawai_service.php
│   ├── Kriteria_service.php
│   ├── Proses_service.php           -- orkestrasi snapshot + panggil Topsis_service
│   ├── Topsis_service.php           -- lihat assets/templates/Topsis_service.php
│   ├── Laporan_service.php          -- lihat references/word-export.md
│   └── Auth_service.php
├── core/
│   ├── MY_Loader.php                -- tambah method load->service()
│   └── MY_Controller.php            -- base controller: cek sesi & role, sediakan $this->service, $this->model
├── views/
│   ├── auth/login.php
│   ├── admin/
│   │   ├── pegawai/ (index, form partial untuk modal)
│   │   ├── kriteria/
│   │   ├── periode/
│   │   ├── proses/ (pilih alternatif, input matriks, hasil)
│   │   └── laporan/ (preview futuristik, lihat references/ui-guidelines.md)
│   └── templates/
│       ├── header.php / footer.php / sidebar.php
└── config/
    └── routes.php
```

## Mengaktifkan Service layer di CI3

Buat `application/core/MY_Loader.php`:

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
    /**
     * Load kelas Service dari application/services/ dan simpan sebagai
     * property di controller, sama seperti $this->load->model().
     *
     *   $this->load->service('Proses_service');
     *   $this->proses_service->buat_proses(...);
     */
    public function service($name, $object_name = null)
    {
        $path = APPPATH . 'services/' . $name . '.php';
        if (!file_exists($path)) {
            show_error("Service {$name} tidak ditemukan di application/services/");
        }
        require_once $path;

        $object_name = $object_name ?: strtolower($name);
        $CI =& get_instance();
        $CI->$object_name = new $name();

        return $this;
    }
}
```

Lengkap contoh `MY_Loader.php` siap-pakai ada di
`assets/templates/MY_Loader.php`.

## Base controller untuk cek sesi & role

`MY_Controller.php` memusatkan pengecekan login supaya tidak
copy-paste `if (!$this->session->userdata('logged_in'))` di setiap
Controller. Detail lengkap ada di `references/rbac.md`; intinya:

```php
class Admin_Controller extends CI_Controller
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->role = $this->session->userdata('role'); // 'superadmin' | 'administrator'
        $this->load->service('Auth_service');
    }

    /** Panggil di constructor controller yang superadmin-only, mis. User.php */
    protected function hanya_superadmin()
    {
        if ($this->role !== 'superadmin') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403);
        }
    }
}
```

Semua controller di `application/controllers/admin/` extend
`Admin_Controller` ini, bukan `CI_Controller` langsung.

## Pola AJAX CRUD

Semua CRUD (Pegawai, Kriteria, Periode, User) memakai pola yang sama:
listing pakai DataTables server-side atau client-side (untuk data yang
tidak akan sampai ribuan baris, client-side DataTables sudah cukup dan
lebih sederhana), form tambah/edit di dalam **Bootstrap modal**, submit
lewat AJAX supaya halaman tidak reload, notifikasi pakai SweetAlert2.

**Controller** (`application/controllers/admin/Pegawai.php`):

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('Pegawai_service');
    }

    public function index()
    {
        $this->load->view('admin/pegawai/index');
    }

    /** Dipanggil DataTables / AJAX listing */
    public function data()
    {
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($this->pegawai_service->daftar()));
    }

    public function simpan()
    {
        $input = $this->input->post(null, true); // true = XSS-clean
        $result = $this->pegawai_service->simpan($input);

        $this->output->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function hapus($id)
    {
        $result = $this->pegawai_service->hapus($id);
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
```

**Service** (`application/services/Pegawai_service.php`) — validasi &
aturan bisnis, mis. tidak boleh menghapus pegawai yang sudah pernah
jadi alternatif di suatu proses (integritas histori):

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_service
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Pegawai_model');
    }

    public function daftar()
    {
        return $this->CI->Pegawai_model->get_all();
    }

    public function simpan($input)
    {
        $this->CI->load->library('form_validation');
        $this->CI->form_validation->set_data($input);
        $this->CI->form_validation->set_rules('nip', 'NIP', 'required|trim');
        $this->CI->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->CI->form_validation->set_rules('kategori', 'Kategori', 'required');

        if (!$this->CI->form_validation->run()) {
            return ['status' => false, 'message' => validation_errors()];
        }

        $data = [
            'nip'      => $input['nip'],
            'nama'     => $input['nama'],
            'pangkat'  => $input['pangkat'] ?? null,
            'golongan' => $input['golongan'] ?? null,
            'jabatan'  => $input['jabatan'] ?? null,
            'kategori' => $input['kategori'],
            'aktif'    => $input['aktif'] ?? 1,
        ];

        if (!empty($input['id_pegawai'])) {
            $this->CI->Pegawai_model->update($input['id_pegawai'], $data);
        } else {
            $this->CI->Pegawai_model->insert($data);
        }

        return ['status' => true, 'message' => 'Data pegawai berhasil disimpan.'];
    }

    public function hapus($id)
    {
        $this->CI->load->model('Proses_model');
        if ($this->CI->Proses_model->pernah_jadi_alternatif($id)) {
            return ['status' => false, 'message' => 'Pegawai ini sudah punya riwayat penilaian dan tidak boleh dihapus. Nonaktifkan saja.'];
        }
        $this->CI->Pegawai_model->delete($id);
        return ['status' => true, 'message' => 'Data pegawai dihapus.'];
    }
}
```

**View / AJAX di sisi klien** — pola yang sama dipakai ulang di semua
modul CRUD (Pegawai, Kriteria, Periode, User):

```javascript
// simpan form lewat modal
$('#formPegawai').on('submit', function (e) {
  e.preventDefault();
  $.post(baseUrl + 'admin/pegawai/simpan', $(this).serialize(), function (res) {
    if (res.status) {
      Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
      $('#modalPegawai').modal('hide');
      tabelPegawai.ajax.reload(); // DataTables instance
    } else {
      Swal.fire({ icon: 'error', title: 'Gagal', html: res.message });
    }
  }, 'json');
});

// hapus dengan konfirmasi
function hapusPegawai(id) {
  Swal.fire({
    icon: 'warning', title: 'Yakin hapus data ini?', showCancelButton: true,
    confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
  }).then((r) => {
    if (r.isConfirmed) {
      $.post(baseUrl + 'admin/pegawai/hapus/' + id, function (res) {
        Swal.fire({ icon: res.status ? 'success' : 'error', title: res.message, timer: 1500, showConfirmButton: false });
        tabelPegawai.ajax.reload();
      }, 'json');
    }
  });
}
```

Terapkan pola identik ini untuk `Kriteria`, `Periode`, `User`. Untuk
modul **Proses** (input matriks penilaian & jalankan TOPSIS), lihat alur
khusus di bawah karena melibatkan beberapa tabel snapshot sekaligus.

## Alur modul Proses (yang paling banyak melibatkan Service)

1. Admin buat proses baru → pilih `periode` + `kategori` →
   `Proses_service::buat()` menyalin kriteria aktif kategori tsb ke
   `topsis_proses_kriteria`, dan pegawai aktif kategori tsb ke
   `topsis_proses_alternatif`, status jadi `draft`.
2. Admin input nilai per alternatif per kriteria (form dinamis — jumlah
   kolom = jumlah baris di `topsis_proses_kriteria`, dropdown untuk
   kualitatif / input angka untuk kuantitatif) → simpan ke `penilaian`
   lewat AJAX per sel atau submit satu form besar. Setelah semua sel
   terisi, status → `dinilai`.
3. Admin klik "Hitung TOPSIS" → `Proses_service::hitung()` ambil semua
   `penilaian` jadi matriks array, panggil `Topsis_service::hitung()`,
   simpan hasil ke `hasil_topsis`, status → `dihitung`.
4. Admin preview hasil (lihat `references/ui-guidelines.md`) lalu export
   Berita Acara (lihat `references/word-export.md`), status → `final`
   (kunci dari edit lebih lanjut — kalau perlu revisi, buat proses baru,
   jangan edit proses yang sudah final, supaya jejak histori jujur).

Setiap perpindahan status baiknya dicatat ke `log_aktivitas`.
