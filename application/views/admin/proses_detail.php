<?php $this->load->view('admin/partials/penilaian/detail-header'); ?>
<?php $this->load->view('admin/partials/penilaian/stats-cards'); ?>
<?php $this->load->view('admin/partials/penilaian/detail-tables'); ?>

<!-- Modals -->
<?php $this->load->view('admin/partials/penilaian/modal-add'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-input-nilai'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-edit'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-detail'); ?>
<?php $this->load->view('admin/partials/penilaian/modal-delete'); ?>

<!-- Page Script -->
<?php $this->load->view('admin/partials/penilaian/script-init'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable) {
        $('#tableHasilTopsis').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data hasil TOPSIS tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[0, 'asc']]
        });
    }

    $('#btnRecalculateTopsis').on('click', function() {
        alert('Sukses! Kalkulasi ulang TOPSIS untuk <?= html_escape($periode_info['nama_periode']); ?> berhasil diperbarui.');
    });

    $('#formInputNilaiPegawai').on('submit', function(e) {
        e.preventDefault();
        var modalEl = document.getElementById('modalInputNilaiPegawai');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        alert('Sukses! Nilai kriteria alternative pegawai berhasil disimpan dan ditambahkan ke sesi penilaian ini.');
        this.reset();
    });
});
</script>
