<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_laporan_ba_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for laporan_ba table (Berita Acara Hasil TOPSIS)
        $fields = array(
            'id_laporan' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'no_ba' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => FALSE
            ),
            'id_proses' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'id_periode' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'id_sk' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE
            ),
            'kategori' => array(
                'type'       => 'ENUM',
                'constraint' => array('Hakim', 'Panitera Pengganti', 'Jurusita', 'Staf'),
                'null'       => FALSE
            ),
            'id_pemenang' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE
            ),
            'pemenang_nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => FALSE
            ),
            'pemenang_nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => TRUE
            ),
            'skor_topsis' => array(
                'type'       => 'DECIMAL',
                'constraint' => '10,6',
                'null'       => FALSE
            ),
            'tanggal_terbit' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'status' => array(
                'type'       => 'ENUM',
                'constraint' => array('Draft', 'Diajukan', 'Disahkan', 'Arsip'),
                'default'    => 'Disahkan'
            ),
            'ketua_panitia' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'file_ba' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
            ),
            'created_by' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
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

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id_laporan', TRUE);
        $this->dbforge->create_table('laporan_ba', TRUE);

        if ($this->db->table_exists('laporan_ba')) {
            $this->db->query("ALTER TABLE `laporan_ba` ADD UNIQUE KEY `idx_noba_unique` (`no_ba`)");

            if ($this->db->table_exists('topsis_proses')) {
                $this->db->query("ALTER TABLE `laporan_ba` ADD CONSTRAINT `fk_ba_proses` FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE ON UPDATE CASCADE");
            }
            if ($this->db->table_exists('periode')) {
                $this->db->query("ALTER TABLE `laporan_ba` ADD CONSTRAINT `fk_ba_periode` FOREIGN KEY (`id_periode`) REFERENCES `periode`(`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE");
            }
            if ($this->db->table_exists('tim_penilai_sk')) {
                $this->db->query("ALTER TABLE `laporan_ba` ADD CONSTRAINT `fk_ba_sk` FOREIGN KEY (`id_sk`) REFERENCES `tim_penilai_sk`(`id_sk`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
            if ($this->db->table_exists('referensi_pegawai')) {
                $this->db->query("ALTER TABLE `laporan_ba` ADD CONSTRAINT `fk_ba_pemenang` FOREIGN KEY (`id_pemenang`) REFERENCES `referensi_pegawai`(`id_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
            if ($this->db->table_exists('pengguna')) {
                $this->db->query("ALTER TABLE `laporan_ba` ADD CONSTRAINT `fk_ba_created_by` FOREIGN KEY (`created_by`) REFERENCES `pengguna`(`id_user`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 2. Insert Initial 5 Sample Berita Acara Reports
        $sample_ba = array(
            array(
                'id_laporan'     => 1,
                'no_ba'          => 'W2.U4/01/BA.SPK/06/2026',
                'id_proses'      => 1,
                'id_periode'     => 1,
                'id_sk'          => 1,
                'kategori'       => 'Hakim',
                'id_pemenang'    => 1,
                'pemenang_nama'  => 'Rina Agustina, S.H., M.H.',
                'pemenang_nip'   => '19750812 200003 1 001',
                'skor_topsis'    => 0.942000,
                'tanggal_terbit' => '2026-06-30',
                'status'         => 'Disahkan',
                'ketua_panitia'  => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'file_ba'        => 'uploads/laporan/BA_Reward_Hakim_Triwulan_II_2026.docx',
                'created_by'     => 1,
                'created_at'     => date('Y-m-d H:i:s')
            ),
            array(
                'id_laporan'     => 2,
                'no_ba'          => 'W2.U4/02/BA.SPK/06/2026',
                'id_proses'      => 3,
                'id_periode'     => 1,
                'id_sk'          => 1,
                'kategori'       => 'Panitera Pengganti',
                'id_pemenang'    => 4,
                'pemenang_nama'  => 'Dian Pratiwi, S.H., M.Kn.',
                'pemenang_nip'   => '19850620 200902 2 008',
                'skor_topsis'    => 0.885000,
                'tanggal_terbit' => '2026-06-30',
                'status'         => 'Disahkan',
                'ketua_panitia'  => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'file_ba'        => 'uploads/laporan/BA_Reward_PP_Triwulan_II_2026.docx',
                'created_by'     => 1,
                'created_at'     => date('Y-m-d H:i:s')
            ),
            array(
                'id_laporan'     => 3,
                'no_ba'          => 'W2.U4/03/BA.SPK/06/2026',
                'id_proses'      => 4,
                'id_periode'     => 1,
                'id_sk'          => 1,
                'kategori'       => 'Jurusita',
                'id_pemenang'    => 7,
                'pemenang_nama'  => 'Eko Prasetyo, S.H.',
                'pemenang_nip'   => '19910514 201502 1 007',
                'skor_topsis'    => 0.864000,
                'tanggal_terbit' => '2026-06-30',
                'status'         => 'Disahkan',
                'ketua_panitia'  => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'file_ba'        => 'uploads/laporan/BA_Reward_Jurusita_Triwulan_II_2026.docx',
                'created_by'     => 1,
                'created_at'     => date('Y-m-d H:i:s')
            ),
            array(
                'id_laporan'     => 4,
                'no_ba'          => 'W2.U4/04/BA.SPK/06/2026',
                'id_proses'      => 5,
                'id_periode'     => 1,
                'id_sk'          => 1,
                'kategori'       => 'Staf',
                'id_pemenang'    => 10,
                'pemenang_nama'  => 'Dewi Sartika, S.H.',
                'pemenang_nip'   => '19941201 201802 2 009',
                'skor_topsis'    => 0.821000,
                'tanggal_terbit' => '2026-06-30',
                'status'         => 'Disahkan',
                'ketua_panitia'  => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'file_ba'        => 'uploads/laporan/BA_Reward_Staf_Triwulan_II_2026.docx',
                'created_by'     => 1,
                'created_at'     => date('Y-m-d H:i:s')
            ),
            array(
                'id_laporan'     => 5,
                'no_ba'          => 'W2.U4/05/BA.SPK/03/2026',
                'id_proses'      => 2,
                'id_periode'     => 2,
                'id_sk'          => 1,
                'kategori'       => 'Hakim',
                'id_pemenang'    => 2,
                'pemenang_nama'  => 'Ahmad Faisal, S.H.',
                'pemenang_nip'   => '19800315 200501 1 004',
                'skor_topsis'    => 0.915000,
                'tanggal_terbit' => '2026-03-31',
                'status'         => 'Disahkan',
                'ketua_panitia'  => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'file_ba'        => 'uploads/laporan/BA_Reward_Hakim_Triwulan_I_2026.docx',
                'created_by'     => 1,
                'created_at'     => date('Y-m-d H:i:s')
            )
        );

        $this->db->insert_batch('laporan_ba', $sample_ba);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('laporan_ba', TRUE);
    }
}
