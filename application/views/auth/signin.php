<?php
$page_title = isset($page_title) ? $page_title : 'Masuk';
$is_auth_page = true;
$this->load->view('templates/header', get_defined_vars());
?>
<main class="account-page signin-layout">
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            <section class="col-xl-7 signin-intro" aria-label="Informasi BeRewards">
                <div class="signin-brand">
                    <span class="brand-mark"><i class="ti ti-scale"></i></span>
                    <span><strong>BeRewards</strong><small>Pengadilan Negeri Lubuk Pakam</small></span>
                </div>
                <div class="signin-copy mt-2">
                    <span class="section-kicker"><i class="ti ti-sparkles"></i> Sistem penilaian terukur</span>
                    <h1>Menetapkan Reward melalui keputusan yang <em>objektif.</em></h1>
                    <p>Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court With TOPSIS Method.</p>
                </div>
                <div class="signin-orbit" aria-hidden="true">
                    <div class="orbit-center"><i class="ti ti-award"></i></div>
                    <span class="orbit-node node-one"><i class="ti ti-chart-bar"></i></span>
                    <span class="orbit-node node-two"><i class="ti ti-users"></i></span>
                    <span class="orbit-node node-three"><i class="ti ti-circle-check"></i></span>
                </div>
                <p class="signin-footer">© <?= date('Y'); ?> BeRewards Made By Qori Chairawan</p>
            </section>

            <section class="col-xl-5 d-flex align-items-center justify-content-center signin-panel">
                <div class="card border-0 signin-card">
                    <div class="card-body p-0">
                        <div class="signin-card-heading">
                            <span class="mini-icon"><i class="ti ti-lock"></i></span>
                            <h2>Selamat datang</h2>
                            <p>Masuk untuk melanjutkan ke panel pengelolaan reward.</p>
                        </div>
                        <form action="#" method="post" novalidate>
                            <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                            <div class="mb-3">
                                <label class="form-label" for="username">Nama pengguna</label>
                                <div class="input-with-icon"><i class="ti ti-user"></i><input class="form-control" id="username" name="username" type="text" placeholder="Masukkan nama pengguna" autocomplete="username"></div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="password">Kata sandi</label>
                                <div class="input-with-icon"><i class="ti ti-key"></i><input class="form-control" id="password" name="password" type="password" placeholder="Masukkan kata sandi" autocomplete="current-password"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                                <label class="remember-choice mb-0"><input type="checkbox" name="remember"><span>Ingat saya</span></label>
                                <a class="muted-link" href="#">Lupa kata sandi?</a>
                            </div>
                            <button class="btn btn-brand w-100" type="submit">Masuk ke Sistem <i class="ti ti-arrow-right"></i></button>
                        </form>
                        <div class="signin-security"><i class="ti ti-shield-check"></i><span>Akses Anda terlindungi dan tercatat dengan aman.</span></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
<?php $this->load->view('templates/footer', get_defined_vars()); ?>
