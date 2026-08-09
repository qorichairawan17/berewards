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

    // 3. Detail / Pratinjau Button Handler
    $(document).on('click', '.btn-detail-laporan', function() {
        var noba = $(this).data('noba');
        var periode = $(this).data('periode');
        var pemenang = $(this).data('pemenang');
        var nip = $(this).data('nip');
        var kategori = $(this).data('kategori');
        var skor = $(this).data('skor');
        var tanggal = $(this).data('tanggal');
        var ketua = $(this).data('ketua');

        $('#preview_no_ba').text('Nomor: ' + noba);
        $('#preview_periode').text(periode);
        $('#preview_pemenang_nama').text(pemenang);
        $('#preview_pemenang_nip').text('NIP. ' + nip);
        $('#preview_kategori').text(kategori);
        $('#preview_skor').text(parseFloat(skor).toFixed(4));
        $('#preview_tanggal_terbit').text(tanggal);
        $('#preview_ketua').text(ketua);
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-laporan', function() {
        var noba = $(this).data('noba');
        $('#delete_no_ba').text(noba);
    });

    // 5. Simulated Actions
    $(document).on('click', '.btn-export-word, #btnDownloadWordSimulasi', function() {
        alert('Mengunduh Dokumen Berita Acara (.docx)... File siap dicetak dan ditandatangani.');
    });

    $('#formTambahLaporan').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahLaporan');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Dokumen Berita Acara Penetapan TOPSIS berhasil diterbitkan.');
        this.reset();
    });

    $('#formEditLaporan').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditLaporan');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Data Berita Acara berhasil diperbarui.');
    });

    $('#btnKonfirmasiHapusLaporan').on('click', function() {
        var modalEl = document.getElementById('modalHapusLaporan');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Dokumen Berita Acara telah dipindahkan ke Arsip.');
    });
});
</script>
