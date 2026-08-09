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
                            <tr>
                                <td>
                                    <strong class="d-block text-dark fs-12"><?= date('d M Y', strtotime($row['timestamp'])); ?></strong>
                                    <small class="text-muted fs-11"><?= date('H:i:s', strtotime($row['timestamp'])); ?></small>
                                </td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['nama_user']); ?></strong>
                                    <small class="text-muted fs-11">@<?= html_escape($row['username']); ?> • <?= html_escape($row['role']); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11"><?= html_escape($row['modul']); ?></span>
                                </td>
                                <td>
                                    <span class="fs-13 text-dark"><?= html_escape($row['aktivitas']); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-dark text-white px-2 py-1 fs-11"><?= html_escape($row['ip_address']); ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] === 'Sukses'): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10"><i class="ti ti-check me-1"></i>Sukses</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger rounded-pill px-2 py-1 fs-10"><i class="ti ti-x me-1"></i>Gagal</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-subtle-info btn-detail-audit p-1 px-2"
                                            title="Rincian Audit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAudit"
                                            data-id="<?= $row['id_audit']; ?>"
                                            data-timestamp="<?= date('d M Y H:i:s', strtotime($row['timestamp'])); ?>"
                                            data-username="<?= html_escape($row['username']); ?>"
                                            data-nama="<?= html_escape($row['nama_user']); ?>"
                                            data-role="<?= html_escape($row['role']); ?>"
                                            data-modul="<?= html_escape($row['modul']); ?>"
                                            data-aktivitas="<?= html_escape($row['aktivitas']); ?>"
                                            data-ip="<?= html_escape($row['ip_address']); ?>"
                                            data-status="<?= html_escape($row['status']); ?>">
                                        <i class="ti ti-eye fs-15"></i> Detail
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
<?php $this->load->view('admin/partials/audit/modal-add'); ?>
<?php $this->load->view('admin/partials/audit/modal-detail'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/audit/script-init'); ?>
