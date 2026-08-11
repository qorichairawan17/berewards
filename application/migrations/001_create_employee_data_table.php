<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_employee_data_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for employee_data table
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
            'nama_pegawai' => array(
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
                'constraint' => '100',
                'null'       => FALSE
            ),
            'unit_kerja' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Pengadilan Negeri Lubuk Pakam'
            ),
            'kategori' => array(
                'type'       => 'ENUM',
                'constraint' => array('Hakim', 'Panitera Pengganti', 'Jurusita', 'Staf'),
                'null'       => FALSE
            ),
            'email' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'no_hp' => array(
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => TRUE
            ),
            'foto' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'assets/images/users/user-default.jpg'
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

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id_pegawai', TRUE); // Primary Key

        // Create table employee_data
        $this->dbforge->create_table('employee_data', TRUE);

        // Add Unique Key for NIP if table was newly created
        if ($this->db->table_exists('employee_data')) {
            $this->db->query("ALTER TABLE `employee_data` ADD UNIQUE KEY `idx_nip_unique` (`nip`)");
        }

        // 2. Insert Sample Initial Data (10 Pegawai PN Lubuk Pakam)
        $sample_data = array(
            array(
                'nip'          => '19680512 199303 1 001',
                'nama_pegawai' => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
                'pangkat'      => 'Pembina Utama Muda',
                'golongan'     => 'IV/c',
                'jabatan'      => 'Ketua Pengadilan Negeri',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Hakim',
                'email'        => 'ahmad.syafii@pn-lubukpakam.go.id',
                'no_hp'        => '08116012345',
                'foto'         => 'assets/images/users/user-1.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19720820 199803 2 002',
                'nama_pegawai' => 'Hj. Fitriani, S.H., M.H.',
                'pangkat'      => 'Pembina Tingkat I',
                'golongan'     => 'IV/b',
                'jabatan'      => 'Wakil Ketua Pengadilan Negeri',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Hakim',
                'email'        => 'fitriani@pn-lubukpakam.go.id',
                'no_hp'        => '08126023456',
                'foto'         => 'assets/images/users/user-2.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19830130 200804 1 003',
                'nama_pegawai' => 'Rizky Ramadhan, S.H.',
                'pangkat'      => 'Penata',
                'golongan'     => 'III/c',
                'jabatan'      => 'Hakim Pratama Muda',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Hakim',
                'email'        => 'rizky.ramadhan@pn-lubukpakam.go.id',
                'no_hp'        => '08136034567',
                'foto'         => 'assets/images/users/user-3.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19750410 199903 1 001',
                'nama_pegawai' => 'Bambang Wijaya, S.H., M.H.',
                'pangkat'      => 'Pembina',
                'golongan'     => 'IV/a',
                'jabatan'      => 'Panitera Pengadilan Negeri',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Panitera Pengganti',
                'email'        => 'bambang.wijaya@pn-lubukpakam.go.id',
                'no_hp'        => '08146045678',
                'foto'         => 'assets/images/users/user-4.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19850615 200912 2 004',
                'nama_pegawai' => 'Siti Aminah, A.Md., S.H.',
                'pangkat'      => 'Penata Muda Tingkat I',
                'golongan'     => 'III/b',
                'jabatan'      => 'Panitera Pengganti',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Panitera Pengganti',
                'email'        => 'siti.aminah@pn-lubukpakam.go.id',
                'no_hp'        => '08156056789',
                'foto'         => 'assets/images/users/user-6.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19880222 201101 1 005',
                'nama_pegawai' => 'Eko Prasetyo, S.H.',
                'pangkat'      => 'Penata Muda',
                'golongan'     => 'III/a',
                'jabatan'      => 'Jurusita',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Jurusita',
                'email'        => 'eko.prasetyo@pn-lubukpakam.go.id',
                'no_hp'        => '08166067890',
                'foto'         => 'assets/images/users/user-7.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19920708 201402 1 006',
                'nama_pegawai' => 'Hendra Setiawan, S.H.',
                'pangkat'      => 'Pengatur Tingkat I',
                'golongan'     => 'II/d',
                'jabatan'      => 'Jurusita Pengganti',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Jurusita',
                'email'        => 'hendra.setiawan@pn-lubukpakam.go.id',
                'no_hp'        => '08176078901',
                'foto'         => 'assets/images/users/user-11.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19940319 201801 2 007',
                'nama_pegawai' => 'Nurfadillah, S.E.',
                'pangkat'      => 'Penata Muda',
                'golongan'     => 'III/a',
                'jabatan'      => 'Staf Pengelola Keuangan & Perencanaan',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Staf',
                'email'        => 'nurfadillah@pn-lubukpakam.go.id',
                'no_hp'        => '08186089012',
                'foto'         => 'assets/images/users/user-8.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19951111 201903 2 008',
                'nama_pegawai' => 'Dewi Sartika, S.H.',
                'pangkat'      => 'Penata Muda',
                'golongan'     => 'III/a',
                'jabatan'      => 'Kasubbag Kepegawaian & ORTALA',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Staf',
                'email'        => 'dewi.sartika@pn-lubukpakam.go.id',
                'no_hp'        => '08196090123',
                'foto'         => 'assets/images/users/user-9.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ),
            array(
                'nip'          => '19960905 202012 1 009',
                'nama_pegawai' => 'Ahmad Faisal, S.Kom.',
                'pangkat'      => 'Pengatur',
                'golongan'     => 'II/c',
                'jabatan'      => 'Staf Pranata Komputer / IT',
                'unit_kerja'   => 'Pengadilan Negeri Lubuk Pakam',
                'kategori'     => 'Staf',
                'email'        => 'ahmad.faisal@pn-lubukpakam.go.id',
                'no_hp'        => '08206001234',
                'foto'         => 'assets/images/users/user-12.jpg',
                'aktif'        => 1,
                'created_at'   => date('Y-m-d H:i:s')
            )
        );

        $this->db->insert_batch('employee_data', $sample_data);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('employee_data', TRUE);
    }
}
