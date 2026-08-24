<!-- Detail Header Banner -->
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column justify-content-between gap-3 mb-3">
    <div>
        <div class="mb-2">
            <a href="<?= site_url('proses'); ?>" class="btn btn-sm btn-light border shadow-sm">
                <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Periode Penilaian
            </a>
        </div>
        <div class="section-kicker d-flex align-items-center gap-1 text-primary fw-bold text-uppercase fs-11 tracking-wider mb-1">
            <i class="ti ti-cpu"></i> Sesi Penilaian & Input Alternative Pegawai
        </div>
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold mb-0 text-dark">Detail Penilaian — <?= html_escape($periode_info['nama_periode']); ?></h3>
            <span id="header_status_badge">
                <?php if ($periode_info['status_topsis'] === 'Final'): ?>
                    <span class="badge bg-success rounded-pill px-3 py-1 fs-11"><i class="ti ti-check me-1"></i>Status: Final</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fs-11"><i class="ti ti-clock me-1"></i>Status: Draft</span>
                <?php endif; ?>
            </span>
        </div>
        <p class="text-muted fs-13 mb-0 mt-1">Input nilai kriteria alternatif untuk setiap pegawai, lalu tekan tombol <strong>Proses Perhitungan TOPSIS</strong> untuk mengkalkulasi skor preferensi akhir dan mengubah status menjadi <strong>Final</strong>.</p>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <?php if ($periode_info['status_topsis'] === 'Final'): ?>
            <a href="<?= site_url('laporan/export_proses/' . $id_proses); ?>" class="btn btn-brand shadow-sm" title="Ekspor Dokumen Berita Acara (.docx)">
                <i class="ti ti-file-text me-1"></i> Cetak Berita Acara (.docx)
            </a>
        <?php endif; ?>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalInputNilaiPegawai">
            <i class="ti ti-user-plus me-1"></i> Input Nilai Alternative
        </button>
        <button type="button" class="btn btn-success shadow-sm" id="btnProsesHitungTopsis" data-id="<?= $id_proses; ?>">
            <i class="ti ti-calculator me-1"></i> Hitung Ulang TOPSIS
        </button>
    </div>
</div>
