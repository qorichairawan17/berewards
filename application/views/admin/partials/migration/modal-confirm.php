<!-- Modal Konfirmasi Eksekusi / Rollback Migrasi -->
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
                <div class="p-3 bg-light rounded-circle text-primary mx-auto mb-3" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                    <i class="ti ti-alert-triangle fs-32"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2" id="confirmMigrationTitle">Jalankan Migrasi Skema Tabel?</h5>
                <p class="text-muted fs-13 mb-3" id="confirmMigrationBody">
                    Apakah Anda yakin ingin memproses eksekusi migrasi skema tabel <strong id="confirmTableName" class="text-primary font-monospace">employee_data</strong>?
                </p>
                <div class="p-2.5 bg-warning-subtle text-warning border border-warning-subtle rounded text-start fs-12 mb-0">
                    <i class="ti ti-info-circle me-1"></i> Tindakan rollback akan menghapus tabel <span class="font-monospace fw-bold">employee_data</span> beserta seluruh data sampel di dalamnya.
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
