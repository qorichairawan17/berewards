# Panduan UI — Clean, Minimalist, Futuristik, Tanpa Dark Theme

"Futuristik" di sini dicapai lewat **gradasi warna, ruang kosong yang
lega, animasi halus, dan tipografi tegas** — bukan lewat latar gelap.
Semua permukaan tetap terang (putih / abu sangat muda). Ini penting
diulang karena banyak referensi "futuristik" di internet defaultnya
dark-theme — jangan ikut pola itu di project ini.

## Stack

- **Bootstrap 5** (bukan 4) — sudah tanpa dependensi jQuery di komponennya
  sendiri, tapi jQuery tetap dipakai untuk AJAX & DataTables, itu tidak
  masalah karena keduanya bisa hidup berdampingan.
- **Google Fonts**: `Plus Jakarta Sans` atau `Inter` untuk teks umum,
  boleh `Poppins` untuk heading kalau ingin kesan sedikit lebih tegas.
- **Chart.js** — grafik ranking hasil TOPSIS di dashboard & preview laporan.
- **DataTables** (dengan tema Bootstrap 5) — listing master data.
- **SweetAlert2** — semua alert/konfirmasi, ganti total `alert()`/`confirm()` bawaan browser.
- **AOS (Animate On Scroll)** atau CSS `@keyframes` murni — animasi masuk yang halus di dashboard & halaman preview laporan. Pakai secukupnya; animasi berlebihan bertentangan dengan kesan "clean minimalist".
- **CountUp.js** (opsional) — animasi angka naik di kartu KPI dashboard.

Semua library di atas tersedia lewat CDN (`cdn.jsdelivr.net`,
`cdnjs.cloudflare.com`) — tidak perlu build step (webpack/vite), cocok
untuk CI3 yang menyajikan halaman lewat PHP view biasa.

## Palet warna (light theme)

```css
:root {
  --bg-page:        #F7F9FC;   /* latar halaman, bukan putih polos supaya kartu terlihat "melayang" */
  --bg-surface:      #FFFFFF;  /* latar kartu/modal */
  --bg-surface-alt:  #F1F5F9;  /* latar section sekunder, hover row tabel */

  --primary:         #4F46E5;  /* indigo — warna utama tombol, active nav */
  --primary-dark:    #4338CA;
  --accent:           #06B6D4; /* cyan — dipakai untuk gradient & highlight, bukan tombol utama */
  --gradient-brand:  linear-gradient(135deg, #4F46E5 0%, #06B6D4 100%);

  --success:  #16A34A;
  --warning:  #D97706;
  --danger:   #DC2626;
  --info:     #0284C7;

  --text-primary:   #0F172A;
  --text-secondary: #64748B;
  --border:         #E2E8F0;

  --radius: 0.85rem;           /* rounded-corner konsisten di semua kartu/tombol/input */
  --shadow-soft: 0 4px 20px rgba(15, 23, 42, 0.06);
  --shadow-hover: 0 8px 28px rgba(79, 70, 229, 0.14);
}
```

Aturan pakai gradient: **hanya** untuk elemen aksen kecil — tombol
primer, header kartu KPI, badge ranking #1, progress bar, active state
sidebar. Jangan jadikan gradient sebagai latar besar (mis. seluruh
background halaman) karena itu bikin "ramai", bukan "clean".

## Layout dasar

- **Sidebar** kiri fixed, lebar ~260px, latar putih dengan border kanan
  tipis `--border`. Item aktif dapat pill background gradient tipis
  (`rgba(79,70,229,0.08)`) + teks warna `--primary`, bukan gradient solid
  penuh (biar tetap ringan).
- **Topbar** tipis berisi breadcrumb + info user + tombol logout, latar
  putih, `box-shadow: var(--shadow-soft)`.
- **Kartu** (`.card`) selalu `border: none; border-radius: var(--radius);
  box-shadow: var(--shadow-soft);` — hindari border solid abu tua khas
  Bootstrap default.
