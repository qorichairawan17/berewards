<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_pengguna_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for pengguna table
        $fields = array(
            'id_user' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_pegawai' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE // Opsional, boleh terisi atau kosong (relasi ke referensi_pegawai)
            ),
            'username' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => FALSE
            ),
            'password' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE
            ),
            'nama_lengkap' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => FALSE
            ),
            'email' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'role' => array(
                'type'       => 'ENUM',
                'constraint' => array('superadmin', 'administrator', 'tim_penilai', 'pimpinan'),
                'default'    => 'administrator'
            ),
            'avatar' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
            ),
            'aktif' => array(
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1
            ),
            'last_login' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id_user', TRUE);
        $this->dbforge->create_table('pengguna', TRUE);

        if ($this->db->table_exists('pengguna')) {
            $this->db->query("ALTER TABLE `pengguna` ADD UNIQUE KEY `idx_username_unique` (`username`)");
            if ($this->db->table_exists('referensi_pegawai')) {
                $this->db->query("ALTER TABLE `pengguna` ADD CONSTRAINT `fk_pengguna_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `referensi_pegawai`(`id_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 2. Insert 10 Sample System Users (id_pegawai opsional)
        $default_hash = password_hash('password123', PASSWORD_BCRYPT);

        $sample_users = array(
            array('id_user' => 1,  'id_pegawai' => NULL, 'username' => 'superadmin',   'password' => $default_hash, 'nama_lengkap' => 'Super Administrator SPK', 'email' => 'superadmin@pn-lubukpakam.go.id', 'role' => 'superadmin',    'avatar' => 'assets/images/users/user-1.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 2,  'id_pegawai' => 10,   'username' => 'admin_kepeg',  'password' => $default_hash, 'nama_lengkap' => 'Admin Kepegawaian & Ortala', 'email' => 'kepegawaian@pn-lubukpakam.go.id', 'role' => 'administrator', 'avatar' => 'assets/images/users/user-2.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 3,  'id_pegawai' => 1,    'username' => 'ketua_pn',     'password' => $default_hash, 'nama_lengkap' => "Dr. H. Ahmad Syafi'i, S.H., M.H.", 'email' => 'ketua@pn-lubukpakam.go.id', 'role' => 'pimpinan',      'avatar' => 'assets/images/users/user-3.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 4,  'id_pegawai' => NULL, 'username' => 'wakil_pn',     'password' => $default_hash, 'nama_lengkap' => 'Hj. Fitriani, S.H., M.H.', 'email' => 'wakil@pn-lubukpakam.go.id', 'role' => 'pimpinan',      'avatar' => 'assets/images/users/user-4.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 5,  'id_pegawai' => NULL, 'username' => 'panitera',     'password' => $default_hash, 'nama_lengkap' => 'Bambang Wijaya, S.H., M.H.', 'email' => 'panitera@pn-lubukpakam.go.id', 'role' => 'tim_penilai',   'avatar' => 'assets/images/users/user-5.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 6,  'id_pegawai' => NULL, 'username' => 'sekretaris',   'password' => $default_hash, 'nama_lengkap' => 'Drs. Muhammad Rizky', 'email' => 'sekretaris@pn-lubukpakam.go.id', 'role' => 'tim_penilai',   'avatar' => 'assets/images/users/user-6.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 7,  'id_pegawai' => NULL, 'username' => 'penilai_hakim','password' => $default_hash, 'nama_lengkap' => 'Tim Penilai Kategori Hakim', 'email' => 'penilai.hakim@pn-lubukpakam.go.id', 'role' => 'tim_penilai',   'avatar' => 'assets/images/users/user-7.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 8,  'id_pegawai' => NULL, 'username' => 'penilai_pp',    'password' => $default_hash, 'nama_lengkap' => 'Tim Penilai Kategori PP', 'email' => 'penilai.pp@pn-lubukpakam.go.id', 'role' => 'tim_penilai',   'avatar' => 'assets/images/users/user-8.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 9,  'id_pegawai' => NULL, 'username' => 'penilai_js',    'password' => $default_hash, 'nama_lengkap' => 'Tim Penilai Kategori Jurusita', 'email' => 'penilai.js@pn-lubukpakam.go.id', 'role' => 'tim_penilai',   'avatar' => 'assets/images/users/user-9.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_user' => 10, 'id_pegawai' => NULL, 'username' => 'penilai_staf',  'password' => $default_hash, 'nama_lengkap' => 'Tim Penilai Kategori Staf', 'email' => 'penilai.staf@pn-lubukpakam.go.id', 'role' => 'tim_penilai',   'avatar' => 'assets/images/users/user-10.jpg', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('pengguna', $sample_users);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('pengguna', TRUE);
    }
}
