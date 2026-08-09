<!-- Modal Edit Berita Acara -->
<div class="modal fade" id="modalEditLaporan" tabindex="-1" aria-labelledby="modalEditLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditLaporanLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Berita Acara
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditLaporan">
                <input type="hidden" id="edit_id_laporan" name="id_laporan">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nomor Berita Acara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_no_ba" name="no_ba" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Dokumen <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="Disahkan">Disahkan</option>
                                <option value="Draft">Draft</option>
                                <option value="Arsip">Arsip</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Tanggal Penerbitan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_tanggal_terbit" name="tanggal_terbit" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Ketua Tim Penilai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_ketua_panitia" name="ketua_panitia" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>
