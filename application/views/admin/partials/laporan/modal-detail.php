<!-- Modal Preview Official Berita Acara -->
<div class="modal fade" id="modalDetailLaporan" tabindex="-1" aria-labelledby="modalDetailLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailLaporanLabel">
                    <i class="ti ti-file-certificate text-primary me-2"></i>Pratinjau Resmi Berita Acara Penetapan TOPSIS
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <!-- Official Court Letterhead -->
                <div class="text-center border-bottom border-2 border-dark pb-3 mb-4">
                    <h6 class="fw-bold mb-0 text-dark text-uppercase tracking-wider"><?= html_escape(!empty($satker['kop_line1']) ? $satker['kop_line1'] : 'PENGADILAN NEGERI LUBUK PAKAM KELAS I-A'); ?></h6>
                    <small class="d-block text-muted fs-11"><?= html_escape(!empty($satker['alamat']) ? $satker['alamat'] : 'Jl. Sisingamangaraja No. 182, Lubuk Pakam'); ?></small>
                    <small class="d-block text-muted fs-11">Website: <?= html_escape(!empty($satker['website']) ? $satker['website'] : 'pn-lubukpakam.go.id'); ?> | Email: <?= html_escape(!empty($satker['email']) ? $satker['email'] : 'pn.lubukpakam@mahkamahagung.go.id'); ?></small>
                </div>

                <div class="text-center mb-4">
                    <h5 class="fw-bold text-dark mb-1 text-uppercase text-decoration-underline">BERITA ACARA PENETAPAN REWARD PEGAWAI TERBAIK</h5>
                    <p class="text-muted fs-12 mb-0" id="preview_no_ba">Nomor: -</p>
                </div>

                <p class="fs-13 text-dark leading-relaxed mb-3">
                    Pada hari ini, tanggal <strong id="preview_tanggal_terbit">-</strong>, Tim Penilai Kinerja telah melaksanakan rapat pleno penetapan reward pegawai menggunakan Sistem Pendukung Keputusan metode <strong>TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)</strong> untuk periode <strong id="preview_periode">-</strong>.
                </p>

                <!-- 3 Best Reward Candidates Table -->
                <div class="card bg-white border p-3 mb-4 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="ti ti-trophy text-warning me-1"></i> Daftar 3 Kandidat Reward Terbaik (Hasil TOPSIS)
                        </h6>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11" id="preview_kategori">Kategori</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0 fs-12">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;" class="text-center">Peringkat</th>
                                    <th>Nama Pegawai & NIP</th>
                                    <th>Kategori</th>
                                    <th style="width: 140px;" class="text-center">Skor Preferensi</th>
                                    <th style="width: 120px;" class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="preview_top3_tbody">
                                <!-- Populated dynamically via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row g-3 text-center mt-4 pt-3 border-top">
                    <div class="col-6">
                        <small class="d-block text-muted fs-11">Mengetahui,</small>
                        <strong class="d-block text-dark fs-12">Ketua Pengadilan Negeri <?= html_escape(!empty($satker['singkatan']) ? $satker['singkatan'] : 'Lubuk Pakam'); ?></strong>
                        <div style="height: 50px;"></div>
                        <u class="fw-bold text-dark fs-12"><?= html_escape(!empty($satker['nama_ketua']) ? $satker['nama_ketua'] : (!empty($pimpinan['ketua']['nama']) ? $pimpinan['ketua']['nama'] : "Dr. H. Ahmad Syafi'i, S.H., M.H.")); ?></u>
                    </div>
                    <div class="col-6">
                        <small class="d-block text-muted fs-11">Ketua Tim Penilai,</small>
                        <strong class="d-block text-dark fs-12">Reward Aparatur Pengadilan</strong>
                        <div style="height: 50px;"></div>
                        <u class="fw-bold text-dark fs-12" id="preview_ketua">Bambang Wijaya, S.H., M.H.</u>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-brand btn-sm" id="btnDownloadWordDetail">
                    <i class="ti ti-file-text me-1"></i> Ekspor Word (.docx)
                </button>
            </div>
        </div>
    </div>
</div>