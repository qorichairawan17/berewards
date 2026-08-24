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
            'singkatan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'kode_satker' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE
            ),
            'kode_wilayah' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE
            ),
            'tingkat_pengadilan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'kelas_pengadilan' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE
            ),
            'pengadilan_tinggi' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'alamat' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'kota' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'provinsi' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'kode_pos' => array(
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => TRUE
            ),
            'telepon' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE
            ),
            'fax' => array(
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
            'pangkat_ketua' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'nama_wakil_ketua' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'nip_wakil_ketua' => array(
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => TRUE
            ),
            'pangkat_wakil_ketua' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
            'pangkat_panitera' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
            'pangkat_sekretaris' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'logo' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
            ),
            'kop_line1' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
            ),
            'kop_line2' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE
            ),
            'format_nomor_sk' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE
            ),
            'format_nomor_ba' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => TRUE
            ),
            'metode' => array(
                'type'       => 'VARCHAR',
                'constraint' => '150',
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
            'id_setting'          => 1,
            'nama_satker'         => 'Pengadilan Negeri Lubuk Pakam Kelas I-A',
            'singkatan'           => 'PN Lubuk Pakam',
            'kode_satker'         => '005021',
            'kode_wilayah'        => 'W2.U4',
            'tingkat_pengadilan'  => 'Pengadilan Negeri Kelas I-A',
            'kelas_pengadilan'    => 'Kelas I-A',
            'pengadilan_tinggi'   => 'Pengadilan Tinggi Medan',
            'alamat'              => 'Jl. Sisingamangaraja No. 182, Lubuk Pakam, Kabupaten Deli Serdang, Sumatera Utara 20511',
            'kota'                => 'Lubuk Pakam',
            'provinsi'            => 'Sumatera Utara',
            'kode_pos'            => '20511',
            'telepon'             => '(061) 7951234',
            'fax'                 => '(061) 7952182',
            'email'               => 'pn.lubukpakam@mahkamahagung.go.id',
            'website'             => 'https://pn-lubukpakam.go.id',
            'nama_ketua'          => "Dr. H. Ahmad Syafi'i, S.H., M.H.",
            'nip_ketua'           => '19680512 199303 1 001',
            'pangkat_ketua'       => 'Pembina Utama Muda (IV/c)',
            'nama_wakil_ketua'    => 'Hj. Fitriani, S.H., M.H.',
            'nip_wakil_ketua'     => '19720820 199703 2 002',
            'pangkat_wakil_ketua' => 'Pembina Tk. I (IV/b)',
            'nama_panitera'       => 'Bambang Wijaya, S.H., M.H.',
            'nip_panitera'        => '19750310 199903 1 003',
            'pangkat_panitera'    => 'Pembina (IV/a)',
            'nama_sekretaris'     => 'Drs. Muhammad Rizky',
            'nip_sekretaris'      => '19781115 200212 1 004',
            'pangkat_sekretaris'  => 'Pembina (IV/a)',
            'logo'                => 'assets/images/logo-pn.png',
            'kop_line1'           => 'PENGADILAN NEGERI LUBUK PAKAM KELAS I-A',
            'kop_line2'           => 'JL. SISINGAMANGARAJA NO. 182, LUBUK PAKAM, DELI SERDANG 20511',
            'format_nomor_sk'     => 'W2.U4/{NO}/SK.TIM-SPK/{BLN}/{THN}',
            'format_nomor_ba'     => '[KODE_WILAYAH]/[NO_URUT]/BA.SPK/[BULAN_ROMAWI]/[TAHUN]',
            'metode'              => 'TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)',
            'created_at'          => date('Y-m-d H:i:s')
        );

        $this->db->insert('pengaturan', $sample_setting);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('pengaturan', TRUE);
    }
}
