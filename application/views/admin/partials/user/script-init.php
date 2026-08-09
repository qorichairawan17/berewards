<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tableUser').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Pengguna sistem tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true
        });
    }

    // 2. Edit Button Handler
    $(document).on('click', '.btn-edit-user', function() {
        var id = $(this).data('id');
        var username = $(this).data('username');
        var nama = $(this).data('nama');
        var email = $(this).data('email');
        var role = $(this).data('role');
        var status = $(this).data('status');

        $('#edit_id_user').val(id);
        $('#edit_username').val(username);
        $('#edit_nama_user').val(nama);
        $('#edit_email').val(email);
        $('#edit_role').val(role);
        $('#edit_status').val(status);
    });

    // 3. Detail Button Handler
    $(document).on('click', '.btn-detail-user', function() {
        var username = $(this).data('username');
        var nama = $(this).data('nama');
        var email = $(this).data('email');
        var role = $(this).data('role');
        var status = $(this).data('status');
        var login = $(this).data('login');

        $('#detail_nama_user').text(nama);
        $('#detail_username_user').text('@' + username);
        $('#detail_email_user').text(email);
        $('#detail_last_login').text(login);

        if (role === 'Superadmin') {
            $('#detail_role_badge').html('<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-11">Superadmin</span>');
        } else if (role === 'Pimpinan') {
            $('#detail_role_badge').html('<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11">Pimpinan</span>');
        } else if (role === 'Tim Penilai') {
            $('#detail_role_badge').html('<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">Tim Penilai</span>');
        } else {
            $('#detail_role_badge').html('<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-11">Administrator</span>');
        }

        if (status == 1) {
            $('#detail_status_badge').html('<span class="badge bg-success rounded-pill px-2 py-1 fs-10">Aktif</span>');
        } else {
            $('#detail_status_badge').html('<span class="badge bg-secondary rounded-pill px-2 py-1 fs-10">Nonaktif</span>');
        }
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-user', function() {
        var nama = $(this).data('nama');
        $('#delete_nama_user').text(nama);
    });

    // 5. Submit Form Demo Feedback
    $('#formTambahUser').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahUser');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Pengguna baru berhasil ditambahkan.');
        this.reset();
    });

    $('#formEditUser').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditUser');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Perubahan data pengguna berhasil disimpan.');
    });

    $('#btnKonfirmasiHapusUser').on('click', function() {
        var modalEl = document.getElementById('modalHapusUser');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Akun pengguna telah dinonaktifkan.');
    });
});
</script>
