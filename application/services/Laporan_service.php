<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Laporan_service — Berita Acara Word Export Service
 *
 * Mengelola pembuatan dokumen .docx Berita Acara Penetapan Reward
 * menggunakan PHPWord yang diletakkan di application/third_party/PHPWord/.
 *
 * Cara pakai dari Controller:
 *   $this->load->service('Laporan_service');
 *   $this->laporan_service->export_berita_acara($laporan_data);
 *
 * Atau langsung dari method static tanpa Service loader:
 *   Laporan_service::export($laporan_data);
 */
class Laporan_service
{
    /** Path ke direktori PHPWord third_party */
    const PHPWORD_PATH = APPPATH . 'third_party/PHPWord/';

    /** Instansi CodeIgniter */
    private $CI;

    // -----------------------------------------------------------------------
    // Constructor
    // -----------------------------------------------------------------------

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->_load_phpword();
    }

    // -----------------------------------------------------------------------
    // PHPWord Bootstrapper
    // -----------------------------------------------------------------------

    /**
     * Load PHPWord dari application/third_party/PHPWord/ tanpa Composer.
     * Mendaftarkan PSR-0 autoloader khusus untuk namespace PhpOffice\PhpWord.
     */
    private function _load_phpword()
    {
        // Hindari double-load
        if (class_exists('PhpOffice\\PhpWord\\PhpWord', false)) {
            return;
        }

        $phpword_src = self::PHPWORD_PATH . 'src/';

        if (!is_dir($phpword_src)) {
            show_error(
                'PHPWord tidak ditemukan di <code>application/third_party/PHPWord/src/</code>. ' .
                'Pastikan PHPWord sudah disalin ke direktori tersebut.',
                500,
                'PHPWord Missing'
            );
        }

        // Daftarkan PSR-0 autoloader untuk PhpOffice\PhpWord
        spl_autoload_register(function ($class) use ($phpword_src) {
            // Hanya tangani namespace PhpOffice\PhpWord
            if (strpos($class, 'PhpOffice\\PhpWord') !== 0) {
                return;
            }
            $relative = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $file     = $phpword_src . $relative . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        });

        // Load Settings agar konstanta internal PHPWord tersedia
        require_once $phpword_src . 'PhpWord/Settings.php';
    }

    // -----------------------------------------------------------------------
    // Public — Export Berita Acara
    // -----------------------------------------------------------------------

    /**
     * Bangun dan kirim file .docx Berita Acara ke browser sebagai download.
     *
     * @param array $laporan  Data satu baris laporan, harus memiliki key:
     *                        no_ba, nama_periode, kategori, tanggal_terbit,
     *                        ketua_panitia, top_3 (array kandidat).
     * @return void           Langsung output ke browser; tidak return nilai.
     */
    public function export_berita_acara(array $laporan)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // --- Pengaturan dokumen global ---
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);

        // --- Section dengan margin kertas A4 (twip: 1 cm = 567 twip) ---
        $section = $phpWord->addSection([
            'paperSize'    => 'A4',
            'marginTop'    => 1134,   // ±2 cm
            'marginBottom' => 1134,
            'marginLeft'   => 1701,   // ±3 cm (sisi kiri lebih lebar utk jilid)
            'marginRight'  => 1134,
        ]);

        // ===================================================================
        // 1. KOP SURAT
        // ===================================================================
        $styleKopInstansi = [
            'bold'      => true,
            'size'      => 14,
            'allCaps'   => true,
        ];
        $styleKopAlamat = [
            'size' => 10,
        ];
        $styleCenter = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER];

        $section->addText(
            'PENGADILAN NEGERI LUBUK PAKAM',
            $styleKopInstansi,
            $styleCenter
        );
        $section->addText(
            'KELAS I-A',
            ['bold' => true, 'size' => 12],
            $styleCenter
        );
        $section->addText(
            'Jl. Kemerdekaan No. 173, Lubuk Pakam, Deli Serdang, Sumatera Utara 20517',
            $styleKopAlamat,
            $styleCenter
        );
        $section->addText(
            'Telp. (061) 7952181 | Fax. (061) 7952182 | Email: pn.lubukpakam@gmail.com',
            $styleKopAlamat,
            $styleCenter
        );

        // Garis pembatas kop
        $section->addLine([
            'width'     => 8000,
            'height'    => 0,
            'color'     => '000000',
        ]);
        $section->addTextBreak(1);

        // ===================================================================
        // 2. JUDUL BERITA ACARA
        // ===================================================================
        $styleJudul = ['bold' => true, 'size' => 12, 'allCaps' => true];

        $section->addText(
            'BERITA ACARA PENETAPAN REWARD ' . strtoupper($laporan['kategori']),
            $styleJudul,
            $styleCenter
        );
        $section->addText(
            'PERIODE ' . strtoupper($laporan['nama_periode']),
            $styleJudul,
            $styleCenter
        );
        $section->addText(
            'Nomor: ' . $laporan['no_ba'],
            ['size' => 11],
            $styleCenter
        );
        $section->addTextBreak(1);

        // ===================================================================
        // 3. DASAR
        // ===================================================================
        $styleNormal  = ['size' => 12];
        $styleJustify = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH];

        $section->addText('Dasar:', ['bold' => true, 'size' => 12], $styleJustify);

        $dasar = [
            '1. Peraturan Mahkamah Agung Republik Indonesia tentang manajemen kinerja pegawai;',
            '2. Surat Keputusan Ketua Pengadilan Negeri Lubuk Pakam tentang pemberian reward pegawai berprestasi;',
            '3. Hasil perhitungan metode TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution) periode ' . $laporan['nama_periode'] . '.',
        ];

        foreach ($dasar as $d) {
            $section->addListItem($d, 0, $styleNormal, 'listBullet', $styleJustify);
        }

        $section->addTextBreak(1);

        // ===================================================================
        // 4. NARASI PEMBUKA
        // ===================================================================
        $tanggalFormatted = $this->_format_tanggal($laporan['tanggal_terbit']);
        $hariIni          = $this->_format_tanggal(date('Y-m-d'));

        $section->addText(
            'Pada hari ini, ' . $hariIni . ', telah dilaksanakan penilaian kinerja ' .
            'menggunakan metode TOPSIS untuk menentukan penerima reward kategori ' .
            $laporan['kategori'] . ' pada periode ' . $laporan['nama_periode'] .
            ', dengan hasil penilaian sebagaimana tercantum dalam tabel berikut:',
            $styleNormal,
            $styleJustify
        );
        $section->addTextBreak(1);

        // ===================================================================
        // 5. TABEL HASIL (TOP 3 KANDIDAT)
        // ===================================================================
        $top3 = isset($laporan['top_3']) ? $laporan['top_3'] : [];

        $tableStyle = [
            'borderSize'    => 6,
            'borderColor'   => '333333',
            'cellMargin'    => 80,
            'alignment'     => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
        ];

        $table = $section->addTable($tableStyle);

        // Header baris
        $headerFontStyle = ['bold' => true, 'size' => 11];
        $headerParaStyle = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER];
        $cellHeaderStyle = ['bgColor' => 'D6E4F7'];

        $headers = [
            ['text' => 'No.',           'width' => 600],
            ['text' => 'Nama Pegawai',  'width' => 3200],
            ['text' => 'NIP',           'width' => 2400],
            ['text' => 'Jabatan',       'width' => 1800],
            ['text' => 'Nilai (Ci)',    'width' => 1200],
            ['text' => 'Keterangan',    'width' => 1800],
        ];

        $table->addRow(null, ['tblHeader' => true]);
        foreach ($headers as $h) {
            $cell = $table->addCell($h['width'], $cellHeaderStyle);
            $cell->addText($h['text'], $headerFontStyle, $headerParaStyle);
        }

        // Baris data
        $styleDataCenter = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER];

        foreach ($top3 as $i => $kandidat) {
            $rank = isset($kandidat['rank']) ? (int) $kandidat['rank'] : ($i + 1);
            $ket  = $this->_keterangan_rank($rank);

            $table->addRow();
            $table->addCell(600)->addText((string) $rank, $styleNormal, $styleDataCenter);
            $table->addCell(3200)->addText(isset($kandidat['nama']) ? $kandidat['nama'] : '-', $styleNormal);
            $table->addCell(2400)->addText(isset($kandidat['nip'])  ? $kandidat['nip']  : '-', ['size' => 10]);
            $table->addCell(1800)->addText(isset($kandidat['kategori']) ? $kandidat['kategori'] : $laporan['kategori'], $styleNormal);
            $table->addCell(1200)->addText(number_format((float)(isset($kandidat['skor']) ? $kandidat['skor'] : 0), 4, ',', '.'), $styleNormal, $styleDataCenter);
            $table->addCell(1800)->addText($ket, $styleNormal, $styleDataCenter);
        }

        $section->addTextBreak(2);

        // ===================================================================
        // 6. NARASI PENUTUP
        // ===================================================================
        $pemenang = !empty($top3[0]['nama']) ? $top3[0]['nama'] : '-';

        $section->addText(
            'Berdasarkan hasil perhitungan metode TOPSIS di atas, ditetapkan bahwa:',
            $styleNormal,
            $styleJustify
        );
        $section->addTextBreak(1);

        $section->addText(
            'Nama   : ' . $pemenang,
            ['bold' => true, 'size' => 12]
        );
        $section->addText(
            'NIP    : ' . (!empty($top3[0]['nip']) ? $top3[0]['nip'] : '-'),
            ['bold' => true, 'size' => 12]
        );
        $section->addText(
            'Nilai (Ci) : ' . number_format((float)(isset($top3[0]['skor']) ? $top3[0]['skor'] : 0), 4, ',', '.'),
            ['bold' => true, 'size' => 12]
        );
        $section->addTextBreak(1);

        $section->addText(
            'sebagai PENERIMA REWARD TERBAIK kategori ' . strtoupper($laporan['kategori']) .
            ' periode ' . $laporan['nama_periode'] . '.',
            ['bold' => true, 'size' => 12],
            $styleJustify
        );
        $section->addTextBreak(1);

        $section->addText(
            'Demikian Berita Acara ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.',
            $styleNormal,
            $styleJustify
        );
        $section->addTextBreak(2);

        // ===================================================================
        // 7. TANDA TANGAN (dua kolom)
        // ===================================================================
        $sigTable = $section->addTable(['cellMargin' => 80]);
        $sigTable->addRow();

        // Kolom kiri — Ketua Pengadilan
        $cLeft = $sigTable->addCell(5000);
        $cLeft->addText('Mengetahui,', $styleNormal, $styleCenter);
        $cLeft->addText('Ketua Pengadilan Negeri Lubuk Pakam', $styleNormal, $styleCenter);
        $cLeft->addTextBreak(3);
        $cLeft->addText('( ................................................ )', $styleNormal, $styleCenter);
        $cLeft->addText('NIP. ......................................................', ['size' => 11], $styleCenter);

        // Kolom kanan — Ketua Panitia / Panitera
        $cRight = $sigTable->addCell(5000);
        $cRight->addText('Lubuk Pakam, ' . $tanggalFormatted, $styleNormal, $styleCenter);
        $cRight->addText(
            isset($laporan['ketua_panitia']) && $laporan['ketua_panitia']
                ? $laporan['ketua_panitia']
                : 'Ketua Panitia',
            ['bold' => true, 'size' => 12],
            $styleCenter
        );
        $cRight->addTextBreak(3);
        $cRight->addText('( ................................................ )', $styleNormal, $styleCenter);
        $cRight->addText('NIP. ......................................................', ['size' => 11], $styleCenter);

        // ===================================================================
        // 8. OUTPUT KE BROWSER
        // ===================================================================
        $noba_clean  = preg_replace('/[^A-Za-z0-9\-_]/', '_', isset($laporan['no_ba']) ? $laporan['no_ba'] : 'BA');
        $periode_clean = preg_replace('/[^A-Za-z0-9\-_]/', '_', isset($laporan['nama_periode']) ? $laporan['nama_periode'] : '');
        $filename    = 'BeritaAcara_' . $laporan['kategori'] . '_' . $periode_clean . '_' . $noba_clean . '.docx';

        // Bersihkan buffer output agar tidak ada karakter sebelum header
        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');
        exit;
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    /**
     * Format tanggal Y-m-d menjadi "dd Bulan YYYY" dalam Bahasa Indonesia.
     */
    private function _format_tanggal($date_str)
    {
        $bulan = [
            1  => 'Januari',   2  => 'Februari', 3  => 'Maret',
            4  => 'April',     5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',   11 => 'November',  12 => 'Desember',
        ];
        $ts = strtotime($date_str);
        if (!$ts) {
            return $date_str;
        }
        return date('d', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
    }

    /**
     * Keterangan berdasarkan ranking TOPSIS.
     */
    private function _keterangan_rank($rank)
    {
        switch ((int) $rank) {
            case 1:  return 'Penerima Reward';
            case 2:  return 'Runner Up I';
            case 3:  return 'Runner Up II';
            default: return 'Kandidat';
        }
    }
}
