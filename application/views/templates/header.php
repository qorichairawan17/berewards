<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BeRewards — Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court">
    <title><?= isset($page_title) ? html_escape($page_title) . ' | ' : ''; ?>BeRewards</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/icons.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/spk-reward.css'); ?>">
    <script src="<?= base_url('assets/js/head.js'); ?>"></script>
</head>
<body class="spk-app<?= !empty($is_auth_page) ? ' spk-auth-page' : ''; ?>" data-menu-color="light" data-sidebar="default">
