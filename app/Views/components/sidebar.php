<?php
$uri = service('uri');
$seg1 = $uri->getTotalSegments() >= 1 ? $uri->getSegment(1) : '';
$seg2 = $uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '';
$isWargaMode = ($seg1 === 'dashboard-warga' || $seg1 === 'laporan-warga' || $seg1 === 'profil' || ($seg1 === 'iuran' && in_array($seg2, ['tagihan', 'bayar', 'riwayat'])));
?>
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar position-fixed" data-sidebarbg="skin6">
    <!-- Resizer Handle on Right Edge -->
    <div class="sidebar-resizer d-none d-lg-block" id="sidebarResizer" title="Geser untuk mengatur lebar sidebar"></div>
    
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav" style="padding-top: 10px !important;">
            <ul id="sidebarnav">

            <?php if ($isWargaMode) : ?>
                <!-- ============================================================== -->
                <!-- MENU KHUSUS ROLE WARGA (FARROS RIFANTIARNO) -->
                <!-- ============================================================== -->
                <li class="nav-small-cap"><span class="hide-menu">Menu Warga</span></li>

                <!-- Dashboard Warga -->
                <li class="sidebar-item <?= ($seg1 === 'dashboard-warga') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'dashboard-warga') ? 'active' : '' ?>" href="<?= base_url('dashboard-warga') ?>" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard Warga</span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Iuran Saya</span></li>

                <!-- Tagihan Saya -->
                <li class="sidebar-item <?= ($seg1 === 'iuran' && $seg2 === 'tagihan') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'iuran' && $seg2 === 'tagihan') ? 'active' : '' ?>" href="<?= base_url('iuran/tagihan') ?>" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">Tagihan Saya</span>
                    </a>
                </li>

                <!-- Bayar Iuran -->
                <li class="sidebar-item <?= ($seg1 === 'iuran' && $seg2 === 'bayar') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'iuran' && $seg2 === 'bayar') ? 'active' : '' ?>" href="<?= base_url('iuran/bayar') ?>" aria-expanded="false">
                        <i data-feather="credit-card" class="feather-icon"></i>
                        <span class="hide-menu">Bayar Iuran</span>
                    </a>
                </li>

                <!-- Riwayat Bayar -->
                <li class="sidebar-item <?= ($seg1 === 'iuran' && $seg2 === 'riwayat') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'iuran' && $seg2 === 'riwayat') ? 'active' : '' ?>" href="<?= base_url('iuran/riwayat') ?>" aria-expanded="false">
                        <i data-feather="clock" class="feather-icon"></i>
                        <span class="hide-menu">Riwayat Pembayaran</span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Transparansi</span></li>

                <!-- Laporan Kas Terbuka -->
                <li class="sidebar-item <?= ($seg1 === 'laporan-warga') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'laporan-warga') ? 'active' : '' ?>" href="<?= base_url('laporan-warga') ?>" aria-expanded="false">
                        <i data-feather="bar-chart-2" class="feather-icon"></i>
                        <span class="hide-menu">Laporan Kas RT</span>
                    </a>
                </li>

            <?php else : ?>
                <!-- ============================================================== -->
                <!-- MENU KHUSUS ROLE PENGURUS RT (ADMIN) -->
                <!-- ============================================================== -->
                <li class="nav-small-cap"><span class="hide-menu">Menu Utama</span></li>

                <!-- Dashboard -->
                <li class="sidebar-item <?= ($seg1 === '' || $seg1 === 'dashboard') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === '' || $seg1 === 'dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Data Warga -->
                <li class="sidebar-item <?= ($seg1 === 'warga') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'warga') ? 'active' : '' ?>" href="<?= base_url('warga') ?>" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">Data Warga</span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Keuangan RT</span></li>

                <!-- Iuran -->
                <li class="sidebar-item <?= ($seg1 === 'iuran') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'iuran' && $seg2 === '') ? 'active' : '' ?>" href="<?= base_url('iuran') ?>" aria-expanded="false">
                        <i data-feather="dollar-sign" class="feather-icon"></i>
                        <span class="hide-menu">Daftar Iuran Warga</span>
                    </a>
                </li>

                <!-- Pengeluaran -->
                <li class="sidebar-item <?= ($seg1 === 'pengeluaran' || $seg1 === 'kategori') ? 'selected' : '' ?>">
                    <a class="sidebar-link has-arrow <?= ($seg1 === 'pengeluaran' || $seg1 === 'kategori') ? 'active' : '' ?>" href="javascript:void(0)" aria-expanded="<?= ($seg1 === 'pengeluaran' || $seg1 === 'kategori') ? 'true' : 'false' ?>">
                        <i data-feather="arrow-down-circle" class="feather-icon"></i>
                        <span class="hide-menu">Pengeluaran</span>
                    </a>
                    <ul aria-expanded="<?= ($seg1 === 'pengeluaran' || $seg1 === 'kategori') ? 'true' : 'false' ?>" class="collapse first-level base-level-line <?= ($seg1 === 'pengeluaran' || $seg1 === 'kategori') ? 'in' : '' ?>">
                        <li class="sidebar-item <?= ($seg1 === 'pengeluaran') ? 'active' : '' ?>">
                            <a href="<?= base_url('pengeluaran') ?>" class="sidebar-link <?= ($seg1 === 'pengeluaran') ? 'active' : '' ?>">
                                <span class="hide-menu">Daftar Pengeluaran</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= ($seg1 === 'kategori') ? 'active' : '' ?>">
                            <a href="<?= base_url('kategori') ?>" class="sidebar-link <?= ($seg1 === 'kategori') ? 'active' : '' ?>">
                                <span class="hide-menu">Kategori Pengeluaran</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Laporan &amp; Pengaturan</span></li>

                <!-- Laporan -->
                <li class="sidebar-item <?= ($seg1 === 'laporan') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'laporan') ? 'active' : '' ?>" href="<?= base_url('laporan') ?>" aria-expanded="false">
                        <i data-feather="bar-chart-2" class="feather-icon"></i>
                        <span class="hide-menu">Laporan Kas</span>
                    </a>
                </li>

                <!-- Pengaturan Iuran -->
                <li class="sidebar-item <?= ($seg1 === 'pengaturan') ? 'selected' : '' ?>">
                    <a class="sidebar-link <?= ($seg1 === 'pengaturan') ? 'active' : '' ?>" href="<?= base_url('pengaturan/iuran') ?>" aria-expanded="false">
                        <i data-feather="settings" class="feather-icon"></i>
                        <span class="hide-menu">Pengaturan Wilayah &amp; Iuran</span>
                    </a>
                </li>
            <?php endif; ?>

                <li class="list-divider"></li>

                <!-- Tombol Keluar -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link text-danger" href="<?= base_url('logout') ?>" aria-expanded="false">
                        <i data-feather="log-out" class="feather-icon text-danger"></i>
                        <span class="hide-menu text-danger">Keluar</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>