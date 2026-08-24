<!-- Toast Container (Top Right Placement Referencing auth/signin.php) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
    <div id="toastNotification" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2.5 p-3 text-white">
                <i id="toastIcon" class="fs-22 me-1 text-white"></i>
                <div class="text-white">
                    <strong id="toastTitle" class="d-block fs-13 fw-bold mb-0.5 text-white"></strong>
                    <span id="toastText" class="fs-12 text-white"></span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/user/header-banner'); ?>
<?php $this->load->view('admin/partials/user/stats-cards'); ?>

<!-- DataTables Main Panel -->
<section class="card panel-card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-primary fw-bold fs-11 text-uppercase tracking-wider">Tabel Pengaturan</span>
                <h4 class="fw-bold text-dark mb-0">Daftar Pengguna Sistem SPK BeRewards</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tableUser" class="table table-hover table-bordered align-middle dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Akun Pengguna</th>
                        <th>Pegawai Terhubung</th>
                        <th>Email Instansi</th>
                        <th>Hak Akses Role</th>
                        <th>Login Terakhir</th>
                        <th>Status</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($user_list)): ?>
                        <?php $no = 1; foreach ($user_list as $row): ?>
                            <?php 
                                $r = strtolower(trim($row['role'])); 
                                $formatted_login = !empty($row['last_login']) ? date('d M Y H:i', strtotime($row['last_login'])) : '-';
                                $kat = !empty($row['kategori']) ? $row['kategori'] : '';
                            ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <strong class="d-block text-dark fs-13"><?= html_escape(isset($row['nama_user']) ? $row['nama_user'] : $row['nama_lengkap']); ?></strong>
                                    <small class="text-muted fs-11">@<?= html_escape($row['username']); ?></small>
                                </td>
                                <td>
                                    <?php if (!empty($row['id_pegawai']) && !empty($row['nama_pegawai'])): ?>
                                        <strong class="d-block text-dark fs-13"><?= html_escape($row['nama_pegawai']); ?></strong>
                                        <div class="d-flex align-items-center gap-1.5 mt-0.5">
                                            <span class="badge bg-light text-muted border px-1.5 py-0.5 fs-10 font-monospace">NIP: <?= html_escape($row['nip']); ?></span>
                                            <?php if ($kat === 'Hakim'): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-1.5 py-0.5 fs-10">Hakim</span>
                                            <?php elseif ($kat === 'Panitera Pengganti'): ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle px-1.5 py-0.5 fs-10">PP</span>
                                            <?php elseif ($kat === 'Jurusita'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-1.5 py-0.5 fs-10">Jurusita</span>
                                            <?php elseif ($kat === 'Staf'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-1.5 py-0.5 fs-10">Staf</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted fs-12 fst-italic">Belum ditautkan</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= !empty($row['email']) ? html_escape($row['email']) : '-'; ?></td>
                                <td>
                                    <?php if ($r === 'superadmin'): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-11">Superadmin</span>
                                    <?php elseif ($r === 'pimpinan'): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11">Pimpinan</span>
                                    <?php elseif ($r === 'tim_penilai'): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">Tim Penilai</span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-11">Administrator</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-dark fw-medium d-block"><?= $formatted_login; ?></small>
                                </td>
                                <td>
                                    <?php if (isset($row['status']) ? $row['status'] == 1 : (isset($row['aktif']) && $row['aktif'] == 1)): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-subtle-info btn-detail-user p-1 px-2"
                                                title="Profil User"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailUser"
                                                data-id="<?= $row['id_user']; ?>"
                                                data-id_pegawai="<?= !empty($row['id_pegawai']) ? $row['id_pegawai'] : ''; ?>"
                                                data-nama_pegawai="<?= !empty($row['nama_pegawai']) ? html_escape($row['nama_pegawai']) : ''; ?>"
                                                data-nip="<?= !empty($row['nip']) ? html_escape($row['nip']) : ''; ?>"
                                                data-jabatan="<?= !empty($row['jabatan']) ? html_escape($row['jabatan']) : ''; ?>"
                                                data-kategori="<?= !empty($row['kategori']) ? html_escape($row['kategori']) : ''; ?>"
                                                data-pangkat="<?= !empty($row['pangkat']) ? html_escape($row['pangkat']) : ''; ?>"
                                                data-golongan="<?= !empty($row['golongan']) ? html_escape($row['golongan']) : ''; ?>"
                                                data-username="<?= html_escape($row['username']); ?>"
                                                data-nama="<?= html_escape(isset($row['nama_user']) ? $row['nama_user'] : $row['nama_lengkap']); ?>"
                                                data-email="<?= html_escape($row['email']); ?>"
                                                data-role="<?= html_escape($row['role']); ?>"
                                                data-status="<?= isset($row['status']) ? $row['status'] : $row['aktif']; ?>"
                                                data-login="<?= $formatted_login; ?>">
                                            <i class="ti ti-eye fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-primary-subtle text-primary btn-edit-user p-1 px-2"
                                                title="Edit User"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditUser"
                                                data-id="<?= $row['id_user']; ?>"
                                                data-id_pegawai="<?= !empty($row['id_pegawai']) ? $row['id_pegawai'] : ''; ?>"
                                                data-nama_pegawai="<?= !empty($row['nama_pegawai']) ? html_escape($row['nama_pegawai']) : ''; ?>"
                                                data-nip="<?= !empty($row['nip']) ? html_escape($row['nip']) : ''; ?>"
                                                data-jabatan="<?= !empty($row['jabatan']) ? html_escape($row['jabatan']) : ''; ?>"
                                                data-kategori="<?= !empty($row['kategori']) ? html_escape($row['kategori']) : ''; ?>"
                                                data-username="<?= html_escape($row['username']); ?>"
                                                data-nama="<?= html_escape(isset($row['nama_user']) ? $row['nama_user'] : $row['nama_lengkap']); ?>"
                                                data-email="<?= html_escape($row['email']); ?>"
                                                data-role="<?= html_escape($row['role']); ?>"
                                                data-status="<?= isset($row['status']) ? $row['status'] : $row['aktif']; ?>">
                                            <i class="ti ti-edit fs-15"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-danger-subtle text-danger btn-delete-user p-1 px-2"
                                                title="Hapus / Nonaktifkan User"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusUser"
                                                data-id="<?= $row['id_user']; ?>"
                                                data-nama="<?= html_escape(isset($row['nama_user']) ? $row['nama_user'] : $row['nama_lengkap']); ?>">
                                            <i class="ti ti-trash fs-15"></i>
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
</section>

<!-- Modals -->
<?php $this->load->view('admin/partials/user/modal-add'); ?>
<?php $this->load->view('admin/partials/user/modal-edit'); ?>
<?php $this->load->view('admin/partials/user/modal-detail'); ?>
<?php $this->load->view('admin/partials/user/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/user/script-init'); ?>
