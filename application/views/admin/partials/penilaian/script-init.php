<!-- Page Script Penilaian & TOPSIS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var baseUrl       = '<?= site_url(); ?>';
    var csrfTokenName = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash      = '<?= $this->security->get_csrf_hash(); ?>';

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

    // 1. Initialize DataTables for Period List
    if ($.fn.DataTable && $('#tablePeriodePenilaian').length) {
        $('#tablePeriodePenilaian').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Sesi penilaian tidak ditemukan",
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

    // 2. Initialize DataTables for TOPSIS Results
    if ($.fn.DataTable && $('#tableHasilTopsis').length) {
        $('#tableHasilTopsis').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data hasil TOPSIS tidak ditemukan",
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

    // 3. Edit Penilaian Button Handler
    $(document).on('click', '.btn-edit-penilaian', function() {
        var id_alt    = $(this).data('id_alternatif');
        var id_proses = $(this).data('id_proses');
        var nama      = $(this).data('nama');
        var periode   = $(this).data('periode');
        var scores    = $(this).data('scores');

        $('#edit_id_proses_alternatif').val(id_alt);
        $('#edit_id_proses').val(id_proses);
        $('#edit_nama_pegawai').val(nama);
        $('#edit_nama_periode').val(periode);

        if (scores && typeof scores === 'object') {
            $.each(scores, function(kr_id, val) {
                var el = $('#edit_c_' + kr_id);
                if (el.length) {
                    if (el.is('select')) {
                        el.val(val);
                        if (!el.val() && val !== undefined && val !== null) {
                            el.val(parseFloat(val));
                        }
                    } else {
                        el.val(val);
                    }
                }
            });
        }
    });

    // 4. Detail Penilaian Button Handler
    $(document).on('click', '.btn-detail-penilaian', function() {
        var nama      = $(this).data('nama');
        var nip       = $(this).data('nip');
        var kategori  = $(this).data('kategori');
        var skor      = $(this).data('skor');
        var peringkat = $(this).data('peringkat');
        var dplus     = $(this).data('dplus');
        var dminus    = $(this).data('dminus');
        var matrix    = $(this).data('matrix');

        $('#detail_nama_pegawai').text(nama);
        $('#detail_nip_pegawai').text('NIP. ' + (nip ? nip : '-'));
        $('#detail_kategori_pegawai').text(kategori ? kategori : 'Pegawai');
        $('#detail_skor_topsis').text(parseFloat(skor || 0).toFixed(4));

        var badgeClass = (peringkat == 1) ? 'bg-warning text-dark border border-warning fw-bold' : 'bg-success text-white';
        $('#detail_peringkat_badge').attr('class', 'badge rounded-pill px-2.5 py-1 fs-11 ' + badgeClass).text((peringkat == 1 ? '★ #1 WINNER' : 'Peringkat #' + peringkat));

        $('#detail_d_plus').text(parseFloat(dplus || 0).toFixed(4));
        $('#detail_d_minus').text(parseFloat(dminus || 0).toFixed(4));
        $('#detail_box_dplus').text(parseFloat(dplus || 0).toFixed(4));
        $('#detail_box_dminus').text(parseFloat(dminus || 0).toFixed(4));

        var tbodyHtml = '';
        if (matrix && Array.isArray(matrix) && matrix.length > 0) {
            var totalRows = matrix.length;
            matrix.forEach(function(item, idx) {
                tbodyHtml += '<tr>';
                tbodyHtml += '<td class="text-start fw-semibold">' + item.kode + ': ' + item.nama_kriteria + ' <span class="badge bg-light text-muted border fs-10 text-uppercase">' + item.tipe_atribut + '</span></td>';
                tbodyHtml += '<td class="fw-bold font-monospace">' + item.x + '</td>';
                tbodyHtml += '<td class="font-monospace">' + item.r + '</td>';
                tbodyHtml += '<td class="font-monospace fw-semibold text-primary">' + item.y + '</td>';
                if (idx === 0) {
                    tbodyHtml += '<td rowspan="' + totalRows + '" class="fw-bold text-danger align-middle font-monospace fs-13">' + parseFloat(dplus || 0).toFixed(4) + '</td>';
                    tbodyHtml += '<td rowspan="' + totalRows + '" class="fw-bold text-success align-middle font-monospace fs-13">' + parseFloat(dminus || 0).toFixed(4) + '</td>';
                }
                tbodyHtml += '</tr>';
            });
        } else {
            tbodyHtml = '<tr><td colspan="6" class="text-muted py-3">Tidak ada rincian kriteria untuk pegawai ini.</td></tr>';
        }

        $('#detail_matrix_tbody').html(tbodyHtml);
    });

    // 5. Delete Penilaian Button Handler
    $(document).on('click', '.btn-delete-penilaian', function() {
        var id   = $(this).data('id');
        var nama = $(this).data('nama');

        $('#delete_id_proses').val(id);
        $('#delete_nama_penilaian').text(nama);
    });

    // 6. Submit Form Tambah Penilaian via AJAX
    $('#formTambahPenilaian').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'proses/simpan_sesi',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Buat Sesi Penilaian (Status Draft)');
                if (res.status) {
                    var modalEl = document.getElementById('modalTambahPenilaian');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Sesi Berhasil Dibuat', res.message, false);
                    setTimeout(function() {
                        window.location.href = baseUrl + 'proses/detail/' + res.id_proses;
                    }, 1000);
                } else {
                    showToast('danger', 'Gagal Membuat Sesi', res.message, false);
                }
            },
            error: function(xhr) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Buat Sesi Penilaian (Status Draft)');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat membuat sesi penilaian.', false);
            }
        });
    });

    // 7. Submit Form Input Nilai Pegawai via AJAX
    $('#formInputNilaiPegawai').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'proses/simpan_nilai',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Nilai Alternative');
                if (res.status) {
                    var modalEl = document.getElementById('modalInputNilaiPegawai');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Nilai Tersimpan', res.message, true);
                } else {
                    showToast('danger', 'Gagal Simpan Nilai', res.message, false);
                }
            },
            error: function(xhr) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Simpan Nilai Alternative');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menyimpan nilai.', false);
            }
        });
    });

    // 8. Submit Form Edit Nilai Pegawai via AJAX
    $('#formEditPenilaian').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = $(form).serialize();

        if (formData.indexOf(csrfTokenName) === -1) {
            formData += '&' + csrfTokenName + '=' + encodeURIComponent(csrfHash);
        }

        $.ajax({
            url: baseUrl + 'proses/simpan_nilai',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memperbarui...');
            },
            success: function(res) {
                updateCsrf(res);
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Nilai');
                if (res.status) {
                    var modalEl = document.getElementById('modalEditPenilaian');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('success', 'Perbarui Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Perbarui', res.message, false);
                }
            },
            error: function(xhr) {
                $(form).find('button[type="submit"]').prop('disabled', false).html('Perbarui Nilai');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat memperbarui nilai.', false);
            }
        });
    });

    // 9. Konfirmasi Hapus Sesi Penilaian via AJAX
    $('#btnKonfirmasiHapusPenilaian').on('click', function() {
        var id = $('#delete_id_proses').val();
        if (!id) return;

        var btn = $(this);
        var payload = { id_proses: id };
        payload[csrfTokenName] = csrfHash;

        $.ajax({
            url: baseUrl + 'proses/hapus/' + id,
            type: 'POST',
            data: payload,
            dataType: 'json',
            beforeSend: function() {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menghapus...');
            },
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).text('Ya, Hapus Data');
                var modalEl = document.getElementById('modalHapusPenilaian');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (res.status) {
                    showToast('success', 'Hapus Berhasil', res.message, true);
                } else {
                    showToast('danger', 'Gagal Menghapus', res.message, false);
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Ya, Hapus Data');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menghapus sesi.', false);
            }
        });
    });

    // 10. Proses Perhitungan TOPSIS (Trigger Perhitungan Lengkap & Finalisasi Status)
    $(document).on('click', '#btnProsesHitungTopsis', function() {
        var btn       = $(this);
        var id_proses = btn.data('id');
        var payload   = { id_proses: id_proses };
        payload[csrfTokenName] = csrfHash;

        $.ajax({
            url: baseUrl + 'proses/hitung',
            type: 'POST',
            data: payload,
            dataType: 'json',
            beforeSend: function() {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menghitung TOPSIS...');
            },
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html('<i class="ti ti-calculator me-1"></i> Proses Perhitungan TOPSIS');
                if (res.status) {
                    $('#header_status_badge').html('<span class="badge bg-success rounded-pill px-3 py-1 fs-11"><i class="ti ti-check me-1"></i>Status: Final</span>');
                    showToast('success', 'Kalkulasi TOPSIS Sukses', res.message, true);
                } else {
                    showToast('danger', 'Kalkulasi Gagal', res.message, false);
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="ti ti-calculator me-1"></i> Proses Perhitungan TOPSIS');
                showToast('danger', 'Kesalahan Server', 'Terjadi kesalahan (' + xhr.status + ') saat menghitung TOPSIS.', false);
            }
        });
    });
});
</script>
