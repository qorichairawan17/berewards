# Skema Database — SPK Reward TOPSIS

File SQL siap-import ada di `assets/database.sql`. Dokumen ini menjelaskan
**alasan** di balik setiap tabel supaya perubahan di masa depan tidak merusak
integritas historis perhitungan (aturan paling penting: **hasil periode lama
tidak boleh berubah hanya karena master data kriteria/pegawai diedit
kemudian**).

## Prinsip desain: snapshot, bukan referensi hidup

TOPSIS akan dijalankan berulang kali untuk periode berbeda (bulanan,
triwulan, semester, tahunan). Jika bobot kriteria berubah bulan depan, hasil
bulan lalu tidak boleh ikut berubah. Karena itu skema dipecah jadi dua
lapis:

- **Master data** (`referensi_pegawai`, `kriteria`, `skala_kriteria`) — boleh
  diedit kapan saja, dipakai sebagai *default* saat membuat proses baru.
- **Snapshot per proses** (`topsis_proses_kriteria`, `topsis_proses_alternatif`,
  `penilaian`, `hasil_topsis`) — begitu sebuah proses TOPSIS dibuat, kriteria
  dan bobot yang dipakai disalin ke tabel snapshot. Laporan/berita acara lama
  selalu dibangun dari snapshot ini, bukan dari master data terkini.

Kalau kebutuhan project lebih sederhana dan histori tidak jadi masalah,
lapisan snapshot boleh disingkat (langsung pakai `kriteria` di `penilaian`).
Tapi untuk instansi pengadilan yang hasilnya jadi dasar Berita Acara resmi,
snapshot sangat disarankan — jangan dilewati tanpa alasan kuat.

## Daftar tabel

### 1. `users` — akun login sistem
Akun Superadmin & Administrator (BUKAN pegawai yang dinilai — itu di
`referensi_pegawai`). Lihat `references/rbac.md` untuk aturan hak akses.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id_user | INT PK AI | |
| username | VARCHAR(50) UNIQUE | |
| password | VARCHAR(255) | hash bcrypt via `password_hash()` |
| nama_lengkap | VARCHAR(150) | |
| role | ENUM('superadmin','administrator') | |
| aktif | TINYINT(1) DEFAULT 1 | nonaktifkan tanpa hapus akun |
| last_login | DATETIME NULL | |
| created_at / updated_at | DATETIME | |

### 2. `referensi_pegawai` — sumber alternatif
Ini persis 7 kolom yang diminta, ditambah 1 kolom yang **direkomendasikan**:

| Kolom | Tipe | Keterangan |
|---|---|---|
| id_pegawai | INT PK AI | *ID Pegawai* |
| nip | VARCHAR(30) UNIQUE | |
| nama | VARCHAR(150) | |
| pangkat | VARCHAR(100) | |
| golongan | VARCHAR(20) | |
| jabatan | VARCHAR(150) | teks bebas, mis. "Hakim Madya", "Panitera Pengganti Muda" |
| **kategori** | ENUM('Hakim','Panitera Pengganti','Jurusita','Staf') | **tambahan** — lihat catatan di bawah |
| aktif | TINYINT(1) DEFAULT 1 | hanya pegawai aktif jadi kandidat alternatif |
| created_at / updated_at | DATETIME | |

**Kenapa menambah `kategori`?** Empat kelompok yang disebutkan di
permintaan (Hakim, Panitera Pengganti, Jurusita, Staf) hampir pasti dinilai
dengan **kriteria yang berbeda** — kriteria "kualitas putusan" masuk akal
untuk Hakim tapi tidak untuk Staf. `jabatan` adalah teks bebas dan tidak
aman dipakai untuk logika filter (typo, variasi penulisan). `kategori`
sebagai ENUM/lookup terpisah membuat filter kriteria-per-kelompok jadi
eksplisit dan tidak rapuh. Ini opsional secara teknis — kalau project
ternyata memang memakai satu set kriteria yang sama untuk semua pegawai,
kolom ini boleh diabaikan (isi default sesuai kebutuhan) — tapi jangan
dihapus dari skema tanpa mempertimbangkan implikasinya dulu, karena modul
kriteria dan proses TOPSIS di bawah ini mengasumsikan `kategori` ada.

### 3. `periode` — jendela waktu penilaian
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_periode | INT PK AI | |
| nama_periode | VARCHAR(100) | mis. "Triwulan I 2026" |
| tipe_periode | ENUM('Bulanan','Triwulan','Semester','Tahunan') | |
| tanggal_mulai | DATE | |
| tanggal_selesai | DATE | |
| status | ENUM('draft','aktif','selesai') DEFAULT 'draft' | |
| created_by | INT FK → users.id_user | |
| created_at / updated_at | DATETIME | |

Satu `periode` bisa punya beberapa `topsis_proses` — satu proses per
kategori pegawai (karena kriteria beda per kategori). Ini yang membuat
"Periode Bulan / Triwulan / Semester / Tahunan" tetap fleksibel tanpa
memaksa satu periode = satu perhitungan.

### 4. `kriteria` — master kriteria (fleksibel jumlahnya)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_kriteria | INT PK AI | |
| kategori | ENUM('Hakim','Panitera Pengganti','Jurusita','Staf') | kriteria ini berlaku untuk kategori mana |
| kode_kriteria | VARCHAR(10) | mis. "C1", "C2" — dibuat otomatis |
| nama_kriteria | VARCHAR(150) | |
| jenis_data | ENUM('kualitatif','kuantitatif') | lihat penjelasan di bawah |
| tipe_atribut | ENUM('benefit','cost') | benefit = makin besar makin baik, cost = sebaliknya |
| bobot | DECIMAL(5,2) | bobot mentah, dinormalisasi (dibagi total) saat dihitung |
| urutan | INT DEFAULT 0 | urutan tampil di form input |
| aktif | TINYINT(1) DEFAULT 1 | nonaktifkan tanpa hapus (supaya histori aman) |
| created_at / updated_at | DATETIME | |

