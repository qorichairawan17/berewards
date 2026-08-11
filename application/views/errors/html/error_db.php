<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = & get_config();
$base_url = !empty($config['base_url']) ? $config['base_url'] : '/berewards/';
$base_url = rtrim($base_url, '/') . '/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($heading) ? strip_tags($heading) : 'Database Error'; ?> | BeRewards SPK TOPSIS</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- App Favicon Icons -->
    <link rel="shortcut icon" href="<?= $base_url; ?>assets/icons/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?= $base_url; ?>assets/icons/favicon-32x32.png" sizes="32x32" type="image/png" />
    <link rel="icon" href="<?= $base_url; ?>assets/icons/favicon-16x16.png" sizes="16x16" type="image/png" />
    <link rel="apple-touch-icon" href="<?= $base_url; ?>assets/icons/apple-icon-180x180.png" />
    <link rel="manifest" href="<?= $base_url; ?>assets/icons/manifest.json" />

    <!-- Theme & Icons CSS -->
    <link href="<?= $base_url; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $base_url; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $base_url; ?>assets/css/spk-reward.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 24px;
        }
        .clean-error-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.08);
            overflow: hidden;
        }
        .icon-circle-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #E0F2FE;
            color: #0284C7;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .info-box-light {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 0.75rem;
        }
        .btn-brand-primary {
            background-color: #108DFF;
            color: #ffffff;
            font-weight: 600;
            border: none;
            padding: 0.65rem 1.35rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-brand-primary:hover {
            background-color: #0077E6;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 141, 255, 0.25);
        }
        .btn-brand-secondary {
            background-color: #F1F5F9;
            color: #334155;
            font-weight: 600;
            border: 1px solid #CBD5E1;
            padding: 0.65rem 1.35rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-brand-secondary:hover {
            background-color: #E2E8F0;
            color: #0F172A;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 840px;">
        <div class="clean-error-card p-4 p-md-5 mb-4">
            <!-- Header Badge -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 pb-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 fs-11 fw-bold text-uppercase">
                        <i class="ti ti-building-court me-1"></i> Pengadilan Negeri Lubuk Pakam Kelas I-A
                    </span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-11 fw-semibold">
                        Database Service Exception
                    </span>
                </div>
                <span class="badge bg-light text-muted border px-2.5 py-1 fs-11 font-monospace fw-semibold">
                    MySQL / DB Alert
                </span>
            </div>

            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <div class="icon-circle-avatar mb-3">
                        <i class="ti ti-database-exclamation display-5"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2 fs-22"><?php echo !empty($heading) ? $heading : 'Database Engine Error'; ?></h3>
                    <p class="text-secondary fs-14 leading-relaxed mb-4">
                        Gagal menghubungkan atau mengeksekusi kueri ke database MySQL. Pastikan service MySQL di Control Panel server dalam keadaan aktif.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="javascript:location.reload()" class="btn-brand-primary">
                            <i class="ti ti-refresh me-2 fs-18"></i> Coba Koneksi Ulang
                        </a>
                        <a href="<?= $base_url; ?>index.php/dashboard" class="btn-brand-secondary">
                            <i class="ti ti-layout-dashboard me-2 fs-18"></i> Dashboard
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box-light p-3.5">
                        <h6 class="fw-bold text-info mb-2 fs-13 text-uppercase tracking-wider">
                            <i class="ti ti-terminal-2 me-1"></i> Log Rincian Kueri Database
                        </h6>
                        <div class="p-3 rounded bg-white mb-3 font-monospace fs-12 border text-dark text-break" style="max-height: 200px; overflow-y: auto;">
                            <?php echo !empty($message) ? $message : 'Unable to connect to your database server using the provided settings.'; ?>
                        </div>
                        
                        <h6 class="fw-semibold text-dark mb-2 fs-12">Pemeriksaan Administrator:</h6>
                        <ul class="ps-3 mb-0 fs-12 text-muted leading-relaxed">
                            <li class="mb-1">Pastikan service MySQL XAMPP berstatus "Running".</li>
                            <li class="mb-1">Periksa `application/config/database.php`.</li>
                            <li>Pastikan skema database `berewards` sudah di-import.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center text-muted fs-12">
            &copy; <?= date('Y'); ?> <strong>Pengadilan Negeri Lubuk Pakam Kelas I-A</strong> — SPK Reward TOPSIS Engine
        </div>
    </div>
</body>
</html>