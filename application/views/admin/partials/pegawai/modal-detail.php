<!-- Modal Detail Pegawai -->
<div class="modal fade" id="modalDetailPegawai" tabindex="-1" aria-labelledby="modalDetailPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailPegawaiLabel">
                    <i class="ti ti-id text-primary me-2"></i>Detail Profile Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="position-relative d-inline-block mb-3">
                    <img src="<?= base_url('assets/icons/logo.png'); ?>" id="detail_foto_img" alt="Foto Pegawai" class="rounded-circle border border-2 border-primary shadow-sm" style="width: 84px; height: 84px; object-fit: cover;" onerror="this.onerror=null;this.src='<?= base_url('assets/icons/logo.png'); ?>';">
                </div>
                <h5 class="fw-bold text-dark mb-1" id="detail_nama">-</h5>
                <p class="text-muted fs-12 mb-3" id="detail_nip">-</p>

                <div class="card bg-light border-0 p-3 text-start mb-0">
                    <div class="row g-3">
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Kategori Pegawai</span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11" id="detail_kategori_badge">-</span>
                        </div>
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Status Referensi</span>
                            <span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif (Kandidat TOPSIS)</span>
                        </div>
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Pangkat & Golongan</span>
                            <strong class="d-block text-dark fs-13" id="detail_pangkat_gol">-</strong>
                        </div>
                        <div class="col-6">
                            <span class="d-block text-muted fs-11">Jabatan Resmi</span>
                            <strong class="d-block text-dark fs-13" id="detail_jabatan">-</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
