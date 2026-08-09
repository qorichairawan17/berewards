<header class="topbar-custom app-topbar">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="button-toggle-menu topbar-icon d-lg-none" type="button" aria-label="Buka menu"><i class="ti ti-menu-2"></i></button>
                <div>
                    <p class="eyebrow">BeRewards</p>
                    <h1><?= isset($page_heading) ? html_escape($page_heading) : 'Dashboard'; ?></h1>
                </div>
            </div>
            <div class="topbar-actions">
                <button class="topbar-icon" type="button" aria-label="Notifikasi"><i class="ti ti-bell"></i><span></span></button>
                <div class="user-profile">
                    <div class="user-avatar">SA</div>
                    <div><strong>Superadmin</strong><small>Administrator Sistem</small></div>
                    <i class="ti ti-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
</header>
