<!-- Modal Buat Berita Acara Baru -->
<div class="modal fade" id="modalTambahLaporan" tabindex="-1" aria-labelledby="modalTambahLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahLaporanLabel">
                    <i class="ti ti-file-plus text-primary me-2"></i>Buat Berita Acara Penetapan Reward
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahLaporan" action="<?= site_url('laporan/simpan'); ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs-12">Sesi Penilaian TOPSIS (Hasil Final) <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_id_proses" name="id_proses" required>
                                <option value="" disabled selected>-- Pilih Sesi Penilaian yang Selesai Dihitung --</option>
                                <?php if (!empty($form_options['available_proses'])): ?>
                                    <?php foreach ($form_options['available_proses'] as $p): ?>
                                        <option value="<?= $p['id_proses']; ?>" 
                                                data-kategori="<?= html_escape($p['kategori']); ?>"
                                                data-pemenang="<?= html_escape($p['pemenang_nama']); ?>"
                                                data-nip="<?= html_escape($p['pemenang_nip']); ?>"
                                                data-skor="<?= number_format($p['skor_topsis'], 4); ?>"
                                                data-periode="<?= html_escape($p['nama_periode']); ?>">
                                            <?= html_escape($p['nama_periode']); ?> — Kategori <?= html_escape($p['kategori']); ?> (Pemenang: <?= html_escape($p['pemenang_nama']); ?>, Skor: <?= number_format($p['skor_topsis'], 4); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted fs-11 mt-1 d-block"><i class="ti ti-info-circle me-1"></i>Hanya menampilkan sesi penilaian dengan status <strong>Final</strong> yang telah memiliki hasil perankingan.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nomor Berita Acara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_no_ba" name="no_ba" value="<?= html_escape(!empty($form_options['nomor_ba_auto']) ? $form_options['nomor_ba_auto'] : 'W2.U4/01/BA.SPK/VIII/' . date('Y')); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">SK Tim Penilai Terkait</label>
                            <select class="form-select" id="add_id_sk" name="id_sk">
                                <?php if (!empty($form_options['sk_list'])): ?>
                                    <?php foreach ($form_options['sk_list'] as $sk): ?>
                                        <option value="<?= $sk['id_sk']; ?>" <?= (strtolower($sk['status']) === 'aktif') ? 'selected' : ''; ?>
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
                                <input type="text" class="form-control border-start-0 datepicker-input" id="add_tanggal_terbit" name="tanggal_terbit" placeholder="Pilih Tanggal Terbit" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Berita Acara <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_status" name="status" required>
                                <option value="Disahkan" selected>Disahkan (Resmi)</option>
                                <option value="Draft">Draft</option>
                                <option value="Arsip">Arsip</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Ketua Tim Penilai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_ketua_panitia" name="ketua_panitia" value="<?= html_escape(!empty($form_options['default_ketua']) ? $form_options['default_ketua'] : "Bambang Wijaya, S.H., M.H."); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand" id="btnSubmitAddLaporan">
                        <i class="ti ti-check me-1"></i> Terbitkan Berita Acara
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
