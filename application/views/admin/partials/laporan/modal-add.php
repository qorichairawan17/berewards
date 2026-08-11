<!-- Modal Buat Berita Acara Baru -->
<div class="modal fade" id="modalTambahLaporan" tabindex="-1" aria-labelledby="modalTambahLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahLaporanLabel">
                    <i class="ti ti-file-plus text-primary me-2"></i>Buat Berita Acara Penetapan Reward
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahLaporan">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nomor Berita Acara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_ba" value="W2.U4/05/BA.SPK/06/2026" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Periode Evaluasi <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_periode" required>
                                <option value="1" selected>Triwulan II 2026</option>
                                <option value="3">Semester I 2026</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Kategori Pegawai <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori" required>
                                <option value="Hakim">Hakim</option>
                                <option value="Panitera Pengganti">Panitera Pengganti</option>
                                <option value="Jurusita">Jurusita</option>
                                <option value="Staf">Staf</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Tanggal Penerbitan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 datepicker-input" id="add_tanggal_terbit" name="tanggal_terbit" placeholder="Pilih Tanggal Terbit" value="2026-06-30" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Ketua Tim Penilai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ketua_panitia" value="Dr. H. Ahmad Syafi'i, S.H., M.H." required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Generate Berita Acara</button>
                </div>
            </form>
        </div>
    </div>
</div>
