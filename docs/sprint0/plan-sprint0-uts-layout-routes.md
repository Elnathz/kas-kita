# Sprint 0: Foundation dan Branch UTS - Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Setup proyek, slicing layout FreeDash-lite ke CI4, buat semua controller/view skeleton, dan routing lengkap di branch `uts`.

**Architecture:** MVC CI4 standar. Layout FreeDash-lite dipecah jadi komponen (header, sidebar, footer) yang di-include ke layout utama. Semua controller return view saja tanpa model. Login hardcoded.

**Tech Stack:** CodeIgniter 4.7, PHP 8.2, Bootstrap 5 (FreeDash-lite), MySQL (dbngin port 3309)

## Global Constraints

- Template: FreeDash-lite dari adminmart, tidak modifikasi file asli, override via custom CSS
- Tidak boleh emoji di UI, hanya icon dari library (Bootstrap Icons / FreeDash icons)
- Tidak boleh em dash di kode/komentar
- Tidak boleh gradien ala AI
- Commit atomic, format: `<type>(<scope>): penjelasan`
- Branch: `uts`
- Login: hardcoded (admin/admin123 dengan md5)
- Mobile first untuk layout

---

### Task 1: Project Setup dan Git Init

**Files:**
- Modify: `.env`
- Modify: `.gitignore`
- Create: `docs/tdd.md` (sudah ada)
- Create: `docs/tdd_changes_tracker.md` (sudah ada)
- Create: `AGENTS.md` (sudah ada)

**Produces:** Git repo siap pakai dengan konfigurasi yang benar

- [ ] **Step 1: Init git repo**

```bash
cd c:\Kuliah\Semester Antara\PWL\kas-kita
git init
```

- [ ] **Step 2: Fix .env konfigurasi database**

```ini
database.default.hostname = localhost
database.default.database = dbkaskita
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3309
```

- [ ] **Step 3: Initial commit di main**

```bash
git add .
git commit -m "chore(config): initial project setup

- init CodeIgniter 4.7 project
- konfigurasi database dbngin port 3309, db dbkaskita
- tambah AGENTS.md, TDD, sprint planning
- tambah tdd_changes_tracker.md"
```

- [ ] **Step 4: Buat dan switch ke branch uts**

```bash
git checkout -b uts
```

---

### Task 2: Clone dan Ekstrak FreeDash-lite Assets

**Files:**
- Create: `public/assets/css/` (dari FreeDash-lite)
- Create: `public/assets/js/` (dari FreeDash-lite)
- Create: `public/assets/images/` (dari FreeDash-lite)
- Create: `public/assets/libs/` (vendor libraries dari FreeDash-lite)

**Produces:** Semua static assets FreeDash-lite tersedia di public/assets/

- [ ] **Step 1: Clone FreeDash-lite ke temporary**

```bash
git clone https://github.com/adminmart/FreeDash-lite.git temp-freedash
```

