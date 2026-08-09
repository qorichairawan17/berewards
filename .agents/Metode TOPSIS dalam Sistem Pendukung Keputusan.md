# **Metode TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution) dalam Sistem Pendukung Keputusan**

**Technique for Order of Preference by Similarity to Ideal Solution (TOPSIS)** merupakan salah satu metode pengambilan keputusan multikriteria (*Multi-Criteria Decision Making* / MCDM) yang pertama kali diperkenalkan oleh Yoon dan Hwang pada tahun 1981\. Metode ini digunakan secara luas dalam Sistem Pendukung Keputusan (SPK) untuk menyelesaikan masalah pemeringkatan atau pemilihan alternatif terbaik dari sekumpulan alternatif yang dievaluasi berdasarkan beberapa kriteria.

## **1\. Konsep Dasar dan Prinsip Utama**

Prinsip utama di balik metode TOPSIS sangat rasional dan intuitif: alternatif yang terpilih tidak hanya harus memiliki **jarak terpendek dari Solusi Ideal Positif (SIP / *Positive Ideal Solution*)**, tetapi juga harus memiliki **jarak terjauh dari Solusi Ideal Negatif (SIN / *Negative Ideal Solution*)**.

> * **Solusi Ideal Positif (A\+):** Didefinisikan sebagai kombinasi dari seluruh nilai terbaik yang dapat dicapai untuk setiap kriteria. Untuk kriteria bertipe keuntungan (*benefit*), nilai terbaik adalah nilai maksimum. Sedangkan untuk kriteria bertipe biaya (*cost*), nilai terbaik adalah nilai minimum.  
> * **Solusi Ideal Negatif (A\-):** Didefinisikan sebagai kombinasi dari seluruh nilai terburuk untuk setiap kriteria. Untuk kriteria bertipe *benefit*, nilai terburuk adalah nilai minimum. Sedangkan untuk kriteria bertipe *cost*, nilai terburuk adalah nilai maksimum.

## **2\. Tahapan Algoritma TOPSIS**

Prosedur perhitungan metode TOPSIS terdiri dari beberapa tahapan sistematis sebagai berikut:

### **Langkah 1: Pembentukan Matriks Keputusan (X)**

Matriks keputusan X berukuran m × n, di mana m mewakili jumlah alternatif (A1, A2, ..., Am) dan n mewakili jumlah kriteria (C1, C2, ..., Cn). Setiap elemen xij menyatakan nilai kinerja alternatif ke-i pada kriteria ke-j.

### **Langkah 2: Normalisasi Matriks Keputusan (R)**

Metode TOPSIS menggunakan teknik normalisasi Euclidean (vektor) untuk mengubah elemen matriks keputusan ke skala yang seragam sehingga dapat dibandingkan secara adil:  
*rij \= xij / √(∑k=1m xkj2)*

### **Langkah 3: Pembentukan Matriks Ternormalisasi Terbobot (Y)**

Matriks Y diperoleh dengan mengalikan setiap kolom matriks R dengan bobot kriteria (wj) masing-masing, di mana ∑ wj \= 1:  
*yij \= wj × rij*

### **Langkah 4: Menentukan Solusi Ideal Positif (A\+) dan Negatif (A\-)**

Nilai ideal ditentukan berdasarkan sifat masing-masing kriteria:

> * **Kriteria Benefit:** Aj\+ \= maxi(yij) dan Aj\- \= mini(yij)  
> * **Kriteria Cost:** Aj\+ \= mini(yij) dan Aj\- \= maxi(yij)

### **Langkah 5: Menghitung Jarak Solusi Ideal (Di\+ dan Di\-)**

Jarak Euclidean setiap alternatif terhadap Solusi Ideal Positif (Di\+) dan Solusi Ideal Negatif (Di\-) dihitung dengan formula:

> * **Jarak ke SIP (Di\+):** Di\+ \= √(∑j=1n (yij \- Aj\+)2)  
> * **Jarak ke SIN (Di\-):** Di\- \= √(∑j=1n (yij \- Aj\-)2)

### **Langkah 6: Menghitung Nilai Preferensi (Vi)**

Nilai kedekatan relatif atau preferensi (Vi) untuk setiap alternatif dihitung sebagai:  
*Vi \= Di\- / (Di\+ \+ Di\-)*

