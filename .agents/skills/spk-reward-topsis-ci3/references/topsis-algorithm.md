# Metode TOPSIS — Rumus, Alur, dan Contoh Perhitungan

TOPSIS (*Technique for Order Preference by Similarity to Ideal Solution*)
memilih alternatif yang jaraknya **paling dekat ke solusi ideal positif**
dan **paling jauh dari solusi ideal negatif**. Implementasi harus generik
terhadap jumlah kriteria dan jumlah alternatif — jangan pernah hardcode
angka kriteria di kode manapun, selalu loop dari `topsis_proses_kriteria`
dan `topsis_proses_alternatif` (lihat `references/database-schema.md`).

Mesin perhitungan referensi ada di `assets/templates/Topsis_service.php` —
murni PHP, tidak bergantung ke CodeIgniter, supaya mudah di-unit-test.

## Notasi

- `m` = jumlah alternatif (pegawai yang dinilai)
- `n` = jumlah kriteria
- `x_ij` = nilai mentah alternatif *i* pada kriteria *j* (dari tabel `penilaian`)
- `w_j` = bobot kriteria *j*, **dinormalisasi** (`bobot_j / total_semua_bobot`) — supaya total bobot selalu 1 tidak peduli berapa pun bobot mentah yang diinput admin

## Langkah 1 — Susun matriks keputusan X

Baris = alternatif, kolom = kriteria. Untuk kriteria **kualitatif**, `x_ij`
adalah `nilai` dari `skala_kriteria` yang dipilih user (bukan teks
labelnya). Untuk kriteria **kuantitatif**, `x_ij` adalah angka rill yang
diinput langsung. Di titik ini semuanya sudah berupa angka murni — jenis
data hanya relevan saat input, tidak lagi relevan saat perhitungan.

## Langkah 2 — Normalisasi matriks (r_ij)

```
r_ij = x_ij / sqrt( Σ_i(x_ij²) )
```

Setiap kolom kriteria dibagi akar-jumlah-kuadrat kolomnya sendiri. Ini
membuat kriteria dengan skala angka berbeda (mis. "jumlah perkara" 0–500
vs "skala kedisiplinan" 1–5) bisa dibandingkan setara.

## Langkah 3 — Matriks ternormalisasi terbobot (y_ij)

```
y_ij = w_j * r_ij
```

## Langkah 4 — Solusi ideal positif (A+) dan negatif (A-)

Untuk tiap kriteria j:
- Jika `tipe_atribut = 'benefit'` (makin besar makin baik, mis. jumlah
  perkara selesai, nilai integritas): `A+_j = max_i(y_ij)`, `A-_j = min_i(y_ij)`
- Jika `tipe_atribut = 'cost'` (makin kecil makin baik, mis. jumlah
  keterlambatan, jumlah perkara yang ditunda): `A+_j = min_i(y_ij)`, `A-_j = max_i(y_ij)`

## Langkah 5 — Jarak ke solusi ideal

```
D+_i = sqrt( Σ_j (y_ij - A+_j)² )
D-_i = sqrt( Σ_j (y_ij - A-_j)² )
```

## Langkah 6 — Nilai preferensi (Ci)

```
C_i = D-_i / (D+_i + D-_i)
```

`C_i` berkisar 0–1. Semakin mendekati 1, semakin dekat ke solusi ideal
positif → semakin layak diprioritaskan menerima reward.

## Langkah 7 — Perankingan

Urutkan `C_i` descending. Ranking 1 = nilai `C_i` tertinggi. Jika ada nilai
`C_i` yang sama persis, tentukan aturan tie-break (mis. berdasarkan masa
kerja atau golongan) — dokumentasikan aturan ini di `catatan` proses
karena akan dicek saat verifikasi Berita Acara.

## Contoh perhitungan singkat (3 alternatif, 2 kriteria)

Kriteria: C1 = Jumlah Perkara Selesai (kuantitatif, benefit, bobot 3),
C2 = Kedisiplinan (kualitatif skala 1–4, benefit, bobot 2). Total bobot
mentah = 5 → w1 = 0.6, w2 = 0.4.

| Alternatif | C1 (x) | C2 (x, dari skala) |
|---|---|---|
| A | 80 | 4 |
| B | 60 | 3 |
| C | 90 | 2 |

Normalisasi kolom C1: `sqrt(80²+60²+90²) = sqrt(6400+3600+8100) = sqrt(18100) ≈ 134.54`
→ r(A,C1)=0.5947, r(B,C1)=0.4460, r(C,C1)=0.6690

Normalisasi kolom C2: `sqrt(4²+3²+2²) = sqrt(16+9+4) = sqrt(29) ≈ 5.385`
→ r(A,C2)=0.7428, r(B,C2)=0.5571, r(C,C2)=0.3714

Terbobot (kalikan w1=0.6, w2=0.4):
| | y_C1 | y_C2 |
|---|---|---|
| A | 0.3568 | 0.2971 |
| B | 0.2676 | 0.2228 |
| C | 0.4014 | 0.1486 |

Karena keduanya benefit: `A+ = (0.4014, 0.2971)`, `A- = (0.2676, 0.1486)`

`D+_A = sqrt((0.3568-0.4014)² + (0.2971-0.2971)²) = 0.0446`
`D-_A = sqrt((0.3568-0.2676)² + (0.2971-0.1486)²) = 0.1731`
`C_A = 0.1731 / (0.0446+0.1731) = 0.7950`

(Hitung B dan C dengan pola sama.) Alternatif dengan `C_i` tertinggi
menang. Gunakan contoh ini sebagai kasus uji unit test `Topsis_service.php`.

## Yang wajib fleksibel di implementasi

1. **Jumlah kriteria** — form input, matriks, dan loop perhitungan semua
   dibaca dari `COUNT(topsis_proses_kriteria WHERE id_proses = ?)`, bukan
   angka tetap.
2. **Jenis data campuran** — dalam satu proses, boleh ada kriteria
   kualitatif dan kuantitatif sekaligus; keduanya sudah jadi angka murni
   sebelum masuk Langkah 1, jadi mesin TOPSIS tidak perlu tahu bedanya.
3. **benefit vs cost** — jangan asumsikan semua kriteria benefit; selalu
   cek `tipe_atribut` per kolom di Langkah 4.
4. **Bobot tidak harus totalnya 1** — selalu normalisasi bobot di kode
   (`$bobot_j / array_sum($semua_bobot)`), jangan memaksa admin
   menghitung sendiri supaya totalnya pas 1.
