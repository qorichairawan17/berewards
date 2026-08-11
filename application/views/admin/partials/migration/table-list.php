<!-- DataTables / List Migration Files Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Pengelola Skema</span>
                <h4 class="fw-bold text-dark mb-0">Daftar Berkas Migrasi Skema Database</h4>
            </div>
            <button type="button" class="btn btn-sm btn-subtle-info fw-semibold px-3 btn-check-db-status">
                <i class="ti ti-refresh me-1"></i> Cek Status Terkini MySQL
            </button>
        </div>

        <div class="table-responsive">
            <table id="tableMigrations" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama File Migrasi</th>
                        <th>Target Tabel Database</th>
                        <th>Deskripsi Skema</th>
                        <th>Status Eksekusi</th>
                        <th style="width: 220px;" class="text-center">Aksi Migrasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($migration_files)): ?>
                        <?php $no = 1; foreach ($migration_files as $row): ?>
                            <?php 
                                $is_executed = ($current_version >= $row['version'] && $employee_table_exists); 
                            ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <strong class="d-block text-dark font-monospace fs-13"><?= html_escape($row['file_name']); ?></strong>
                                    <small class="text-muted fs-11">Class: <?= html_escape($row['class_name']); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 font-monospace fs-12">
                                        <i class="ti ti-table me-1"></i><?= html_escape($row['target_table']); ?>
                                    </span>
                                </td>
                                <td class="fs-12 text-muted" style="white-space: normal; min-width: 260px;">
                                    <?= html_escape($row['description']); ?>
                                </td>
                                <td>
                                    <?php if ($is_executed): ?>
                                        <span class="badge bg-success rounded-pill px-2.5 py-1 fs-11">
                                            <i class="ti ti-circle-check me-1"></i>Terbentuk (v<?= $row['version']; ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-2.5 py-1 fs-11">
                                            <i class="ti ti-clock me-1"></i>Belum Dieksekusi
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <?php if (!$is_executed): ?>
                                            <button type="button" class="btn btn-sm btn-success fw-semibold btn-run-migration p-1.5 px-3"
                                                    data-version="<?= $row['version']; ?>"
                                                    data-filename="<?= html_escape($row['file_name']); ?>"
                                                    data-table="<?= html_escape($row['target_table']); ?>"
                                                    title="Jalankan Migrasi (UP) untuk membuat tabel <?= html_escape($row['target_table']); ?>">
                                                <i class="ti ti-player-play me-1"></i> Jalankan UP
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger fw-semibold btn-rollback-migration p-1.5 px-3"
                                                    data-filename="<?= html_escape($row['file_name']); ?>"
                                                    data-table="<?= html_escape($row['target_table']); ?>"
                                                    title="Rollback (DOWN) untuk menghapus tabel <?= html_escape($row['target_table']); ?>">
                                                <i class="ti ti-rotate-dot me-1"></i> Rollback DOWN
                                            </button>
                                        <?php endif; ?>
                                        <a href="<?= site_url('pegawai'); ?>" class="btn btn-sm btn-subtle-info p-1.5 px-2" title="Lihat Tampilan Pegawai">
                                            <i class="ti ti-eye fs-15"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
