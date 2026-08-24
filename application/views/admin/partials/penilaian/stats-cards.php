<!-- Statistic Cards -->
<section class="row g-3 mb-4" aria-label="Statistik Penilaian TOPSIS">
    <?php if (isset($stats)): ?>
        <!-- STATS CARD UNTUK HALAMAN DETAIL -->
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon indigo flex-shrink-0">
                        <i class="ti ti-users"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Total Terpenilai</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['total_terpenilai']) ? $stats['total_terpenilai'] : count($hasil_topsis_pegawai); ?> <span class="fs-12 text-muted fw-normal">Pegawai</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon cyan flex-shrink-0">
                        <i class="ti ti-trophy"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Skor Tertinggi (Rank #1)</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= isset($stats['skor_tertinggi']) ? $stats['skor_tertinggi'] : '0.0000'; ?> <span class="fs-12 text-muted fw-normal"><?= isset($stats['pemenang_singkat']) ? html_escape($stats['pemenang_singkat']) : '-'; ?></span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon amber flex-shrink-0">
                        <i class="ti ti-calendar"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Periode Evaluasi</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= isset($periode_info['nama_periode']) ? html_escape($periode_info['nama_periode']) : 'TW II 2026'; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon green flex-shrink-0">
                        <i class="ti ti-circle-check"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Status TOPSIS</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= isset($periode_info['status_topsis']) ? html_escape($periode_info['status_topsis']) : 'Draft'; ?> <span class="fs-12 text-muted fw-normal">Kalkulasi</span></h4>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- STATS CARD UNTUK HALAMAN INDEX UTAMA -->
        <?php
            $total_sesi  = !empty($periode_penilaian_list) ? count($periode_penilaian_list) : 0;
            $final_count = 0;
            $total_org   = 0;
            if (!empty($periode_penilaian_list)) {
                foreach ($periode_penilaian_list as $pl) {
                    if ($pl['status_topsis'] === 'Final') $final_count++;
                    $total_org += (int)$pl['jumlah_terpenilai'];
                }
            }
            $draft_count = $total_sesi - $final_count;
        ?>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon indigo flex-shrink-0">
                        <i class="ti ti-calendar-event"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Total Sesi Penilaian</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= $total_sesi; ?> <span class="fs-12 text-muted fw-normal">Sesi</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon green flex-shrink-0">
                        <i class="ti ti-circle-check"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Sesi Status Final</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= $final_count; ?> <span class="fs-12 text-muted fw-normal">Selesai</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon amber flex-shrink-0">
                        <i class="ti ti-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Sesi Status Draft</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= $draft_count; ?> <span class="fs-12 text-muted fw-normal">Draft</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="kpi-icon cyan flex-shrink-0">
                        <i class="ti ti-users"></i>
                    </div>
                    <div>
                        <p class="text-muted fs-12 mb-0">Total Kandidat</p>
                        <h4 class="fw-bold mb-0 text-dark"><?= $total_org; ?> <span class="fs-12 text-muted fw-normal">Pegawai</span></h4>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
