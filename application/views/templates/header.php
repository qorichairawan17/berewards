<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BeRewards — Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court With TOPSIS Method"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= isset($page_title) ? html_escape($page_title) . ' | ' : ''; ?>BeRewards</title>

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

