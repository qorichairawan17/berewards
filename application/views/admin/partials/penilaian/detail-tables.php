<!-- Tabbed TOPSIS Results & Matrices -->
<div class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-header bg-light border-bottom p-3">
        <ul class="nav nav-pills card-header-pills gap-2" id="topsisTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold fs-13" id="tab-peringkat" data-bs-toggle="tab" data-bs-target="#panel-peringkat" type="button" role="tab">
                    <i class="ti ti-trophy me-1"></i> Peringkat & Hasil TOPSIS
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold fs-13" id="tab-matriks-x" data-bs-toggle="tab" data-bs-target="#panel-matriks-x" type="button" role="tab">
                    <i class="ti ti-table me-1"></i> Matriks Keputusan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold fs-13" id="tab-matriks-y" data-bs-toggle="tab" data-bs-target="#panel-matriks-y" type="button" role="tab">
                    <i class="ti ti-chart-arrows me-1"></i> Matriks Terbobot
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold fs-13" id="tab-solusi-ideal" data-bs-toggle="tab" data-bs-target="#panel-solusi-ideal" type="button" role="tab">
                    <i class="ti ti-target me-1"></i> Solusi Ideal
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
                                <th class="text-center">Jarak Positif (D+)</th>
                                <th class="text-center">Jarak Negatif (D-)</th>
                                <th class="text-center">Skor Preferensi</th>
                                <th class="text-center">Status</th>
                                <th style="width: 140px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hasil_topsis_pegawai)): ?>
                                <?php foreach ($hasil_topsis_pegawai as $row): ?>
                                    <?php
                                        $is_winner  = ($row['peringkat'] == 1);
                                        $kat        = isset($row['kategori']) ? $row['kategori'] : '';
                                        $row_alt_id = isset($row['id_proses_alternatif']) ? (int)$row['id_proses_alternatif'] : (isset($row['id']) ? (int)$row['id'] : 0);

                                        // Susun matrix data detail & scores
                                        $alt_matrix_data = array();
                                        $alt_scores      = array();
                                        if (!empty($kriteria_list)) {
                                            foreach ($kriteria_list as $kr) {
                                                $kr_id = (int)$kr['id_proses_kriteria'];
                                                $x_val = isset($penilaian_matrix[$row_alt_id][$kr_id]) ? (float)$penilaian_matrix[$row_alt_id][$kr_id] : (isset($matrices['matrix_x'][$row_alt_id][$kr_id]) ? (float)$matrices['matrix_x'][$row_alt_id][$kr_id] : 0.0);
                                                $r_val = isset($matrices['matrix_r'][$row_alt_id][$kr_id]) ? (float)$matrices['matrix_r'][$row_alt_id][$kr_id] : 0.0;
                                                $y_val = isset($matrices['matrix_y'][$row_alt_id][$kr_id]) ? (float)$matrices['matrix_y'][$row_alt_id][$kr_id] : 0.0;
                                                
                                                $alt_scores[$kr_id] = $x_val;
                                                $alt_matrix_data[] = array(
                                                    'id_kriteria'   => $kr_id,
                                                    'kode'          => $kr['kode'],
                                                    'nama_kriteria' => $kr['nama_kriteria'],
                                                    'tipe_atribut'  => $kr['tipe_atribut'],
                                                    'x'             => $x_val,
                                                    'r'             => number_format($r_val, 4),
                                                    'y'             => number_format($y_val, 4)
                                                );
                                            }
                                        }
                                    ?>
                                    <tr class="<?= $is_winner ? 'table-warning-subtle' : ''; ?>">
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
                                            <strong class="d-block text-dark fs-13"><?= html_escape(isset($row['nama_pegawai']) ? $row['nama_pegawai'] : (isset($row['nama']) ? $row['nama'] : '')); ?></strong>
                                            <small class="text-muted fs-11">NIP. <?= html_escape($row['nip']); ?></small>
                                        </td>
                                        <td>
                                            <span class="d-block text-dark fs-13"><?= html_escape($row['jabatan']); ?></span>
                                            <?php if ($kat === 'Hakim'): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-10">Hakim</span>
                                            <?php elseif ($kat === 'Panitera Pengganti'): ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle fs-10">Panitera Pengganti</span>
                                            <?php elseif ($kat === 'Jurusita'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-10">Jurusita</span>
                                            <?php elseif ($kat === 'Staf'): ?>
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
                                                        title="Detail Matriks Penilaian"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetailPenilaian"
                                                        data-id="<?= $row_alt_id; ?>"
                                                        data-nama="<?= html_escape(isset($row['nama_pegawai']) ? $row['nama_pegawai'] : (isset($row['nama']) ? $row['nama'] : '')); ?>"
                                                        data-nip="<?= html_escape($row['nip']); ?>"
                                                        data-kategori="<?= html_escape($kat); ?>"
                                                        data-skor="<?= $row['skor_topsis']; ?>"
                                                        data-peringkat="<?= $row['peringkat']; ?>"
                                                        data-dplus="<?= $row['d_plus']; ?>"
                                                        data-dminus="<?= $row['d_minus']; ?>"
                                                        data-matrix='<?= htmlspecialchars(json_encode($alt_matrix_data), ENT_QUOTES, 'UTF-8'); ?>'>
                                                    <i class="ti ti-calculator fs-15"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-penilaian p-1 px-2"
                                                        title="Edit Nilai Alternative"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditPenilaian"
                                                        data-id_alternatif="<?= $row_alt_id; ?>"
                                                        data-id_proses="<?= $id_proses; ?>"
                                                        data-nama="<?= html_escape(isset($row['nama_pegawai']) ? $row['nama_pegawai'] : (isset($row['nama']) ? $row['nama'] : '')); ?>"
                                                        data-periode="<?= html_escape($periode_info['nama_periode']); ?>"
                                                        data-scores='<?= htmlspecialchars(json_encode($alt_scores), ENT_QUOTES, 'UTF-8'); ?>'>
                                                    <i class="ti ti-edit fs-15"></i>
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
                                <th style="width: 50px;">No</th>
                                <th class="text-start">Nama Pegawai Alternatif</th>
                                <?php if (!empty($kriteria_list)): ?>
                                    <?php foreach ($kriteria_list as $kr): ?>
                                        <th>
                                            <?= html_escape($kr['kode']); ?>
                                            <small class="d-block text-muted fs-11 fw-normal">(<?= html_escape($kr['nama_kriteria']); ?>)</small>
                                        </th>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($alternatif_list)): ?>
                                <?php $no=1; foreach ($alternatif_list as $alt): ?>
                                    <?php $alt_id = (int)$alt['id_proses_alternatif']; ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-start fw-semibold"><?= html_escape($alt['nama_snapshot']); ?></td>
                                        <?php if (!empty($kriteria_list)): ?>
                                            <?php foreach ($kriteria_list as $kr): ?>
                                                <?php
                                                    $krit_id = (int)$kr['id_proses_kriteria'];
                                                    $val = isset($penilaian_matrix[$alt_id][$krit_id]) ? $penilaian_matrix[$alt_id][$krit_id] : (isset($matrices['matrix_x'][$alt_id][$krit_id]) ? $matrices['matrix_x'][$alt_id][$krit_id] : 0);
                                                ?>
                                                <td><?= is_numeric($val) ? (float)$val : $val; ?></td>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
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
                                <th style="width: 50px;">No</th>
                                <th class="text-start">Nama Pegawai Alternatif</th>
                                <?php if (!empty($kriteria_list)): ?>
                                    <?php foreach ($kriteria_list as $kr): ?>
                                        <th>
                                            <?= 'Y_' . html_escape($kr['kode']); ?>
                                            <small class="d-block text-muted fs-11 fw-normal">(Bobot <?= (float)$kr['bobot']; ?>%)</small>
                                        </th>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($alternatif_list)): ?>
                                <?php $no=1; foreach ($alternatif_list as $alt): ?>
                                    <?php $alt_id = (int)$alt['id_proses_alternatif']; ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-start fw-semibold"><?= html_escape($alt['nama_snapshot']); ?></td>
                                        <?php if (!empty($kriteria_list)): ?>
                                            <?php foreach ($kriteria_list as $kr): ?>
                                                <?php
                                                    $krit_id = (int)$kr['id_proses_kriteria'];
                                                    $y_val = isset($matrices['matrix_y'][$alt_id][$krit_id]) ? $matrices['matrix_y'][$alt_id][$krit_id] : 0.0;
                                                ?>
                                                <td><?= number_format($y_val, 4); ?></td>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PANEL 4: SOLUSI IDEAL -->
            <div class="tab-pane fade" id="panel-solusi-ideal" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card bg-success-subtle border-success border p-3 h-100">
                            <h6 class="fw-bold text-success mb-2"><i class="ti ti-arrow-up-right me-1"></i> Solusi Ideal Positif (A+)</h6>
                            <ul class="list-unstyled fs-12 mb-0">
                                <?php if (!empty($kriteria_list)): ?>
                                    <?php foreach ($kriteria_list as $kr): ?>
                                        <?php
                                            $krit_id = (int)$kr['id_proses_kriteria'];
                                            $a_plus = isset($matrices['ideal_positive'][$krit_id]) ? $matrices['ideal_positive'][$krit_id] : 0.0;
                                        ?>
                                        <li class="d-flex justify-content-between py-1.5 border-bottom border-success-subtle">
                                            <span><?= html_escape($kr['kode']); ?> (<?= html_escape($kr['nama_kriteria']); ?> - <strong class="text-uppercase"><?= $kr['tipe_atribut']; ?></strong>):</span>
                                            <strong class="font-monospace fs-13"><?= number_format($a_plus, 4); ?></strong>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-danger-subtle border-danger border p-3 h-100">
                            <h6 class="fw-bold text-danger mb-2"><i class="ti ti-arrow-down-right me-1"></i> Solusi Ideal Negatif (A-)</h6>
                            <ul class="list-unstyled fs-12 mb-0">
                                <?php if (!empty($kriteria_list)): ?>
                                    <?php foreach ($kriteria_list as $kr): ?>
                                        <?php
                                            $krit_id = (int)$kr['id_proses_kriteria'];
                                            $a_min = isset($matrices['ideal_negative'][$krit_id]) ? $matrices['ideal_negative'][$krit_id] : 0.0;
                                        ?>
                                        <li class="d-flex justify-content-between py-1.5 border-bottom border-danger-subtle">
                                            <span><?= html_escape($kr['kode']); ?> (<?= html_escape($kr['nama_kriteria']); ?> - <strong class="text-uppercase"><?= $kr['tipe_atribut']; ?></strong>):</span>
                                            <strong class="font-monospace fs-13"><?= number_format($a_min, 4); ?></strong>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
