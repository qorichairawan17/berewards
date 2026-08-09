<!-- Modal Pilih Periode Pratinjau Kandidat -->
<div class="modal fade" id="modalSelectPreviewPeriode" tabindex="-1" aria-labelledby="modalSelectPreviewPeriodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalSelectPreviewPeriodeLabel">
                    <i class="ti ti-sparkles text-primary me-2"></i>Pilih Periode Pratinjau Reward
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formPilihPeriodeShowroom">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark fs-12">Pilih Periode Penilaian & Kategori <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg fs-13" id="select_showroom_periode" required>
                            <option value="1" selected>Triwulan II 2026 — Hakim (Pemenang: Rina Agustina, S.H., M.H.)</option>
                            <option value="2">Triwulan II 2026 — Panitera Pengganti (Pemenang: Dian Pratiwi, S.H., M.Kn.)</option>
                            <option value="3">Triwulan II 2026 — Jurusita (Pemenang: Eko Prasetyo, S.H.)</option>
                            <option value="4">Triwulan II 2026 — Staf (Pemenang: Dewi Sartika, S.H.)</option>
                            <option value="5">Triwulan I 2026 — Hakim (Pemenang: Ahmad Faisal, S.H.)</option>
                        </select>
                    </div>
                    <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center gap-2 mb-0 fs-12">
                        <i class="ti ti-info-circle fs-18 flex-shrink-0 text-primary"></i>
                        <div>
                            Menampilkan halaman showroom pratinjau interaktif 3D dengan kartu 3 kandidat reward terbaik berdasarkan hasil TOPSIS.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">
                        <i class="ti ti-sparkles me-1"></i> Buka Halaman Showroom
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
