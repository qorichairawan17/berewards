<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. AJAX Handler: Update Profile Information
    $('#formEditProfile').on('submit', function (e) {
        e.preventDefault();

        var $form = $(this);
        var $btn  = $('#btnSaveProfile');
        var originalBtnHtml = $btn.html();

        var namaLengkap = $('#prof_nama_lengkap').val().trim();
        var email       = $('#prof_email').val().trim();

        if (!namaLengkap || !email) {
            showToast('warning', 'Validasi Formulir', 'Nama Lengkap dan Alamat Email wajib diisi.');
            return;
        }

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false).html(originalBtnHtml);

                if (res.csrf_hash) {
                    $('input[name="' + (res.csrf_token_name || 'csrf_berewards_token') + '"]').val(res.csrf_hash);
                }

                if (res.status) {
                    showToast('success', 'Berhasil', res.message || 'Profil berhasil diperbarui.');

                    if (res.user) {
                        var u = res.user;

                        // Update Header Banner
                        if (u.nama_lengkap) $('#header_nama_lengkap').text(u.nama_lengkap);
                        if (u.nip) $('#header_nip').text(u.nip);
                        if (u.jabatan) $('#header_jabatan').text(u.jabatan);
                        if (u.pangkat) {
                            var pangkatGol = u.pangkat + (u.golongan && u.golongan !== '-' ? ' (Gol. ' + u.golongan + ')' : '');
                            $('#header_pangkat_gol').text(pangkatGol);
                        }
                        if (u.kategori && u.kategori !== 'Non-Pegawai' && u.kategori !== '-') {
                            $('#header_kategori_badge').text(u.kategori).show();
                        }
                        if (u.email) $('#header_email').text(u.email);
                        if (u.no_hp) $('#header_no_hp').text(u.no_hp);

                        // Update Overview Tab
                        if (u.nama_lengkap) $('#overview_nama_lengkap').text(u.nama_lengkap);
                        if (u.nip) $('#overview_nip').text(u.nip);
                        if (u.nik) $('#overview_nik').text(u.nik);
                        if (u.pangkat) {
                            var pangkatGol = u.pangkat + (u.golongan && u.golongan !== '-' ? ' (Gol. ' + u.golongan + ')' : '');
                            $('#overview_pangkat_gol').text(pangkatGol);
                        }
                        if (u.kategori) {
                            var kat = u.kategori;
                            var katClass = 'bg-secondary-subtle text-secondary border-secondary-subtle';
                            if (kat === 'Hakim') katClass = 'bg-primary-subtle text-primary border-primary-subtle';
                            else if (kat === 'Panitera Pengganti') katClass = 'bg-info-subtle text-info border-info-subtle';
                            else if (kat === 'Jurusita') katClass = 'bg-warning-subtle text-warning border-warning-subtle';
                            else if (kat === 'Staf') katClass = 'bg-success-subtle text-success border-success-subtle';
                            $('#overview_kategori_container').html('<span class="badge ' + katClass + ' border px-2.5 py-1 fs-11" id="overview_kategori">' + kat + '</span>');
                        }
                        if (u.jabatan) $('#overview_jabatan').text(u.jabatan);
                        if (u.email) $('#overview_email').text(u.email);
                        if (u.no_hp) $('#overview_no_hp').text(u.no_hp);

                        // Update Sidebar ID Card
                        if (u.nama_lengkap) $('#sidebar_nama_lengkap').text(u.nama_lengkap);
                        if (u.nip) $('#sidebar_nip').text(u.nip);
                        if (u.jabatan) $('#sidebar_jabatan').text(u.jabatan);
                        if (u.pangkat) {
                            var pangkatGol = u.pangkat + (u.golongan && u.golongan !== '-' ? ' (' + u.golongan + ')' : '');
                            $('#sidebar_pangkat_gol').text(pangkatGol);
                        }
                        if (u.kategori && u.kategori !== 'Non-Pegawai' && u.kategori !== '-') {
                            $('#sidebar_kategori').text(u.kategori).show();
                        }

                        // Update Initials
                        if (u.nama_lengkap) {
                            var parts = u.nama_lengkap.trim().split(' ');
                            var inits = parts[0].charAt(0).toUpperCase() + (parts[1] ? parts[1].charAt(0).toUpperCase() : '');
                            $('#header_user_initials').text(inits);
                        }

                        // Update Topbar Username if element exists
                        $('.topbar-user-name').text(u.nama_lengkap);
                    }

                    // Return to Info Tab
                    setTimeout(function () {
                        var infoTabBtn = document.getElementById('profile-tabs-tab-info');
                        if (infoTabBtn) infoTabBtn.click();
                    }, 800);
                } else {
                    showToast('danger', 'Gagal Memperbarui', res.message || 'Terjadi kesalahan saat menyimpan perubahan profil.');
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html(originalBtnHtml);
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan saat menghubungi server (' + xhr.status + '). Silakan coba lagi.');
            }
        });
    });

    // 2. AJAX Handler: Update Password & Security
    $('#formChangePassword').on('submit', function (e) {
        e.preventDefault();

        var $form = $(this);
        var $btn  = $('#btnSavePassword');
        var originalBtnHtml = $btn.html();

        var currentPwd = $('#prof_current_password').val().trim();
        var newPwd     = $('#prof_new_password').val().trim();
        var confirmPwd = $('#prof_confirm_password').val().trim();

        if (!currentPwd || !newPwd || !confirmPwd) {
            showToast('warning', 'Validasi Password', 'Semua kolom password wajib diisi.');
            return;
        }

        if (newPwd.length < 8) {
            showToast('warning', 'Standar Password', 'Password baru minimal harus terdiri dari 8 karakter.');
            $('#prof_new_password').focus();
            return;
        }

        if (newPwd !== confirmPwd) {
            showToast('warning', 'Konfirmasi Password', 'Konfirmasi password baru tidak cocok. Silakan ulangi.');
            $('#prof_confirm_password').focus();
            return;
        }

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memperbarui Password...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false).html(originalBtnHtml);

                if (res.csrf_hash) {
                    $('input[name="' + (res.csrf_token_name || 'csrf_berewards_token') + '"]').val(res.csrf_hash);
                }

                if (res.status) {
                    showToast('success', 'Password Diperbarui', res.message || 'Kata sandi akun Anda berhasil diperbarui.');
                    $form[0].reset();

                    // Return to Info Tab after success
                    setTimeout(function () {
                        var infoTabBtn = document.getElementById('profile-tabs-tab-info');
                        if (infoTabBtn) infoTabBtn.click();
                    }, 1200);
                } else {
                    showToast('danger', 'Gagal Memperbarui Password', res.message || 'Terjadi kesalahan saat memverifikasi password lama.');
                    $('#prof_current_password').focus();
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html(originalBtnHtml);
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan saat menghubungi server (' + xhr.status + '). Silakan coba lagi.');
            }
        });
    });
});
</script>
