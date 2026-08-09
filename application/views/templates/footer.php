    <?php if (empty($is_auth_page)): ?>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col fs-13 text-muted text-center">
                        &copy; <?= date('Y'); ?> <span class="fw-bold text-primary">BeRewards</span> — Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court With TOPSIS Method.
                    </div>
                </div>
            </div>
        </footer>
        </div><!-- end content-page -->
        </div><!-- end #app-layout -->
    <?php endif; ?>

    <!-- Vendor Scripts -->
    <script src="<?= base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/node-waves/waves.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/waypoints/lib/jquery.waypoints.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/jquery.counterup/jquery.counterup.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/feather-icons/feather.min.js'); ?>"></script>

    <!-- App js-->
    <script src="<?= base_url('assets/js/app.js'); ?>"></script>
</body>
</html>

