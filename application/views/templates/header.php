<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="BeRewards — Sistem Pendukung Keputusan Penentuan Reward Terbaik Bagi Hakim, Panitera Pengganti, Jurusita, dan Staf Pengadilan Negeri Lubuk Pakam Kelas I-A Menggunakan Metode TOPSIS." />
    <meta name="author" content="Pengadilan Negeri Lubuk Pakam Kelas I-A" />
    <meta name="keywords"
        content="BeRewards, SPK TOPSIS, Reward Pegawai, Pengadilan Negeri Lubuk Pakam, TOPSIS Method, Decision Support System, Penilaian Kinerja Hakim" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#108DFF" />

    <!-- Open Graph Metadata -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= current_url(); ?>" />
    <meta property="og:title" content="<?= isset($page_title) ? html_escape($page_title) . ' | ' : ''; ?>BeRewards — SPK TOPSIS PN Lubuk Pakam" />
    <meta property="og:description"
        content="Sistem Pendukung Keputusan Penentuan Reward Terbaik Bagi Hakim & Pegawai Pengadilan Negeri Lubuk Pakam berbasis Metode TOPSIS." />
    <meta property="og:image" content="<?= base_url('assets/icons/logo.png'); ?>" />

    <!-- Twitter Card Metadata -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= isset($page_title) ? html_escape($page_title) . ' | ' : ''; ?>BeRewards — SPK TOPSIS" />
    <meta name="twitter:description"
        content="Sistem Pendukung Keputusan Penentuan Reward Terbaik Bagi Hakim & Pegawai Pengadilan Negeri Lubuk Pakam berbasis Metode TOPSIS." />
    <meta name="twitter:image" content="<?= base_url('assets/icons/logo.png'); ?>" />

    <!-- App Favicon Icons -->
    <link rel="shortcut icon" href="<?= base_url('assets/icons/favicon.ico'); ?>" type="image/x-icon" />
    <link rel="icon" href="<?= base_url('assets/icons/favicon-32x32.png'); ?>" sizes="32x32" type="image/png" />
    <link rel="icon" href="<?= base_url('assets/icons/favicon-16x16.png'); ?>" sizes="16x16" type="image/png" />
    <link rel="apple-touch-icon" href="<?= base_url('assets/icons/apple-icon-180x180.png'); ?>" />
    <link rel="manifest" href="<?= base_url('assets/icons/manifest.json'); ?>" />

    <title><?= isset($page_title) ? html_escape($page_title) . ' | ' : ''; ?>BeRewards — SPK TOPSIS PN Lubuk Pakam</title>

    <!-- App css -->
    <link href="<?= base_url('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons -->
    <link href="<?= base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- BeRewards Custom styling -->
    <link href="<?= base_url('assets/css/spk-reward.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Extra Page CSS -->
    <?php if (!empty($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link href="<?= base_url($css); ?>" rel="stylesheet" type="text/css" />
        <?php endforeach; ?>
    <?php endif; ?>

    <script src="<?= base_url('assets/js/head.js'); ?>"></script>
</head>

<body class="spk-app<?= !empty($is_auth_page) ? ' spk-auth-page' : ''; ?>" data-menu-color="light" data-sidebar="default">