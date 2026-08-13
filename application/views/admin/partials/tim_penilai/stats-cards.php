<!-- Statistic Cards Tim Penilai -->
<section class="row g-3 mb-4" aria-label="Statistik SK Tim Penilai">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Total SK Terbit</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= isset($stats['total_sk']) ? (int)$stats['total_sk'] : count($sk_list); ?> <small class="fs-12 text-muted font-normal">dokumen</small></h3>
                    <span class="text-primary fs-11 fw-medium"><i class="ti ti-file-text me-1"></i> Terarsip</span>
                </div>
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-file-certificate"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Tim Penilai Aktif</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= isset($stats['sk_aktif']) ? (int)$stats['sk_aktif'] : 0; ?> <small class="fs-12 text-muted font-normal">SK Aktif</small></h3>
                    <span class="text-success fs-11 fw-medium"><i class="ti ti-circle-check me-1"></i> Status Aktif</span>
                </div>
                <div class="kpi-icon green flex-shrink-0">
                    <i class="ti ti-user-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Total Personel Tim</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= isset($stats['total_personel']) ? (int)$stats['total_personel'] : 0; ?> <small class="fs-12 text-muted font-normal">orang</small></h3>
                    <span class="text-info fs-11 fw-medium"><i class="ti ti-users me-1"></i> Ketua & Anggota</span>
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
                    <span class="text-muted fs-11 text-uppercase fw-semibold tracking-wider">Dokumen SK PDF</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= isset($stats['pdf_uploaded']) ? (int)$stats['pdf_uploaded'] : 0; ?> <small class="fs-12 text-muted font-normal">terupload</small></h3>
                    <span class="text-warning fs-11 fw-medium"><i class="ti ti-check me-1"></i> PDF Resmi</span>
                </div>
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-file-check"></i>
                </div>
            </div>
        </div>
    </div>
</section>
