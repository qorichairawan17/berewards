<!-- Modal Edit Penilaian -->
<div class="modal fade" id="modalEditPenilaian" tabindex="-1" aria-labelledby="modalEditPenilaianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditPenilaianLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Nilai Kriteria Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditPenilaian">
                <input type="hidden" id="edit_id_penilaian" name="id_penilaian">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Pegawai</label>
                            <input type="text" class="form-control bg-light" id="edit_nama_pegawai" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Periode Penilaian</label>
                            <input type="text" class="form-control bg-light" id="edit_nama_periode" readonly>
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="ti ti-checklist text-primary me-1"></i> Perbarui Skor Kriteria
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C1: Kedisiplinan & Kehadiran (1-5)</label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control" id="edit_c1" name="c1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C2: Penyelesaian Perkara / SKP (%)</label>
                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="edit_c2" name="c2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C3: Integritas & Kode Etik (1-5)</label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control" id="edit_c3" name="c3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">C4: Tunggakan Minutasi (Jumlah Berkas)</label>
                            <input type="number" min="0" class="form-control" id="edit_c4" name="c4" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Nilai</button>
                </div>
            </form>
        </div>
    </div>
</div>
