<script>
/**
 * BeRewards - Application & Satker Setting Management Script
 * Handles AJAX form submissions, real-time DOM synchronization,
 * CSRF security token rotations, file upload previews, and toast notifications.
 */
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // 1. Toast Notification Utility (Clean & White Text Standard)
    function showToast(type, title, message) {
        var toastEl = $('#toastNotification');
        if (!toastEl.length) return;

        toastEl.removeClass('bg-success bg-danger bg-warning bg-info text-dark').addClass('text-white');
        var iconClass = 'ti ti-info-circle';

        if (type === 'success') {
            toastEl.addClass('bg-success');
            iconClass = 'ti ti-circle-check';
        } else if (type === 'danger' || type === 'error') {
            toastEl.addClass('bg-danger');
            iconClass = 'ti ti-alert-triangle';
        } else if (type === 'warning') {
            toastEl.addClass('bg-warning');
            iconClass = 'ti ti-alert-circle';
        } else {
            toastEl.addClass('bg-info');
            iconClass = 'ti ti-info-circle';
        }

        $('#toastIcon').attr('class', iconClass + ' fs-22 me-1 text-white');
        $('#toastTitle').text(title);
        $('#toastText').text(message);

        var toast = bootstrap.Toast.getOrCreateInstance(toastEl[0], { delay: 4000 });
        toast.show();
    }

    // CSRF Token Helper
    var csrfTokenName = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    function updateCsrf(res) {
        if (res && res.csrf_token_name && res.csrf_hash) {
            csrfTokenName = res.csrf_token_name;
            csrfHash = res.csrf_hash;
            $('input[name="' + csrfTokenName + '"]').val(csrfHash);
        }
    }

    // 2. Tab 1: Submit Form Profil Satker
    $('#formSettingSatker').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#btnSubmitSatker');
        var originalBtnHtml = btn.html();

        var formData = form.serializeArray();
        formData.push({ name: csrfTokenName, value: csrfHash });

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html(originalBtnHtml);

                if (res.status) {
                    showToast('success', 'Berhasil', res.message || 'Profil Satker berhasil disimpan.');
                    
                    // Live Update Banner & Sidebar UI Elements
                    var namaSatker   = $('#satker_nama').val();
                    var singkatan    = $('#satker_singkatan').val();
                    var kodeSatker   = $('#satker_kode').val();
                    var kodeWilayah  = $('#satker_wilayah').val();
                    var kelasSatker  = $('#satker_kelas').val();
                    var ptPembina    = $('#satker_pt').val();
                    var alamat       = $('#satker_alamat').val();
                    var telepon      = $('#satker_telepon').val();
                    var email        = $('#satker_email').val();
                    var website      = $('#satker_website').val();

                    if (namaSatker) {
                        $('#bannerSatkerNama').text(namaSatker);
                        $('#sidebarSatkerNama').text(namaSatker);
                    }
                    if (singkatan) {
                        $('#sidebarSatkerShort').html('MARI &bull; ' + singkatan);
                        $('#kpiSatkerShort').text(singkatan);
                    }
                    if (kodeSatker) {
                        $('#bannerSatkerKode').text(kodeSatker);
                        $('#sidebarSatkerKode').text(kodeSatker);
                        $('#kpiSatkerKode').text(kodeSatker);
                    }
                    if (kodeWilayah) {
                        $('#bannerSatkerWilayah').text(kodeWilayah);
                        $('#sidebarSatkerWilayah').text(kodeWilayah);
                    }
                    if (kelasSatker) {
                        $('#bannerSatkerKelas').html('<i class="ti ti-building me-1"></i>' + kelasSatker);
                        $('#sidebarSatkerKelasBadge').text(kelasSatker);
                        $('#badgeKelasSatker').html('<i class="ti ti-building me-1"></i> ' + kelasSatker);
                    }
                    if (ptPembina) {
                        $('#bannerSatkerPT').text(ptPembina);
                        $('#sidebarSatkerPT').text(ptPembina);
                    }
                    if (alamat) $('#bannerSatkerAlamat').text(alamat);
                    if (telepon) {
                        $('#bannerSatkerTelepon').text(telepon);
                        $('#sidebarSatkerTelepon').text(telepon);
                    }
                    if (email) $('#sidebarSatkerEmail').text(email);
                    if (website) {
                        $('#bannerSatkerWebsite').text(website);
                        $('#sidebarSatkerWebsite').text(website);
                    }
                } else {
                    showToast('danger', 'Gagal Simpan', res.message || 'Terjadi kesalahan saat menyimpan data.');
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html(originalBtnHtml);
                showToast('danger', 'Error Jaringan', 'Gagal menghubungi server. Silakan coba kembali.');
            }
        });
    });

    // 3. Tab 2: Submit Form Susunan Pimpinan
    $('#formSettingPimpinan').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#btnSubmitPimpinan');
        var originalBtnHtml = btn.html();

        var formData = form.serializeArray();
        formData.push({ name: csrfTokenName, value: csrfHash });

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html(originalBtnHtml);

                if (res.status) {
                    showToast('success', 'Berhasil', res.message || 'Data pimpinan berhasil disimpan.');

                    // Live Update Sidebar Leadership Summary
                    var namaKetua = $('input[name="nama_ketua"]').val();
                    var nipKetua  = $('input[name="nip_ketua"]').val();
                    var namaWakil = $('input[name="nama_wakil_ketua"]').val();
                    var nipWakil  = $('input[name="nip_wakil_ketua"]').val();
                    var namaPan   = $('input[name="nama_panitera"]').val();
                    var nipPan    = $('input[name="nip_panitera"]').val();
                    var namaSek   = $('input[name="nama_sekretaris"]').val();
                    var nipSek    = $('input[name="nip_sekretaris"]').val();

                    if (namaKetua) $('#sidebarKetuaNama').text(namaKetua);
                    if (nipKetua)  $('#sidebarKetuaNip').text('NIP. ' + nipKetua);
                    if (namaWakil) $('#sidebarWakilNama').text(namaWakil);
                    if (nipWakil)  $('#sidebarWakilNip').text('NIP. ' + nipWakil);
                    if (namaPan)   $('#sidebarPaniteraNama').text(namaPan);
                    if (nipPan)    $('#sidebarPaniteraNip').text('NIP. ' + nipPan);
                    if (namaSek)   $('#sidebarSekretarisNama').text(namaSek);
                    if (nipSek)    $('#sidebarSekretarisNip').text('NIP. ' + nipSek);
                } else {
                    showToast('danger', 'Gagal Simpan', res.message || 'Terjadi kesalahan saat menyimpan data pimpinan.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html(originalBtnHtml);
                showToast('danger', 'Error Jaringan', 'Gagal menghubungi server. Silakan coba kembali.');
            }
        });
    });

    // 4. Tab 3: Submit Form Konfigurasi SPK & Kop Surat
    $('#formSettingApp').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#btnSubmitApp');
        var originalBtnHtml = btn.html();

        var formData = form.serializeArray();
        formData.push({ name: csrfTokenName, value: csrfHash });

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function(res) {
                updateCsrf(res);
                btn.prop('disabled', false).html(originalBtnHtml);

                if (res.status) {
                    showToast('success', 'Berhasil', res.message || 'Konfigurasi SPK berhasil disimpan.');
                } else {
                    showToast('danger', 'Gagal Simpan', res.message || 'Terjadi kesalahan saat menyimpan konfigurasi.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html(originalBtnHtml);
                showToast('danger', 'Error Jaringan', 'Gagal menghubungi server. Silakan coba kembali.');
            }
        });
    });

    // 5. Logo Upload Trigger & AJAX Handler
    $('#btnUploadLogoTrigger').on('click', function() {
        $('#logoFileInput').click();
    });

    $('#logoFileInput').on('change', function() {
        var file = this.files[0];
        if (!file) return;

        // Client-side validation: Max 2MB & image types
        var validExtensions = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml'];
        if (!validExtensions.includes(file.type)) {
            showToast('danger', 'File Tidak Valid', 'Harap pilih file gambar PNG, JPG, JPEG, atau SVG.');
            $(this).val('');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            showToast('danger', 'File Terlalu Besar', 'Ukuran logo maksimal 2 MB.');
            $(this).val('');
            return;
        }

        // Instant local preview
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#satkerLogoPreview').attr('src', e.target.result);
            $('.sidebarLogoImg').attr('src', e.target.result);
            $('#bannerLogoImg').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);

        // Upload to backend via AJAX FormData
        var uploadFormData = new FormData();
        uploadFormData.append('logo', file);
        uploadFormData.append(csrfTokenName, csrfHash);

        var btnTrigger = $('#btnUploadLogoTrigger');
        var originalTriggerHtml = btnTrigger.html();
        btnTrigger.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Mengunggah...');

        $.ajax({
            url: '<?= base_url("setting/upload_logo"); ?>',
            type: 'POST',
            data: uploadFormData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                updateCsrf(res);
                btnTrigger.prop('disabled', false).html(originalTriggerHtml);

                if (res.status) {
                    showToast('success', 'Logo Diperbarui', res.message || 'Logo resmi satker berhasil diunggah.');
                    if (res.logo_url) {
                        $('#satkerLogoPreview').attr('src', res.logo_url);
                        $('.sidebarLogoImg').attr('src', res.logo_url);
                        $('#bannerLogoImg').attr('src', res.logo_url);
                    }
                } else {
                    showToast('danger', 'Gagal Unggah', res.message || 'Gagal mengunggah logo satker.');
                }
            },
            error: function() {
                btnTrigger.prop('disabled', false).html(originalTriggerHtml);
                showToast('danger', 'Error Jaringan', 'Gagal mengunggah logo ke server.');
            }
        });
    });
});
</script>
