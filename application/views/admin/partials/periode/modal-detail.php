<!-- Modal Detail Periode -->
<div class="modal fade" id="modalDetailPeriode" tabindex="-1" aria-labelledby="modalDetailPeriodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailPeriodeLabel">
                    <i class="ti ti-calendar-event text-primary me-2"></i>Informasi Periode
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="user-avatar-lg mx-auto bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-20 mb-3" style="width:58px; height:58px;">
                    <i class="ti ti-calendar fs-28"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1" id="detail_nama_periode">-</h5>
                <p class="text-muted fs-12 mb-3" id="detail_tahun_jenis">-</p>

                <div class="card bg-light border-0 p-3 text-start mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Rentang Tanggal</span>
                            <strong class="d-block text-dark fs-12" id="detail_rentang_tanggal">-</strong>
                        </div>
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Status Akses</span>
                            <span id="detail_status_badge">-</span>
                        </div>
                        <div class="col-12 mt-3">
                            <span class="d-block text-muted fs-11 mb-1">Keterangan Catatan</span>
                            <p class="text-dark fs-12 mb-0 bg-white p-2 rounded border" id="detail_keterangan">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
