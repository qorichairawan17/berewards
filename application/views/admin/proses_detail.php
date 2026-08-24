<!-- Toast Container (Top Right Placement Referencing auth/signin.php) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
    <div id="toastNotification" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2.5 p-3 text-white">
                <i id="toastIcon" class="fs-22 me-1 text-white"></i>
                <div class="text-white">
                    <strong id="toastTitle" class="d-block fs-13 fw-bold mb-0.5 text-white"></strong>
                    <span id="toastText" class="fs-12 text-white"></span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/penilaian/detail-header'); ?>
<?php $this->load->view('admin/partials/penilaian/stats-cards'); ?>
<?php $this->load->view('admin/partials/penilaian/detail-tables'); ?>

<!-- Modals -->
<?php $this->load->view('admin/partials/penilaian/modal-input-nilai'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-edit'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-detail'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/penilaian/script-init'); ?>
