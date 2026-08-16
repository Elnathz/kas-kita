<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <a href="<?= base_url() ?>" class="d-flex align-items-center text-decoration-none">
                    <img src="<?= base_url('FreeDash/src/assets/images/logo-icon.png') ?>" alt="Logo Kas-Kita" class="img-fluid me-2" style="max-height: 38px;">
                    <span class="logo-text fw-bolder mb-0" style="font-size: 1.65rem; background: linear-gradient(135deg, #059669 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.5px;">Kas-Kita</span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                <!-- Notification -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                        id="bell" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        <span class="badge text-bg-primary notify-no rounded-circle">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                        <ul class="list-style-none">
                            <li>
                                <div class="message-center notifications position-relative">
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="btn btn-danger rounded-circle btn-circle"><i
                                                data-feather="airplay" class="text-white"></i></div>
                                        <div class="w-75 d-inline-block v-middle ps-2">
                                            <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                            <span class="font-12 text-nowrap d-block text-muted">Just see
                                                the my new
                                                admin!</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-success text-white rounded-circle btn-circle"><i
                                                data-feather="calendar" class="text-white"></i></span>
                                        <div class="w-75 d-inline-block v-middle ps-2">
                                            <h6 class="message-title mb-0 mt-1">Event today</h6>
                                            <span
                                                class="font-12 text-nowrap d-block text-muted text-truncate">Just
                                                a reminder that you have event</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:10 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-info rounded-circle btn-circle"><i
                                                data-feather="settings" class="text-white"></i></span>
                                        <div class="w-75 d-inline-block v-middle ps-2">
                                            <h6 class="message-title mb-0 mt-1">Settings</h6>
                                            <span
                                                class="font-12 text-nowrap d-block text-muted text-truncate">You
                                                can customize this template
                                                as you want</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:08 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-primary rounded-circle btn-circle"><i
                                                data-feather="box" class="text-white"></i></span>
                                        <div class="w-75 d-inline-block v-middle ps-2">
                                            <h6 class="message-title mb-0 mt-1">Pavan kumar</h6> <span
                                                class="font-12 text-nowrap d-block text-muted">Just
                                                see the my admin!</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:02 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);">
                                    <strong>Check all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Notification -->
                <!-- ============================================================== -->
                <!-- create new -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="settings" class="svg-icon"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <div class="customize-input">
                            <select
                                class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                <option selected>EN</option>
                                <option value="1">AB</option>
                                <option value="2">AK</option>
                                <option value="3">BE</option>
                            </select>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <form>
                            <div class="customize-input">
                                <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                    type="search" placeholder="Search" aria-label="Search">
                                <i class="form-control-icon" data-feather="search"></i>
                            </div>
                        </form>
                    </a>
                </li>
                <!-- User profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= base_url('FreeDash/src/assets/images/users/profile-pic.jpg') ?>" alt="user" class="rounded-circle"
                            width="40">
                        <span class="ms-2 d-none d-lg-inline-block">
                            <span>Halo,</span> 
                            <span class="text-dark fw-semibold"><?= session()->get('nama') ?? 'Pengurus RT' ?></span> 
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                        <div class="p-3 border-bottom">
                            <h6 class="mb-0 fw-bold"><?= session()->get('nama') ?? 'Pengurus RT' ?></h6>
                            <span class="text-muted small"><?= ucfirst(session()->get('role') ?? 'pengurus') ?></span>
                        </div>
                        <a class="dropdown-item" href="<?= base_url('dashboard') ?>">
                            <i data-feather="home" class="svg-icon me-2 ms-1"></i> Dashboard
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i data-feather="power" class="svg-icon me-2 ms-1 text-danger"></i> Keluar
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