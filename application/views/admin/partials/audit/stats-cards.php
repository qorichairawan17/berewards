<!-- Statistic Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Audit Trail">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-activity"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Total Audit Log</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_logs']) ? number_format((int)$stats['total_logs'], 0, ',', '.') : '0'; ?> <span class="fs-12 text-muted fw-normal">Transaksi</span></h4>
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
                    <p class="text-muted fs-12 mb-0">Log Berhasil (Sukses)</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_sukses']) ? number_format((int)$stats['total_sukses'], 0, ',', '.') : '0'; ?> <span class="fs-12 text-muted fw-normal">Event</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-alert-triangle"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Log Peringatan / Gagal</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_gagal']) ? number_format((int)$stats['total_gagal'], 0, ',', '.') : '0'; ?> <span class="fs-12 text-muted fw-normal">Event</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="kpi-icon cyan flex-shrink-0">
                    <i class="ti ti-user-check"></i>
                </div>
                <div>
                    <p class="text-muted fs-12 mb-0">Pengguna Terlibat</p>
                    <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_user']) ? number_format((int)$stats['total_user'], 0, ',', '.') : '0'; ?> <span class="fs-12 text-muted fw-normal">User</span></h4>
                </div>
            </div>
        </div>
    </div>
</section>
