<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Topsis_algorithm_service
 * 
 * Mesin Matematis Murni (Pure Mathematical Engine) untuk Metode TOPSIS
 * (Technique for Order of Preference by Similarity to Ideal Solution).
 * 
 * Karakteristik Arsitektur:
 * 1. Independen dari database sehingga mudah di-unit-test secara terisolasi.
 * 2. Generik dan dinamis: mendukung sembarang jumlah alternatif (m) dan kriteria (n).
 * 3. Menangani kriteria bertipe 'benefit' (keuntungan) dan 'cost' (biaya).
 * 4. Otomatis menormalisasi bobot kriteria (w_j / sum(w)) sehingga total bobot selalu 1.0.
 * 5. Mencegah error pembagian nol (division by zero) secara elegan.
 * 
 * Rujukan Formula:
 * - Yoon & Hwang (1981) - Multiple Attribute Decision Making: Methods and Applications
 * - Dokumen SPK: .agents/Metode TOPSIS dalam Sistem Pendukung Keputusan.md
 * - Algoritma: .agents/skills/spk-reward-topsis-ci3/references/topsis-algorithm.md
 * 
 * @author BeRewards Core Engine
 * @version 1.0.0
 */
class Topsis_algorithm_service
{
    /**
     * Menjalankan seluruh 7 tahapan algoritma perhitungan TOPSIS secara komprehensif.
     * 
     * @param array $alternatives Daftar alternatif array format:
     *                            [
     *                              ['id' => 1, 'nama' => 'Rina Agustina', 'nip' => '...'],
     *                              ...
     *                            ]
     * @param array $criteria     Daftar kriteria array format:
     *                            [
     *                              [
     *                                'id'           => 1,
     *                                'kode'         => 'C1',
     *                                'nama'         => 'Kedisiplinan',
     *                                'bobot'        => 20.0,
     *                                'tipe_atribut' => 'benefit' // 'benefit' atau 'cost'
     *                              ],
     *                              ...
     *                            ]
     * @param array $evaluations  Matriks penilaian mentah format:
     *                            [
     *                              alternative_id => [
     *                                criteria_id => float_score,
     *                                ...
     *                              ],
     *                              ...
     *                            ]
     * 
     * @return array Struktur data lengkap berisi seluruh matriks antara dan hasil akhir perankingan.
     * @throws InvalidArgumentException Jika parameter tidak valid atau data alternatif/kriteria kosong.
     */
    public function calculate(array $alternatives, array $criteria, array $evaluations)
    {
        // 0. Validasi Masukan Awal
        if (empty($alternatives)) {
            throw new InvalidArgumentException("Daftar alternatif tidak boleh kosong untuk perhitungan TOPSIS.");
        }
        if (empty($criteria)) {
            throw new InvalidArgumentException("Daftar kriteria tidak boleh kosong untuk perhitungan TOPSIS.");
        }

        // 1. Langkah 1: Susun Matriks Keputusan (X) & Normalisasi Bobot Kriteria (w)
        $matrix_x = array();
        foreach ($alternatives as $alt) {
            $alt_id = $alt['id'];
            $matrix_x[$alt_id] = array();
            foreach ($criteria as $crit) {
                $crit_id = $crit['id'];
                $val = isset($evaluations[$alt_id][$crit_id]) ? (float)$evaluations[$alt_id][$crit_id] : 0.0;
                $matrix_x[$alt_id][$crit_id] = $val;
            }
        }

        // Hitung total bobot kriteria untuk normalisasi bobot w_j' = w_j / sum(w)
        $total_raw_weight = 0.0;
        foreach ($criteria as $crit) {
            $total_raw_weight += (float)$crit['bobot'];
        }
        if ($total_raw_weight <= 0.0) {
            $total_raw_weight = 1.0;
        }

        $normalized_weights = array();
        foreach ($criteria as $crit) {
            $crit_id = $crit['id'];
            $normalized_weights[$crit_id] = (float)$crit['bobot'] / $total_raw_weight;
        }

        // 2. Langkah 2: Normalisasi Matriks Keputusan (R)
        // Formula: r_ij = x_ij / sqrt( sum_i (x_ij^2) )
        $divisors = array();
        foreach ($criteria as $crit) {
            $crit_id = $crit['id'];
            $sum_squared = 0.0;
            foreach ($alternatives as $alt) {
                $alt_id = $alt['id'];
                $val = $matrix_x[$alt_id][$crit_id];
                $sum_squared += ($val * $val);
            }
            $divisors[$crit_id] = sqrt($sum_squared);
        }

        $matrix_r = array();
        foreach ($alternatives as $alt) {
            $alt_id = $alt['id'];
            $matrix_r[$alt_id] = array();
            foreach ($criteria as $crit) {
                $crit_id = $crit['id'];
                $divisor = $divisors[$crit_id];
                if ($divisor > 0.0) {
                    $matrix_r[$alt_id][$crit_id] = $matrix_x[$alt_id][$crit_id] / $divisor;
                } else {
                    $matrix_r[$alt_id][$crit_id] = 0.0;
                }
            }
        }

        // 3. Langkah 3: Matriks Ternormalisasi Terbobot (Y)
        // Formula: y_ij = w_j' * r_ij
        $matrix_y = array();
        foreach ($alternatives as $alt) {
            $alt_id = $alt['id'];
            $matrix_y[$alt_id] = array();
            foreach ($criteria as $crit) {
                $crit_id = $crit['id'];
                $w = $normalized_weights[$crit_id];
                $r = $matrix_r[$alt_id][$crit_id];
                $matrix_y[$alt_id][$crit_id] = $w * $r;
            }
        }

        // 4. Langkah 4: Tentukan Solusi Ideal Positif (A+) dan Solusi Ideal Negatif (A-)
        // Benefit: A+_j = max_i(y_ij), A-_j = min_i(y_ij)
        // Cost:    A+_j = min_i(y_ij), A-_j = max_i(y_ij)
        $ideal_positive = array();
        $ideal_negative = array();

        foreach ($criteria as $crit) {
            $crit_id = $crit['id'];
            $tipe = strtolower(trim($crit['tipe_atribut'])); // 'benefit' atau 'cost'

            // Kumpulkan seluruh nilai kolom y untuk kriteria ini
            $col_values = array();
            foreach ($alternatives as $alt) {
                $alt_id = $alt['id'];
                $col_values[] = $matrix_y[$alt_id][$crit_id];
            }

            $max_val = !empty($col_values) ? max($col_values) : 0.0;
            $min_val = !empty($col_values) ? min($col_values) : 0.0;

            if ($tipe === 'cost') {
                $ideal_positive[$crit_id] = $min_val;
                $ideal_negative[$crit_id] = $max_val;
            } else {
                // Default: benefit
                $ideal_positive[$crit_id] = $max_val;
                $ideal_negative[$crit_id] = $min_val;
            }
        }

        // 5. Langkah 5: Hitung Jarak Euclidean ke Solusi Ideal (D+ dan D-)
        // D+_i = sqrt( sum_j (y_ij - A+_j)^2 )
        // D-_i = sqrt( sum_j (y_ij - A-_j)^2 )
        $d_plus  = array();
        $d_minus = array();

        foreach ($alternatives as $alt) {
            $alt_id = $alt['id'];
            $sum_diff_pos_sq = 0.0;
            $sum_diff_neg_sq = 0.0;

            foreach ($criteria as $crit) {
                $crit_id = $crit['id'];
                $y_val   = $matrix_y[$alt_id][$crit_id];
                $a_pos   = $ideal_positive[$crit_id];
                $a_neg   = $ideal_negative[$crit_id];

                $diff_pos = $y_val - $a_pos;
                $diff_neg = $y_val - $a_neg;

                $sum_diff_pos_sq += ($diff_pos * $diff_pos);
                $sum_diff_neg_sq += ($diff_neg * $diff_neg);
            }

            $d_plus[$alt_id]  = sqrt($sum_diff_pos_sq);
            $d_minus[$alt_id] = sqrt($sum_diff_neg_sq);
        }

        // 6. Langkah 6: Hitung Nilai Kedekatan Relatif / Skor Preferensi (V_i atau C_i)
        // V_i = D-_i / (D+_i + D-_i)
        $preferences = array();
        foreach ($alternatives as $alt) {
            $alt_id   = $alt['id'];
            $dp       = $d_plus[$alt_id];
            $dm       = $d_minus[$alt_id];
            $total_d  = $dp + $dm;

            if ($total_d > 0.0) {
                $preferences[$alt_id] = $dm / $total_d;
            } else {
                $preferences[$alt_id] = 0.0;
            }
        }

        // 7. Langkah 7: Perankingan Alternatif (Sorting Descending)
        // Peringkat 1 adalah alternatif dengan nilai preferensi V_i terbesar
        $ranking_list = array();
        foreach ($alternatives as $alt) {
            $alt_id = $alt['id'];
            $ranking_list[] = array(
                'id'               => $alt_id,
                'nama'             => isset($alt['nama']) ? $alt['nama'] : '',
                'nip'              => isset($alt['nip']) ? $alt['nip'] : '',
                'jabatan'          => isset($alt['jabatan']) ? $alt['jabatan'] : '',
                'kategori'         => isset($alt['kategori']) ? $alt['kategori'] : '',
                'd_plus'           => $d_plus[$alt_id],
                'd_minus'          => $d_minus[$alt_id],
                'nilai_preferensi' => $preferences[$alt_id],
                'skor_topsis'      => $preferences[$alt_id]
            );
        }

        // Urutkan array berdasarkan nilai_preferensi DESC
        usort($ranking_list, function($a, $b) {
            if (abs($b['nilai_preferensi'] - $a['nilai_preferensi']) < 0.0000001) {
                return 0; // Nilai identik
            }
            return ($b['nilai_preferensi'] > $a['nilai_preferensi']) ? 1 : -1;
        });

        // Berikan nomor peringkat 1, 2, 3, dst.
        $rank = 1;
        foreach ($ranking_list as &$item) {
            $item['ranking']   = $rank;
            $item['peringkat'] = $rank;
            $rank++;
        }
        unset($item);

        // Susun struktur data hasil kalkulasi lengkap
        return array(
            'status'             => TRUE,
            'matrix_x'           => $matrix_x,
            'matrix_r'           => $matrix_r,
            'matrix_y'           => $matrix_y,
            'divisors'           => $divisors,
            'normalized_weights' => $normalized_weights,
            'ideal_positive'     => $ideal_positive,
            'ideal_negative'     => $ideal_negative,
            'd_plus'             => $d_plus,
            'd_minus'            => $d_minus,
            'preferences'        => $preferences,
            'rankings'           => $ranking_list,
            'winner'             => !empty($ranking_list[0]) ? $ranking_list[0] : NULL
        );
    }
}
