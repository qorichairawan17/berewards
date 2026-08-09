<!-- Tabbed TOPSIS Results & Matrices -->
<div class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-header bg-light border-bottom p-3">
        <ul class="nav nav-pills card-header-pills gap-2" id="topsisTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold fs-13" id="tab-peringkat" data-bs-toggle="tab" data-bs-target="#panel-peringkat" type="button" role="tab">
                    <i class="ti ti-trophy me-1"></i> Peringkat & Hasil TOPSIS ($V_i$)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold fs-13" id="tab-matriks-x" data-bs-toggle="tab" data-bs-target="#panel-matriks-x" type="button" role="tab">
                    <i class="ti ti-table me-1"></i> Matriks Keputusan ($X_{ij}$)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold fs-13" id="tab-matriks-y" data-bs-toggle="tab" data-bs-target="#panel-matriks-y" type="button" role="tab">
                    <i class="ti ti-chart-arrows me-1"></i> Matriks Terbobot ($Y_{ij}$)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold fs-13" id="tab-solusi-ideal" data-bs-toggle="tab" data-bs-target="#panel-solusi-ideal" type="button" role="tab">
                    <i class="ti ti-target me-1"></i> Solusi Ideal ($A^+ / A^-$)
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body p-4">
        <div class="tab-content" id="topsisTabContent">
            
            <!-- PANEL 1: PERINGKAT & HASIL TOPSIS -->
            <div class="tab-pane fade show active" id="panel-peringkat" role="tabpanel">
                <div class="table-responsive">
                    <table id="tableHasilTopsis" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px;" class="text-center">Rank</th>
                                <th>NIP & Nama Pegawai</th>
                                <th>Jabatan & Kategori</th>
                                <th class="text-center">Jarak $D^+$</th>
                                <th class="text-center">Jarak $D^-$</th>
                                <th class="text-center">Skor Preferensi ($V_i$)</th>
                                <th class="text-center">Status</th>
                                <th style="width: 140px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hasil_topsis_pegawai)): ?>
                                <?php foreach ($hasil_topsis_pegawai as $row): ?>
                                    <tr class="<?= $row['peringkat'] == 1 ? 'table-warning-subtle' : ''; ?>">
                                        <td class="text-center">
                                            <?php if ($row['peringkat'] == 1): ?>
                                                <span class="badge bg-warning text-dark border border-warning px-2 py-1 fs-12 fw-bold">
                                                    <i class="ti ti-trophy me-1"></i>#1 WINNER
                                                </span>
                                            <?php elseif ($row['peringkat'] == 2): ?>
                                                <span class="badge bg-light text-dark border px-2 py-1 fs-12 fw-bold">#2</span>
                                            <?php elseif ($row['peringkat'] == 3): ?>
                                                <span class="badge bg-light text-dark border px-2 py-1 fs-12 fw-bold">#3</span>
                                            <?php else: ?>
                                                <span class="fw-semibold text-muted fs-13">#<?= $row['peringkat']; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong class="d-block text-dark fs-13"><?= html_escape($row['nama_pegawai']); ?></strong>
                                            <small class="text-muted fs-11">NIP. <?= html_escape($row['nip']); ?></small>
                                        </td>
                                        <td>
                                            <span class="d-block text-dark fs-13"><?= html_escape($row['jabatan']); ?></span>
                                            <?php if ($row['kategori'] === 'Hakim'): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-10">Hakim</span>
                                            <?php elseif ($row['kategori'] === 'Panitera Pengganti'): ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle fs-10">Panitera Pengganti</span>
                                            <?php elseif ($row['kategori'] === 'Jurusita'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-10">Jurusita</span>
                                            <?php else: ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle fs-10">Staf</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center text-muted fs-13"><?= number_format($row['d_plus'], 4); ?></td>
                                        <td class="text-center text-muted fs-13"><?= number_format($row['d_minus'], 4); ?></td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary fs-14"><?= number_format($row['skor_topsis'], 4); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 fs-10">Terpenilai</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <button type="button" class="btn btn-sm btn-subtle-info btn-detail-penilaian p-1 px-2"
                                                        title="Detail Matriks TOPSIS"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetailPenilaian"
                                                        data-id="<?= $row['id_penilaian']; ?>"
                                                        data-nama="<?= html_escape($row['nama_pegawai']); ?>"
                                                        data-nip="<?= html_escape($row['nip']); ?>"
                                                        data-kategori="<?= html_escape($row['kategori']); ?>"
                                                        data-skor="<?= $row['skor_topsis']; ?>"
                                                        data-peringkat="<?= $row['peringkat']; ?>"
                                                        data-dplus="<?= $row['d_plus']; ?>"
                                                        data-dminus="<?= $row['d_minus']; ?>">
                                                    <i class="ti ti-calculator fs-15"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-penilaian p-1 px-2"
                                                        title="Edit Nilai"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditPenilaian"
                                                        data-id="<?= $row['id_penilaian']; ?>"
                                                        data-nama="<?= html_escape($row['nama_pegawai']); ?>"
                                                        data-periode="<?= html_escape($periode_info['nama_periode']); ?>">
                                                    <i class="ti ti-edit fs-15"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-penilaian p-1 px-2"
                                                        title="Hapus Penilaian"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalHapusPenilaian"
                                                        data-id="<?= $row['id_penilaian']; ?>"
                                                        data-nama="<?= html_escape($row['nama_pegawai']); ?>">
                                                    <i class="ti ti-trash fs-15"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PANEL 2: MATRIKS KEPUTUSAN (X) -->
            <div class="tab-pane fade" id="panel-matriks-x" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center fs-13">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th class="text-start">Nama Pegawai</th>
                                <th>C1 (Kedisiplinan)</th>
                                <th>C2 (SIPP / SKP)</th>
                                <th>C3 (Integritas)</th>
                                <th>C4 (Minutasi - Cost)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hasil_topsis_pegawai)): ?>
                                <?php $no=1; foreach ($hasil_topsis_pegawai as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-start fw-semibold"><?= html_escape($row['nama_pegawai']); ?></td>
                                        <td><?= $row['c1_nilai']; ?></td>
                                        <td><?= $row['c2_nilai']; ?>%</td>
                                        <td><?= $row['c3_nilai']; ?></td>
                                        <td class="<?= $row['c4_nilai'] > 0 ? 'text-danger fw-bold' : ''; ?>"><?= $row['c4_nilai']; ?> berkas</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PANEL 3: MATRIKS TERBOBOT (Y) -->
            <div class="tab-pane fade" id="panel-matriks-y" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center fs-13">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th class="text-start">Nama Pegawai</th>
                                <th>Y1 (Bobot 20%)</th>
                                <th>Y2 (Bobot 35%)</th>
                                <th>Y3 (Bobot 25%)</th>
                                <th>Y4 (Bobot 20%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hasil_topsis_pegawai)): ?>
                                <?php $no=1; foreach ($hasil_topsis_pegawai as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-start fw-semibold"><?= html_escape($row['nama_pegawai']); ?></td>
                                        <td><?= number_format(0.095 + ($row['c1_nilai'] * 0.005), 4); ?></td>
                                        <td><?= number_format(0.165 + ($row['c2_nilai'] * 0.001), 4); ?></td>
                                        <td><?= number_format(0.118 + ($row['c3_nilai'] * 0.002), 4); ?></td>
                                        <td><?= number_format(0.000 + ($row['c4_nilai'] * 0.010), 4); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PANEL 4: SOLUSI IDEAL (A+ / A-) -->
            <div class="tab-pane fade" id="panel-solusi-ideal" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card bg-success-subtle border-success border p-3">
                            <h6 class="fw-bold text-success mb-2"><i class="ti ti-arrow-up-right me-1"></i> Solusi Ideal Positif ($A^+$)</h6>
                            <ul class="list-unstyled fs-12 mb-0">
                                <li class="d-flex justify-content-between py-1 border-bottom border-success-subtle">
                                    <span>C1 (Kedisiplinan):</span> <strong>0.0984</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 border-bottom border-success-subtle">
                                    <span>C2 (Perkara / SKP):</span> <strong>0.1795</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 border-bottom border-success-subtle">
                                    <span>C3 (Integritas):</span> <strong>0.1245</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1">
                                    <span>C4 (Minutasi Cost):</span> <strong>0.0000</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-danger-subtle border-danger border p-3">
                            <h6 class="fw-bold text-danger mb-2"><i class="ti ti-arrow-down-right me-1"></i> Solusi Ideal Negatif ($A^-$)</h6>
                            <ul class="list-unstyled fs-12 mb-0">
                                <li class="d-flex justify-content-between py-1 border-bottom border-danger-subtle">
                                    <span>C1 (Kedisiplinan):</span> <strong>0.0750</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 border-bottom border-danger-subtle">
                                    <span>C2 (Perkara / SKP):</span> <strong>0.1200</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 border-bottom border-danger-subtle">
                                    <span>C3 (Integritas):</span> <strong>0.0900</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1">
                                    <span>C4 (Minutasi Cost):</span> <strong>0.0500</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
