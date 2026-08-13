<!-- Toast Container (Top Right Placement Referencing auth/signin.php) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
    <div id="toastNotification" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2.5 p-3">
                <i id="toastIcon" class="fs-22 me-1"></i>
                <div>
                    <strong id="toastTitle" class="d-block fs-13 fw-bold mb-0.5"></strong>
                    <span id="toastText" class="fs-12 text-white-80"></span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/pegawai/header-banner'); ?>
<?php $this->load->view('admin/partials/pegawai/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Referensi</span>
                <h4 class="fw-bold text-dark mb-0">Daftar Pegawai Aktif</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tablePegawai" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIP</th>
                        <th>Foto & Nama Pegawai</th>
                        <th>Pangkat / Gol.</th>
                        <th>Jabatan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pegawai_list)): ?>
                        <?php $no = 1; foreach ($pegawai_list as $row): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td class="fw-medium text-dark"><?= html_escape($row['nip']); ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($row['foto']) && file_exists(FCPATH . $row['foto'])): ?>
                                            <img src="<?= base_url($row['foto']); ?>" alt="<?= html_escape($row['nama']); ?>" class="rounded-circle border shadow-sm flex-shrink-0" style="width: 38px; height: 38px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div>
                                            <strong class="d-block text-dark fs-13"><?= html_escape($row['nama']); ?></strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fs-13 text-dark"><?= html_escape($row['pangkat']); ?></span>
                                    <small class="d-block text-muted fs-11">Gol. <?= html_escape($row['golongan']); ?></small>
                                </td>
                                <td><?= html_escape($row['jabatan']); ?></td>
                                <td>
                                    <?php if ($row['kategori'] === 'Hakim'): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">Hakim</span>
                                    <?php elseif ($row['kategori'] === 'Panitera Pengganti'): ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-11">Panitera Pengganti</span>
                                    <?php elseif ($row['kategori'] === 'Jurusita'): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11">Jurusita</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-11">Staf</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ((int)$row['aktif'] === 1): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-subtle-info btn-detail-pegawai p-1 px-2"
                                                title="Detail Pegawai"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailPegawai"
                                                data-id="<?= $row['id_pegawai']; ?>"
                                                data-nip="<?= html_escape($row['nip']); ?>"
                                                data-nama="<?= html_escape($row['nama']); ?>"
                                                data-pangkat="<?= html_escape($row['pangkat']); ?>"
                                                data-golongan="<?= html_escape($row['golongan']); ?>"
                                                data-jabatan="<?= html_escape($row['jabatan']); ?>"
                                                data-kategori="<?= html_escape($row['kategori']); ?>"
                                                data-foto="<?= (!empty($row['foto']) && file_exists(FCPATH . $row['foto'])) ? base_url($row['foto']) : ''; ?>">
                                            <i class="ti ti-eye fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-pegawai p-1 px-2"
                                                title="Edit Pegawai"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditPegawai"
                                                data-id="<?= $row['id_pegawai']; ?>"
                                                data-nip="<?= html_escape($row['nip']); ?>"
                                                data-nama="<?= html_escape($row['nama']); ?>"
                                                data-pangkat="<?= html_escape($row['pangkat']); ?>"
                                                data-golongan="<?= html_escape($row['golongan']); ?>"
                                                data-jabatan="<?= html_escape($row['jabatan']); ?>"
                                                data-kategori="<?= html_escape($row['kategori']); ?>"
                                                data-foto="<?= (!empty($row['foto']) && file_exists(FCPATH . $row['foto'])) ? base_url($row['foto']) : ''; ?>">
                                            <i class="ti ti-edit fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-pegawai p-1 px-2"
                                                title="Hapus Pegawai"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusPegawai"
                                                data-id="<?= $row['id_pegawai']; ?>"
                                                data-nama="<?= html_escape($row['nama']); ?>">
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
<?php $this->load->view('admin/partials/pegawai/modal-add'); ?>
<?php $this->load->view('admin/partials/pegawai/modal-edit'); ?>
<?php $this->load->view('admin/partials/pegawai/modal-detail'); ?>
<?php $this->load->view('admin/partials/pegawai/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/pegawai/script-init'); ?>
