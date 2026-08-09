<?php
$page_title = isset($page_title) ? $page_title : 'Masuk';
$is_auth_page = true;
$this->load->view('templates/header', get_defined_vars());
?>
<main class="account-page signin-layout">
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            <!-- Left Branding & Information Intro Column -->
            <section class="col-xl-7 signin-intro" aria-label="Informasi BeRewards">
                <div class="signin-brand mb-4">
                    <img src="<?= base_url('assets/icons/logo.png'); ?>" alt="BeRewards Logo" class="rounded">
                    <div>
                        <strong class="d-block text-dark fs-18 fw-bold lh-1">BeRewards</strong>
                        <small class="text-muted fs-11 tracking-wider text-uppercase fw-semibold">Pengadilan Negeri Lubuk Pakam Kelas I-A</small>
                    </div>
                </div>
                <div class="signin-copy mt-3">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 fs-11 rounded-pill mb-2">
                        <i class="ti ti-sparkles me-1"></i> Sistem Penilaian Terukur
                    </span>
                    <h1>Menetapkan Reward Melalui Keputusan yang <em>Objektif.</em></h1>
                    <p>Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court With TOPSIS Method.</p>
                </div>
                <div class="signin-orbit my-auto" aria-hidden="true">
                    <div class="orbit-center"><i class="ti ti-award"></i></div>
                    <span class="orbit-node node-one"><i class="ti ti-chart-bar"></i></span>
                    <span class="orbit-node node-two"><i class="ti ti-users"></i></span>
                    <span class="orbit-node node-three"><i class="ti ti-circle-check"></i></span>
                </div>
                <p class="signin-footer">© <?= date('Y'); ?> BeRewards • Pengadilan Negeri Lubuk Pakam. Made By Qori Chairawan</p>
            </section>

            <!-- Right Login Form Panel Column -->
            <section class="col-xl-5 d-flex align-items-center justify-content-center signin-panel">
                <div class="card border-0 signin-card shadow-lg rounded-4">
                    <div class="card-body p-0">
                        <div class="signin-card-heading text-center text-sm-start">
                            <div class="mini-icon mx-auto mx-sm-0">
                                <i class="ti ti-lock"></i>
                            </div>
                            <h2>Selamat Datang</h2>
                            <p>Masuk untuk melanjutkan ke panel pengelolaan SPK BeRewards.</p>
                        </div>
                        <form action="<?= site_url('dashboard'); ?>" method="get" novalidate>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark fs-12" for="username">Nama Pengguna</label>
                                <div class="input-with-icon">
                                    <i class="ti ti-user"></i>
                                    <input class="form-control" id="username" name="username" type="text" placeholder="Masukkan nama pengguna" autocomplete="username" value="superadmin" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark fs-12" for="password">Kata Sandi</label>
                                <div class="input-with-icon">
                                    <i class="ti ti-key"></i>
                                    <input class="form-control" id="password" name="password" type="password" placeholder="Masukkan kata sandi" autocomplete="current-password" value="password" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                                <label class="remember-choice mb-0 d-flex align-items-center">
                                    <input type="checkbox" name="remember" checked>
                                    <span>Ingat saya</span>
                                </label>
                                <a class="muted-link" href="javascript:void(0);">Lupa kata sandi?</a>
                            </div>
                            <button class="btn btn-brand w-100 py-2.5 shadow-sm" type="submit">
                                Masuk ke Sistem <i class="ti ti-arrow-right ms-1"></i>
                            </button>
                        </form>
                        <div class="signin-security mt-4">
                            <i class="ti ti-shield-check text-success fs-16"></i>
                            <span>Akses Anda terlindungi dan tercatat dalam Audit Trail.</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
<?php $this->load->view('templates/footer', get_defined_vars()); ?>
