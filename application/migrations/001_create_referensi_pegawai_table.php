<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_referensi_pegawai_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for referensi_pegawai table
        $fields = array(
            'id_pegawai' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => FALSE
            ),
            'nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => FALSE
            ),
            'pangkat' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'golongan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => TRUE
            ),
            'jabatan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'kategori' => array(
                'type'       => 'ENUM',
                'constraint' => array('Hakim', 'Panitera Pengganti', 'Jurusita', 'Staf'),
                'null'       => FALSE
            ),
            'aktif' => array(
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1
            ),
            'foto' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE,
                'default'    => NULL
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
        $this->dbforge->add_key('id_pegawai', TRUE);
        $this->dbforge->create_table('referensi_pegawai', TRUE);

        if ($this->db->table_exists('referensi_pegawai')) {
            $this->db->query("ALTER TABLE `referensi_pegawai` ADD UNIQUE KEY `idx_nip_unique` (`nip`)");
        }

        // 2. Insert 10 Initial Sample Employee Records
        $sample_data = array(
            array('id_pegawai' => 1,  'nip' => '19750812 200003 1 001', 'nama' => 'Rina Agustina, S.H., M.H.', 'pangkat' => 'Pembina Utama Muda', 'golongan' => 'IV/c', 'jabatan' => 'Hakim Utama / Ketua Majelis', 'kategori' => 'Hakim', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 2,  'nip' => '19800315 200501 1 004', 'nama' => 'Ahmad Faisal, S.H.', 'pangkat' => 'Pembina', 'golongan' => 'IV/a', 'jabatan' => 'Hakim Pratama', 'kategori' => 'Hakim', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 3,  'nip' => '19821104 200804 2 002', 'nama' => 'Nurmala Sari, S.H.', 'pangkat' => 'Penata Tk.I', 'golongan' => 'III/d', 'jabatan' => 'Hakim Member', 'kategori' => 'Hakim', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 4,  'nip' => '19850620 200902 2 008', 'nama' => 'Dian Pratiwi, S.H., M.Kn.', 'pangkat' => 'Penata', 'golongan' => 'III/c', 'jabatan' => 'Panitera Pengganti Muda', 'kategori' => 'Panitera Pengganti', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 5,  'nip' => '19881110 201101 1 005', 'nama' => 'Budi Santoso, S.H.', 'pangkat' => 'Penata Muda Tk.I', 'golongan' => 'III/b', 'jabatan' => 'Panitera Pengganti Perdata', 'kategori' => 'Panitera Pengganti', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 6,  'nip' => '19900115 201403 2 003', 'nama' => 'Siti Rahmawati, S.H.', 'pangkat' => 'Penata Muda', 'golongan' => 'III/a', 'jabatan' => 'Panitera Pengganti Pidana', 'kategori' => 'Panitera Pengganti', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 7,  'nip' => '19910514 201502 1 007', 'nama' => 'Eko Prasetyo, S.H.', 'pangkat' => 'Penata Muda Tk.I', 'golongan' => 'III/b', 'jabatan' => 'Jurusita Utama', 'kategori' => 'Jurusita', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 8,  'nip' => '19930722 201701 1 009', 'nama' => 'Hendra Gunawan, A.Md.', 'pangkat' => 'Pengatur Tk.I', 'golongan' => 'II/d', 'jabatan' => 'Jurusita Pengganti', 'kategori' => 'Jurusita', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 9,  'nip' => '19950228 201903 2 006', 'nama' => 'Fitri Handayani, S.Kom.', 'pangkat' => 'Penata Muda', 'golongan' => 'III/a', 'jabatan' => 'Pranata Komputer / Staf IT', 'kategori' => 'Staf', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s')),
            array('id_pegawai' => 10, 'nip' => '19941201 201802 2 009', 'nama' => 'Dewi Sartika, S.H.', 'pangkat' => 'Penata Muda', 'golongan' => 'III/a', 'jabatan' => 'Staf Kesekretariatan', 'kategori' => 'Staf', 'aktif' => 1, 'created_at' => date('Y-m-d H:i:s'))
        );

        $this->db->insert_batch('referensi_pegawai', $sample_data);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('referensi_pegawai', TRUE);
    }
}
