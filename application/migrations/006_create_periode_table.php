<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_periode_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for periode table
        $fields = array(
            'id_periode' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'nama_periode' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => FALSE
            ),
            'jenis_periode' => array(
                'type'       => 'ENUM',
                'constraint' => array('bulanan', 'triwulan', 'semester', 'tahunan'),
                'default'    => 'triwulan'
            ),
            'tahun' => array(
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => FALSE
            ),
            'tanggal_mulai' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'tanggal_selesai' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'keterangan' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'status' => array(
                'type'       => 'ENUM',
                'constraint' => array('buka', 'tutup'),
                'default'    => 'buka'
            ),
            'aktif' => array(
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1
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
        $this->dbforge->add_key('id_periode', TRUE);
        $this->dbforge->create_table('periode', TRUE);

        if ($this->db->table_exists('periode') && $this->db->table_exists('pengguna')) {
            $this->db->query("ALTER TABLE `periode` ADD CONSTRAINT `fk_periode_created_by` FOREIGN KEY (`created_by`) REFERENCES `pengguna`(`id_user`) ON DELETE SET NULL ON UPDATE CASCADE");
        }

        // 2. Insert Initial 10 Sample Periode Records
        $sample_periode = array(
            array('id_periode' => 1,  'nama_periode' => 'Triwulan II 2026',        'jenis_periode' => 'triwulan', 'tahun' => 2026, 'tanggal_mulai' => '2026-04-01', 'tanggal_selesai' => '2026-06-30', 'keterangan' => 'Periode penilaian kinerja reward Triwulan II T.A. 2026', 'status' => 'buka',  'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 2,  'nama_periode' => 'Triwulan I 2026',         'jenis_periode' => 'triwulan', 'tahun' => 2026, 'tanggal_mulai' => '2026-01-01', 'tanggal_selesai' => '2026-03-31', 'keterangan' => 'Periode penilaian Triwulan I T.A. 2026 (Selesai/Final)',  'status' => 'tutup', 'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 3,  'nama_periode' => 'Semester I 2026',         'jenis_periode' => 'semester', 'tahun' => 2026, 'tanggal_mulai' => '2026-01-01', 'tanggal_selesai' => '2026-06-30', 'keterangan' => 'Penilaian gabungan Semester I T.A. 2026',                'status' => 'buka',  'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 4,  'nama_periode' => 'Triwulan IV 2025',        'jenis_periode' => 'triwulan', 'tahun' => 2025, 'tanggal_mulai' => '2025-10-01', 'tanggal_selesai' => '2025-12-31', 'keterangan' => 'Periode akhir tahun T.A. 2025',                           'status' => 'tutup', 'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 5,  'nama_periode' => 'Triwulan III 2025',       'jenis_periode' => 'triwulan', 'tahun' => 2025, 'tanggal_mulai' => '2025-07-01', 'tanggal_selesai' => '2025-09-30', 'keterangan' => 'Penilaian Triwulan III T.A. 2025',                        'status' => 'tutup', 'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 6,  'nama_periode' => 'Semester II 2025',        'jenis_periode' => 'semester', 'tahun' => 2025, 'tanggal_mulai' => '2025-07-01', 'tanggal_selesai' => '2025-12-31', 'keterangan' => 'Penilaian Semester II T.A. 2025',                         'status' => 'tutup', 'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 7,  'nama_periode' => 'Tahunan 2025',            'jenis_periode' => 'tahunan',  'tahun' => 2025, 'tanggal_mulai' => '2025-01-01', 'tanggal_selesai' => '2025-12-31', 'keterangan' => 'Penilaian Tahunan Pegawai Terbaik T.A. 2025',              'status' => 'tutup', 'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 8,  'nama_periode' => 'Triwulan II 2025',        'jenis_periode' => 'triwulan', 'tahun' => 2025, 'tanggal_mulai' => '2025-04-01', 'tanggal_selesai' => '2025-06-30', 'keterangan' => 'Penilaian Triwulan II T.A. 2025',                         'status' => 'tutup', 'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 9,  'nama_periode' => 'Triwulan I 2025',         'jenis_periode' => 'triwulan', 'tahun' => 2025, 'tanggal_mulai' => '2025-01-01', 'tanggal_selesai' => '2025-03-31', 'keterangan' => 'Penilaian Triwulan I T.A. 2025',                          'status' => 'tutup', 'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_periode' => 10, 'nama_periode' => 'Triwulan III 2026 (Draft)','jenis_periode' => 'triwulan', 'tahun' => 2026, 'tanggal_mulai' => '2026-07-01', 'tanggal_selesai' => '2026-09-30', 'keterangan' => 'Persiapan Periode Mendatang T.A. 2026',                  'status' => 'buka',  'aktif' => 1, 'created_by' => 1, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('periode', $sample_periode);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('periode', TRUE);
    }
}
