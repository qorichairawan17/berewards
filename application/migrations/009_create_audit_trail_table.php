<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_audit_trail_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for audit_trail table (Audit Log Aktivitas System)
        $fields = array(
            'id_audit' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'timestamp' => array(
                'type' => 'DATETIME',
                'null' => FALSE
            ),
            'id_user' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE
            ),
            'username' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => FALSE
            ),
            'nama_user' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'role' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE
            ),
            'modul' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => FALSE
            ),
            'aktivitas' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'ip_address' => array(
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => TRUE
            ),
            'user_agent' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
            ),
            'status' => array(
                'type'       => 'ENUM',
                'constraint' => array('Sukses', 'Gagal', 'Peringatan'),
                'default'    => 'Sukses'
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id_audit', TRUE);
        $this->dbforge->create_table('audit_trail', TRUE);

        if ($this->db->table_exists('audit_trail')) {
            if ($this->db->table_exists('pengguna')) {
                $this->db->query("ALTER TABLE `audit_trail` ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`id_user`) REFERENCES `pengguna`(`id_user`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 2. Insert 10 Initial Sample Audit Logs
        $sample_audit = array(
            array(
                'id_audit'   => 1,
                'timestamp'  => '2026-08-09 14:15:22',
                'id_user'    => 1,
                'username'   => 'superadmin',
                'nama_user'  => 'Administrator Utama',
                'role'       => 'Superadmin',
                'modul'      => 'Manajemen Pengguna',
                'aktivitas'  => 'Menambahkan akun pengguna baru: panitera.dian',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-09 14:15:22'
            ),
            array(
                'id_audit'   => 2,
                'timestamp'  => '2026-08-09 13:50:00',
                'id_user'    => 2,
                'username'   => 'admin_kepeg',
                'nama_user'  => 'Dewi Sartika, S.H.',
                'role'       => 'Administrator',
                'modul'      => 'Data Pegawai',
                'aktivitas'  => 'Memperbarui data & foto profil pegawai NIP 19750812 200003 1 001',
                'ip_address' => '192.168.1.24',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-09 13:50:00'
            ),
            array(
                'id_audit'   => 3,
                'timestamp'  => '2026-08-09 11:30:15',
                'id_user'    => 5,
                'username'   => 'panitera',
                'nama_user'  => 'Bambang Wijaya, S.H., M.H.',
                'role'       => 'Tim Penilai',
                'modul'      => 'Penilaian & TOPSIS',
                'aktivitas'  => 'Memproses kalkulasi TOPSIS periode Triwulan II 2026 ke status FINAL',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-09 11:30:15'
            ),
            array(
                'id_audit'   => 4,
                'timestamp'  => '2026-08-09 11:20:30',
                'id_user'    => 5,
                'username'   => 'panitera',
                'nama_user'  => 'Bambang Wijaya, S.H., M.H.',
                'role'       => 'Tim Penilai',
                'modul'      => 'Penilaian & TOPSIS',
                'aktivitas'  => 'Menginput nilai alternative kriteria C1-C4 pegawai Rina Agustina, S.H., M.H.',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-09 11:20:30'
            ),
            array(
                'id_audit'   => 5,
                'timestamp'  => '2026-08-09 09:30:10',
                'id_user'    => 3,
                'username'   => 'ketua_pn',
                'nama_user'  => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'role'       => 'Pimpinan',
                'modul'      => 'Laporan & Berita Acara',
                'aktivitas'  => 'Mengesahkan Berita Acara W2.U4/01/BA.SPK/06/2026',
                'ip_address' => '192.168.1.2',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-09 09:30:10'
            ),
            array(
                'id_audit'   => 6,
                'timestamp'  => '2026-08-09 08:15:00',
                'id_user'    => 6,
                'username'   => 'sekretaris',
                'nama_user'  => 'Drs. Muhammad Rizky',
                'role'       => 'Tim Penilai',
                'modul'      => 'Kriteria Penilaian',
                'aktivitas'  => 'Memperbarui bobot kriteria C2 Perkara (Benefit, w=0.30)',
                'ip_address' => '192.168.1.18',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-09 08:15:00'
            ),
            array(
                'id_audit'   => 7,
                'timestamp'  => '2026-08-08 16:45:00',
                'id_user'    => 4,
                'username'   => 'wakil_pn',
                'nama_user'  => 'Hj. Fitriani, S.H., M.H.',
                'role'       => 'Pimpinan',
                'modul'      => 'Showroom Pratinjau',
                'aktivitas'  => 'Membuka showroom pratinjau 3D kandidat reward Triwulan II 2026',
                'ip_address' => '192.168.1.3',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-08 16:45:00'
            ),
            array(
                'id_audit'   => 8,
                'timestamp'  => '2026-08-08 14:10:22',
                'id_user'    => NULL,
                'username'   => 'hakim.rina',
                'nama_user'  => 'Rina Agustina, S.H., M.H.',
                'role'       => 'Tim Penilai',
                'modul'      => 'Autentikasi Login',
                'aktivitas'  => 'Gagal login: Kombinasi password tidak sesuai (2x percobaan)',
                'ip_address' => '192.168.1.45',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Gagal',
                'created_at' => '2026-08-08 14:10:22'
            ),
            array(
                'id_audit'   => 9,
                'timestamp'  => '2026-08-07 15:20:00',
                'id_user'    => 7,
                'username'   => 'penilai_hakim',
                'nama_user'  => 'Tim Penilai Kategori Hakim',
                'role'       => 'Tim Penilai',
                'modul'      => 'Autentikasi Login',
                'aktivitas'  => 'Berhasil login ke dalam sistem BeRewards',
                'ip_address' => '192.168.1.45',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-07 15:20:00'
            ),
            array(
                'id_audit'   => 10,
                'timestamp'  => '2026-08-06 10:05:00',
                'id_user'    => 2,
                'username'   => 'admin_kepeg',
                'nama_user'  => 'Dewi Sartika, S.H.',
                'role'       => 'Administrator',
                'modul'      => 'Periode Penilaian',
                'aktivitas'  => 'Menambahkan periode penilaian baru: Triwulan III 2026',
                'ip_address' => '192.168.1.22',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
                'status'     => 'Sukses',
                'created_at' => '2026-08-06 10:05:00'
            )
        );

        $this->db->insert_batch('audit_trail', $sample_audit);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('audit_trail', TRUE);
    }
}
