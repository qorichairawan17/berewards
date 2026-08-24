<!-- Modal Detail Kriteria -->
<div class="modal fade" id="modalDetailKriteria" tabindex="-1" aria-labelledby="modalDetailKriteriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailKriteriaLabel">
                    <i class="ti ti-info-circle text-primary me-2"></i>Spesifikasi Kriteria Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-3">
                    <div class="user-avatar-lg bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-18 flex-shrink-0" style="width:54px; height:54px;" id="detail_kode_badge">
                        C1
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0.5" id="detail_nama_kriteria">-</h5>
                        <div class="d-flex align-items-center gap-2 flex-wrap fs-12 text-muted">
                            <span id="detail_kategori_pegawai">-</span>
                            <span>•</span>
                            <span id="detail_tipe_atribut_badge">-</span>
                            <span>•</span>
                            <span class="text-capitalize" id="detail_jenis_data">-</span>
                        </div>
                    </div>
                    <div class="ms-auto text-end">
                        <span class="d-block text-muted fs-11">Bobot Penilaian</span>
                        <span class="fs-18 fw-bold text-primary" id="detail_bobot">-</span>
                    </div>
                </div>

                <!-- Section Sub Kriteria / Skala Penilaian -->
                <div id="detail_skala_container" class="mt-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="fw-bold text-dark mb-0 fs-13 d-flex align-items-center gap-1.5">
                            <i class="ti ti-list-details text-warning fs-16"></i> Opsi Skala & Sub Kriteria
                        </h6>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-0.5 fs-11">Kualitatif (Skala 1-5)</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover align-middle mb-0" id="tableDetailSkala">
                            <thead class="table-light">
                                <tr class="fs-12 text-dark">
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Sub Kriteria</th>
                                    <th style="width: 100px;" class="text-center">Bobot</th>
                                    <th style="width: 180px;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDetailSkala">
                                <!-- Dynamic rows populated from AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
