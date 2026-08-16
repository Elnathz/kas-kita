<?php
$hlm = "Dashboard";
if (uri_string() != "" && uri_string() != "/") {
    $hlm = ucwords(str_replace('/', ' > ', uri_string()));
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/images/logo-icon.svg') ?>">
    <title>Kas Kita | <?= $hlm ?></title>
    <!-- Custom CSS FreeDash & Plugins -->
    <link href="<?= base_url('FreeDash/src/assets/extra-libs/c3/c3.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('FreeDash/src/assets/libs/chartist/dist/chartist.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('FreeDash/src/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('FreeDash/src/dist/css/style.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <?= $this->renderSection('styles') ?>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        
        <!-- Header -->
        <?= $this->include('components/header') ?>

        <!-- Sidebar -->
        <?= $this->include('components/sidebar') ?>

        <!-- Page wrapper -->
        <div class="page-wrapper">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1"><?= $hlm ?></h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Home</a></li>
                                    <?php if ($hlm !== "Dashboard") : ?>
                                        <li class="breadcrumb-item text-muted active" aria-current="page"><?= $hlm ?></li>
                                    <?php endif; ?>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>

            <!-- Footer -->
            <?= $this->include('components/footer') ?>
        </div>
    </div>

    <!-- All Jquery & Bootstrap JS -->
    <script src="<?= base_url('FreeDash/src/assets/libs/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/dist/js/app-style-switcher.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/dist/js/feather.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/dist/js/sidebarmenu.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/dist/js/custom.min.js') ?>"></script>
    
    <!-- Kas-Kita Dynamic Resizable & Collapsible Sidebar Script -->
    <script>
    $(document).ready(function() {
        const $wrapper = $('#main-wrapper');
        const $brandLogo = $('#headerBrandLogo');
        const fullLogo = $brandLogo.data('full-logo');
        const iconLogo = $brandLogo.data('icon-logo');
        
        // 1. Restore saved width & collapsed state from localStorage
        const savedWidth = localStorage.getItem('kaskita_sidebar_width') || '275px';
        const isMini = localStorage.getItem('kaskita_sidebar_mini') === 'true';
        
        document.documentElement.style.setProperty('--sidebar-width', savedWidth);
        
        if (isMini && window.innerWidth >= 992) {
            $wrapper.addClass('mini-sidebar').attr('data-sidebartype', 'mini-sidebar');
            if ($brandLogo.length && iconLogo) {
                $brandLogo.attr('src', iconLogo);
            }
        } else {
            $wrapper.removeClass('mini-sidebar').attr('data-sidebartype', 'full');
            if ($brandLogo.length && fullLogo) {
                $brandLogo.attr('src', fullLogo);
            }
        }

        // 2. Desktop Toggle Handler (Full <-> Mini Icon Only)
        $('#toggleSidebarDesktop').on('click', function(e) {
            e.preventDefault();
            const currentlyMini = $wrapper.hasClass('mini-sidebar');
            if (currentlyMini) {
                $wrapper.removeClass('mini-sidebar').attr('data-sidebartype', 'full');
                localStorage.setItem('kaskita_sidebar_mini', 'false');
                if ($brandLogo.length && fullLogo) {
                    $brandLogo.attr('src', fullLogo);
                }
            } else {
                $wrapper.addClass('mini-sidebar').attr('data-sidebartype', 'mini-sidebar');
                localStorage.setItem('kaskita_sidebar_mini', 'true');
                if ($brandLogo.length && iconLogo) {
                    $brandLogo.attr('src', iconLogo);
                }
            }
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });

        // 3. Resizable & Stretchable Sidebar Drag Logic (Min: 220px, Max: 380px)
        const resizer = document.getElementById('sidebarResizer');
        if (resizer) {
            let isDragging = false;
            const minW = 220;
            const maxW = 380;

            resizer.addEventListener('mousedown', function(e) {
                if ($wrapper.hasClass('mini-sidebar')) return;
                isDragging = true;
                document.body.classList.add('is-resizing-sidebar');
                e.preventDefault();
            });

            document.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                let newWidth = e.clientX;
                if (newWidth < minW) newWidth = minW;
                if (newWidth > maxW) newWidth = maxW;
                document.documentElement.style.setProperty('--sidebar-width', newWidth + 'px');
            });

            document.addEventListener('mouseup', function(e) {
                if (!isDragging) return;
                isDragging = false;
                document.body.classList.remove('is-resizing-sidebar');
                const finalWidth = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width').trim();
                localStorage.setItem('kaskita_sidebar_width', finalWidth);
            });
        }
    });
    </script>
    
    <!-- Global App Toast Notification Container (Pengganti Alert Bawaan Browser) -->
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

    <!-- Global Toast Helper Script -->
    <script>
    function showAppToast(message, type = 'success', title = null) {
        const toastEl = document.getElementById('appGlobalToast');
        if (!toastEl) return;
        
        const toastTitle = document.getElementById('appToastTitle');
        const toastMsg = document.getElementById('appToastMessage');
        const toastIcon = document.getElementById('appToastIcon');
        
        toastMsg.textContent = message;
        
        // Reset classes
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
