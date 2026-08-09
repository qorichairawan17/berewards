# BeRewards — SPK Penentuan Reward Pengadilan Negeri Lubuk Pakam

> **Sistem Pendukung Keputusan Penentuan Reward Terbaik Bagi Hakim, Panitera Pengganti, Jurusita, dan Staf Pengadilan Negeri Lubuk Pakam Kelas I-A Menggunakan Metode TOPSIS**

---

## 📌 Tentang Proyek

**BeRewards** adalah aplikasi web Sistem Pendukung Keputusan (SPK) yang dirancang untuk **menentukan penerima reward pegawai terbaik** di lingkungan Pengadilan Negeri Lubuk Pakam Kelas I-A secara **objektif, terukur, dan transparan** menggunakan metode **TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)**.

Aplikasi ini mendukung proses penilaian kinerja untuk empat kategori pegawai:

- ⚖️ **Hakim**
- 📋 **Panitera Pengganti**
- 🏛️ **Jurusita**
- 🗂️ **Staf**

---

## ✨ Fitur Utama

| Modul | Deskripsi |
|---|---|
| 🏠 **Dashboard** | Ringkasan KPI, spotlight penerima reward terbaik, navigasi cepat antar modul |
| 👥 **Data Pegawai** | Kelola master data referensi pegawai berikut foto profil |
| 📊 **Kriteria Penilaian** | Atur bobot dan jenis kriteria (benefit/cost, kualitatif/kuantitatif) |
| 📅 **Periode Penilaian** | Siklus penilaian triwulan, semester, dan tahunan |
| 🧮 **Penilaian & TOPSIS** | Buat penilaian per periode, input nilai alternatif, dan proses kalkulasi TOPSIS menjadi FINAL |
| 📄 **Laporan & Berita Acara** | Penerbitan Berita Acara resmi penetapan reward, pratinjau, dan ekspor Word |
| 🎯 **Showroom Kandidat 3D** | Halaman pratinjau interaktif 3D kandidat reward terbaik dengan animasi kartu carousel |
| 🔐 **Manajemen Pengguna** | Pengelolaan hak akses Superadmin dan Administrator |
| 🛡️ **Audit Trail** | Histori log aktivitas pengguna, alamat IP, dan jejak keamanan sistem |

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Detail |
|---|---|
| **Backend Framework** | [CodeIgniter 3](https://codeigniter.com/) (PHP MVC) |
| **Bahasa Pemrograman** | PHP 7+ |
| **Database** | MySQL / MariaDB |
| **Frontend UI** | Bootstrap 5, Vanilla CSS, Tabler Icons |
| **Metode DSS** | TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution) |
| **Visualisasi** | Animated 3D Card Stack Carousel, DataTables |
| **Export** | Microsoft Word (.docx) Berita Acara |

---

## 🏗️ Struktur Proyek

```text
berewards/
├── application/
│   ├── config/              # Konfigurasi CodeIgniter & routing
│   ├── controllers/         # Controller: Dashboard, Pegawai, Kriteria, Periode, Proses, Laporan, User, Audit
│   ├── models/              # Model database
│   └── views/
│       ├── admin/           # Halaman utama administrasi
│       │   └── partials/    # Komponen view modular (audit, laporan, pegawai, dll.)
│       ├── auth/            # Halaman autentikasi (signin)
│       └── templates/       # Layout, header, sidebar, topbar, footer
├── assets/
│   ├── css/                 # Tema kustom (spk-reward.css)
│   ├── js/                  # Aset JavaScript
│   ├── icons/               # Ikon & logo aplikasi
│   └── images/              # Foto profil & aset gambar
├── system/                  # Runtime CodeIgniter 3
├── index.php                # Front controller
└── .agents/                 # Brand guide & skill dokumentasi
```

---

## 🚀 Instalasi & Konfigurasi Lokal

### Prasyarat

- PHP 7.4 atau lebih baru
- Apache / XAMPP web server
- MySQL / MariaDB database server

### Langkah Instalasi

1. **Clone repositori** ke dalam direktori `htdocs` XAMPP:

   ```bash
   git clone https://github.com/qorichairawan17/berewards.git
   cd berewards
   ```

2. **Buat database** MySQL dengan nama `dss`:

   ```sql
   CREATE DATABASE dss CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Konfigurasi database** di `application/config/database.php`:

   ```php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'dss',
       ...
   );
   ```

4. **Konfigurasi base URL** di `application/config/config.php`:

   ```php
   $config['base_url'] = 'http://localhost/berewards/';
   ```

5. **Akses aplikasi** melalui browser:

   ```
   http://localhost/berewards/
   ```

---

## 🗺️ Routing Utama

| URL | Halaman |
|---|---|
| `/` atau `/signin` | Halaman Login |
| `/dashboard` | Dashboard Utama |
| `/pegawai` | Manajemen Data Pegawai |
| `/kriteria` | Kriteria Penilaian |
| `/periode` | Periode Penilaian |
| `/proses` | Penilaian & TOPSIS Engine |
| `/laporan` | Laporan & Berita Acara |
| `/laporan/preview/{id}` | Showroom Kandidat 3D |
| `/user` | Manajemen Pengguna |
| `/audit` | Audit Trail Aktivitas |

---

## 🎨 Panduan Branding

Panduan UI dan visual lengkap tersedia di [`.agents/be-rewards-brand-guide.md`](.agents/be-rewards-brand-guide.md):

- **Nama Produk:** BeRewards
- **Primary Color:** `#108DFF` (Ocean Blue)
- **Supporting Accent:** `#06B6D4` (Cyan)
- **Tema:** Light theme dengan tipografi bersih, spacing nyaman, dan sudut elemen membulat

---

## 📁 File Penting

| File | Keterangan |
|---|---|
| [`application/controllers/Dashboard.php`](application/controllers/Dashboard.php) | Controller dashboard utama |
| [`application/controllers/Laporan.php`](application/controllers/Laporan.php) | Controller laporan & showroom preview |
| [`application/controllers/Audit.php`](application/controllers/Audit.php) | Controller audit trail |
| [`application/views/auth/signin.php`](application/views/auth/signin.php) | Halaman autentikasi |
| [`application/views/admin/dashboard.php`](application/views/admin/dashboard.php) | Konten dashboard utama |
| [`application/views/admin/laporan_preview.php`](application/views/admin/laporan_preview.php) | Showroom kandidat 3D interaktif |
| [`assets/css/spk-reward.css`](assets/css/spk-reward.css) | Stylesheet tema kustom |
| [`assets/icons/logo.png`](assets/icons/logo.png) | Logo resmi BeRewards |

---

## 👨‍💻 Pengembang

**Qori Chairawan**
- 🏛️ Pengadilan Negeri Lubuk Pakam Kelas I-A
- 📧 Proyek: SPK Penentuan Reward Pegawai — BeRewards

---

## 📄 Lisensi

Proyek ini bersifat **Free / Open Source** dan bebas digunakan, dimodifikasi, serta didistribusikan tanpa batasan lisensi komersial.

> © 2026 BeRewards — Qori Chairawan. Dikembangkan untuk Pengadilan Negeri Lubuk Pakam Kelas I-A.
