<!-- Page Script Migration Manager -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables for Migrations
    if ($.fn.DataTable) {
        $('#tableMigrations').DataTable({
            language: {
                search: "Cari Migrasi:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data migrasi",
                infoEmpty: "Tidak ada data migrasi",
                zeroRecords: "File migrasi tidak ditemukan",
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

    // 2. Run Migration Handler (UP)
    $(document).on('click', '.btn-run-migration, .btn-run-migration-all', function() {
        var table = $(this).data('table') || 'employee_data';
        var version = $(this).data('version') || 1;

        $('#confirmMigrationTitle').html('<i class="ti ti-player-play text-success me-1"></i> Jalankan Migrasi (UP)');
        $('#confirmTableName').text(table);
        $('#confirmMigrationBody').html('Apakah Anda yakin ingin mengeksekusi migrasi UP untuk membuat skema tabel <strong class="text-primary font-monospace">' + table + '</strong>?');
        
        var targetUrl = "<?= site_url('migration/execute/'); ?>" + version;
        $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-success px-4 shadow-sm');
        
        var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
        modalEl.show();
    });

    // 3. Rollback Migration Handler (DOWN)
    $(document).on('click', '.btn-rollback-migration, .btn-rollback-migration-all', function() {
        var table = $(this).data('table') || 'employee_data';

        $('#confirmMigrationTitle').html('<i class="ti ti-rotate-dot text-danger me-1"></i> Rollback Skema (DOWN)');
        $('#confirmTableName').text(table);
        $('#confirmMigrationBody').html('Apakah Anda yakin ingin membalikkan (rollback) skema tabel <strong class="text-danger font-monospace">' + table + '</strong>? Tabel dan data sampel di dalamnya akan terhapus.');
        
        var targetUrl = "<?= site_url('migration/rollback'); ?>";
        $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-danger px-4 shadow-sm');
        
        var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
        modalEl.show();
    });

    // 4. Check DB Status Handler
    $('.btn-check-db-status').on('click', function() {
        $.ajax({
            url: "<?= site_url('migration/status'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    var statusText = res.employee_table_exists 
                        ? 'Tabel employee_data TERBENTUK (' + res.employee_count + ' record).' 
                        : 'Tabel employee_data BELUM TERBENTUK.';
                    alert('Status Database MySQL: ' + statusText + ' Versi Migrasi: v' + res.current_version);
                    location.reload();
                }
            },
            error: function() {
                alert('Gagal mengecek status database.');
            }
        });
    });
});
</script>
