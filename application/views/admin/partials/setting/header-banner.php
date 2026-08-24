<!-- Setting Hero Header Banner -->
<div class="card border-0 shadow-lg rounded-3 mb-4 overflow-hidden position-relative">
    <div class="p-4 p-md-5 text-white position-relative" style="background: linear-gradient(135deg, #1E1B4B 0%, #108DFF 50%, #06B6D4 100%);">
        <div class="position-absolute top-0 end-0 p-4 opacity-10 pointer-events-none">
            <i class="ti ti-building-bank" style="font-size: 160px;"></i>
        </div>
        <div class="row align-items-center position-relative z-1 g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <div class="avatar-xxl rounded-circle bg-white p-2 shadow-sm d-flex align-items-center justify-content-center"
                        style="width: 96px; height: 96px;">
                        <img src="<?= base_url($satker['logo']); ?>" alt="Logo Satker" id="bannerLogoImg" class="img-fluid rounded sidebarLogoImg" style="max-height: 76px;">
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"
                        title="Satuan Kerja Aktif"></span>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h3 class="fw-bold text-white mb-0 fs-20" id="bannerSatkerNama"><?= html_escape($satker['nama_satker']); ?></h3>
                    <span class="badge bg-primary bg-opacity-20 text-white border border-white border-opacity-25 px-2 py-1 fs-11" id="bannerSatkerKelas">
                        <i class="ti ti-building me-1"></i><?= html_escape($satker['kelas_pengadilan']); ?>
                    </span>
                    <span class="badge bg-success bg-opacity-20 text-white border border-white border-opacity-25 px-2 py-1 fs-11">
                        <i class="ti ti-check-check me-1"></i>Terkonfigurasi
                    </span>
                </div>
                <p class="text-white text-opacity-85 mb-1 fs-13">
                    <i class="ti ti-key me-1"></i>Kode Satker: <strong id="bannerSatkerKode"><?= html_escape($satker['kode_satker']); ?></strong> &bull;
                    <i class="ti ti-map-pin me-1"></i>Kode Wilayah: <strong id="bannerSatkerWilayah"><?= html_escape($satker['kode_wilayah']); ?></strong>
                </p>
                <small class="text-white text-opacity-75 fs-12">
                    <i class="ti ti-building-community me-1"></i>Bawahan: <span id="bannerSatkerPT"><?= html_escape($satker['pengadilan_tinggi']); ?></span>
                </small>
            </div>
            <div class="col-md-auto ms-auto d-flex gap-2">
                <button type="button" class="btn btn-light btn-sm fw-semibold shadow-sm text-primary px-3"
                    onclick="document.getElementById('setting-tabs-tab-satker').click();">
                    <i class="ti ti-edit me-1"></i> Edit Profil Satker
                </button>
                <button type="button" class="btn btn-outline-light btn-sm fw-semibold px-3"
                    onclick="document.getElementById('setting-tabs-tab-pimpinan').click();">
                    <i class="ti ti-users me-1"></i> Unsur Pimpinan
                </button>
            </div>
        </div>
    </div>
    <div class="card-body bg-white py-3 px-4 border-top border-light">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 text-muted fs-12">
            <div class="d-flex align-items-center gap-3">
                <span><i class="ti ti-map-2 text-primary me-1"></i> <span id="bannerSatkerAlamat"><?= html_escape($satker['alamat']); ?></span></span>
                <span class="d-none d-sm-inline">&bull;</span>
                <span><i class="ti ti-phone text-primary me-1"></i> <span id="bannerSatkerTelepon"><?= html_escape($satker['telepon']); ?></span></span>
            </div>
            <div>
                <i class="ti ti-world text-primary me-1"></i> Website: <strong class="text-dark" id="bannerSatkerWebsite"><?= html_escape($satker['website']); ?></strong>
            </div>
        </div>
    </div>
</div>