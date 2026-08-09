<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahUserLabel">
                    <i class="ti ti-user-plus text-primary me-2"></i>Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahUser">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" placeholder="Contoh: panitera.dian" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_user" placeholder="Contoh: Dian Pratiwi, S.H., M.Kn." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Email Instansi <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Contoh: dian.pratiwi@pn-lubukpakam.go.id" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Password Login <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Hak Akses Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="" selected disabled>-- Pilih Role --</option>
                                <option value="Superadmin">Superadmin</option>
                                <option value="Administrator">Administrator</option>
                                <option value="Tim Penilai">Tim Penilai</option>
                                <option value="Pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Akun <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
