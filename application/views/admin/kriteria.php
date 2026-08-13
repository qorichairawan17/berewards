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

<?php $this->load->view('admin/partials/kriteria/header-banner'); ?>
<?php $this->load->view('admin/partials/kriteria/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Referensi</span>
                <h4 class="fw-bold text-dark mb-0">Master Kriteria Penilaian TOPSIS</h4>
            </div>
            <button type="button" class="btn btn-brand px-3 shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahKriteria">
                <i class="ti ti-plus fs-16"></i> Tambah Kriteria Penilaian
            </button>
        </div>

        <div class="table-responsive">
            <table id="tableKriteria" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 100px;">Kode</th>
                        <th>Nama Kriteria</th>
                        <th>Kategori Pegawai</th>
                        <th>Bobot (%)</th>
                        <th>Jenis Data</th>
                        <th>Tipe Atribut</th>
                        <th>Status</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kriteria_list)): ?>
                        <?php $no = 1; foreach ($kriteria_list as $row): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 fs-12 fw-bold"><?= html_escape($row['kode']); ?></span>
                                </td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['nama_kriteria']); ?></strong>
                                </td>
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
                                    <span class="fw-bold text-primary fs-13"><?= number_format($row['bobot'], 2); ?>%</span>
                                </td>
                                <td class="text-capitalize fs-13"><?= html_escape($row['jenis_data']); ?></td>
                                <td>
                                    <?php if ($row['tipe_atribut'] === 'benefit'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-11"><i class="ti ti-trending-up me-1"></i>Benefit</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11"><i class="ti ti-trending-down me-1"></i>Cost</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!isset($row['aktif']) || $row['aktif'] == 1): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-subtle-info btn-detail-kriteria p-1 px-2"
                                                title="Detail Kriteria"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailKriteria"
                                                data-id="<?= $row['id_kriteria']; ?>"
                                                data-kode="<?= html_escape($row['kode']); ?>"
                                                data-nama="<?= html_escape($row['nama_kriteria']); ?>"
                                                data-kategori="<?= html_escape($row['kategori']); ?>"
                                                data-bobot="<?= number_format($row['bobot'], 2); ?>"
                                                data-jenis="<?= html_escape($row['jenis_data']); ?>"
                                                data-tipe="<?= html_escape($row['tipe_atribut']); ?>">
                                            <i class="ti ti-eye fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-kriteria p-1 px-2"
                                                title="Edit Kriteria"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditKriteria"
                                                data-id="<?= $row['id_kriteria']; ?>"
                                                data-kode="<?= html_escape($row['kode']); ?>"
                                                data-nama="<?= html_escape($row['nama_kriteria']); ?>"
                                                data-kategori="<?= html_escape($row['kategori']); ?>"
                                                data-bobot="<?= number_format($row['bobot'], 2); ?>"
                                                data-jenis="<?= html_escape($row['jenis_data']); ?>"
                                                data-tipe="<?= html_escape($row['tipe_atribut']); ?>">
                                            <i class="ti ti-edit fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-kriteria p-1 px-2"
                                                title="Hapus Kriteria"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusKriteria"
                                                data-id="<?= $row['id_kriteria']; ?>"
                                                data-nama="<?= html_escape($row['nama_kriteria']); ?>">
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
<?php $this->load->view('admin/partials/kriteria/modal-add'); ?>
<?php $this->load->view('admin/partials/kriteria/modal-edit'); ?>
<?php $this->load->view('admin/partials/kriteria/modal-detail'); ?>
<?php $this->load->view('admin/partials/kriteria/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/kriteria/script-init'); ?>
