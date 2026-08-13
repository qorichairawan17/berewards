<!-- Modal Edit Periode -->
<div class="modal fade" id="modalEditPeriode" tabindex="-1" aria-labelledby="modalEditPeriodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditPeriodeLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Periode Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditPeriode">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="edit_id_periode" name="id_periode">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Periode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_periode" name="nama_periode" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12">Jenis Siklus <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jenis_periode" name="jenis_periode" required>
                                <option value="triwulan">Triwulan</option>
                                <option value="semester">Semester</option>
                                <option value="tahunan">Tahunan</option>
                                <option value="bulanan">Bulanan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12">Tahun Anggaran <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_tahun" name="tahun" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Tanggal Mulai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 datepicker-input" id="edit_tanggal_mulai" name="tanggal_mulai" placeholder="Pilih Tanggal Mulai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Tanggal Selesai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 datepicker-input" id="edit_tanggal_selesai" name="tanggal_selesai" placeholder="Pilih Tanggal Selesai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Akses <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="buka">Buka (Aktif untuk Penilaian)</option>
                                <option value="tutup">Tutup (Final / Terkunci)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Keterangan Catatan</label>
                            <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>
