# BeRewards — Sistem Pendukung Keputusan Reward Pegawai (Metode TOPSIS)

> **Sistem Pendukung Keputusan (SPK) Penentuan Reward Pegawai Terbaik Bagi Hakim, Panitera Pengganti, Jurusita, dan Staf Pengadilan Negeri Lubuk Pakam Kelas I-A Menggunakan Metode TOPSIS Berbasis Clean Architecture CodeIgniter 3**

---

## 📌 Tentang Proyek

**BeRewards** adalah aplikasi web Sistem Pendukung Keputusan (SPK) / _Decision Support System_ (DSS) yang dirancang untuk membantu pimpinan dan tim penilai di lingkungan **Pengadilan Negeri Lubuk Pakam Kelas I-A** dalam menentukan penerima penghargaan (_reward_) pegawai terbaik secara **objektif, akuntabel, terukur, dan transparan**.

Penilaian dilakukan berdasarkan kriteria kinerja multi-dimensi menggunakan metode **TOPSIS (_Technique for Order of Preference by Similarity to Ideal Solution_)**, yaitu metode pengambilan keputusan multikriteria yang memilih alternatif terbaik berdasarkan jarak terpendek dari Solusi Ideal Positif ($A^+$) dan jarak terjauh dari Solusi Ideal Negatif ($A^-$).

### 🏛️ Klaster Kategori Penilaian:

1. ⚖️ **Hakim** — Penilaian kinerja teknis yudisial, integritas, dan penyelesaian perkara.
2. 📋 **Panitera Pengganti** — Penilaian ketepatan berita acara sidang, minutasi perkara, dan ketaatan administrasi kepaniteraan.
3. 🏛️ **Jurusita / Jurusita Pengganti** — Penilaian kecepatan dan keakuratan relaas panggilan/pemberitahuan sidang.
4. 🗂️ **Staf / Pelaksana / Kesekretariatan** — Penilaian kedisiplinan, capaian SKP, inisiatif kerja, dan pelayanan publik.

---

## 🏗️ Arsitektur Sistem & Clean Code

Aplikasi dibangun di atas **CodeIgniter 3** dengan menerapkan standar **Clean Architecture / Service Layer Pattern**:

```text
┌─────────────────────────────────────────────────────────────────┐
│                    Presentation / View Layer                   │
│   (Bootstrap 5, Tabler Icons, 3D Showroom Podium, DataTables)   │
└────────────────────────────────┬────────────────────────────────┘
                                 │ AJAX / HTTP Requests
┌────────────────────────────────▼────────────────────────────────┐
│                    Controller Layer (Thin)                      │
│       (MY_Controller, Auth_Controller, Guest_Controller)        │
└────────────────────────────────┬────────────────────────────────┘
                                 │ Delegates to
┌────────────────────────────────▼────────────────────────────────┐
│                    Service Layer (Business Logic)               │
│  - Topsis_algorithm_service.php   - Dashboard_service.php       │
│  - Topsis_service.php             - Profile_service.php         │
│  - Export_word_service.php        - Audit_service.php           │
│  - Laporan_service.php            - Pegawai_service.php         │
│  - Kriteria_service.php           - Tim_penilai_service.php     │
│  - Periode_service.php            - Setting_service.php         │
└────────────────────────────────┬────────────────────────────────┘
                                 │ Queries via CI Query Builder
┌────────────────────────────────▼────────────────────────────────┐
│                    Model / Data Access Layer                    │
│   (User_model, Pegawai_model, Kriteria_model, Periode_model,   │
│    Proses_model, Laporan_model, Audit_model, Setting_model)     │
└────────────────────────────────┬────────────────────────────────┘
                                 │
┌────────────────────────────────▼────────────────────────────────┐
│                     Database (MySQL / MariaDB)                  │
└─────────────────────────────────────────────────────────────────┘
```

