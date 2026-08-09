<!-- Modal Hapus Kriteria -->
<div class="modal fade" id="modalHapusKriteria" tabindex="-1" aria-labelledby="modalHapusKriteriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-danger-subtle text-danger">
                <h5 class="modal-title fw-bold" id="modalHapusKriteriaLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus Kriteria
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="text-danger mb-3">
                    <i class="ti ti-trash fs-40"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2">Apakah Anda yakin ingin menonaktifkan kriteria ini?</h6>
                <p class="text-muted fs-13 mb-0" id="delete_nama_kriteria">-</p>
                <small class="text-muted fs-11 d-block mt-2">Kriteria yang sudah dipakai di proses lama tetap tersimpan secara snapshot.</small>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnKonfirmasiHapusKriteria">Ya, Nonaktifkan</button>
            </div>
        </div>
    </div>
</div>
