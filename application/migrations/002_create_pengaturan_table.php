<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_pengaturan_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for pengaturan table
        $fields = array(
            'id_setting' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'nama_satker' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => FALSE
            ),
            'kode_satker' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE
            ),
            'tingkat_pengadilan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'alamat' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'telepon' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE
            ),
            'email' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'website' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'nama_ketua' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'nip_ketua' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => TRUE
            ),
            'nama_panitera' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'nip_panitera' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => TRUE
            ),
            'nama_sekretaris' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'nip_sekretaris' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => TRUE
            ),
            'logo' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
            ),
            'format_nomor_sk' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->dbforge->add_key('id_setting', TRUE);
        $this->dbforge->create_table('pengaturan', TRUE);

        // 2. Insert Initial Satker Settings Record
        $sample_setting = array(
            'id_setting'         => 1,
            'nama_satker'        => 'Pengadilan Negeri Lubuk Pakam Kelas I-A',
            'kode_satker'        => 'W2.U4',
            'tingkat_pengadilan' => 'Pengadilan Negeri Kelas I-A',
            'alamat'             => 'Jl. Sisingamangaraja No. 182, Lubuk Pakam, Kabupaten Deli Serdang, Sumatera Utara 20511',
            'telepon'            => '(061) 7951234',
            'email'              => 'pn.lubukpakam@mahkamahagung.go.id',
            'website'            => 'https://pn-lubukpakam.go.id',
            'nama_ketua'         => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
            'nip_ketua'          => '19680512 199303 1 001',
            'nama_panitera'      => 'Bambang Wijaya, S.H., M.H.',
            'nip_panitera'       => '19750310 199903 1 003',
            'nama_sekretaris'    => 'Drs. Muhammad Rizky',
            'nip_sekretaris'     => '19781115 200212 1 004',
            'logo'               => 'assets/images/logo-pn.png',
            'format_nomor_sk'    => 'W2.U4/{NO}/SK.TIM-SPK/{BLN}/{THN}',
            'created_at'         => date('Y-m-d H:i:s')
        );

        $this->db->insert('pengaturan', $sample_setting);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('pengaturan', TRUE);
    }
}
