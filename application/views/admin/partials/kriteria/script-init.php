<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tableKriteria').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
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
            responsive: true
        });
    }

    // 2. Edit Button Handler
    $(document).on('click', '.btn-edit-kriteria', function() {
        var id = $(this).data('id');
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var kategori = $(this).data('kategori');
        var bobot = $(this).data('bobot');
        var jenis = $(this).data('jenis');
        var tipe = $(this).data('tipe');

        $('#edit_id_kriteria').val(id);
        $('#edit_kode').val(kode);
        $('#edit_nama_kriteria').val(nama);
        $('#edit_kategori').val(kategori);
        $('#edit_bobot').val(bobot);
        $('#edit_jenis_data').val(jenis);
        $('#edit_tipe_atribut').val(tipe);
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-kriteria', function() {
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var kategori = $(this).data('kategori');
        var bobot = $(this).data('bobot');
        var jenis = $(this).data('jenis');
        var tipe = $(this).data('tipe');

        $('#detail_kode_badge').text(kode);
        $('#detail_nama_kriteria').text(nama);
        $('#detail_kategori_pegawai').text('Kategori: ' + kategori);
        $('#detail_bobot').text(bobot + '%');
        $('#detail_jenis_data').text(jenis);

        if (tipe === 'benefit') {
            $('#detail_tipe_atribut_badge').html('<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-11">Benefit</span>');
        } else {
            $('#detail_tipe_atribut_badge').html('<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11">Cost</span>');
        }
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-kriteria', function() {
        var nama = $(this).data('nama');
        $('#delete_nama_kriteria').text(nama);
    });

    // 5. Form Submit Demo Handlers
    $('#formTambahKriteria').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahKriteria');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Kriteria penilaian baru berhasil ditambahkan.');
        this.reset();
    });

    $('#formEditKriteria').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditKriteria');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Data kriteria berhasil diperbarui.');
    });

    $('#btnKonfirmasiHapusKriteria').on('click', function() {
        var modalEl = document.getElementById('modalHapusKriteria');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Kriteria telah nonaktif dari referensi.');
    });
});
</script>
