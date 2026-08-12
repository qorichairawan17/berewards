<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_kriteria_tables extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for kriteria table (Master Kriteria TOPSIS)
        $fields_kriteria = array(
            'id_kriteria' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
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
            'kategori' => array(
                'type'       => 'ENUM',
                'constraint' => array('Hakim', 'Panitera Pengganti', 'Jurusita', 'Staf'),
                'null'       => FALSE
            ),
            'bobot' => array(
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
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
            'urutan' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ),
            'aktif' => array(
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1
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

        $this->dbforge->add_field($fields_kriteria);
        $this->dbforge->add_key('id_kriteria', TRUE);
        $this->dbforge->create_table('kriteria', TRUE);

        if ($this->db->table_exists('kriteria')) {
            $this->db->query("ALTER TABLE `kriteria` ADD UNIQUE KEY `idx_kode_unique` (`kode`)");
        }

        // 2. Define Fields for skala_kriteria table (Opsi Skala Penilaian Kualitatif)
        $fields_skala = array(
            'id_skala' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'id_kriteria' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => FALSE
            ),
            'label' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => FALSE
            ),
            'nilai' => array(
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
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($fields_skala);
        $this->dbforge->add_key('id_skala', TRUE);
        $this->dbforge->create_table('skala_kriteria', TRUE);

        if ($this->db->table_exists('skala_kriteria') && $this->db->table_exists('kriteria')) {
            $this->db->query("ALTER TABLE `skala_kriteria` ADD CONSTRAINT `fk_skala_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria`(`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE");
        }

        // 3. Insert Initial 10 Sample Kriteria Records
        $sample_kriteria = array(
            array('id_kriteria' => 1,  'kode' => 'C1_HKM', 'nama_kriteria' => 'Kedisiplinan Kehadiran & Jam Kerja', 'kategori' => 'Hakim', 'bobot' => 20.00, 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'benefit', 'urutan' => 1, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 2,  'kode' => 'C2_HKM', 'nama_kriteria' => 'Penyelesaian Perkara SIPP (Kepatuhan Waktu)', 'kategori' => 'Hakim', 'bobot' => 35.00, 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'benefit', 'urutan' => 2, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 3,  'kode' => 'C3_HKM', 'nama_kriteria' => 'Integritas & Kepatuhan Kode Etik', 'kategori' => 'Hakim', 'bobot' => 25.00, 'jenis_data' => 'kualitatif', 'tipe_atribut' => 'benefit', 'urutan' => 3, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 4,  'kode' => 'C4_HKM', 'nama_kriteria' => 'Tunggakan Minutasi Perkara', 'kategori' => 'Hakim', 'bobot' => 20.00, 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'cost', 'urutan' => 4, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 5,  'kode' => 'C1_PP',  'nama_kriteria' => 'Kecepatan Minutasi Berkas Perkara', 'kategori' => 'Panitera Pengganti', 'bobot' => 30.00, 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'benefit', 'urutan' => 1, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 6,  'kode' => 'C2_PP',  'nama_kriteria' => 'Kepatuhan Penginputan e-Court & SIPP', 'kategori' => 'Panitera Pengganti', 'bobot' => 30.00, 'jenis_data' => 'kualitatif', 'tipe_atribut' => 'benefit', 'urutan' => 2, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 7,  'kode' => 'C3_PP',  'nama_kriteria' => 'Kedisiplinan & Ketertiban Berkas Persidangan', 'kategori' => 'Panitera Pengganti', 'bobot' => 40.00, 'jenis_data' => 'kualitatif', 'tipe_atribut' => 'benefit', 'urutan' => 3, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 8,  'kode' => 'C1_JS',  'nama_kriteria' => 'Kecepatan Penyampaian Relaas Panggilan', 'kategori' => 'Jurusita', 'bobot' => 50.00, 'jenis_data' => 'kuantitatif', 'tipe_atribut' => 'benefit', 'urutan' => 1, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 9,  'kode' => 'C2_JS',  'nama_kriteria' => 'Akurasi & Validitas Upload Berita Acara Relaas', 'kategori' => 'Jurusita', 'bobot' => 50.00, 'jenis_data' => 'kualitatif', 'tipe_atribut' => 'benefit', 'urutan' => 2, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_kriteria' => 10, 'kode' => 'C1_STF', 'nama_kriteria' => 'Capaian Kinerja Pegawai (SKP) & Pelayanan Publik', 'kategori' => 'Staf', 'bobot' => 100.00, 'jenis_data' => 'kualitatif', 'tipe_atribut' => 'benefit', 'urutan' => 1, 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('kriteria', $sample_kriteria);

        // 4. Insert Initial Sample Skala Kriteria for Kualitatif Criteria (IDs: 3, 6, 7, 9, 10)
        $kualitatif_ids = array(3, 6, 7, 9, 10);
        $sample_skala = array();

        foreach ($kualitatif_ids as $id_kriteria) {
            $sample_skala[] = array('id_kriteria' => $id_kriteria, 'label' => 'Sangat Baik', 'nilai' => 5.00, 'urutan' => 1, 'created_at' => date('Y-m-d H:i:s'));
            $sample_skala[] = array('id_kriteria' => $id_kriteria, 'label' => 'Baik',        'nilai' => 4.00, 'urutan' => 2, 'created_at' => date('Y-m-d H:i:s'));
            $sample_skala[] = array('id_kriteria' => $id_kriteria, 'label' => 'Cukup',       'nilai' => 3.00, 'urutan' => 3, 'created_at' => date('Y-m-d H:i:s'));
            $sample_skala[] = array('id_kriteria' => $id_kriteria, 'label' => 'Kurang',      'nilai' => 2.00, 'urutan' => 4, 'created_at' => date('Y-m-d H:i:s'));
            $sample_skala[] = array('id_kriteria' => $id_kriteria, 'label' => 'Sangat Kurang','nilai' => 1.00, 'urutan' => 5, 'created_at' => date('Y-m-d H:i:s'));
        }

        $this->db->insert_batch('skala_kriteria', $sample_skala);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('skala_kriteria', TRUE);
        $this->dbforge->drop_table('kriteria', TRUE);
    }
}
