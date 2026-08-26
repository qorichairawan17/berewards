<!-- Modal Pilih Periode Pratinjau Kandidat -->
<div class="modal fade" id="modalSelectPreviewPeriode" tabindex="-1" aria-labelledby="modalSelectPreviewPeriodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalSelectPreviewPeriodeLabel">
                    <i class="ti ti-sparkles text-primary me-2"></i>Pilih Periode Pratinjau Reward
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formPilihPeriodeShowroom" action="<?= site_url('laporan/preview'); ?>" method="GET">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark fs-12">Pilih Sesi Penilaian SPK TOPSIS <span
                                class="text-danger">*</span></label>
                        <select class="form-select form-select-lg fs-13" id="select_showroom_periode" required>
                            <?php if (!empty($form_options['available_proses'])): ?>
                                <optgroup label="Sesi Penilaian TOPSIS (Hasil Final)">
                                    <?php foreach ($form_options['available_proses'] as $idx => $p): ?>
                                        <option value="proses_<?= $p['id_proses']; ?>" <?= ($idx === 0) ? 'selected' : ''; ?> data-id="<?= $p['id_proses']; ?>"
                                            data-type="proses" data-periode="<?= html_escape($p['nama_periode']); ?>"
                                            data-kategori="<?= html_escape($p['kategori']); ?>">
                                            <?= html_escape($p['nama_periode']); ?> — Kategori <?= html_escape($p['kategori']); ?> (Pemenang:
                                            <?= html_escape($p['pemenang_nama']); ?>, Skor: <?= number_format($p['skor_topsis'], 4); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endif; ?>

                            <?php if (!empty($laporan_list)): ?>
                                <optgroup label="Arsip Dokumen Berita Acara">
                                    <?php foreach ($laporan_list as $l): ?>
                                        <option value="laporan_<?= $l['id_laporan']; ?>" data-id="<?= $l['id_laporan']; ?>" data-type="laporan"
                                            data-idproses="<?= $l['id_proses']; ?>" data-periode="<?= html_escape($l['nama_periode']); ?>"
                                            data-kategori="<?= html_escape($l['kategori']); ?>">
                                            <?= html_escape($l['no_ba']); ?> — <?= html_escape($l['nama_periode']); ?> (Kategori
                                            <?= html_escape($l['kategori']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endif; ?>

                            <?php if (empty($form_options['available_proses']) && empty($laporan_list)): ?>
                                <option value="" disabled selected>Belum ada sesi penilaian TOPSIS yang selesai dihitung</option>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted fs-11 mt-1 d-block"><i class="ti ti-info-circle me-1"></i>Pilih sesi penilaian TOPSIS yang ingin
                            ditampilkan pada antarmuka Showroom.</small>
                    </div>
                    <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center gap-2 mb-0 fs-12">
                        <i class="ti ti-trophy fs-20 flex-shrink-0 text-primary"></i>
                        <div>
                            Menampilkan pratinjau interaktif 3D Stack Card untuk 3 kandidat terbaik, metrik preferensi, dan evaluasi rincian kriteria
                            kinerja.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btnLaunchModalShowroom">
                            <i class="ti ti-eye me-1"></i> Buka Modal Showroom
                        </button>
                        <button type="submit" class="btn btn-brand btn-sm" id="btnLaunchPageShowroom">
                            <i class="ti ti-external-link me-1"></i> Halaman Penuh
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>