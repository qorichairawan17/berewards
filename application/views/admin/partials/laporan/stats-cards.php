<!-- Statistic Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Laporan">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-files"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Total Berita Acara</p>
                    <h4 class="fw-bold mb-0 text-dark" id="stat_total_ba"><?= isset($stats['total_ba']) ? $stats['total_ba'] : 0; ?> <span class="fs-12 text-muted fw-normal">Dokumen</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon green flex-shrink-0">
                    <i class="ti ti-file-check"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">BA Disahkan</p>
                    <h4 class="fw-bold mb-0 text-dark" id="stat_disahkan"><?= isset($stats['disahkan']) ? $stats['disahkan'] : 0; ?> <span class="fs-12 text-muted fw-normal">Resmi</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-archive"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">BA Terarsip / Draft</p>
                    <h4 class="fw-bold mb-0 text-dark" id="stat_arsip"><?= (isset($stats['arsip']) ? $stats['arsip'] : 0) + (isset($stats['draft']) ? $stats['draft'] : 0); ?> <span class="fs-12 text-muted fw-normal">Dokumen</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon cyan flex-shrink-0">
                    <i class="ti ti-file-text"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Format Ekspor</p>
                    <h4 class="fw-bold mb-0 text-dark">Word <span class="fs-12 text-muted fw-normal">.docx (PHPWord)</span></h4>
                </div>
            </div>
        </div>
    </div>
</section>