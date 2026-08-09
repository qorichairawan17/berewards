<!-- Modal Tambah Audit Log -->
<div class="modal fade" id="modalTambahAudit" tabindex="-1" aria-labelledby="modalTambahAuditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahAuditLabel">
                    <i class="ti ti-plus text-primary me-2"></i>Catat Log Aktivitas Audit Manual
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahAudit">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Username Pengguna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" placeholder="Contoh: superadmin" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Nama Lengkap User <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_user" placeholder="Contoh: Administrator Utama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Modul Terkait <span class="text-danger">*</span></label>
                            <select class="form-select" name="modul" required>
                                <option value="" selected disabled>-- Pilih Modul --</option>
                                <option value="Autentikasi Login">Autentikasi Login</option>
                                <option value="Data Pegawai">Data Pegawai</option>
                                <option value="Kriteria Penilaian">Kriteria Penilaian</option>
                                <option value="Periode Penilaian">Periode Penilaian</option>
                                <option value="Penilaian & TOPSIS">Penilaian & TOPSIS</option>
                                <option value="Laporan & Berita Acara">Laporan & Berita Acara</option>
                                <option value="Manajemen Pengguna">Manajemen Pengguna</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs-12">Status Hasil <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="Sukses" selected>Sukses</option>
                                <option value="Gagal">Gagal / Peringatan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark fs-12">Deskripsi Aktivitas Audit <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="aktivitas" rows="3" placeholder="Jelaskan secara spesifik tindakan atau transaksi pengguna..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Audit Log</button>
                </div>
            </form>
        </div>
    </div>
</div>
