# Autentikasi & Hak Akses — Superadmin vs Administrator

Hanya dua role sistem (bukan pegawai yang dinilai — mereka ada di
`referensi_pegawai` sebagai data, bukan akun login):

| Modul | Superadmin | Administrator |
|---|:---:|:---:|
| Dashboard | ✅ | ✅ |
| Master Data Pegawai (`referensi_pegawai`) | ✅ | ✅ |
| Master Kriteria & Skala | ✅ | ✅ |
| Master Periode | ✅ | ✅ |
| Proses Penilaian & Hitung TOPSIS | ✅ | ✅ |
| Preview & Export Laporan (Berita Acara) | ✅ | ✅ |
| Log Aktivitas | ✅ | ✅ (read-only) |
| **Kelola Pengguna** (`users`: tambah/edit/hapus/reset password akun) | ✅ | ❌ |
| Pengaturan sistem umum (kop surat, dsb, jika ada) | ✅ | opsional — putuskan sesuai kebutuhan, defaultnya ikutkan di Superadmin karena berdampak ke semua orang |

Satu-satunya pembeda adalah **modul Kelola Pengguna**. Semua modul lain
identik antara kedua role. Jangan menambah pembatasan tersembunyi lain
tanpa diminta — di luar tabel ini, treat Administrator sama seperti
Superadmin.

## Implementasi sesi login

Simpan minimal ini di `$this->session` setelah login berhasil:

```php
$this->session->set_userdata([
    'logged_in'    => true,
    'id_user'      => $user['id_user'],
    'username'     => $user['username'],
    'nama_lengkap' => $user['nama_lengkap'],
    'role'         => $user['role'], // 'superadmin' | 'administrator'
]);
```

## Guard di level Controller

Gunakan `Admin_Controller` (lihat `references/architecture.md`) sebagai
induk semua controller area admin — otomatis redirect ke login kalau
sesi tidak ada. Untuk controller yang superadmin-only (`User.php`),
panggil pengecekan tambahan di constructor:

```php
class User extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->hanya_superadmin(); // dari Admin_Controller, show_error 403 kalau bukan superadmin
    }
    // ...
}
```

Jangan hanya menyembunyikan menu "Kelola Pengguna" di sidebar untuk
Administrator — itu bukan proteksi, hanya kosmetik. Guard di
Controller wajib ada supaya akses langsung lewat URL tetap diblokir.

## Guard di level View (untuk sembunyikan menu)

Selain guard Controller di atas, sembunyikan juga menu di sidebar
supaya Administrator tidak melihat tautan yang toh akan ditolak:

```php
<?php if ($this->session->userdata('role') === 'superadmin'): ?>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/user') ?>">
      <i class="bi bi-people"></i> Kelola Pengguna
    </a>
  </li>
<?php endif; ?>
```

## Password

Simpan hash dengan `password_hash($password, PASSWORD_BCRYPT)`, verifikasi
dengan `password_verify()`. Jangan pernah simpan password plain text atau
pakai `md5()`/`sha1()` — ini poin yang tidak bisa ditawar untuk sistem
instansi pemerintah.

## Audit trail

Setiap aksi tambah/ubah/hapus di modul manapun, terutama Kelola
Pengguna dan Proses TOPSIS (karena berujung ke dokumen resmi), sebaiknya
dicatat ke `log_aktivitas` (lihat `references/database-schema.md`) —
`id_user` dari sesi, `aksi`, `modul`, dan `keterangan` singkat (mis.
"Menghapus pegawai NIP 1987...").