- **Thin Controllers**: Controller hanya bertugas menangani _HTTP request/response_, otentikasi peran (RBAC), dan _formatting_ output JSON/View.
- **Rich Service Layer**: Seluruh aturan bisnis, validasi, kalkulasi TOPSIS bertahap, logging audit trail, sinkronisasi dua arah, serta ekspor dokumen dienkapsulasi ke dalam service classes di `application/services/`.
- **RBAC Middleware**: Pengamanan controller berbasis role secara otomatis melalui `Auth_middleware.php`.
- **Global Timezone**: Terstandarisasi menggunakan Waktu Indonesia Barat (`Asia/Jakarta` / WIB, UTC+7).

---

## ✨ Fitur & Modul Aplikasi

| Modul                       | Ikon | Deskripsi Fungsional                                                                                                                                                                |
| :-------------------------- | :--: | :---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Dashboard Eksekutif**     |  🏠  | Ringkasan KPI (total proses, pegawai dinilai, periode aktif), spotlight juara Rank #1 hasil kalkulasi riil, dan feed audit trail aktivitas terkini.                                 |
| **Data Referensi Pegawai**  |  👥  | Manajemen data master pegawai (NIP, Nama, Pangkat, Golongan Ruang, Jabatan, Kategori, Foto Profil, Status Aktif) dengan modal detail profil.                                        |
| **Tim Penilai**             |  ⚖️  | Pengelolaan anggota Tim Penilai per periode/kategori, penetapan Surat Keputusan (SK) Tim Penilai, dan hak akses penilaian.                                                          |
| **Kriteria & Bobot**        |  📊  | Pengaturan parameter kriteria dinamis per kategori, jenis atribut (_Benefit_ / _Cost_), sifat input (Kualitatif Skala 1-5 vs Kuantitatif Nilai Rill), dan normalisasi bobot.        |
| **Periode Penilaian**       |  📅  | Pengaturan siklus evaluasi reward (Bulanan, Triwulan, Semester, Tahunan) dan penetapan status periode aktif berjalan.                                                               |
| **Mesin Hitung SPK TOPSIS** |  🧮  | Penginputan matriks nilai alternatif, pemrosesan bertahap 6 matriks TOPSIS, deteksi solusi ideal, jarak euclidean ($D^+ / D^-$), skor preferensi ($V_i$), dan perankingan otomatis. |
| **Showroom Kandidat 3D**    |  🎯  | Pratinjau interaktif 3D podium kandidat terbaik dengan animasi kartu carousel, stacked progress bar capaian kriteria, dan fallback foto aman.                                       |
| **Laporan & Berita Acara**  |  📄  | Penerbitan dokumen resmi Berita Acara Hasil Penilaian Reward, pratinjau online, serta ekspor cetak dokumen Microsoft Word (`.docx`).                                                |
| **Profil Saya**             |  👤  | Informasi akun terintegrasi ke data kepegawaian (_two-way synchronization_), ubah biodata & password, dan kartu identitas digital (_Official ID Card_).                             |
| **Manajemen Pengguna**      |  🔐  | Manajemen akun pengguna dengan Role-Based Access Control (RBAC: Superadmin, Administrator, Tim Penilai, Pimpinan).                                                                  |
| **Pengaturan Satker**       |  ⚙️  | Kustomisasi profil Satuan Kerja Pengadilan Negeri Lubuk Pakam, logo instansi, format kop surat, tema visual, dan pejabat penandatangan.                                             |
| **Audit Trail & Keamanan**  |  🛡️  | Pencatatan otomatis setiap aksi pengguna (Login, Tambah, Ubah, Hapus, Kalkulasi) lengkap dengan timestamp WIB, IP address, user agent, dan status eksekusi.                         |

---

## 🧮 Alur Perhitungan Matematis TOPSIS

Metode **TOPSIS** diimplementasikan secara murni (_pure mathematical engine_) pada [`Topsis_algorithm_service.php`](application/services/Topsis_algorithm_service.php) melalui 6 tahapan:

### 1. Pembentukan Matriks Keputusan ($X$)

Matriks berukuran $m \times n$ di mana $m$ adalah jumlah kandidat pegawai dan $n$ adalah jumlah kriteria:
$$X = \begin{pmatrix} x_{11} & x_{12} & \cdots & x_{1n} \\ x_{21} & x_{22} & \cdots & x_{2n} \\ \vdots & \vdots & \ddots & \vdots \\ x_{m1} & x_{m2} & \cdots & x_{mn} \end{pmatrix}$$

