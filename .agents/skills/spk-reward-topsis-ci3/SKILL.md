---
name: spk-reward-topsis-ci3
description: Membangun dan mengembangkan aplikasi SPK (Sistem Pendukung Keputusan) penentuan Reward untuk Hakim, Panitera Pengganti, Jurusita, dan Staf di lingkungan pengadilan, menggunakan metode TOPSIS di atas CodeIgniter 3. WAJIB dipakai untuk permintaan apa pun yang menyentuh project ini — termasuk skema database (referensi_pegawai, kriteria, periode, penilaian, hasil_topsis), mesin perhitungan TOPSIS, form kriteria dinamis (kualitatif/skala vs kuantitatif/rill), CRUD via AJAX, hak akses Superadmin/Administrator, tampilan Bootstrap clean-minimalist-futuristik, penyimpanan hasil per periode (bulanan/triwulan/semester/tahunan), atau export & preview laporan Berita Acara dalam format Word. Trigger juga untuk permintaan yang hanya menyebut "SPK reward pengadilan", "penilaian kinerja hakim/panitera/jurusita/staf", "TOPSIS CodeIgniter", atau referensi ke modul/file mana pun dari project ini, walau tanpa menyebut nama project secara lengkap.
---

# SPK Reward TOPSIS — Hakim, Panitera Pengganti, Jurusita, Staf (CodeIgniter 3)

Skill ini adalah spesifikasi teknis lengkap untuk membangun dan
mengembangkan satu aplikasi: **Sistem Pendukung Keputusan penentuan
Reward** memakai metode **TOPSIS**, framework **CodeIgniter 3**, untuk
menilai empat kelompok pegawai pengadilan — Hakim, Panitera Pengganti,
Jurusita, dan Staf.

Baca ringkasan di bawah ini dulu untuk memahami bentuk keseluruhan
sistem, lalu masuk ke file referensi yang relevan dengan tugas spesifik
yang sedang dikerjakan. Jangan coba membangun ulang keputusan desain
(skema tabel, rumus TOPSIS, pola arsitektur) dari nol setiap kali
diminta sesuatu — semua sudah didokumentasikan supaya konsisten di
seluruh project, lintas sesi maupun lintas modul.

## Peta keputusan desain (baca ini dulu)

1. **Kriteria fleksibel** — jumlah kriteria tidak dibatasi di kode
   manapun; admin menambah/mengurangi baris di tabel `kriteria` kapan
   saja. Setiap kriteria punya `jenis_data` (`kualitatif` pakai skala
   dari tabel `skala_kriteria`, atau `kuantitatif` pakai angka rill
   langsung) dan `tipe_atribut` (`benefit`/`cost`).
2. **Kriteria dikelompokkan per kategori pegawai** — karena Hakim,
   Panitera Pengganti, Jurusita, dan Staf realistisnya dinilai dengan
   kriteria berbeda, `kriteria` dan `referensi_pegawai` sama-sama punya
   kolom `kategori`. Satu proses TOPSIS = satu `periode` × satu
   `kategori`. Alasan lengkap ada di
   `references/database-schema.md`.
3. **Alternatif = pegawai aktif** — daftar alternatif TOPSIS diambil
   dari relasi ke `referensi_pegawai` (hanya `aktif = 1`), bukan
   diinput manual terpisah.
4. **Snapshot, bukan referensi hidup** — begitu sebuah proses TOPSIS
   dibuat, kriteria/bobot dan alternatif yang dipakai disalin ke tabel
   snapshot (`topsis_proses_kriteria`, `topsis_proses_alternatif`).
   Ini supaya hasil periode lama tidak pernah berubah gara-gara master
   data diedit belakangan — penting karena hasilnya jadi dasar dokumen
   resmi (Berita Acara).
5. **Clean Architecture ala CI3**: Controller (tipis) → Service (logika
   bisnis & orkestrasi) → Model (akses data) → View (presentasi saja).
   CI3 tidak punya lapisan Service bawaan, jadi ditambahkan lewat
   `MY_Loader` custom.
6. **Semua CRUD lewat AJAX** — tidak ada full page reload untuk operasi
   tambah/ubah/hapus; modal Bootstrap + `$.post` + respons JSON + SweetAlert2.
7. **UI terang, bukan dark theme** — kesan "futuristik" dicapai lewat
   gradasi warna aksen, animasi halus, dan tipografi, bukan lewat latar
   gelap.

## Peta file referensi — baca sesuai kebutuhan tugas