Admin bisa menambah/mengurangi baris di tabel ini kapan saja → itulah
makna "kriteria bisa fleksibel sesuai kebutuhan". Jumlah kriteria tidak
di-hardcode di kode program manapun; semua form, matriks, dan perhitungan
harus di-loop dari isi tabel ini (lihat `references/topsis-algorithm.md`).

### 5. `skala_kriteria` — opsi skala untuk kriteria kualitatif
Dipakai hanya jika `kriteria.jenis_data = 'kualitatif'`.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id_skala | INT PK AI | |
| id_kriteria | INT FK → kriteria.id_kriteria | |
| label | VARCHAR(50) | mis. "Sangat Baik", "Baik", "Cukup", "Kurang" |
| nilai | DECIMAL(5,2) | mis. 5, 4, 3, 2 — angka yang sebenarnya dipakai di matriks |
| urutan | INT | urutan tampil di dropdown |

Untuk kriteria **kuantitatif** (data rill), tidak perlu baris di tabel ini
sama sekali — nilai diinput langsung sebagai angka (mis. jumlah perkara
yang diselesaikan, jumlah keterlambatan, dsb). Form input harus
membedakan otomatis: kalau `jenis_data = 'kualitatif'` render `<select>`
dari `skala_kriteria`, kalau `'kuantitatif'` render `<input type="number">`.

### 6. `topsis_proses` — header satu kali eksekusi TOPSIS
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_proses | INT PK AI | |
| id_periode | INT FK → periode.id_periode | |
| kategori | ENUM('Hakim','Panitera Pengganti','Jurusita','Staf') | |
| tanggal_proses | DATETIME NULL | diisi saat tombol "Hitung TOPSIS" ditekan |
| status | ENUM('draft','dinilai','dihitung','final') DEFAULT 'draft' | lihat alur di bawah |
| catatan | TEXT NULL | |
| created_by | INT FK → users.id_user | |
| created_at / updated_at | DATETIME | |

Alur status: `draft` (baru dibuat, pilih alternatif & kriteria) →
`dinilai` (semua nilai/matriks sudah diinput) → `dihitung` (TOPSIS sudah
dijalankan, hasil ada di `hasil_topsis`) → `final` (sudah di-export jadi
Berita Acara, terkunci dari edit).

### 7. `topsis_proses_kriteria` — snapshot kriteria per proses
Sama persis strukturnya dengan `kriteria`, tapi `id_kriteria` di sini
adalah PK baru; kolom `ref_kriteria_id` menyimpan id kriteria master asal
(nullable, untuk audit trail) sehingga sekalipun master `kriteria`
diedit/dihapus nanti, angka di proses lama tetap utuh.

### 8. `topsis_proses_alternatif` — pegawai yang ikut dinilai di proses ini
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | INT PK AI | |
| id_proses | INT FK → topsis_proses.id_proses | |
| id_pegawai | INT FK → referensi_pegawai.id_pegawai | |
| nip_snapshot | VARCHAR(30) | disalin saat proses dibuat |
| nama_snapshot | VARCHAR(150) | disalin saat proses dibuat |
| jabatan_snapshot | VARCHAR(150) | disalin saat proses dibuat |

Snapshot nama/NIP/jabatan penting supaya laporan tetap benar walau data
pegawai (mis. jabatan naik) berubah setelah periode selesai.

### 9. `penilaian` — matriks keputusan (input nilai mentah)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_penilaian | INT PK AI | |
| id_proses | INT FK → topsis_proses.id_proses | |
| id_proses_alternatif | INT FK → topsis_proses_alternatif.id | |
| id_proses_kriteria | INT FK → topsis_proses_kriteria.id | |
| nilai | DECIMAL(10,2) | angka final yang dipakai di matriks (hasil lookup skala, atau input rill langsung) |
| created_at / updated_at | DATETIME | |

UNIQUE KEY pada (`id_proses_alternatif`, `id_proses_kriteria`) supaya satu
sel matriks tidak terisi ganda.

### 10. `hasil_topsis` — hasil akhir perankingan
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_hasil | INT PK AI | |
| id_proses | INT FK → topsis_proses.id_proses | |
| id_proses_alternatif | INT FK → topsis_proses_alternatif.id | |
| d_positif | DECIMAL(10,6) | jarak ke solusi ideal positif |
| d_negatif | DECIMAL(10,6) | jarak ke solusi ideal negatif |
| nilai_preferensi | DECIMAL(10,6) | Ci — nilai akhir TOPSIS |
| ranking | INT | 1 = terbaik |
| created_at | DATETIME | |

### 11. `log_aktivitas` (opsional tapi disarankan)
Audit trail sederhana: `id_log, id_user, aksi, modul, keterangan, created_at`.
Berguna untuk instansi pengadilan yang butuh jejak siapa mengubah apa —
terutama karena hasilnya berujung ke dokumen resmi (Berita Acara).

## Relasi ringkas

```
referensi_pegawai ──┐
                     ├──< topsis_proses_alternatif >── topsis_proses ──< topsis_proses_kriteria
periode ──< topsis_proses                               │
kriteria ──(snapshot ke)── topsis_proses_kriteria        │
                                                          ├──< penilaian
                                                          └──< hasil_topsis
```

Lihat `assets/database.sql` untuk DDL lengkap siap `mysql -u root -p nama_db < database.sql`.
