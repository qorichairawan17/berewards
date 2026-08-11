<?php $this->load->view('admin/partials/profile/header-banner'); ?>
<?php $this->load->view('admin/partials/profile/stats-cards'); ?>

<div class="row g-3">
    <!-- Left Column: Main Detail & Form Panel -->
    <main class="col-lg-8">
        <?php $this->load->view('admin/partials/profile/info-form'); ?>
    </main>

    <!-- Right Column: ID Card & Security Log Sidebar -->
    <?php $this->load->view('admin/partials/profile/activity-sidebar'); ?>
</div>
