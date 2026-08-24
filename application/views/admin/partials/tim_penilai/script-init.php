<!-- Page Script Tim Penilai -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var baseUrl = '<?= site_url(); ?>';
    var csrfTokenName = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    // Options HTML for Pegawai selects
    var pegawaiOptionsHtml = '<option value="">-- Pilih Pegawai Anggota Tim --</option>' +
        <?php if (!empty($pegawai_list)): ?>
            <?php foreach ($pegawai_list as $p): ?>
                '<option value="<?= $p['id_pegawai']; ?>"><?= addslashes(html_escape($p['nama'])); ?> (<?= addslashes(html_escape($p['jabatan'])); ?>)</option>' +
            <?php endforeach; ?>
        <?php endif; ?>
        '';

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

    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tableTimPenilai').DataTable({
            language: {
                search: "Cari SK:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data SK",
                infoEmpty: "Tidak ada data",
                zeroRecords: "SK Tim Penilai tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[2, 'desc']] // Default order by Tahun descending
        });
    }

    // 2. Initialize Flatpickr Datepicker
    if (typeof flatpickr !== 'undefined') {
        flatpickr(".datepicker-input", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            allowInput: true
        });
    }

    var memberRowCounter = 1;
    // Template HTML Baris Anggota Tim Penilai Baru dengan Multicheck Kategori
    function createMemberRowHtml(prefix, selectedPegawaiId, checkedCategories) {
        prefix = prefix || 'add';
        memberRowCounter++;
        var rowId = prefix + '_row_' + memberRowCounter;
        checkedCategories = checkedCategories || ['Hakim', 'Panitera Pengganti'];

        var isHakim = checkedCategories.indexOf('Hakim') !== -1 ? 'checked' : '';
        var isPP    = checkedCategories.indexOf('Panitera Pengganti') !== -1 ? 'checked' : '';
        var isJS    = checkedCategories.indexOf('Jurusita') !== -1 ? 'checked' : '';
        var isStaf  = checkedCategories.indexOf('Staf') !== -1 ? 'checked' : '';

        return '<div class="member-row p-3 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-3 mb-2">' +
            '<div class="flex-grow-1" style="min-width: 250px;">' +
                '<label class="form-label fw-semibold text-dark fs-11 mb-1">Nama & NIP Pegawai Anggota <span class="text-danger">*</span></label>' +
                '<select class="form-select form-select-sm" name="anggota_pegawai[]" required>' +
                    pegawaiOptionsHtml +
                '</select>' +
            '</div>' +
            '<div class="flex-grow-1" style="min-width: 320px;">' +
                '<label class="form-label fw-semibold text-dark fs-11 mb-1">' +
                    '<i class="ti ti-check-check text-primary me-1"></i> Kategori Pegawai yang Dinilai (Bisa Pilih > 1)' +
                '</label>' +
                '<div class="d-flex flex-wrap align-items-center gap-2 p-2 bg-white rounded border">' +
                    '<div class="form-check form-check-inline me-2 mb-0">' +
                        '<input class="form-check-input" type="checkbox" id="' + rowId + '_hakim" name="add_kategori_' + memberRowCounter + '[]" value="Hakim" ' + isHakim + '>' +
                        '<label class="form-check-label fs-11 fw-semibold text-dark pointer" for="' + rowId + '_hakim">Hakim</label>' +
                    '</div>' +
                    '<div class="form-check form-check-inline me-2 mb-0">' +
                        '<input class="form-check-input" type="checkbox" id="' + rowId + '_pp" name="add_kategori_' + memberRowCounter + '[]" value="Panitera Pengganti" ' + isPP + '>' +
                        '<label class="form-check-label fs-11 fw-semibold text-dark pointer" for="' + rowId + '_pp">Panitera Pengganti</label>' +
                    '</div>' +
                    '<div class="form-check form-check-inline me-2 mb-0">' +
                        '<input class="form-check-input" type="checkbox" id="' + rowId + '_jurusita" name="add_kategori_' + memberRowCounter + '[]" value="Jurusita" ' + isJS + '>' +
                        '<label class="form-check-label fs-11 fw-semibold text-dark pointer" for="' + rowId + '_jurusita">Jurusita</label>' +
                    '</div>' +
                    '<div class="form-check form-check-inline me-0 mb-0">' +
                        '<input class="form-check-input" type="checkbox" id="' + rowId + '_staf" name="add_kategori_' + memberRowCounter + '[]" value="Staf" ' + isStaf + '>' +
                        '<label class="form-check-label fs-11 fw-semibold text-dark pointer" for="' + rowId + '_staf">Staf</label>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div class="align-self-end ms-auto">' +
                '<button type="button" class="btn btn-sm btn-outline-danger btn-remove-member-row" title="Hapus Baris Anggota">' +
                    '<i class="ti ti-trash"></i>' +
                '</button>' +
            '</div>' +
        '</div>';
    }

    // Initialize default member rows on Modal Add open
    $('#modalTambahTim').on('show.bs.modal', function() {
        if ($('#addMemberListContainer').children().length === 0) {
            $('#addMemberListContainer').append(createMemberRowHtml('add'));
            $('#addMemberListContainer').append(createMemberRowHtml('add'));
        }
    });

    // Tambah Baris Anggota pada Modal Tambah
    $('#btnAddAddMemberRow').on('click', function() {
        $('#addMemberListContainer').append(createMemberRowHtml('add'));
    });

    // Tambah Baris Anggota pada Modal Edit
    $('#btnEditAddMemberRow').on('click', function() {
        $('#editMemberListContainer').append(createMemberRowHtml('edit'));
    });

    // Hapus Baris Anggota
    $(document).on('click', '.btn-remove-member-row', function() {
        var container = $(this).closest('.d-flex.flex-column');
        var rowCount = container.find('.member-row').length;
        if (rowCount > 1) {
            $(this).closest('.member-row').remove();
        } else {
            showToast('warning', 'Peringatan', 'Minimal harus ada 1 anggota tim penilai.', false);
        }
    });

    // Edit Button Handler
    $(document).on('click', '.btn-edit-tim', function() {
        var id        = $(this).data('id');
        var nosk      = $(this).data('nosk');
        var tahun     = $(this).data('tahun');
        var tanggal   = $(this).data('tanggal');
        var perihal   = $(this).data('perihal');
        var status    = $(this).data('status');
        var ketua     = $(this).data('ketua');
        var sekretaris = $(this).data('sekretaris');

        $('#edit_id_sk').val(id);
        $('#edit_no_sk').val(nosk);
        $('#edit_tahun').val(tahun);
        $('#edit_tanggal_sk').val(tanggal);
        $('#edit_perihal').val(perihal);
        $('#edit_status').val(status);
        if (ketua) $('#edit_id_ketua').val(ketua);
        if (sekretaris) $('#edit_id_sekretaris').val(sekretaris);

        // Fetch SK details for edit member list
        $.get(baseUrl + 'timpenilai/detail/' + id, function(res) {
            if (res && res.data && res.data.anggota) {
                $('#editMemberListContainer').empty();
                $.each(res.data.anggota, function(idx, item) {
                    var html = createMemberRowHtml('edit');
                    var $row = $(html);
                    $row.find('select').val(item.id_pegawai);
                    $('#editMemberListContainer').append($row);
                });
            }
        }, 'json');
    });

    // Delete Button Handler
    $(document).on('click', '.btn-delete-tim', function() {
        var id   = $(this).data('id');
        var nosk = $(this).data('nosk');

        $('#delete_id_sk').val(id);
        $('#delete_no_sk').text(nosk);
    });

    // Submit Form Tambah SK via AJAX
    $('#formTambahTim').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        if (!formData.has(csrfTokenName)) {
            formData.append(csrfTokenName, csrfHash);
        }

        $.ajax({
            url: baseUrl + 'timpenilai/simpan',
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
                $(form).find('button[type="submit"]').prop('disabled', false).html('<i class="ti ti-check me-1"></i> Simpan SK Tim Penilai');
                if (res.status) {
                    var modalEl = document.getElementById('modalTambahTim');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Simpan Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Simpan', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('<i class="ti ti-check me-1"></i> Simpan SK Tim Penilai');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menyimpan SK Tim Penilai.', false);
            }
        });
    });

    // Submit Form Edit SK via AJAX
    $('#formEditTim').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        if (!formData.has(csrfTokenName)) {
            formData.append(csrfTokenName, csrfHash);
        }

        $.ajax({
            url: baseUrl + 'timpenilai/simpan',
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
                $(form).find('button[type="submit"]').prop('disabled', false).html('<i class="ti ti-check me-1"></i> Perbarui SK');
                if (res.status) {
                    var modalEl = document.getElementById('modalEditTim');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Perbarui Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Perbarui', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('<i class="ti ti-check me-1"></i> Perbarui SK');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat memperbarui SK Tim Penilai.', false);
            }
        });
    });

    // Konfirmasi Hapus SK via AJAX
    $('#btnKonfirmasiHapusTim').on('click', function() {
        var id = $('#delete_id_sk').val();
        if (!id) return;

        var btn = $(this);
        var payload = { id_sk: id };
        payload[csrfTokenName] = csrfHash;

        $.ajax({
            url: baseUrl + 'timpenilai/hapus/' + id,
            type: 'POST',
            data: payload,
            dataType: 'json',
            beforeSend: function() {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menghapus...');
            },
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html('<i class="ti ti-trash me-1"></i> Ya, Hapus SK');
                var modalEl = document.getElementById('modalHapusTim');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (res.status) {
                    showToast('success', 'Hapus Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Hapus', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html('<i class="ti ti-trash me-1"></i> Ya, Hapus SK');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menghapus SK Tim Penilai.', false);
            }
        });
    });
});
</script>
