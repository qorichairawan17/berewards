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
                        <th>Nama Pegawai</th>
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
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['nama']); ?></strong>
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
                                    <span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>
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
                                                data-kategori="<?= html_escape($row['kategori']); ?>">
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
                                                data-kategori="<?= html_escape($row['kategori']); ?>">
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