### 2. Matriks Keputusan Ternormalisasi ($R$)

Normalisasi vektor dihitung menggunakan formula:
$$r_{ij} = \frac{x_{ij}}{\sqrt{\sum_{k=1}^m x_{kj}^2}}$$

### 3. Matriks Keputusan Ternormalisasi Terbobot ($Y$)

Mengalikan nilai ternormalisasi dengan bobot kriteria masing-masing ($w_j$):
$$y_{ij} = w_j \cdot r_{ij}$$

### 4. Menentukan Solusi Ideal Positif ($A^+$) dan Negatif ($A^-$)

- **Solusi Ideal Positif ($A^+$)**:
  $$A^+ = \{y_1^+, y_2^+, \dots, y_n^+\}, \quad \text{di mana } y_j^+ = \begin{cases} \max_i(y_{ij}), & \text{jika kriteria } j \text{ adalah Benefit} \\ \min_i(y_{ij}), & \text{jika kriteria } j \text{ adalah Cost} \end{cases}$$
- **Solusi Ideal Negatif ($A^-$)**:
  $$A^- = \{y_1^-, y_2^-, \dots, y_n^-\}, \quad \text{di mana } y_j^- = \begin{cases} \min_i(y_{ij}), & \text{jika kriteria } j \text{ adalah Benefit} \\ \max_i(y_{ij}), & \text{jika kriteria } j \text{ adalah Cost} \end{cases}$$

### 5. Menghitung Jarak Separasi ($D_i^+$ dan $D_i^-$)

- **Jarak ke Solusi Ideal Positif ($D_i^+$)**:
  $$D_i^+ = \sqrt{\sum_{j=1}^n (y_{ij} - y_j^+)^2}$$
- **Jarak ke Solusi Ideal Negatif ($D_i^-$)**:
  $$D_i^- = \sqrt{\sum_{j=1}^n (y_{ij} - y_j^-)^2}$$

### 6. Menghitung Nilai Preferensi / Skor Akhir ($V_i$) & Perankingan

$$V_i = \frac{D_i^-}{D_i^+ + D_i^-}, \quad \text{dengan rentang } 0 \le V_i \le 1$$
Alternatif dengan nilai $V_i$ terbesar menempati **Peringkat #1 (Penerima Reward Terbaik)**.

---

## 👥 Hak Akses & Peran Pengguna (RBAC)

Aplikasi memiliki 4 level hak akses pengguna:

| Role              |  Dashboard   | Data Master (Pegawai/Kriteria/Periode) | Penilaian & Hitung TOPSIS  | Cetak Laporan & Word | User Management & Setting |
| :---------------- | :----------: | :------------------------------------: | :------------------------: | :------------------: | :-----------------------: |
| **Superadmin**    |      ✅      |             ✅ Full Akses              |             ✅             |          ✅          |       ✅ Full Akses       |
| **Administrator** |      ✅      |             ✅ Full Akses              |             ✅             |          ✅          |        ❌ Terbatas        |
| **Tim Penilai**   |      ✅      |              👁️ Read-Only              | ✅ Input Nilai & Kalkulasi |          ✅          |            ❌             |
| **Pimpinan**      | ✅ Ringkasan |              👁️ Read-Only              |    👁️ Monitoring Hasil     |  ✅ Cetak & Preview  |            ❌             |

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

- **Backend:** PHP 7.4+ / PHP 8.x, Framework CodeIgniter 3.1.x
- **Database:** MySQL 5.7+ / MariaDB 10.4+
- **Frontend & Styling:** Bootstrap 5.3, Vanilla CSS Custom Tokens ([`spk-reward.css`](assets/css/spk-reward.css)), Glassmorphism Elements
- **Ikonografi:** Tabler Icons v2.x
- **Data Grid & Export:** DataTables jQuery, HTML5 DOMParser, PHPWord Library
- **Keamanan:** CSRF Protection with Token Sync, Prepared Statements (Query Builder), XSS Filtering, Password Hash (`PASSWORD_BCRYPT`), Timezone Enforcement (`Asia/Jakarta`)

---

