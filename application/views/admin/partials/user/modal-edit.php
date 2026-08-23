<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditUserLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Data Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditUser">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="edit_id_user" name="id_user">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Pilih Pegawai Terkait -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Pilih Pegawai Terkait <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_pegawai" id="edit_id_pegawai" required>
                                <option value="" selected disabled>-- Pilih Pegawai dari Referensi --</option>
                                <?php if (!empty($pegawai_list)): ?>
                                    <?php foreach ($pegawai_list as $p): ?>
                                        <option value="<?= $p['id_pegawai']; ?>"
                                                data-nama="<?= html_escape($p['nama']); ?>"
                                                data-nip="<?= html_escape($p['nip']); ?>"
                                                data-jabatan="<?= html_escape($p['jabatan']); ?>"
                                                data-kategori="<?= html_escape($p['kategori']); ?>">
                                            <?= html_escape($p['nama']); ?> &bull; <?= html_escape($p['nip']); ?> (<?= html_escape($p['kategori']); ?> - <?= html_escape($p['jabatan']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div id="edit_pegawai_preview" class="p-2.5 mt-2 bg-light rounded border border-primary-subtle d-none">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-xs rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold fs-12">
                                            <i class="ti ti-user-check"></i>
                                        </div>
                                        <div>
                                            <strong id="edit_prev_nama" class="d-block text-dark fs-12 fw-semibold">-</strong>
                                            <small id="edit_prev_jabatan" class="text-muted fs-11">-</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span id="edit_prev_nip" class="badge bg-white text-dark border px-2 py-1 fs-10 font-monospace">-</span>
                                        <span id="edit_prev_kategori" class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-10">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Username & Nama Lengkap -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Username Login <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" id="edit_username" name="username" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_user" name="nama_user" required>
                        </div>

                        <!-- Email & Reset Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Email Instansi</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Reset Password (Opsional)</label>
                            <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <!-- Role & Status -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Hak Akses Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="superadmin">Superadmin</option>
                                <option value="administrator">Administrator</option>
                                <option value="tim_penilai">Tim Penilai</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Akun <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
