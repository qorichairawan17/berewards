<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Database Migration Manager | BeRewards SPK TOPSIS</title>

    <!-- App Favicon Icons -->
    <link rel="shortcut icon" href="<?= base_url('assets/icons/favicon.ico'); ?>" type="image/x-icon" />
    <link rel="icon" href="<?= base_url('assets/icons/favicon-32x32.png'); ?>" sizes="32x32" type="image/png" />
    <link rel="icon" href="<?= base_url('assets/icons/favicon-16x16.png'); ?>" sizes="16x16" type="image/png" />
    <link rel="apple-touch-icon" href="<?= base_url('assets/icons/apple-icon-180x180.png'); ?>" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Theme & Icons CSS -->
    <link href="<?= base_url('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/spk-reward.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- DataTables CSS -->
    <link href="<?= base_url('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            min-height: 100vh;
        }

        .standalone-navbar {
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
        }

        .clean-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg standalone-navbar py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url('migration'); ?>">
                <img src="<?= base_url('assets/icons/logo.png'); ?>" alt="BeRewards Logo" height="32" class="d-inline-block align-text-top">
                <div>
                    <strong class="d-block text-dark fs-15 leading-tight">BeRewards — Migration Manager</strong>
                    <small class="text-muted fs-11">Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court With TOPSIS
                        Method.</small>
                </div>
            </a>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <a href="<?= site_url('signin'); ?>" class="btn btn-outline-primary btn-sm fw-semibold px-3">
                    <i class="ti ti-login me-1"></i> Ke Halaman Login
                </a>
                <a href="<?= site_url('dashboard'); ?>" class="btn btn-primary btn-sm fw-semibold px-3">
                    <i class="ti ti-layout-dashboard me-1"></i> Dashboard Utama
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="container-fluid px-4 py-4" style="max-width: 1300px;">
        <!-- Header Hero Banner -->
        <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden"
            style="background: linear-gradient(135deg, #0A2540 0%, #0052CC 40%, #108DFF 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-warning text-dark font-bold px-2.5 py-1 fs-11 text-uppercase tracking-wider">
                                <i class="ti ti-database me-1"></i> Database Migration Manager
                            </span>
                            <span class="badge bg-primary bg-opacity-20 text-white px-2 py-1 fs-11">
                                Standalone Migration Engine
                            </span>
                        </div>
                        <h3 class="fw-bold text-white mb-1 fs-22">Manajemen Skema & Migrasi Tabel Database</h3>
                        <p class="text-white text-opacity-80 fs-13 mb-0">
                            Halaman independen pengelola migrasi struktur tabel database SPK Reward TOPSIS. Eksekusi pembuatan skema (UP) dan
                            pembalikan struktur tabel (DOWN Rollback) dapat dijalankan tanpa login dashboard.
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-warning font-bold shadow-sm px-3 py-2 btn-run-migration-all" data-latest-version="<?= isset($latest_version) ? $latest_version : 7; ?>">
                            <i class="ti ti-player-play me-1"></i> Jalankan Semua Migrasi
                        </button>
                        <button type="button" class="btn btn-outline-light font-semibold px-3 py-2 btn-rollback-migration-all">
                            <i class="ti ti-rotate-dot me-1"></i> Rollback Versi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 KPI Summary Cards -->
        <section class="row g-3 mb-4" aria-label="Statistik Migrasi Database">
            <div class="col-md-6 col-xl-3">
                <div class="card clean-card h-100">
                    <div class="card-body p-3.5 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-primary-subtle text-primary p-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px;">
                            <i class="ti ti-file-code fs-22"></i>
                        </div>
                        <div>
                            <span class="text-muted fs-11 d-block mb-0">Total Berkas Migrasi</span>
                            <h4 class="fw-bold mb-0 text-dark"><?= count($migration_files); ?> <span class="fs-11 text-muted fw-normal">File</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card clean-card h-100">
                    <div class="card-body p-3.5 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-info-subtle text-info p-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px;">
                            <i class="ti ti-versions fs-22"></i>
                        </div>
                        <div>
                            <span class="text-muted fs-11 d-block mb-0">Versi Skema Aktif</span>
                            <h4 class="fw-bold mb-0 text-dark">v<?= $current_version; ?> <span class="fs-11 text-muted fw-normal">Current</span></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card clean-card h-100">
                    <div class="card-body p-3.5 d-flex align-items-center gap-3">
                        <div class="rounded-3 <?= $referensi_pegawai_table_exists ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?> p-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px;">
                            <i class="ti <?= $referensi_pegawai_table_exists ? 'ti-table-check' : 'ti-table-off'; ?> fs-22"></i>
                        </div>
                        <div>
                            <span class="text-muted fs-11 d-block mb-0">Tabel referensi_pegawai</span>
                            <h4 class="fw-bold mb-0 text-dark">
                                <?php if ($referensi_pegawai_table_exists): ?>
                                    <span class="badge bg-success rounded-pill px-2.5 py-1 fs-11">Terbentuk (<?= $referensi_pegawai_count; ?> Record)</span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-2.5 py-1 fs-11">Belum Terbentuk</span>
                                <?php endif; ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card clean-card h-100">
                    <div class="card-body p-3.5 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-secondary-subtle text-secondary p-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px;">
                            <i class="ti ti-database fs-22"></i>
                        </div>
                        <div>
                            <span class="text-muted fs-11 d-block mb-0">Database Driver</span>
                            <h4 class="fw-bold mb-0 text-dark"><?= strtoupper(html_escape($db_driver)); ?> <span
                                    class="fs-11 text-muted fw-normal">(<?= html_escape($db_name); ?>)</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Migration Files Data Table -->
        <section class="card clean-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Pengelola Skema Standalone</span>
                        <h4 class="fw-bold text-dark mb-0">Daftar Berkas Migrasi Skema Database</h4>
                    </div>
                    <button type="button" class="btn btn-sm btn-subtle-info fw-semibold px-3 btn-check-db-status">
                        <i class="ti ti-refresh me-1"></i> Cek Status Terkini MySQL
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="tableMigrations" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama File Migrasi</th>
                                <th>Target Tabel Database</th>
                                <th>Deskripsi Skema</th>
                                <th>Status Eksekusi</th>
                                <th style="width: 220px;" class="text-center">Aksi Migrasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($migration_files)): ?>
                                <?php $no = 1;
                                foreach ($migration_files as $row): ?>
                                    <?php
                                    $is_table_exist = ($row['target_table'] === 'referensi_pegawai') ? $referensi_pegawai_table_exists : (($row['target_table'] === 'pengaturan') ? $pengaturan_table_exists : (($row['target_table'] === 'pengguna') ? (isset($pengguna_table_exists) && $pengguna_table_exists) : (($row['target_table'] === 'tim_penilai_sk') ? (isset($tim_penilai_table_exists) && $tim_penilai_table_exists) : (($row['target_table'] === 'kriteria') ? (isset($kriteria_table_exists) && $kriteria_table_exists) : (($row['target_table'] === 'periode') ? (isset($periode_table_exists) && $periode_table_exists) : (($row['target_table'] === 'topsis_proses') ? (isset($topsis_proses_table_exists) && $topsis_proses_table_exists) : (($row['target_table'] === 'laporan_ba') ? (isset($laporan_ba_table_exists) && $laporan_ba_table_exists) : (($row['target_table'] === 'audit_trail') ? (isset($audit_trail_table_exists) && $audit_trail_table_exists) : FALSE))))))));
                                    $is_executed = ($current_version >= $row['version'] && $is_table_exist);
                                    $preview_url = ($row['target_table'] === 'pengaturan') ? site_url('setting') : (($row['target_table'] === 'pengguna') ? site_url('user') : (($row['target_table'] === 'tim_penilai_sk') ? site_url('timpenilai') : (($row['target_table'] === 'kriteria') ? site_url('kriteria') : (($row['target_table'] === 'periode') ? site_url('periode') : (($row['target_table'] === 'topsis_proses') ? site_url('proses') : (($row['target_table'] === 'laporan_ba') ? site_url('laporan') : (($row['target_table'] === 'audit_trail') ? site_url('audit') : site_url('pegawai'))))))));
                                    ?>
                                    <tr>
                                        <td class="text-center fw-semibold"><?= $no++; ?></td>
                                        <td>
                                            <strong class="d-block text-dark font-monospace fs-13"><?= html_escape($row['file_name']); ?></strong>
                                            <small class="text-muted fs-11">Class: <?= html_escape($row['class_name']); ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 font-monospace fs-12">
                                                <i class="ti ti-table me-1"></i><?= html_escape($row['target_table']); ?>
                                            </span>
                                        </td>
                                        <td class="fs-12 text-muted" style="white-space: normal; min-width: 260px;">
                                            <?= html_escape($row['description']); ?>
                                        </td>
                                        <td>
                                            <?php if ($is_executed): ?>
                                                <span class="badge bg-success rounded-pill px-2.5 py-1 fs-11">
                                                    <i class="ti ti-circle-check me-1"></i>Terbentuk (v<?= $row['version']; ?>)
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary rounded-pill px-2.5 py-1 fs-11">
                                                    <i class="ti ti-clock me-1"></i>Belum Dieksekusi
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <?php if (!$is_executed): ?>
                                                    <button type="button" class="btn btn-sm btn-success fw-semibold btn-run-migration p-1.5 px-3"
                                                        data-version="<?= $row['version']; ?>" data-filename="<?= html_escape($row['file_name']); ?>"
                                                        data-table="<?= html_escape($row['target_table']); ?>"
                                                        title="Jalankan Migrasi (UP) untuk membuat tabel <?= html_escape($row['target_table']); ?>">
                                                        <i class="ti ti-player-play me-1"></i> Jalankan UP
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger fw-semibold btn-rollback-migration p-1.5 px-3"
                                                        data-filename="<?= html_escape($row['file_name']); ?>"
                                                        data-table="<?= html_escape($row['target_table']); ?>"
                                                        title="Rollback (DOWN) untuk menghapus tabel <?= html_escape($row['target_table']); ?>">
                                                        <i class="ti ti-rotate-dot me-1"></i> Rollback DOWN
                                                    </button>
                                                <?php endif; ?>
                                                <a href="<?= $preview_url; ?>" class="btn btn-sm btn-subtle-info p-1.5 px-2"
                                                    title="Lihat Tampilan <?= html_escape($row['target_table']); ?>">
                                                    <i class="ti ti-eye fs-15"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <div class="text-center text-muted fs-12 mt-4">
            &copy; <?= date('Y'); ?> <strong>Made By Qori Chairawan</strong> — Determining the Rewards for Judges and Employees of the Lubuk
            Pakam District Court With TOPSIS Method.
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="modalConfirmMigration" tabindex="-1" aria-labelledby="modalConfirmMigrationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom bg-light">
                    <h5 class="modal-title fw-bold text-dark" id="modalConfirmMigrationLabel">
                        <i class="ti ti-database text-primary me-2"></i>Konfirmasi Eksekusi Migrasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="p-3 bg-light rounded-circle text-primary mx-auto mb-3"
                        style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                        <i class="ti ti-alert-triangle fs-32"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" id="confirmMigrationTitle">Jalankan Migrasi Skema Tabel?</h5>
                    <p class="text-muted fs-13 mb-3" id="confirmMigrationBody">
                        Apakah Anda yakin ingin memproses eksekusi migrasi skema tabel <strong id="confirmTableName"
                            class="text-primary font-monospace">employee_data</strong>?
                    </p>
                    <div class="p-2.5 bg-warning-subtle text-warning border border-warning-subtle rounded text-start fs-12 mb-0">
                        <i class="ti ti-info-circle me-1"></i> Tindakan rollback akan menghapus tabel <span
                            class="font-monospace fw-bold">employee_data</span> beserta seluruh data sampel di dalamnya.
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-top justify-content-center">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="btnExecuteMigrationAction" class="btn btn-brand px-4 shadow-sm">
                        <i class="ti ti-check me-1"></i> Ya, Lanjutkan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Scripts -->
    <script src="<?= base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'); ?>"></script>

    <!-- Page Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

            // 2. Run Single Migration (UP)
            $(document).on('click', '.btn-run-migration', function () {
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

            // 3. Run All Migrations (UP All)
            $(document).on('click', '.btn-run-migration-all', function () {
                var latestVersion = $(this).data('latest-version') || 7;

                $('#confirmMigrationTitle').html('<i class="ti ti-player-play text-warning me-1"></i> Jalankan Semua Migrasi (v1 s.d. v' + latestVersion + ')');
                $('#confirmTableName').text('Semua Tabel Database (v1 s.d. v' + latestVersion + ')');
                $('#confirmMigrationBody').html('Apakah Anda yakin ingin mengeksekusi <strong>seluruh migrasi skema tabel database (Versi v1 s.d. v' + latestVersion + ')</strong>? Seluruh tabel database akan dibuat dan diisi data sampel awal.');

                var targetUrl = "<?= site_url('migration/execute/'); ?>" + latestVersion;
                $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-warning font-bold px-4 shadow-sm').html('<i class="ti ti-player-play me-1"></i> Ya, Jalankan Semua Migrasi');

                var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
                modalEl.show();
            });

            // 4. Rollback Single Migration (DOWN)
            $(document).on('click', '.btn-rollback-migration', function () {
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

            // 5. Rollback All Migrations (DOWN All to 0)
            $(document).on('click', '.btn-rollback-migration-all', function () {
                $('#confirmMigrationTitle').html('<i class="ti ti-rotate-dot text-danger me-1"></i> Rollback Semua Skema Tabel Database');
                $('#confirmTableName').text('Seluruh Tabel Database (Ke Versi v0)');
                $('#confirmMigrationBody').html('Apakah Anda yakin ingin membalikkan (rollback) <strong>seluruh skema tabel database ke Versi 0</strong>? Seluruh tabel dan data sampel di dalamnya akan terhapus.');

                var targetUrl = "<?= site_url('migration/rollback/0'); ?>";
                $('#btnExecuteMigrationAction').attr('href', targetUrl).attr('class', 'btn btn-danger font-bold px-4 shadow-sm').html('<i class="ti ti-rotate-dot me-1"></i> Ya, Rollback Semua Tabel');

                var modalEl = new bootstrap.Modal(document.getElementById('modalConfirmMigration'));
                modalEl.show();
            });

            // Check DB Status
            $('.btn-check-db-status').on('click', function () {
                $.ajax({
                    url: "<?= site_url('migration/status'); ?>",
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.status === 'success') {
                            var statusText = res.referensi_pegawai_table_exists
                                ? 'Tabel referensi_pegawai TERBENTUK (' + res.referensi_pegawai_count + ' record).'
                                : 'Tabel referensi_pegawai BELUM TERBENTUK.';
                            alert('Status Database MySQL: ' + statusText + ' Versi Migrasi: v' + res.current_version);
                            location.reload();
                        }
                    },
                    error: function () {
                        alert('Gagal mengecek status database.');
                    }
                });
            });
        });
    </script>
</body>

</html>