<!DOCTYPE html>
<html dir="ltr" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/images/logo-icon.svg') ?>">
    <title>Kas Kita | Masuk</title>
    <link href="<?= base_url('FreeDash/src/dist/css/style.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <?= $this->renderSection('styles') ?>
</head>

<body>
    <div>
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Global App Toast Notification Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="appGlobalToast" class="toast align-items-center border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2 py-3 px-3">
                    <div id="appToastIconWrapper" class="p-2 rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i id="appToastIcon" data-feather="check-circle" class="feather-icon text-success" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <strong id="appToastTitle" class="d-block font-13 text-dark">Pemberitahuan</strong>
                        <span id="appToastMessage" class="font-12 text-muted">Pesan notifikasi berhasil.</span>
                    </div>
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('FreeDash/src/assets/libs/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/dist/js/feather.min.js') ?>"></script>
    <script>
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        function showAppToast(message, type = 'success', title = null) {
            const toastEl = document.getElementById('appGlobalToast');
            if (!toastEl) return;
            
            const toastTitle = document.getElementById('appToastTitle');
            const toastMsg = document.getElementById('appToastMessage');
            const toastIcon = document.getElementById('appToastIcon');
            
            toastMsg.textContent = message;
            toastEl.className = 'toast align-items-center border-0 shadow-lg';
            
            if (type === 'success') {
                toastTitle.textContent = title || 'Berhasil';
                toastEl.classList.add('bg-success-subtle', 'text-success-emphasis', 'border-start', 'border-success', 'border-4');
                toastIcon.setAttribute('data-feather', 'check-circle');
                toastIcon.className = 'feather-icon text-success';
            } else if (type === 'warning' || type === 'error' || type === 'danger') {
                toastTitle.textContent = title || (type === 'warning' ? 'Perhatian' : 'Gagal');
                toastEl.classList.add('bg-warning-subtle', 'text-warning-emphasis', 'border-start', 'border-warning', 'border-4');
                toastIcon.setAttribute('data-feather', 'alert-triangle');
                toastIcon.className = 'feather-icon text-warning';
            } else {
                toastTitle.textContent = title || 'Informasi';
                toastEl.classList.add('bg-info-subtle', 'text-info-emphasis', 'border-start', 'border-info', 'border-4');
                toastIcon.setAttribute('data-feather', 'info');
                toastIcon.className = 'feather-icon text-info';
            }
            
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
            toast.show();
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
