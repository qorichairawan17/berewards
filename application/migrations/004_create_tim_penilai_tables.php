<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_tim_penilai_tables extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for tim_penilai_sk (Header SK)
        $fields_sk = array(
            'id_sk' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'no_sk' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => FALSE
            ),
            'tahun' => array(
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => FALSE
            ),
            'tanggal_sk' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'perihal' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => FALSE
            ),
            'status' => array(
                'type'       => 'ENUM',
                'constraint' => array('Aktif', 'Selesai', 'Arsip'),
                'default'    => 'Aktif'
            ),
            'file_sk' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
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

        $this->dbforge->add_field($fields_sk);
        $this->dbforge->add_key('id_sk', TRUE);
        $this->dbforge->create_table('tim_penilai_sk', TRUE);

        if ($this->db->table_exists('tim_penilai_sk')) {
            $this->db->query("ALTER TABLE `tim_penilai_sk` ADD UNIQUE KEY `idx_nosk_unique` (`no_sk`)");
        }

        // 2. Define Fields for tim_penilai_anggota (Detail Personel Tim Penilai)
        $fields_anggota = array(
            'id_anggota' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_sk' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'id_pegawai' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE
            ),
            'nama_personel' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => FALSE
            ),
            'nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => TRUE
            ),
            'jabatan_instansi' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'peran_tim' => array(
                'type'       => 'ENUM',
                'constraint' => array('Ketua', 'Sekretaris', 'Anggota'),
                'default'    => 'Anggota'
            ),
            'kategori_penilaian' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
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

        $this->dbforge->add_field($fields_anggota);
        $this->dbforge->add_key('id_anggota', TRUE);
        $this->dbforge->create_table('tim_penilai_anggota', TRUE);

        // Add Foreign Keys for tim_penilai_anggota
        if ($this->db->table_exists('tim_penilai_anggota')) {
            $this->db->query("ALTER TABLE `tim_penilai_anggota` ADD CONSTRAINT `fk_anggota_sk` FOREIGN KEY (`id_sk`) REFERENCES `tim_penilai_sk`(`id_sk`) ON DELETE CASCADE ON UPDATE CASCADE");
            if ($this->db->table_exists('referensi_pegawai')) {
                $this->db->query("ALTER TABLE `tim_penilai_anggota` ADD CONSTRAINT `fk_anggota_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `referensi_pegawai`(`id_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 3. Insert Initial Sample SK Data
        $sk_data = array(
            array('id_sk' => 1, 'no_sk' => 'W2.U4/01/SK.TIM-SPK/01/2026', 'tahun' => 2026, 'tanggal_sk' => '2026-01-05', 'perihal' => 'SK Penetapan Tim Penilai SPK Penentuan Reward Pegawai Tahun 2026', 'status' => 'Aktif', 'file_sk' => 'uploads/sk/SK_Tim_Penilai_TOPSIS_2026.pdf', 'created_at' => date('Y-m-d H:i:s')),
            array('id_sk' => 2, 'no_sk' => 'W2.U4/15/SK.TIM-SPK/07/2025', 'tahun' => 2025, 'tanggal_sk' => '2025-07-01', 'perihal' => 'SK Tim Penilai SPK Reward Semester II Tahun 2025', 'status' => 'Selesai', 'file_sk' => 'uploads/sk/SK_Tim_Penilai_TOPSIS_2025_Sem2.pdf', 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('tim_penilai_sk', $sk_data);

        // 4. Insert Initial Sample Anggota Data
        $anggota_data = array(
            array('id_sk' => 1, 'id_pegawai' => 3, 'nama_personel' => "Dr. H. Ahmad Syafi'i, S.H., M.H.", 'nip' => '19680512 199303 1 001', 'jabatan_instansi' => 'Ketua Pengadilan Negeri', 'peran_tim' => 'Ketua', 'kategori_penilaian' => 'Penanggung Jawab Utama', 'created_at' => date('Y-m-d H:i:s')),
            array('id_sk' => 1, 'id_pegawai' => 6, 'nama_personel' => 'Drs. Muhammad Rizky', 'nip' => '19781115 200212 1 004', 'jabatan_instansi' => 'Sekretaris Pengadilan Negeri', 'peran_tim' => 'Sekretaris', 'kategori_penilaian' => 'Sekretaris Pengelola Tim', 'created_at' => date('Y-m-d H:i:s')),
            array('id_sk' => 1, 'id_pegawai' => 4, 'nama_personel' => 'Hj. Fitriani, S.H., M.H.', 'nip' => '19720820 199703 2 002', 'jabatan_instansi' => 'Wakil Ketua Pengadilan Negeri', 'peran_tim' => 'Anggota', 'kategori_penilaian' => 'Penilai Kategori Hakim', 'created_at' => date('Y-m-d H:i:s')),
            array('id_sk' => 1, 'id_pegawai' => 5, 'nama_personel' => 'Bambang Wijaya, S.H., M.H.', 'nip' => '19750310 199903 1 003', 'jabatan_instansi' => 'Panitera Pengadilan Negeri', 'peran_tim' => 'Anggota', 'kategori_penilaian' => 'Penilai Kategori Panitera Pengganti', 'created_at' => date('Y-m-d H:i:s')),
            array('id_sk' => 1, 'id_pegawai' => 10,'nama_personel' => 'Dewi Sartika, S.H.', 'nip' => '19941201 201802 2 009', 'jabatan_instansi' => 'Kasubbag Kepegawaian & Ortala', 'peran_tim' => 'Anggota', 'kategori_penilaian' => 'Penilai Kategori Jurusita & Staf', 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('tim_penilai_anggota', $anggota_data);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('tim_penilai_anggota', TRUE);
        $this->dbforge->drop_table('tim_penilai_sk', TRUE);
    }
}
