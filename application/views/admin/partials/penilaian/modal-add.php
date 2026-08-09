<!-- Modal Buat Sesi Penilaian Baru -->
<div class="modal fade" id="modalTambahPenilaian" tabindex="-1" aria-labelledby="modalTambahPenilaianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahPenilaianLabel">
                    <i class="ti ti-calendar-plus text-primary me-2"></i>Buat Sesi Penilaian TOPSIS Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahPenilaian">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Pilih Periode Penilaian <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_periode" required>
                                <option value="" selected disabled>-- Pilih Periode Penilaian --</option>
                                <option value="1">Triwulan II 2026</option>
                                <option value="2">Triwulan I 2026</option>
                                <option value="3">Semester I 2026</option>
                                <option value="4">Triwulan IV 2025</option>
                                <option value="5">Tahunan 2025</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Kategori Target Penilaian <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori_target" required>
                                <option value="Semua" selected>Semua Kategori (Hakim, PP, Jurusita, Staf)</option>
                                <option value="Hakim">Hakim</option>
                                <option value="Panitera Pengganti">Panitera Pengganti</option>
                                <option value="Jurusita">Jurusita</option>
                                <option value="Staf">Staf</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center gap-2 mb-0 fs-12">
                                <i class="ti ti-info-circle fs-18 flex-shrink-0 text-warning"></i>
                                <div>
                                    <strong>Status Sesi Otomatis DRAFT:</strong> Sesi penilaian baru akan secara otomatis berstatus <strong>Draft</strong>. Anda dapat mengklik tombol <strong>Detail</strong> untuk menginput nilai kriteria alternatif pegawai, lalu menekan tombol <strong>Proses Perhitungan TOPSIS</strong> untuk mengubah status menjadi <strong>Final</strong>.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Catatan Sesi Penilaian</label>
                            <textarea class="form-control" name="catatan" rows="2" placeholder="Catatan singkat mengenai pembentukan sesi penilaian ini..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Buat Sesi Penilaian (Status Draft)</button>
                </div>
            </form>
        </div>
    </div>
</div>
