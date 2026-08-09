<!-- Dashboard Welcome Banner -->
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column justify-content-between gap-3 mb-3">
    <div>
        <div class="section-kicker d-flex align-items-center gap-1 text-primary fw-bold text-uppercase fs-11 tracking-wider mb-1">
            <i class="ti ti-sparkles"></i> Ringkasan Sistem TOPSIS
        </div>
        <h3 class="fw-bold mb-1 text-dark">Selamat datang kembali, Superadmin</h3>
        <p class="text-muted fs-13 mb-0">Pantau data pegawai, kriteria, dan status penilaian reward di Pengadilan Negeri Lubuk Pakam.</p>
    </div>
    <div>
        <a href="<?= site_url('proses'); ?>" class="btn btn-brand shadow-sm">
            <i class="ti ti-plus me-1"></i> Mulai Penilaian TOPSIS
        </a>
    </div>
</div>

<!-- KPI Summary Cards -->
<section class="row g-3 mb-4" aria-label="Ringkasan statistik">
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card h-100 border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-start gap-3">
                <div class="kpi-icon indigo flex-shrink-0">
                    <i class="ti ti-users"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="text-muted fs-12 mb-1">Total Pegawai Aktif</p>
                    <h3 class="fw-bold mb-1 text-dark">128</h3>
                    <span class="kpi-note up fs-11 text-success"><i class="ti ti-trending-up"></i> Data terbarui</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card h-100 border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-start gap-3">
                <div class="kpi-icon cyan flex-shrink-0">
                    <i class="ti ti-calendar-event"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="text-muted fs-12 mb-1">Periode Berjalan</p>
                    <h3 class="fw-bold mb-1 text-dark">Triwulan II</h3>
                    <span class="kpi-note fs-11 text-muted">April — Juni 2026</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card h-100 border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-start gap-3">
                <div class="kpi-icon amber flex-shrink-0">
                    <i class="ti ti-hourglass"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="text-muted fs-12 mb-1">Proses Belum Selesai</p>
                    <h3 class="fw-bold mb-1 text-dark">04</h3>
                    <span class="kpi-note warning fs-11 text-warning"><i class="ti ti-alert-circle me-1"></i>Perlu tindak lanjut</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card kpi-card h-100 border-0 shadow-sm">
            <div class="card-body p-3 d-flex align-items-start gap-3">
                <div class="kpi-icon green flex-shrink-0">
                    <i class="ti ti-rosette-discount-check"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="text-muted fs-12 mb-1">Reward Ditetapkan</p>
                    <h3 class="fw-bold mb-1 text-dark">36</h3>
                    <span class="kpi-note fs-11 text-muted">Periode sebelumnya</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Grid Section -->
