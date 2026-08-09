<?php

/**
 * Topsis_service
 *
 * Mesin perhitungan TOPSIS murni — tidak menyentuh database, tidak
 * bergantung ke CodeIgniter sama sekali (sengaja TANPA guard BASEPATH),
 * supaya bisa di-unit-test langsung lewat PHPUnit tanpa bootstrap CI3
 * dan dipakai ulang dari service lain. Tugas memuat data dari
 * `topsis_proses_kriteria`, `topsis_proses_alternatif`, dan `penilaian`,
 * lalu menyimpan ke `hasil_topsis`, dilakukan di controller/service lain
 * (lihat contoh alur di references/architecture.md). Saat file ini
 * di-require dari MY_Loader di dalam CI3, itu tetap aman — kelasnya
 * hanya berisi logika matematis murni, tidak ada akses filesystem/URL
 * langsung yang perlu diblokir.
 *
 * Cara pakai (lihat juga references/topsis-algorithm.md untuk rumusnya):
 *
 *   $kriteria = [
 *       ['id' => 1, 'bobot' => 3, 'tipe_atribut' => 'benefit'],
 *       ['id' => 2, 'bobot' => 2, 'tipe_atribut' => 'benefit'],
 *   ];
 *   $matriks = [
 *       // id_proses_alternatif => [id_kriteria => nilai]
 *       10 => [1 => 80, 2 => 4],
 *       11 => [1 => 60, 2 => 3],
 *       12 => [1 => 90, 2 => 2],
 *   ];
 *   $engine = new Topsis_service();
 *   $hasil = $engine->hitung($matriks, $kriteria);
 *   // $hasil = [ id_proses_alternatif => ['d_positif'=>.., 'd_negatif'=>.., 'nilai_preferensi'=>.., 'ranking'=>..], ... ]
 */
class Topsis_service
{
    /**
     * Jalankan seluruh alur TOPSIS.
     *
     * @param array $matriks   [id_alternatif => [id_kriteria => nilai_mentah, ...], ...]
     * @param array $kriteria  daftar kriteria, tiap elemen wajib punya
     *                         'id', 'bobot' (angka mentah), 'tipe_atribut' ('benefit'|'cost')
     * @return array           [id_alternatif => ['d_positif','d_negatif','nilai_preferensi','ranking'], ...]
     * @throws InvalidArgumentException jika data tidak lengkap/tidak konsisten
     */
    public function hitung(array $matriks, array $kriteria): array
    {
        $this->validasi($matriks, $kriteria);

        $idKriteria   = array_column($kriteria, 'id');
        $bobotMentah  = array_column($kriteria, 'bobot', 'id');
        $tipeAtribut  = array_column($kriteria, 'tipe_atribut', 'id');
        $totalBobot   = array_sum($bobotMentah);
        $bobotNormal  = [];
        foreach ($idKriteria as $j) {
            // Bobot dinormalisasi supaya admin tidak wajib membuat totalnya = 1.
            $bobotNormal[$j] = $totalBobot > 0 ? ($bobotMentah[$j] / $totalBobot) : 0;
        }

        // Langkah 2: penyebut normalisasi per kolom = akar jumlah kuadrat
        $penyebut = [];
        foreach ($idKriteria as $j) {
            $sumSq = 0.0;
            foreach ($matriks as $baris) {
                $sumSq += ($baris[$j] ?? 0) ** 2;
            }
            $penyebut[$j] = sqrt($sumSq);
        }

        // Langkah 2 & 3: matriks ternormalisasi terbobot y_ij
        $y = [];
        foreach ($matriks as $idAlt => $baris) {
            foreach ($idKriteria as $j) {
                $r = $penyebut[$j] > 0 ? (($baris[$j] ?? 0) / $penyebut[$j]) : 0;
                $y[$idAlt][$j] = $r * $bobotNormal[$j];
            }
        }

        // Langkah 4: solusi ideal positif (A+) & negatif (A-) per kolom
        $aPositif = [];
        $aNegatif = [];
        foreach ($idKriteria as $j) {
            $kolom = array_column($y, $j);
            if ($tipeAtribut[$j] === 'cost') {
                $aPositif[$j] = min($kolom);
                $aNegatif[$j] = max($kolom);
            } else { // benefit (default)
                $aPositif[$j] = max($kolom);
                $aNegatif[$j] = min($kolom);
            }
        }

        // Langkah 5 & 6: jarak ke solusi ideal + nilai preferensi Ci
        $hasil = [];
        foreach ($y as $idAlt => $baris) {
            $sumPos = 0.0;
            $sumNeg = 0.0;
            foreach ($idKriteria as $j) {
                $sumPos += ($baris[$j] - $aPositif[$j]) ** 2;
                $sumNeg += ($baris[$j] - $aNegatif[$j]) ** 2;
            }
            $dPos = sqrt($sumPos);
            $dNeg = sqrt($sumNeg);
            $denom = $dPos + $dNeg;

            $hasil[$idAlt] = [
                'd_positif'        => round($dPos, 6),
                'd_negatif'        => round($dNeg, 6),
                'nilai_preferensi' => $denom > 0 ? round($dNeg / $denom, 6) : 0.0,
            ];
        }

        // Langkah 7: ranking descending berdasarkan nilai_preferensi.
        // Tie-break: alternatif dengan id lebih kecil (dibuat lebih dulu) menang.
        // Sesuaikan aturan tie-break ini kalau instansi punya kebijakan sendiri
        // (mis. berdasarkan masa kerja) — dokumentasikan di kolom `catatan`
        // pada topsis_proses.
        uasort($hasil, function ($a, $b) {
            return $b['nilai_preferensi'] <=> $a['nilai_preferensi'];
        });
        $rank = 1;
        foreach ($hasil as $idAlt => $row) {
            $hasil[$idAlt]['ranking'] = $rank++;
        }

        return $hasil;
    }

    /**
     * Validasi dasar supaya error data ketahuan lebih awal, bukan jadi
     * hasil TOPSIS yang salah tanpa disadari.
     */
    private function validasi(array $matriks, array $kriteria): void
    {
        if (empty($matriks)) {
            throw new InvalidArgumentException('Matriks alternatif kosong — pastikan ada alternatif yang diikutkan di proses ini.');
        }
        if (empty($kriteria)) {
            throw new InvalidArgumentException('Daftar kriteria kosong — proses TOPSIS butuh minimal 1 kriteria.');
        }
        foreach ($kriteria as $k) {
            if (!isset($k['id'], $k['bobot'], $k['tipe_atribut'])) {
                throw new InvalidArgumentException('Setiap kriteria wajib punya id, bobot, dan tipe_atribut.');
            }
            if (!in_array($k['tipe_atribut'], ['benefit', 'cost'], true)) {
                throw new InvalidArgumentException("tipe_atribut kriteria id={$k['id']} harus 'benefit' atau 'cost'.");
            }
        }
        $idKriteria = array_column($kriteria, 'id');
        foreach ($matriks as $idAlt => $baris) {
            foreach ($idKriteria as $j) {
                if (!array_key_exists($j, $baris)) {
                    throw new InvalidArgumentException("Alternatif id={$idAlt} belum punya nilai untuk kriteria id={$j} — lengkapi penilaian sebelum menghitung.");
                }
            }
        }
    }
}
