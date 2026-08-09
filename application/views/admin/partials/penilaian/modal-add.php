<!-- Modal Input Penilaian -->
<div class="modal fade" id="modalTambahPenilaian" tabindex="-1" aria-labelledby="modalTambahPenilaianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahPenilaianLabel">
                    <i class="ti ti-plus text-primary me-2"></i>Input Nilai Kriteria Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahPenilaian">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Periode Penilaian <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_periode" required>
                                <option value="1" selected>Triwulan II 2026 (Aktif)</option>
                                <option value="3">Semester I 2026</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Pilih Pegawai Kandidat <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_pegawai" required>
                                <option value="" selected disabled>-- Pilih Pegawai --</option>
                                <option value="1">Rina Agustina, S.H., M.H. (Hakim)</option>
                                <option value="2">Ahmad Faisal, S.H. (Hakim)</option>
                                <option value="4">Dian Pratiwi, S.H., M.Kn. (Panitera Pengganti)</option>
                                <option value="7">Eko Prasetyo, S.H. (Jurusita)</option>
                                <option value="10">Dewi Sartika, S.H. (Staf)</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="ti ti-checklist text-primary me-1"></i> Form Skor Kriteria Penilaian
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C1: Kedisiplinan & Kehadiran (1-5)</label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control" name="c1" placeholder="Skor 1.0 - 5.0" value="4.8" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C2: Penyelesaian Perkara / SKP (%)</label>
                            <input type="number" step="0.01" min="0" max="100" class="form-control" name="c2" placeholder="Nilai 0 - 100" value="95.5" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C3: Integritas & Kode Etik (1-5)</label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control" name="c3" placeholder="Skor 1.0 - 5.0" value="4.9" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C4: Tunggakan Minutasi (Jumlah Berkas)</label>
                            <input type="number" min="0" class="form-control" name="c4" placeholder="Angka 0 dst." value="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Nilai & Hitung</button>
                </div>
            </form>
        </div>
    </div>
</div>
