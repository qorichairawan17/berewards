<!-- Modal Detail Audit Log -->
<div class="modal fade" id="modalDetailAudit" tabindex="-1" aria-labelledby="modalDetailAuditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailAuditLabel">
                    <i class="ti ti-activity text-primary me-2"></i>Rincian Transaksi Audit Trail
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="card bg-light border-0 p-3 mb-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="d-block text-muted fs-11">Waktu Timestamp</small>
                            <strong class="d-block text-dark fs-13" id="detail_timestamp">-</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="d-block text-muted fs-11">Status Eksekusi</small>
                            <span id="detail_status_badge">-</span>
                        </div>
                        <div class="col-md-6">
                            <small class="d-block text-muted fs-11">Pengguna / Role</small>
                            <strong class="d-block text-dark fs-13" id="detail_user">-</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="d-block text-muted fs-11">Alamat IP Client</small>
                            <span class="badge bg-dark text-white px-2 py-1 fs-11" id="detail_ip">-</span>
                        </div>
                        <div class="col-12 mt-2">
                            <small class="d-block text-muted fs-11">Modul Terkait</small>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11" id="detail_modul">-</span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold text-dark fs-12 mb-1">Rincian Deskripsi Aktivitas:</h6>
                    <div class="p-3 bg-white border rounded text-dark fs-13 leading-relaxed" id="detail_aktivitas">
                        -
                    </div>
                </div>

                <div>
                    <h6 class="fw-bold text-dark fs-12 mb-1">Audit Metadata Header:</h6>
                    <pre class="bg-dark text-success p-3 rounded fs-11 mb-0" style="max-height: 120px; overflow-y: auto;">
{
  "system": "SPK BeRewards PN Lubuk Pakam",
  "environment": "production",
  "client_browser": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
  "protocol": "HTTPS/1.1",
  "audit_version": "v1.2.0"
}</pre>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
