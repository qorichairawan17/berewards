# Export Laporan Berita Acara (.docx) — PHPWord

## Instalasi

CI3 tidak punya package manager bawaan yang jamak dipakai untuk ini,
jadi pasang via Composer di root project lalu include autoloader-nya
dari `index.php`:

```bash
composer require phpoffice/phpword
```

Di `index.php` (root CI3), tambahkan sebelum baris yang memuat
`system/core/CodeIgniter.php`:

```php
require_once FCPATH . 'vendor/autoload.php';
```

Kalau project tidak boleh pakai Composer (server shared hosting lama),
alternatifnya unduh rilis PHPWord manual dan taruh di
`application/third_party/PHPWord/`, lalu load manual sebelum dipakai.
Composer tetap cara yang disarankan kalau memungkinkan.

## Struktur Berita Acara

Susunan standar dokumen berita acara instansi pengadilan biasanya:

1. **Kop surat** — logo/nama pengadilan, alamat (statis, taruh di
   config atau tabel `pengaturan` kalau perlu diubah dari UI).
2. **Judul** — "BERITA ACARA PENETAPAN REWARD [KATEGORI] PERIODE [NAMA PERIODE]".
3. **Nomor & dasar** — nomor surat, dasar hukum/kebijakan (referensi ke
   SK atau pedoman internal — isi manual atau dari input admin).
4. **Narasi pembuka** — "Pada hari ini ... telah dilaksanakan penilaian
   kinerja untuk menentukan penerima reward periode ... dengan hasil
   sebagai berikut:"
5. **Tabel hasil** — kolom: Ranking, Nama, NIP, Jabatan, Nilai Preferensi
   (Ci). Urut sesuai `ranking`.
6. **Narasi penutup** — penetapan penerima reward (biasanya ranking 1,
   atau ranking 1–3, sesuai kebijakan instansi — buat ini dikonfigurasi,
   jangan di-hardcode "juara 1 saja").
7. **Tanda tangan** — Ketua Pengadilan / Panitera, dengan nama & NIP,
   biasanya dua kolom (kiri-kanan) untuk dua pihak penandatangan.

## Service — `Laporan_service.php`

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\Style\Font;

class Laporan_service
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Proses_model');
        $this->CI->load->model('Hasil_model');
    }

    /**
     * Bangun file .docx Berita Acara untuk satu id_proses dan langsung
     * kirim ke browser sebagai download. Panggil dari Controller Laporan.
     */
    public function export_berita_acara(int $idProses): void
    {
        $proses = $this->CI->Proses_model->get_detail($idProses); // join periode, dsb
        $hasil  = $this->CI->Hasil_model->get_by_proses($idProses); // sudah urut ranking ASC

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => 1000, 'marginBottom' => 1000,
            'marginLeft' => 1200, 'marginRight' => 1200,
        ]);

        // Kop surat sederhana — sesuaikan dengan identitas instansi.
        $section->addText('PENGADILAN ...', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addText('Jl. ... Telp. ...', ['size' => 9], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $section->addText(
            'BERITA ACARA PENETAPAN REWARD ' . strtoupper($proses['kategori']),
            ['bold' => true, 'size' => 12],
            ['alignment' => 'center']
        );
        $section->addText(
            'Periode: ' . $proses['nama_periode'],
            ['size' => 11],
            ['alignment' => 'center']
        );
        $section->addTextBreak(1);

        $section->addText(
            'Pada hari ini, ' . date('d F Y') . ', telah dilaksanakan penilaian kinerja ' .
            'menggunakan metode TOPSIS untuk menentukan penerima reward kategori ' .
            $proses['kategori'] . ' periode ' . $proses['nama_periode'] . ', dengan hasil sebagai berikut:'
        );
        $section->addTextBreak(1);

        // Tabel hasil
        $tableStyle = ['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80];
        $table = $section->addTable($tableStyle);

        $table->addRow(null, ['tblHeader' => true]);
        foreach (['Ranking', 'Nama', 'NIP', 'Jabatan', 'Nilai Preferensi'] as $head) {
            $table->addCell(2200)->addText($head, ['bold' => true]);
        }

        foreach ($hasil as $row) {
            $table->addRow();
            $table->addCell(2200)->addText((string) $row['ranking']);
            $table->addCell(2200)->addText($row['nama_snapshot']);
            $table->addCell(2200)->addText($row['nip_snapshot']);
            $table->addCell(2200)->addText($row['jabatan_snapshot']);
            $table->addCell(2200)->addText(number_format($row['nilai_preferensi'], 4, ',', '.'));
        }

        $section->addTextBreak(2);
        $section->addText('Demikian Berita Acara ini dibuat untuk digunakan sebagaimana mestinya.');
        $section->addTextBreak(2);

        // Tanda tangan dua kolom
        $sigTable = $section->addTable(['cellMargin' => 80]);
        $sigTable->addRow();
        $c1 = $sigTable->addCell(5000);
        $c1->addText('Mengetahui,');
        $c1->addText('Ketua Pengadilan', [], ['spaceBefore' => 1200]);
        $c1->addText('( ......................................... )', [], ['spaceBefore' => 1200]);

        $c2 = $sigTable->addCell(5000);
        $c2->addText(date('d F Y'));
        $c2->addText('Panitera', [], ['spaceBefore' => 1200]);
        $c2->addText('( ......................................... )', [], ['spaceBefore' => 1200]);

        // Kirim langsung sebagai download
        $filename = 'Berita_Acara_' . $proses['kategori'] . '_' . $proses['nama_periode'] . '.docx';
        $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');
        exit;
    }
}
```

**Controller** cukup satu baris pemanggilan:

```php
public function export($idProses)
{
    $this->load->service('Laporan_service');
    $this->laporan_service->export_berita_acara((int) $idProses);
}
```

## Tips penting

- **Jangan build ulang layout dokumen dari nol tiap kali diminta
  perubahan kecil** — kalau format berita acara instansi sudah baku
  (mis. ada logo tertentu, format nomor surat tertentu), pertimbangkan
  pakai fitur *template processing* PHPWord
  (`TemplateProcessor`) dengan file `.docx` template yang sudah berisi
  placeholder `${nama_periode}`, `${kategori}`, dsb — ini lebih mudah
  dirawat staf non-programmer dibanding mengubah kode PHP setiap kali
  format surat berubah. Simpan file template di
  `application/assets/templates/berita_acara_template.docx`.
- Nomor urut baris tabel hasil **harus** memakai `ranking` dari
  `hasil_topsis`, bukan urutan insert — pastikan query `ORDER BY ranking ASC`.
- Simpan salinan setiap dokumen yang sudah di-export (mis. ke folder
  `writable/laporan/` dengan nama unik) supaya bisa diunduh ulang tanpa
  generate ulang, dan supaya ada arsip resmi meski data di
  `hasil_topsis` suatu saat berubah struktur.
