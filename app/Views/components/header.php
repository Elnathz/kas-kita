<!-- ============================================================== -->
<!-- Topbar header -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg">
        <div class="navbar-header" data-logobg="skin6">
            <!-- Sidebar toggle visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)">
                <i data-feather="menu" class="feather-icon"></i>
            </a>
            
            <!-- Brand Logo with Wordmark -->
            <div class="navbar-brand py-0">
                <a href="<?= base_url('dashboard') ?>" class="d-flex align-items-center text-decoration-none py-1">
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
                    <span class="navbar-text text-muted small">
                        Aplikasi Manajemen Kas & Iuran RT
                    </span>
                </li>
            </ul>

            <!-- Right side items (User profile) -->
            <ul class="navbar-nav float-end">
                <!-- User profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= base_url('FreeDash/src/assets/images/users/profile-pic.jpg') ?>" alt="Foto Pengguna" class="rounded-circle"
                            width="38" height="38">
                        <span class="ms-2 d-none d-lg-inline-block">
                            <span>Halo,</span> 
                            <span class="text-dark fw-semibold"><?= session()->get('nama') ?? 'Pengurus RT' ?></span> 
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY shadow">
                        <div class="p-3 border-bottom bg-light">
                            <h6 class="mb-0 fw-bold text-dark"><?= session()->get('nama') ?? 'Pengurus RT' ?></h6>
                            <span class="badge bg-success mt-1"><?= ucfirst(session()->get('role') ?? 'pengurus') ?></span>
                        </div>
                        <a class="dropdown-item py-2" href="<?= base_url('dashboard') ?>">
                            <i data-feather="home" class="svg-icon me-2 text-primary"></i> Dashboard
                        </a>
                        <div class="dropdown-divider my-1"></div>
                        <a class="dropdown-item py-2 text-danger" href="<?= base_url('logout') ?>">
                            <i data-feather="log-out" class="svg-icon me-2 text-danger"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->