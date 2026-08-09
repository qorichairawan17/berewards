<!-- Modal Detail Matriks & TOPSIS -->
<div class="modal fade" id="modalDetailPenilaian" tabindex="-1" aria-labelledby="modalDetailPenilaianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailPenilaianLabel">
                    <i class="ti ti-calculator text-primary me-2"></i>Rincian Matriks TOPSIS Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                    <div>
                        <span class="d-block text-muted fs-11" id="detail_nip_pegawai">-</span>
                        <h5 class="fw-bold text-dark mb-0" id="detail_nama_pegawai">-</h5>
                        <small class="text-primary fw-semibold" id="detail_kategori_pegawai">-</small>
                    </div>
                    <div class="text-end">
                        <span class="d-block text-muted fs-11">Skor Preferensi V_i</span>
                        <h3 class="fw-bold text-primary mb-0" id="detail_skor_topsis">0.000</h3>
                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10" id="detail_peringkat_badge">Peringkat 1</span>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered text-center align-middle fs-12 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <th>Nilai Rill (X)</th>
                                <th>Normalisasi (R)</th>
                                <th>Terbobot (Y)</th>
                                <th>Jarak Positif D+</th>
                                <th>Jarak Negatif D-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">C1: Kedisiplinan</td>
                                <td>4.8</td>
                                <td>0.485</td>
                                <td>0.097</td>
                                <td rowspan="4" class="fw-bold text-danger align-middle" id="detail_d_plus">0.0215</td>
                                <td rowspan="4" class="fw-bold text-success align-middle" id="detail_d_minus">0.3482</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">C2: Perkara / SKP</td>
                                <td>95.5%</td>
                                <td>0.512</td>
                                <td>0.179</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">C3: Integritas</td>
                                <td>4.9</td>
                                <td>0.490</td>
                                <td>0.1225</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">C4: Minutasi (Cost)</td>
                                <td>0 berkas</td>
                                <td>0.000</td>
                                <td>0.0000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-2 mb-0 fs-12">
                    <i class="ti ti-info-circle fs-18"></i>
                    <div>
                        <strong>Rumus Preferensi TOPSIS:</strong> $V_i = \frac{D_i^-}{D_i^+ + D_i^-}$. Semakin mendekati angka 1.0, semakin baik performa pegawai tersebut.
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
