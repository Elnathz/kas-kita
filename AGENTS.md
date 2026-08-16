# AGENTS.md - Aturan Pengerjaan Proyek Kas-Kita

## Identitas Proyek

- **Nama**: Kas-Kita (Aplikasi Manajemen Kas RT)
- **Tech Stack**: CodeIgniter 4.7, Bootstrap 5, PHP 8.2+, MySQL (dbngin port 3309, db: dbkaskita)
- **Template**: FreeDash-lite (adminmart)

---

## Source of Truth

**TDD (Technical Design Document) adalah satu-satunya source of truth.** Semua keputusan teknis, struktur data, flow aplikasi, dan scope fitur harus merujuk ke dokumen TDD di `docs/tdd.md`. Jika ada perbedaan antara kode dan TDD, TDD yang benar.

Setiap perubahan terhadap TDD wajib dicatat di `docs/tdd_changes_tracker.md` dengan format:

```markdown
## [Tanggal] - [Judul Perubahan]
- **Sebelum**: [deskripsi kondisi sebelum]
- **Sesudah**: [deskripsi kondisi sesudah]
- **Alasan**: [mengapa berubah]
- **Dampak**: [file/fitur apa yang terdampak]
```

---

## Branching Strategy

```
main (fitur lengkap - UAS)
 |
 +-- uts (slicing layout + routes + dummy login)
```

- **Branch `uts`**: Layout slicing, routing, MVC tanpa filter/session/migration/seeder/CRUD/library. Login hardcoded dengan md5.
- **Branch `main`**: Fitur lengkap termasuk session, filter, migration, seeder, CRUD, validasi, upload bukti transfer, laporan.

**Alur kerja:**
1. Mulai dari `uts` - selesaikan semua layout slicing dan routes
2. Merge `uts` ke `main`
3. Lanjutkan fitur lengkap di `main`

---

## Konvensi Commit

Commit WAJIB atomic. Satu commit = satu perubahan logis yang bisa berdiri sendiri.

### Format

```
<type>(<scope>): penjelasan singkat

- detail perubahan 1
- detail perubahan 2
```

### Type yang Digunakan

| Type       | Kegunaan                                    |
|------------|---------------------------------------------|
| `feat`     | Fitur baru                                  |
| `fix`      | Perbaikan bug                               |
| `refactor` | Perubahan kode tanpa ubah fungsionalitas    |
| `style`    | Perubahan formatting, whitespace, dll       |
| `docs`     | Perubahan dokumentasi                       |
| `chore`    | Setup, config, dependency                   |
| `test`     | Penambahan atau perbaikan test              |
| `layout`   | Khusus untuk slicing layout                 |

### Scope yang Digunakan

| Scope       | Kegunaan                                   |
|-------------|---------------------------------------------|
| `auth`      | Login, logout, session                      |
| `dashboard` | Halaman dashboard                           |
| `warga`     | Manajemen data warga                        |
| `iuran`     | Iuran dan pembayaran                        |
| `pengeluaran`| Pencatatan pengeluaran                     |
| `kategori`  | Kategori pengeluaran                        |
| `laporan`   | Report dan rekap                            |
| `layout`    | Layout template (header, sidebar, footer)   |
| `routes`    | Routing                                     |
| `config`    | Konfigurasi aplikasi                        |
| `db`        | Database, migration, seeder                 |

### Contoh Commit yang Benar

```
feat(layout): slicing sidebar navigation dari FreeDash-lite

- menambahkan komponen sidebar di app/Views/components/sidebar.php
- menambahkan menu navigasi untuk dashboard, warga, iuran, pengeluaran, dan laporan
- menambahkan logo dan brand name
```

```
feat(routes): menambahkan routing untuk modul warga

- GET /warga -> WargaController::index
- GET /warga/create -> WargaController::create
- POST /warga/store -> WargaController::store
- GET /warga/edit/(:num) -> WargaController::edit/$1
```

### Commit yang DILARANG

- Commit dengan pesan generik: "update", "fix bug", "changes", "WIP"
- Commit yang mencampur banyak perubahan tidak terkait
- Commit yang isinya kosong atau hanya whitespace

---

## Aturan Anti-AI Slop

Aturan ini WAJIB dipatuhi tanpa terkecuali:

### 1. Tidak Boleh Pakai Emoji di Kode dan UI

- **DILARANG**: Emoji unicode di judul halaman, menu, heading, button, atau teks apapun
- **BOLEH**: Icon dari library asli (Bootstrap Icons, Feather Icons, atau icon bawaan FreeDash-lite)
- **Contoh salah**: `<h1>Dashboard</h1>` (NO EMOJI)
- **Contoh benar**: `<h1><i class="bi bi-speedometer2"></i> Dashboard</h1>`

### 2. Tidak Boleh Pakai Em Dash

