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

    // 2. Detail Button Handler
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
});
</script>
