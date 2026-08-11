<!-- Modal Edit SK Tim Penilai -->
<div class="modal fade" id="modalEditTim" tabindex="-1" aria-labelledby="modalEditTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white p-3">
                <h5 class="modal-header-title fw-bold text-white mb-0 fs-16" id="modalEditTimLabel">
                    <i class="ti ti-edit me-1"></i> Edit Data SK & Personel Tim Penilai
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditTim">
                <input type="hidden" id="edit_id_sk" name="id_sk">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <!-- Section 1: Informasi Dokumen SK -->
                        <div class="col-12 border-bottom pb-2 mb-2">
                            <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Identitas Surat Keputusan</span>
                            <h6 class="fw-bold text-dark mb-0 fs-14">Data Utama Dokumen SK</h6>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Nomor SK Penetapan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-file-text text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="edit_no_sk" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Tahun Evaluasi <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_tahun" min="2020" max="2035" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Tanggal Terbit SK <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 datepicker-input" id="edit_tanggal_sk" placeholder="Pilih Tanggal Terbit SK" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Status SK <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Arsip">Arsip</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Perihal SK <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_perihal" rows="2" required></textarea>
                        </div>

                        <!-- Section 2: Input Fleksibel Anggota Tim Penilai (Multi-Member Dynamic Input with Multicheck Categories) -->
                        <div class="col-12 border-bottom pb-2 mt-4 mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Personel Tim Penilai Fleksibel</span>
                                <h6 class="fw-bold text-dark mb-0 fs-14">Daftar Anggota Tim Penilai (Multicheck Kategori Penilaian)</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" id="btnEditAddMemberRow">
                                <i class="ti ti-plus me-1"></i> Tambah Baris Anggota
                            </button>
                        </div>

                        <div class="col-12">
                            <div id="editMemberListContainer" class="d-flex flex-column gap-2">
                                <!-- Baris Anggota Edit 1 -->
                                <div class="member-row p-3 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-3">
                                    <div class="flex-grow-1" style="min-width: 250px;">
                                        <label class="form-label fw-semibold text-dark fs-11 mb-1">Nama & NIP Pegawai Anggota <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="edit_anggota_pegawai[]">
                                            <option value="2" selected>Hj. Fitriani, S.H., M.H. (Wakil Ketua PN)</option>
                                            <option value="4">Bambang Wijaya, S.H., M.H. (Panitera PN)</option>
                                            <option value="9">Dewi Sartika, S.H. (Kasubbag Kepegawaian)</option>
                                            <option value="7">Eko Prasetyo, S.H. (Jurusita)</option>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 320px;">
                                        <label class="form-label fw-semibold text-dark fs-11 mb-1">
                                            <i class="ti ti-check-check text-primary me-1"></i> Kategori Pegawai yang Dinilai (Bisa Pilih > 1)
                                        </label>
                                        <div class="d-flex flex-wrap align-items-center gap-2 p-2 bg-white rounded border">
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="edit_cat_hakim_1" name="edit_kategori_1[]" value="Hakim" checked>
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="edit_cat_hakim_1">Hakim</label>
                                            </div>
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="edit_cat_pp_1" name="edit_kategori_1[]" value="Panitera Pengganti" checked>
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="edit_cat_pp_1">Panitera Pengganti</label>
                                            </div>
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="edit_cat_jurusita_1" name="edit_kategori_1[]" value="Jurusita">
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="edit_cat_jurusita_1">Jurusita</label>
                                            </div>
                                            <div class="form-check form-check-inline me-0 mb-0">
                                                <input class="form-check-input" type="checkbox" id="edit_cat_staf_1" name="edit_kategori_1[]" value="Staf">
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="edit_cat_staf_1">Staf</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-self-end ms-auto">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-member-row" title="Hapus Baris Anggota">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Ganti Dokumen SK (.pdf)</label>
                            <input type="file" class="form-control" accept=".pdf">
                            <small class="text-muted fs-11">Kosongkan jika tidak ingin mengubah dokumen SK PDF yang ada.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand px-4 shadow-sm">
                        <i class="ti ti-check me-1"></i> Perbarui SK
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
