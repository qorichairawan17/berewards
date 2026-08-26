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
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Identitas Pengguna & Kepegawaian</span>
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
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Pegawai Terhubung (Data Sumber SPK)</small>
                            <?php if (!empty($user['id_pegawai'])): ?>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <strong class="text-dark fs-13" id="overview_nama_pegawai"><?= html_escape($user['nama_pegawai']); ?></strong>
                                    <span class="badge bg-light text-muted border px-2 py-0.5 fs-10 font-monospace">ID #<?= $user['id_pegawai']; ?></span>
                                </div>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 fs-11 mt-1">Akun Administrator Mandiri (Non-Pegawai Terhubung)</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Kategori Pegawai (Klaster TOPSIS)</small>
                            <div class="mt-1" id="overview_kategori_container">
                                <?php 
                                    $kat = !empty($user['kategori']) ? $user['kategori'] : 'Non-Pegawai';
                                    if ($kat === 'Hakim'): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fs-11" id="overview_kategori">Hakim</span>
                                    <?php elseif ($kat === 'Panitera Pengganti'): ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1 fs-11" id="overview_kategori">Panitera Pengganti</span>
                                    <?php elseif ($kat === 'Jurusita'): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 fs-11" id="overview_kategori">Jurusita</span>
                                    <?php elseif ($kat === 'Staf'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 fs-11" id="overview_kategori">Staf</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1 fs-11" id="overview_kategori">Non-Pegawai</span>
                                    <?php endif; ?>
                            </div>
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
                            <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Pangkat & Golongan Ruang</small>
                            <span class="fw-semibold text-dark fs-13" id="overview_pangkat_gol">
                                <?= html_escape($user['pangkat']); ?> <?= ($user['golongan'] !== '-') ? '(Gol. ' . html_escape($user['golongan']) . ')' : ''; ?>
                            </span>
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
                            <?php 
                                $r = strtolower(trim($user['role_raw'])); 
                                if ($r === 'superadmin'): ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 fs-11 mt-1" id="overview_role">
                                        <i class="ti ti-shield me-1"></i>Superadmin
                                    </span>
                                <?php elseif ($r === 'pimpinan'): ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 fs-11 mt-1" id="overview_role">
                                        <i class="ti ti-crown me-1"></i>Pimpinan
                                    </span>
                                <?php elseif ($r === 'tim_penilai'): ?>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fs-11 mt-1" id="overview_role">
                                        <i class="ti ti-award me-1"></i>Tim Penilai
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1 fs-11 mt-1" id="overview_role">
                                        <i class="ti ti-shield-check me-1"></i>Administrator
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="p-3 bg-light rounded-3 border d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Status Akun</small>
                                <?php if ($user['status_akun'] === 'Aktif'): ?>
                                    <span class="badge bg-success rounded-pill px-2.5 py-1 fs-11"><i class="ti ti-circle-check me-1"></i>Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill px-2.5 py-1 fs-11"><i class="ti ti-circle-x me-1"></i>Nonaktif</span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Tanggal Terdaftar</small>
                                <span class="fw-semibold text-dark fs-12" id="overview_tgl_bergabung"><?= date('d F Y', strtotime($user['tgl_bergabung'])); ?></span>
                            </div>
                            <div>
                                <small class="text-muted d-block fs-11 text-uppercase fw-semibold">Waktu Terakhir Login</small>
                                <span class="fw-semibold text-primary fs-12" id="overview_last_login"><?= date('d M Y, H:i', strtotime($user['last_login'])); ?> WIB</span>
                            </div>
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
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
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
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_pangkat">Pangkat Pegawai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-award text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="prof_pangkat" name="pangkat" value="<?= ($user['pangkat'] !== '-') ? html_escape($user['pangkat']) : ''; ?>" placeholder="Contoh: Pembina Utama Muda / Penata Tk. I">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_golongan">Golongan Ruang</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-stairs text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="prof_golongan" name="golongan" value="<?= ($user['golongan'] !== '-') ? html_escape($user['golongan']) : ''; ?>" placeholder="Contoh: IV/c, III/d, III/a">
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
                            <label class="form-label fw-semibold text-dark fs-12 mb-1" for="prof_kategori">Kategori Pegawai (Klaster TOPSIS)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-category text-muted"></i></span>
                                <select class="form-select border-start-0" id="prof_kategori" name="kategori">
                                    <option value="Hakim" <?= ($user['kategori'] === 'Hakim') ? 'selected' : ''; ?>>Hakim</option>
                                    <option value="Panitera Pengganti" <?= ($user['kategori'] === 'Panitera Pengganti') ? 'selected' : ''; ?>>Panitera Pengganti</option>
                                    <option value="Jurusita" <?= ($user['kategori'] === 'Jurusita') ? 'selected' : ''; ?>>Jurusita</option>
                                    <option value="Staf" <?= ($user['kategori'] === 'Staf') ? 'selected' : ''; ?>>Staf</option>
                                    <option value="Non-Pegawai" <?= ($user['kategori'] === 'Non-Pegawai' || empty($user['kategori'])) ? 'selected' : ''; ?>>Non-Pegawai / Administrator</option>
                                </select>
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

                        <div class="col-md-12">
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
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
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
