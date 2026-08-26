<?php
$initials_side = 'SA';
if (!empty($user['nama_lengkap'])) {
    $parts = explode(' ', trim($user['nama_lengkap']));
    $initials_side = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}
$avatar_side = !empty($user['foto']) ? (strpos($user['foto'], 'http') === 0 ? $user['foto'] : base_url($user['foto'])) : NULL;
?>
<!-- Sidebar Right: ID Card Mockup & Activity Security Feed -->
<aside class="col-lg-4">
    <!-- Card ID Pegawai Mockup -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden position-relative"
        style="background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%);">
        <div class="card-body p-4 text-white position-relative">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="<?= base_url('assets/icons/logo.png'); ?>" alt="Logo" height="28" class="rounded">
                    <span class="fw-bold fs-12 text-uppercase tracking-wider">PN Lubuk Pakam</span>
                </div>
                <span class="badge bg-primary bg-opacity-20 text-white border border-white border-opacity-25 fs-10">OFFICIAL ID</span>
            </div>

            <div class="text-center py-2">
                <div class="avatar-xl rounded-circle bg-white p-1 shadow mx-auto mb-2 d-flex align-items-center justify-content-center"
                    style="width: 72px; height: 72px;">
                    <?php if ($avatar_side && file_exists(FCPATH . $user['foto'])): ?>
                        <img src="<?= $avatar_side; ?>" alt="<?= html_escape($user['nama_lengkap']); ?>"
                            class="w-100 h-100 rounded-circle object-fit-cover"
                            onerror="this.onerror=null;this.src='<?= base_url('assets/icons/logo.png'); ?>';">
                    <?php else: ?>
                        <div
                            class="w-100 h-100 rounded-circle bg-primary bg-opacity-10 text-primary fw-bold fs-20 d-flex align-items-center justify-content-center">
                            <?= $initials_side; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <h5 class="fw-bold text-white mb-0 fs-16" id="sidebar_nama_lengkap"><?= html_escape($user['nama_lengkap']); ?></h5>
                <small class="text-white text-opacity-75 fs-11 d-block mb-1">NIP. <span
                        id="sidebar_nip"><?= html_escape($user['nip']); ?></span></small>
                <div class="d-flex flex-wrap justify-content-center gap-1 my-1.5">
                    <span class="badge bg-primary text-white border border-primary-subtle px-2.5 py-0.5 fs-10" id="sidebar_role">
                        <?= html_escape($user['role']); ?>
                    </span>
                    <?php if (!empty($user['kategori']) && $user['kategori'] !== 'Non-Pegawai' && $user['kategori'] !== '-'): ?>
                        <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 px-2.5 py-0.5 fs-10" id="sidebar_kategori">
                            <?= html_escape($user['kategori']); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <small class="text-white text-opacity-90 fs-11 d-block" id="sidebar_jabatan"><?= html_escape($user['jabatan']); ?></small>
            </div>

            <div class="mt-3 pt-3 border-top border-white border-opacity-15 fs-11 text-white text-opacity-80">
                <?php if (!empty($user['pangkat']) && $user['pangkat'] !== '-'): ?>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Pangkat / Gol:</span>
                        <strong class="text-white" id="sidebar_pangkat_gol"><?= html_escape($user['pangkat']); ?> (<?= html_escape($user['golongan']); ?>)</strong>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between mb-1">
                    <span>Satker:</span>
                    <strong class="text-white" id="sidebar_unit_kerja"><?= html_escape($user['unit_kerja']); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span>Status:</span>
                    <strong class="text-success"><i class="ti ti-circle-check me-1"></i>Akun <?= html_escape($user['status_akun']); ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>System ID:</span>
                    <strong class="text-white font-monospace">SPK-USER-<?= str_pad($user['id_user'], 3, '0', STR_PAD_LEFT); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Activity Log Card -->
    <div class="card panel-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom border-light p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-shield-lock text-primary fs-18"></i>
                <h6 class="fw-bold text-dark mb-0">Aktivitas & Login Terakhir</h6>
            </div>
            <a href="<?= site_url('audit'); ?>" class="btn btn-sm btn-light text-primary fs-11 fw-semibold py-1">
                Lihat Semua
            </a>
        </div>
        <div class="card-body p-3">
            <div class="timeline-feed">
                <?php if (!empty($activity_logs)): ?>
                    <?php foreach ($activity_logs as $index => $log): ?>
                        <div class="d-flex align-items-start gap-3 py-2 <?= ($index < count($activity_logs) - 1) ? 'border-bottom border-light' : ''; ?>">
                            <div class="p-2 rounded-circle bg-primary-subtle text-primary mt-1 flex-shrink-0">
                                <i class="ti ti-activity fs-14"></i>
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong class="text-dark fs-12 d-block"><?= html_escape($log['aktivitas']); ?></strong>
                                    <span class="badge bg-success-subtle text-success fs-10 px-1 py-0"><?= html_escape($log['status']); ?></span>
                                </div>
                                <small class="text-muted fs-11 d-block"><i
                                        class="ti ti-clock me-1"></i><?= date('d M Y H:i', strtotime($log['waktu'])); ?></small>
                                <small class="text-muted fs-11 d-block"><i class="ti ti-device-desktop me-1"></i><?= html_escape($log['perangkat']); ?> &bull;
                                    <?= html_escape($log['ip']); ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</aside>