<!-- Modal Hapus SK Tim Penilai -->
<div class="modal fade" id="modalHapusTim" tabindex="-1" aria-labelledby="modalHapusTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white p-3">
                <h5 class="modal-header-title fw-bold text-white mb-0 fs-16" id="modalHapusTimLabel">
                    <i class="ti ti-alert-triangle me-1"></i> Konfirmasi Hapus SK Tim Penilai
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="avatar-lg rounded-circle bg-danger bg-opacity-10 text-danger mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
                    <i class="ti ti-trash fs-30"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Apakah Anda yakin ingin menghapus SK ini?</h5>
                <p class="text-muted fs-13 mb-3">
                    SK Penetapan Nomor: <strong class="text-dark d-block fs-14 mt-1" id="delete_no_sk">-</strong>
                </p>
                <div class="alert alert-warning text-start mb-0 p-2 fs-11">
                    <i class="ti ti-info-circle me-1"></i> Tindakan ini akan mengarsipkan SK dari daftar aktif sistem SPK BeRewards.
                </div>
            </div>
            <div class="modal-footer bg-light p-3 border-top d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger px-4 shadow-sm" id="btnKonfirmasiHapusTim">
                    <i class="ti ti-trash me-1"></i> Ya, Hapus SK
                </button>
            </div>
        </div>
    </div>
</div>
