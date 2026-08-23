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
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Pilih Pegawai Terkait -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Pilih Pegawai (Wajib) <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_pegawai" id="add_id_pegawai" required>
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
                            <div id="add_pegawai_preview" class="p-2.5 mt-2 bg-light rounded border border-primary-subtle d-none">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-xs rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold fs-12">
                                            <i class="ti ti-user-check"></i>
                                        </div>
                                        <div>
                                            <strong id="add_prev_nama" class="d-block text-dark fs-12 fw-semibold">-</strong>
                                            <small id="add_prev_jabatan" class="text-muted fs-11">-</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span id="add_prev_nip" class="badge bg-white text-dark border px-2 py-1 fs-10 font-monospace">-</span>
                                        <span id="add_prev_kategori" class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-10">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Username & Nama Lengkap -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Username Login <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_username" name="username" placeholder="Contoh: panitera.dian" required>
                            <small class="text-muted fs-11">Username unik untuk login ke sistem.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_nama_user" name="nama_user" placeholder="Nama otomatis terisi saat pegawai dipilih" required>
                        </div>

                        <!-- Email & Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Email Instansi</label>
                            <input type="email" class="form-control" id="add_email" name="email" placeholder="Contoh: pegawai@pn-lubukpakam.go.id">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Password Login <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="add_password" name="password" placeholder="Minimal 4 karakter" required>
                        </div>

                        <!-- Role & Status -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Hak Akses Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_role" name="role" required>
                                <option value="" selected disabled>-- Pilih Role Akses --</option>
                                <option value="superadmin">Superadmin</option>
                                <option value="administrator">Administrator</option>
                                <option value="tim_penilai">Tim Penilai</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Akun <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_status" name="status" required>
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
