<!-- Modal Hapus / Arsip Berita Acara -->
<div class="modal fade" id="modalHapusLaporan" tabindex="-1" aria-labelledby="modalHapusLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-danger-subtle text-danger">
                <h5 class="modal-title fw-bold" id="modalHapusLaporanLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus Berita Acara
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="text-danger mb-3">
                    <i class="ti ti-trash fs-40"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2">Apakah Anda yakin ingin menghapus dokumen ini?</h6>
                <p class="text-muted fs-13 mb-0" id="delete_no_ba">-</p>
                <small class="text-muted fs-11 d-block mt-2">Dokumen Berita Acara yang dihapus akan dipindahkan ke folder Arsip sistem.</small>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnKonfirmasiHapusLaporan">Ya, Hapus Dokumen</button>
            </div>
        </div>
    </div>
</div>
