<!-- Modal Tambah Pegawai -->
<div class="modal fade" id="modalTambahPegawai" tabindex="-1" aria-labelledby="modalTambahPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahPegawaiLabel">
                    <i class="ti ti-user-plus text-primary me-2"></i>Tambah Data Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahPegawai" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">NIP Pegawai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nip" placeholder="Contoh: 19850620 200902 2 008" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama lengkap serta gelar resmi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Pangkat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pangkat" placeholder="Contoh: Pembina Utama Muda" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Golongan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="golongan" placeholder="Contoh: IV/c" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" placeholder="Contoh: Hakim Utama" required>
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
                            <label class="form-label fw-semibold text-dark fs-12">Foto Profil (JPG/PNG)</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            <small class="text-muted fs-11">Format yang didukung: JPG, JPEG, PNG. Maksimal ukuran 2 MB.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
