<!-- Statistic Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Pengguna">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-users"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Total Pengguna</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_user']) ? (int)$stats['total_user'] : count($user_list); ?> <span class="fs-12 text-muted fw-normal">Akun</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon cyan flex-shrink-0">
                    <i class="ti ti-shield"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Administrator & Superadmin</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_admin']) ? (int)$stats['total_admin'] : 0; ?> <span class="fs-12 text-muted fw-normal">User</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-user-check"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Tim Penilai & Pimpinan</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_penilai']) ? (int)$stats['total_penilai'] : 0; ?> <span class="fs-12 text-muted fw-normal">User</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon green flex-shrink-0">
                    <i class="ti ti-check font-bold"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Status Aktif</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_aktif']) ? (int)$stats['total_aktif'] : 0; ?> <span class="fs-12 text-muted fw-normal">Akun</span></h4>
                </div>
            </div>
        </div>
    </div>
</section>
