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

                <div class="card bg-light border-0 p-3 text-start mb-3">
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
