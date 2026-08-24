<!-- Modal Input Nilai Alternative Pegawai -->
<div class="modal fade" id="modalInputNilaiPegawai" tabindex="-1" aria-labelledby="modalInputNilaiPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalInputNilaiPegawaiLabel">
                    <i class="ti ti-user-plus text-primary me-2"></i>Input Nilai Alternative Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formInputNilaiPegawai">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="id_proses" value="<?= isset($id_proses) ? $id_proses : (isset($periode_info['id_proses']) ? $periode_info['id_proses'] : ''); ?>">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Pilih Pegawai Kandidat <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_pegawai" id="input_id_pegawai" required>
                                <option value="" selected disabled>-- Pilih Pegawai dari Referensi --</option>
                                <?php if (!empty($pegawai_options)): ?>
                                    <?php foreach ($pegawai_options as $p): ?>
                                        <option value="<?= $p['id_pegawai']; ?>">
                                            <?= html_escape($p['nama']); ?> (NIP: <?= html_escape($p['nip']); ?> - <?= html_escape($p['kategori']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Dynamic Criteria Inputs -->
                        <?php if (!empty($kriteria_list)): ?>
                            <?php foreach ($kriteria_list as $index => $kr): ?>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark fs-12 d-flex align-items-center justify-content-between mb-1">
                                        <span>
                                            <span class="badge bg-primary text-white px-1.5 py-0.5 fs-11 me-1"><?= html_escape($kr['kode']); ?></span>
                                            <?= html_escape($kr['nama_kriteria']); ?> <span class="text-danger">*</span>
                                        </span>
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="badge bg-light text-muted border fs-10 text-uppercase"><?= $kr['tipe_atribut']; ?></span>
                                            <?php if ($kr['jenis_data'] === 'kualitatif'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-10">Skala</span>
                                            <?php else: ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle fs-10">Angka Rill</span>
                                            <?php endif; ?>
                                        </span>
                                    </label>
                                    
                                    <?php if ($kr['jenis_data'] === 'kualitatif' && !empty($kr['skala_list'])): ?>
                                        <select class="form-select" name="c_<?= $kr['id_proses_kriteria']; ?>" required>
                                            <option value="" selected disabled>-- Pilih Sub Kriteria Penilaian --</option>
                                            <?php foreach ($kr['skala_list'] as $sk): ?>
                                                <?php 
                                                    $subTitle = !empty($sk['sub_kriteria']) ? $sk['sub_kriteria'] : (!empty($sk['label']) ? $sk['label'] : 'Opsi Skala');
                                                    $ketTitle = !empty($sk['keterangan']) ? $sk['keterangan'] : (!empty($sk['label']) ? $sk['label'] : '');
                                                    $valNum   = (float)$sk['nilai'];
                                                ?>
                                                <option value="<?= $valNum; ?>">
                                                    <?= html_escape($subTitle); ?> &nbsp;—&nbsp; (Bobot: <?= $valNum; ?><?= !empty($ketTitle) ? ' - ' . html_escape($ketTitle) : ''; ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <input type="number" step="0.01" class="form-control" name="c_<?= $kr['id_proses_kriteria']; ?>"
                                               placeholder="Masukkan nilai angka rill (contoh: 95.50)" required>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C1: Kedisiplinan Kehadiran (Skala 1 - 5) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="1" max="5" class="form-control" name="c1" placeholder="Contoh: 4.8" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C2: Produktivitas Perkara / Tugas (Skor 0 - 100) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="0" max="100" class="form-control" name="c2" placeholder="Contoh: 95.5" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C3: Integritas & Kepatuhan (Skala 1 - 5) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="1" max="5" class="form-control" name="c3" placeholder="Contoh: 4.9" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C4: Inovasi & Pelayanan (Skala 1 - 5) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="1" max="5" class="form-control" name="c4" placeholder="Contoh: 4.5" required>
                            </div>
                        <?php endif; ?>

                        <div class="col-12">
                            <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-2 mb-0 fs-12">
                                <i class="ti ti-info-circle fs-18 flex-shrink-0 text-info"></i>
                                <div>
                                    Nilai kriteria yang dimasukkan akan secara otomatis diproses dalam matriks keputusan dan dinormalisasi untuk kalkulasi TOPSIS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Nilai Alternative</button>
                </div>
            </form>
        </div>
    </div>
</div>
