<!-- Modal Edit Audit Log -->
<div class="modal fade" id="modalEditAudit" tabindex="-1" aria-labelledby="modalEditAuditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditAuditLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Catatan Audit Log
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditAudit">
                <input type="hidden" id="edit_id_audit" name="id_audit">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Username Pengguna</label>
                            <input type="text" class="form-control bg-light" id="edit_username" name="username" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Waktu Timestamp</label>
                            <input type="text" class="form-control bg-light" id="edit_timestamp" name="timestamp" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Modul Terkait <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_modul" name="modul" required>
                                <option value="Autentikasi Login">Autentikasi Login</option>
                                <option value="Data Pegawai">Data Pegawai</option>
                                <option value="Kriteria Penilaian">Kriteria Penilaian</option>
                                <option value="Periode Penilaian">Periode Penilaian</option>
                                <option value="Penilaian & TOPSIS">Penilaian & TOPSIS</option>
                                <option value="Laporan & Berita Acara">Laporan & Berita Acara</option>
                                <option value="Manajemen Pengguna">Manajemen Pengguna</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Hasil <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="Sukses">Sukses</option>
                                <option value="Gagal">Gagal / Peringatan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Deskripsi Aktivitas Audit <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_aktivitas" name="aktivitas" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Audit Log</button>
                </div>
            </form>
        </div>
    </div>
</div>
