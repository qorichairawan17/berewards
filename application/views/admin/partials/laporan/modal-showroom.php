<!-- Modal Futuristic Showroom 3D Stack Carousel -->
<div class="modal fade" id="modalShowroomKandidat" tabindex="-1" aria-labelledby="modalShowroomKandidatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg style-showroom-content overflow-hidden">
            <!-- Glassmorphism Futuristic Modal Header -->
            <div class="modal-header border-0 bg-dark text-white p-4 position-relative"
                style="background: linear-gradient(135deg, #0A2540 0%, #0052CC 50%, #108DFF 100%);">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-warning text-dark font-bold px-2 py-1 fs-11 tracking-wider text-uppercase">
                            <i class="ti ti-trophy me-1"></i> Reward Showroom TOPSIS
                        </span>
                        <span class="badge bg-warning bg-opacity-20 text-white px-2 py-1 fs-11" id="showroom_periode_title">Triwulan II 2026</span>
                    </div>
                    <h4 class="fw-bold text-white mb-0" id="showroom_main_title">Pratinjau Kandidat Reward Terbaik</h4>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body p-4 bg-light position-relative">
                <!-- Top Carousel Navigator -->
                <div class="d-flex align-items-center justify-content-between mb-4 px-2">
                    <div>
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider d-block">Interactive Selection</span>
                        <h6 class="fw-bold text-dark mb-0">Klik / Geser Kartu untuk Melihat Profil Kandidat</h6>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-white border shadow-sm rounded-circle p-2" id="btnPrevShowroomCard"
                            style="width:38px; height:38px;">
                            <i class="ti ti-chevron-left fs-16"></i>
                        </button>
                        <span class="fs-12 fw-bold text-dark px-2" id="showroom_slide_indicator">1 / 3</span>
                        <button type="button" class="btn btn-sm btn-white border shadow-sm rounded-circle p-2" id="btnNextShowroomCard"
                            style="width:38px; height:38px;">
                            <i class="ti ti-chevron-right fs-16"></i>
                        </button>
                    </div>
                </div>

                <!-- 3D Card Stack Container -->
                <div class="showroom-card-stack-wrapper mb-4">
                    <div class="row justify-content-center g-4" id="showroom_cards_container">
                        <!-- Cards dynamically rendered via JS -->
                    </div>
                </div>

                <!-- Dynamic Detailed Candidate Metrics Panel -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="border-left: 4px solid #108DFF !important;">
                    <div class="card-body p-4 bg-white">
                        <div class="row align-items-center g-4">
                            <div class="col-md-3 text-center border-end">
                                <img src="<?= base_url('assets/icons/logo.png'); ?>" id="showroom_detail_photo" alt="Candidate Photo"
                                    class="rounded-circle border border-3 border-primary shadow-sm mb-2"
                                    style="width: 84px; height: 84px; object-fit: cover;"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/icons/logo.png'); ?>';">
                                <h6 class="fw-bold text-dark mb-0 fs-14" id="showroom_detail_nama">-</h6>
                                <small class="text-muted fs-11 d-block" id="showroom_detail_nip">-</small>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 mt-2"
                                    id="showroom_detail_kategori">-</span>
                            </div>

                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <div class="p-3 bg-light rounded-3 text-center border">
                                            <span class="d-block text-muted fs-11 mb-1">Skor Preferensi ($V_i$)</span>
                                            <h3 class="fw-bold text-primary mb-0" id="showroom_detail_vi">0.0000</h3>
                                            <small class="text-success fw-semibold fs-11" id="showroom_detail_rank_label">Rank #1 (Pemenang)</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="p-3 bg-light rounded-3 text-center border">
                                            <span class="d-block text-muted fs-11 mb-1">Jarak Solusi Positif ($D^+$)</span>
                                            <h4 class="fw-bold text-dark mb-0" id="showroom_detail_dplus">0.0000</h4>
                                            <small class="text-muted fs-11">Jarak terdekat ke Solusi Ideal Positif</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="p-3 bg-light rounded-3 text-center border">
                                            <span class="d-block text-muted fs-11 mb-1">Jarak Solusi Negatif ($D^-$)</span>
                                            <h4 class="fw-bold text-dark mb-0" id="showroom_detail_dminus">0.0000</h4>
                                            <small class="text-muted fs-11">Jarak terjauh dari Solusi Ideal Negatif</small>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <h6 class="fw-bold text-dark fs-12 mb-2">Evaluasi Kinerja Berdasarkan Kriteria:</h6>
                                        <div class="progress-stacked" id="showroom_progress_stacked" style="height: 14px;">
                                            <!-- Rendered dynamically -->
                                        </div>
                                        <div class="d-flex flex-wrap gap-3 fs-11 text-muted mt-2" id="showroom_criteria_labels">
                                            <!-- Rendered dynamically -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup Showroom</button>
                    <a href="#" id="btnShowroomFullPage" class="btn btn-brand btn-sm" target="_blank">
                        <i class="ti ti-external-link me-1"></i> Buka Halaman Showroom Penuh
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Futuristic 3D Card Stack Styles */
        .showroom-card-item {
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
        }

        .showroom-card-item:hover {
            transform: translateY(-8px) scale(1.02);
        }

        .showroom-card-item.active-card {
            border: 2px solid #108DFF !important;
            box-shadow: 0 15px 30px rgba(16, 141, 255, 0.25) !important;
        }

        .showroom-card-item.active-card .rank-trophy-badge {
            animation: pulse-glow 2s infinite alternate;
        }

        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                filter: drop-shadow(0 0 2px rgba(245, 158, 11, 0.5));
            }

            100% {
                transform: scale(1.1);
                filter: drop-shadow(0 0 8px rgba(245, 158, 11, 0.9));
            }
        }
    </style>