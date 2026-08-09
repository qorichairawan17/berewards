<!-- Welcome Hero Banner -->
<div class="card border-0 shadow-lg rounded-3 mb-4 text-white overflow-hidden"
    style="background: linear-gradient(135deg, #0A2540 0%, #0052CC 40%, #108DFF 100%);">
    <div class="card-body p-4 p-md-5 position-relative">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
            <div style="max-width: 680px;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-warning text-dark font-bold px-2.5 py-1 fs-11 tracking-wider text-uppercase">
                        <i class="ti ti-crown me-1"></i> Pengadilan Negeri Lubuk Pakam Kelas I-A
                    </span>
                    <span class="badge bg-primary bg-opacity-20 text-white px-2 py-1 fs-11">Versi TOPSIS Engine v1.2</span>
                </div>
                <h2 class="fw-bold text-white mb-2 fs-26">Sistem Pendukung Keputusan Penentuan Reward Hakim & Pegawai</h2>
                <p class="text-white text-opacity-80 fs-14 leading-relaxed mb-0">
                    Aplikasi SPK menggunakan metode <strong>TOPSIS (Technique for Order of Preference by Similarity to Ideal
                        Solution)</strong> untuk mengkalkulasi dan menentukan reward secara objektif bagi Hakim, Panitera Pengganti, Jurusita, dan
                    Staf.
                </p>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <a href="<?= site_url('laporan/preview/1'); ?>" class="btn btn-warning font-bold shadow-sm px-3 py-2">
                    <i class="ti ti-sparkles me-1"></i> Showroom Candidates 3D
                </a>
                <a href="<?= site_url('proses'); ?>" class="btn btn-primary bg-opacity-20 text-white border-0 shadow-sm px-3 py-2">
                    <i class="ti ti-cpu me-1"></i> Penilaian & TOPSIS
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 6 Primary KPI Summary Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Utama">
    <div class="col-md-4 col-xl-2">
        <a href="<?= site_url('pegawai'); ?>" class="card kpi-card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body p-3 text-center">
                <div class="kpi-icon indigo mx-auto mb-2">
                    <i class="ti ti-users"></i>
                </div>
                <span class="text-muted fs-11 d-block mb-1">Total Pegawai</span>
                <h4 class="fw-bold mb-0 text-dark"><?= $kpi['total_pegawai']; ?> <span class="fs-11 text-muted fw-normal">Orang</span></h4>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-xl-2">
        <a href="<?= site_url('kriteria'); ?>" class="card kpi-card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body p-3 text-center">
                <div class="kpi-icon cyan mx-auto mb-2">
                    <i class="ti ti-list-check"></i>
                </div>
                <span class="text-muted fs-11 d-block mb-1">Kriteria Evaluation</span>
                <h4 class="fw-bold mb-0 text-dark"><?= $kpi['total_kriteria']; ?> <span class="fs-11 text-muted fw-normal">Item</span></h4>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-xl-2">
        <a href="<?= site_url('periode'); ?>" class="card kpi-card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body p-3 text-center">
                <div class="kpi-icon amber mx-auto mb-2">
                    <i class="ti ti-calendar"></i>
                </div>
                <span class="text-muted fs-11 d-block mb-1">Siklus Periode</span>
                <h4 class="fw-bold mb-0 text-dark"><?= $kpi['periode_aktif']; ?> <span class="fs-11 text-muted fw-normal">Siklus</span></h4>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-xl-2">
        <a href="<?= site_url('proses'); ?>" class="card kpi-card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body p-3 text-center">
                <div class="kpi-icon green mx-auto mb-2">
                    <i class="ti ti-cpu"></i>
                </div>
                <span class="text-muted fs-11 d-block mb-1">Engine TOPSIS</span>
                <h4 class="fw-bold mb-0 text-dark">Active <span class="fs-11 text-success fw-semibold">● Ready</span></h4>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-xl-2">
        <a href="<?= site_url('laporan'); ?>" class="card kpi-card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body p-3 text-center">
                <div class="kpi-icon indigo mx-auto mb-2" style="background:#e6f3ff; color:#108dff;">
                    <i class="ti ti-file-text"></i>
                </div>
                <span class="text-muted fs-11 d-block mb-1">BA Disahkan</span>
                <h4 class="fw-bold mb-0 text-dark"><?= $kpi['ba_disahkan']; ?> <span class="fs-11 text-muted fw-normal">Resmi</span></h4>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-xl-2">
        <a href="<?= site_url('audit'); ?>" class="card kpi-card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body p-3 text-center">
                <div class="kpi-icon cyan mx-auto mb-2">
                    <i class="ti ti-activity"></i>
                </div>
                <span class="text-muted fs-11 d-block mb-1">Audit Trail</span>
                <h4 class="fw-bold mb-0 text-dark"><?= $kpi['audit_log']; ?> <span class="fs-11 text-muted fw-normal">Log</span></h4>
            </div>
        </a>
    </div>
</section>

