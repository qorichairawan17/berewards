<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Export_word_service
 * 
 * Service Layer khusus untuk mengonstruksi, mendesain, dan mengekspor dokumen
 * Berita Acara Penetapan Reward TOPSIS dalam format Microsoft Word (.docx)
 * menggunakan pustaka PHPWord di application/third_party/PHPWord/.
 * 
 * Mengikuti spesifikasi OpenXML Word 2007+ yang 100% valid dan kompatibel
 * dengan seluruh versi Microsoft Word dan LibreOffice.
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Export_word_service
{
    const PHPWORD_PATH = APPPATH . 'third_party/PHPWord/';

    /**
     * CodeIgniter Super Object
     * @var CI_Controller
     */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->_load_phpword();
    }

    /**
     * PSR-4 Autoloader untuk memuat kelas-kelas PHPWord tanpa ketergantungan composer luar.
     */
    private function _load_phpword()
    {
        if (class_exists('PhpOffice\\PhpWord\\PhpWord', false)) {
            return;
        }

        $phpword_src = self::PHPWORD_PATH . 'src/';
        if (!is_dir($phpword_src)) {
            show_error('Direktori PHPWord tidak ditemukan di application/third_party/PHPWord/src/', 500, 'PHPWord Missing');
        }

        $prefix   = 'PhpOffice\\PhpWord\\';
        $base_dir = $phpword_src . 'PhpWord' . DIRECTORY_SEPARATOR;
        $len      = strlen($prefix);

        spl_autoload_register(function ($class) use ($prefix, $base_dir, $len) {
            if (strncmp($prefix, $class, $len) !== 0) {
                return;
            }
            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        });

        if (file_exists($base_dir . 'Settings.php')) {
            require_once $base_dir . 'Settings.php';
        }
    }

    /**
     * Menghasilkan dan mengirimkan file Berita Acara (.docx) ke browser sebagai unduhan.
     * 
     * @param array $laporan Data lengkap Berita Acara beserta relasinya
     * @param array $satker  Data profil satker & kop surat
     * @param array $pimpinan Data susunan pimpinan pengadilan
     * @param array $tim_penilai Data detail SK dan anggota tim penilai
     * @return void Langsung stream file dan exit
     */
    public function export_berita_acara(array $laporan, array $satker = array(), array $pimpinan = array(), array $tim_penilai = array())
    {
        // 1. Matikan error output agar tidak merusak binary ZIP/DOCX
        @error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
        @ini_set('display_errors', '0');

        // 2. Aktifkan XML Output Escaping agar karakter &, <, > aman dalam XML OpenXML
        if (class_exists('PhpOffice\\PhpWord\\Settings')) {
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // 3. Pengaturan Default Dokumen
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(11);

        // Margin A4: Top 2cm, Bottom 2cm, Left 3cm, Right 2cm (1 cm = 567 twips)
        $section = $phpWord->addSection(array(
            'paperSize'    => 'A4',
            'marginTop'    => 1134,
            'marginBottom' => 1134,
            'marginLeft'   => 1701,
            'marginRight'  => 1134
        ));

        // 4. Styling Rules
        $styleCenter  = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $styleJustify = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
        $styleRight   = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);

        $fontKopInstansi = array('bold' => true, 'size' => 13, 'allCaps' => true);
        $fontKopSub      = array('bold' => true, 'size' => 11, 'allCaps' => true);
        $fontKopAlamat   = array('size' => 9, 'italic' => false);

        // =========================================================================
        // KOP SURAT RESMI
        // =========================================================================
        $kop1    = !empty($satker['kop_line1']) ? $satker['kop_line1'] : 'PENGADILAN NEGERI LUBUK PAKAM KELAS I-A';
        $alamat  = !empty($satker['alamat']) ? $satker['alamat'] : 'Jl. Sisingamangaraja No. 182, Lubuk Pakam, Deli Serdang';
        $telp    = !empty($satker['telepon']) ? $satker['telepon'] : '(061) 7951234';
        $email   = !empty($satker['email']) ? $satker['email'] : 'pn.lubukpakam@mahkamahagung.go.id';
        $website = !empty($satker['website']) ? $satker['website'] : 'https://pn-lubukpakam.go.id';
        $pt      = !empty($satker['pengadilan_tinggi']) ? $satker['pengadilan_tinggi'] : 'PENGADILAN TINGGI MEDAN';

        // Header Table Kop (Logo Kiri & Teks Kanan jika logo ada)
        $logoPath = !empty($satker['logo']) ? FCPATH . $satker['logo'] : FCPATH . 'assets/images/logo-pn.png';
        if (file_exists($logoPath)) {
            $kopTable = $section->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellMargin' => 40));
            $kopTable->addRow();
            
            // Kolom Logo
            $cellLogo = $kopTable->addCell(1400, array('valign' => 'center'));
            $cellLogo->addImage($logoPath, array('width' => 60, 'height' => 75, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

            // Kolom Teks
            $cellText = $kopTable->addCell(7600, array('valign' => 'center'));
            $cellText->addText(strtoupper($pt), $fontKopSub, $styleCenter);
            $cellText->addText(strtoupper($kop1), $fontKopInstansi, $styleCenter);
            $cellText->addText($alamat, $fontKopAlamat, $styleCenter);
            $cellText->addText('Telepon: ' . $telp . ' | Email: ' . $email . ' | Website: ' . $website, $fontKopAlamat, $styleCenter);
        } else {
            $section->addText(strtoupper($pt), $fontKopSub, $styleCenter);
            $section->addText(strtoupper($kop1), $fontKopInstansi, $styleCenter);
            $section->addText($alamat, $fontKopAlamat, $styleCenter);
            $section->addText('Telepon: ' . $telp . ' | Email: ' . $email . ' | Website: ' . $website, $fontKopAlamat, $styleCenter);
        }

        // Garis Pembatas Kop Resmi (Kompatibel OpenXML penuh)
        $kopBorder = $section->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $kopBorder->addRow(30);
        $kopBorder->addCell(9000, array(
            'borderBottomSize'  => 18,
            'borderBottomColor' => '000000',
            'borderTopSize'     => 0,
            'borderLeftSize'    => 0,
            'borderRightSize'   => 0
        ))->addText('', array('size' => 1));

        $section->addTextBreak(1);

        // =========================================================================
        // JUDUL & NOMOR BERITA ACARA
        // =========================================================================
        $kategoriUpper = strtoupper(!empty($laporan['kategori']) ? $laporan['kategori'] : 'PEGAWAI');
        $periodeUpper  = strtoupper(!empty($laporan['nama_periode']) ? $laporan['nama_periode'] : 'PERIODE PENILAIAN');
        $noBa          = !empty($laporan['no_ba']) ? $laporan['no_ba'] : 'W2.U4/01/BA.SPK/VIII/2026';

        $section->addText(
            'BERITA ACARA PENETAPAN REWARD ' . $kategoriUpper . ' TERBAIK',
            array('bold' => true, 'size' => 12, 'underline' => 'single'),
            $styleCenter
        );
        $section->addText(
            'PERIODE ' . $periodeUpper,
            array('bold' => true, 'size' => 11),
            $styleCenter
        );
        $section->addText(
            'Nomor: ' . $noBa,
            array('size' => 11),
            $styleCenter
        );
        $section->addTextBreak(1);

        // =========================================================================
        // DASAR HUKUM
        // =========================================================================
        $section->addText('Dasar Pelaksanaan:', array('bold' => true, 'size' => 11), $styleJustify);
        
        $skInfo = !empty($laporan['no_sk']) ? $laporan['no_sk'] : 'Surat Keputusan Ketua Pengadilan Negeri Lubuk Pakam tentang Tim Penilai Reward';
        $dasarPoints = array(
            '1. Keputusan Ketua Mahkamah Agung RI tentang Pedoman Pemberian Reward dan Punishment bagi Aparatur Peradilan;',
            '2. ' . $skInfo . ' tentang Pembentukan Tim Penilai Kinerja dan Pemberian Reward;',
            '3. Hasil pengolahan dan perankingan Sistem Pendukung Keputusan (SPK) menggunakan Metode TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution) Periode ' . (!empty($laporan['nama_periode']) ? $laporan['nama_periode'] : '') . '.'
        );

        foreach ($dasarPoints as $point) {
            $section->addText($point, array('size' => 10.5), $styleJustify);
        }
        $section->addTextBreak(1);

        // =========================================================================
        // NARASI PEMBUKA RAPAT PLENO
        // =========================================================================
        $tanggalTerbit = !empty($laporan['tanggal_terbit']) ? $laporan['tanggal_terbit'] : date('Y-m-d');
        $hariIndonesia  = $this->_get_nama_hari($tanggalTerbit);
        $tglFormatIndo  = $this->_format_tanggal_indo($tanggalTerbit);

        $narasi = "Pada hari ini, " . $hariIndonesia . " tanggal " . $tglFormatIndo . ", bertempat di Kantor " . (!empty($satker['nama_satker']) ? $satker['nama_satker'] : 'Pengadilan Negeri Lubuk Pakam') . ", Tim Penilai Kinerja telah melaksanakan rapat pleno penetapan reward aparatur berprestasi kategori " . (!empty($laporan['kategori']) ? $laporan['kategori'] : 'Pegawai') . " untuk periode " . (!empty($laporan['nama_periode']) ? $laporan['nama_periode'] : '') . ".";
        $section->addText($narasi, array('size' => 11), $styleJustify);

        $narasi2 = "Berdasarkan hasil kalkulasi matriks keputusan, solusi ideal positif dan negatif, serta perhitungan kedekatan relatif preferensi dengan metode TOPSIS, maka ditetapkan daftar perolehan nilai dan peringkat kinerja aparatur sebagai berikut:";
        $section->addText($narasi2, array('size' => 11), $styleJustify);
        $section->addTextBreak(1);

        // =========================================================================
        // TABEL HASIL TOPSIS & RANKING
        // =========================================================================
        $candidates = !empty($laporan['all_candidates']) ? $laporan['all_candidates'] : (!empty($laporan['top_3']) ? $laporan['top_3'] : array());

        $tableStyle = array(
            'borderSize'    => 6,
            'borderColor'   => '000000',
            'cellMargin'    => 80,
            'alignment'     => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
        );
        $table = $section->addTable($tableStyle);

        // Header Tabel
        $headerStyle = array('bold' => true, 'size' => 10);
        $headerCellBg = array('bgColor' => 'EAEAEA', 'valign' => 'center');

        $table->addRow(400, array('tblHeader' => true));
        $table->addCell(600, $headerCellBg)->addText('No.', $headerStyle, $styleCenter);
        $table->addCell(3000, $headerCellBg)->addText('Nama Pegawai & NIP', $headerStyle, $styleCenter);
        $table->addCell(2200, $headerCellBg)->addText('Jabatan / Pangkat', $headerStyle, $styleCenter);
        $table->addCell(1600, $headerCellBg)->addText('Nilai Preferensi', $headerStyle, $styleCenter);
        $table->addCell(1800, $headerCellBg)->addText('Keterangan', $headerStyle, $styleCenter);

        // Baris Data Kandidat
        if (!empty($candidates)) {
            $no = 1;
            foreach ($candidates as $c) {
                $rank = isset($c['rank']) ? (int)$c['rank'] : $no;
                $skor = isset($c['skor']) ? number_format((float)$c['skor'], 4) : '0.0000';
                
                $keterangan = 'Kandidat';
                $isWinner = false;
                if ($rank === 1) {
                    $keterangan = 'Penerima Reward';
                    $isWinner = true;
                } elseif ($rank === 2) {
                    $keterangan = 'Runner Up 1';
                } elseif ($rank === 3) {
                    $keterangan = 'Runner Up 2';
                }

                $rowBg = $isWinner ? array('bgColor' => 'F2F7FF', 'valign' => 'center') : array('valign' => 'center');
                $boldIfWinner = array('bold' => $isWinner, 'size' => 10);

                $table->addRow();
                $table->addCell(600, $rowBg)->addText($rank . '.', $boldIfWinner, $styleCenter);
                
                $cellNama = $table->addCell(3000, $rowBg);
                $cellNama->addText($c['nama'], array('bold' => true, 'size' => 10));
                $cellNama->addText('NIP. ' . (!empty($c['nip']) ? $c['nip'] : '-'), array('size' => 8.5, 'color' => '555555'));

                $cellJabatan = $table->addCell(2200, $rowBg);
                $cellJabatan->addText(!empty($c['jabatan']) ? $c['jabatan'] : '-', array('size' => 9.5));
                if (!empty($c['pangkat']) || !empty($c['golongan'])) {
                    $cellJabatan->addText(trim($c['pangkat'] . ' ' . $c['golongan']), array('size' => 8.5, 'color' => '555555'));
                }

                $table->addCell(1600, $rowBg)->addText($skor, array('bold' => $isWinner, 'size' => 10), $styleCenter);
                $table->addCell(1800, $rowBg)->addText($keterangan, $boldIfWinner, $styleCenter);

                $no++;
            }
        } else {
            $table->addRow();
            $table->addCell(9200, array('gridSpan' => 5, 'valign' => 'center'))
                  ->addText('Tidak ada data alternatif yang dinilai pada sesi ini.', array('italic' => true, 'size' => 10), $styleCenter);
        }

        $section->addTextBreak(1);

        // =========================================================================
        // KESIMPULAN RAPAT PLENO
        // =========================================================================
        $pemenangNama = !empty($laporan['pemenang_nama']) ? $laporan['pemenang_nama'] : (!empty($candidates[0]['nama']) ? $candidates[0]['nama'] : '-');
        $pemenangNip  = !empty($laporan['pemenang_nip']) ? $laporan['pemenang_nip'] : (!empty($candidates[0]['nip']) ? $candidates[0]['nip'] : '-');
        $pemenangSkor = !empty($laporan['skor_topsis']) ? number_format((float)$laporan['skor_topsis'], 4) : (!empty($candidates[0]['skor']) ? number_format((float)$candidates[0]['skor'], 4) : '0.0000');

        $kesimpulan = "Berdasarkan hasil perolehan nilai di atas, Tim Penilai Kinerja secara mufakat menetapkan Saudara/i " . $pemenangNama . " (NIP. " . $pemenangNip . ") dengan perolehan skor akhir " . $pemenangSkor . " sebagai PENERIMA REWARD KINERJA KATEGORI " . $kategoriUpper . " PERIODE " . $periodeUpper . ".";
        $section->addText($kesimpulan, array('bold' => true, 'size' => 11), $styleJustify);

        $penutup = "Demikian Berita Acara ini dibuat dengan sebenarnya dalam rangkap secukupnya untuk dapat dipergunakan sebagaimana mestinya.";
        $section->addText($penutup, array('size' => 11), $styleJustify);
        $section->addTextBreak(1);

        // =========================================================================
        // BLOK TANDA TANGAN RESMI
        // =========================================================================
        $kotaSatker   = !empty($satker['kota']) ? $satker['kota'] : 'Lubuk Pakam';
        $namaKetuaPn  = !empty($satker['nama_ketua']) ? $satker['nama_ketua'] : (!empty($pimpinan['ketua']['nama']) ? $pimpinan['ketua']['nama'] : "Dr. H. Ahmad Syafi'i, S.H., M.H.");
        $nipKetuaPn   = !empty($satker['nip_ketua']) ? $satker['nip_ketua'] : (!empty($pimpinan['ketua']['nip']) ? $pimpinan['ketua']['nip'] : '19680512 199303 1 001');

        $namaKetuaTim = !empty($laporan['ketua_panitia']) ? $laporan['ketua_panitia'] : (!empty($tim_penilai['ketua']['nama']) ? $tim_penilai['ketua']['nama'] : "Bambang Wijaya, S.H., M.H.");
        $nipKetuaTim  = !empty($tim_penilai['ketua']['nip']) ? $tim_penilai['ketua']['nip'] : '19750310 199903 1 003';

        $signTable = $section->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellMargin' => 40));
        $signTable->addRow();

        // Kolom Kiri: Mengetahui Ketua Pengadilan Negeri
        $cellLeft = $signTable->addCell(4600, array('valign' => 'top'));
        $cellLeft->addText('Mengetahui,', array('size' => 10.5), $styleCenter);
        $cellLeft->addText('Ketua Pengadilan Negeri ' . (!empty($satker['singkatan']) ? $satker['singkatan'] : 'Lubuk Pakam'), array('bold' => true, 'size' => 10.5), $styleCenter);
        $cellLeft->addTextBreak(3); // Ruang tanda tangan & cap
        $cellLeft->addText($namaKetuaPn, array('bold' => true, 'size' => 10.5, 'underline' => 'single'), $styleCenter);
        $cellLeft->addText('NIP. ' . $nipKetuaPn, array('size' => 9.5), $styleCenter);

        // Kolom Kanan: Ketua Tim Penilai
        $cellRight = $signTable->addCell(4600, array('valign' => 'top'));
        $cellRight->addText($kotaSatker . ', ' . $tglFormatIndo, array('size' => 10.5), $styleCenter);
        $cellRight->addText('Ketua Tim Penilai Reward,', array('bold' => true, 'size' => 10.5), $styleCenter);
        $cellRight->addTextBreak(3); // Ruang tanda tangan
        $cellRight->addText($namaKetuaTim, array('bold' => true, 'size' => 10.5, 'underline' => 'single'), $styleCenter);
        $cellRight->addText('NIP. ' . $nipKetuaTim, array('size' => 9.5), $styleCenter);

        // 5. Bersihkan output buffer sebelum streaming binary file ke browser
        while (ob_get_level()) {
            ob_end_clean();
        }

        // 6. Set HTTP Headers untuk download binary file docx
        $safeFileName = 'Berita_Acara_Reward_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $kategoriUpper . '_' . $periodeUpper) . '.docx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $safeFileName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: max-age=0, no-cache, no-store, must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * Helper nama hari dalam bahasa Indonesia.
     * 
     * @param string $date Y-m-d
     * @return string
     */
    protected function _get_nama_hari($date)
    {
        $hariArr = array(
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu'
        );
        $dayName = date('l', strtotime($date));
        return isset($hariArr[$dayName]) ? $hariArr[$dayName] : 'Senin';
    }

    /**
     * Helper format tanggal Indonesia lengkap (misal: 24 Agustus 2026).
     * 
     * @param string $date Y-m-d
     * @return string
     */
    protected function _format_tanggal_indo($date)
    {
        if (empty($date)) return date('d F Y');
        $bulanArr = array(
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );

        $time  = strtotime($date);
        $d     = date('j', $time);
        $m     = (int)date('n', $time);
        $y     = date('Y', $time);

        return $d . ' ' . (isset($bulanArr[$m]) ? $bulanArr[$m] : date('F', $time)) . ' ' . $y;
    }
}
