<?php $this->load->view('admin/partials/audit/header-banner'); ?>
<?php $this->load->view('admin/partials/audit/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Log Histori System</span>
                <h4 class="fw-bold text-dark mb-0">Audit Trail Transaksi Pengguna</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tableAudit" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 140px;">Waktu Log</th>
                        <th>Pengguna & Role</th>
                        <th>Modul</th>
                        <th>Aktivitas Audit</th>
                        <th>Alamat IP</th>
                        <th class="text-center">Status</th>
                        <th style="width: 90px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($audit_list)): ?>
                        <?php foreach ($audit_list as $row): ?>
                            <?php 
                                $tipe_aksi = !empty($row['tipe_aksi']) ? strtoupper($row['tipe_aksi']) : 'ACTIVITY';
                                $badge_action = 'bg-secondary-subtle text-secondary border-secondary-subtle';
                                if ($tipe_aksi === 'INSERT') {
                                    $badge_action = 'bg-success-subtle text-success border-success-subtle';
                                } elseif ($tipe_aksi === 'UPDATE') {
                                    $badge_action = 'bg-warning-subtle text-warning border-warning-subtle';
                                } elseif ($tipe_aksi === 'DELETE') {
                                    $badge_action = 'bg-danger-subtle text-danger border-danger-subtle';
                                } elseif ($tipe_aksi === 'LOGIN') {
                                    $badge_action = 'bg-info-subtle text-info border-info-subtle';
                                } elseif ($tipe_aksi === 'LOGOUT') {
                                    $badge_action = 'bg-dark-subtle text-dark border-dark-subtle';
                                } elseif (in_array($tipe_aksi, array('PROSES_TOPSIS', 'EXPORT'))) {
                                    $badge_action = 'bg-primary-subtle text-primary border-primary-subtle';
                                }
                                $has_diff = !empty($row['data_sebelum']) || !empty($row['data_sesudah']);
                            ?>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark fs-12"><?= date('d M Y', strtotime($row['timestamp'])); ?></strong>
                                    <small class="text-muted fs-11"><i class="ti ti-clock me-1"></i><?= date('H:i:s', strtotime($row['timestamp'])); ?> WIB</small>
                                </td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape(!empty($row['nama_user']) ? $row['nama_user'] : $row['username']); ?></strong>
                                    <small class="text-muted fs-11">@<?= html_escape($row['username']); ?> • <span class="badge bg-light text-muted border px-1.5 py-0.5"><?= html_escape($row['role']); ?></span></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 d-inline-block mb-1">
                                        <?= html_escape($row['modul']); ?>
                                    </span>
                                    <br>
                                    <span class="badge <?= $badge_action; ?> border px-1.5 py-0.5 fs-10 fw-bold">
                                        <?= html_escape($tipe_aksi); ?>
                                    </span>
                                    <?php if ($has_diff): ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-1.5 py-0.5 fs-10 ms-1" title="Terdapat Rincian Perubahan Nilai">
                                            <i class="ti ti-arrows-diff me-0.5"></i>Diff
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="fs-13 text-dark text-break"><?= html_escape($row['aktivitas']); ?></span>
                                    <?php if (!empty($row['tabel_terkait'])): ?>
                                        <small class="d-block text-muted fs-11 mt-1">
                                            <i class="ti ti-database me-1"></i>Tabel: <code><?= html_escape($row['tabel_terkait']); ?></code>
                                            <?php if (!empty($row['id_record'])): ?>
                                                (ID: <?= html_escape($row['id_record']); ?>)
                                            <?php endif; ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-dark text-white px-2 py-1 fs-11"><?= html_escape($row['ip_address']); ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] === 'Sukses'): ?>
                                        <span class="badge bg-success rounded-pill px-2.5 py-1 fs-10"><i class="ti ti-check me-1"></i>Sukses</span>
                                    <?php elseif ($row['status'] === 'Peringatan'): ?>
                                        <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fs-10"><i class="ti ti-alert-triangle me-1"></i>Peringatan</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger rounded-pill px-2.5 py-1 fs-10"><i class="ti ti-x me-1"></i>Gagal</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-subtle-info btn-detail-audit p-1 px-2.5 shadow-sm" title="Rincian Audit"
                                        data-id="<?= $row['id_audit']; ?>">
                                        <i class="ti ti-eye fs-14 me-1"></i>Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modals -->
<?php $this->load->view('admin/partials/audit/modal-detail'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/audit/script-init'); ?>