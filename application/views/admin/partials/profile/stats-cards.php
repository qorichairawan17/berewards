<!-- Profile KPI Summary Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Pengguna">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Proses TOPSIS</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= $stats['total_proses']; ?> <small class="fs-12 text-muted font-normal">proses</small></h3>
                    <span class="text-success fs-11 fw-medium"><i class="ti ti-arrow-up-right"></i> Terkelola</span>
                </div>
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-cpu"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Pegawai Dinilai</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= $stats['total_pegawai']; ?> <small class="fs-12 text-muted font-normal">orang</small></h3>
                    <span class="text-primary fs-11 fw-medium"><i class="ti ti-users me-1"></i> Alternatif</span>
                </div>
                <div class="kpi-icon cyan flex-shrink-0">
                    <i class="ti ti-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Periode Aktif</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1 fs-16"><?= html_escape($stats['periode_aktif']); ?></h4>
                    <span class="text-warning fs-11 fw-medium"><i class="ti ti-calendar-event me-1"></i> Berjalan</span>
                </div>
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-calendar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Keamanan Akun</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1 fs-16"><?= html_escape($stats['keamanan']); ?></h4>
                    <span class="text-success fs-11 fw-medium"><i class="ti ti-shield-check me-1"></i> Terverifikasi</span>
                </div>
                <div class="kpi-icon green flex-shrink-0">
                    <i class="ti ti-shield-lock"></i>
                </div>
            </div>
        </div>
    </div>
</section>
