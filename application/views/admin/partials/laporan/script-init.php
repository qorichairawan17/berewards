<!-- Page Script Laporan & Berita Acara -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    var csrfTokenName = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    // 1. Toast Notification Utility (Clean & White Text Standard)
    function showToast(type, title, message) {
        var toastEl = $('#toastNotification');
        if (!toastEl.length) {
            alert(title + ': ' + message);
            return;
        }

        toastEl.removeClass('bg-success bg-danger bg-warning bg-info text-dark').addClass('text-white');
        var iconClass = 'ti ti-info-circle';

        if (type === 'success') {
            toastEl.addClass('bg-success');
            iconClass = 'ti ti-circle-check';
        } else if (type === 'danger' || type === 'error') {
            toastEl.addClass('bg-danger');
            iconClass = 'ti ti-alert-triangle';
        } else if (type === 'warning') {
            toastEl.addClass('bg-warning');
            iconClass = 'ti ti-alert-circle';
        } else {
            toastEl.addClass('bg-info');
            iconClass = 'ti ti-info-circle';
        }

        $('#toastIcon').attr('class', iconClass + ' fs-22 me-1 text-white');
        $('#toastTitle').text(title);
        $('#toastText').text(message);

        var toast = bootstrap.Toast.getOrCreateInstance(toastEl[0], { delay: 4000 });
        toast.show();
    }

    function updateCsrf(res) {
        if (res && res.csrf_token_name && res.csrf_hash) {
            csrfTokenName = res.csrf_token_name;
            csrfHash = res.csrf_hash;
            $('input[name="' + csrfTokenName + '"]').val(csrfHash);
        }
    }

    // 2. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tableLaporan').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Dokumen Berita Acara tidak ditemukan",
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

    // 3. Initialize Flatpickr Datepicker
    if (typeof flatpickr !== 'undefined') {
        flatpickr(".datepicker-input", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            allowInput: true
        });
    }

    // 4. Handle SK Change in Modal Add
    $('#add_id_sk').on('change', function() {
        var selected = $(this).find('option:selected');
        var ketua = selected.data('ketua');
        if (ketua) {
            $('#add_ketua_panitia').val(ketua);
        }
    });

    // 5. Submit Form Tambah Berita Acara (AJAX)
    $('#formTambahLaporan').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#btnSubmitAddLaporan');
        var origHtml = btn.html();

        var formData = form.serializeArray();
        formData.push({ name: csrfTokenName, value: csrfHash });

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menerbitkan...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html(origHtml);

                if (res.status) {
                    var modalEl = document.getElementById('modalTambahLaporan');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();

                    showToast('success', 'Berhasil', res.message || 'Berita Acara berhasil diterbitkan.');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showToast('danger', 'Gagal', res.message || 'Terjadi kesalahan saat menerbitkan Berita Acara.');
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(origHtml);
                var msg = 'Gagal menghubungi server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                showToast('danger', 'Error Jaringan', msg);
            }
        });
    });

    // 6. Edit Button Click Handler
    $(document).on('click', '.btn-edit-laporan', function() {
        var id = $(this).data('id');
        var noba = $(this).data('noba');
        var status = $(this).data('status');
        var tanggal = $(this).data('tanggal');
        var ketua = $(this).data('ketua');

        $('#edit_id_laporan').val(id);
        $('#edit_no_ba').val(noba);
        $('#edit_status').val(status);
        $('#edit_ketua_panitia').val(ketua);

        var dateInput = document.getElementById('edit_tanggal_terbit');
        if (dateInput && dateInput._flatpickr) {
            dateInput._flatpickr.setDate(tanggal, true);
        } else {
            $('#edit_tanggal_terbit').val(tanggal);
        }
    });

    // 7. Submit Form Edit Berita Acara (AJAX)
    $('#formEditLaporan').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#btnSubmitEditLaporan');
        var origHtml = btn.html();

        var formData = form.serializeArray();
        formData.push({ name: csrfTokenName, value: csrfHash });

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html(origHtml);

                if (res.status) {
                    var modalEl = document.getElementById('modalEditLaporan');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();

                    showToast('success', 'Berhasil', res.message || 'Perubahan Berita Acara berhasil disimpan.');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showToast('danger', 'Gagal', res.message || 'Terjadi kesalahan saat memperbarui Berita Acara.');
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(origHtml);
                var msg = 'Gagal menghubungi server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                showToast('danger', 'Error', msg);
            }
        });
    });

    // 8. Delete Button Click Handler & Confirmation
    var targetDeleteId = null;
    $(document).on('click', '.btn-delete-laporan', function() {
        targetDeleteId = $(this).data('id');
        var noba = $(this).data('noba');
        $('#delete_no_ba').text(noba || 'Dokumen Berita Acara #' + targetDeleteId);
    });

    $('#btnKonfirmasiHapusLaporan').on('click', function() {
        if (!targetDeleteId) return;

        var btn = $(this);
        var origHtml = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menghapus...');

        $.ajax({
            url: '<?= site_url("laporan/delete"); ?>',
            type: 'POST',
            data: {
                id_laporan: targetDeleteId,
                [csrfTokenName]: csrfHash
            },
            dataType: 'json',
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html(origHtml);

                var modalEl = document.getElementById('modalHapusLaporan');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (res.status) {
                    showToast('success', 'Berhasil', res.message || 'Dokumen Berita Acara berhasil dihapus.');
                    $('#row_laporan_' + targetDeleteId).fadeOut(400, function() {
                        $(this).remove();
                    });
                } else {
                    showToast('danger', 'Gagal', res.message || 'Gagal menghapus dokumen Berita Acara.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html(origHtml);
                showToast('danger', 'Error', 'Gagal menghubungi server.');
            }
        });
    });

    // 9. Detail / Pratinjau Button Handler
    $(document).on('click', '.btn-detail-laporan', function() {
        var id       = $(this).data('id');
        var noba     = $(this).data('noba');
        var periode  = $(this).data('periode');
        var kategori = $(this).data('kategori');
        var tanggal  = $(this).data('tanggal');
        var ketua    = $(this).data('ketua');
        var top3Data = $(this).data('top3');

        $('#preview_no_ba').text('Nomor: ' + noba);
        $('#preview_periode').text(periode);
        $('#preview_kategori').text('Kategori ' + kategori);
        $('#preview_tanggal_terbit').text(tanggal);
        $('#preview_ketua').text(ketua || 'Ketua Tim Penilai');

        $('#btnDownloadWordDetail').data('id', id);

        var tbodyHtml = '';
        if (typeof top3Data === 'string') {
            try { top3Data = JSON.parse(top3Data); } catch (e) { top3Data = []; }
        }

        if (Array.isArray(top3Data) && top3Data.length > 0) {
            top3Data.forEach(function(item) {
                var rankBadge = '';
                var ketBadge = '';

                if (item.rank == 1) {
                    rankBadge = '<span class="badge bg-warning text-dark border border-warning px-2 py-1"><i class="ti ti-trophy text-warning me-1"></i>Rank #1</span>';
                    ketBadge = '<span class="badge bg-success rounded-pill px-2 py-1 fs-10"><i class="ti ti-check me-1"></i>Penerima Reward</span>';
                } else if (item.rank == 2) {
                    rankBadge = '<span class="badge bg-secondary-subtle text-dark border border-secondary px-2 py-1">Rank #2</span>';
                    ketBadge = '<span class="badge bg-info-subtle text-info rounded-pill px-2 py-1 fs-10">Runner Up 1</span>';
                } else {
                    rankBadge = '<span class="badge bg-light text-dark border px-2 py-1">Rank #3</span>';
                    ketBadge = '<span class="badge bg-light text-muted rounded-pill px-2 py-1 fs-10">Runner Up 2</span>';
                }

                tbodyHtml += '<tr>' +
                    '<td class="text-center">' + rankBadge + '</td>' +
                    '<td><strong class="d-block text-dark">' + item.nama + '</strong><small class="text-muted fs-11">NIP. ' + (item.nip || '-') + '</small></td>' +
                    '<td><span class="badge bg-light text-dark border px-2 py-1">' + (item.kategori || kategori) + '</span></td>' +
                    '<td class="text-center"><strong class="text-primary fs-13">' + parseFloat(item.skor).toFixed(4) + '</strong></td>' +
                    '<td class="text-center">' + ketBadge + '</td>' +
                    '</tr>';
            });
        } else {
            tbodyHtml = '<tr><td colspan="5" class="text-center text-muted">Data kandidat terbaik tidak ditemukan.</td></tr>';
        }

        $('#preview_top3_tbody').html(tbodyHtml);
    });

    // 10. Export Word Handlers (Direct Download)
    $(document).on('click', '.btn-export-word', function() {
        var id = $(this).data('id');
        if (!id) {
            showToast('danger', 'Error', 'ID Berita Acara tidak ditemukan.');
            return;
        }
        showToast('info', 'Menyiapkan Dokumen', 'Sedang mengunduh dokumen Word Berita Acara...');
        window.location.href = '<?= site_url("laporan/export/"); ?>' + id;
    });

    $(document).on('click', '#btnDownloadWordDetail', function() {
        var id = $(this).data('id');
        if (!id) {
            showToast('danger', 'Error', 'ID Berita Acara tidak ditemukan.');
            return;
        }
        window.location.href = '<?= site_url("laporan/export/"); ?>' + id;
    });

    // 11. Select Period for Showroom Preview
    $('#formPilihPeriodeShowroom').on('submit', function(e) {
        e.preventDefault();
        var id = $('#select_showroom_periode').val();
        if (id) {
            window.location.href = '<?= site_url("laporan/preview/"); ?>' + id;
        }
    });
});
</script>
