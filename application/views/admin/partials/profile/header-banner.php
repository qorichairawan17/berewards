<!-- Profile Hero Header Banner -->
<div class="card border-0 shadow-lg rounded-3 mb-4 overflow-hidden position-relative">
    <!-- Header Cover Background Gradient -->
    <div class="p-4 p-md-5 text-white position-relative" style="background: linear-gradient(135deg, #1E1B4B 0%, #108DFF 50%, #06B6D4 100%);">
        <div class="position-absolute top-0 end-0 p-4 opacity-10 pointer-events-none">
            <i class="ti ti-user-check" style="font-size: 160px;"></i>
        </div>
        <div class="row align-items-center position-relative z-1 g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <div class="avatar-xxl rounded-circle bg-white p-1 shadow-sm d-flex align-items-center justify-content-center"
                        style="width: 96px; height: 96px;">
                        <div
                            class="w-100 h-100 rounded-circle bg-primary bg-opacity-10 text-primary fw-bold display-6 d-flex align-items-center justify-content-center border border-primary border-opacity-25">
                            SA
                        </div>
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"
                        title="Status Akun Aktif"></span>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h3 class="fw-bold text-white mb-0 fs-20"><?= html_escape($user['nama_lengkap']); ?></h3>
                    <span class="badge bg-primary bg-opacity-20 text-white border border-white border-opacity-25 px-2 py-1 fs-11">
                        <i class="ti ti-shield-check me-1"></i><?= html_escape($user['role']); ?>
                    </span>
                    <span class="badge bg-success bg-opacity-20 text-white border border-white border-opacity-25 px-2 py-1 fs-11">
                        <i class="ti ti-circle-check me-1"></i><?= html_escape($user['status_akun']); ?>
                    </span>
                </div>
                <p class="text-white text-opacity-85 mb-1 fs-13">
                    <i class="ti ti-id me-1"></i>NIP. <?= html_escape($user['nip']); ?> &bull;
                    <i class="ti ti-briefcase me-1"></i><?= html_escape($user['jabatan']); ?>
                </p>
                <small class="text-white text-opacity-75 fs-12">
                    <i class="ti ti-building-bank me-1"></i><?= html_escape($user['unit_kerja']); ?>
                </small>
            </div>
            <div class="col-md-auto ms-auto d-flex gap-2">
                <button type="button" class="btn btn-light btn-sm fw-semibold shadow-sm text-primary px-3"
                    onclick="document.getElementById('profile-tabs-tab-edit').click();">
                    <i class="ti ti-edit me-1"></i> Edit Profil
                </button>
                <button type="button" class="btn btn-outline-light btn-sm fw-semibold px-3"
                    onclick="document.getElementById('profile-tabs-tab-security').click();">
                    <i class="ti ti-lock me-1"></i> Keamanan
                </button>
            </div>
        </div>
    </div>
    <div class="card-body bg-white py-3 px-4 border-top border-light">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 text-muted fs-12">
            <div class="d-flex align-items-center gap-3">
                <span><i class="ti ti-mail text-primary me-1"></i> <?= html_escape($user['email']); ?></span>
                <span class="d-none d-sm-inline">&bull;</span>
                <span><i class="ti ti-phone text-primary me-1"></i> <?= html_escape($user['no_hp']); ?></span>
            </div>
            <div>
                <i class="ti ti-clock text-primary me-1"></i> Login Terakhir: <strong
                    class="text-dark"><?= date('d M Y, H:i', strtotime($user['last_login'])); ?> WIB</strong>
            </div>
        </div>
    </div>
</div>