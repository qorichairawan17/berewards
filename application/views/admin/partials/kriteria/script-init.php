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

        var bgClass   = 'bg-primary text-white';
        var iconClass = 'ti ti-info-circle text-white';

        if (type === 'success') {
            bgClass   = 'bg-success text-white';
            iconClass = 'ti ti-circle-check text-white';
        } else if (type === 'danger' || type === 'error') {
            bgClass   = 'bg-danger text-white';
            iconClass = 'ti ti-alert-circle text-white';
        } else if (type === 'warning') {
            bgClass   = 'bg-warning text-dark';
            iconClass = 'ti ti-alert-triangle text-dark';
        } else if (type === 'info') {
            bgClass   = 'bg-info text-white';
            iconClass = 'ti ti-info-circle text-white';
        }

        toastEl.className = 'toast align-items-center border-0 shadow-lg rounded-3 text-white ' + bgClass;

        $('#toastIcon').attr('class', iconClass + ' fs-22 me-1');
        $('#toastTitle').attr('class', 'd-block fs-13 fw-bold mb-0.5 ' + (type === 'warning' ? 'text-dark' : 'text-white')).text(title);
        $('#toastText').attr('class', 'fs-12 ' + (type === 'warning' ? 'text-dark' : 'text-white')).text(message);

        var bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
        bsToast.show();

        if (reload) {
            setTimeout(function() {
                location.reload();
            }, 1200);
        }
    }

    // Default Sub Kriteria / Skala Options Template
    var defaultSkalaOptions = [
        { sub_kriteria: 'Sangat Memenuhi Standar & Tanpa Pelanggaran', nilai: 5, keterangan: 'Sangat Baik' },
        { sub_kriteria: 'Memenuhi Standar dengan Baik',               nilai: 4, keterangan: 'Baik' },
        { sub_kriteria: 'Cukup Memenuhi Standar Operasional',         nilai: 3, keterangan: 'Cukup Baik' },
        { sub_kriteria: 'Terdapat Beberapa Catatan Keterlambatan',    nilai: 2, keterangan: 'Kurang Baik' },
        { sub_kriteria: 'Tidak Memenuhi Standar / Pelanggaran',       nilai: 1, keterangan: 'Buruk' }
    ];

    /**
     * Render single row in Sub Kriteria table builder
     */
    function renderSkalaRow(tbodyId, sub, nilai, ket) {
        var rowCount = $('#' + tbodyId + ' tr').length + 1;
        var subVal   = sub ? $('<div>').text(sub).html() : '';
        var ketVal   = ket ? $('<div>').text(ket).html() : '';
        var numVal   = (nilai !== undefined && nilai !== null && nilai !== '') ? parseFloat(nilai) : (6 - rowCount > 0 ? (6 - rowCount) : 1);

        var rowHtml = '<tr>' +
            '<td class="text-center fw-semibold skala-no">' + rowCount + '</td>' +
            '<td><input type="text" class="form-control form-control-sm" name="skala_sub_kriteria[]" value="' + subVal + '" placeholder="Deskripsi Sub Kriteria (contoh: Tidak Pernah Telat)" required></td>' +
            '<td><input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm text-center fw-bold" name="skala_nilai[]" value="' + numVal + '" placeholder="Nilai" required></td>' +
            '<td><input type="text" class="form-control form-control-sm" name="skala_keterangan[]" value="' + ketVal + '" placeholder="Contoh: Sangat Baik"></td>' +
            '<td class="text-center"><button type="button" class="btn btn-xs btn-outline-danger btn-remove-skala-row p-1 px-1.5" title="Hapus Baris"><i class="ti ti-trash fs-13"></i></button></td>' +
            '</tr>';

        $('#' + tbodyId).append(rowHtml);
        renumberSkalaRows(tbodyId);
    }

    /**
     * Renumber rows sequentially
     */
    function renumberSkalaRows(tbodyId) {
        $('#' + tbodyId + ' tr').each(function(idx) {
            $(this).find('.skala-no').text(idx + 1);
        });
    }

    /**
     * Populate default template rows into target tbody
     */
    function populateDefaultSkala(tbodyId) {
        $('#' + tbodyId).empty();
        $.each(defaultSkalaOptions, function(i, opt) {
            renderSkalaRow(tbodyId, opt.sub_kriteria, opt.nilai, opt.keterangan);
        });
    }

    // Initialize Add Modal Sub Kriteria rows
    populateDefaultSkala('tbodyAddSkala');

    // Toggle Sub Kriteria Builder on Modal Tambah
    $('#formTambahKriteria select[name="jenis_data"]').on('change', function() {
        if ($(this).val() === 'kualitatif') {
            if ($('#tbodyAddSkala tr').length === 0) {
                populateDefaultSkala('tbodyAddSkala');
            }
            $('#add_skala_container').slideDown(200);
        } else {
            $('#add_skala_container').slideUp(200);
        }
    });

    // Toggle Sub Kriteria Builder on Modal Edit
    $('#edit_jenis_data').on('change', function() {
        if ($(this).val() === 'kualitatif') {
            if ($('#tbodyEditSkala tr').length === 0) {
                populateDefaultSkala('tbodyEditSkala');
            }
            $('#edit_skala_container').slideDown(200);
        } else {
            $('#edit_skala_container').slideUp(200);
        }
    });

    // Button Add Row on Modal Tambah
    $(document).on('click', '.btn-add-skala-row-add', function() {
        renderSkalaRow('tbodyAddSkala', '', '', '');
    });

    // Button Add Row on Modal Edit
    $(document).on('click', '.btn-add-skala-row-edit', function() {
        renderSkalaRow('tbodyEditSkala', '', '', '');
    });

    // Button Remove Row (Both Add & Edit Modals)
    $(document).on('click', '.btn-remove-skala-row', function() {
        var tbody = $(this).closest('tbody');
        var tbodyId = tbody.attr('id');
        $(this).closest('tr').remove();
        renumberSkalaRows(tbodyId);
    });

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

        $('#tbodyEditSkala').empty();

        if (jenis === 'kualitatif') {
            $('#edit_skala_container').show();
            // Fetch detailed skala items via AJAX
            $.ajax({
                url: baseUrl + 'kriteria/detail/' + id,
                type: 'POST',
                data: { id_kriteria: id, [csrfTokenName]: csrfHash },
                dataType: 'json',
                success: function(res) {
                    updateCsrf(res);
                    if (res.status && res.data && res.data.skala_list && res.data.skala_list.length > 0) {
                        $('#tbodyEditSkala').empty();
                        $.each(res.data.skala_list, function(i, item) {
                            renderSkalaRow('tbodyEditSkala', item.sub_kriteria || item.label, item.nilai, item.keterangan || item.label);
                        });
                    } else {
                        populateDefaultSkala('tbodyEditSkala');
                    }
                },
                error: function() {
                    populateDefaultSkala('tbodyEditSkala');
                }
            });
        } else {
            $('#edit_skala_container').hide();
        }
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-kriteria', function() {
        var id       = $(this).data('id');
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
        $('#detail_jenis_data').text(jenis === 'kualitatif' ? 'Kualitatif (Skala 1-5)' : 'Kuantitatif (Angka Rill)');

        if (tipe === 'benefit') {
            $('#detail_tipe_atribut_badge').html('<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 fs-11"><i class="ti ti-trending-up me-1"></i>Benefit</span>');
        } else {
            $('#detail_tipe_atribut_badge').html('<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-0.5 fs-11"><i class="ti ti-trending-down me-1"></i>Cost</span>');
        }

        $('#tbodyDetailSkala').empty();

        if (jenis === 'kualitatif') {
            $('#detail_skala_container').show();
            // Fetch detail via AJAX to populate Sub Kriteria table
            $.ajax({
                url: baseUrl + 'kriteria/detail/' + id,
                type: 'POST',
                data: { id_kriteria: id, [csrfTokenName]: csrfHash },
                dataType: 'json',
                success: function(res) {
                    updateCsrf(res);
                    if (res.status && res.data && res.data.skala_list && res.data.skala_list.length > 0) {
                        var html = '';
                        $.each(res.data.skala_list, function(idx, item) {
                            var subTitle = item.sub_kriteria || item.label || '-';
                            var ketBadge = item.keterangan || item.label || '-';
                            html += '<tr>' +
                                '<td class="text-center fw-semibold">' + (idx + 1) + '</td>' +
                                '<td><strong class="text-dark fs-12">' + $('<div>').text(subTitle).html() + '</strong></td>' +
                                '<td class="text-center fw-bold text-primary fs-13">' + parseFloat(item.nilai).toFixed(0) + '</td>' +
                                '<td><span class="badge bg-light text-dark border px-2 py-1 fs-11">' + $('<div>').text(ketBadge).html() + '</span></td>' +
                                '</tr>';
                        });
                        $('#tbodyDetailSkala').html(html);
                    } else {
                        $('#tbodyDetailSkala').html('<tr><td colspan="4" class="text-center text-muted py-3">Belum ada opsi skala kualitatif terdaftar</td></tr>');
                    }
                },
                error: function() {
                    $('#tbodyDetailSkala').html('<tr><td colspan="4" class="text-center text-danger py-3">Gagal memuat rincian skala kriteria</td></tr>');
                }
            });
        } else {
            $('#detail_skala_container').hide();
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