- **DILARANG**: Karakter em dash (--) di kode, komentar, atau dokumentasi
- **BOLEH**: Tanda hubung biasa (-), en dash jika perlu, atau tulis ulang kalimatnya

### 3. Tidak Boleh Design Gradien ala AI

- **DILARANG**: Gradien warna-warni yang terlihat generic/AI-generated (misal purple-to-blue hero section)
- **BOLEH**: Warna solid, gradien subtle yang memang ada di template FreeDash-lite
- Ikuti color scheme dari FreeDash-lite, jangan buat custom gradient yang tidak ada di template

### 4. Teks Harus Natural

- Tidak boleh pakai bahasa yang terdengar seperti AI (overly formal, repetitif, atau generic)
- Label, placeholder, dan pesan error harus dalam Bahasa Indonesia yang natural
- Contoh salah: "Silakan masukkan data yang valid untuk melanjutkan proses"
- Contoh benar: "Data tidak valid, periksa kembali"

---

## Workflow Development

### Sebelum Membuat Fitur Baru

1. **Brainstorming** - Wajib pakai skill brainstorming dari superpowers. Tidak boleh langsung coding.
2. **Planning** - Wajib buat plan terlebih dahulu dan simpan di `docs/sprint0/` (atau folder sprint yang sesuai)
3. **Review TDD** - Pastikan fitur yang akan dibuat sesuai dengan TDD

### Saat Mengerjakan

1. Cek TDD untuk scope dan requirement fitur
2. Buat plan jika belum ada
3. Kerjakan sesuai plan
4. Commit secara atomic setiap menyelesaikan satu unit kerja
5. Test manual bahwa fitur berjalan

### Setelah Selesai

1. Pastikan tidak ada error atau warning
2. Update progress di walkthrough
3. Catat jika ada perubahan TDD di `docs/tdd_changes_tracker.md`

---

## Struktur Folder Proyek

```
kas-kita/
|-- app/
|   |-- Config/
|   |   |-- Routes.php
|   |   |-- Filters.php (branch main)
|   |-- Controllers/
|   |   |-- Auth/
|   |   |   |-- LoginController.php
|   |   |-- Dashboard/
|   |   |   |-- DashboardController.php
|   |   |-- Warga/
|   |   |   |-- WargaController.php
|   |   |-- Iuran/
|   |   |   |-- IuranController.php
|   |   |-- Pengeluaran/
|   |   |   |-- PengeluaranController.php
|   |   |-- Kategori/
|   |   |   |-- KategoriController.php (branch main)
|   |   |-- Laporan/
|   |   |   |-- LaporanController.php (branch main)
|   |-- Models/ (branch main)
|   |-- Filters/ (branch main)
|   |-- Database/
|   |   |-- Migrations/ (branch main)
|   |   |-- Seeds/ (branch main)
|   |-- Views/
|   |   |-- layouts/
|   |   |   |-- app.php (layout utama)
|   |   |-- components/
|   |   |   |-- header.php
|   |   |   |-- sidebar.php
|   |   |   |-- footer.php
|   |   |-- auth/
|   |   |   |-- login.php
|   |   |-- dashboard/
|   |   |   |-- index.php
|   |   |-- warga/
|   |   |   |-- index.php
|   |   |   |-- create.php
|   |   |   |-- edit.php
|   |   |-- iuran/
|   |   |   |-- index.php
|   |   |   |-- bayar.php
|   |   |   |-- riwayat.php
|   |   |-- pengeluaran/
|   |   |   |-- index.php
|   |   |   |-- create.php
|   |   |-- laporan/
|   |   |   |-- index.php
|-- public/
|   |-- assets/
|   |   |-- css/ (dari FreeDash-lite)
|   |   |-- js/ (dari FreeDash-lite)
|   |   |-- images/
|   |   |-- libs/ (vendor libraries)
|-- docs/
|   |-- tdd.md
|   |-- tdd_changes_tracker.md
|   |-- studi-kasus-aplikasi-rt.md
|   |-- sprint0/
|   |   |-- (plan files)
```

---

## Environment

```ini
CI_ENVIRONMENT = development
database.default.hostname = localhost
database.default.database = dbkaskita
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3309
```

---

## Catatan Penting

1. Template FreeDash-lite di-clone dan asset-nya diekstrak ke `public/assets/`. Jangan modifikasi file asset template secara langsung, override lewat custom CSS jika perlu.
2. Bootstrap 5 sudah include di FreeDash-lite, jangan tambah Bootstrap lagi dari CDN.
3. Untuk branch `uts`, login menggunakan data hardcoded:
   - Username: `admin`
   - Password: `admin123` (disimpan sebagai md5 hash)
   - Validasi menggunakan `md5()` langsung, tanpa session library atau filter
4. Pembayaran iuran tanpa payment gateway. Warga upload bukti transfer, pengurus validasi manual.