- [ ] **Step 2: Copy assets ke public/**

Copy folder berikut dari `temp-freedash/` ke `public/assets/`:
- `dist/css/` -> `public/assets/css/`
- `dist/js/` -> `public/assets/js/`
- `dist/images/` -> `public/assets/images/`
- `dist/libs/` -> `public/assets/libs/`

- [ ] **Step 3: Hapus temporary clone**

```bash
rm -rf temp-freedash
```

- [ ] **Step 4: Commit**

```bash
git add public/assets/
git commit -m "chore(layout): tambah assets FreeDash-lite template

- copy css, js, images, dan vendor libs dari FreeDash-lite
- assets siap digunakan untuk layout slicing"
```

---

### Task 3: Layout Slicing - Layout Utama

**Files:**
- Create: `app/Views/layouts/app.php`

**Produces:** Layout wrapper yang bisa dipakai semua halaman

- [ ] **Step 1: Buat file layout utama**

`app/Views/layouts/app.php` - Struktur HTML dasar dengan slot untuk header, sidebar, content, footer:

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Kas-Kita' ?> - Kas-Kita</title>
    <!-- CSS FreeDash -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.min.css') ?>">
    <!-- Custom CSS -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
         data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar -->
        <?= $this->include('components/sidebar') ?>
        <!-- Main Content -->
        <div class="body-wrapper">
            <!-- Header -->
            <?= $this->include('components/header') ?>
            <!-- Content -->
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
                <!-- Footer -->
                <?= $this->include('components/footer') ?>
            </div>
        </div>
    </div>
    <!-- JS FreeDash -->
    <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.min.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
```

- [ ] **Step 2: Verifikasi file bisa di-load tanpa error**

- [ ] **Step 3: Commit**

```bash
git add app/Views/layouts/
git commit -m "layout(layout): buat layout utama app.php

- struktur HTML dengan slot untuk header, sidebar, footer
- include CSS dan JS FreeDash-lite
- support dynamic title dan section untuk styles/scripts"
```

---

### Task 4: Layout Slicing - Header

**Files:**
- Create: `app/Views/components/header.php`

**Produces:** Komponen header navbar atas

- [ ] **Step 1: Buat header.php**

Navbar atas dengan: brand/logo, user info dropdown (nama, logout)

- [ ] **Step 2: Commit**

```bash
git add app/Views/components/header.php
git commit -m "layout(layout): slicing komponen header navbar

- navbar atas dengan brand Kas-Kita
- user info dropdown dengan nama dan tombol logout
- responsive untuk mobile"
```

---

### Task 5: Layout Slicing - Sidebar

**Files:**
- Create: `app/Views/components/sidebar.php`

**Produces:** Komponen sidebar navigasi

- [ ] **Step 1: Buat sidebar.php**

Sidebar dengan menu navigasi. Untuk branch UTS, tampilkan semua menu (pengurus). Active state berdasarkan URL segment.

Menu items:
- Dashboard (`/dashboard`)
- Data Warga (`/warga`)
- Iuran (dropdown):
  - Daftar Iuran (`/iuran`)
  - Verifikasi Pembayaran (`/iuran/verifikasi`)
- Pengeluaran (dropdown):
  - Daftar Pengeluaran (`/pengeluaran`)
  - Kategori (`/kategori`)
- Pengaturan Iuran (`/pengaturan/iuran`)
- Laporan (`/laporan`)

- [ ] **Step 2: Implementasi active state**

Gunakan `service('uri')->getSegment(1)` untuk highlight menu aktif.

- [ ] **Step 3: Commit**

```bash
git add app/Views/components/sidebar.php
git commit -m "layout(layout): slicing komponen sidebar navigasi

- menu navigasi lengkap untuk semua modul
- submenu dropdown untuk iuran dan pengeluaran
- active state berdasarkan URL segment
- logo dan brand name Kas-Kita"
```

---

### Task 6: Layout Slicing - Footer

**Files:**
- Create: `app/Views/components/footer.php`

**Produces:** Komponen footer

- [ ] **Step 1: Buat footer.php**

Footer sederhana dengan copyright dan nama aplikasi.

- [ ] **Step 2: Commit**

```bash
git add app/Views/components/footer.php
git commit -m "layout(layout): slicing komponen footer

- copyright text dengan tahun dan nama aplikasi"
```

---

### Task 7: Halaman Login

**Files:**
- Create: `app/Views/auth/login.php`
- Create: `app/Controllers/Auth/LoginController.php`

**Produces:** Halaman login standalone (tanpa sidebar) dan controller dengan hardcoded auth

- [ ] **Step 1: Buat login.php**

Halaman login standalone (tidak pakai layout app.php). Include CSS FreeDash sendiri. Form: username, password, tombol login.

- [ ] **Step 2: Buat LoginController**

```php
<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Hardcoded credentials
        $validUsername = 'admin';
        $validPassword = md5('admin123');

        if ($username === $validUsername && md5($password) === $validPassword) {
            session()->set([
                'user_id'   => 1,
                'username'  => $username,
                'nama'      => 'Administrator',
                'role'      => 'pengurus',
                'logged_in' => true,
            ]);
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
```

- [ ] **Step 3: Test login flow**

- [ ] **Step 4: Commit**

```bash
git add app/Views/auth/ app/Controllers/Auth/
git commit -m "feat(auth): implementasi login hardcoded dengan md5

- halaman login standalone tanpa sidebar
- LoginController dengan hardcoded credentials (admin/admin123)
- validasi password dengan md5
- session native untuk menyimpan status login
- redirect ke dashboard setelah login berhasil
- logout destroy session dan redirect ke login"
```

---

### Task 8: Dashboard Controller dan View

**Files:**
- Create: `app/Controllers/Dashboard/DashboardController.php`
- Create: `app/Views/dashboard/index.php`

**Produces:** Halaman dashboard dengan data dummy

- [ ] **Step 1: Buat DashboardController**

```php
class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard/index', $data);
    }
}
```

- [ ] **Step 2: Buat dashboard view**

Halaman dashboard dengan layout FreeDash. Tampilkan card statistik (dummy): total pemasukan, total pengeluaran, saldo, jumlah warga.

- [ ] **Step 3: Commit**

```bash
git add app/Controllers/Dashboard/ app/Views/dashboard/
git commit -m "feat(dashboard): buat halaman dashboard dengan data dummy

- DashboardController return view dengan title
- view dashboard dengan card statistik (data dummy)
- extend layout app.php"
```

---

### Task 9: Warga Controller dan Views

**Files:**
- Create: `app/Controllers/Warga/WargaController.php`
- Create: `app/Views/warga/index.php`
- Create: `app/Views/warga/create.php`
- Create: `app/Views/warga/edit.php`

**Produces:** Skeleton halaman manajemen warga

- [ ] **Step 1: Buat WargaController**

Methods: index(), create(), edit($id). Semua return view dengan data dummy.

- [ ] **Step 2: Buat views**

- index.php: Tabel daftar warga (data dummy), tombol tambah, edit, hapus
- create.php: Form tambah warga (nama, username, password, no rumah, telepon, alamat)
- edit.php: Form edit warga (prefilled data dummy)

- [ ] **Step 3: Commit**

```bash
git add app/Controllers/Warga/ app/Views/warga/
git commit -m "feat(warga): buat skeleton halaman manajemen warga

- WargaController dengan method index, create, edit
- view index dengan tabel daftar warga (data dummy)
- view create dengan form tambah warga
- view edit dengan form edit warga
- semua view extend layout app.php"
```

---

### Task 10: Iuran Controller dan Views

**Files:**
- Create: `app/Controllers/Iuran/IuranController.php`
- Create: `app/Views/iuran/index.php`
- Create: `app/Views/iuran/bayar.php`
- Create: `app/Views/iuran/riwayat.php`
- Create: `app/Views/iuran/tagihan.php`
- Create: `app/Views/iuran/verifikasi.php`

**Produces:** Skeleton halaman iuran dan pembayaran

- [ ] **Step 1: Buat IuranController**

Methods: index(), bayar(), riwayat(), tagihan(), verifikasi($id). Semua return view.

- [ ] **Step 2: Buat views**

- index.php: Tabel status iuran per warga (data dummy)
- bayar.php: Form bayar iuran (pilih periode, upload bukti)
- riwayat.php: Tabel riwayat pembayaran (data dummy)
- tagihan.php: Daftar tagihan warga (data dummy)
- verifikasi.php: Detail pembayaran + bukti transfer (data dummy)

- [ ] **Step 3: Commit**

```bash
git add app/Controllers/Iuran/ app/Views/iuran/
git commit -m "feat(iuran): buat skeleton halaman iuran dan pembayaran

- IuranController dengan method index, bayar, riwayat, tagihan, verifikasi
- view index: tabel status iuran per warga
- view bayar: form pembayaran dengan upload bukti
- view riwayat: tabel riwayat pembayaran
- view tagihan: daftar tagihan warga
- view verifikasi: detail dan validasi pembayaran
- semua data dummy, semua extend layout app.php"
```

---

### Task 11: Pengeluaran Controller dan Views

**Files:**
- Create: `app/Controllers/Pengeluaran/PengeluaranController.php`
- Create: `app/Views/pengeluaran/index.php`
- Create: `app/Views/pengeluaran/create.php`
- Create: `app/Views/pengeluaran/edit.php`

**Produces:** Skeleton halaman pengeluaran

- [ ] **Step 1: Buat PengeluaranController**

Methods: index(), create(), edit($id). Semua return view.

- [ ] **Step 2: Buat views**

- index.php: Tabel pengeluaran (data dummy)
- create.php: Form tambah pengeluaran
- edit.php: Form edit pengeluaran

- [ ] **Step 3: Commit**

```bash
git add app/Controllers/Pengeluaran/ app/Views/pengeluaran/
git commit -m "feat(pengeluaran): buat skeleton halaman pengeluaran

- PengeluaranController dengan method index, create, edit
- view index: tabel daftar pengeluaran (data dummy)
- view create: form tambah pengeluaran
- view edit: form edit pengeluaran
- semua extend layout app.php"
```

---

### Task 12: Kategori, Laporan, Pengaturan Controller dan Views

**Files:**
- Create: `app/Controllers/Kategori/KategoriController.php`
- Create: `app/Views/kategori/index.php`
- Create: `app/Views/kategori/create.php`
- Create: `app/Views/kategori/edit.php`
- Create: `app/Controllers/Laporan/LaporanController.php`
- Create: `app/Views/laporan/index.php`
- Create: `app/Controllers/Pengaturan/PengaturanController.php`
- Create: `app/Views/pengaturan/iuran.php`

**Produces:** Skeleton halaman kategori, laporan, dan pengaturan

- [ ] **Step 1: Buat KategoriController dan views**

- [ ] **Step 2: Buat LaporanController dan view**

- [ ] **Step 3: Buat PengaturanController dan view**

- [ ] **Step 4: Commit**

```bash
git add app/Controllers/Kategori/ app/Controllers/Laporan/ app/Controllers/Pengaturan/
git add app/Views/kategori/ app/Views/laporan/ app/Views/pengaturan/
git commit -m "feat(routes): buat skeleton kategori, laporan, dan pengaturan

- KategoriController dengan CRUD views
- LaporanController dengan view rekap bulanan
- PengaturanController dengan view pengaturan iuran
- semua data dummy, extend layout app.php"
```

---

### Task 13: Setup Routes Lengkap

**Files:**
- Modify: `app/Config/Routes.php`

**Produces:** Semua route terdefinisi dan bisa diakses

- [ ] **Step 1: Define semua routes**

```php
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth
$routes->get('/login', 'Auth\LoginController::index');
$routes->post('/login', 'Auth\LoginController::authenticate');
$routes->get('/logout', 'Auth\LoginController::logout');

// Dashboard
$routes->get('/', 'Dashboard\DashboardController::index');
$routes->get('/dashboard', 'Dashboard\DashboardController::index');

// Warga
$routes->get('/warga', 'Warga\WargaController::index');
$routes->get('/warga/create', 'Warga\WargaController::create');
$routes->post('/warga/store', 'Warga\WargaController::store');
$routes->get('/warga/edit/(:num)', 'Warga\WargaController::edit/$1');
$routes->post('/warga/update/(:num)', 'Warga\WargaController::update/$1');
$routes->post('/warga/delete/(:num)', 'Warga\WargaController::delete/$1');

// Iuran
$routes->get('/iuran', 'Iuran\IuranController::index');
$routes->get('/iuran/tagihan', 'Iuran\IuranController::tagihan');
$routes->get('/iuran/bayar', 'Iuran\IuranController::bayar');
$routes->post('/iuran/bayar/proses', 'Iuran\IuranController::prosesBayar');
$routes->get('/iuran/riwayat', 'Iuran\IuranController::riwayat');
$routes->get('/iuran/verifikasi/(:num)', 'Iuran\IuranController::verifikasi/$1');
$routes->post('/iuran/verifikasi/proses/(:num)', 'Iuran\IuranController::prosesVerifikasi/$1');

// Pengeluaran
$routes->get('/pengeluaran', 'Pengeluaran\PengeluaranController::index');
$routes->get('/pengeluaran/create', 'Pengeluaran\PengeluaranController::create');
$routes->post('/pengeluaran/store', 'Pengeluaran\PengeluaranController::store');
$routes->get('/pengeluaran/edit/(:num)', 'Pengeluaran\PengeluaranController::edit/$1');
$routes->post('/pengeluaran/update/(:num)', 'Pengeluaran\PengeluaranController::update/$1');
$routes->post('/pengeluaran/delete/(:num)', 'Pengeluaran\PengeluaranController::delete/$1');

// Kategori Pengeluaran
$routes->get('/kategori', 'Kategori\KategoriController::index');
$routes->get('/kategori/create', 'Kategori\KategoriController::create');
$routes->post('/kategori/store', 'Kategori\KategoriController::store');
$routes->get('/kategori/edit/(:num)', 'Kategori\KategoriController::edit/$1');
$routes->post('/kategori/update/(:num)', 'Kategori\KategoriController::update/$1');
$routes->post('/kategori/delete/(:num)', 'Kategori\KategoriController::delete/$1');

// Pengaturan
$routes->get('/pengaturan/iuran', 'Pengaturan\PengaturanController::iuran');
$routes->post('/pengaturan/iuran/update', 'Pengaturan\PengaturanController::updateIuran');

// Laporan
$routes->get('/laporan', 'Laporan\LaporanController::index');
```

- [ ] **Step 2: Test semua route bisa diakses tanpa 404**

Buka setiap URL di browser, pastikan tidak ada error.

- [ ] **Step 3: Commit**

```bash
git add app/Config/Routes.php
git commit -m "feat(routes): setup semua routing aplikasi

- route auth: login, logout
- route dashboard
- route CRUD warga
- route iuran: daftar, tagihan, bayar, riwayat, verifikasi
- route CRUD pengeluaran
- route CRUD kategori
- route pengaturan iuran
- route laporan"
```

---

### Task 14: Final Review Branch UTS

**Files:** Semua file yang sudah dibuat

**Produces:** Branch UTS yang bersih dan siap

- [ ] **Step 1: Test login flow end-to-end**

1. Buka `/login`
2. Login dengan admin/admin123
3. Pastikan redirect ke dashboard
4. Navigasi ke setiap menu di sidebar
5. Pastikan semua halaman tampil tanpa error
6. Logout, pastikan redirect ke login

- [ ] **Step 2: Check responsive (mobile view)**

Resize browser ke 375px width, pastikan layout responsive.

- [ ] **Step 3: Final commit jika ada perbaikan**

- [ ] **Step 4: Push branch uts**

```bash
git push -u origin uts
```
