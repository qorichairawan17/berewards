<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <div class="logo-box">
                <a href="<?= site_url('dashboard'); ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <span class="brand-mark"><i class="ti ti-scale"></i></span>
                    </span>
                    <span class="logo-lg mt-3">
                        <span class="d-flex align-items-center gap-2">
                            <span class="brand-mark"><i class="ti ti-scale"></i></span>
                            <span class="text-start">
                                <strong class="d-block text-dark fs-15 lh-1">BeRewards</strong>
                            </span>
                        </span>
                    </span>
                </a>
                <a href="<?= site_url('dashboard'); ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <span class="brand-mark"><i class="ti ti-scale"></i></span>
                    </span>
                    <span class="logo-lg mt-3">
                        <span class="d-flex align-items-center gap-2">
                            <span class="brand-mark"><i class="ti ti-scale"></i></span>
                            <span class="text-start">
                                <strong class="d-block text-dark fs-15 lh-1">BeRewards</strong>
                            </span>
                        </span>
                    </span>
                </a>
            </div>

            <ul id="side-menu">
                <li class="menu-title">Menu Utama</li>
                <li>
                    <a href="<?= site_url('dashboard'); ?>"
                        class="tp-link<?= (!isset($active_menu) || $active_menu === 'dashboard') ? ' active' : ''; ?>">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Master Data</li>
                <li>
                    <a href="<?= site_url('pegawai'); ?>" class="tp-link<?= (isset($active_menu) && $active_menu === 'pegawai') ? ' active' : ''; ?>">
                        <i data-feather="users"></i>
                        <span> Data Pegawai </span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('kriteria'); ?>"
                        class="tp-link<?= (isset($active_menu) && $active_menu === 'kriteria') ? ' active' : ''; ?>">
                        <i data-feather="list"></i>
                        <span> Kriteria Penilaian </span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('periode'); ?>" class="tp-link<?= (isset($active_menu) && $active_menu === 'periode') ? ' active' : ''; ?>">
                        <i data-feather="calendar"></i>
                        <span> Periode Penilaian </span>
                    </a>
                </li>

                <li class="menu-title">Penilaian TOPSIS</li>
                <li>
                    <a href="<?= site_url('proses'); ?>" class="tp-link<?= (isset($active_menu) && $active_menu === 'proses') ? ' active' : ''; ?>">
                        <i data-feather="cpu"></i>
                        <span> Penilaian & TOPSIS </span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('laporan'); ?>" class="tp-link<?= (isset($active_menu) && $active_menu === 'laporan') ? ' active' : ''; ?>">
                        <i data-feather="file-text"></i>
                        <span> Laporan & Berita Acara </span>
                    </a>
                </li>

                <li class="menu-title">Pengaturan</li>
                <li>
                    <a href="<?= site_url('user'); ?>" class="tp-link<?= (isset($active_menu) && $active_menu === 'user') ? ' active' : ''; ?>">
                        <i data-feather="settings"></i>
                        <span> Manajemen Pengguna </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>