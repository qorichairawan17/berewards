<?php
$total_migrations = !empty($migration_files) ? count($migration_files) : 0;
$executed_migrations = 0;
if (!empty($migration_files)) {
    foreach ($migration_files as $mf) {
        $tbl_exist = ($mf['target_table'] === 'referensi_pegawai') ? $referensi_pegawai_table_exists : (($mf['target_table'] === 'pengaturan') ? $pengaturan_table_exists : (($mf['target_table'] === 'pengguna') ? (isset($pengguna_table_exists) && $pengguna_table_exists) : (($mf['target_table'] === 'tim_penilai_sk') ? (isset($tim_penilai_table_exists) && $tim_penilai_table_exists) : (($mf['target_table'] === 'kriteria') ? (isset($kriteria_table_exists) && $kriteria_table_exists) : (($mf['target_table'] === 'periode') ? (isset($periode_table_exists) && $periode_table_exists) : (($mf['target_table'] === 'topsis_proses') ? (isset($topsis_proses_table_exists) && $topsis_proses_table_exists) : (($mf['target_table'] === 'laporan_ba') ? (isset($laporan_ba_table_exists) && $laporan_ba_table_exists) : (($mf['target_table'] === 'audit_trail') ? (isset($audit_trail_table_exists) && $audit_trail_table_exists) : FALSE))))))));
        if ($current_version >= $mf['version'] && $tbl_exist) {
            $executed_migrations++;
        }
    }
}
$is_all_migrated = ($total_migrations > 0 && $executed_migrations >= $total_migrations);
?>
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
                <div class="rounded-3 <?= $is_all_migrated ? 'bg-success-subtle text-success' : ($executed_migrations > 0 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger'); ?> p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="ti <?= $is_all_migrated ? 'ti-table-check' : ($executed_migrations > 0 ? 'ti-table' : 'ti-table-off'); ?> fs-22"></i>
                </div>
                <div>
                    <span class="text-muted fs-11 d-block mb-0">Status Skema Tabel</span>
                    <h4 class="fw-bold mb-0 text-dark">
                        <?php if ($is_all_migrated): ?>
                            <span class="badge bg-success rounded-pill px-2.5 py-1 fs-11">Lengkap (<?= $executed_migrations; ?>/<?= $total_migrations; ?> Tabel)</span>
                        <?php elseif ($executed_migrations > 0): ?>
                            <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fs-11">Sebagian (<?= $executed_migrations; ?>/<?= $total_migrations; ?> Tabel)</span>
                        <?php else: ?>
                            <span class="badge bg-danger rounded-pill px-2.5 py-1 fs-11">Belum Terbentuk (0/<?= $total_migrations; ?>)</span>
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
