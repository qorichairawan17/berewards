<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tableAudit').DataTable({
            language: {
                search: "Cari Log:",
                lengthMenu: "Tampilkan _MENU_ log",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ log audit",
                infoEmpty: "Tidak ada log audit",
                zeroRecords: "Entri log audit tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[0, 'desc']]
        });
    }

    // 2. Edit Button Handler
    $(document).on('click', '.btn-edit-audit', function() {
        var id = $(this).data('id');
        var username = $(this).data('username');
        var timestamp = $(this).data('timestamp');
        var modul = $(this).data('modul');
        var aktivitas = $(this).data('aktivitas');
        var status = $(this).data('status');

        $('#edit_id_audit').val(id);
        $('#edit_username').val(username);
        $('#edit_timestamp').val(timestamp);
        $('#edit_modul').val(modul);
        $('#edit_aktivitas').val(aktivitas);
        $('#edit_status').val(status);
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-audit', function() {
        var timestamp = $(this).data('timestamp');
        var nama = $(this).data('nama');
        var username = $(this).data('username');
        var role = $(this).data('role');
        var modul = $(this).data('modul');
        var aktivitas = $(this).data('aktivitas');
        var ip = $(this).data('ip');
        var status = $(this).data('status');

        $('#detail_timestamp').text(timestamp);
        $('#detail_user').text(nama + ' (@' + username + ' - ' + role + ')');
        $('#detail_ip').text(ip);
        $('#detail_modul').text(modul);
        $('#detail_aktivitas').text(aktivitas);

        if (status === 'Sukses') {
            $('#detail_status_badge').html('<span class="badge bg-success rounded-pill px-2 py-1 fs-10"><i class="ti ti-check me-1"></i>Sukses</span>');
        } else {
            $('#detail_status_badge').html('<span class="badge bg-danger rounded-pill px-2 py-1 fs-10"><i class="ti ti-x me-1"></i>Gagal</span>');
        }
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-audit', function() {
        var aktivitas = $(this).data('aktivitas');
        $('#delete_aktivitas_text').text(aktivitas);
    });

    // 5. Submit Form Demo Feedback
    $('#formTambahAudit').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahAudit');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Entri log audit manual berhasil dicatat ke dalam database.');
        this.reset();
    });

    $('#formEditAudit').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditAudit');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Catatan log audit berhasil diperbarui.');
    });

    $('#btnKonfirmasiHapusAudit').on('click', function() {
        var modalEl = document.getElementById('modalHapusAudit');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Entri log audit telah diarsipkan.');
    });
});
</script>
