-- =====================================================================
-- SPK Reward TOPSIS — Skema Database
-- Hakim, Panitera Pengganti, Jurusita, Staf
-- Lihat references/database-schema.md untuk penjelasan tiap tabel.
-- Charset utf8mb4 supaya aman untuk karakter khusus di nama/berita acara.
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- 1. users — akun login (Superadmin / Administrator)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(150) NOT NULL,
  `role` ENUM('superadmin','administrator') NOT NULL DEFAULT 'administrator',
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Akun superadmin default — GANTI PASSWORD setelah instalasi.
-- password default: "password" (bcrypt) — hanya contoh, jangan dipakai di produksi.
INSERT INTO `users` (`username`,`password`,`nama_lengkap`,`role`) VALUES
('superadmin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Administrator', 'superadmin');

-- ---------------------------------------------------------------------
-- 2. referensi_pegawai — sumber alternatif TOPSIS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `referensi_pegawai` (
  `id_pegawai` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nip` VARCHAR(30) NOT NULL UNIQUE,
  `nama` VARCHAR(150) NOT NULL,
  `pangkat` VARCHAR(100) NULL,
  `golongan` VARCHAR(20) NULL,
  `jabatan` VARCHAR(150) NULL,
  `kategori` ENUM('Hakim','Panitera Pengganti','Jurusita','Staf') NOT NULL,
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_pegawai_kategori (`kategori`),
  INDEX idx_pegawai_aktif (`aktif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 3. periode — jendela waktu penilaian
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `periode` (
  `id_periode` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama_periode` VARCHAR(100) NOT NULL,
  `tipe_periode` ENUM('Bulanan','Triwulan','Semester','Tahunan') NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `status` ENUM('draft','aktif','selesai') NOT NULL DEFAULT 'draft',
  `created_by` INT UNSIGNED NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_periode_user FOREIGN KEY (`created_by`) REFERENCES `users`(`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 4. kriteria — master kriteria, jumlah & isi bebas ditambah/kurangi
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kategori` ENUM('Hakim','Panitera Pengganti','Jurusita','Staf') NOT NULL,
  `kode_kriteria` VARCHAR(10) NOT NULL,
  `nama_kriteria` VARCHAR(150) NOT NULL,
  `jenis_data` ENUM('kualitatif','kuantitatif') NOT NULL DEFAULT 'kuantitatif',
  `tipe_atribut` ENUM('benefit','cost') NOT NULL DEFAULT 'benefit',
  `bobot` DECIMAL(5,2) NOT NULL DEFAULT 0,
  `urutan` INT NOT NULL DEFAULT 0,
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_kriteria_kategori (`kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 5. skala_kriteria — opsi skala untuk kriteria kualitatif
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `skala_kriteria` (
  `id_skala` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_kriteria` INT UNSIGNED NOT NULL,
  `label` VARCHAR(50) NOT NULL,
  `nilai` DECIMAL(5,2) NOT NULL,
  `urutan` INT NOT NULL DEFAULT 0,
  CONSTRAINT fk_skala_kriteria FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria`(`id_kriteria`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 6. topsis_proses — header satu kali eksekusi TOPSIS (periode x kategori)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `topsis_proses` (
  `id_proses` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_periode` INT UNSIGNED NOT NULL,
  `kategori` ENUM('Hakim','Panitera Pengganti','Jurusita','Staf') NOT NULL,
  `tanggal_proses` DATETIME NULL,
  `status` ENUM('draft','dinilai','dihitung','final') NOT NULL DEFAULT 'draft',
  `catatan` TEXT NULL,
  `created_by` INT UNSIGNED NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_proses_periode FOREIGN KEY (`id_periode`) REFERENCES `periode`(`id_periode`) ON DELETE CASCADE,
  CONSTRAINT fk_proses_user FOREIGN KEY (`created_by`) REFERENCES `users`(`id_user`) ON DELETE SET NULL,
  UNIQUE KEY uq_periode_kategori (`id_periode`, `kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 7. topsis_proses_kriteria — snapshot kriteria+bobot milik satu proses
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `topsis_proses_kriteria` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_proses` INT UNSIGNED NOT NULL,
  `ref_kriteria_id` INT UNSIGNED NULL COMMENT 'jejak ke kriteria master, boleh null jika master sudah dihapus',
  `kode_kriteria` VARCHAR(10) NOT NULL,
  `nama_kriteria` VARCHAR(150) NOT NULL,
  `jenis_data` ENUM('kualitatif','kuantitatif') NOT NULL,
  `tipe_atribut` ENUM('benefit','cost') NOT NULL,
  `bobot` DECIMAL(5,2) NOT NULL,
  CONSTRAINT fk_pk_proses FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 8. topsis_proses_alternatif — pegawai yang ikut dinilai di proses ini
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `topsis_proses_alternatif` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_proses` INT UNSIGNED NOT NULL,
  `id_pegawai` INT UNSIGNED NOT NULL,
  `nip_snapshot` VARCHAR(30) NOT NULL,
  `nama_snapshot` VARCHAR(150) NOT NULL,
  `jabatan_snapshot` VARCHAR(150) NULL,
  CONSTRAINT fk_pa_proses FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE,
  CONSTRAINT fk_pa_pegawai FOREIGN KEY (`id_pegawai`) REFERENCES `referensi_pegawai`(`id_pegawai`) ON DELETE RESTRICT,
  UNIQUE KEY uq_proses_pegawai (`id_proses`, `id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 9. penilaian — matriks keputusan (satu baris = satu sel matriks)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_proses` INT UNSIGNED NOT NULL,
  `id_proses_alternatif` INT UNSIGNED NOT NULL,
  `id_proses_kriteria` INT UNSIGNED NOT NULL,
  `nilai` DECIMAL(10,2) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_nilai_proses FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE,
  CONSTRAINT fk_nilai_alternatif FOREIGN KEY (`id_proses_alternatif`) REFERENCES `topsis_proses_alternatif`(`id`) ON DELETE CASCADE,
  CONSTRAINT fk_nilai_kriteria FOREIGN KEY (`id_proses_kriteria`) REFERENCES `topsis_proses_kriteria`(`id`) ON DELETE CASCADE,
  UNIQUE KEY uq_sel_matriks (`id_proses_alternatif`, `id_proses_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 10. hasil_topsis — hasil akhir perankingan
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hasil_topsis` (
  `id_hasil` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_proses` INT UNSIGNED NOT NULL,
  `id_proses_alternatif` INT UNSIGNED NOT NULL,
  `d_positif` DECIMAL(12,6) NOT NULL,
  `d_negatif` DECIMAL(12,6) NOT NULL,
  `nilai_preferensi` DECIMAL(12,6) NOT NULL,
  `ranking` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_hasil_proses FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE,
  CONSTRAINT fk_hasil_alternatif FOREIGN KEY (`id_proses_alternatif`) REFERENCES `topsis_proses_alternatif`(`id`) ON DELETE CASCADE,
  UNIQUE KEY uq_hasil_alternatif (`id_proses`, `id_proses_alternatif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 11. log_aktivitas — audit trail (opsional, disarankan untuk instansi)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `log_aktivitas` (
  `id_log` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT UNSIGNED NULL,
  `aksi` VARCHAR(50) NOT NULL COMMENT 'create/update/delete/proses/export',
  `modul` VARCHAR(50) NOT NULL,
  `keterangan` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_log_user FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
