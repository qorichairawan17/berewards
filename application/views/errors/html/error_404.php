<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = &get_config();
$base_url = !empty($config['base_url']) ? $config['base_url'] : '/berewards/';
$base_url = rtrim($base_url, '/') . '/';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | SPK BeRewards</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- App Favicon Icons -->
    <link rel="shortcut icon" href="<?= $base_url; ?>assets/icons/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?= $base_url; ?>assets/icons/favicon-32x32.png" sizes="32x32" type="image/png" />
    <link rel="icon" href="<?= $base_url; ?>assets/icons/favicon-16x16.png" sizes="16x16" type="image/png" />
    <link rel="apple-touch-icon" href="<?= $base_url; ?>assets/icons/apple-icon-180x180.png" />

    <!-- Theme & Icons CSS -->
    <link href="<?= $base_url; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $base_url; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <style>
        :root {
            --primary: #108DFF;
            --primary-gradient: linear-gradient(135deg, #108DFF 0%, #0066CC 100%);
            --accent-glow: rgba(16, 141, 255, 0.12);
            --bg-canvas: #F6F9FC;
            --card-bg: rgba(255, 255, 255, 0.94);
            --text-dark: #0F172A;
            --text-body: #475569;
            --text-muted: #94A3B8;
            --border-light: #E2E8F0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-canvas);
            background-image: 
                radial-gradient(at 15% 15%, rgba(16, 141, 255, 0.07) 0px, transparent 50%),
                radial-gradient(at 85% 85%, rgba(99, 102, 241, 0.06) 0px, transparent 50%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 32px 16px;
        }

        .error-wrapper {
            width: 100%;
            max-width: 980px;
        }

        .error-header-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #FFFFFF;
            border: 1px solid var(--border-light);
            border-radius: 9999px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #DC2626;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 9999px;
            letter-spacing: 0.5px;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #DC2626;
            box-shadow: 0 0 8px #DC2626;
            animation: blinkDot 1.5s infinite alternate;
        }

        @keyframes blinkDot {
            0% { opacity: 0.4; }
            100% { opacity: 1; }
        }

        .fresh-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 24px;
            box-shadow: 
                0 20px 40px -15px rgba(16, 141, 255, 0.07),
                0 1px 3px rgba(0, 0, 0, 0.02);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .hero-number {
            font-size: 6.5rem;
            font-weight: 800;
            line-height: 0.9;
            letter-spacing: -4px;
            background: linear-gradient(135deg, #0F172A 0%, #108DFF 50%, #6366F1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px;
        }

        .hero-title {
            font-size: 1.625rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            font-size: 0.95rem;
            color: var(--text-body);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .action-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-fresh-primary {
            background: var(--primary-gradient);
            color: #FFFFFF !important;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 14px rgba(16, 141, 255, 0.3);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-fresh-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(16, 141, 255, 0.4);
            color: #FFFFFF;
        }

        .btn-fresh-secondary {
            background: #FFFFFF;
            color: var(--text-dark) !important;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid var(--border-light);
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-fresh-secondary:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            transform: translateY(-2px);
            color: var(--text-dark);
        }

        .info-card {
            background: #F8FAFC;
            border: 1px solid var(--border-light);
            border-radius: 18px;
            padding: 24px;
            height: 100%;
        }

        .info-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .info-card-title {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--primary);
        }

        .terminal-box {
            font-family: 'JetBrains Mono', monospace;
            background: #FFFFFF;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 0.8125rem;
            color: #334155;
            line-height: 1.5;
            margin-bottom: 20px;
            word-break: break-all;
        }

        .check-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .check-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.8125rem;
            color: var(--text-body);
            margin-bottom: 10px;
        }

        .check-list li:last-child {
            margin-bottom: 0;
        }

        .check-list i {
            color: var(--primary);
            font-size: 1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .footer-text {
            text-align: center;
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-top: 24px;
        }

        @media (max-width: 768px) {
            .fresh-card {
                padding: 24px;
            }
            .hero-number {
                font-size: 4.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="error-wrapper">
        <!-- Top Navigation Brand Bar -->
        <div class="error-header-brand">
            <div class="brand-badge">
                <img src="<?= $base_url; ?>assets/icons/logo.png" alt="BeRewards Logo" width="22" height="22" class="rounded">
                <span>Pengadilan Negeri Lubuk Pakam Kelas I-A</span>
            </div>
            <div class="status-pill">
                <span class="status-dot"></span>
                <span>HTTP 404 NOT FOUND</span>
            </div>
        </div>

        <!-- Main Card -->
        <div class="fresh-card">
            <div class="row align-items-center g-4">
                <!-- Left Hero Content -->
                <div class="col-lg-6">
                    <div class="hero-number">404</div>
                    <h1 class="hero-title">Halaman Tidak Ditemukan</h1>
                    <p class="hero-subtitle">
                        Alamat URL yang Anda tuju tidak terdaftar, telah dipindahkan, atau rute target tidak aktif pada aplikasi SPK BeRewards.
                    </p>

                    <div class="action-group">
                        <a href="<?= $base_url; ?>index.php/dashboard" class="btn-fresh-primary">
                            <i class="ti ti-layout-dashboard fs-18"></i>
                            <span>Beranda Utama</span>
                        </a>
                        <a href="javascript:history.back()" class="btn-fresh-secondary">
                            <i class="ti ti-arrow-left fs-18"></i>
                            <span>Kembali</span>
                        </a>
                        <a href="javascript:location.reload()" class="btn-fresh-secondary">
                            <i class="ti ti-refresh fs-18"></i>
                            <span>Refresh</span>
                        </a>
                    </div>
                </div>

                <!-- Right Information Card -->
                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="info-card-header">
                            <span class="info-card-title"><i class="ti ti-terminal me-1"></i> Rincian Diagnostik System</span>
                            <span class="badge bg-light text-muted border fs-10 font-monospace">Route Debug</span>
                        </div>

                        <div class="terminal-box">
                            <i class="ti ti-alert-circle text-primary me-1"></i> 
                            <?php echo !empty($message) ? strip_tags($message) : 'The requested URL target was not found on this application router.'; ?>
                        </div>

                        <span class="d-block text-dark fw-bold fs-12 mb-2">Langkah Penanganan Disarankan:</span>
                        <ul class="check-list">
                            <li>
                                <i class="ti ti-circle-check-filled"></i>
                                <span>Periksa kembali penulisan nama URL atau rute pada alamat browser.</span>
                            </li>
                            <li>
                                <i class="ti ti-circle-check-filled"></i>
                                <span>Gunakan tautan navigasi resmi yang tersedia pada bilah menu samping.</span>
                            </li>
                            <li>
                                <i class="ti ti-circle-check-filled"></i>
                                <span>Hubungi Administrator Subbag Kepegawaian jika kendala berlanjut.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-text">
            © <?= date('Y'); ?> <strong>Pengadilan Negeri Lubuk Pakam Kelas I-A</strong> • BeRewards System Engine
        </div>
    </div>
</body>

</html>