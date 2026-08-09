<!-- Header Banner with Glassmorphism Theme -->
<div class="card border-0 shadow-lg rounded-3 mb-4 text-white overflow-hidden"
    style="background: linear-gradient(135deg, #1E1B4B 0%, #312E81 50%, #4F46E5 100%);">
    <div class="card-body p-4 position-relative">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="mb-2">
                    <a href="<?= site_url('laporan'); ?>" class="btn btn-sm btn-primary bg-opacity-20 text-white border-0 shadow-sm">
                        <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Laporan
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-warning text-dark font-bold px-2 py-1 fs-11 tracking-wider text-uppercase">
                        <i class="ti ti-sparkles me-1"></i> Reward Showroom TOPSIS
                    </span>
                    <span class="badge bg-primary bg-opacity-20 text-white px-2 py-1 fs-11"><?= html_escape($laporan_info['nama_periode']); ?></span>
                </div>
                <h3 class="fw-bold text-white mb-1">Pratinjau Showroom Kandidat Reward Terbaik</h3>
                <p class="text-white text-opacity-75 fs-13 mb-0">Halaman pratinjau interaktif hasil perhitungan metode TOPSIS untuk penetapan reward
                    pegawai Pengadilan Negeri Lubuk Pakam.</p>
            </div>

            <!-- Dynamic Period Switcher Dropdown -->
            <div class="bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-20">
                <label class="form-label text-white fs-11 fw-semibold mb-1">Ganti Periode & Kategori:</label>
                <select class="form-select form-select-sm bg-white text-dark fw-semibold" id="select_preview_laporan_id">
                    <?php foreach ($laporan_list as $item): ?>
                        <option value="<?= $item['id_laporan']; ?>" <?= ($item['id_laporan'] == $laporan_info['id_laporan']) ? 'selected' : ''; ?>>
                            <?= html_escape($item['nama_periode']); ?> — <?= html_escape($item['kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Main Showroom Interactive Section -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <!-- Carousel Controls Bar -->
        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider d-block">Pilih & Geser Kartu</span>
                <h5 class="fw-bold text-dark mb-0">Kandidat Teratas — <?= html_escape($laporan_info['kategori']); ?>
                    (<?= html_escape($laporan_info['nama_periode']); ?>)</h5>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-white border shadow-sm rounded-circle p-2" id="btnPrevCard" style="width:40px; height:40px;">
                    <i class="ti ti-chevron-left fs-16"></i>
                </button>
                <span class="fs-13 fw-bold text-dark px-2" id="page_slide_indicator">1 / 3</span>
                <button type="button" class="btn btn-white border shadow-sm rounded-circle p-2" id="btnNextCard" style="width:40px; height:40px;">
                    <i class="ti ti-chevron-right fs-16"></i>
                </button>
            </div>
        </div>

        <!-- 3D Stack of Cards for 3 Best Candidates -->
        <div class="row justify-content-center g-4 mb-4" id="page_cards_container">
            <?php foreach ($laporan_info['top_3'] as $idx => $cand): ?>
                <?php
                $isActive = ($idx === 0);
                $cardClass = $isActive ? 'active-page-card bg-white border-primary shadow-lg' : 'bg-light border-0 opacity-75';
                $trophyIcon = ($cand['rank'] == 1) ? '<i class="ti ti-trophy text-warning fs-28 rank-trophy-badge"></i>' : (($cand['rank'] == 2) ? '<i class="ti ti-medal text-secondary fs-28"></i>' : '<i class="ti ti-award text-amber fs-28"></i>');
                ?>
                <div class="col-md-4">
                    <div class="card page-card-item h-100 rounded-3 p-4 <?= $cardClass; ?>" data-index="<?= $idx; ?>"
                        style="<?= $isActive ? 'border: 2px solid #4F46E5 !important;' : ''; ?>">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-dark text-white px-2 py-1 fs-11">PERINGKAT #<?= $cand['rank']; ?></span>
                            <?= $trophyIcon; ?>
                        </div>
                        <div class="text-center mb-3">
                            <img src="<?= base_url($cand['foto']); ?>" alt="<?= html_escape($cand['nama']); ?>"
                                class="rounded-circle border border-3 border-primary mb-2 shadow-sm"
                                style="width: 84px; height: 84px; object-fit: cover;">
                            <h5 class="fw-bold text-dark mb-1 fs-14"><?= html_escape($cand['nama']); ?></h5>
                            <small class="text-muted fs-11 d-block">NIP. <?= html_escape($cand['nip']); ?></small>
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 mt-2"><?= html_escape($cand['kategori']); ?></span>
                        </div>
                        <div class="p-3 bg-light rounded text-center border">
                            <small class="text-muted fs-11 d-block mb-1">Skor Preferensi TOPSIS</small>
                            <h4 class="fw-bold text-primary mb-0">V = <?= number_format($cand['skor'], 4); ?></h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Dynamic Lower Detailed Performance Panel -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="border-left: 4px solid #4F46E5 !important;">
            <div class="card-body p-4 bg-white">
                <div class="row align-items-center g-4">
                    <div class="col-md-3 text-center border-end">
                        <img src="<?= base_url($laporan_info['top_3'][0]['foto']); ?>" id="detail_photo" alt="Candidate Photo"
                            class="rounded-circle border border-3 border-primary shadow-sm mb-2"
                            style="width: 90px; height: 90px; object-fit: cover;">
                        <h5 class="fw-bold text-dark mb-0" id="detail_nama"><?= html_escape($laporan_info['top_3'][0]['nama']); ?></h5>
                        <small class="text-muted fs-12 d-block" id="detail_nip">NIP. <?= html_escape($laporan_info['top_3'][0]['nip']); ?></small>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 mt-2"
                            id="detail_kategori"><?= html_escape($laporan_info['top_3'][0]['kategori']); ?></span>
                    </div>

                    <div class="col-md-9">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="d-block text-muted fs-11 mb-1">Skor Preferensi ($V_i$)</span>
                                    <h3 class="fw-bold text-primary mb-0" id="detail_vi"><?= number_format($laporan_info['top_3'][0]['skor'], 4); ?>
                                    </h3>
                                    <small class="text-success fw-semibold fs-11" id="detail_rank_label">Rank #1 (Penerima Reward)</small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="d-block text-muted fs-11 mb-1">Jarak Solusi Positif ($D^+$)</span>
                                    <h4 class="fw-bold text-dark mb-0" id="detail_dplus"><?= number_format($laporan_info['top_3'][0]['dplus'], 4); ?>
                                    </h4>
                                    <small class="text-muted fs-11">Jarak terdekat ke SIP</small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="d-block text-muted fs-11 mb-1">Jarak Solusi Negatif ($D^-$)</span>
                                    <h4 class="fw-bold text-dark mb-0" id="detail_dminus">
                                        <?= number_format($laporan_info['top_3'][0]['dminus'], 4); ?>
                                    </h4>
                                    <small class="text-muted fs-11">Jarak terjauh dari SIN</small>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <h6 class="fw-bold text-dark fs-12 mb-2">Evaluasi Kriteria Kinerja ($C_1 - C_4$):</h6>
                                <div class="progress-stacked" style="height: 12px;">
                                    <div class="progress" role="progressbar" style="width: 25%" aria-label="C1" aria-valuenow="25" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-primary" title="C1: Kehadiran">C1</div>
                                    </div>
                                    <div class="progress" role="progressbar" style="width: 25%" aria-label="C2" aria-valuenow="25" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-info" title="C2: Produktivitas">C2</div>
                                    </div>
                                    <div class="progress" role="progressbar" style="width: 25%" aria-label="C3" aria-valuenow="25" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-success" title="C3: Integritas">C3</div>
                                    </div>
                                    <div class="progress" role="progressbar" style="width: 25%" aria-label="C4" aria-valuenow="25" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-warning" title="C4: Inovasi">C4</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between fs-11 text-muted mt-2">
                                    <span><i class="ti ti-circle-filled text-primary fs-9 me-1"></i>C1 Kehadiran: <strong>4.8</strong></span>
                                    <span><i class="ti ti-circle-filled text-info fs-9 me-1"></i>C2 Perkara/Tugas: <strong>95.5</strong></span>
                                    <span><i class="ti ti-circle-filled text-success fs-9 me-1"></i>C3 Integritas: <strong>4.9</strong></span>
                                    <span><i class="ti ti-circle-filled text-warning fs-9 me-1"></i>C4 Inovasi: <strong>4.5</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Inline Custom CSS & JS for Interactive Page Showroom -->
<style>
    .page-card-item {
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
    }

    .page-card-item:hover {
        transform: translateY(-8px) scale(1.02);
    }

    .page-card-item.active-page-card {
        border: 2px solid #4F46E5 !important;
        box-shadow: 0 15px 30px rgba(79, 70, 229, 0.22) !important;
    }

    .page-card-item.active-page-card .rank-trophy-badge {
        animation: pulse-glow-page 2s infinite alternate;
    }

    @keyframes pulse-glow-page {
        0% {
            transform: scale(1);
            filter: drop-shadow(0 0 2px rgba(245, 158, 11, 0.5));
        }

        100% {
            transform: scale(1.12);
            filter: drop-shadow(0 0 10px rgba(245, 158, 11, 0.9));
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var top3Data = <?= json_encode($laporan_info['top_3']); ?>;
        var currentIndex = 0;

        function updatePagePanel(idx) {
            var cand = top3Data[idx];
            if (!cand) return;

            $('#page_slide_indicator').text((idx + 1) + ' / ' + top3Data.length);

            // Update active class on card list
            $('.page-card-item').each(function (i) {
                if (i === idx) {
                    $(this).addClass('active-page-card bg-white border-primary shadow-lg').removeClass('bg-light border-0 opacity-75').css('border', '2px solid #4F46E5');
                } else {
                    $(this).removeClass('active-page-card bg-white border-primary shadow-lg').addClass('bg-light border-0 opacity-75').css('border', 'none');
                }
            });

            // Update detail panel elements
            $('#detail_photo').attr('src', '<?= base_url(); ?>' + cand.foto);
            $('#detail_nama').text(cand.nama);
            $('#detail_nip').text('NIP. ' + cand.nip);
            $('#detail_kategori').text(cand.kategori);
            $('#detail_vi').text(parseFloat(cand.skor).toFixed(4));
            $('#detail_dplus').text(parseFloat(cand.dplus).toFixed(4));
            $('#detail_dminus').text(parseFloat(cand.dminus).toFixed(4));

            if (cand.rank == 1) {
                $('#detail_rank_label').text('Rank #1 (Penerima Reward Utama)').removeClass('text-muted').addClass('text-success');
            } else if (cand.rank == 2) {
                $('#detail_rank_label').text('Rank #2 (Runner Up 1)').removeClass('text-success').addClass('text-info');
            } else {
                $('#detail_rank_label').text('Rank #3 (Runner Up 2)').removeClass('text-success text-info').addClass('text-muted');
            }
        }

        // Card Click Handler
        $(document).on('click', '.page-card-item', function () {
            currentIndex = parseInt($(this).data('index'));
            updatePagePanel(currentIndex);
        });

        // Navigation Controls
        $('#btnPrevCard').on('click', function () {
            currentIndex = (currentIndex - 1 + top3Data.length) % top3Data.length;
            updatePagePanel(currentIndex);
        });

        $('#btnNextCard').on('click', function () {
            currentIndex = (currentIndex + 1) % top3Data.length;
            updatePagePanel(currentIndex);
        });

        // Period Switcher Dropdown
        $('#select_preview_laporan_id').on('change', function () {
            var id = $(this).val();
            window.location.href = '<?= site_url("laporan/preview/"); ?>' + id;
        });
    });
</script>