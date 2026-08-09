<!-- Modal Hapus Pegawai -->
<div class="modal fade" id="modalHapusPegawai" tabindex="-1" aria-labelledby="modalHapusPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-danger-subtle text-danger">
                <h5 class="modal-title fw-bold" id="modalHapusPegawaiLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="text-danger mb-3">
                    <i class="ti ti-trash fs-40"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2">Apakah Anda yakin ingin menghapus pegawai ini?</h6>
                <p class="text-muted fs-13 mb-0" id="delete_nama_pegawai">-</p>
                <small class="text-muted fs-11 d-block mt-2">Tindakan ini akan menonaktifkan data dari referensi TOPSIS.</small>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">Ya, Hapus Data</button>
            </div>
        </div>
    </div>
</div>
