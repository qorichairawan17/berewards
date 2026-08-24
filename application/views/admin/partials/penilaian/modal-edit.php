<!-- Modal Edit Penilaian -->
<div class="modal fade" id="modalEditPenilaian" tabindex="-1" aria-labelledby="modalEditPenilaianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalEditPenilaianLabel">
                    <i class="ti ti-edit text-primary me-2"></i>Edit Nilai Kriteria Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditPenilaian">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="edit_id_proses" name="id_proses" value="<?= isset($id_proses) ? $id_proses : (isset($periode_info['id_proses']) ? $periode_info['id_proses'] : ''); ?>">
                <input type="hidden" id="edit_id_proses_alternatif" name="id_proses_alternatif">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Pegawai Alternatif</label>
                            <input type="text" class="form-control bg-light" id="edit_nama_pegawai" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Periode Penilaian</label>
                            <input type="text" class="form-control bg-light" id="edit_nama_periode" readonly>
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="ti ti-checklist text-primary me-1"></i> Perbarui Skor Kriteria
                            </h6>
                        </div>

                        <?php if (!empty($kriteria_list)): ?>
                            <?php foreach ($kriteria_list as $kr): ?>
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
                                        <select class="form-select edit_kriteria_input"
                                                id="edit_c_<?= $kr['id_proses_kriteria']; ?>"
                                                name="c_<?= $kr['id_proses_kriteria']; ?>"
                                                data-id-kriteria="<?= $kr['id_proses_kriteria']; ?>" required>
                                            <option value="" disabled>-- Pilih Sub Kriteria Penilaian --</option>
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
                                        <input type="number" step="0.01" class="form-control edit_kriteria_input"
                                               id="edit_c_<?= $kr['id_proses_kriteria']; ?>"
                                               name="c_<?= $kr['id_proses_kriteria']; ?>"
                                               data-id-kriteria="<?= $kr['id_proses_kriteria']; ?>"
                                               placeholder="Masukkan nilai angka rill (contoh: 95.50)" required>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C1: Kedisiplinan & Kehadiran (1-5)</label>
                                <input type="number" step="0.1" min="1" max="5" class="form-control" id="edit_c1" name="c1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C2: Penyelesaian Perkara / SKP (%)</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control" id="edit_c2" name="c2" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C3: Integritas & Kode Etik (1-5)</label>
                                <input type="number" step="0.1" min="1" max="5" class="form-control" id="edit_c3" name="c3" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark fs-12">C4: Tunggakan Minutasi (Jumlah Berkas)</label>
                                <input type="number" min="0" class="form-control" id="edit_c4" name="c4" required>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Perbarui Nilai</button>
                </div>
            </form>
        </div>
    </div>
</div>
