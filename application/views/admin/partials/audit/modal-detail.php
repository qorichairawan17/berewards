<!-- Modal Detail Audit Log -->
<div class="modal fade" id="modalDetailAudit" tabindex="-1" aria-labelledby="modalDetailAuditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-sm bg-primary-subtle rounded text-primary d-flex align-items-center justify-content-center p-2">
                        <i class="ti ti-activity fs-18"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="modalDetailAuditLabel">
                            Rincian Transaksi Audit Trail
                        </h5>
                        <small class="text-muted fs-11">Log Aktivitas & Transparansi Perubahan Data Sistem</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            
            <div class="modal-body p-4">
                <!-- Loading State -->
                <div id="detail_loading" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary mb-2" role="status">
                        <span class="visually-hidden">Memuat data...</span>
                    </div>
                    <p class="text-muted fs-12 mb-0">Mengambil rincian data audit trail...</p>
                </div>

                <!-- Main Content Container -->
                <div id="detail_content">
                    <!-- Top Summary Card -->
                    <div class="card bg-light border-0 p-3 mb-4 rounded-3">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <small class="d-block text-muted fs-11 text-uppercase fw-semibold tracking-wider mb-1">Waktu Kejadian</small>
                                <strong class="d-block text-dark fs-13" id="detail_timestamp">-</strong>
                            </div>
                            <div class="col-md-3">
                                <small class="d-block text-muted fs-11 text-uppercase fw-semibold tracking-wider mb-1">Status Eksekusi</small>
                                <div id="detail_status_badge">-</div>
                            </div>
                            <div class="col-md-3">
                                <small class="d-block text-muted fs-11 text-uppercase fw-semibold tracking-wider mb-1">Pengguna Terlibat</small>
                                <strong class="d-block text-dark fs-13 text-truncate" id="detail_user">-</strong>
                            </div>
                            <div class="col-md-3">
                                <small class="d-block text-muted fs-11 text-uppercase fw-semibold tracking-wider mb-1">Alamat IP Client</small>
                                <span class="badge bg-dark text-white px-2 py-1 fs-11 font-monospace" id="detail_ip">-</span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <small class="d-block text-muted fs-11 text-uppercase fw-semibold tracking-wider mb-1">Modul & Tipe Aksi</small>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11" id="detail_modul">-</span>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 fs-11 fw-bold" id="detail_tipe_aksi">-</span>
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <small class="d-block text-muted fs-11 text-uppercase fw-semibold tracking-wider mb-1">Target Entitas / Tabel</small>
                                <div class="fs-12 text-dark font-monospace" id="detail_target_tabel">
                                    -
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <small class="d-block text-muted fs-11 text-uppercase fw-semibold tracking-wider mb-1">User Agent Browser</small>
                                <span class="text-muted fs-11 text-truncate d-block" id="detail_user_agent" title="">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Description -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark fs-12 mb-2 d-flex align-items-center gap-1">
                            <i class="ti ti-file-text text-primary"></i> Ringkasan Aktivitas:
                        </h6>
                        <div class="p-3 bg-white border rounded-3 text-dark fs-13 leading-relaxed shadow-sm" id="detail_aktivitas">
                            -
                        </div>
                    </div>

                    <!-- Database Data Comparison (Before vs After) -->
                    <div class="mb-4" id="section_data_diff">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-dark fs-12 mb-0 d-flex align-items-center gap-1">
                                <i class="ti ti-arrows-diff text-primary"></i> Transparansi Perubahan Data Database (Sebelum vs Sesudah):
                            </h6>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5 fs-10" id="diff_count_badge">
                                0 Field
                            </span>
                        </div>

                        <div class="table-responsive border rounded-3 bg-white shadow-sm">
                            <table class="table table-hover table-bordered align-middle mb-0 fs-12" id="table_data_diff">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 25%;">Nama Kolom / Field</th>
                                        <th style="width: 32%;">Data Sebelum (Old Value)</th>
                                        <th style="width: 32%;">Data Sesudah (New Value)</th>
                                        <th style="width: 11%;" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="diff_tbody">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Informational Banner for Non-DB logs -->
                    <div class="alert alert-info border-info-subtle d-flex align-items-center gap-2 mb-4 d-none" id="info_non_db">
                        <i class="ti ti-info-circle fs-18 text-info"></i>
                        <span class="fs-12">Aktivitas ini merupakan interaksi non-transaksional (tidak ada mutasi baris data pada tabel database).</span>
                    </div>

                    <!-- Technical Audit Payload (JSON View) -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-dark fs-12 mb-0 d-flex align-items-center gap-1">
                                <i class="ti ti-code text-secondary"></i> Metadata Header & Raw Payload:
                            </h6>
                            <button class="btn btn-link btn-sm text-muted p-0 fs-11 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRawJson" aria-expanded="false">
                                <i class="ti ti-chevron-down me-1"></i>Toggle Payload JSON
                            </button>
                        </div>
                        <div class="collapse show" id="collapseRawJson">
                            <pre class="bg-dark text-success p-3 rounded-3 fs-11 font-monospace mb-0 border border-dark" style="max-height: 160px; overflow-y: auto;" id="detail_raw_json">{
  "system": "SPK BeRewards PN Lubuk Pakam",
  "audit_version": "2.0.0-PROD"
}</pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-top bg-light py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
