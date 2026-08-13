<?php
if (!isset($settings)) {
    $this->load->service('setting_service');
    $settings = $this->setting_service->get_settings();
}
$satker_nama = isset($settings['nama_satker']) ? $settings['nama_satker'] : 'Pengadilan Negeri Lubuk Pakam Kelas I-A';
$satker_logo = isset($settings['logo']) && !empty($settings['logo']) ? base_url($settings['logo']) : base_url('assets/icons/logo.png');
?>

<!-- Toast Container (Top Right Placement Referencing auth/signin.php) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
    <div id="toastNotification" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive"
        aria-atomic="true">
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

<!-- Header Top Navigation -->
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column justify-content-between gap-3 mb-3">
    <div>
        <a href="<?= site_url('timpenilai'); ?>" class="btn btn-sm btn-light text-primary fw-semibold mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar SK Tim Penilai
        </a>
        <h3 class="fw-bold text-dark mb-0 fs-20">Rincian Personel & Dokumen SK Tim Penilai</h3>
        <p class="text-muted fs-13 mb-0">Surat Keputusan Ketua <?= html_escape($satker_nama); ?> tentang Pembentukan Tim Penilai TOPSIS.</p>
    </div>
</div>

<!-- Header Card SK Metadata -->
<div class="card border-0 shadow-lg rounded-3 mb-4 overflow-hidden position-relative"
    style="background: linear-gradient(135deg, #1E1B4B 0%, #108DFF 50%, #06B6D4 100%);">
    <div class="card-body p-4 text-white position-relative">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
            <span class="badge bg-primary bg-opacity-20 text-white border border-white border-opacity-25 px-3 py-1 fs-11">
                <i class="ti ti-calendar me-1"></i>Tahun Evaluasi <?= html_escape($sk_info['tahun']); ?>
            </span>
            <?php if ($sk_info['status'] === 'Aktif'): ?>
                <span class="badge bg-success text-white border border-white border-opacity-25 px-3 py-1 fs-11">
                    <i class="ti ti-circle-check me-1"></i>
                    SK Aktif Berjalan
                </span>
            <?php elseif ($sk_info['status'] === 'Selesai'): ?>
                <span class="badge bg-info text-white border border-white border-opacity-25 px-3 py-1 fs-11">
                    <i class="ti ti-check-check me-1"></i>
                    Masa Tugas Selesai
                </span>
            <?php else: ?>
                <span class="badge bg-secondary text-white border border-white border-opacity-25 px-3 py-1 fs-11">
                    <i class="ti ti-archive me-1"></i>
                    SK Terarsip
                </span>
            <?php endif; ?>
        </div>

        <h4 class="fw-bold text-white mb-2 fs-20"><?= html_escape($sk_info['no_sk']); ?></h4>
        <p class="text-white text-opacity-90 mb-3 fs-14"><?= html_escape($sk_info['perihal']); ?></p>

        <div class="d-flex flex-wrap align-items-center gap-4 text-white text-opacity-80 fs-12 border-top border-white border-opacity-15 pt-3">
            <div><i class="ti ti-building-bank me-1"></i> Instansi: <strong><?= html_escape($satker_nama); ?></strong></div>
            <div>
                <i class="ti ti-calendar-event me-1"></i> Tanggal Terbit: <strong><?= date('d F Y', strtotime($sk_info['tanggal_sk'])); ?></strong>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Left Column: Pimpinan & Anggota Tim Penilai (Col 8) -->
    <main class="col-lg-8">

        <!-- Pimpinan Tim Penilai Section -->
        <div class="card panel-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom border-light p-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-user-check text-primary fs-18"></i>
                    <h5 class="fw-bold text-dark mb-0 fs-15">Unsur Pimpinan Tim Penilai</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">

                    <!-- KETUA TIM -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100 border-primary border-opacity-25 position-relative">
                            <span class="position-absolute top-0 end-0 m-3 badge bg-primary text-white fs-10">KETUA TIM</span>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-lg rounded-circle bg-primary bg-opacity-10 text-primary fw-bold display-6 d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width:56px; height:56px;">
                                    K
                                </div>
                                <div class="overflow-hidden">
                                    <small class="text-primary fw-bold fs-10 text-uppercase d-block mb-1">Ketua Tim Penilai</small>
                                    <strong
                                        class="text-dark fs-14 d-block text-truncate"><?= !empty($sk_info['ketua']['nama']) ? html_escape($sk_info['ketua']['nama']) : '-'; ?></strong>
                                    <small class="text-muted fs-11 d-block mb-1">NIP.
                                        <?= !empty($sk_info['ketua']['nip']) ? html_escape($sk_info['ketua']['nip']) : '-'; ?></small>
                                    <span
                                        class="badge bg-light text-dark border fs-10"><?= !empty($sk_info['ketua']['jabatan']) ? html_escape($sk_info['ketua']['jabatan']) : '-'; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEKRETARIS TIM -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100 border-success border-opacity-25 position-relative">
                            <span class="position-absolute top-0 end-0 m-3 badge bg-success text-white fs-10">SEKRETARIS</span>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-lg rounded-circle bg-success bg-opacity-10 text-success fw-bold display-6 d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width:56px; height:56px;">
                                    S
                                </div>
                                <div class="overflow-hidden">
                                    <small class="text-success fw-bold fs-10 text-uppercase d-block mb-1">Sekretaris Tim Penilai</small>
                                    <strong
                                        class="text-dark fs-14 d-block text-truncate"><?= !empty($sk_info['sekretaris']['nama']) ? html_escape($sk_info['sekretaris']['nama']) : '-'; ?></strong>
                                    <small class="text-muted fs-11 d-block mb-1">NIP.
                                        <?= !empty($sk_info['sekretaris']['nip']) ? html_escape($sk_info['sekretaris']['nip']) : '-'; ?></small>
                                    <span
                                        class="badge bg-light text-dark border fs-10"><?= !empty($sk_info['sekretaris']['jabatan']) ? html_escape($sk_info['sekretaris']['jabatan']) : '-'; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Daftar Anggota Tim Penilai Table -->
        <div class="card panel-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom border-light p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-users text-primary fs-18"></i>
                    <h5 class="fw-bold text-dark mb-0 fs-15">Daftar Anggota Tim Penilai</h5>
                </div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">
                    <?= !empty($sk_info['anggota']) ? count($sk_info['anggota']) : 0; ?> Anggota Terdaftar
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>Nama & NIP Anggota</th>
                                <th>Jabatan Kedinasan</th>
                                <th>Kategori Penilaian</th>
                                <th style="width: 100px;" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sk_info['anggota'])): ?>
                                <?php $no = 1;
                                foreach ($sk_info['anggota'] as $anggota): ?>
                                    <tr>
                                        <td class="text-center fw-semibold"><?= $no++; ?></td>
                                        <td>
                                            <strong class="d-block text-dark fs-13"><?= html_escape($anggota['nama']); ?></strong>
                                            <small class="text-muted fs-11">NIP. <?= html_escape($anggota['nip']); ?></small>
                                        </td>
                                        <td><?= html_escape($anggota['jabatan']); ?></td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">
                                                <i class="ti ti-check me-1"></i><?= html_escape($anggota['penilaian']); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted fs-13">
                                        <i class="ti ti-info-circle me-1"></i> Belum ada anggota tambahan yang didaftarkan untuk SK ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- Right Column: Document Box & System Status (Col 4) -->
    <aside class="col-lg-4">

        <!-- Dokumen SK File Box Card -->
        <div class="card panel-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom border-light p-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-file-text text-danger fs-18"></i>
                    <h6 class="fw-bold text-dark mb-0">Dokumen Fisik Surat Keputusan</h6>
                </div>
            </div>
            <div class="card-body p-4 text-center">
                <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                    style="width: 72px; height: 72px;">
                    <i class="ti ti-file-type-pdf display-5"></i>
                </div>

                <h6 class="fw-bold text-dark fs-14 mb-1">
                    <?= !empty($sk_info['dokumen_sk']['nama_file']) ? html_escape($sk_info['dokumen_sk']['nama_file']) : 'SK_Tim_Penilai.pdf'; ?>
                </h6>
                <p class="text-muted fs-11 mb-3">
                    Ukuran:
                    <strong><?= !empty($sk_info['dokumen_sk']['ukuran']) ? html_escape($sk_info['dokumen_sk']['ukuran']) : '1.5 MB'; ?></strong>
                    &bull;
                    Diunggah:
                    <strong><?= !empty($sk_info['dokumen_sk']['tgl_upload']) ? date('d M Y', strtotime($sk_info['dokumen_sk']['tgl_upload'])) : date('d M Y'); ?></strong>
                </p>

                <div class="d-grid gap-2">
                    <a href="<?= base_url('assets/templates/sample.pdf'); ?>" target="_blank"
                        onclick="showToast('info', 'Pratinjau Dokumen', 'Membuka pratinjau dokumen PDF SK...');"
                        class="btn btn-outline-danger btn-sm font-medium">
                        <i class="ti ti-eye me-1"></i> Pratinjau Dokumen SK PDF
                    </a>
                    <a href="<?= base_url('assets/templates/sample.pdf'); ?>" download
                        onclick="showToast('success', 'Unduh Dokumen', 'Mengunduh file SK PDF resmi...');"
                        class="btn btn-danger btn-sm font-medium shadow-sm">
                        <i class="ti ti-download me-1"></i> Unduh File Asli (.pdf)
                    </a>
                </div>
            </div>
        </div>

        <!-- Instansi Authority Card -->
        <div class="card panel-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom border-light p-3">
                <h6 class="fw-bold text-dark mb-0 fs-13"><i class="ti ti-shield-check text-primary me-1"></i> Otoritas Penerbitan SK</h6>
            </div>
            <div class="card-body p-3 fs-12 text-muted">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <img src="<?= $satker_logo; ?>" alt="Logo" height="28" class="rounded">
                    <strong class="text-dark"><?= html_escape($satker_nama); ?></strong>
                </div>
                <p class="mb-2">SK ini diterbitkan secara sah oleh Ketua <?= html_escape($satker_nama); ?> sebagai dasar hukum tim penilai dalam
                    menghitung nilai preferensi TOPSIS.</p>
                <div class="p-2 bg-light rounded border text-dark fs-11">
                    <i class="ti ti-check text-success me-1"></i> Berlaku untuk periode penilaian kinerja pegawai.
                </div>
            </div>
        </div>

    </aside>
