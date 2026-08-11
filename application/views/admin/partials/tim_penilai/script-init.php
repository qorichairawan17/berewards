<!-- Page Script Tim Penilai -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize DataTables
    if ($.fn.DataTable) {
        $('#tableTimPenilai').DataTable({
            language: {
                search: "Cari SK:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data SK",
                infoEmpty: "Tidak ada data",
                zeroRecords: "SK Tim Penilai tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[2, 'desc']] // Default order by Tahun descending
        });
    }

    // Template HTML Baris Anggota Tim Penilai Baru
    function createMemberRowHtml(prefix) {
        prefix = prefix || 'anggota';
        return '<div class="member-row p-3 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-2 mb-2">' +
            '<div class="flex-grow-1" style="min-width: 250px;">' +
                '<label class="form-label fw-semibold text-dark fs-11 mb-1">Nama & NIP Pegawai Anggota</label>' +
                '<select class="form-select form-select-sm" name="' + prefix + '_pegawai[]" required>' +
                    '<option value="">-- Pilih Pegawai Anggota Tim --</option>' +
                    '<option value="2">Hj. Fitriani, S.H., M.H. (Wakil Ketua PN)</option>' +
                    '<option value="4">Bambang Wijaya, S.H., M.H. (Panitera PN)</option>' +
                    '<option value="9">Dewi Sartika, S.H. (Kasubbag Kepegawaian)</option>' +
                    '<option value="7">Eko Prasetyo, S.H. (Jurusita)</option>' +
                    '<option value="8">Nurfadillah, S.E. (Staf)</option>' +
                    '<option value="3">Rizky Ramadhan, S.H. (Hakim Pratama)</option>' +
                    '<option value="6">Siti Aminah, A.Md. (Panitera Pengganti)</option>' +
                '</select>' +
            '</div>' +
            '<div class="flex-grow-1" style="min-width: 220px;">' +
                '<label class="form-label fw-semibold text-dark fs-11 mb-1">Kategori / Peran Penilaian</label>' +
                '<select class="form-select form-select-sm" name="' + prefix + '_peran[]" required>' +
                    '<option value="Penilai Kategori Hakim">Penilai Kategori Hakim</option>' +
                    '<option value="Penilai Kategori Panitera Pengganti">Penilai Kategori Panitera Pengganti</option>' +
                    '<option value="Penilai Kategori Jurusita">Penilai Kategori Jurusita</option>' +
                    '<option value="Penilai Kategori Staf">Penilai Kategori Staf</option>' +
                    '<option value="Penilai Seluruh Kategori">Penilai Seluruh Kategori</option>' +
                '</select>' +
            '</div>' +
            '<div class="align-self-end">' +
                '<button type="button" class="btn btn-sm btn-outline-danger btn-remove-member-row" title="Hapus Baris Anggota">' +
                    '<i class="ti ti-trash"></i>' +
                '</button>' +
            '</div>' +
        '</div>';
    }

    // Tambah Baris Anggota pada Modal Tambah
    $('#btnAddAddMemberRow').on('click', function() {
        $('#addMemberListContainer').append(createMemberRowHtml('anggota'));
    });

    // Tambah Baris Anggota pada Modal Edit
    $('#btnEditAddMemberRow').on('click', function() {
        $('#editMemberListContainer').append(createMemberRowHtml('edit_anggota'));
    });

    // Hapus Baris Anggota (Delegasi Event)
    $(document).on('click', '.btn-remove-member-row', function() {
        var container = $(this).closest('.d-flex.flex-column');
        var rowCount = container.find('.member-row').length;
        if (rowCount > 1) {
            $(this).closest('.member-row').remove();
        } else {
            alert('Minimal harus ada 1 anggota tim penilai.');
        }
    });

    // 2. Edit Button Handler
    $(document).on('click', '.btn-edit-tim', function() {
        var id = $(this).data('id');
        var nosk = $(this).data('nosk');
        var tahun = $(this).data('tahun');
        var tanggal = $(this).data('tanggal');
        var perihal = $(this).data('perihal');
        var status = $(this).data('status');

        $('#edit_id_sk').val(id);
        $('#edit_no_sk').val(nosk);
        $('#edit_tahun').val(tahun);
        $('#edit_tanggal_sk').val(tanggal);
        $('#edit_perihal').val(perihal);
        $('#edit_status').val(status);
    });

    // 3. Detail Quick Preview Button Handler
    $(document).on('click', '.btn-detail-tim', function() {
        var id = $(this).data('id');
        var nosk = $(this).data('nosk');
        var tahun = $(this).data('tahun');
        var tanggal = $(this).data('tanggal');
        var perihal = $(this).data('perihal');
        var status = $(this).data('status');
        var ketua = $(this).data('ketua');
        var sekretaris = $(this).data('sekretaris');

        $('#preview_no_sk').text(nosk);
        $('#preview_tahun').text(tahun);
        $('#preview_tanggal_sk').text(tanggal);
        $('#preview_perihal').text(perihal);
        $('#preview_ketua_nama').text(ketua || '-');
        $('#preview_sekretaris_nama').text(sekretaris || '-');

        // Set detail page link
        $('#btnFullDetailLink').attr('href', '<?= site_url("timpenilai/detail/"); ?>' + id);

        var badgeClass = 'bg-secondary';
        if (status === 'Aktif') badgeClass = 'bg-success';
        else if (status === 'Selesai') badgeClass = 'bg-info';

        $('#preview_status_badge').attr('class', 'badge rounded-pill px-2 py-1 fs-11 mt-1 ' + badgeClass).text(status);
    });

    // 4. Delete Button Handler
    $(document).on('click', '.btn-delete-tim', function() {
        var nosk = $(this).data('nosk');
        $('#delete_no_sk').text(nosk);
    });

    // 5. Submit Form Handlers (Demo presentation response)
    $('#formTambahTim').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalTambahTim');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! SK Tim Penilai baru dengan anggota terdaftar berhasil ditambahkan.');
        this.reset();
    });

    $('#formEditTim').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalEditTim');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Perubahan SK & Anggota Tim Penilai berhasil disimpan.');
    });

    $('#btnKonfirmasiHapusTim').on('click', function() {
        var modalEl = document.getElementById('modalHapusTim');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! SK Tim Penilai telah diarsipkan.');
    });
});
</script>
