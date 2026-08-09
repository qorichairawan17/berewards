<?php $this->load->view('admin/partials/user/header-banner'); ?>
<?php $this->load->view('admin/partials/user/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Pengaturan</span>
                <h4 class="fw-bold text-dark mb-0">Daftar Pengguna Sistem SPK BeRewards</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tableUser" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Username & Nama</th>
                        <th>Email Instansi</th>
                        <th>Hak Akses Role</th>
                        <th>Login Terakhir</th>
                        <th>Status</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($user_list)): ?>
                        <?php $no = 1; foreach ($user_list as $row): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['nama_user']); ?></strong>
                                    <small class="text-muted fs-11">@<?= html_escape($row['username']); ?></small>
                                </td>
                                <td><?= html_escape($row['email']); ?></td>
                                <td>
                                    <?php if ($row['role'] === 'Superadmin'): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-11">Superadmin</span>
                                    <?php elseif ($row['role'] === 'Pimpinan'): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11">Pimpinan</span>
                                    <?php elseif ($row['role'] === 'Tim Penilai'): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">Tim Penilai</span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-11">Administrator</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-dark fw-medium d-block"><?= date('d M Y H:i', strtotime($row['last_login'])); ?></small>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 1): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-subtle-info btn-detail-user p-1 px-2"
                                                title="Profil User"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailUser"
                                                data-id="<?= $row['id_user']; ?>"
                                                data-username="<?= html_escape($row['username']); ?>"
                                                data-nama="<?= html_escape($row['nama_user']); ?>"
                                                data-email="<?= html_escape($row['email']); ?>"
                                                data-role="<?= html_escape($row['role']); ?>"
                                                data-status="<?= $row['status']; ?>"
                                                data-login="<?= date('d M Y H:i', strtotime($row['last_login'])); ?>">
                                            <i class="ti ti-eye fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-user p-1 px-2"
                                                title="Edit User"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditUser"
                                                data-id="<?= $row['id_user']; ?>"
                                                data-username="<?= html_escape($row['username']); ?>"
                                                data-nama="<?= html_escape($row['nama_user']); ?>"
                                                data-email="<?= html_escape($row['email']); ?>"
                                                data-role="<?= html_escape($row['role']); ?>"
                                                data-status="<?= $row['status']; ?>">
                                            <i class="ti ti-edit fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-user p-1 px-2"
                                                title="Hapus / Nonaktifkan User"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusUser"
                                                data-id="<?= $row['id_user']; ?>"
                                                data-nama="<?= html_escape($row['nama_user']); ?>">
                                            <i class="ti ti-trash fs-15"></i>
                                        </button>
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

<!-- Modals -->
<?php $this->load->view('admin/partials/user/modal-add'); ?>
<?php $this->load->view('admin/partials/user/modal-edit'); ?>
<?php $this->load->view('admin/partials/user/modal-detail'); ?>
<?php $this->load->view('admin/partials/user/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/user/script-init'); ?>
