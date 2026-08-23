<!-- Page Script Manajemen Pengguna -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var baseUrl = '<?= site_url(); ?>';
    var csrfTokenName = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    /**
     * Helper to sync CSRF tokens across form inputs and JS state
     */
    function updateCsrf(res) {
        if (res && res.csrf_hash) {
            csrfHash = res.csrf_hash;
            $('input[name="' + csrfTokenName + '"]').val(csrfHash);
        }
    }

    /**
     * Helper to generate a suggested clean username from employee name
     */
    function generateUsernameSuggestion(name) {
        if (!name) return '';
        // Remove academic degrees, titles, and non-alpha characters
        var cleanName = name.replace(/(,?\s*(S\.H\.|M\.H\.|S\.Kom\.|A\.Md\.|M\.Kn\.|Drs\.|Dr\.|H\.|Hj\.|M\.M\.|\bSH\b|\bMH\b))/gi, '')
                            .replace(/[^a-zA-Z\s]/g, '')
                            .trim()
                            .toLowerCase();
        var parts = cleanName.split(/\s+/);
        if (parts.length >= 2) {
            return parts[0] + '.' + parts[parts.length - 1];
        } else if (parts.length === 1) {
            return parts[0];
        }
        return '';
    }

    /**
     * Toast notification handler matching application/views/auth/signin.php reference
     */
    function showToast(type, title, message, reload) {
        var toastEl = document.getElementById('toastNotification');
        if (!toastEl) {
            alert(title + ': ' + message);
            if (reload) location.reload();
            return;
        }

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

        toastEl.className = 'toast align-items-center border-0 text-white shadow-lg rounded-3 ' + bgClass;

        $('#toastIcon').attr('class', iconClass + ' fs-22 me-1');
        $('#toastTitle').text(title);
        $('#toastText').text(message);

        var bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
        bsToast.show();

        if (reload) {
            setTimeout(function() {
                location.reload();
            }, 1200);
        }
    }

    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tableUser').DataTable({
            language: {
                search: "Cari Pengguna:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data pengguna",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Pengguna sistem tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[0, 'asc']]
        });
    }

    // 2. Event Handler: Pilih Pegawai pada Modal Tambah User
    $('#add_id_pegawai').on('change', function() {
        var opt = $(this).find(':selected');
        var nama     = opt.data('nama');
        var nip      = opt.data('nip');
        var jabatan  = opt.data('jabatan');
        var kategori = opt.data('kategori');

        if (nama) {
            $('#add_nama_user').val(nama);
            $('#add_prev_nama').text(nama);
            $('#add_prev_nip').text('NIP: ' + nip);
            $('#add_prev_jabatan').text(jabatan);
            $('#add_prev_kategori').text(kategori);
            $('#add_pegawai_preview').removeClass('d-none');

            // Suggest username if currently empty
            if (!$('#add_username').val().trim()) {
                var suggested = generateUsernameSuggestion(nama);
                if (suggested) {
                    $('#add_username').val(suggested);
                }
            }
        } else {
            $('#add_pegawai_preview').addClass('d-none');
        }
    });

    // 3. Event Handler: Pilih Pegawai pada Modal Edit User
    $('#edit_id_pegawai').on('change', function() {
        var opt = $(this).find(':selected');
        var nama     = opt.data('nama');
        var nip      = opt.data('nip');
        var jabatan  = opt.data('jabatan');
        var kategori = opt.data('kategori');

        if (nama) {
            $('#edit_nama_user').val(nama);
            $('#edit_prev_nama').text(nama);
            $('#edit_prev_nip').text('NIP: ' + nip);
            $('#edit_prev_jabatan').text(jabatan);
            $('#edit_prev_kategori').text(kategori);
            $('#edit_pegawai_preview').removeClass('d-none');
        } else {
            $('#edit_pegawai_preview').addClass('d-none');
        }
    });

    // 4. Edit Button Handler
    $(document).on('click', '.btn-edit-user', function() {
        var id         = $(this).data('id');
        var id_pegawai = $(this).data('id_pegawai');
        var username   = $(this).data('username');
        var nama       = $(this).data('nama');
        var email      = $(this).data('email');
        var role       = $(this).data('role');
        var status     = $(this).data('status');

        $('#edit_id_user').val(id);
        $('#edit_id_pegawai').val(id_pegawai).trigger('change');
        $('#edit_username').val(username);
        $('#edit_nama_user').val(nama);
        $('#edit_email').val(email ? email : '');
        $('#edit_role').val(role ? role.toLowerCase() : 'administrator');
        $('#edit_status').val(status !== undefined ? status : 1);
        $('#edit_password').val('');
    });

    // 5. Detail Button Handler
    $(document).on('click', '.btn-detail-user', function() {
        var username     = $(this).data('username');
        var nama         = $(this).data('nama');
        var email        = $(this).data('email');
        var role         = $(this).data('role');
        var status       = $(this).data('status');
        var login        = $(this).data('login');
        var nama_pegawai = $(this).data('nama_pegawai');
        var nip          = $(this).data('nip');
        var jabatan      = $(this).data('jabatan');
        var kategori     = $(this).data('kategori');
        var pangkat      = $(this).data('pangkat');
        var golongan     = $(this).data('golongan');

        var r = role ? role.toLowerCase() : '';

        $('#detail_nama_user').text(nama);
        $('#detail_username_user').text('@' + username);
        $('#detail_email_user').text(email ? email : '-');
        $('#detail_last_login').text(login ? login : '-');

        if (nama_pegawai) {
            $('#detail_nama_pegawai').text(nama_pegawai);
            $('#detail_nip_pegawai').text('NIP: ' + nip);
            $('#detail_jabatan_pegawai').text(jabatan + (pangkat ? ' (' + pangkat + ' ' + golongan + ')' : ''));
            $('#detail_kategori_badge').text(kategori ? kategori : 'Pegawai').show();
        } else {
            $('#detail_nama_pegawai').text('Tidak terhubung ke data pegawai');
            $('#detail_nip_pegawai').text('-');
            $('#detail_jabatan_pegawai').text('-');
            $('#detail_kategori_badge').hide();
        }

        if (r === 'superadmin') {
            $('#detail_role_badge').html('<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-11">Superadmin</span>');
        } else if (r === 'pimpinan') {
            $('#detail_role_badge').html('<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11">Pimpinan</span>');
        } else if (r === 'tim_penilai') {
            $('#detail_role_badge').html('<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">Tim Penilai</span>');
        } else {
            $('#detail_role_badge').html('<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-11">Administrator</span>');
        }

        if (status == 1) {
            $('#detail_status_badge').html('<span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>');
        } else {
            $('#detail_status_badge').html('<span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Nonaktif</span>');
        }
    });

    // 6. Delete Button Handler
    $(document).on('click', '.btn-delete-user', function() {
        var id   = $(this).data('id');
        var nama = $(this).data('nama');

        $('#delete_id_user').val(id);
        $('#delete_nama_user').text(nama);
    });

    // 7. Submit Form Tambah User via AJAX
    $('#formTambahUser').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'user/simpan',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Pengguna');
                if (res.status) {
                    var modalEl = document.getElementById('modalTambahUser');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Simpan Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Simpan', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Pengguna');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menyimpan data pengguna.', false);
            }
        });
    });

    // 8. Submit Form Edit User via AJAX
    $('#formEditUser').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'user/simpan',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memperbarui...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Akun');
                if (res.status) {
                    var modalEl = document.getElementById('modalEditUser');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Perbarui Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Perbarui', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Akun');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat memperbarui data pengguna.', false);
            }
        });
    });

    // 9. Konfirmasi Hapus / Nonaktifkan User via AJAX
    $('#btnKonfirmasiHapusUser').on('click', function() {
        var id = $('#delete_id_user').val();
        if (!id) return;

        var btn = $(this);
        var payload = { id_user: id };
        payload[csrfTokenName] = csrfHash;

        $.ajax({
            url: baseUrl + 'user/hapus/' + id,
            type: 'POST',
            data: payload,
            dataType: 'json',
            beforeSend: function() {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menonaktifkan...');
            },
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).text('Ya, Menonaktifkan');
                var modalEl = document.getElementById('modalHapusUser');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (res.status) {
                    showToast('success', 'Nonaktif Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Nonaktif', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).text('Ya, Menonaktifkan');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menonaktifkan pengguna.', false);
            }
        });
    });
});
</script>
