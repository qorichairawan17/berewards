<!-- Modal Edit Pegawai -->
<div class="modal fade" id="modalEditPegawai" tabindex="-1" aria-labelledby="modalEditPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditPegawaiLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Data Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditPegawai" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="edit_id" name="id_pegawai">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">NIP Pegawai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nip" name="nip" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Pangkat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_pangkat" name="pangkat" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Golongan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_golongan" name="golongan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_jabatan" name="jabatan" required>
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
                            <label class="form-label fw-semibold text-dark fs-12">Ganti Foto Profil (JPG/PNG)</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="" id="edit_preview_foto" alt="Preview Foto" class="rounded-circle border shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                <input type="file" class="form-control" name="foto" accept="image/*">
                            </div>
                            <small class="text-muted fs-11">Kosongkan jika tidak ingin mengubah foto profil yang ada.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
