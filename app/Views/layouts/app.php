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
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('FreeDash/src/assets/images/favicon.png') ?>">
    <title>Kas Kita | <?= $hlm ?></title>
    <!-- Custom CSS FreeDash & Plugins -->
    <link href="<?= base_url('FreeDash/src/assets/extra-libs/c3/c3.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('FreeDash/src/assets/libs/chartist/dist/chartist.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('FreeDash/src/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('FreeDash/src/dist/css/style.min.css') ?>" rel="stylesheet">
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
    <?= $this->renderSection('scripts') ?>
</body>

</html>
