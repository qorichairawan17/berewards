<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_assessment_tables extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Table: topsis_proses (Header Sesi Penilaian TOPSIS)
        $fields_proses = array(
            'id_proses' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_periode' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'kategori' => array(
                'type'       => 'ENUM',
                'constraint' => array('Hakim', 'Panitera Pengganti', 'Jurusita', 'Staf'),
                'null'       => TRUE
            ),
            'tanggal_proses' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'status' => array(
                'type'       => 'ENUM',
                'constraint' => array('draft', 'dinilai', 'dihitung', 'final'),
                'default'    => 'draft'
            ),
            'catatan' => array(
                'type' => 'TEXT',
                'null' => TRUE
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

        $this->dbforge->add_field($fields_proses);
        $this->dbforge->add_key('id_proses', TRUE);
        $this->dbforge->create_table('topsis_proses', TRUE);

        if ($this->db->table_exists('topsis_proses')) {
            if ($this->db->table_exists('periode')) {
                $this->db->query("ALTER TABLE `topsis_proses` ADD CONSTRAINT `fk_proses_periode` FOREIGN KEY (`id_periode`) REFERENCES `periode`(`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE");
            }
            if ($this->db->table_exists('pengguna')) {
                $this->db->query("ALTER TABLE `topsis_proses` ADD CONSTRAINT `fk_proses_created_by` FOREIGN KEY (`created_by`) REFERENCES `pengguna`(`id_user`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 2. Table: topsis_proses_kriteria (Snapshot Kriteria per Sesi TOPSIS)
        $fields_proses_kriteria = array(
            'id_proses_kriteria' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_proses' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'ref_kriteria_id' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE
            ),
            'kode' => array(
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => FALSE
            ),
            'nama_kriteria' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => FALSE
            ),
            'jenis_data' => array(
                'type'       => 'ENUM',
                'constraint' => array('kualitatif', 'kuantitatif'),
                'default'    => 'kuantitatif'
            ),
            'tipe_atribut' => array(
                'type'       => 'ENUM',
                'constraint' => array('benefit', 'cost'),
                'default'    => 'benefit'
            ),
            'bobot' => array(
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => FALSE
            ),
            'urutan' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($fields_proses_kriteria);
        $this->dbforge->add_key('id_proses_kriteria', TRUE);
        $this->dbforge->create_table('topsis_proses_kriteria', TRUE);

        if ($this->db->table_exists('topsis_proses_kriteria')) {
            $this->db->query("ALTER TABLE `topsis_proses_kriteria` ADD CONSTRAINT `fk_pkrit_proses` FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE ON UPDATE CASCADE");
            if ($this->db->table_exists('kriteria')) {
                $this->db->query("ALTER TABLE `topsis_proses_kriteria` ADD CONSTRAINT `fk_pkrit_ref` FOREIGN KEY (`ref_kriteria_id`) REFERENCES `kriteria`(`id_kriteria`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 3. Table: topsis_proses_alternatif (Snapshot Pegawai Alternatif per Sesi TOPSIS)
        $fields_proses_alternatif = array(
            'id_proses_alternatif' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_proses' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'id_pegawai' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'nip_snapshot' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => TRUE
            ),
            'nama_snapshot' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => FALSE
            ),
            'pangkat_snapshot' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'golongan_snapshot' => array(
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => TRUE
            ),
            'jabatan_snapshot' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($fields_proses_alternatif);
        $this->dbforge->add_key('id_proses_alternatif', TRUE);
        $this->dbforge->create_table('topsis_proses_alternatif', TRUE);

        if ($this->db->table_exists('topsis_proses_alternatif')) {
            $this->db->query("ALTER TABLE `topsis_proses_alternatif` ADD CONSTRAINT `fk_palt_proses` FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE ON UPDATE CASCADE");
            if ($this->db->table_exists('referensi_pegawai')) {
                $this->db->query("ALTER TABLE `topsis_proses_alternatif` ADD CONSTRAINT `fk_palt_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `referensi_pegawai`(`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE");
            }
        }

        // 4. Table: penilaian (Matriks Keputusan X - Input Nilai Mentah)
        $fields_penilaian = array(
            'id_penilaian' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_proses' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'id_proses_alternatif' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'id_proses_kriteria' => array(
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
            'id_kriteria' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE
            ),
            'nilai' => array(
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE
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

        $this->dbforge->add_field($fields_penilaian);
        $this->dbforge->add_key('id_penilaian', TRUE);
        $this->dbforge->create_table('penilaian', TRUE);

        if ($this->db->table_exists('penilaian')) {
            $this->db->query("ALTER TABLE `penilaian` ADD UNIQUE KEY `idx_alt_krit_unique` (`id_proses_alternatif`, `id_proses_kriteria`)");
            $this->db->query("ALTER TABLE `penilaian` ADD CONSTRAINT `fk_nilai_proses` FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE ON UPDATE CASCADE");
            $this->db->query("ALTER TABLE `penilaian` ADD CONSTRAINT `fk_nilai_alt` FOREIGN KEY (`id_proses_alternatif`) REFERENCES `topsis_proses_alternatif`(`id_proses_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE");
            $this->db->query("ALTER TABLE `penilaian` ADD CONSTRAINT `fk_nilai_krit` FOREIGN KEY (`id_proses_kriteria`) REFERENCES `topsis_proses_kriteria`(`id_proses_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE");
            if ($this->db->table_exists('referensi_pegawai')) {
                $this->db->query("ALTER TABLE `penilaian` ADD CONSTRAINT `fk_nilai_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `referensi_pegawai`(`id_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
            if ($this->db->table_exists('kriteria')) {
                $this->db->query("ALTER TABLE `penilaian` ADD CONSTRAINT `fk_nilai_kriteria_ref` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria`(`id_kriteria`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 5. Table: hasil_topsis (Solusi Ideal, Jarak D+ / D-, Preferensi Vi, & Ranking)
        $fields_hasil = array(
            'id_hasil' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_proses' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'id_proses_alternatif' => array(
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
            'd_positif' => array(
                'type'       => 'DECIMAL',
                'constraint' => '10,6',
                'null'       => FALSE
            ),
            'd_negatif' => array(
                'type'       => 'DECIMAL',
                'constraint' => '10,6',
                'null'       => FALSE
            ),
            'nilai_preferensi' => array(
                'type'       => 'DECIMAL',
                'constraint' => '10,6',
                'null'       => FALSE
            ),
            'ranking' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => FALSE
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

        $this->dbforge->add_field($fields_hasil);
        $this->dbforge->add_key('id_hasil', TRUE);
        $this->dbforge->create_table('hasil_topsis', TRUE);

        if ($this->db->table_exists('hasil_topsis')) {
            $this->db->query("ALTER TABLE `hasil_topsis` ADD CONSTRAINT `fk_hasil_proses` FOREIGN KEY (`id_proses`) REFERENCES `topsis_proses`(`id_proses`) ON DELETE CASCADE ON UPDATE CASCADE");
            $this->db->query("ALTER TABLE `hasil_topsis` ADD CONSTRAINT `fk_hasil_alt` FOREIGN KEY (`id_proses_alternatif`) REFERENCES `topsis_proses_alternatif`(`id_proses_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE");
            if ($this->db->table_exists('referensi_pegawai')) {
                $this->db->query("ALTER TABLE `hasil_topsis` ADD CONSTRAINT `fk_hasil_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `referensi_pegawai`(`id_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE");
            }
        }

        // 6. Insert Initial Sample Data for topsis_proses
        $sample_proses = array(
            array('id_proses' => 1, 'id_periode' => 1, 'kategori' => 'Hakim',              'tanggal_proses' => '2026-06-25 14:30:00', 'status' => 'final', 'catatan' => 'Kalkulasi TOPSIS Reward Triwulan II 2026 (Final)', 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 2, 'id_periode' => 2, 'kategori' => 'Hakim',              'tanggal_proses' => '2026-03-28 10:15:00', 'status' => 'final', 'catatan' => 'Kalkulasi TOPSIS Reward Triwulan I 2026 (Final)',  'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 3, 'id_periode' => 3, 'kategori' => 'Panitera Pengganti', 'tanggal_proses' => '2026-06-30 09:00:00', 'status' => 'draft', 'catatan' => 'Kalkulasi TOPSIS Semester I 2026 (Draft)',        'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 4, 'id_periode' => 4, 'kategori' => 'Jurusita',           'tanggal_proses' => '2025-12-29 16:45:00', 'status' => 'final', 'catatan' => 'Kalkulasi TOPSIS Triwulan IV 2025 (Final)',       'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 5, 'id_periode' => 7, 'kategori' => 'Staf',               'tanggal_proses' => '2025-12-30 11:20:00', 'status' => 'final', 'catatan' => 'Kalkulasi TOPSIS Tahunan 2025 (Final)',             'created_by' => 1, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('topsis_proses', $sample_proses);

        // 7. Insert Snapshot Kriteria for id_proses = 1
        $sample_kriteria_snapshot = array(
            array('id_proses_kriteria' => 1, 'id_proses' => 1, 'ref_kriteria_id' => 1, 'kode' => 'C1_HKM', 'nama_kriteria' => 'Kedisiplinan Kehadiran & Jam Kerja', 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'benefit', 'bobot' => 20.00, 'urutan' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses_kriteria' => 2, 'id_proses' => 1, 'ref_kriteria_id' => 2, 'kode' => 'C2_HKM', 'nama_kriteria' => 'Penyelesaian Perkara SIPP (Kepatuhan Waktu)', 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'benefit', 'bobot' => 35.00, 'urutan' => 2, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses_kriteria' => 3, 'id_proses' => 1, 'ref_kriteria_id' => 3, 'kode' => 'C3_HKM', 'nama_kriteria' => 'Integritas & Kepatuhan Kode Etik', 'jenis_data' => 'kualitatif', 'tipe_atribut' => 'benefit', 'bobot' => 25.00, 'urutan' => 3, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses_kriteria' => 4, 'id_proses' => 1, 'ref_kriteria_id' => 4, 'kode' => 'C4_HKM', 'nama_kriteria' => 'Tunggakan Minutasi Perkara', 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'cost', 'bobot' => 20.00, 'urutan' => 4, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('topsis_proses_kriteria', $sample_kriteria_snapshot);

        // 8. Insert Snapshot Alternatif for id_proses = 1
        $sample_alternatif_snapshot = array(
            array('id_proses_alternatif' => 1, 'id_proses' => 1, 'id_pegawai' => 1,  'nip_snapshot' => '19750812 200003 1 001', 'nama_snapshot' => 'Rina Agustina, S.H., M.H.', 'pangkat_snapshot' => 'Pembina Utama Muda', 'golongan_snapshot' => 'IV/c', 'jabatan_snapshot' => 'Hakim Utama / Ketua Majelis', 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses_alternatif' => 2, 'id_proses' => 1, 'id_pegawai' => 4,  'nip_snapshot' => '19850620 200902 2 008', 'nama_snapshot' => 'Dian Pratiwi, S.H., M.Kn.', 'pangkat_snapshot' => 'Penata', 'golongan_snapshot' => 'III/c', 'jabatan_snapshot' => 'Panitera Pengganti Muda', 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses_alternatif' => 3, 'id_proses' => 1, 'id_pegawai' => 7,  'nip_snapshot' => '19910514 201502 1 007', 'nama_snapshot' => 'Eko Prasetyo, S.H.', 'pangkat_snapshot' => 'Penata Muda Tk.I', 'golongan_snapshot' => 'III/b', 'jabatan_snapshot' => 'Jurusita Utama', 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses_alternatif' => 4, 'id_proses' => 1, 'id_pegawai' => 10, 'nip_snapshot' => '19941201 201802 2 009', 'nama_snapshot' => 'Dewi Sartika, S.H.', 'pangkat_snapshot' => 'Penata Muda', 'golongan_snapshot' => 'III/a', 'jabatan_snapshot' => 'Staf Kesekretariatan', 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses_alternatif' => 5, 'id_proses' => 1, 'id_pegawai' => 2,  'nip_snapshot' => '19800315 200501 1 004', 'nama_snapshot' => 'Ahmad Faisal, S.H.', 'pangkat_snapshot' => 'Pembina', 'golongan_snapshot' => 'IV/a', 'jabatan_snapshot' => 'Hakim Pratama', 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('topsis_proses_alternatif', $sample_alternatif_snapshot);

        // 9. Insert Initial Sample Data for hasil_topsis (id_proses = 1)
        $sample_hasil = array(
            array('id_proses' => 1, 'id_proses_alternatif' => 1, 'id_pegawai' => 1,  'd_positif' => 0.021500, 'd_negatif' => 0.348200, 'nilai_preferensi' => 0.942000, 'ranking' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 2, 'id_pegawai' => 4,  'd_positif' => 0.041200, 'd_negatif' => 0.317500, 'nilai_preferensi' => 0.885000, 'ranking' => 2, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 3, 'id_pegawai' => 7,  'd_positif' => 0.048900, 'd_negatif' => 0.310500, 'nilai_preferensi' => 0.864000, 'ranking' => 3, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 4, 'id_pegawai' => 10, 'd_positif' => 0.062000, 'd_negatif' => 0.284100, 'nilai_preferensi' => 0.821000, 'ranking' => 4, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 5, 'id_pegawai' => 2,  'd_positif' => 0.071500, 'd_negatif' => 0.277000, 'nilai_preferensi' => 0.795000, 'ranking' => 5, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('hasil_topsis', $sample_hasil);

        // 10. Insert Initial Sample Data for penilaian (Matriks Mentah id_proses = 1)
        $sample_penilaian = array(
            // Alternatif 1 (Rina Agustina)
            array('id_proses' => 1, 'id_proses_alternatif' => 1, 'id_proses_kriteria' => 1, 'id_pegawai' => 1, 'id_kriteria' => 1, 'nilai' => 4.80, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 1, 'id_proses_kriteria' => 2, 'id_pegawai' => 1, 'id_kriteria' => 2, 'nilai' => 95.50, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 1, 'id_proses_kriteria' => 3, 'id_pegawai' => 1, 'id_kriteria' => 3, 'nilai' => 4.90, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 1, 'id_proses_kriteria' => 4, 'id_pegawai' => 1, 'id_kriteria' => 4, 'nilai' => 0.00, 'created_at' => date('Y-m-d H:i:s')),

            // Alternatif 2 (Dian Pratiwi)
            array('id_proses' => 1, 'id_proses_alternatif' => 2, 'id_proses_kriteria' => 1, 'id_pegawai' => 4, 'id_kriteria' => 1, 'nilai' => 4.70, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 2, 'id_proses_kriteria' => 2, 'id_pegawai' => 4, 'id_kriteria' => 2, 'nilai' => 92.00, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 3, 'id_proses_kriteria' => 3, 'id_pegawai' => 4, 'id_kriteria' => 3, 'nilai' => 4.80, 'created_at' => date('Y-m-d H:i:s')),
            array('id_proses' => 1, 'id_proses_alternatif' => 4, 'id_proses_kriteria' => 4, 'id_pegawai' => 4, 'id_kriteria' => 4, 'nilai' => 1.00, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('penilaian', $sample_penilaian);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('hasil_topsis', TRUE);
        $this->dbforge->drop_table('penilaian', TRUE);
        $this->dbforge->drop_table('topsis_proses_alternatif', TRUE);
        $this->dbforge->drop_table('topsis_proses_kriteria', TRUE);
        $this->dbforge->drop_table('topsis_proses', TRUE);
    }
}