## 📁 Struktur Direktori Repositori

```text
berewards/
├── application/
│   ├── config/                      # Konfigurasi aplikasi, database, routing, CSRF
│   │   ├── config.php
│   │   ├── database.php
│   │   └── routes.php
│   ├── controllers/                 # Thin Controllers
│   │   ├── Audit.php                # Modul audit trail & log aktivitas
│   │   ├── Dashboard.php            # Modul dashboard eksekutif
│   │   ├── Kriteria.php             # Modul kriteria & pembobotan
│   │   ├── Laporan.php              # Modul laporan & showroom 3D
│   │   ├── Pegawai.php              # Modul referensi pegawai
│   │   ├── Periode.php              # Modul periode penilaian
│   │   ├── Profile.php              # Modul profil pengguna
│   │   ├── Proses.php               # Modul input nilai & kalkulator TOPSIS
│   │   ├── Setting.php              # Modul pengaturan satker
│   │   ├── Signin.php / Auth.php    # Modul autentikasi login/logout
│   │   ├── Timpenilai.php           # Modul tim penilai
│   │   └── User.php                 # Modul manajemen pengguna
│   ├── core/                        # Base Controller (MY_Controller, Auth_Controller)
│   ├── middleware/                  # Middleware Otentikasi & RBAC
│   ├── models/                      # Data Access Layer (CI Model)
│   ├── services/                    # Business Logic Layer (Clean Service Layer)
│   │   ├── Audit_service.php
│   │   ├── Auth_service.php
│   │   ├── Dashboard_service.php
│   │   ├── Export_word_service.php
│   │   ├── Kriteria_service.php
│   │   ├── Laporan_service.php
│   │   ├── Pegawai_service.php
│   │   ├── Periode_service.php
│   │   ├── Profile_service.php
│   │   ├── Setting_service.php
│   │   ├── Tim_penilai_service.php
│   │   ├── Topsis_algorithm_service.php
│   │   ├── Topsis_service.php
│   │   └── User_service.php
│   └── views/                       # View Templates & Partials
│       ├── admin/                   # Tampilan modul administrasi
│       │   ├── partials/            # Komponen modular per modul (audit, profile, dll.)
│       │   ├── dashboard.php
│       │   ├── pegawai.php
│       │   ├── proses.php
│       │   ├── laporan.php
│       │   ├── laporan_preview.php  # Showroom 3D Carousel
│       │   └── profile.php
│       ├── auth/                    # Halaman signin login
│       └── templates/               # Layout master, header, sidebar, topbar, footer
├── assets/
│   ├── css/                         # Custom stylesheet & token warna
│   ├── js/                          # Script interaksi UI & AJAX
│   ├── icons/                       # Logo resmi (logo.png) & icon pack
│   └── images/                      # Aset gambar & foto pegawai
├── system/                          # Core Framework CodeIgniter 3
├── index.php                        # Front controller & bootstrap timezone
└── README.md                        # Dokumentasi lengkap proyek
```

---

## 🚀 Panduan Instalasi & Penggunaan Lokal

### Prasyarat Perangkat Lunak:

- **Web Server**: Apache (XAMPP / Laragon / WampServer)
- **PHP Version**: PHP 7.4 atau PHP 8.0/8.1/8.2
- **Database Server**: MySQL 5.7+ / MariaDB 10.x
- **Browser**: Google Chrome, Mozilla Firefox, Microsoft Edge, atau Safari modern

### Langkah Instalasi:

1. **Clone Repositori**:
   Tempatkan folder proyek ke dalam direktori web server (misalnya `C:\xampp\htdocs\berewards`):

   ```bash
   cd c:/xampp/htdocs
   git clone https://github.com/qorichairawan17/berewards.git
   cd berewards
   ```

2. **Setup Database**:
   - Buka **phpMyAdmin** (`http://localhost/phpmyadmin`) atau MySQL CLI.
   - Buat database baru bernama `dss`:
     ```sql
     CREATE DATABASE dss CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
     ```
   - Import skema dan data awal database.

