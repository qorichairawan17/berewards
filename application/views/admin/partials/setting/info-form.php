<!-- Main Setting Configuration Panel -->
<div class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom border-light p-3">
        <ul class="nav nav-tabs card-header-tabs nav-bordered border-0" id="setting-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-dark fs-13 py-2 px-3" id="setting-tabs-tab-satker" data-bs-toggle="tab" data-bs-target="#setting-tab-satker" type="button" role="tab" aria-controls="setting-tab-satker" aria-selected="true">
                    <i class="ti ti-building-bank me-1 text-primary"></i> Profil & Identitas Satker
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark fs-13 py-2 px-3" id="setting-tabs-tab-pimpinan" data-bs-toggle="tab" data-bs-target="#setting-tab-pimpinan" type="button" role="tab" aria-controls="setting-tab-pimpinan" aria-selected="false">
                    <i class="ti ti-users me-1 text-primary"></i> Susunan Pimpinan Pengadilan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark fs-13 py-2 px-3" id="setting-tabs-tab-app" data-bs-toggle="tab" data-bs-target="#setting-tab-app" type="button" role="tab" aria-controls="setting-tab-app" aria-selected="false">
                    <i class="ti ti-settings me-1 text-primary"></i> Konfigurasi SPK & Kop Surat
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="tab-content" id="setting-tabs-content">
            
            <!-- TAB 1: Profil Satker & Logo -->
            <div class="tab-pane fade show active" id="setting-tab-satker" role="tabpanel" aria-labelledby="setting-tabs-tab-satker">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Identitas Resmi Instansi</span>
                        <h5 class="fw-bold text-dark mb-0">Informasi Satuan Kerja Pengadilan</h5>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-11" id="badgeKelasSatker">
                        <i class="ti ti-building me-1"></i> <?= html_escape($satker['kelas_pengadilan']); ?>
                    </span>
                </div>

                <!-- Logo Upload Section -->
                <div class="col-12 mb-4">
                    <div class="p-3 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-3">
                        <div class="avatar-lg bg-white p-2 rounded border shadow-sm d-flex align-items-center justify-content-center" style="width: 72px; height: 72px;">
                            <img src="<?= base_url($satker['logo']); ?>" alt="Logo Satker" id="satkerLogoPreview" class="img-fluid" style="max-height: 58px;">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1 fs-13"><i class="ti ti-photo me-1 text-primary"></i> Logo Resmi Satuan Kerja</h6>
                            <p class="text-muted fs-11 mb-0">Format file: PNG, JPG, JPEG (Latar transparan disarankan, maks. 2 MB). Digunakan pada Kop Berita Acara Word dan Cetakan Laporan.</p>
                        </div>
                        <div>
                            <input type="file" id="logoFileInput" name="logo" accept="image/png,image/jpeg,image/jpg" class="d-none">
                            <button type="button" class="btn btn-outline-primary btn-sm font-medium px-3" id="btnUploadLogoTrigger">
                                <i class="ti ti-upload me-1"></i> Unggah Logo Baru
                            </button>
                        </div>
                    </div>
                </div>

                <form id="formSettingSatker" method="POST" action="<?= base_url('setting/simpan_satker'); ?>">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Nama Satuan Kerja Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-building-bank text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="satker_nama" name="nama_satker" value="<?= html_escape($satker['nama_satker']); ?>" placeholder="Contoh: Pengadilan Negeri Lubuk Pakam Kelas I-A" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Nama Singkatan / Sebutan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-bookmark text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="satker_singkatan" name="singkatan" value="<?= html_escape($satker['singkatan']); ?>" placeholder="Contoh: PN Lubuk Pakam" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Kode Satuan Kerja (Kode Satker) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-key text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="satker_kode" name="kode_satker" value="<?= html_escape($satker['kode_satker']); ?>" placeholder="Contoh: 005021" required>
                            </div>
                            <small class="text-muted fs-11">Kode unik register Mahkamah Agung RI.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Kode Wilayah Surat <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-map-pin text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="satker_wilayah" name="kode_wilayah" value="<?= html_escape($satker['kode_wilayah']); ?>" placeholder="Contoh: W2.U4" required>
                            </div>
                            <small class="text-muted fs-11">Digunakan untuk penomoran Berita Acara.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Kelas Pengadilan <span class="text-danger">*</span></label>
                            <select class="form-select" id="satker_kelas" name="kelas_pengadilan" required>
                                <option value="Kelas I-A Khusus" <?= ($satker['kelas_pengadilan'] === 'Kelas I-A Khusus') ? 'selected' : ''; ?>>Kelas I-A Khusus</option>
                                <option value="Kelas I-A" <?= ($satker['kelas_pengadilan'] === 'Kelas I-A') ? 'selected' : ''; ?>>Kelas I-A</option>
                                <option value="Kelas I-B" <?= ($satker['kelas_pengadilan'] === 'Kelas I-B') ? 'selected' : ''; ?>>Kelas I-B</option>
                                <option value="Kelas II" <?= ($satker['kelas_pengadilan'] === 'Kelas II') ? 'selected' : ''; ?>>Kelas II</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Pengadilan Tinggi Pembina (Pengadilan Tingkat Banding)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-building-community text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="satker_pt" name="pengadilan_tinggi" value="<?= html_escape($satker['pengadilan_tinggi']); ?>" placeholder="Contoh: Pengadilan Tinggi Medan">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Alamat Kantor Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-map-2 text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" id="satker_alamat" name="alamat" value="<?= html_escape($satker['alamat']); ?>" placeholder="Jl. ... No. ..." required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Kota / Kabupaten</label>
                            <input type="text" class="form-control" id="satker_kota" name="kota" value="<?= html_escape($satker['kota']); ?>" placeholder="Contoh: Lubuk Pakam">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Provinsi</label>
                            <input type="text" class="form-control" id="satker_provinsi" name="provinsi" value="<?= html_escape($satker['provinsi']); ?>" placeholder="Contoh: Sumatera Utara">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Kode Pos</label>
                            <input type="text" class="form-control" id="satker_kodepos" name="kode_pos" value="<?= html_escape($satker['kode_pos']); ?>" placeholder="Contoh: 20511">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Nomor Telepon</label>
                            <input type="text" class="form-control" id="satker_telepon" name="telepon" value="<?= html_escape($satker['telepon']); ?>" placeholder="Contoh: (061) 7951234">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Nomor Fax</label>
                            <input type="text" class="form-control" id="satker_fax" name="fax" value="<?= html_escape($satker['fax']); ?>" placeholder="Contoh: (061) 7952182">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Email Resmi Instansi</label>
                            <input type="email" class="form-control" id="satker_email" name="email" value="<?= html_escape($satker['email']); ?>" placeholder="Contoh: pn.lubukpakam@mahkamahagung.go.id">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Website Resmi</label>
                            <input type="text" class="form-control" id="satker_website" name="website" value="<?= html_escape($satker['website']); ?>" placeholder="Contoh: https://pn-lubukpakam.go.id">
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                            <button type="submit" class="btn btn-brand px-4 shadow-sm" id="btnSubmitSatker">
                                <i class="ti ti-check me-1"></i> Simpan Profil Satker
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TAB 2: Susunan Pimpinan Pengadilan -->
            <div class="tab-pane fade" id="setting-tab-pimpinan" role="tabpanel" aria-labelledby="setting-tabs-tab-pimpinan">
                <div class="mb-4">
                    <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Unsur Pimpinan</span>
                    <h5 class="fw-bold text-dark mb-1">Daftar Pejabat Pimpinan Pengadilan Negeri</h5>
                    <p class="text-muted fs-12 mb-0">Pejabat yang tercantum di sini akan secara otomatis menjadi penandatangan resmi Berita Acara Penetapan Reward TOPSIS.</p>
                </div>

                <form id="formSettingPimpinan" method="POST" action="<?= base_url('setting/simpan_pimpinan'); ?>">
                    <div class="row g-4">
                        
                        <!-- 1. KETUA PENGADILAN NEGERI -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 position-relative">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-primary text-white p-2 rounded-circle"><i class="ti ti-gavel fs-16"></i></span>
                                    <div>
                                        <strong class="d-block text-dark fs-14">Ketua Pengadilan Negeri</strong>
                                        <small class="text-muted fs-11">Penandatangan Berita Acara (Mengetahui)</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="nama_ketua" value="<?= html_escape($pimpinan['ketua']['nama']); ?>" placeholder="Nama lengkap Ketua" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">NIP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="nip_ketua" value="<?= html_escape($pimpinan['ketua']['nip']); ?>" placeholder="19xxxxxxxxxxxxxx" required>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Pangkat / Golongan</label>
                                    <input type="text" class="form-control form-control-sm" name="pangkat_ketua" value="<?= html_escape($pimpinan['ketua']['pangkat']); ?>" placeholder="Contoh: Pembina Utama Muda (IV/c)">
                                </div>
                            </div>
                        </div>

                        <!-- 2. WAKIL KETUA PENGADILAN NEGERI -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 position-relative">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-info text-white p-2 rounded-circle"><i class="ti ti-scale fs-16"></i></span>
                                    <div>
                                        <strong class="d-block text-dark fs-14">Wakil Ketua Pengadilan Negeri</strong>
                                        <small class="text-muted fs-11">Wakil Penandatangan / Pembina Tim</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Nama Lengkap & Gelar</label>
                                    <input type="text" class="form-control form-control-sm" name="nama_wakil_ketua" value="<?= html_escape($pimpinan['wakil_ketua']['nama']); ?>" placeholder="Nama lengkap Wakil Ketua">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">NIP</label>
                                    <input type="text" class="form-control form-control-sm" name="nip_wakil_ketua" value="<?= html_escape($pimpinan['wakil_ketua']['nip']); ?>" placeholder="19xxxxxxxxxxxxxx">
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Pangkat / Golongan</label>
                                    <input type="text" class="form-control form-control-sm" name="pangkat_wakil_ketua" value="<?= html_escape($pimpinan['wakil_ketua']['pangkat']); ?>" placeholder="Contoh: Pembina Tk. I (IV/b)">
                                </div>
                            </div>
                        </div>

                        <!-- 3. PANITERA PENGADILAN NEGERI -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 position-relative">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-warning text-white p-2 rounded-circle"><i class="ti ti-file-certificate fs-16"></i></span>
                                    <div>
                                        <strong class="d-block text-dark fs-14">Panitera Pengadilan Negeri</strong>
                                        <small class="text-muted fs-11">Penandatangan Berita Acara / Ketua Panitia</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="nama_panitera" value="<?= html_escape($pimpinan['panitera']['nama']); ?>" placeholder="Nama lengkap Panitera" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">NIP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="nip_panitera" value="<?= html_escape($pimpinan['panitera']['nip']); ?>" placeholder="19xxxxxxxxxxxxxx" required>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Pangkat / Golongan</label>
                                    <input type="text" class="form-control form-control-sm" name="pangkat_panitera" value="<?= html_escape($pimpinan['panitera']['pangkat']); ?>" placeholder="Contoh: Pembina (IV/a)">
                                </div>
                            </div>
                        </div>

                        <!-- 4. SEKRETARIS PENGADILAN NEGERI -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 position-relative">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-success text-white p-2 rounded-circle"><i class="ti ti-user-check fs-16"></i></span>
                                    <div>
                                        <strong class="d-block text-dark fs-14">Sekretaris Pengadilan Negeri</strong>
                                        <small class="text-muted fs-11">Penanggung Jawab Kesekretariatan & SDM</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="nama_sekretaris" value="<?= html_escape($pimpinan['sekretaris']['nama']); ?>" placeholder="Nama lengkap Sekretaris" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">NIP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="nip_sekretaris" value="<?= html_escape($pimpinan['sekretaris']['nip']); ?>" placeholder="19xxxxxxxxxxxxxx" required>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark fs-11 mb-1">Pangkat / Golongan</label>
                                    <input type="text" class="form-control form-control-sm" name="pangkat_sekretaris" value="<?= html_escape($pimpinan['sekretaris']['pangkat']); ?>" placeholder="Contoh: Pembina (IV/a)">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                            <button type="submit" class="btn btn-brand px-4 shadow-sm" id="btnSubmitPimpinan">
                                <i class="ti ti-check me-1"></i> Simpan Data Pimpinan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TAB 3: Konfigurasi SPK & Kop Berita Acara -->
            <div class="tab-pane fade" id="setting-tab-app" role="tabpanel" aria-labelledby="setting-tabs-tab-app">
                <div class="mb-4">
                    <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Parameter Sistem</span>
                    <h5 class="fw-bold text-dark mb-1">Konfigurasi Mesin TOPSIS & Cetakan Dokumen</h5>
                    <p class="text-muted fs-12 mb-0">Atur teks header kop surat dan format nomor otomatis Berita Acara Word.</p>
                </div>

                <form id="formSettingApp" method="POST" action="<?= base_url('setting/simpan_app'); ?>">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Teks Kop Surat Baris 1 (Nama Satker di Word) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kop_line1" value="<?= html_escape($app['kop_line1']); ?>" placeholder="Contoh: PENGADILAN NEGERI LUBUK PAKAM KELAS I-A" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Teks Kop Surat Baris 2 (Alamat & Kontak di Word) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kop_line2" value="<?= html_escape($app['kop_line2']); ?>" placeholder="Contoh: JL. SISINGAMANGARAJA NO. 182, LUBUK PAKAM, DELI SERDANG 20511" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Format Template Nomor Berita Acara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control font-monospace" name="format_nomor_ba" value="<?= html_escape($app['format_nomor_ba']); ?>" placeholder="[KODE_WILAYAH]/[NO_URUT]/BA.SPK/[BULAN_ROMAWI]/[TAHUN]" required>
                            <small class="text-muted fs-11">Variabel otomatis: <code>[KODE_WILAYAH]</code>, <code>[NO_URUT]</code>, <code>[BULAN_ROMAWI]</code>, <code>[TAHUN]</code></small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12 mb-1">Metode SPK Penilaian</label>
                            <input type="text" class="form-control" value="<?= html_escape($app['metode']); ?>" readonly style="background-color: #F8FAFC;">
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                            <button type="submit" class="btn btn-brand px-4 shadow-sm" id="btnSubmitApp">
                                <i class="ti ti-check me-1"></i> Simpan Konfigurasi SPK
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

