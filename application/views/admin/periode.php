<?php $this->load->view('admin/partials/periode/header-banner'); ?>
<?php $this->load->view('admin/partials/periode/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Referensi</span>
                <h4 class="fw-bold text-dark mb-0">Master Periode Penilaian Reward</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tablePeriode" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Periode</th>
                        <th>Jenis Siklus</th>
                        <th>Tahun</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($periode_list)): ?>
                        <?php $no = 1; foreach ($periode_list as $row): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['nama_periode']); ?></strong>
                                    <small class="text-muted fs-11"><?= html_escape($row['keterangan']); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 text-uppercase"><?= html_escape($row['jenis_periode']); ?></span>
                                </td>
                                <td class="fw-semibold text-dark"><?= html_escape($row['tahun']); ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal_mulai'])); ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal_selesai'])); ?></td>
                                <td>
                                    <?php if ($row['status'] === 'buka'): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10"><i class="ti ti-lock-open me-1"></i>Buka</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-2 py-1 fs-10"><i class="ti ti-lock me-1"></i>Tutup</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-subtle-info btn-detail-periode p-1 px-2"
                                                title="Detail Periode"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailPeriode"
                                                data-id="<?= $row['id_periode']; ?>"
                                                data-nama="<?= html_escape($row['nama_periode']); ?>"
                                                data-jenis="<?= html_escape($row['jenis_periode']); ?>"
                                                data-tahun="<?= html_escape($row['tahun']); ?>"
                                                data-mulai="<?= date('d M Y', strtotime($row['tanggal_mulai'])); ?>"
                                                data-selesai="<?= date('d M Y', strtotime($row['tanggal_selesai'])); ?>"
                                                data-status="<?= html_escape($row['status']); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan']); ?>">
                                            <i class="ti ti-eye fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-periode p-1 px-2"
                                                title="Edit Periode"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditPeriode"
                                                data-id="<?= $row['id_periode']; ?>"
                                                data-nama="<?= html_escape($row['nama_periode']); ?>"
                                                data-jenis="<?= html_escape($row['jenis_periode']); ?>"
                                                data-tahun="<?= html_escape($row['tahun']); ?>"
                                                data-mulai="<?= html_escape($row['tanggal_mulai']); ?>"
                                                data-selesai="<?= html_escape($row['tanggal_selesai']); ?>"
                                                data-status="<?= html_escape($row['status']); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan']); ?>">
                                            <i class="ti ti-edit fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-periode p-1 px-2"
                                                title="Hapus Periode"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusPeriode"
                                                data-id="<?= $row['id_periode']; ?>"
                                                data-nama="<?= html_escape($row['nama_periode']); ?>">
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
<?php $this->load->view('admin/partials/periode/modal-add'); ?>
<?php $this->load->view('admin/partials/periode/modal-edit'); ?>
<?php $this->load->view('admin/partials/periode/modal-detail'); ?>
<?php $this->load->view('admin/partials/periode/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/periode/script-init'); ?>
