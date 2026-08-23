<!-- Modal Detail User -->
<div class="modal fade" id="modalDetailUser" tabindex="-1" aria-labelledby="modalDetailUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailUserLabel">
                    <i class="ti ti-id text-primary me-2"></i>Profil Pengguna Sistem
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="user-avatar-lg mx-auto bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-20 mb-3" style="width:64px; height:64px;">
                    <i class="ti ti-user fs-30"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1" id="detail_nama_user">-</h5>
                <p class="text-muted fs-12 mb-3" id="detail_username_user">@username</p>

                <!-- Informasi Pegawai Terkait -->
                <div class="card bg-light border-0 p-3 text-start mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">
                            <i class="ti ti-briefcase me-1"></i>Pegawai Terhubung
                        </span>
                        <span id="detail_kategori_badge" class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5 fs-10">-</span>
                    </div>
                    <div class="row g-2">
                        <div class="col-12">
                            <span class="d-block text-muted fs-11">Nama Pegawai & NIP</span>
                            <strong class="d-block text-dark fs-13" id="detail_nama_pegawai">-</strong>
                            <small class="text-muted fs-11 font-monospace" id="detail_nip_pegawai">-</small>
                        </div>
                        <div class="col-12 mt-2">
                            <span class="d-block text-muted fs-11">Jabatan & Pangkat</span>
                            <strong class="d-block text-dark fs-12" id="detail_jabatan_pegawai">-</strong>
                        </div>
                    </div>
                </div>

                <!-- Informasi Akun Pengguna -->
                <div class="card bg-light border-0 p-3 text-start mb-0">
                    <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider mb-2 d-block">
                        <i class="ti ti-shield me-1"></i>Detail Akun & Akses
                    </span>
                    <div class="row g-2">
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Hak Akses Role</span>
                            <span id="detail_role_badge">-</span>
                        </div>
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Status Akun</span>
                            <span id="detail_status_badge">-</span>
                        </div>
                        <div class="col-12 mt-2">
                            <span class="d-block text-muted fs-11">Email Instansi</span>
                            <strong class="d-block text-dark fs-13" id="detail_email_user">-</strong>
                        </div>
                        <div class="col-12 mt-2">
                            <span class="d-block text-muted fs-11">Aktivitas Login Terakhir</span>
                            <small class="d-block text-dark fw-semibold" id="detail_last_login">-</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
