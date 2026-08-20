<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth routes
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::prosesRegister');
$routes->get('/logout', 'AuthController::logout');

// Dashboard routes (Guest trying to access / will be redirected to login via AuthFilter, but let's map / to login directly for guest)
$routes->get('/', 'AuthController::index');

$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Switch Role
    $routes->get('/switch-role', 'AuthController::switchRole');

    // Kuitansi dapat dibuka oleh pengurus maupun warga setelah pembayaran terverifikasi.
    $routes->get('/iuran/kuitansi/(:num)', 'IuranController::kuitansi/$1');

    // Warga Routes
    $routes->group('', ['filter' => 'role:warga'], function($routes) {
        $routes->get('/dashboard-warga', 'DashboardController::warga');
        
        // Iuran Warga
        $routes->get('/iuran/tagihan', 'IuranController::tagihan');
        $routes->get('/iuran/bayar', 'IuranController::bayar');
        $routes->post('/iuran/bayar/proses', 'IuranController::prosesBayar');
        $routes->get('/iuran/riwayat', 'IuranController::riwayat');
        // Laporan Warga
        $routes->get('/laporan-warga', 'LaporanController::warga');
        
        // Profil
        $routes->get('/profil', 'ProfilController::index');
        $routes->post('/profil/update', 'ProfilController::update');
        $routes->post('/profil/password', 'ProfilController::updatePassword');
    });

    // Pengurus Routes
    $routes->group('', ['filter' => 'role:pengurus'], function($routes) {
        $routes->get('/dashboard', 'DashboardController::index');
        
        // Warga Management
        $routes->get('/warga', 'WargaController::index');
        $routes->get('/warga/create', 'WargaController::create');
        $routes->post('/warga/store', 'WargaController::store');
        $routes->get('/warga/edit/(:num)', 'WargaController::edit/$1');
        $routes->post('/warga/update/(:num)', 'WargaController::update/$1');
        $routes->post('/warga/delete/(:num)', 'WargaController::delete/$1');
        $routes->post('/warga/approve/(:num)', 'WargaController::approve/$1');
        $routes->post('/warga/reject/(:num)', 'WargaController::reject/$1');

        // Iuran Management
        $routes->get('/iuran', 'IuranController::index');
        $routes->get('/iuran/verifikasi/(:num)', 'IuranController::verifikasi/$1');
        $routes->post('/iuran/verifikasi/proses/(:num)', 'IuranController::prosesVerifikasi/$1');

        // Pengeluaran Management
        $routes->get('/pengeluaran', 'PengeluaranController::index');
        $routes->get('/pengeluaran/create', 'PengeluaranController::create');
        $routes->post('/pengeluaran/store', 'PengeluaranController::store');
        $routes->get('/pengeluaran/edit/(:num)', 'PengeluaranController::edit/$1');
        $routes->post('/pengeluaran/update/(:num)', 'PengeluaranController::update/$1');
        $routes->post('/pengeluaran/delete/(:num)', 'PengeluaranController::delete/$1');

        // Kategori Management
        $routes->get('/kategori', 'KategoriController::index');
        $routes->get('/kategori/create', 'KategoriController::create');
        $routes->post('/kategori/store', 'KategoriController::store');
        $routes->get('/kategori/edit/(:num)', 'KategoriController::edit/$1');
        $routes->post('/kategori/update/(:num)', 'KategoriController::update/$1');
        $routes->post('/kategori/delete/(:num)', 'KategoriController::delete/$1');

        // Pengaturan
        $routes->get('/pengaturan/iuran', 'PengaturanController::iuran');
        $routes->post('/pengaturan/iuran/update', 'PengaturanController::updateIuran');
        $routes->post('/pengaturan/iuran/metode/store', 'PengaturanController::storeMetode');
        $routes->post('/pengaturan/iuran/metode/update/(:num)', 'PengaturanController::updateMetode/$1');
        $routes->post('/pengaturan/iuran/metode/delete/(:num)', 'PengaturanController::deleteMetode/$1');
        $routes->post('/pengaturan/iuran/jalan/add', 'PengaturanController::addJalan');
        $routes->post('/pengaturan/iuran/jalan/delete/(:num)', 'PengaturanController::deleteJalan/$1');
        $routes->post('/pengaturan/iuran/blok/add', 'PengaturanController::addBlok');
        $routes->post('/pengaturan/iuran/blok/delete/(:num)', 'PengaturanController::deleteBlok/$1');

        // Laporan Pengurus
        $routes->get('/laporan', 'LaporanController::index');
    });
});