### **Langkah 7: Perankingan Alternatif**

Alternatif diurutkan berdasarkan nilai preferensi Vi dari yang tertinggi hingga terendah. Nilai Vi mendekati 1 menunjukkan bahwa alternatif tersebut merupakan pilihan terbaik.

## **3\. Contoh Studi Kasus: Pemilihan Karyawan Terbaik**

Sebuah perusahaan ingin melakukan seleksi untuk menentukan karyawan terbaik dari 3 kandidat: **Budi (A1)**, **Ani (A2)**, dan **Citra (A3)**.  
Kriteria yang digunakan dalam penilaian:

| Kode Kriteria | Nama Kriteria | Sifat / Jenis | Bobot (wj)   |
| :---- | :---- | :---- | :---- |
| C1 | Tes Potensi Akademik (TPA) | Benefit | 0.50 (50%) |
| C2 | Pengalaman Kerja (Tahun) | Benefit | 0.30 (30%) |
| C3 | Ekspektasi Gaji (Juta Rp) | Cost | 0.20 (20%) |

### **3.1. Matriks Keputusan Awal (X)**

| Alternatif | C1 (TPA) | C2 (Pengalaman) | C3 (Gaji)   |
| :---- | :---- | :---- | :---- |
| **A1 (Budi)** | 80 | 4 | 8 |
| **A2 (Ani)** | 90 | 2 | 6 |
| **A3 (Citra)** | 70 | 5 | 7 |

### **3.2. Normalisasi Matriks (R)**

Hitung pembagi Euclidean untuk tiap kolom kriteria:

> * Pembagi C1 \= √(802 \+ 902 \+ 702) \= √(6400 \+ 8100 \+ 4900\) \= √(19400) ≈ **139.284**  
> * Pembagi C2 \= √(42 \+ 22 \+ 52) \= √(16 \+ 4 \+ 25\) \= √(45) ≈ **6.708**  
> * Pembagi C3 \= √(82 \+ 62 \+ 72) \= √(64 \+ 36 \+ 49\) \= √(149) ≈ **12.207**

| Alternatif | C1 | C2 | C3   |
| :---- | :---- | :---- | :---- |
| **A1** | 80 / 139.284 \= **0.574** | 4 / 6.708 \= **0.596** | 8 / 12.207 \= **0.655** |
| **A2** | 90 / 139.284 \= **0.646** | 2 / 6.708 \= **0.298** | 6 / 12.207 \= **0.492** |
| **A3** | 70 / 139.284 \= **0.503** | 5 / 6.708 \= **0.745** | 7 / 12.207 \= **0.573** |

### **3.3. Matriks Normalisasi Terbobot (Y)**

Kalikan setiap elemen matriks R dengan bobotnya masing-masing (w1 \= 0.5, w2 \= 0.3, w3 \= 0.2):

| Alternatif | C1 (w \= 0.5) | C2 (w \= 0.3) | C3 (w \= 0.2)   |
| :---- | :---- | :---- | :---- |
| **A1** | 0.574 × 0.5 \= **0.287** | 0.596 × 0.3 \= **0.179** | 0.655 × 0.2 \= **0.131** |
| **A2** | 0.646 × 0.5 \= **0.323** | 0.298 × 0.3 \= **0.089** | 0.492 × 0.2 \= **0.098** |
| **A3** | 0.503 × 0.5 \= **0.251** | 0.745 × 0.3 \= **0.224** | 0.573 × 0.2 \= **0.115** |

### **3.4. Solusi Ideal Positif (A\+) dan Solusi Ideal Negatif (A\-)**

> * **Solusi Ideal Positif (A\+):**  
  * C1 (Benefit): max(0.287, 0.323, 0.251) \= **0.323**  
  * C2 (Benefit): max(0.179, 0.089, 0.224) \= **0.224**  
  * C3 (Cost): min(0.131, 0.098, 0.115) \= **0.098**  
  * **A\+ \= \[0.323, 0.224, 0.098\]**  
> * **Solusi Ideal Negatif (A\-):**  
  * C1 (Benefit): min(0.287, 0.323, 0.251) \= **0.251**  
  * C2 (Benefit): min(0.179, 0.089, 0.224) \= **0.089**  
  * C3 (Cost): max(0.131, 0.098, 0.115) \= **0.131**  
  * **A\- \= \[0.251, 0.089, 0.131\]**

