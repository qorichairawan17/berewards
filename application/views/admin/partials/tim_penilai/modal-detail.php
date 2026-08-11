<!-- Modal Detail Quick Preview SK Tim Penilai -->
<div class="modal fade" id="modalDetailTim" tabindex="-1" aria-labelledby="modalDetailTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-bottom border-light p-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary p-2 rounded-circle"><i class="ti ti-file-certificate fs-18"></i></span>
                    <div>
                        <small class="text-primary fw-bold fs-10 text-uppercase tracking-wider">Pratinjau Ringkas</small>
                        <h5 class="fw-bold text-dark mb-0 fs-16" id="preview_no_sk">Nomor SK</h5>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Tahun Evaluasi</small>
                            <strong class="text-dark fs-14" id="preview_tahun">-</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Tanggal Terbit SK</small>
                            <strong class="text-dark fs-14" id="preview_tanggal_sk">-</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Status SK</small>
                            <span id="preview_status_badge" class="badge bg-success rounded-pill px-2 py-1 fs-11 mt-1">Aktif</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold mb-1">Perihal SK Penetapan</small>
                            <p class="text-dark fs-13 mb-0" id="preview_perihal">-</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Personnel List -->
                <div class="mb-3">
                    <h6 class="fw-bold text-dark fs-13 mb-2"><i class="ti ti-users text-primary me-1"></i> Susunan Pimpinan Tim Penilai:</h6>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="p-2 rounded bg-light border d-flex align-items-center gap-2">
                                <div class="avatar-sm rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px; height:36px;">K</div>
                                <div>
                                    <small class="text-primary fw-bold fs-10 text-uppercase d-block">Ketua Tim</small>
                                    <strong class="text-dark fs-12 d-block" id="preview_ketua_nama">-</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2 rounded bg-light border d-flex align-items-center gap-2">
                                <div class="avatar-sm rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px; height:36px;">S</div>
                                <div>
                                    <small class="text-success fw-bold fs-10 text-uppercase d-block">Sekretaris Tim</small>
                                    <strong class="text-dark fs-12 d-block" id="preview_sekretaris_nama">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light p-3 border-top d-flex justify-content-between">
                <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Tutup</button>
                <a href="#" id="btnFullDetailLink" class="btn btn-brand px-4 shadow-sm">
                    <i class="ti ti-external-link me-1"></i> Buka Halaman Rincian Selengkapnya
                </a>
            </div>
        </div>
    </div>
</div>
