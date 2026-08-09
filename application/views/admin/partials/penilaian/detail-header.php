<!-- Detail Header Banner -->
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column justify-content-between gap-3 mb-3">
    <div>
        <div class="mb-2">
            <a href="<?= site_url('proses'); ?>" class="btn btn-sm btn-light border shadow-sm">
                <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Periode
            </a>
        </div>
        <div class="section-kicker d-flex align-items-center gap-1 text-primary fw-bold text-uppercase fs-11 tracking-wider mb-1">
            <i class="ti ti-trophy"></i> Hasil Evaluasi TOPSIS
        </div>
        <h3 class="fw-bold mb-1 text-dark">Rincian Penilaian Pegawai — <?= html_escape($periode_info['nama_periode']); ?></h3>
        <p class="text-muted fs-13 mb-0">Daftar peringkat, skor preferensi $V_i$, dan matriks perhitungan TOPSIS kandidat pegawai.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-outline-primary" id="btnRecalculateTopsis">
            <i class="ti ti-refresh me-1"></i> Hitung Ulang TOPSIS
        </button>
        <button type="button" class="btn btn-brand shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPenilaian">
            <i class="ti ti-user-plus me-1"></i> Input Nilai Pegawai
        </button>
    </div>
</div>
