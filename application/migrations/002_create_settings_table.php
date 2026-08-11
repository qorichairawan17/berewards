<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_settings_table extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        // 1. Define Fields for settings table
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
                'default'    => 'Pengadilan Negeri Lubuk Pakam Kelas I-A'
            ),
            'singkatan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'PN Lubuk Pakam'
            ),
            'kode_satker' => array(
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '005021'
            ),
            'kode_wilayah' => array(
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'W2.U4'
            ),
            'kelas_pengadilan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Kelas I-A'
            ),
            'pengadilan_tinggi' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'default'    => 'Pengadilan Tinggi Medan'
            ),
            'alamat' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'Jl. Sudirman No. 18, Lubuk Pakam'
            ),
            'kota' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Kabupaten Deli Serdang'
            ),
            'provinsi' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Sumatera Utara'
            ),
            'kode_pos' => array(
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default'    => '20511'
            ),
            'telepon' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => '(061) 7951234'
            ),
            'fax' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => '(061) 7955678'
            ),
            'email' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'pn.lubukpakam@yahoo.co.id'
            ),
            'website' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'www.pn-lubukpakam.go.id'
            ),
            'logo' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'assets/icons/logo.png'
            ),
            'ketua_nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'default'    => "Dr. H. Ahmad Syafi'i, S.H., M.H."
            ),
            'ketua_nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => '19680512 199303 1 001'
            ),
            'ketua_pangkat' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Pembina Utama Muda (IV/c)'
            ),
            'wakil_ketua_nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'default'    => 'Hj. Fitriani, S.H., M.H.'
            ),
            'wakil_ketua_nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => '19720820 199803 2 002'
            ),
            'wakil_ketua_pangkat' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Pembina Tingkat I (IV/b)'
            ),
            'panitera_nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'default'    => 'Bambang Wijaya, S.H., M.H.'
            ),
            'panitera_nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => '19750410 199903 1 001'
            ),
            'panitera_pangkat' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Pembina (IV/a)'
            ),
            'sekretaris_nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'default'    => 'H. Burhanuddin, S.H., M.H.'
            ),
            'sekretaris_nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => '19760915 200112 1 002'
            ),
            'sekretaris_pangkat' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Pembina (IV/a)'
            ),
            'kop_line1' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'PENGADILAN NEGERI LUBUK PAKAM KELAS I-A'
            ),
            'kop_line2' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'Jl. Sudirman No. 18, Lubuk Pakam, Telp: (061) 7951234, Website: www.pn-lubukpakam.go.id'
            ),
            'format_nomor_ba' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'W2.U4/[NO_URUT]/OT.01.2/[BULAN_ROMAWI]/[TAHUN]'
            ),
            'metode' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'TOPSIS'
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
        $this->dbforge->add_key('id_setting', TRUE); // Primary Key

        // Create table settings
        $this->dbforge->create_table('settings', TRUE);

        // 2. Insert Default Setting Row
        $default_setting = array(
            'nama_satker'        => 'Pengadilan Negeri Lubuk Pakam Kelas I-A',
            'singkatan'          => 'PN Lubuk Pakam',
            'kode_satker'        => '005021',
            'kode_wilayah'       => 'W2.U4',
            'kelas_pengadilan'   => 'Kelas I-A',
            'pengadilan_tinggi'  => 'Pengadilan Tinggi Medan',
            'alamat'             => 'Jl. Sudirman No. 18, Lubuk Pakam',
            'kota'               => 'Kabupaten Deli Serdang',
            'provinsi'           => 'Sumatera Utara',
            'kode_pos'           => '20511',
            'telepon'            => '(061) 7951234',
            'fax'                => '(061) 7955678',
            'email'              => 'pn.lubukpakam@yahoo.co.id',
            'website'            => 'www.pn-lubukpakam.go.id',
            'logo'               => 'assets/icons/logo.png',
            'ketua_nama'         => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
            'ketua_nip'          => '19680512 199303 1 001',
            'ketua_pangkat'      => 'Pembina Utama Muda (IV/c)',
            'wakil_ketua_nama'   => 'Hj. Fitriani, S.H., M.H.',
            'wakil_ketua_nip'    => '19720820 199803 2 002',
            'wakil_ketua_pangkat' => 'Pembina Tingkat I (IV/b)',
            'panitera_nama'      => 'Bambang Wijaya, S.H., M.H.',
            'panitera_nip'       => '19750410 199903 1 001',
            'panitera_pangkat'   => 'Pembina (IV/a)',
            'sekretaris_nama'    => 'H. Burhanuddin, S.H., M.H.',
            'sekretaris_nip'     => '19760915 200112 1 002',
            'sekretaris_pangkat' => 'Pembina (IV/a)',
            'kop_line1'          => 'PENGADILAN NEGERI LUBUK PAKAM KELAS I-A',
            'kop_line2'          => 'Jl. Sudirman No. 18, Lubuk Pakam, Telp: (061) 7951234, Website: www.pn-lubukpakam.go.id',
            'format_nomor_ba'    => 'W2.U4/[NO_URUT]/OT.01.2/[BULAN_ROMAWI]/[TAHUN]',
            'metode'             => 'TOPSIS',
            'created_at'         => date('Y-m-d H:i:s')
        );

        $this->db->insert('settings', $default_setting);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('settings', TRUE);
    }
}