</div>

<!-- Toast Script Function (Referencing auth/signin.php) -->
<script>
    function showToast(type, title, message) {
        var toastEl = document.getElementById('toastNotification');
        if (!toastEl) return;

        var bgClass = 'bg-primary';
        var iconClass = 'ti ti-info-circle';

        if (type === 'success') {
            bgClass = 'bg-success';
            iconClass = 'ti ti-circle-check';
        } else if (type === 'danger' || type === 'error') {
            bgClass = 'bg-danger';
            iconClass = 'ti ti-alert-circle';
        } else if (type === 'warning') {
            bgClass = 'bg-warning text-dark';
            iconClass = 'ti ti-alert-triangle';
        } else if (type === 'info') {
            bgClass = 'bg-info';
            iconClass = 'ti ti-info-circle';
        }

        toastEl.className = 'toast align-items-center border-0 text-white shadow-lg rounded-3 ' + bgClass;

        var iconEl = document.getElementById('toastIcon');
        var titleEl = document.getElementById('toastTitle');
        var textEl = document.getElementById('toastText');

        if (iconEl) iconEl.className = iconClass + ' fs-22 me-1';
        if (titleEl) titleEl.innerText = title;
        if (textEl) textEl.innerText = message;

        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            var bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
            bsToast.show();
        }
    }
</script>