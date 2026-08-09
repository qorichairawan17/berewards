<?php $this->load->view('admin/partials/penilaian/header-banner'); ?>
<?php $this->load->view('admin/partials/penilaian/stats-cards'); ?>

<!-- DataTables Assessment Periods Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Daftar Sesi Penilaian</span>
                <h4 class="fw-bold text-dark mb-0">Periode Penilaian & Perhitungan TOPSIS</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tablePeriodePenilaian" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Nama Periode Penilaian</th>
                        <th>Siklus & Tahun</th>
                        <th class="text-center">Pegawai Terpenilai</th>
                        <th class="text-center">Status</th>
                        <th style="width: 170px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($periode_penilaian_list)): ?>
                        <?php $no = 1; foreach ($periode_penilaian_list as $row): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['nama_periode']); ?></strong>
                                    <small class="text-muted fs-11">Dikalkulasi pada <?= date('d M Y H:i', strtotime($row['tanggal_kalkulasi'])); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 text-uppercase me-1"><?= html_escape($row['jenis_periode']); ?></span>
                                    <span class="fw-semibold text-dark fs-13"><?= html_escape($row['tahun']); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-11">
                                        <i class="ti ti-users me-1"></i><?= $row['jumlah_terpenilai']; ?> Orang
                                    </span>
                                </td>
                                <td class="text-center" id="status_periode_cell_<?= $row['id_periode']; ?>">
                                    <?php if ($row['status_topsis'] === 'Final'): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10"><i class="ti ti-check me-1"></i>Final</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1 fs-10"><i class="ti ti-clock me-1"></i>Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a href="<?= site_url('proses/detail/' . $row['id_periode']); ?>" class="btn btn-sm btn-brand p-1 px-2"
                                            title="Input Nilai Alternative & Proses TOPSIS">
                                            <i class="ti ti-eye fs-15 me-1"></i> Detail
                                        </a>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-penilaian p-1 px-2"
                                            title="Hapus / Reset Penilaian" data-bs-toggle="modal" data-bs-target="#modalHapusPenilaian"
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
<?php $this->load->view('admin/partials/penilaian/modal-add'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-edit'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-detail'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/penilaian/script-init'); ?>