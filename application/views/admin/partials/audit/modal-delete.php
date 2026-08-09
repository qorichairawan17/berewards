<!-- Modal Hapus Audit Log -->
<div class="modal fade" id="modalHapusAudit" tabindex="-1" aria-labelledby="modalHapusAuditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-danger-subtle text-danger">
                <h5 class="modal-title fw-bold" id="modalHapusAuditLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus Log Audit
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="text-danger mb-3">
                    <i class="ti ti-trash fs-40"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2">Apakah Anda yakin ingin mengarsipkan / menghapus entri log audit ini?</h6>
                <p class="text-muted fs-13 mb-0" id="delete_aktivitas_text">-</p>
                <small class="text-muted fs-11 d-block mt-2">Penghapusan log audit akan dicatat dalam log keamanan utama.</small>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnKonfirmasiHapusAudit">Ya, Hapus Log</button>
            </div>
        </div>
    </div>
</div>
