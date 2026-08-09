<aside class="sidenav-menu app-sidebar" aria-label="Navigasi utama">
    <a class="logo brand" href="<?= site_url('dashboard'); ?>">
        <span class="brand-mark"><i class="ti ti-scale"></i></span>
        <span><strong>BeRewards</strong><small>Pengadilan Negeri Lubuk Pakam</small></span>
    </a>

    <div class="sidenav-menu-inner" data-simplebar>
        <nav class="sidebar-nav">
            <p class="nav-label">Menu Utama</p>
            <a class="nav-link<?= (!isset($active_menu) || $active_menu === 'dashboard') ? ' active' : ''; ?>" href="<?= site_url('dashboard'); ?>"><i class="ti ti-layout-dashboard"></i>Dashboard</a>

            <p class="nav-label">Master Data</p>
            <a class="nav-link<?= isset($active_menu) && $active_menu === 'pegawai' ? ' active' : ''; ?>" href="#"><i class="ti ti-users"></i>Data Pegawai</a>
            <a class="nav-link<?= isset($active_menu) && $active_menu === 'kriteria' ? ' active' : ''; ?>" href="#"><i class="ti ti-list-check"></i>Kriteria Penilaian</a>
            <a class="nav-link<?= isset($active_menu) && $active_menu === 'periode' ? ' active' : ''; ?>" href="#"><i class="ti ti-calendar-event"></i>Periode Penilaian</a>

            <p class="nav-label">Penilaian</p>
            <a class="nav-link<?= isset($active_menu) && $active_menu === 'proses' ? ' active' : ''; ?>" href="#"><i class="ti ti-math-function"></i>Proses TOPSIS</a>
            <a class="nav-link<?= isset($active_menu) && $active_menu === 'laporan' ? ' active' : ''; ?>" href="#"><i class="ti ti-file-description"></i>Laporan Reward</a>

            <p class="nav-label">Pengaturan</p>
            <a class="nav-link<?= isset($active_menu) && $active_menu === 'user' ? ' active' : ''; ?>" href="#"><i class="ti ti-user-cog"></i>Manajemen Pengguna</a>
        </nav>
    </div>
</aside>