<section class="row g-4 mb-4">
    <!-- Ranking Visual Panel -->
    <div class="col-xl-7">
        <div class="card panel-card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Hasil TOPSIS Terakhir</span>
                        <h4 class="fw-bold text-dark mb-0">Ranking Preferensi Kandidat</h4>
                    </div>
                    <a href="<?= site_url('laporan'); ?>" class="text-action text-primary fw-semibold fs-12">
                        Lihat Laporan <i class="ti ti-arrow-up-right ms-1"></i>
                    </a>
                </div>
                <div class="ranking-visual">
                    <div class="rank-list">
                        <div class="rank-row first p-2 rounded-3 mb-2 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <span class="rank-badge bg-warning text-white fw-bold rounded-circle d-inline-flex align-items-center justify-content-center" style="width:28px; height:28px; font-size:12px;">1</span>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark fs-13">Rina Agustina, S.H.</h6>
                                    <small class="text-muted fs-11">Hakim Utama</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary fs-13">0.892</span>
                                <small class="d-block text-muted fs-10">Nilai V<sub>i</sub></small>
                            </div>
                        </div>
                        <div class="rank-row p-2 rounded-3 mb-2 d-flex align-items-center justify-content-between border">
                            <div class="d-flex align-items-center gap-3">
                                <span class="rank-badge bg-light text-dark fw-bold rounded-circle d-inline-flex align-items-center justify-content-center" style="width:28px; height:28px; font-size:12px;">2</span>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark fs-13">Ahmad Faisal, S.H.</h6>
                                    <small class="text-muted fs-11">Hakim Pratama</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary fs-13">0.847</span>
                                <small class="d-block text-muted fs-10">Nilai V<sub>i</sub></small>
                            </div>
                        </div>
                        <div class="rank-row p-2 rounded-3 mb-2 d-flex align-items-center justify-content-between border">
                            <div class="d-flex align-items-center gap-3">
                                <span class="rank-badge bg-light text-dark fw-bold rounded-circle d-inline-flex align-items-center justify-content-center" style="width:28px; height:28px; font-size:12px;">3</span>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark fs-13">Dian Pratiwi, S.H.</h6>
                                    <small class="text-muted fs-11">Panitera Pengganti</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary fs-13">0.811</span>
                                <small class="d-block text-muted fs-10">Nilai V<sub>i</sub></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Workflow Progress Panel -->
    <div class="col-xl-5">
        <div class="card panel-card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Kesiapan Tahapan</span>
                        <h4 class="fw-bold text-dark mb-0">Alur Penilaian Reward</h4>
                    </div>
                    <i class="ti ti-route workflow-icon fs-20 text-primary bg-primary-subtle p-2 rounded-3"></i>
                </div>
                <ol class="workflow-list list-unstyled mb-0">
                    <li class="done d-flex align-items-center gap-3 mb-3">
                        <span class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width:28px; height:28px;"><i class="ti ti-check fs-14"></i></span>
                        <div>
                            <strong class="d-block text-dark fs-13">Data Master</strong>
                            <small class="text-muted fs-11">Pegawai dan kriteria telah dikonfigurasi</small>
                        </div>
                    </li>
                    <li class="done d-flex align-items-center gap-3 mb-3">
                        <span class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width:28px; height:28px;"><i class="ti ti-check fs-14"></i></span>
                        <div>
                            <strong class="d-block text-dark fs-13">Periode Penilaian</strong>
                            <small class="text-muted fs-11">Triwulan II 2026 telah dibuka</small>
                        </div>
                    </li>
                    <li class="current d-flex align-items-center gap-3 mb-3">
                        <span class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-12" style="width:28px; height:28px;">3</span>
                        <div>
                            <strong class="d-block text-dark fs-13">Input Penilaian</strong>
                            <small class="text-muted fs-11">4 proses penilaian sedang berlangsung</small>
                        </div>
                    </li>
                    <li class="d-flex align-items-center gap-3">
                        <span class="bg-light text-muted rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-12" style="width:28px; height:28px;">4</span>
                        <div>
                            <strong class="d-block text-dark fs-13">Penetapan Reward & Export</strong>
                            <small class="text-muted fs-11">Menunggu penyelesaian kalkulasi TOPSIS</small>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Activity Log Section -->
<section class="card panel-card border-0 shadow-sm mb-2">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Aktivitas Sistem</span>
                <h4 class="fw-bold text-dark mb-0">Pembaruan Terbaru</h4>
            </div>
            <a href="#" class="text-action text-primary fw-semibold fs-12">
                Lihat Semua <i class="ti ti-arrow-up-right ms-1"></i>
            </a>
        </div>
        <div class="activity-list">
            <div class="activity-item d-flex align-items-center justify-content-between py-2 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <span class="activity-icon bg-primary-subtle text-primary p-2 rounded-3 d-inline-flex"><i class="ti ti-user-plus fs-18"></i></span>
                    <div>
                        <strong class="text-dark fs-13 d-block">Data Pegawai Diperbarui</strong>
                        <p class="text-muted fs-12 mb-0">12 referensi pegawai baru berhasil disinkronkan ke master data.</p>
                    </div>
                </div>
                <time class="text-muted fs-11">10 menit lalu</time>
            </div>
            <div class="activity-item d-flex align-items-center justify-content-between py-2 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <span class="activity-icon bg-cyan-subtle text-info p-2 rounded-3 d-inline-flex" style="background:#ecfeff;"><i class="ti ti-calculator fs-18" style="color:#0891b2;"></i></span>
                    <div>
                        <strong class="text-dark fs-13 d-block">Proses Penilaian TOPSIS Dibuat</strong>
                        <p class="text-muted fs-12 mb-0">Penilaian kategori Panitera Pengganti telah dimulai untuk Triwulan II 2026.</p>
                    </div>
                </div>
                <time class="text-muted fs-11">1 jam lalu</time>
            </div>
            <div class="activity-item d-flex align-items-center justify-content-between py-2">
                <div class="d-flex align-items-center gap-3">
                    <span class="activity-icon bg-success-subtle text-success p-2 rounded-3 d-inline-flex"><i class="ti ti-file-check fs-18"></i></span>
                    <div>
                        <strong class="text-dark fs-13 d-block">Laporan Berita Acara Diterbitkan</strong>
                        <p class="text-muted fs-12 mb-0">Dokumen Berita Acara penetapan reward Triwulan I 2026 telah ditandatangani.</p>
                    </div>
                </div>
                <time class="text-muted fs-11">Kemarin</time>
            </div>
        </div>
    </div>
</section>

