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

    // 2. Run Single Migration Handler (UP)
    $(document).on('click', '.btn-run-migration', function() {
        var table = $(this).data('table') || 'referensi_pegawai';
        var version = $(this).data('version') || 1;

        $('#confirmMigrationTitle').html('<i class="ti ti-player-play text-success me-1"></i> Jalankan Migrasi Tabel (v' + version + ')');
        $('#confirmTableName').text(table);
        $('#confirmMigrationBody').html('Apakah Anda yakin ingin mengeksekusi migrasi UP untuk skema tabel <strong class="text-primary font-monospace">' + table + '</strong> (Versi v' + version + ')?');
        
        var targetUrl = "<?= site_url('migration/execute/'); ?>" + version;
        $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-success px-4 shadow-sm').html('<i class="ti ti-check me-1"></i> Ya, Lanjutkan');
        
        var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
        modalEl.show();
    });

    // 3. Run All Migrations Handler (UP All)
    $(document).on('click', '.btn-run-migration-all', function() {
        var latestVersion = $(this).data('latest-version') || 7;

        $('#confirmMigrationTitle').html('<i class="ti ti-player-play text-warning me-1"></i> Jalankan Semua Migrasi (v1 s.d. v' + latestVersion + ')');
        $('#confirmTableName').text('Semua Tabel Database (v1 s.d. v' + latestVersion + ')');
        $('#confirmMigrationBody').html('Apakah Anda yakin ingin mengeksekusi <strong>seluruh migrasi skema tabel database (Versi v1 s.d. v' + latestVersion + ')</strong>? Seluruh tabel database akan dibuat dan diisi data sampel awal.');

        var targetUrl = "<?= site_url('migration/execute/'); ?>" + latestVersion;
        $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-warning font-bold px-4 shadow-sm').html('<i class="ti ti-player-play me-1"></i> Ya, Jalankan Semua Migrasi');

        var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
        modalEl.show();
    });

    // 4. Rollback Single Migration Handler (DOWN)
    $(document).on('click', '.btn-rollback-migration', function() {
        var table = $(this).data('table') || 'referensi_pegawai';
        var version = $(this).data('version') || 1;
        var targetVersion = version > 1 ? (version - 1) : 0;

        $('#confirmMigrationTitle').html('<i class="ti ti-rotate-dot text-danger me-1"></i> Rollback Skema Tabel (DOWN)');
        $('#confirmTableName').text(table);
        $('#confirmMigrationBody').html('Apakah Anda yakin ingin membalikkan (rollback) skema tabel <strong class="text-danger font-monospace">' + table + '</strong> ke versi v' + targetVersion + '? Tabel ini dan data sampel di dalamnya akan terhapus.');
        
        var targetUrl = "<?= site_url('migration/rollback/'); ?>" + targetVersion;
        $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-danger px-4 shadow-sm').html('<i class="ti ti-rotate-dot me-1"></i> Ya, Rollback Tabel');
        
        var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
        modalEl.show();
    });

    // 5. Rollback All Migrations Handler (DOWN All to 0)
    $(document).on('click', '.btn-rollback-migration-all', function() {
        $('#confirmMigrationTitle').html('<i class="ti ti-rotate-dot text-danger me-1"></i> Rollback Semua Skema Tabel Database');
        $('#confirmTableName').text('Seluruh Tabel Database (Ke Versi v0)');
        $('#confirmMigrationBody').html('Apakah Anda yakin ingin membalikkan (rollback) <strong>seluruh skema tabel database ke Versi 0</strong>? Seluruh tabel dan data sampel di dalamnya akan terhapus.');

        var targetUrl = "<?= site_url('migration/rollback/0'); ?>";
        $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-danger font-bold px-4 shadow-sm').html('<i class="ti ti-rotate-dot me-1"></i> Ya, Rollback Semua Tabel');

        var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
        modalEl.show();
    });

    // 6. Check DB Status Handler
    $('.btn-check-db-status').on('click', function() {
        $.ajax({
            url: "<?= site_url('migration/status'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    var statusText = res.referensi_pegawai_table_exists 
                        ? 'Tabel referensi_pegawai TERBENTUK (' + res.referensi_pegawai_count + ' record).' 
                        : 'Tabel referensi_pegawai BELUM TERBENTUK.';
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
