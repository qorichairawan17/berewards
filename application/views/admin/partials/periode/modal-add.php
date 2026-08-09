<!-- Modal Tambah Periode -->
<div class="modal fade" id="modalTambahPeriode" tabindex="-1" aria-labelledby="modalTambahPeriodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahPeriodeLabel">
                    <i class="ti ti-calendar-plus text-primary me-2"></i>Tambah Periode Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahPeriode">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Periode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_periode" placeholder="Contoh: Triwulan III 2026" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12">Jenis Siklus <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenis_periode" required>
                                <option value="triwulan" selected>Triwulan</option>
                                <option value="semester">Semester</option>
                                <option value="tahunan">Tahunan</option>
                                <option value="bulanan">Bulanan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12">Tahun Anggaran <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tahun" value="2026" min="2020" max="2030" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_selesai" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Akses <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="buka" selected>Buka (Aktif untuk Penilaian)</option>
                                <option value="tutup">Tutup (Final / Terkunci)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Keterangan Catatan</label>
                            <textarea class="form-control" name="keterangan" rows="2" placeholder="Catatan singkat mengenai periode penilaian ini..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>
