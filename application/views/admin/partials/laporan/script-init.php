<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
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
            responsive: true
        });
    }

    // 2. Edit Button Handler
    $(document).on('click', '.btn-edit-laporan', function() {
        var id = $(this).data('id');
        var noba = $(this).data('noba');
        var status = $(this).data('status');
        var tanggal = $(this).data('tanggal');
        var ketua = $(this).data('ketua');

        $('#edit_id_laporan').val(id);
        $('#edit_no_ba').val(noba);
        $('#edit_status').val(status);
        $('#edit_tanggal_terbit').val(tanggal);
        $('#edit_ketua_panitia').val(ketua);
    });

    // 3. Detail / Pratinjau Button Handler with 3 Best Candidates Table
    $(document).on('click', '.btn-detail-laporan', function() {
        var noba = $(this).data('noba');
        var periode = $(this).data('periode');
        var kategori = $(this).data('kategori');
        var tanggal = $(this).data('tanggal');
        var ketua = $(this).data('ketua');
        var top3Data = $(this).data('top3');

        $('#preview_no_ba').text('Nomor: ' + noba);
        $('#preview_periode').text(periode);
        $('#preview_kategori').text(kategori);
        $('#preview_tanggal_terbit').text(tanggal);
        $('#preview_ketua').text(ketua);

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
                    '<td><strong class="d-block text-dark">' + item.nama + '</strong><small class="text-muted fs-11">NIP. ' + item.nip + '</small></td>' +
                    '<td><span class="badge bg-light text-dark border px-2 py-1">' + item.kategori + '</span></td>' +
                    '<td class="text-center"><strong class="text-primary fs-13">V = ' + parseFloat(item.skor).toFixed(4) + '</strong></td>' +
                    '<td class="text-center">' + ketBadge + '</td>' +
                    '</tr>';
            });
        } else {
            tbodyHtml = '<tr><td colspan="5" class="text-center text-muted">Data kandidat terbaik tidak ditemukan.</td></tr>';
        }

        $('#preview_top3_tbody').html(tbodyHtml);
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-laporan', function() {
        var noba = $(this).data('noba');
        $('#delete_no_ba').text(noba);
    });

    // 5. Submit Form Demo Feedback
    $('#formTambahLaporan').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahLaporan');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Berita Acara penetapan reward baru berhasil diterbitkan.');
        this.reset();
    });

    $('#formEditLaporan').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditLaporan');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Perubahan Berita Acara berhasil disimpan.');
    });

    $('#btnKonfirmasiHapusLaporan').on('click', function() {
        var modalEl = document.getElementById('modalHapusLaporan');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Berita Acara telah diarsipkan.');
    });

    // 6. Export Word — navigasi ke laporan/export/{id} untuk mengunduh .docx
    $(document).on('click', '.btn-export-word', function() {
        var id = $(this).data('id');
        if (!id) {
            alert('ID laporan tidak ditemukan. Coba muat ulang halaman.');
            return;
        }
        var url = '<?= site_url("laporan/export/"); ?>' + id;
        // Buka di tab saat ini — browser akan langsung trigger unduhan karena
        // response header Content-Disposition: attachment
        window.location.href = url;
    });

    // Export Word dari modal detail pratinjau
    $(document).on('click', '#btnDownloadWordSimulasi', function() {
        var id = $(this).data('id');
        if (!id) {
            alert('ID laporan tidak tersedia. Tutup dan buka ulang pratinjau.');
            return;
        }
        var url = '<?= site_url("laporan/export/"); ?>' + id;
        window.location.href = url;
    });


    // 7. Select Period Form Handler -> Redirect to Separate Preview Page
    $('#formPilihPeriodeShowroom').on('submit', function(e) {
        e.preventDefault();
        var id = $('#select_showroom_periode').val();
        window.location.href = '<?= site_url("laporan/preview/"); ?>' + id;
    });
});
</script>
