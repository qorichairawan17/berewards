<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tablePegawai').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
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
    $(document).on('click', '.btn-edit-pegawai', function() {
        var id = $(this).data('id');
        var nip = $(this).data('nip');
        var nama = $(this).data('nama');
        var pangkat = $(this).data('pangkat');
        var golongan = $(this).data('golongan');
        var jabatan = $(this).data('jabatan');
        var kategori = $(this).data('kategori');

        $('#edit_id').val(id);
        $('#edit_nip').val(nip);
        $('#edit_nama').val(nama);
        $('#edit_pangkat').val(pangkat);
        $('#edit_golongan').val(golongan);
        $('#edit_jabatan').val(jabatan);
        $('#edit_kategori').val(kategori);
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-pegawai', function() {
        var nip = $(this).data('nip');
        var nama = $(this).data('nama');
        var pangkat = $(this).data('pangkat');
        var golongan = $(this).data('golongan');
        var jabatan = $(this).data('jabatan');
        var kategori = $(this).data('kategori');

        $('#detail_nama').text(nama);
        $('#detail_nip').text('NIP. ' + nip);
        $('#detail_kategori').text(kategori);
        $('#detail_pangkat_gol').text(pangkat + ' (' + golongan + ')');
        $('#detail_jabatan').text(jabatan);
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-pegawai', function() {
        var nama = $(this).data('nama');
        $('#delete_nama_pegawai').text(nama);
    });

    // 5. Submit Form Demo Feedback
    $('#formTambahPegawai').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahPegawai');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Data pegawai baru berhasil ditambahkan.');
        this.reset();
    });

    $('#formEditPegawai').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditPegawai');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Data pegawai berhasil diperbarui.');
    });

    $('#btnKonfirmasiHapus').on('click', function() {
        var modalEl = document.getElementById('modalHapusPegawai');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Data pegawai telah dinonaktifkan.');
    });
});
</script>
