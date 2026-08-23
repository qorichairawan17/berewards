<?php
$page_title = isset($page_title) ? $page_title : 'Masuk';
$is_auth_page = true;

if (!isset($settings)) {
    $this->load->library('setting_service');
    $settings = $this->setting_service->get_settings();
}

$satker_nama = isset($settings['nama_satker']) ? $settings['nama_satker'] : 'Pengadilan Negeri Lubuk Pakam Kelas I-A';
$brand_logo = base_url('assets/icons/logo.png');

$this->load->view('templates/header', get_defined_vars());
?>

<!-- Toast Container (Top Right Placement Referencing extended-notifications.html) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
    <div id="toastNotification" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2.5 p-3">
                <i id="toastIcon" class="fs-22 me-1"></i>
                <div>
                    <strong id="toastTitle" class="d-block fs-13 fw-bold mb-0.5"></strong>
                    <span id="toastText" class="fs-12 text-white-80"></span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<main class="account-page signin-layout">
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            <!-- Left Branding & Information Intro Column -->
            <section class="col-xl-7 signin-intro" aria-label="Informasi BeRewards">
                <div class="signin-brand mb-4">
                    <img src="<?= $brand_logo; ?>" alt="BeRewards Logo" class="rounded">
                    <div>
                        <strong class="d-block text-dark fs-18 fw-bold lh-1">BeRewards</strong>
                        <small class="text-muted fs-11 tracking-wider text-uppercase fw-semibold"><?= html_escape($satker_nama); ?></small>
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
                <p class="signin-footer">© <?= date('Y'); ?> BeRewards • <?= html_escape($satker_nama); ?>. Made By Qori Chairawan</p>
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

                        <!-- Form Signin dengan Handler Ajax -->
                        <form id="formSignin" action="<?= site_url('user/authenticate'); ?>" method="post" novalidate>
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" id="csrfTokenInput">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark fs-12" for="username">Nama Pengguna</label>
                                <div class="input-with-icon position-relative">
                                    <i class="ti ti-user"></i>
                                    <input class="form-control" id="username" name="username" type="text" placeholder="Masukkan nama pengguna"
                                        autocomplete="username" value="superadmin" required>
                                </div>
                                <div class="invalid-feedback id-error-username fs-11"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark fs-12" for="password">Kata Sandi</label>
                                <div class="input-with-icon position-relative">
                                    <i class="ti ti-key"></i>
                                    <input class="form-control" id="password" name="password" type="password" placeholder="Masukkan kata sandi"
                                        autocomplete="current-password" value="password123" required>
                                </div>
                                <div class="invalid-feedback id-error-password fs-11"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                                <label class="remember-choice mb-0 d-flex align-items-center">
                                    <input type="checkbox" name="remember" value="1" checked>
                                    <span>Ingat saya</span>
                                </label>
                                <a class="muted-link" href="javascript:void(0);"
                                    onclick="showToast('info', 'Bantuan Akses', 'Silakan hubungi Administrator Subbag Kepegawaian untuk mereset kata sandi Anda.');">Lupa
                                    kata sandi?</a>
                            </div>
                            <button id="btnSubmitSignin" class="btn btn-brand w-100 py-2.5 shadow-sm" type="submit">
                                <span class="btn-text">Masuk ke Sistem <i class="ti ti-arrow-right ms-1"></i></span>
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

<!-- Page Footers & Vendor JS -->
<?php $this->load->view('templates/footer', get_defined_vars()); ?>

<!-- Toast Notification & Form Validation Script (Referencing extended-notifications.html) -->
<script>
    /**
     * Helper function to show Toast notification referencing extended-notifications.html
     */
    function showToast(type, title, message) {
        var toastEl = document.getElementById('toastNotification');
        if (!toastEl) return;

        var bgClass = 'bg-primary';
        var iconClass = 'ti ti-info-circle';

        if (type === 'success') {
            bgClass = 'bg-success';
            iconClass = 'ti ti-circle-check';
        } else if (type === 'danger' || type === 'error') {
            bgClass = 'bg-danger';
            iconClass = 'ti ti-alert-circle';
        } else if (type === 'warning') {
            bgClass = 'bg-warning text-dark';
            iconClass = 'ti ti-alert-triangle';
        } else if (type === 'info') {
            bgClass = 'bg-info';
            iconClass = 'ti ti-info-circle';
        }

        toastEl.className = 'toast align-items-center border-0 shadow-lg rounded-3 ' + bgClass;

        $('#toastIcon').attr('class', iconClass + ' fs-22 me-1');
        $('#toastTitle').text(title);
        $('#toastText').text(message);

        var bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
        bsToast.show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Ajax Signin Handler
        $('#formSignin').on('submit', function (e) {
            e.preventDefault();

            // Clear previous errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('').hide();

            var $btn = $('#btnSubmitSignin');
            var originalBtnHtml = $btn.html();

            // Loading state
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memeriksa Kredensial...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.csrf_token) {
                        $('#csrfTokenInput').val(res.csrf_token);
                    }

                    if (res.toast) {
                        showToast(res.toast.type, res.toast.title, res.toast.message);
                    }

                    if (res.status === 'success') {
                        $btn.removeClass('btn-brand').addClass('btn-success').html('<i class="ti ti-check me-1"></i> ' + res.message);
                        setTimeout(function () {
                            window.location.href = res.redirect || "<?= site_url('dashboard'); ?>";
                        }, 1000);
                    } else {
                        $btn.prop('disabled', false).html(originalBtnHtml);

                        if (res.errors) {
                            if (res.errors.username) {
                                $('#username').addClass('is-invalid');
                                $('.id-error-username').text(res.errors.username).show();
                            }
                            if (res.errors.password) {
                                $('#password').addClass('is-invalid');
                                $('.id-error-password').text(res.errors.password).show();
                            }
                        }
                    }
                },
                error: function (xhr, status, error) {
                    $btn.prop('disabled', false).html(originalBtnHtml);
                    showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan sistem saat memproses login (' + xhr.status + '). Silakan coba lagi.');
                }
            });
        });
    });
</script>