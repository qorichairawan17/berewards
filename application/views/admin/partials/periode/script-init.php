<!-- Page Script Periode Penilaian -->
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
        $('#tablePeriode').DataTable({
            language: {
                search: "Cari Periode:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data periode",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data periode tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[3, 'desc'], [4, 'desc']]
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

    // 3. Edit Button Handler
    $(document).on('click', '.btn-edit-periode', function() {
        var id         = $(this).data('id');
        var nama       = $(this).data('nama');
        var jenis      = $(this).data('jenis');
        var tahun      = $(this).data('tahun');
        var mulai      = $(this).data('mulai');
        var selesai    = $(this).data('selesai');
        var status     = $(this).data('status');
        var keterangan = $(this).data('keterangan');

        $('#edit_id_periode').val(id);
        $('#edit_nama_periode').val(nama);
        $('#edit_jenis_periode').val(jenis);
        $('#edit_tahun').val(tahun);
        $('#edit_status').val(status);
        $('#edit_keterangan').val(keterangan);

        if (document.getElementById('edit_tanggal_mulai')._flatpickr) {
            document.getElementById('edit_tanggal_mulai')._flatpickr.setDate(mulai, true);
        } else {
            $('#edit_tanggal_mulai').val(mulai);
        }

        if (document.getElementById('edit_tanggal_selesai')._flatpickr) {
            document.getElementById('edit_tanggal_selesai')._flatpickr.setDate(selesai, true);
        } else {
            $('#edit_tanggal_selesai').val(selesai);
        }
    });

    // 4. Detail Button Handler
    $(document).on('click', '.btn-detail-periode', function() {
        var nama       = $(this).data('nama');
        var jenis      = $(this).data('jenis');
        var tahun      = $(this).data('tahun');
        var mulai      = $(this).data('mulai');
        var selesai    = $(this).data('selesai');
        var status     = $(this).data('status');
        var keterangan = $(this).data('keterangan');

        $('#detail_nama_periode').text(nama);
        $('#detail_tahun_jenis').text('Jenis Siklus: ' + (jenis ? jenis.toUpperCase() : '-') + ' • Tahun ' + tahun);
        $('#detail_rentang_tanggal').text(mulai + ' s.d. ' + selesai);
        $('#detail_keterangan').text(keterangan ? keterangan : '-');

        if (status === 'buka') {
            $('#detail_status_badge').html('<span class="badge bg-success rounded-pill px-2 py-1 fs-10">Buka (Aktif)</span>');
        } else {
            $('#detail_status_badge').html('<span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Tutup (Selesai)</span>');
        }
    });

    // 5. Delete Button Handler
    $(document).on('click', '.btn-delete-periode', function() {
        var id   = $(this).data('id');
        var nama = $(this).data('nama');

        $('#delete_id_periode').val(id);
        $('#delete_nama_periode').text(nama);
    });

    // 6. Submit Form Tambah Periode via AJAX
    $('#formTambahPeriode').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'periode/simpan',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Periode');
                if (res.status) {
                    var modalEl = document.getElementById('modalTambahPeriode');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Simpan Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Simpan', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Periode');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menyimpan periode.', false);
            }
        });
    });

    // 7. Submit Form Edit Periode via AJAX
    $('#formEditPeriode').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'periode/simpan',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memperbarui...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Periode');
                if (res.status) {
                    var modalEl = document.getElementById('modalEditPeriode');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Perbarui Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Perbarui', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Periode');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat memperbarui periode.', false);
            }
        });
    });

    // 8. Konfirmasi Hapus / Tutup Periode via AJAX
    $('#btnKonfirmasiHapusPeriode').on('click', function() {
        var id = $('#delete_id_periode').val();
        if (!id) return;

        var btn = $(this);
        var payload = { id_periode: id };
        payload[csrfTokenName] = csrfHash;

        $.ajax({
            url: baseUrl + 'periode/hapus/' + id,
            type: 'POST',
            data: payload,
            dataType: 'json',
            beforeSend: function() {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menonaktifkan...');
            },
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).text('Ya, Hapus Data');
                var modalEl = document.getElementById('modalHapusPeriode');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (res.status) {
                    showToast('success', 'Hapus Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Hapus', res.message, false);
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).text('Ya, Hapus Data');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menonaktifkan periode.', false);
            }
        });
    });
});
</script>
