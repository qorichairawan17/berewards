<!-- Modal Edit Berita Acara -->
<div class="modal fade" id="modalEditLaporan" tabindex="-1" aria-labelledby="modalEditLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditLaporanLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Berita Acara
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditLaporan" action="<?= site_url('laporan/update'); ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="edit_id_laporan" name="id_laporan">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nomor Berita Acara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_no_ba" name="no_ba" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">SK Tim Penilai Terkait</label>
                            <select class="form-select" id="edit_id_sk" name="id_sk">
                                <option value="">-- Pilih SK Tim Penilai --</option>
                                <?php if (!empty($form_options['sk_list'])): ?>
                                    <?php foreach ($form_options['sk_list'] as $sk): ?>
                                        <option value="<?= $sk['id_sk']; ?>"
                                                data-ketua="<?= !empty($sk['ketua']) ? html_escape($sk['ketua']['nama']) : ''; ?>">
                                            <?= html_escape($sk['no_sk']); ?> (<?= html_escape($sk['status']); ?> - <?= html_escape($sk['tahun']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Tanggal Penerbitan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 datepicker-input" id="edit_tanggal_terbit" name="tanggal_terbit" placeholder="Pilih Tanggal Terbit" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Dokumen <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="Disahkan">Disahkan</option>
                                <option value="Draft">Draft</option>
                                <option value="Arsip">Arsip</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Ketua Tim Penilai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_ketua_panitia" name="ketua_panitia" required placeholder="Nama Ketua Tim Penilai">
                            <small class="text-muted fs-11 mt-1 d-block"><i class="ti ti-user-check me-1 text-primary"></i>Otomatis disinkronkan dari data Ketua Tim Penilai pada SK yang dipilih.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand" id="btnSubmitEditLaporan">
                        <i class="ti ti-check me-1"></i> Perbarui Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
