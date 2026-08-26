<!-- Main Profile Detail & Edit Form Panel -->
<div class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom border-light p-3">
        <ul class="nav nav-tabs card-header-tabs nav-bordered border-0" id="profile-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-dark fs-13 py-2 px-3" id="profile-tabs-tab-info" data-bs-toggle="tab" data-bs-target="#profile-tab-info" type="button" role="tab" aria-controls="profile-tab-info" aria-selected="true">
                    <i class="ti ti-user me-1 text-primary"></i> Data Profil & Kepegawaian
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark fs-13 py-2 px-3" id="profile-tabs-tab-edit" data-bs-toggle="tab" data-bs-target="#profile-tab-edit" type="button" role="tab" aria-controls="profile-tab-edit" aria-selected="false">
                    <i class="ti ti-edit me-1 text-primary"></i> Edit Informasi Profil
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark fs-13 py-2 px-3" id="profile-tabs-tab-security" data-bs-toggle="tab" data-bs-target="#profile-tab-security" type="button" role="tab" aria-controls="profile-tab-security" aria-selected="false">
                    <i class="ti ti-lock me-1 text-primary"></i> Ubah Password & Keamanan
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="tab-content" id="profile-tabs-content">
            <!-- TAB 1: Detail Informasi Profil (Read Only Overview) -->
            <div class="tab-pane fade show active" id="profile-tab-info" role="tabpanel" aria-labelledby="profile-tabs-tab-info">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Identitas Pengguna</span>
                        <h5 class="fw-bold text-dark mb-0">Rincian Data Profil Sistem</h5>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-11">
                        <i class="ti ti-check-check me-1"></i> Data Terverifikasi
                    </span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Nama Lengkap & Gelar</small>
                            <span class="fw-bold text-dark fs-14" id="overview_nama_lengkap"><?= html_escape($user['nama_lengkap']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Username Login</small>
                            <span class="fw-bold text-primary fs-14" id="overview_username">@<?= html_escape($user['username']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Nomor Induk Pegawai (NIP)</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_nip"><?= html_escape($user['nip']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Nomor Induk Kependudukan (NIK)</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_nik"><?= html_escape($user['nik']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Jabatan Kedinasan</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_jabatan"><?= html_escape($user['jabatan']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Unit Kerja / Satuan Kerja</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_unit_kerja"><?= html_escape($user['unit_kerja']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Alamat Email Kedinasan</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_email"><?= html_escape($user['email']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Nomor Telepon / WhatsApp</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_no_hp"><?= html_escape($user['no_hp']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Hak Akses Role</small>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-11 mt-1" id="overview_role">
                                <i class="ti ti-shield me-1"></i><?= html_escape($user['role']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Tanggal Bergabung</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_tgl_bergabung"><?= date('d F Y', strtotime($user['tgl_bergabung'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Edit Form Profil -->
            <div class="tab-pane fade" id="profile-tab-edit" role="tabpanel" aria-labelledby="profile-tabs-tab-edit">
                <div class="mb-4">
                    <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Formulir Pembaruan</span>
                    <h5 class="fw-bold text-dark mb-1">Perbarui Informasi Kontak & Biodata</h5>
                    <p class="text-muted fs-12 mb-0">Ubah data profil pribadi Anda. Perubahan akan langsung disinkronkan ke akun dan data kepegawaian Anda.</p>
                </div>

                <form id="formEditProfile" action="<?= site_url('profile/update'); ?>" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_nama_lengkap">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-user text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="prof_nama_lengkap" name="nama_lengkap" value="<?= html_escape($user['nama_lengkap']); ?>" placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_username">Username Login <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-at text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 text-muted" id="prof_username" name="username" value="<?= html_escape($user['username']); ?>" readonly style="background-color: #F8FAFC;">
                            </div>
                            <small class="text-muted fs-11">Username digunakan untuk login dan tidak dapat diubah sendiri.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_nip">Nomor Induk Pegawai (NIP)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-id text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="prof_nip" name="nip" value="<?= ($user['nip'] !== '-') ? html_escape($user['nip']) : ''; ?>" placeholder="Masukkan NIP">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_nik">Nomor Induk Kependudukan (NIK)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-credit-card text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="prof_nik" name="nik" value="<?= ($user['nik'] !== '-') ? html_escape($user['nik']) : ''; ?>" placeholder="Masukkan 16 digit NIK">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_email">Email Instansi Kedinasan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-mail text-muted"></i></span>
                                <input type="email" class="form-control border-start-0" id="prof_email" name="email" value="<?= ($user['email'] !== '-') ? html_escape($user['email']) : ''; ?>" placeholder="nama@pn-lubukpakam.go.id" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_no_hp">Nomor Telepon / WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-phone text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="prof_no_hp" name="no_hp" value="<?= ($user['no_hp'] !== '-') ? html_escape($user['no_hp']) : ''; ?>" placeholder="08xx-xxxx-xxxx">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_jabatan">Jabatan Kedinasan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-briefcase text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="prof_jabatan" name="jabatan" value="<?= html_escape($user['jabatan']); ?>" placeholder="Masukkan jabatan kedinasan">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_unit_kerja">Unit Kerja / Satuan Kerja</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-building-bank text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 text-muted" id="prof_unit_kerja" name="unit_kerja" value="<?= html_escape($user['unit_kerja']); ?>" readonly style="background-color: #F8FAFC;">
                            </div>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light px-4" onclick="document.getElementById('profile-tabs-tab-info').click();">Batal</button>
                            <button type="submit" class="btn btn-brand px-4 shadow-sm" id="btnSaveProfile">
                                <i class="ti ti-check me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TAB 3: Ubah Password & Security Form -->
            <div class="tab-pane fade" id="profile-tab-security" role="tabpanel" aria-labelledby="profile-tabs-tab-security">
                <div class="mb-4">
                    <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Keamanan Akun</span>
                    <h5 class="fw-bold text-dark mb-1">Perbarui Password & Akses Kredensial</h5>
                    <p class="text-muted fs-12 mb-0">Pastikan password Anda menggunakan minimal 8 karakter dengan kombinasi huruf dan angka untuk keamanan maksimal.</p>
                </div>

                <form id="formChangePassword" action="<?= site_url('profile/update_password'); ?>" method="POST">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_current_password">Password Saat Ini <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-key text-muted"></i></span>
                                <input type="password" class="form-control border-start-0" id="prof_current_password" name="current_password" placeholder="Masukkan password lama Anda" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_new_password">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-lock text-muted"></i></span>
                                <input type="password" class="form-control border-start-0" id="prof_new_password" name="new_password" placeholder="Minimal 8 karakter" required minlength="8" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_confirm_password">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-lock-check text-muted"></i></span>
                                <input type="password" class="form-control border-start-0" id="prof_confirm_password" name="confirm_password" placeholder="Ulangi password baru" required minlength="8" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold text-dark fs-12 mb-2"><i class="ti ti-shield-check text-success me-1"></i> Standar Keamanan Password:</h6>
                                <ul class="list-unstyled mb-0 fs-11 text-muted row g-2">
                                    <li class="col-md-6"><i class="ti ti-check text-success me-1"></i> Minimal 8 karakter</li>
                                    <li class="col-md-6"><i class="ti ti-check text-success me-1"></i> Mengandung huruf besar & kecil</li>
                                    <li class="col-md-6"><i class="ti ti-check text-success me-1"></i> Mengandung minimal 1 angka</li>
                                    <li class="col-md-6"><i class="ti ti-check text-success me-1"></i> Disarankan simbol khusus (!@#$%^&*)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light px-4" onclick="document.getElementById('profile-tabs-tab-info').click();">Batal</button>
                            <button type="submit" class="btn btn-brand px-4 shadow-sm" id="btnSavePassword">
                                <i class="ti ti-key me-1"></i> Perbarui Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
