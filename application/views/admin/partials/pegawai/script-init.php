<!-- Page Script for Pegawai Module -->
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

        toastEl.className = 'toast align-items-center border-0 shadow-lg rounded-3 ' + bgClass;

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
        $('#tablePegawai').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data pegawai tidak ditemukan",
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

    // 2. Edit Button Handler
    $(document).on('click', '.btn-edit-pegawai', function() {
        var id       = $(this).data('id');
        var nip      = $(this).data('nip');
        var nama     = $(this).data('nama');
        var pangkat  = $(this).data('pangkat');
        var golongan = $(this).data('golongan');
        var jabatan  = $(this).data('jabatan');
        var kategori = $(this).data('kategori');
        var foto     = $(this).data('foto');

        $('#edit_id').val(id);
        $('#edit_nip').val(nip);
        $('#edit_nama').val(nama);
        $('#edit_pangkat').val(pangkat);
        $('#edit_golongan').val(golongan);
        $('#edit_jabatan').val(jabatan);
        $('#edit_kategori').val(kategori);
        if (foto && foto !== 'null' && foto !== '') {
            $('#edit_preview_foto').attr('src', foto).show();
        } else {
            $('#edit_preview_foto').hide();
        }
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-pegawai', function() {
        var id       = $(this).data('id');
        var nip      = $(this).data('nip');
        var nama     = $(this).data('nama');
        var pangkat  = $(this).data('pangkat');
        var golongan = $(this).data('golongan');
        var jabatan  = $(this).data('jabatan');
        var kategori = $(this).data('kategori');
        var foto     = $(this).data('foto');

        $('#detail_nama').text(nama);
        $('#detail_nip').text('NIP. ' + nip);
        $('#detail_kategori_badge').text(kategori);
        $('#detail_pangkat_gol').text((pangkat ? pangkat : '-') + ' (' + (golongan ? golongan : '-') + ')');
        $('#detail_jabatan').text(jabatan ? jabatan : '-');
        if (foto && foto !== 'null' && foto !== '') {
            $('#detail_foto_img').attr('src', foto).parent().show();
        } else {
            $('#detail_foto_img').parent().hide();
        }
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-pegawai', function() {
        var id   = $(this).data('id');
        var nama = $(this).data('nama');

        $('#delete_id').val(id);
        $('#delete_nama_pegawai').text(nama);
    });

    // 5. Submit Form Tambah Pegawai via AJAX
    $('#formTambahPegawai').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        if (!formData.has(csrfTokenName)) {
            formData.append(csrfTokenName, csrfHash);
        }

        $.ajax({
            url: baseUrl + 'pegawai/simpan',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Data');
                if (res.status) {
                    var modalEl = document.getElementById('modalTambahPegawai');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Simpan Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Simpan', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Data');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menyimpan data pegawai.', false);
            }
        });
    });

    // 6. Submit Form Edit Pegawai via AJAX
    $('#formEditPegawai').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        if (!formData.has(csrfTokenName)) {
            formData.append(csrfTokenName, csrfHash);
        }

        $.ajax({
            url: baseUrl + 'pegawai/simpan',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memperbarui...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Data');
                if (res.status) {
                    var modalEl = document.getElementById('modalEditPegawai');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Perbarui Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Perbarui', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Data');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat memperbarui data pegawai.', false);
            }
        });
    });

    // 7. Konfirmasi Hapus Pegawai via AJAX
    $('#btnKonfirmasiHapus').on('click', function() {
        var id = $('#delete_id').val();
        if (!id) return;

        var btn = $(this);
        var payload = { id_pegawai: id };
        payload[csrfTokenName] = csrfHash;

        $.ajax({
            url: baseUrl + 'pegawai/hapus/' + id,
            type: 'POST',
            data: payload,
            dataType: 'json',
            beforeSend: function() {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menghapus...');
            },
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html('Ya, Hapus Data');
                var modalEl = document.getElementById('modalHapusPegawai');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (res.status) {
                    showToast('success', 'Hapus Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Hapus', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html('Ya, Hapus Data');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menghapus data pegawai.', false);
            }
        });
    });
});
</script>
