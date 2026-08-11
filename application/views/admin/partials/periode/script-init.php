<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tablePeriode').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
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
            responsive: true
        });
    }

    // 2. Initialize Flatpickr Datepicker (Reference from forms-pickers.html)
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
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var jenis = $(this).data('jenis');
        var tahun = $(this).data('tahun');
        var mulai = $(this).data('mulai');
        var selesai = $(this).data('selesai');
        var status = $(this).data('status');
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

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-periode', function() {
        var nama = $(this).data('nama');
        var jenis = $(this).data('jenis');
        var tahun = $(this).data('tahun');
        var mulai = $(this).data('mulai');
        var selesai = $(this).data('selesai');
        var status = $(this).data('status');
        var keterangan = $(this).data('keterangan');

        $('#detail_nama_periode').text(nama);
        $('#detail_tahun_jenis').text('Jenis Siklus: ' + jenis.toUpperCase() + ' • Tahun ' + tahun);
        $('#detail_rentang_tanggal').text(mulai + ' s.d. ' + selesai);
        $('#detail_keterangan').text(keterangan ? keterangan : '-');

        if (status === 'buka') {
            $('#detail_status_badge').html('<span class="badge bg-success rounded-pill px-2 py-1 fs-10">Buka (Aktif)</span>');
        } else {
            $('#detail_status_badge').html('<span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Tutup (Selesai)</span>');
        }
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-periode', function() {
        var nama = $(this).data('nama');
        $('#delete_nama_periode').text(nama);
    });

    // 5. Submit Form Demo Handlers
    $('#formTambahPeriode').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahPeriode');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Periode penilaian baru berhasil ditambahkan.');
        this.reset();
    });

    $('#formEditPeriode').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditPeriode');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Data periode berhasil diperbarui.');
    });

    $('#btnKonfirmasiHapusPeriode').on('click', function() {
        var modalEl = document.getElementById('modalHapusPeriode');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Periode penilaian telah ditutup/dihapus.');
    });
});
</script>
