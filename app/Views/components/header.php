<!-- ============================================================== -->
<!-- Topbar header -->
<!-- ============================================================== -->
<?php
$uri = service('uri');
$seg1 = $uri->getTotalSegments() >= 1 ? $uri->getSegment(1) : '';
$isWargaMode = ($seg1 === 'dashboard-warga' || ($seg1 === 'iuran' && in_array($uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '', ['tagihan', 'bayar', 'riwayat'])));
$currentUserName = $isWargaMode ? 'Farros Rifantiarno' : (session()->get('nama') ?? 'Pengurus RT');
$currentUserRole = $isWargaMode ? 'Warga RT 04' : (ucfirst(session()->get('role') ?? 'Pengurus RT'));
?>
<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg">
        <div class="navbar-header" data-logobg="skin6">
            <!-- Sidebar toggle visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)">
                <i data-feather="menu" class="feather-icon"></i>
            </a>
            
            <!-- Brand Logo with Wordmark -->
            <div class="navbar-brand py-0">
                <a href="<?= base_url($isWargaMode ? 'dashboard-warga' : 'dashboard') ?>" class="d-flex align-items-center text-decoration-none py-1">
                    <img src="<?= base_url('assets/images/logo-full.svg') ?>" alt="Kas Kita - Manajemen Kas RT" class="img-fluid" style="height: 52px; width: auto;">
                </a>
            </div>

            <!-- Mobile toggle -->
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i data-feather="more-horizontal" class="feather-icon"></i>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- Left nav items (Quick Shortcuts) -->
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                <li class="nav-item d-none d-md-block">
                    <span class="badge <?= $isWargaMode ? 'bg-info-subtle text-info-emphasis border border-info' : 'bg-success-subtle text-success-emphasis border border-success' ?> px-2 py-1">
                        Mode Aktif: <strong><?= $isWargaMode ? 'Warga RT' : 'Pengurus RT' ?></strong>
                    </span>
                </li>
            </ul>

            <!-- Right side items (User profile & Role Switcher) -->
            <ul class="navbar-nav float-end align-items-center">
                <!-- Role Switcher Quick Button (Sangat Berguna untuk Demo UTS) -->
                <li class="nav-item me-2 d-none d-sm-block">
                    <?php if ($isWargaMode) : ?>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                            <i data-feather="repeat" class="feather-icon" style="width: 14px; height: 14px;"></i>
                            <span>Beralih ke Pengurus</span>
                        </a>
                    <?php else : ?>
                        <a href="<?= base_url('dashboard-warga') ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                            <i data-feather="user" class="feather-icon" style="width: 14px; height: 14px;"></i>
                            <span>Lihat Akun Farros (Warga)</span>
                        </a>
                    <?php endif; ?>
                </li>

                <!-- User profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= base_url('FreeDash/src/assets/images/users/profile-pic.jpg') ?>" alt="Foto Pengguna" class="rounded-circle"
                            width="38" height="38">
                        <span class="ms-2 d-none d-lg-inline-block">
                            <span>Halo,</span> 
                            <span class="text-dark fw-semibold"><?= $currentUserName ?></span> 
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY shadow">
                        <div class="p-3 border-bottom bg-light">
                            <h6 class="mb-0 fw-bold text-dark"><?= $currentUserName ?></h6>
                            <span class="badge bg-success mt-1"><?= $currentUserRole ?></span>
                        </div>
                        
                        <?php if ($isWargaMode) : ?>
                            <a class="dropdown-item py-2" href="<?= base_url('dashboard-warga') ?>">
                                <i data-feather="home" class="svg-icon me-2 text-primary"></i> Dashboard Warga
                            </a>
                            <a class="dropdown-item py-2" href="<?= base_url('iuran/tagihan') ?>">
                                <i data-feather="file-text" class="svg-icon me-2 text-warning"></i> Tagihan Saya
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item py-2 text-primary fw-semibold" href="<?= base_url('dashboard') ?>">
                                <i data-feather="repeat" class="svg-icon me-2 text-primary"></i> Mode Pengurus RT
                            </a>
                        <?php else : ?>
                            <a class="dropdown-item py-2" href="<?= base_url('dashboard') ?>">
                                <i data-feather="home" class="svg-icon me-2 text-primary"></i> Dashboard Pengurus
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item py-2 text-primary fw-semibold" href="<?= base_url('dashboard-warga') ?>">
                                <i data-feather="user" class="svg-icon me-2 text-primary"></i> Mode Warga (Farros)
                            </a>
                        <?php endif; ?>

                        <div class="dropdown-divider my-1"></div>
                        <a class="dropdown-item py-2 text-danger" href="<?= base_url('logout') ?>">
                            <i data-feather="power" class="svg-icon me-2 text-danger"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>