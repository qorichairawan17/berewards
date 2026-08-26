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

    // 4. Handle SK Change in Modal Add & Modal Edit
    $('#add_id_sk').on('change', function() {
        var selected = $(this).find('option:selected');
        var ketua = selected.data('ketua');
        if (ketua) {
            $('#add_ketua_panitia').val(ketua);
        }
    });

    $('#edit_id_sk').on('change', function() {
        var selected = $(this).find('option:selected');
        var ketua = selected.data('ketua');
        if (ketua) {
            $('#edit_ketua_panitia').val(ketua);
        }
    });

    $('#modalTambahLaporan').on('show.bs.modal', function() {
        var selected = $('#add_id_sk').find('option:selected');
        var ketua = selected.data('ketua');
        if (ketua && !$('#add_ketua_panitia').val()) {
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
        var id      = $(this).data('id');
        var noba    = $(this).data('noba');
        var status  = $(this).data('status');
        var tanggal = $(this).data('tanggal');
        var id_sk   = $(this).data('id_sk');
        var ketua   = $(this).data('ketua');

        $('#edit_id_laporan').val(id);
        $('#edit_no_ba').val(noba);
        $('#edit_status').val(status);

        if (id_sk) {
            $('#edit_id_sk').val(id_sk);
        } else {
            $('#edit_id_sk').val('');
        }

        if (ketua) {
            $('#edit_ketua_panitia').val(ketua);
        } else if (id_sk) {
            var optKetua = $('#edit_id_sk option[value="' + id_sk + '"]').data('ketua');
            if (optKetua) {
                $('#edit_ketua_panitia').val(optKetua);
            }
        }

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

    // 11. Showroom TOPSIS Modal Engine & Interactive Carousel
    var showroomCurrentCandidates = [];
    var showroomCurrentIndex = 0;
    var baseUrl = '<?= base_url(); ?>';

    function renderShowroomDetail(idx) {
        if (!showroomCurrentCandidates || !showroomCurrentCandidates.length || !showroomCurrentCandidates[idx]) {
            return;
        }

        showroomCurrentIndex = idx;
        var cand = showroomCurrentCandidates[idx];

        // Update Slide Indicator
        $('#showroom_slide_indicator').text((idx + 1) + ' / ' + showroomCurrentCandidates.length);

        // Update Active Card Styling
        $('.showroom-card-item').each(function(i) {
            if (i === idx) {
                $(this).addClass('active-card bg-white shadow-lg').removeClass('bg-light opacity-75');
            } else {
                $(this).removeClass('active-card bg-white shadow-lg').addClass('bg-light opacity-75');
            }
        });

        // Update Left Profile
        var defaultLogo = baseUrl + 'assets/icons/logo.png';
        var photoUrl = cand.foto ? (cand.foto.indexOf('http') === 0 ? cand.foto : baseUrl + cand.foto) : defaultLogo;
        $('#showroom_detail_photo').attr('src', photoUrl).attr('onerror', "this.onerror=null;this.src='" + defaultLogo + "';");
        $('#showroom_detail_nama').text(cand.nama || '-');
        $('#showroom_detail_nip').text('NIP. ' + (cand.nip || '-'));
        $('#showroom_detail_kategori').text(cand.kategori || '-');

        // Update Scores & Distances
        $('#showroom_detail_vi').text(parseFloat(cand.skor || 0).toFixed(4));
        $('#showroom_detail_dplus').text(parseFloat(cand.dplus || 0).toFixed(4));
        $('#showroom_detail_dminus').text(parseFloat(cand.dminus || 0).toFixed(4));

        // Update Rank Badge Label
        var rank = parseInt(cand.rank) || (idx + 1);
        if (rank === 1) {
            $('#showroom_detail_rank_label').text('Rank #1 (Penerima Reward Utama)').removeClass('text-info text-muted').addClass('text-success');
        } else if (rank === 2) {
            $('#showroom_detail_rank_label').text('Rank #2 (Runner Up 1)').removeClass('text-success text-muted').addClass('text-info');
        } else {
            $('#showroom_detail_rank_label').text('Rank #3 (Runner Up 2)').removeClass('text-success text-info').addClass('text-muted');
        }

        // Update Progress Bar & Criteria Labels
        var progressHtml = '';
        var labelsHtml = '';

        if (cand.kriteria_scores && cand.kriteria_scores.length > 0) {
            cand.kriteria_scores.forEach(function(k) {
                var percent = k.percent || (100 / cand.kriteria_scores.length);
                var colorClass = k.color || 'bg-primary';
                var kode = k.kode || 'C';
                var nama = k.nama || 'Kriteria';
                var val = parseFloat(k.nilai || 0).toFixed(2);

                progressHtml += '<div class="progress" role="progressbar" style="width: ' + percent + '%" aria-label="' + kode + '" aria-valuenow="' + percent + '" aria-valuemin="0" aria-valuemax="100">' +
                    '<div class="progress-bar ' + colorClass + '" title="' + kode + ': ' + nama + ' (' + val + ')">' + kode + '</div>' +
                    '</div>';

                labelsHtml += '<span><i class="ti ti-circle-filled fs-9 me-1 ' + colorClass.replace('bg-', 'text-') + '"></i>' +
                    '<strong>' + kode + '</strong> ' + nama + ': <strong class="text-dark">' + val + '</strong></span>';
            });
        } else {
            progressHtml = '<div class="progress" role="progressbar" style="width: 100%"><div class="progress-bar bg-primary">Skor TOPSIS: ' + parseFloat(cand.skor || 0).toFixed(4) + '</div></div>';
            labelsHtml = '<span class="text-muted">Rincian evaluasi kriteria diproses dari matriks keputusan ternormalisasi.</span>';
        }

        $('#showroom_progress_stacked').html(progressHtml);
        $('#showroom_criteria_labels').html(labelsHtml);
    }

    function loadShowroomModal(targetId) {
        if (!targetId) {
            targetId = $('#select_showroom_periode').val();
        }

        if (!targetId) {
            showToast('warning', 'Peringatan', 'Silakan pilih sesi penilaian TOPSIS terlebih dahulu.');
            return;
        }

        showToast('info', 'Memuat Showroom', 'Sedang mengambil data kalkulasi SPK TOPSIS...');

        $.ajax({
            url: '<?= site_url("laporan/showroom_data/"); ?>' + encodeURIComponent(targetId),
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (!res || !res.status) {
                    showToast('danger', 'Gagal', (res && res.message) ? res.message : 'Gagal memuat data showroom TOPSIS.');
                    return;
                }

                var data = res;
                showroomCurrentCandidates = data.candidates || [];
                showroomCurrentIndex = 0;

                // Close Select Modal if open
                var selectModalEl = document.getElementById('modalSelectPreviewPeriode');
                if (selectModalEl) {
                    var selectModal = bootstrap.Modal.getInstance(selectModalEl);
                    if (selectModal) selectModal.hide();
                }

                // Update Header Titles
                $('#showroom_periode_title').text(data.nama_periode + ' — Kategori ' + data.kategori);
                $('#showroom_main_title').text('Pratinjau Kandidat Reward Kategori ' + data.kategori);
                $('#btnShowroomFullPage').attr('href', '<?= site_url("laporan/preview/"); ?>' + (data.id_laporan ? data.id_laporan : 'proses_' + data.id_proses));

                // Render Top Candidate Cards
                var defaultLogo = baseUrl + 'assets/icons/logo.png';
                var cardsHtml = '';
                if (showroomCurrentCandidates.length > 0) {
                    showroomCurrentCandidates.forEach(function(cand, idx) {
                        var rank = parseInt(cand.rank) || (idx + 1);
                        var isFirst = (idx === 0);
                        var trophyIcon = (rank === 1) 
                            ? '<i class="ti ti-trophy text-warning fs-28 rank-trophy-badge"></i>' 
                            : ((rank === 2) ? '<i class="ti ti-medal text-secondary fs-28"></i>' : '<i class="ti ti-award text-amber fs-28"></i>');

                        var cardPhoto = cand.foto ? (cand.foto.indexOf('http') === 0 ? cand.foto : baseUrl + cand.foto) : defaultLogo;
                        var activeClass = isFirst ? 'active-card bg-white shadow-lg' : 'bg-light opacity-75';

                        cardsHtml += '<div class="col-md-4">' +
                            '<div class="card showroom-card-item h-100 rounded-3 p-4 ' + activeClass + '" data-index="' + idx + '">' +
                            '<div class="d-flex align-items-center justify-content-between mb-3">' +
                            '<span class="badge bg-dark text-white px-2 py-1 fs-11">PERINGKAT #' + rank + '</span>' +
                            trophyIcon +
                            '</div>' +
                            '<div class="text-center mb-3">' +
                            '<img src="' + cardPhoto + '" alt="' + (cand.nama || 'Foto') + '" class="rounded-circle border border-3 border-primary mb-2 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;" onerror="this.onerror=null;this.src=\'' + defaultLogo + '\';">' +
                            '<h5 class="fw-bold text-dark mb-1 fs-14">' + (cand.nama || '-') + '</h5>' +
                            '<small class="text-muted fs-11 d-block">NIP. ' + (cand.nip || '-') + '</small>' +
                            '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 mt-2">' + (cand.kategori || data.kategori) + '</span>' +
                            '</div>' +
                            '<div class="p-3 bg-light rounded text-center border">' +
                            '<small class="text-muted fs-11 d-block mb-1">Skor Preferensi Akhir ($V_i$)</small>' +
                            '<h4 class="fw-bold text-primary mb-0">' + parseFloat(cand.skor || 0).toFixed(4) + '</h4>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    });
                } else {
                    cardsHtml = '<div class="col-12 text-center py-4 text-muted"><i class="ti ti-alert-circle fs-32 mb-2 d-block"></i>Tidak ada kandidat hasil perankingan pada sesi ini.</div>';
                }

                $('#showroom_cards_container').html(cardsHtml);

                // Initialize first candidate detail
                if (showroomCurrentCandidates.length > 0) {
                    renderShowroomDetail(0);
                }

                // Show Showroom Modal
                var showroomModalEl = document.getElementById('modalShowroomKandidat');
                if (showroomModalEl) {
                    var showroomModal = bootstrap.Modal.getOrCreateInstance(showroomModalEl);
                    showroomModal.show();
                }
            },
            error: function() {
                showToast('danger', 'Error', 'Gagal menghubungi server untuk memuat data showroom.');
            }
        });
    }

    // Card Click Event Handler
    $(document).on('click', '.showroom-card-item', function() {
        var idx = parseInt($(this).data('index'));
        if (!isNaN(idx)) {
            renderShowroomDetail(idx);
        }
    });

    // Prev / Next Navigation Buttons
    $('#btnPrevShowroomCard').on('click', function() {
        if (showroomCurrentCandidates.length > 0) {
            var newIdx = (showroomCurrentIndex - 1 + showroomCurrentCandidates.length) % showroomCurrentCandidates.length;
            renderShowroomDetail(newIdx);
        }
    });

    $('#btnNextShowroomCard').on('click', function() {
        if (showroomCurrentCandidates.length > 0) {
            var newIdx = (showroomCurrentIndex + 1) % showroomCurrentCandidates.length;
            renderShowroomDetail(newIdx);
        }
    });

    // Launch Modal Showroom from Select Modal
    $('#btnLaunchModalShowroom').on('click', function() {
        var selectedVal = $('#select_showroom_periode').val();
        loadShowroomModal(selectedVal);
    });

    // Launch Modal Showroom from Table Action Button
    $(document).on('click', '.btn-trigger-showroom', function() {
        var target = $(this).data('target');
        if (target) {
            loadShowroomModal(target);
        }
    });

    // Form Submit (Full Page Showroom)
    $('#formPilihPeriodeShowroom').on('submit', function(e) {
        e.preventDefault();
        var id = $('#select_showroom_periode').val();
        if (id) {
            window.location.href = '<?= site_url("laporan/preview/"); ?>' + encodeURIComponent(id);
        }
    });
});
</script>
