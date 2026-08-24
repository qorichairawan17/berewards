<!-- Setting KPI Summary Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Pengaturan Aplikasi">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Identitas Satker</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1 fs-16" id="kpiSatkerShort"><?= html_escape(!empty($satker['singkatan']) ? $satker['singkatan'] : 'PN'); ?></h3>
                    <span class="text-primary fs-11 fw-medium"><i class="ti ti-check me-1"></i><span id="kpiSatkerKode"><?= html_escape($satker['kode_satker']); ?></span></span>
                </div>
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-building-bank"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Unsur Pimpinan</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">4 <small class="fs-12 text-muted font-normal">Pejabat</small></h3>
                    <span class="text-success fs-11 fw-medium"><i class="ti ti-users me-1"></i> Ketua - Sekretaris</span>
                </div>
                <div class="kpi-icon cyan flex-shrink-0">
                    <i class="ti ti-user-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Mesin SPK</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1 fs-16">TOPSIS Engine</h4>
                    <span class="text-warning fs-11 fw-medium"><i class="ti ti-cpu me-1"></i> Standar MA-RI</span>
                </div>
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-cpu"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Status Konfigurasi</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1 fs-16"><?= html_escape($app['status']); ?></h4>
                    <span class="text-success fs-11 fw-medium"><i class="ti ti-circle-check me-1"></i> Siap Digunakan</span>
                </div>
                <div class="kpi-icon green flex-shrink-0">
                    <i class="ti ti-shield-check"></i>
                </div>
            </div>
        </div>
    </div>
</section>