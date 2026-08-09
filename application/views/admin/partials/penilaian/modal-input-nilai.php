<!-- Modal Input Nilai Alternative Pegawai -->
<div class="modal fade" id="modalInputNilaiPegawai" tabindex="-1" aria-labelledby="modalInputNilaiPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalInputNilaiPegawaiLabel">
                    <i class="ti ti-user-plus text-primary me-2"></i>Input Nilai Alternative Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formInputNilaiPegawai">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Pilih Pegawai Kandidat <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_pegawai" required>
                                <option value="" selected disabled>-- Pilih Pegawai --</option>
                                <option value="1">Rina Agustina, S.H., M.H. (NIP: 19750812 200003 1 001 - Hakim)</option>
                                <option value="2">Ahmad Faisal, S.H. (NIP: 19800315 200501 1 004 - Hakim)</option>
                                <option value="3">Rizky Ramadhan, S.H. (NIP: 19830130 200804 1 003 - Hakim)</option>
                                <option value="4">Dian Pratiwi, S.H., M.Kn. (NIP: 19850620 200902 2 008 - Panitera Pengganti)</option>
                                <option value="5">Budi Santoso, S.H. (NIP: 19881110 201101 1 005 - Panitera Pengganti)</option>
                                <option value="6">Siti Aminah, A.Md. (NIP: 19900225 201403 2 006 - Panitera Pengganti)</option>
                                <option value="7">Eko Prasetyo, S.H. (NIP: 19910514 201502 1 007 - Jurusita)</option>
                                <option value="8">Nurfadillah, S.E. (NIP: 19930708 201601 2 003 - Jurusita)</option>
                                <option value="9">Hendra Wijaya, S.H. (NIP: 19920919 201703 1 002 - Staf)</option>
                                <option value="10">Dewi Sartika, S.H. (NIP: 19941201 201802 2 009 - Staf)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C1: Kedisiplinan Kehadiran (Skala 1 - 5) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control" name="c1" placeholder="Contoh: 4.8" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C2: Produktivitas Perkara / Tugas (Skor 0 - 100) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" min="0" max="100" class="form-control" name="c2" placeholder="Contoh: 95.5" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C3: Integritas & Kepatuhan (Skala 1 - 5) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control" name="c3" placeholder="Contoh: 4.9" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C4: Inovasi & Pelayanan (Skala 1 - 5) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control" name="c4" placeholder="Contoh: 4.5" required>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-2 mb-0 fs-12">
                                <i class="ti ti-info-circle fs-18 flex-shrink-0 text-info"></i>
                                <div>
                                    Nilai kriteria yang dimasukkan akan secara otomatis diproses dalam matriks keputusan $X_{ij}$ dan dinormalisasi untuk kalkulasi TOPSIS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Nilai Alternative</button>
                </div>
            </form>
        </div>
    </div>
</div>