<!-- Spotlight Section: Penerima Reward Teratas Per Kategori -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Hasil TOPSIS Terbaik</span>
                <h4 class="fw-bold text-dark mb-0">Penerima Reward Teratas Per Kategori (Triwulan II 2026)</h4>
            </div>
            <a href="<?= site_url('laporan/preview/1'); ?>" class="btn btn-sm btn-outline-primary">
                <i class="ti ti-sparkles me-1"></i> Buka Showroom 3D
            </a>
        </div>

        <div class="row g-3">
            <?php foreach ($top_winners as $winner): ?>
                <div class="col-md-6 col-xl-3">
                    <div class="card border rounded-3 p-3 bg-light h-100 shadow-sm position-relative overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-warning text-dark font-bold px-2 py-1 fs-10">
                                <i class="ti ti-trophy text-warning me-1"></i>RANK #1
                            </span>
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11"><?= html_escape($winner['kategori']); ?></span>
                        </div>
                        <div class="text-center my-2">
                            <img src="<?= base_url($winner['foto']); ?>" alt="<?= html_escape($winner['nama']); ?>"
                                class="rounded-circle border border-2 border-primary shadow-sm mb-2"
                                style="width: 64px; height: 64px; object-fit: cover;">
                            <h6 class="fw-bold text-dark mb-0 fs-13"><?= html_escape($winner['nama']); ?></h6>
                            <small class="text-muted fs-11 d-block">NIP. <?= html_escape($winner['nip']); ?></small>
                        </div>
                        <div class="p-2 bg-white rounded text-center border mt-2">
                            <small class="text-muted fs-11 d-block">Skor Preferensi TOPSIS</small>
                            <strong class="text-primary fs-14">V = <?= number_format($winner['skor'], 4); ?></strong>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Module Navigation & Recent Audit Feed Grid -->
<div class="row g-4 mb-4">
    <!-- Quick Module Navigation Cards -->
    <div class="col-xl-7">
        <div class="card panel-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Modul Navigasi</span>
                <h4 class="fw-bold text-dark mb-3">Akses Cepat Pengelolaan Sistem</h4>

                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="<?= site_url('pegawai'); ?>"
                            class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 text-decoration-none border hover-shadow transition">
                            <div class="kpi-icon indigo flex-shrink-0">
                                <i class="ti ti-users"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0 fs-13">Data Pegawai</h6>
                                <small class="text-muted fs-11">Kelola master pegawai & foto profil</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('kriteria'); ?>"
                            class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 text-decoration-none border hover-shadow transition">
                            <div class="kpi-icon cyan flex-shrink-0">
                                <i class="ti ti-list-check"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0 fs-13">Kriteria Penilaian</h6>
                                <small class="text-muted fs-11">Atur bobot kriteria benefit / cost</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('periode'); ?>"
                            class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 text-decoration-none border hover-shadow transition">
                            <div class="kpi-icon amber flex-shrink-0">
                                <i class="ti ti-calendar"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0 fs-13">Periode Penilaian</h6>
                                <small class="text-muted fs-11">Siklus penilaian triwulan & tahunan</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('proses'); ?>"
                            class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 text-decoration-none border hover-shadow transition">
                            <div class="kpi-icon green flex-shrink-0">
                                <i class="ti ti-cpu"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0 fs-13">Penilaian & TOPSIS</h6>
                                <small class="text-muted fs-11">Input alternative & hitung final</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('laporan'); ?>"
                            class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 text-decoration-none border hover-shadow transition">
                            <div class="kpi-icon indigo flex-shrink-0" style="background:#e6f3ff; color:#108dff;">
                                <i class="ti ti-file-text"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0 fs-13">Laporan & Berita Acara</h6>
                                <small class="text-muted fs-11">Pratinjau resmi & ekspor Word</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('audit'); ?>"
                            class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 text-decoration-none border hover-shadow transition">
                            <div class="kpi-icon cyan flex-shrink-0">
                                <i class="ti ti-activity"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0 fs-13">Audit Trail</h6>
                                <small class="text-muted fs-11">Histori log aktivitas & IP security</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Audit Activity Feed -->
    <div class="col-xl-5">
        <div class="card panel-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Audit Security Feed</span>
                        <h4 class="fw-bold text-dark mb-0">Aktivitas Terakhir</h4>
                    </div>
                    <a href="<?= site_url('audit'); ?>" class="text-action text-primary fw-semibold fs-12">
                        Lihat Semua <i class="ti ti-arrow-up-right ms-1"></i>
                    </a>
                </div>

                <div class="activity-list">
                    <?php if (!empty($recent_activities)): ?>
                        <?php foreach ($recent_activities as $act): ?>
                            <div class="activity-item d-flex align-items-center justify-content-between py-2.5 pb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="activity-icon bg-primary-subtle text-primary p-2 rounded-3 d-inline-flex">
                                        <i class="ti ti-activity fs-16"></i>
                                    </span>
                                    <div>
                                        <strong class="text-dark fs-13 d-block"><?= html_escape($act['modul']); ?></strong>
                                        <p class="text-muted fs-11 mb-0"
                                            style="max-width: 280px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                            <?= html_escape($act['aktivitas']); ?>
                                        </p>
                                    </div>
                                </div>
                                <small class="text-muted fs-11 text-nowrap"><?= date('H:i', strtotime($act['timestamp'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>