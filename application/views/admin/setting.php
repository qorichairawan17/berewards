<?php $this->load->view('admin/partials/setting/header-banner'); ?>
<?php $this->load->view('admin/partials/setting/stats-cards'); ?>

<div class="row g-3">
    <!-- Left Column: Main Configuration Tabs & Forms Panel -->
    <main class="col-lg-8">
        <?php $this->load->view('admin/partials/setting/info-form'); ?>
    </main>

    <!-- Right Column: Court Badge & Leadership Directory Sidebar -->
    <?php $this->load->view('admin/partials/setting/sidebar-info'); ?>
</div>
