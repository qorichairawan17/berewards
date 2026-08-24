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
                                    <label class="form-label fw-semibold text-dark fs-12">
                                        <?= html_escape($kr['kode']); ?>: <?= html_escape($kr['nama_kriteria']); ?>
                                        <span class="badge bg-light text-muted border fs-10 text-uppercase"><?= $kr['tipe_atribut']; ?></span>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" step="0.01" class="form-control" name="c_<?= $kr['id_proses_kriteria']; ?>"
                                           placeholder="Nilai angka kriteria <?= html_escape($kr['kode']); ?>" required>
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
