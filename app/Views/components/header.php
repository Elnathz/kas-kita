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
        <div class="navbar-header d-flex align-items-center justify-content-between px-2 px-md-3" data-logobg="skin6">
            <!-- Left: Sidebar toggle visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none text-dark p-1" href="javascript:void(0)" title="Menu Navigasi">
                <i data-feather="menu" class="feather-icon" style="width: 22px; height: 22px;"></i>
            </a>
            
            <!-- Brand Logo with Wordmark -->
            <div class="navbar-brand py-0">
                <a href="<?= base_url($isWargaMode ? 'dashboard-warga' : 'dashboard') ?>" class="d-flex align-items-center text-decoration-none py-1">
                    <img id="headerBrandLogo" src="<?= base_url('assets/images/logo-full.svg') ?>" data-full-logo="<?= base_url('assets/images/logo-full.svg') ?>" data-icon-logo="<?= base_url('assets/images/logo-icon.svg') ?>" alt="Kas Kita - Manajemen Kas RT" class="img-fluid" style="height: 44px; width: auto;">
                </a>
            </div>

            <!-- Desktop Sidebar Toggle Button (Mini / Full Sidebar) -->
            <a class="nav-link text-dark p-1 d-none d-lg-inline-flex align-items-center justify-content-center rounded hover-bg-light" href="javascript:void(0)" id="toggleSidebarDesktop" title="Buka / Tutup Menu Sidebar" style="width: 34px; height: 34px;">
                <i data-feather="menu" class="feather-icon" style="width: 20px; height: 20px;"></i>
            </a>

            <!-- Right: Profile Dropdown Button on Mobile -->
            <div class="dropdown d-block d-lg-none">
                <a class="nav-link dropdown-toggle p-0" href="javascript:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Menu Akun">
                    <img src="<?= base_url('FreeDash/src/assets/images/users/profile-pic.jpg') ?>" alt="Foto Profil" class="rounded-circle shadow-sm" width="34" height="34" style="border: 2px solid var(--kk-green-500); object-fit: cover;">
                </a>
                <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY shadow border-0 rounded-3 mt-1" style="z-index: 1050;">
                    <!-- Compact Header: Name + Badge on Single Line -->
                    <div class="px-3 py-2 border-bottom bg-light d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark font-13 text-truncate" style="max-width: 120px;"><?= $currentUserName ?></span>
                        <span class="badge <?= $isWargaMode ? 'bg-info-subtle text-info-emphasis border border-info' : 'bg-success-subtle text-success-emphasis border border-success' ?> font-10 px-2 py-0 ms-1"><?= $currentUserRole ?></span>
                    </div>
                    
                    <?php if ($isWargaMode) : ?>
                        <a class="dropdown-item" href="<?= base_url('dashboard-warga') ?>">
                            <i data-feather="home" class="svg-icon text-primary"></i> Dashboard Warga
                        </a>
                        <a class="dropdown-item" href="<?= base_url('iuran/tagihan') ?>">
                            <i data-feather="file-text" class="svg-icon text-warning"></i> Tagihan Saya
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-success fw-semibold" href="<?= base_url('dashboard') ?>">
                            <i data-feather="repeat" class="svg-icon text-success"></i> Mode Pengurus RT
                        </a>
                    <?php else : ?>
                        <a class="dropdown-item" href="<?= base_url('dashboard') ?>">
                            <i data-feather="home" class="svg-icon text-primary"></i> Dashboard Pengurus
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-primary fw-semibold" href="<?= base_url('dashboard-warga') ?>">
                            <i data-feather="user" class="svg-icon text-primary"></i> Mode Warga (Farros)
                        </a>
                    <?php endif; ?>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                        <i data-feather="power" class="svg-icon text-danger"></i> Keluar
                    </a>
                </div>
            </div>
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

            <!-- Right side items (User profile & Role Switcher for Desktop) -->
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

                <!-- User profile (Desktop) -->
                <li class="nav-item dropdown d-none d-lg-block">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= base_url('FreeDash/src/assets/images/users/profile-pic.jpg') ?>" alt="Foto Pengguna" class="rounded-circle"
                            width="38" height="38" style="border: 2px solid var(--kk-green-500); object-fit: cover;">
                        <span class="ms-2 d-none d-lg-inline-block">
                            <span>Halo,</span> 
                            <span class="text-dark fw-semibold"><?= $currentUserName ?></span> 
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY shadow border-0 rounded-3">
                        <div class="px-3 py-2 border-bottom bg-light d-flex align-items-center justify-content-between">
                            <span class="fw-bold text-dark font-13 text-truncate" style="max-width: 130px;"><?= $currentUserName ?></span>
                            <span class="badge bg-success font-10 px-2 py-0 ms-1"><?= $currentUserRole ?></span>
                        </div>
                        
                        <?php if ($isWargaMode) : ?>
                            <a class="dropdown-item" href="<?= base_url('dashboard-warga') ?>">
                                <i data-feather="home" class="svg-icon text-primary"></i> Dashboard Warga
                            </a>
                            <a class="dropdown-item" href="<?= base_url('iuran/tagihan') ?>">
                                <i data-feather="file-text" class="svg-icon text-warning"></i> Tagihan Saya
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-success fw-semibold" href="<?= base_url('dashboard') ?>">
                                <i data-feather="repeat" class="svg-icon text-success"></i> Mode Pengurus RT
                            </a>
                        <?php else : ?>
                            <a class="dropdown-item" href="<?= base_url('dashboard') ?>">
                                <i data-feather="home" class="svg-icon text-primary"></i> Dashboard Pengurus
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-primary fw-semibold" href="<?= base_url('dashboard-warga') ?>">
                                <i data-feather="user" class="svg-icon text-primary"></i> Mode Warga (Farros)
                            </a>
                        <?php endif; ?>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i data-feather="power" class="svg-icon text-danger"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>