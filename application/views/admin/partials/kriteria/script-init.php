<!-- Page Script Kriteria Penilaian -->
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
        $('#tableKriteria').DataTable({
            language: {
                search: "Cari Kriteria:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data kriteria",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data kriteria tidak ditemukan",
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
    $(document).on('click', '.btn-edit-kriteria', function() {
        var id       = $(this).data('id');
        var kode     = $(this).data('kode');
        var nama     = $(this).data('nama');
        var kategori = $(this).data('kategori');
        var bobot    = $(this).data('bobot');
        var jenis    = $(this).data('jenis');
        var tipe     = $(this).data('tipe');

        $('#edit_id_kriteria').val(id);
        $('#edit_kode').val(kode);
        $('#edit_nama_kriteria').val(nama);
        $('#edit_kategori').val(kategori);
        $('#edit_bobot').val(bobot);
        $('#edit_jenis_data').val(jenis);
        $('#edit_tipe_atribut').val(tipe);
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-kriteria', function() {
        var kode     = $(this).data('kode');
        var nama     = $(this).data('nama');
        var kategori = $(this).data('kategori');
        var bobot    = $(this).data('bobot');
        var jenis    = $(this).data('jenis');
        var tipe     = $(this).data('tipe');

        $('#detail_kode_badge').text(kode);
        $('#detail_nama_kriteria').text(nama);
        $('#detail_kategori_pegawai').text('Kategori: ' + kategori);
        $('#detail_bobot').text(bobot + '%');
        $('#detail_jenis_data').text(jenis);

        if (tipe === 'benefit') {
            $('#detail_tipe_atribut_badge').html('<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-11">Benefit</span>');
        } else {
            $('#detail_tipe_atribut_badge').html('<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11">Cost</span>');
        }
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-kriteria', function() {
        var id   = $(this).data('id');
        var nama = $(this).data('nama');

        $('#delete_id_kriteria').val(id);
        $('#delete_nama_kriteria').text(nama);
    });

    // 5. Submit Form Tambah Kriteria via AJAX
    $('#formTambahKriteria').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'kriteria/simpan',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Kriteria');
                if (res.status) {
                    var modalEl = document.getElementById('modalTambahKriteria');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Simpan Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Simpan', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Kriteria');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menyimpan kriteria.', false);
            }
        });
    });

    // 6. Submit Form Edit Kriteria via AJAX
    $('#formEditKriteria').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'kriteria/simpan',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memperbarui...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Kriteria');
                if (res.status) {
                    var modalEl = document.getElementById('modalEditKriteria');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Perbarui Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Perbarui', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Kriteria');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat memperbarui kriteria.', false);
            }
        });
    });

    // 7. Konfirmasi Hapus Kriteria via AJAX
    $('#btnKonfirmasiHapusKriteria').on('click', function() {
        var id = $('#delete_id_kriteria').val();
        if (!id) return;

        var btn = $(this);
        var payload = { id_kriteria: id };
        payload[csrfTokenName] = csrfHash;

        $.ajax({
            url: baseUrl + 'kriteria/hapus/' + id,
            type: 'POST',
            data: payload,
            dataType: 'json',
            beforeSend: function() {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menonaktifkan...');
            },
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).text('Ya, Nonaktifkan');
                var modalEl = document.getElementById('modalHapusKriteria');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (res.status) {
                    showToast('success', 'Nonaktif Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Nonaktif', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).text('Ya, Nonaktifkan');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menonaktifkan kriteria.', false);
            }
        });
    });
});
</script>
