<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth routes
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::prosesRegister');
$routes->get('/logout', 'AuthController::logout');

// Dashboard routes
$routes->get('/', 'DashboardController::index');
$routes->get('/dashboard', 'DashboardController::index');

// Warga routes
$routes->get('/warga', 'WargaController::index');
$routes->get('/warga/create', 'WargaController::create');
$routes->post('/warga/store', 'WargaController::store');
$routes->get('/warga/edit/(:num)', 'WargaController::edit/$1');
$routes->post('/warga/update/(:num)', 'WargaController::update/$1');
$routes->post('/warga/delete/(:num)', 'WargaController::delete/$1');

// Iuran routes
$routes->get('/iuran', 'IuranController::index');
$routes->get('/iuran/tagihan', 'IuranController::tagihan');
$routes->get('/iuran/bayar', 'IuranController::bayar');
$routes->post('/iuran/bayar/proses', 'IuranController::prosesBayar');
$routes->get('/iuran/riwayat', 'IuranController::riwayat');
$routes->get('/iuran/verifikasi/(:num)', 'IuranController::verifikasi/$1');
$routes->post('/iuran/verifikasi/proses/(:num)', 'IuranController::prosesVerifikasi/$1');

// Pengeluaran routes
$routes->get('/pengeluaran', 'PengeluaranController::index');
$routes->get('/pengeluaran/create', 'PengeluaranController::create');
$routes->post('/pengeluaran/store', 'PengeluaranController::store');
$routes->get('/pengeluaran/edit/(:num)', 'PengeluaranController::edit/$1');
$routes->post('/pengeluaran/update/(:num)', 'PengeluaranController::update/$1');
$routes->post('/pengeluaran/delete/(:num)', 'PengeluaranController::delete/$1');

// Kategori routes
$routes->get('/kategori', 'KategoriController::index');
$routes->get('/kategori/create', 'KategoriController::create');
$routes->post('/kategori/store', 'KategoriController::store');
$routes->get('/kategori/edit/(:num)', 'KategoriController::edit/$1');
$routes->post('/kategori/update/(:num)', 'KategoriController::update/$1');
$routes->post('/kategori/delete/(:num)', 'KategoriController::delete/$1');

// Pengaturan Iuran routes
$routes->get('/pengaturan/iuran', 'PengaturanController::iuran');
$routes->post('/pengaturan/iuran/update', 'PengaturanController::updateIuran');

// Laporan routes
$routes->get('/laporan', 'LaporanController::index');