3. **Konfigurasi Database**:
   Sesuaikan koneksi database di file [`application/config/database.php`](application/config/database.php):

   ```php
   $db['default'] = array(
       'dsn'      => '',
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'dss',
       'dbdriver' => 'mysqli',
       'dbprefix' => '',
       'pconnect' => FALSE,
       'db_debug' => (ENVIRONMENT !== 'production'),
       'cache_on' => FALSE,
       'cachedir' => '',
       'char_set' => 'utf8mb4',
       'dbcollat' => 'utf8mb4_unicode_ci',
       'swap_pre' => '',
       'encrypt'  => FALSE,
       'compress' => FALSE,
       'stricton' => FALSE,
       'failover' => array(),
       'save_queries' => TRUE
   );
   ```

4. **Konfigurasi Base URL**:
   Pastikan base URL pada [`application/config/config.php`](application/config/config.php) telah mengarah ke URL lokal:

   ```php
   $config['base_url'] = 'http://localhost/berewards/';
   ```

5. **Jalankan Aplikasi**:
   Buka browser dan akses alamat:
   ```
   http://localhost/berewards/
   ```

---

## 🗺️ Peta Navigasi & Rute URL

| Rute URL                    | Pengontrol             |     Hak Akses     | Deskripsi                                       |
| :-------------------------- | :--------------------- | :---------------: | :---------------------------------------------- |
| `/` atau `/signin`          | `Signin::index`        |      Publik       | Halaman login otentikasi akun                   |
| `/dashboard`                | `Dashboard::index`     |     Auth All      | Halaman utama dashboard performa SPK            |
| `/pegawai`                  | `Pegawai::index`       |     Auth All      | Master data referensi pegawai                   |
| `/timpenilai`               | `Timpenilai::index`    |    Admin/Super    | Manajemen susunan tim penilai reward            |
| `/kriteria`                 | `Kriteria::index`      |    Admin/Super    | Pengaturan kriteria dan bobot preferensi        |
| `/periode`                  | `Periode::index`       |    Admin/Super    | Manajemen periode dan siklus evaluasi           |
| `/proses`                   | `Proses::index`        | Tim Penilai/Admin | Input matriks penilaian & proses hitung TOPSIS  |
| `/laporan`                  | `Laporan::index`       |     Auth All      | Daftar berita acara reward & ekspor dokumen     |
| `/laporan/preview/{id}`     | `Laporan::preview`     |     Auth All      | Pratinjau interaktif Showroom 3D kandidat juara |
| `/laporan/export_word/{id}` | `Laporan::export_word` |     Auth All      | Unduh berkas Berita Acara format Microsoft Word |
| `/profile`                  | `Profile::index`       |     Auth All      | Profil saya, ubah password, sinkronisasi data   |
| `/setting`                  | `Setting::index`       |    Superadmin     | Pengaturan identitas Satker & kop dinas         |
| `/user`                     | `User::index`          |    Superadmin     | Manajemen user login dan hak akses RBAC         |
| `/audit`                    | `Audit::index`         |    Admin/Super    | Log audit trail aktivitas dan jejak sistem      |

---

## 🎨 Panduan Identitas Visual & Desain

- **Nama Produk:** BeRewards
- **Instansi:** Pengadilan Negeri Lubuk Pakam Kelas I-A
- **Warna Utama (Primary Blue):** `#108DFF`
- **Warna Aksen (Cyan & Indigo):** `#06B6D4` / `#1E1B4B`
- **Gaya Desain:** Clean, Minimalist, Modern, Card-Based Layout, Subtle Micro-Animations, Glassmorphism Accent, Standar Aksesibilitas WCAG AA.
- **Tipografi:** System Font Stack Modern (_Plus Jakarta Sans / Inter / Segoe UI_).

---

## 👨‍💻 Pengembang & Kontributor

- **Pengembang:** Qori Chairawan
- **Instansi:** Pengadilan Negeri Lubuk Pakam Kelas I-A

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan internal **Pengadilan Negeri Lubuk Pakam Kelas I-A** dan didistribusikan secara terbuka untuk tujuan pembelajaran, pengembangan keilmuan sistem pendukung keputusan, dan kemajuan tata kelola peradilan Indonesia.

> © 2026 **BeRewards** — Pengadilan Negeri Lubuk Pakam.
