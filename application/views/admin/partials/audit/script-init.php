<!-- Page Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var baseUrl = '<?= base_url(); ?>';

    // 1. Initialize DataTables
    var tableAudit = null;
    if ($.fn.DataTable) {
        tableAudit = $('#tableAudit').DataTable({
            language: {
                search: "Cari Log Transaksi:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ log audit",
                infoEmpty: "Tidak ada log audit yang tersedia",
                zeroRecords: "Tidak ditemukan transaksi log audit yang cocok",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[0, 'desc']]
        });
    }

    // 2. Detail Button Handler with AJAX fetch
    $(document).on('click', '.btn-detail-audit', function(e) {
        e.preventDefault();
        var idAudit = $(this).data('id');
        if (!idAudit) return;

        var modalEl = document.getElementById('modalDetailAudit');
        var bsModal = bootstrap.Modal.getInstance(modalEl);
        if (!bsModal) {
            bsModal = new bootstrap.Modal(modalEl);
        }
        bsModal.show();

        // Show loading state
        $('#detail_loading').removeClass('d-none');
        $('#detail_content').addClass('d-none');

        $.ajax({
            url: baseUrl + 'audit/detail/' + idAudit,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                $('#detail_loading').addClass('d-none');
                $('#detail_content').removeClass('d-none');

                if (res.status && res.data) {
                    var d = res.data;

                    $('#detail_timestamp').text(d.formatted_time || d.timestamp);
                    $('#detail_user').text(d.nama_user + ' (@' + d.username + ' • ' + d.role + ')');
                    $('#detail_ip').text(d.ip_address || '-');
                    $('#detail_user_agent').text(d.user_agent || '-').attr('title', d.user_agent || '-');
                    $('#detail_modul').text(d.modul);
                    $('#detail_tipe_aksi').text(d.tipe_aksi || 'ACTIVITY');
                    $('#detail_aktivitas').text(d.aktivitas);

                    // Target Entity Table
                    if (d.tabel_terkait) {
                        var targetText = '<code>' + d.tabel_terkait + '</code>';
                        if (d.id_record) {
                            targetText += ' (ID: <strong>' + d.id_record + '</strong>)';
                        }
                        $('#detail_target_tabel').html(targetText);
                    } else {
                        $('#detail_target_tabel').html('<span class="text-muted fst-italic">Non-spesifik tabel</span>');
                    }

                    // Status Badge
                    var statusHtml = '';
                    if (d.status === 'Sukses') {
                        statusHtml = '<span class="badge bg-success rounded-pill px-2.5 py-1 fs-11"><i class="ti ti-check me-1"></i>Sukses</span>';
                    } else if (d.status === 'Peringatan') {
                        statusHtml = '<span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fs-11"><i class="ti ti-alert-triangle me-1"></i>Peringatan</span>';
                    } else {
                        statusHtml = '<span class="badge bg-danger rounded-pill px-2.5 py-1 fs-11"><i class="ti ti-x me-1"></i>Gagal</span>';
                    }
                    $('#detail_status_badge').html(statusHtml);

                    // Comparison Matrix / Diff Table
                    var $tbody = $('#diff_tbody');
                    $tbody.empty();

                    if (d.comparison_matrix && d.comparison_matrix.length > 0) {
                        $('#section_data_diff').removeClass('d-none');
                        $('#info_non_db').addClass('d-none');
                        $('#diff_count_badge').text(d.comparison_matrix.length + ' Field Tercatat');

                        $.each(d.comparison_matrix, function(index, item) {
                            var rowClass = item.is_changed ? 'table-warning-subtle' : '';
                            var statusBadge = '<span class="badge ' + (item.badge_class || 'bg-secondary') + ' px-2 py-0.5 fs-10">' + item.status_label + '</span>';

                            var tr = '<tr class="' + rowClass + '">' +
                                '<td><strong class="d-block text-dark">' + item.field_label + '</strong><code class="fs-10 text-muted">' + item.field_key + '</code></td>' +
                                '<td><div class="text-break">' + item.old_value + '</div></td>' +
                                '<td><div class="text-break fw-semibold">' + item.new_value + '</div></td>' +
                                '<td class="text-center">' + statusBadge + '</td>' +
                                '</tr>';
                            $tbody.append(tr);
                        });
                    } else {
                        $('#section_data_diff').addClass('d-none');
                        $('#info_non_db').removeClass('d-none');
                    }

                    // Raw JSON Metadata
                    var rawJsonObj = {
                        audit_id: d.id_audit,
                        timestamp: d.timestamp,
                        user: d.username,
                        role: d.role,
                        module: d.modul,
                        action: d.tipe_aksi,
                        target_table: d.tabel_terkait,
                        record_id: d.id_record,
                        ip_address: d.ip_address,
                        user_agent: d.user_agent,
                        data_sebelum: d.data_sebelum,
                        data_sesudah: d.data_sesudah,
                        metadata: d.raw_metadata
                    };
                    $('#detail_raw_json').text(JSON.stringify(rawJsonObj, null, 2));

                } else {
                    $('#detail_aktivitas').html('<div class="text-danger"><i class="ti ti-alert-circle me-1"></i> ' + (res.message || 'Gagal mengambil data rincian audit.') + '</div>');
                    $('#section_data_diff').addClass('d-none');
                    $('#info_non_db').addClass('d-none');
                }
            },
            error: function(xhr) {
                $('#detail_loading').addClass('d-none');
                $('#detail_content').removeClass('d-none');
                $('#detail_aktivitas').html('<div class="text-danger"><i class="ti ti-alert-circle me-1"></i> Terjadi kesalahan saat memuat data audit (Kode: ' + xhr.status + ').</div>');
                $('#section_data_diff').addClass('d-none');
                $('#info_non_db').addClass('d-none');
            }
        });
    });
});
</script>
