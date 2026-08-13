<!-- Statistic Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Periode">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-calendar"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Total Periode</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_periode']) ? (int)$stats['total_periode'] : count($periode_list); ?> <span class="fs-12 text-muted fw-normal">Siklus</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon green flex-shrink-0">
                    <i class="ti ti-door-enter"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Periode Berjalan</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_buka']) ? (int)$stats['total_buka'] : 0; ?> <span class="fs-12 text-muted fw-normal">Buka</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-lock"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Periode Ditutup</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_tutup']) ? (int)$stats['total_tutup'] : 0; ?> <span class="fs-12 text-muted fw-normal">Selesai</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon cyan flex-shrink-0">
                    <i class="ti ti-history"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Tahun Berjalan</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['tahun_berjalan']) ? (int)$stats['tahun_berjalan'] : date('Y'); ?> <span class="fs-12 text-muted fw-normal">T.A.</span></h4>
                </div>
            </div>
        </div>
    </div>
</section>