### **3.5. Jarak Solusi Ideal (Di\+ dan Di\-)**

Hitung jarak Euclidean untuk tiap alternatif:

> * **Alternatif A1 (Budi):**  
>   D1\+ \= √((0.287-0.323)2 \+ (0.179-0.224)2 \+ (0.131-0.098)2) \= √(0.001296 \+ 0.002025 \+ 0.001089) \= √(0.00441) ≈ **0.066**  
>   D1\- \= √((0.287-0.251)2 \+ (0.179-0.089)2 \+ (0.131-0.131)2) \= √(0.001296 \+ 0.008100 \+ 0\) \= √(0.009396) ≈ **0.096**  
> * **Alternatif A2 (Ani):**  
>   D2\+ \= √((0.323-0.323)2 \+ (0.089-0.224)2 \+ (0.098-0.098)2) \= √(0 \+ 0.018225 \+ 0\) \= √(0.018225) ≈ **0.134**  
>   D2\- \= √((0.323-0.251)2 \+ (0.089-0.089)2 \+ (0.098-0.131)2) \= √(0.005184 \+ 0 \+ 0.001089) \= √(0.006273) ≈ **0.079**  
> * **Alternatif A3 (Citra):**  
>   D3\+ \= √((0.251-0.323)2 \+ (0.224-0.224)2 \+ (0.115-0.098)2) \= √(0.005184 \+ 0 \+ 0.000289) \= √(0.005473) ≈ **0.074**  
>   D3\- \= √((0.251-0.251)2 \+ (0.224-0.089)2 \+ (0.115-0.131)2) \= √(0 \+ 0.018225 \+ 0.000256) \= √(0.018481) ≈ **0.135**

### **3.6. Perhitungan Nilai Preferensi (Vi) dan Perankingan**

Hitung nilai preferensi relatif (Vi):

> * V1 \= 0.096 / (0.066 \+ 0.096) \= 0.096 / 0.162 ≈ **0.593**  
> * V2 \= 0.079 / (0.134 \+ 0.079) \= 0.079 / 0.213 ≈ **0.370**  
> * V3 \= 0.135 / (0.074 \+ 0.135) \= 0.135 / 0.209 ≈ **0.647**

| Peringkat | Alternatif | Jarak D\+ | Jarak D\- | Nilai Preferensi (Vi) | Keterangan   |
| :---- | :---- | :---- | :---- | :---- | :---- |
| **1** | **A3 (Citra)** | 0.074 | 0.135 | **0.647** | **Terpilih / Terbaik** |
| 2 | A1 (Budi) | 0.066 | 0.096 | 0.593 | Peringkat 2 |
| 3 | A2 (Ani) | 0.134 | 0.079 | 0.370 | Peringkat 3 |

**Kesimpulan Studi Kasus:** Berdasarkan analisis metode TOPSIS, **Citra (A3)** direkomendasikan sebagai karyawan terbaik dengan nilai preferensi tertinggi sebesar **0.647**.

## **4\. Kelebihan dan Kelemahan Metode TOPSIS**

### **Kelebihan:**

> * **Konsep Sederhana dan Elegan:** Menggunakan logika intuitif jarak terhadap solusi ideal terbaik dan terburuk.  
> * **Kemampuan Menangani Banyak Kriteria & Alternatif:** Komputasi tetap efisien meskipun melibatkan banyak kriteria kuantitatif.  
> * **Mempertimbangkan Trade-off:** Mampu mengakomodasi kriteria bertipe *benefit* dan *cost* secara bersamaan tanpa memerlukan konversi skala yang rumit.  
> * **Output Berupa Skor Kontinu:** Memberikan gambaran yang jelas mengenai seberapa jauh keunggulan satu alternatif dibanding alternatif lain.

### **Kelemahan:**

> * **Subjektivitas Penentuan Bobot:** TOPSIS tidak menyediakan mekanisme internal untuk menentukan bobot kriteria secara objektif (sehingga sering dikombinasikan dengan metode AHP atau Entropy).  
> * **Sensitivitas terhadap Rank Reversal:** Penambahan atau pengurangan alternatif baru dapat mengubah peringkat alternatif yang sudah ada karena perubahan nilai max/min pada matriks terbobot.