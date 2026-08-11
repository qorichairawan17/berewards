<!-- 4 KPI Summary Cards for Migration Status -->
<section class="row g-3 mb-4" aria-label="Statistik Migrasi Database">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3.5 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary-subtle text-primary p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="ti ti-file-code fs-22"></i>
                </div>
                <div>
                    <span class="text-muted fs-11 d-block mb-0">Total Berkas Migrasi</span>
                    <h4 class="fw-bold mb-0 text-dark"><?= count($migration_files); ?> <span class="fs-11 text-muted fw-normal">File</span></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3.5 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-info-subtle text-info p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="ti ti-versions fs-22"></i>
                </div>
                <div>
                    <span class="text-muted fs-11 d-block mb-0">Versi Skema Aktif</span>
                    <h4 class="fw-bold mb-0 text-dark">v<?= $current_version; ?> <span class="fs-11 text-muted fw-normal">Current</span></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3.5 d-flex align-items-center gap-3">
                <div class="rounded-3 <?= $employee_table_exists ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?> p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="ti <?= $employee_table_exists ? 'ti-table-check' : 'ti-table-off'; ?> fs-22"></i>
                </div>
                <div>
                    <span class="text-muted fs-11 d-block mb-0">Tabel employee_data</span>
                    <h4 class="fw-bold mb-0 text-dark">
                        <?php if ($employee_table_exists): ?>
                            <span class="badge bg-success rounded-pill px-2 py-1 fs-11">Terbentuk (<?= $employee_count; ?> Record)</span>
                        <?php else: ?>
                            <span class="badge bg-danger rounded-pill px-2 py-1 fs-11">Belum Terbentuk</span>
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3.5 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-secondary-subtle text-secondary p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="ti ti-database fs-22"></i>
                </div>
                <div>
                    <span class="text-muted fs-11 d-block mb-0">Database Driver</span>
                    <h4 class="fw-bold mb-0 text-dark"><?= strtoupper(html_escape($db_driver)); ?> <span class="fs-11 text-muted fw-normal">(<?= html_escape($db_name); ?>)</span></h4>
                </div>
            </div>
        </div>
    </div>
</section>
