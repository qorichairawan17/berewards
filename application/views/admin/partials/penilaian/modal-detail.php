<!-- Modal Detail Matriks & TOPSIS -->
<div class="modal fade" id="modalDetailPenilaian" tabindex="-1" aria-labelledby="modalDetailPenilaianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailPenilaianLabel">
                    <i class="ti ti-calculator text-primary me-2"></i>Rincian Matriks Penilaian Pegawai
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
                        <span class="d-block text-muted fs-11">Skor Preferensi</span>
                        <h3 class="fw-bold text-primary mb-0" id="detail_skor_topsis">0.0000</h3>
                        <span class="badge bg-success rounded-pill px-2.5 py-1 fs-11" id="detail_peringkat_badge">Peringkat #1</span>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered text-center align-middle fs-12 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria Penilaian</th>
                                <th>Nilai Rill (X)</th>
                                <th>Normalisasi (R)</th>
                                <th>Terbobot (Y)</th>
                                <th>Jarak Positif (D+)</th>
                                <th>Jarak Negatif (D-)</th>
                            </tr>
                        </thead>
                        <tbody id="detail_matrix_tbody">
                            <tr>
                                <td colspan="6" class="text-muted py-3">Memuat rincian matriks perhitungan TOPSIS...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="p-2.5 bg-danger-subtle text-danger border border-danger-subtle rounded d-flex justify-content-between align-items-center fs-12">
                            <span><i class="ti ti-arrow-down-right me-1"></i> Jarak ke Solusi Ideal Positif (D+):</span>
                            <strong class="font-monospace fs-13" id="detail_box_dplus">0.0000</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2.5 bg-success-subtle text-success border border-success-subtle rounded d-flex justify-content-between align-items-center fs-12">
                            <span><i class="ti ti-arrow-up-right me-1"></i> Jarak ke Solusi Ideal Negatif (D-):</span>
                            <strong class="font-monospace fs-13" id="detail_box_dminus">0.0000</strong>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-2 mb-0 fs-12">
                    <i class="ti ti-info-circle fs-18 flex-shrink-0 text-info"></i>
                    <div>
                        <strong>Metode Penilaian TOPSIS:</strong> Skor preferensi dihitung berdasarkan kedekatan relatif alternatif terhadap Solusi Ideal Positif (A+) dan jarak terjauh dari Solusi Ideal Negatif (A-). Nilai yang semakin mendekati 1.0 menunjukkan kinerja pegawai yang semakin unggul.
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
