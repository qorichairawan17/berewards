<!-- Toast Container (Top Right Placement) -->
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

<?php $this->load->view('admin/partials/laporan/header-banner'); ?>
<?php $this->load->view('admin/partials/laporan/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Arsip Dokumen</span>
                <h4 class="fw-bold text-dark mb-0">Daftar Berita Acara Penetapan Reward TOPSIS</h4>
            </div>
            <div>
                <button type="button" class="btn btn-brand btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahLaporan">
                    <i class="ti ti-file-plus me-1"></i> Buat Berita Acara
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tableLaporan" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>No. Berita Acara</th>
                        <th>Periode</th>
                        <th>Kategori Pegawai</th>
                        <th>Skor Preferensi (Rank #1)</th>
                        <th>Tanggal Terbit</th>
                        <th>Status</th>
                        <th style="width: 170px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($laporan_list)): ?>
                        <?php $no = 1; foreach ($laporan_list as $row): ?>
                            <tr id="row_laporan_<?= $row['id_laporan']; ?>">
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape($row['no_ba']); ?></strong>
                                    <small class="text-muted fs-11">Ketua: <?= html_escape($row['ketua_panitia']); ?></small>
                                </td>
                                <td><?= html_escape($row['nama_periode']); ?></td>
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
                                    <span class="fw-bold text-primary fs-13"><?= number_format($row['skor_topsis'], 4); ?></span>
                                    <small class="d-block text-muted fs-10"><?= html_escape($row['pemenang_nama']); ?></small>
                                </td>
                                <td><?= date('d M Y', strtotime($row['tanggal_terbit'])); ?></td>
                                <td>
                                    <?php if ($row['status'] === 'Disahkan'): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10"><i class="ti ti-check me-1"></i>Disahkan</span>
                                    <?php elseif ($row['status'] === 'Arsip'): ?>
                                        <span class="badge bg-secondary rounded-pill px-2 py-1 fs-10"><i class="ti ti-archive me-1"></i>Arsip</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1 fs-10"><i class="ti ti-clock me-1"></i>Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-subtle-info btn-detail-laporan p-1 px-2" title="Pratinjau Berita Acara & 3 Kandidat Terbaik"
                                            data-bs-toggle="modal" data-bs-target="#modalDetailLaporan" data-id="<?= $row['id_laporan']; ?>"
                                            data-noba="<?= html_escape($row['no_ba']); ?>" data-periode="<?= html_escape($row['nama_periode']); ?>"
                                            data-pemenang="<?= html_escape($row['pemenang_nama']); ?>" data-nip="<?= html_escape($row['pemenang_nip']); ?>"
                                            data-kategori="<?= html_escape($row['kategori']); ?>" data-skor="<?= number_format((float)$row['skor_topsis'], 4); ?>"
                                            data-tanggal="<?= date('d F Y', strtotime($row['tanggal_terbit'])); ?>"
                                            data-id_sk="<?= !empty($row['id_sk']) ? (int)$row['id_sk'] : ''; ?>"
                                            data-ketua="<?= html_escape($row['ketua_panitia']); ?>"
                                            data-top3="<?= html_escape(json_encode(!empty($row['top_3']) ? $row['top_3'] : array())); ?>">
                                            <i class="ti ti-eye fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-warning-subtle text-warning btn-trigger-showroom p-1 px-2"
                                            title="Pratinjau Showroom 3D TOPSIS"
                                            data-target="laporan_<?= $row['id_laporan']; ?>">
                                            <i class="ti ti-sparkles fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-export-word p-1 px-2"
                                            title="Ekspor Word (.docx)"
                                            data-id="<?= $row['id_laporan']; ?>">
                                            <i class="ti ti-file-text fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-info-subtle text-info btn-edit-laporan p-1 px-2" title="Edit Berita Acara"
                                            data-bs-toggle="modal" data-bs-target="#modalEditLaporan" data-id="<?= $row['id_laporan']; ?>"
                                            data-noba="<?= html_escape($row['no_ba']); ?>" data-status="<?= html_escape($row['status']); ?>"
                                            data-tanggal="<?= html_escape($row['tanggal_terbit']); ?>"
                                            data-id_sk="<?= !empty($row['id_sk']) ? (int)$row['id_sk'] : ''; ?>"
                                            data-ketua="<?= html_escape($row['ketua_panitia']); ?>">
                                            <i class="ti ti-edit fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-laporan p-1 px-2"
                                            title="Hapus / Arsipkan" data-bs-toggle="modal" data-bs-target="#modalHapusLaporan"
                                            data-id="<?= $row['id_laporan']; ?>" data-noba="<?= html_escape($row['no_ba']); ?>">
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
<?php $this->load->view('admin/partials/laporan/modal-preview-select'); ?>
<?php $this->load->view('admin/partials/laporan/modal-showroom'); ?>
<?php $this->load->view('admin/partials/laporan/modal-add'); ?>
<?php $this->load->view('admin/partials/laporan/modal-edit'); ?>
<?php $this->load->view('admin/partials/laporan/modal-detail'); ?>
<?php $this->load->view('admin/partials/laporan/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/laporan/script-init'); ?>