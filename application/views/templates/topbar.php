<div class="topbar-custom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                <li>
                    <button class="button-toggle-menu nav-link">
                        <i data-feather="menu" class="noti-icon"></i>
                    </button>
                </li>
                <li class="d-none d-lg-block">
                    <h5 class="mb-0 fw-bold text-dark"><?= isset($page_heading) ? html_escape($page_heading) : 'Dashboard'; ?></h5>
                </li>
            </ul>

            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                <li class="d-none d-sm-flex">
                    <button type="button" class="btn nav-link" data-toggle="fullscreen">
                        <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                    </button>
                </li>

                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i data-feather="bell" class="noti-icon"></i>
                        <span class="badge bg-danger rounded-circle noti-icon-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-end"><a href="javascript:void(0);" class="text-dark"><small>Tandai dibaca</small></a></span>Notifikasi
                            </h5>
                        </div>
                        <div class="noti-scroll" data-simplebar style="max-height: 230px;">
                            <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary active">
                                <div class="notify-icon bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                                    <i class="ti ti-calculator fs-18"></i>
                                </div>
                                <div class="notify-content ms-2">
                                    <p class="notify-details mb-0 text-dark">Proses TOPSIS Baru</p>
                                    <small class="text-muted">Kategori Panitera Pengganti • 1 jam lalu</small>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                <div class="notify-icon bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                                    <i class="ti ti-file-check fs-18"></i>
                                </div>
                                <div class="notify-content ms-2">
                                    <p class="notify-details mb-0 text-dark">Berita Acara Final</p>
                                    <small class="text-muted">Triwulan I 2026 telah disetujui • Kemarin</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <div class="user-avatar-sm d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold fs-12 align-middle me-1" style="width:32px; height:32px;">SA</div>
                        <span class="pro-user-name ms-1">
                            Superadmin <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">PN Lubuk Pakam</h6>
                        </div>
                        <a href="#" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle-outline fs-16 align-middle me-1"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="#" class="dropdown-item notify-item">
                            <i class="mdi mdi-cog-outline fs-16 align-middle me-1"></i>
                            <span>Pengaturan</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= site_url('signin'); ?>" class="dropdown-item notify-item text-danger">
                            <i class="mdi mdi-location-exit fs-16 align-middle me-1"></i>
                            <span>Keluar</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
