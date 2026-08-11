<!-- Modal Tambah SK Tim Penilai -->
<div class="modal fade" id="modalTambahTim" tabindex="-1" aria-labelledby="modalTambahTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white p-3">
                <h5 class="modal-header-title fw-bold text-white mb-0 fs-16" id="modalTambahTimLabel">
                    <i class="ti ti-plus me-1"></i> Tambah SK Tim Penilai Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahTim">
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
                                <input type="text" class="form-control border-start-0" placeholder="Contoh: W2.U4/01/SK.TIM-SPK/01/2026" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Tahun Evaluasi <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" value="<?= date('Y'); ?>" min="2020" max="2035" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Tanggal Terbit SK <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 datepicker-input" id="add_tanggal_sk" placeholder="Pilih Tanggal Terbit SK" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Status SK <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Arsip">Arsip</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Perihal SK <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" placeholder="Contoh: SK Penetapan Tim Penilai SPK Penentuan Reward Pegawai Tahun 2026" required></textarea>
                        </div>

                        <!-- Section 2: Unsur Pimpinan Tim Penilai -->
                        <div class="col-12 border-bottom pb-2 mt-4 mb-2">
                            <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Pimpinan Tim Penilai</span>
                            <h6 class="fw-bold text-dark mb-0 fs-14">Ketua & Sekretaris Tim Penilai</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Ketua Tim Penilai <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">-- Pilih Ketua Tim Penilai --</option>
                                <option value="1" selected>Dr. H. Ahmad Syafi'i, S.H., M.H. (Ketua PN)</option>
                                <option value="2">Hj. Fitriani, S.H., M.H. (Wakil Ketua PN)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Sekretaris Tim Penilai <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">-- Pilih Sekretaris Tim --</option>
                                <option value="5" selected>Drs. Muhammad Rizky (Sekretaris PN)</option>
                                <option value="4">Bambang Wijaya, S.H., M.H. (Panitera PN)</option>
                            </select>
                        </div>

                        <!-- Section 3: Input Fleksibel Anggota Tim Penilai (Multi-Member Dynamic Input with Multicheck Categories) -->
                        <div class="col-12 border-bottom pb-2 mt-4 mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Personel Tim Penilai Fleksibel</span>
                                <h6 class="fw-bold text-dark mb-0 fs-14">Daftar Anggota Tim Penilai (Multicheck Kategori Penilaian)</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" id="btnAddAddMemberRow">
                                <i class="ti ti-plus me-1"></i> Tambah Baris Anggota
                            </button>
                        </div>

                        <div class="col-12">
                            <div id="addMemberListContainer" class="d-flex flex-column gap-2">
                                <!-- Baris Anggota 1 -->
                                <div class="member-row p-3 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-3">
                                    <div class="flex-grow-1" style="min-width: 250px;">
                                        <label class="form-label fw-semibold text-dark fs-11 mb-1">Nama & NIP Pegawai Anggota <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="anggota_pegawai[]" required>
                                            <option value="">-- Pilih Pegawai Anggota Tim --</option>
                                            <option value="2" selected>Hj. Fitriani, S.H., M.H. (Wakil Ketua PN)</option>
                                            <option value="4">Bambang Wijaya, S.H., M.H. (Panitera PN)</option>
                                            <option value="9">Dewi Sartika, S.H. (Kasubbag Kepegawaian)</option>
                                            <option value="7">Eko Prasetyo, S.H. (Jurusita)</option>
                                            <option value="8">Nurfadillah, S.E. (Staf)</option>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 320px;">
                                        <label class="form-label fw-semibold text-dark fs-11 mb-1">
                                            <i class="ti ti-check-check text-primary me-1"></i> Kategori Pegawai yang Dinilai (Bisa Pilih > 1)
                                        </label>
                                        <div class="d-flex flex-wrap align-items-center gap-2 p-2 bg-white rounded border">
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_hakim_1" name="add_kategori_1[]" value="Hakim" checked>
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_hakim_1">Hakim</label>
                                            </div>
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_pp_1" name="add_kategori_1[]" value="Panitera Pengganti" checked>
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_pp_1">Panitera Pengganti</label>
                                            </div>
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_jurusita_1" name="add_kategori_1[]" value="Jurusita">
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_jurusita_1">Jurusita</label>
                                            </div>
                                            <div class="form-check form-check-inline me-0 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_staf_1" name="add_kategori_1[]" value="Staf">
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_staf_1">Staf</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-self-end ms-auto">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-member-row" title="Hapus Baris Anggota">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Baris Anggota 2 -->
                                <div class="member-row p-3 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-3">
                                    <div class="flex-grow-1" style="min-width: 250px;">
                                        <label class="form-label fw-semibold text-dark fs-11 mb-1">Nama & NIP Pegawai Anggota <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="anggota_pegawai[]">
                                            <option value="">-- Pilih Pegawai Anggota Tim --</option>
                                            <option value="2">Hj. Fitriani, S.H., M.H. (Wakil Ketua PN)</option>
                                            <option value="4" selected>Bambang Wijaya, S.H., M.H. (Panitera PN)</option>
                                            <option value="9">Dewi Sartika, S.H. (Kasubbag Kepegawaian)</option>
                                            <option value="7">Eko Prasetyo, S.H. (Jurusita)</option>
                                            <option value="8">Nurfadillah, S.E. (Staf)</option>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 320px;">
                                        <label class="form-label fw-semibold text-dark fs-11 mb-1">
                                            <i class="ti ti-check-check text-primary me-1"></i> Kategori Pegawai yang Dinilai (Bisa Pilih > 1)
                                        </label>
                                        <div class="d-flex flex-wrap align-items-center gap-2 p-2 bg-white rounded border">
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_hakim_2" name="add_kategori_2[]" value="Hakim">
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_hakim_2">Hakim</label>
                                            </div>
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_pp_2" name="add_kategori_2[]" value="Panitera Pengganti" checked>
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_pp_2">Panitera Pengganti</label>
                                            </div>
                                            <div class="form-check form-check-inline me-2 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_jurusita_2" name="add_kategori_2[]" value="Jurusita" checked>
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_jurusita_2">Jurusita</label>
                                            </div>
                                            <div class="form-check form-check-inline me-0 mb-0">
                                                <input class="form-check-input" type="checkbox" id="add_cat_staf_2" name="add_kategori_2[]" value="Staf" checked>
                                                <label class="form-check-label fs-11 fw-semibold text-dark pointer" for="add_cat_staf_2">Staf</label>
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

                        <!-- Section 4: Upload Dokumen -->
                        <div class="col-12 mt-3">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Unggah Dokumen SK (.pdf)</label>
                            <input type="file" class="form-control" accept=".pdf">
                            <small class="text-muted fs-11">Format yang didukung: PDF resmi bertanda tangan (maks. 5 MB).</small>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand px-4 shadow-sm">
                        <i class="ti ti-check me-1"></i> Simpan SK Tim Penilai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
