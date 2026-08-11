<!-- Sidebar Right: Court ID Badge & Leadership Summary -->
<aside class="col-lg-4">
    <!-- Official Court ID Card -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden position-relative"
        style="background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%);">
        <div class="card-body p-4 text-white position-relative">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="<?= base_url($satker['logo']); ?>" alt="Logo" height="28" class="rounded">
                    <span class="fw-bold fs-12 text-uppercase tracking-wider">MARI &bull; PN LUBUK PAKAM</span>
                </div>
                <span
                    class="badge bg-primary bg-opacity-20 text-white border border-white border-opacity-25 fs-10"><?= html_escape($satker['kelas_pengadilan']); ?></span>
            </div>

            <div class="text-center py-2">
                <div class="avatar-xl rounded-circle bg-white p-2 shadow mx-auto mb-2 d-flex align-items-center justify-content-center"
                    style="width: 76px; height: 76px;">
                    <img src="<?= base_url($satker['logo']); ?>" alt="Logo Satker" class="img-fluid rounded" style="max-height: 60px;">
                </div>
                <h5 class="fw-bold text-white mb-0 fs-15"><?= html_escape($satker['nama_satker']); ?></h5>
                <small class="text-white text-opacity-75 fs-11 d-block mb-2">Kode Satker: <strong><?= html_escape($satker['kode_satker']); ?></strong>
                    &bull; Wilayah: <strong><?= html_escape($satker['kode_wilayah']); ?></strong></small>
                <span class="badge bg-primary text-white border border-primary-subtle px-3 py-1 fs-11">
                    <?= html_escape($satker['pengadilan_tinggi']); ?>
                </span>
            </div>

            <div class="mt-3 pt-3 border-top border-white border-opacity-15 fs-11 text-white text-opacity-80">
                <div class="d-flex justify-content-between mb-1">
                    <span>Telepon:</span>
                    <strong class="text-white"><?= html_escape($satker['telepon']); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span>Email:</span>
                    <strong class="text-white"><?= html_escape($satker['email']); ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Website:</span>
                    <strong class="text-white"><?= html_escape($satker['website']); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Pejabat Penandatangan Card -->
    <div class="card panel-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom border-light p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-users text-primary fs-18"></i>
                <h6 class="fw-bold text-dark mb-0">Pimpinan & Panitera Serta Sekretaris</h6>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="d-flex flex-column gap-3">

                <!-- KETUA -->
                <div class="p-2 rounded bg-light border d-flex align-items-center gap-3">
                    <div class="avatar-md rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:40px; height:40px;">
                        K
                    </div>
                    <div class="overflow-hidden">
                        <small class="text-primary fw-bold fs-10 text-uppercase d-block">Ketua Pengadilan</small>
                        <strong class="text-dark fs-12 d-block text-truncate"><?= html_escape($pimpinan['ketua']['nama']); ?></strong>
                        <small class="text-muted fs-11 d-block">NIP. <?= html_escape($pimpinan['ketua']['nip']); ?></small>
                    </div>
                </div>

                <!-- WAKIL KETUA -->
                <div class="p-2 rounded bg-light border d-flex align-items-center gap-3">
                    <div class="avatar-md rounded-circle bg-info-subtle text-info fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:40px; height:40px;">
                        WK
                    </div>
                    <div class="overflow-hidden">
                        <small class="text-info fw-bold fs-10 text-uppercase d-block">Wakil Ketua Pengadilan</small>
                        <strong class="text-dark fs-12 d-block text-truncate"><?= html_escape($pimpinan['wakil_ketua']['nama']); ?></strong>
                        <small class="text-muted fs-11 d-block">NIP. <?= html_escape($pimpinan['wakil_ketua']['nip']); ?></small>
                    </div>
                </div>

                <!-- PANITERA -->
                <div class="p-2 rounded bg-light border d-flex align-items-center gap-3">
                    <div class="avatar-md rounded-circle bg-warning-subtle text-warning fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:40px; height:40px;">
                        P
                    </div>
                    <div class="overflow-hidden">
                        <small class="text-warning fw-bold fs-10 text-uppercase d-block">Panitera Pengadilan</small>
                        <strong class="text-dark fs-12 d-block text-truncate"><?= html_escape($pimpinan['panitera']['nama']); ?></strong>
                        <small class="text-muted fs-11 d-block">NIP. <?= html_escape($pimpinan['panitera']['nip']); ?></small>
                    </div>
                </div>

                <!-- SEKRETARIS -->
                <div class="p-2 rounded bg-light border d-flex align-items-center gap-3">
                    <div class="avatar-md rounded-circle bg-success-subtle text-success fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:40px; height:40px;">
                        S
                    </div>
                    <div class="overflow-hidden">
                        <small class="text-success fw-bold fs-10 text-uppercase d-block">Sekretaris Pengadilan</small>
                        <strong class="text-dark fs-12 d-block text-truncate"><?= html_escape($pimpinan['sekretaris']['nama']); ?></strong>
                        <small class="text-muted fs-11 d-block">NIP. <?= html_escape($pimpinan['sekretaris']['nip']); ?></small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>