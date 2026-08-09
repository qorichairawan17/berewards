<!-- Modal Tambah Kriteria -->
<div class="modal fade" id="modalTambahKriteria" tabindex="-1" aria-labelledby="modalTambahKriteriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahKriteriaLabel">
                    <i class="ti ti-plus text-primary me-2"></i>Tambah Kriteria Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahKriteria">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Kode Kriteria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode" placeholder="Contoh: C1_HKM" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Kategori Pegawai <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <option value="Hakim">Hakim</option>
                                <option value="Panitera Pengganti">Panitera Pengganti</option>
                                <option value="Jurusita">Jurusita</option>
                                <option value="Staf">Staf</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Kriteria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_kriteria" placeholder="Contoh: Kedisiplinan Kehadiran & Jam Kerja" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12">Bobot (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" max="100" class="form-control" name="bobot" placeholder="Contoh: 25.00" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12">Jenis Data <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenis_data" required>
                                <option value="kualitatif">Kualitatif (Skala 1-5)</option>
                                <option value="kuantitatif">Kuantitatif (Angka Rill)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12">Tipe Atribut <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipe_atribut" required>
                                <option value="benefit">Benefit (Makin Tinggi Makin Baik)</option>
                                <option value="cost">Cost (Makin Rendah Makin Baik)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Kriteria</button>
                </div>
            </form>
        </div>
    </div>
</div>
