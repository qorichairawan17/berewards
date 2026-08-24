<!-- Toast Container (Top Right Placement Referencing auth/signin.php) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
    <div id="toastNotification" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2.5 p-3 text-white">
                <i id="toastIcon" class="fs-22 me-1 text-white"></i>
                <div class="text-white">
                    <strong id="toastTitle" class="d-block fs-13 fw-bold mb-0.5 text-white"></strong>
                    <span id="toastText" class="fs-12 text-white"></span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/tim_penilai/header-banner'); ?>
<?php $this->load->view('admin/partials/tim_penilai/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Referensi</span>
                <h4 class="fw-bold text-dark mb-0">Daftar Surat Keputusan (SK) Tim Penilai</h4>
            </div>
            <?php if (!empty($sk_list)): ?>
                <a href="<?= site_url('timpenilai/detail/' . $sk_list[0]['id_sk']); ?>" class="btn btn-sm btn-subtle-info fw-semibold px-3">
                    <i class="ti ti-eye me-1"></i> Lihat Rincian Tim Aktif (<?= html_escape($sk_list[0]['tahun']); ?>)
                </a>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table id="tableTimPenilai" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nomor SK</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th style="width: 170px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sk_list)): ?>
                        <?php $no = 1; foreach ($sk_list as $row): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['no_sk']); ?></strong>
                                    <small class="text-muted fs-11"><?= html_escape($row['perihal']); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 fs-12 fw-bold">
                                        <i class="ti ti-calendar me-1"></i><?= html_escape($row['tahun']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'Aktif'): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10"><i class="ti ti-circle-check me-1"></i>Aktif</span>
                                    <?php elseif ($row['status'] === 'Selesai'): ?>
                                        <span class="badge bg-info rounded-pill px-2 py-1 fs-10"><i class="ti ti-check-check me-1"></i>Selesai</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-2 py-1 fs-10"><i class="ti ti-archive me-1"></i>Arsip</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a href="<?= site_url('timpenilai/detail/' . $row['id_sk']); ?>"
                                           class="btn btn-sm btn-subtle-info p-1 px-2"
                                           title="Rincian Personel Tim & Dokumen SK">
                                            <i class="ti ti-eye fs-15"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-tim p-1 px-2"
                                                title="Edit SK"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditTim"
                                                data-id="<?= $row['id_sk']; ?>"
                                                data-nosk="<?= html_escape($row['no_sk']); ?>"
                                                data-tahun="<?= html_escape($row['tahun']); ?>"
                                                data-tanggal="<?= html_escape($row['tanggal_sk']); ?>"
                                                data-perihal="<?= html_escape($row['perihal']); ?>"
                                                data-status="<?= html_escape($row['status']); ?>"
                                                data-ketua="<?= !empty($row['ketua']['id_pegawai']) ? $row['ketua']['id_pegawai'] : ''; ?>"
                                                data-sekretaris="<?= !empty($row['sekretaris']['id_pegawai']) ? $row['sekretaris']['id_pegawai'] : ''; ?>">
                                            <i class="ti ti-edit fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-tim p-1 px-2"
                                                title="Hapus SK"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusTim"
                                                data-id="<?= $row['id_sk']; ?>"
                                                data-nosk="<?= html_escape($row['no_sk']); ?>">
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
<?php $this->load->view('admin/partials/tim_penilai/modal-add'); ?>
<?php $this->load->view('admin/partials/tim_penilai/modal-edit'); ?>
<?php $this->load->view('admin/partials/tim_penilai/modal-detail'); ?>
<?php $this->load->view('admin/partials/tim_penilai/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/tim_penilai/script-init'); ?>
