<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
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
            responsive: true
        });
    }

    // 2. Edit Button Handler
    $(document).on('click', '.btn-edit-penilaian', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var periode = $(this).data('periode');

        $('#edit_id_penilaian').val(id);
        $('#edit_nama_pegawai').val(nama);
        $('#edit_nama_periode').val(periode);
        $('#edit_c1').val(4.8);
        $('#edit_c2').val(95.5);
        $('#edit_c3').val(4.9);
        $('#edit_c4').val(0);
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-penilaian', function() {
        var nama = $(this).data('nama');
        var nip = $(this).data('nip');
        var kategori = $(this).data('kategori');
        var skor = $(this).data('skor');
        var peringkat = $(this).data('peringkat');
        var dplus = $(this).data('dplus');
        var dminus = $(this).data('dminus');

        $('#detail_nama_pegawai').text(nama);
        $('#detail_nip_pegawai').text('NIP. ' + nip);
        $('#detail_kategori_pegawai').text(kategori);
        $('#detail_skor_topsis').text(parseFloat(skor).toFixed(4));
        $('#detail_peringkat_badge').text('Peringkat #' + peringkat);
        $('#detail_d_plus').text(parseFloat(dplus).toFixed(4));
        $('#detail_d_minus').text(parseFloat(dminus).toFixed(4));
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-penilaian', function() {
        var nama = $(this).data('nama');
        $('#delete_nama_penilaian').text(nama);
    });

    // 5. Submit Form & Action Handlers
    $('#formTambahPenilaian').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahPenilaian');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Sesi penilaian periode baru telah dibuat dengan status DRAFT. Silakan klik Detail untuk menginput nilai alternative pegawai.');
        this.reset();
    });

    $('#formEditPenilaian').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditPenilaian');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Perubahan skor kriteria alternative berhasil diperbarui.');
    });

    $('#btnKonfirmasiHapusPenilaian').on('click', function() {
        var modalEl = document.getElementById('modalHapusPenilaian');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Sesi penilaian telah dihapus / di-reset.');
    });

    // 6. Proses Perhitungan TOPSIS (Ubah Status ke Final)
    $(document).on('click', '#btnProsesHitungTopsis', function() {
        $('#header_status_badge').html('<span class="badge bg-success rounded-pill px-3 py-1 fs-11"><i class="ti ti-check me-1"></i>Status: Final</span>');
        alert('Sukses! Perhitungan TOPSIS telah diproses secara komprehensif. Matriks normalisasi, jarak ideal D+ / D-, dan skor preferensi Vi seluruh alternative pegawai telah dikalkulasi. Status sesi penilaian kini resmi menjadi FINAL!');
    });
});
</script>
