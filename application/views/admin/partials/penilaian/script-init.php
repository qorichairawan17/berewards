<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tablePenilaian').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data penilaian tidak ditemukan",
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
    $('#btnHitungTopsisSimulasi').on('click', function() {
        alert('Kalkulasi TOPSIS Berhasil! Matriks normalisasi dan skor preferensi V_i seluruh kandidat telah diperbarui.');
    });

    $('#formTambahPenilaian').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahPenilaian');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Nilai kriteria berhasil disimpan dan matriks TOPSIS dikalkulasi ulang.');
        this.reset();
    });

    $('#formEditPenilaian').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditPenilaian');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Perubahan skor berhasil diperbarui.');
    });

    $('#btnKonfirmasiHapusPenilaian').on('click', function() {
        var modalEl = document.getElementById('modalHapusPenilaian');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Data penilaian telah dihapus.');
    });
});
</script>
