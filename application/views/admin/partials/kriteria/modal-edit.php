<!-- Modal Edit Kriteria -->
<div class="modal fade" id="modalEditKriteria" tabindex="-1" aria-labelledby="modalEditKriteriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditKriteriaLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Kriteria Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditKriteria">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="edit_id_kriteria" name="id_kriteria">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Kode Kriteria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_kode" name="kode" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Kategori Pegawai <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_kategori" name="kategori" required>
                                <option value="Hakim">Hakim</option>
                                <option value="Panitera Pengganti">Panitera Pengganti</option>
                                <option value="Jurusita">Jurusita</option>
                                <option value="Staf">Staf</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Kriteria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_kriteria" name="nama_kriteria" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12">Bobot (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="edit_bobot" name="bobot" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12">Jenis Data <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jenis_data" name="jenis_data" required>
                                <option value="kualitatif">Kualitatif (Skala 1-5)</option>
                                <option value="kuantitatif">Kuantitatif (Angka Rill)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12">Tipe Atribut <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_tipe_atribut" name="tipe_atribut" required>
                                <option value="benefit">Benefit (Makin Tinggi Makin Baik)</option>
                                <option value="cost">Cost (Makin Rendah Makin Baik)</option>
                            </select>
                        </div>

                        <!-- Sub Kriteria / Skala Rating Builder (Kualitatif Only) -->
                        <div class="col-12 mt-3" id="edit_skala_container">
                            <div class="card border border-warning-subtle bg-warning-subtle bg-opacity-10 rounded-3 p-3 mb-0">
                                <div class="d-flex justify-content-between align-items-center mb-2.5">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0 fs-13 d-flex align-items-center gap-1.5">
                                            <i class="ti ti-list-details text-warning fs-16"></i> Opsi Skala & Sub Kriteria (1 - 5)
                                        </h6>
                                        <span class="text-muted fs-11">Tentukan deskripsi sub kriteria, bobot nilai skala, dan keterangan predikat.</span>
                                    </div>
                                    <button type="button" class="btn btn-xs btn-outline-primary btn-add-skala-row-edit d-flex align-items-center gap-1 fs-11 px-2.5 py-1">
                                        <i class="ti ti-plus fs-13"></i> Tambah Opsi
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered bg-white align-middle mb-0" id="tableEditSkala">
                                        <thead class="table-light">
                                            <tr class="fs-11 text-dark">
                                                <th style="width: 40px;" class="text-center">No</th>
                                                <th>Sub Kriteria</th>
                                                <th style="width: 100px;" class="text-center">Bobot</th>
                                                <th style="width: 150px;">Keterangan</th>
                                                <th style="width: 45px;" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyEditSkala">
                                            <!-- Dynamic rows populated from AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Kriteria</button>
                </div>
            </form>
        </div>
    </div>
</div>