- **Spacing**: gunakan skala 4px/8px Bootstrap utility (`p-4`, `gap-3`,
  dst), jangan padat — ruang kosong adalah bagian dari kesan "clean".

## Dashboard

Kartu KPI di baris atas (Total Pegawai Aktif, Periode Berjalan, Proses
Belum Selesai, dst) dengan ikon dari `bootstrap-icons` atau `lucide`,
angka besar (animasi CountUp opsional), dan aksen gradient tipis di
border-top kartu (`border-top: 3px solid; border-image: var(--gradient-brand) 1;`).
Di bawahnya, grafik batang/radar Chart.js menampilkan ranking hasil
TOPSIS proses terakhir per kategori.

## Form input matriks penilaian (halaman paling kompleks)

Karena jumlah kriteria dinamis, tabel input harus scroll horizontal
dengan header kolom sticky (`position: sticky; top: 0`), baris pertama =
nama alternatif (sticky juga di kolom pertama, `position: sticky; left: 0`)
supaya tetap terlihat saat scroll ke kanan pada kriteria yang banyak.
Untuk kriteria kualitatif pakai `<select class="form-select">` berisi
opsi dari `skala_kriteria`; untuk kuantitatif pakai `<input type="number"
class="form-control">`. Validasi client-side: sel tidak boleh kosong
sebelum tombol "Hitung TOPSIS" aktif — nonaktifkan tombol dan tampilkan
progress "X dari Y sel terisi" supaya admin tahu kapan siap dihitung.

## Halaman Preview Laporan (Berita Acara) — di sinilah "futuristik" paling terasa

Preview ini beda dari halaman kerja biasa — dibuat terasa seperti
"dokumen digital resmi yang hidup":

- Kartu utama lebar tengah (`max-width: 900px`, `margin: auto`), latar
  putih dengan bayangan lebih dalam (`--shadow-hover`), header kartu
  memakai `--gradient-brand` penuh dengan judul "Berita Acara Penetapan
  Reward" + nama periode + kategori, teks putih.
- Tabel ranking hasil dengan baris ranking 1–3 diberi badge medali
  (emas/perak/perunggu, warna solid bukan gradient supaya tidak
  bentrok) dan sedikit highlight latar (`--bg-surface-alt`).
- Animasi masuk halus: kartu fade-up (`opacity 0→1, translateY 12px→0`,
  `transition: 0.4s ease-out`) saat halaman dimuat; baris tabel muncul
  berurutan dengan delay singkat antar baris (`animation-delay` bertingkat
  50ms) — efek stagger yang umum dipakai di dashboard modern.
- Nomor "Nilai Preferensi" boleh dianimasikan naik dari 0 ke nilai akhir
  (CountUp.js, durasi ~800ms) untuk kesan hidup tanpa berlebihan.
- **WAJIB** sediakan `@media print` yang mematikan semua animasi,
  gradient background, dan shadow (ganti jadi border tipis biasa) supaya
  saat dicetak/di-PDF hasilnya tetap dokumen formal yang bersih, bukan
  tampilan "app". Contoh:

```css
@media print {
  * { animation: none !important; transition: none !important; box-shadow: none !important; }
  .card-header { background: #FFFFFF !important; color: #000 !important; border-bottom: 2px solid #000; }
}
```

- Tombol "Export ke Word (.docx)" tetap terlihat jelas di layar (tidak
  ikut `@media print`) — lihat `references/word-export.md`.

## Yang harus dihindari

- Latar hitam/abu sangat gelap di elemen manapun (bertentangan dengan
  permintaan "tidak dark theme").
- Neon glow berlebihan, terlalu banyak drop-shadow warna-warni — itu
  kesan "flashy", bukan "clean futuristik".
- Icon set yang tidak konsisten (campur beberapa icon library sekaligus)
  — pilih satu (`bootstrap-icons` disarankan karena native cocok dengan
  Bootstrap 5) dan pakai konsisten di semua modul.