| Kalau sedang mengerjakan... | Baca |
|---|---|
| Desain/migrasi tabel, relasi, kenapa ada tabel snapshot | `references/database-schema.md` + `assets/database.sql` |
| Rumus TOPSIS, urutan langkah, contoh hitung manual, aturan fleksibilitas | `references/topsis-algorithm.md` + `assets/templates/Topsis_service.php` |
| Struktur folder CI3, lapisan Service, pola Controller/Model/Service, alur modul Proses | `references/architecture.md` + `assets/templates/MY_Loader.php` + `assets/templates/Admin_Controller.php` |
| CRUD AJAX modul apa pun (Pegawai, Kriteria, Periode, User) | contoh lengkap ada di `references/architecture.md` bagian "Pola AJAX CRUD" |
| Desain visual, warna, layout, animasi, halaman preview laporan | `references/ui-guidelines.md` |
| Export Berita Acara ke `.docx` | `references/word-export.md` |
| Login, session, siapa boleh akses apa | `references/rbac.md` |

## Alur kerja aplikasi secara end-to-end

1. **Setup awal**: import `assets/database.sql`, pasang `MY_Loader.php`
   dan `Admin_Controller.php` ke `application/core/`, pasang PHPWord via
   Composer (lihat `references/word-export.md`).
2. **Master data**: Superadmin/Administrator mengisi `referensi_pegawai`
   (dengan `kategori`), `kriteria` per kategori (+ `skala_kriteria` untuk
   yang kualitatif), dan `periode`.
3. **Buat proses**: pilih `periode` + `kategori` → sistem menyalin
   kriteria & alternatif aktif jadi snapshot proses baru (status `draft`).
4. **Input penilaian**: isi matriks nilai per alternatif per kriteria
   (form dinamis, lihat `references/ui-guidelines.md` bagian form input
   matriks) → status jadi `dinilai`.
5. **Hitung TOPSIS**: jalankan `Topsis_service::hitung()`, simpan ke
   `hasil_topsis` → status `dihitung`.
6. **Preview & export**: tampilkan hasil di halaman preview futuristik →
   export jadi Berita Acara `.docx` → status `final` (terkunci dari
   edit; revisi = buat proses baru, bukan edit yang lama).

## Prinsip yang berlaku di semua modul, jangan dilanggar diam-diam

- **Jangan hardcode jumlah atau nama kriteria** di controller, view,
  atau query manapun — selalu loop dari data (`topsis_proses_kriteria`
  untuk proses yang sudah berjalan, `kriteria` untuk form master).
- **Jangan izinkan hapus permanen** data yang sudah punya riwayat
  (pegawai yang pernah jadi alternatif, kriteria yang pernah dipakai di
  suatu proses, proses yang sudah `final`) — nonaktifkan (`aktif = 0`)
  atau buat versi/proses baru sebagai gantinya. Ini menjaga integritas
  dokumen resmi yang sudah diterbitkan.
- **Validasi server-side selalu ada**, meskipun sudah ada validasi
  client-side di form — form CI3 `form_validation` di layer Service,
  bukan cuma di JavaScript.
- **Konsisten satu pola AJAX** di semua modul CRUD — jangan modul
  Pegawai pakai SweetAlert2 sementara modul Kriteria pakai `alert()`
  bawaan browser; pengalaman harus seragam di seluruh aplikasi.
- **UI tetap terang** di semua halaman termasuk preview laporan; efek
  "futuristik" lewat gradient/animasi secukupnya, bukan lewat dark mode.

## Isi paket skill ini

```
spk-reward-topsis-ci3/
├── SKILL.md                              (file ini)
├── references/
│   ├── database-schema.md                penjelasan & alasan tiap tabel
│   ├── topsis-algorithm.md                rumus lengkap + contoh hitung manual
│   ├── architecture.md                    folder CI3, Service layer, pola AJAX CRUD, alur modul Proses
│   ├── ui-guidelines.md                   warna, layout, animasi, halaman preview
│   ├── word-export.md                     PHPWord, struktur Berita Acara, contoh kode
│   └── rbac.md                            Superadmin vs Administrator, guard controller & view
└── assets/
    ├── database.sql                       skema siap-import (11 tabel + akun superadmin default)
    └── templates/
        ├── Topsis_service.php             mesin TOPSIS generik, siap pakai/unit-test
        ├── MY_Loader.php                   aktifkan $this->load->service(...)
        └── Admin_Controller.php            base controller: guard sesi + role + helper JSON
```

Ganti password akun `superadmin` default di `assets/database.sql`
setelah instalasi pertama — hash di sana hanya contoh untuk kemudahan
setup awal, jangan dipakai di lingkungan produksi.
