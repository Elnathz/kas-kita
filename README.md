**Farros Rifantiarno Ramadhani**<br>
**NIM: A11.2024.15694**

# Kas-Kita

Kas-Kita adalah aplikasi manajemen kas RT berbasis web. Aplikasi ini membantu pengurus RT mencatat pemasukan dari iuran warga, memantau tunggakan, memverifikasi pembayaran, mencatat pengeluaran, dan menyusun laporan keuangan. Warga dapat melihat tagihan, mengunggah bukti transfer, serta memantau riwayat pembayarannya.

## Daftar Isi

- [Gambaran Umum](#gambaran-umum)
- [Tech Stack](#tech-stack)
- [Role dan Hak Akses](#role-dan-hak-akses)
- [Fitur Utama](#fitur-utama)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Seeder dan Akun Demo](#seeder-dan-akun-demo)
- [Data Demo yang Dihasilkan](#data-demo-yang-dihasilkan)
- [Struktur Folder](#struktur-folder)
- [Route Utama](#route-utama)
- [Alur Penggunaan](#alur-penggunaan)
- [Testing](#testing)
- [Perbedaan Branch UTS dan Main](#perbedaan-branch-uts-dan-main)
- [Catatan Keamanan](#catatan-keamanan)
- [Dokumentasi Proyek](#dokumentasi-proyek)

## Gambaran Umum

Kas-Kita dibuat untuk mendigitalisasi pengelolaan kas RT agar data pembayaran dan pengeluaran tidak lagi bergantung pada pencatatan manual. Sistem memiliki dua role utama:

1. **Pengurus**, yang mengelola data warga, iuran, pembayaran, pengeluaran, kategori, pengaturan, dan laporan.
2. **Warga**, yang melihat tagihan pribadi, mengirim bukti pembayaran, dan melihat riwayat pembayaran.

Status pembayaran warga dihitung dari data pembayaran secara real-time. Sistem membagi status menjadi:

- **Lancar**: tidak memiliki tunggakan berturut-turut.
- **Nunggak**: belum membayar satu bulan terakhir.
- **Macet**: belum membayar minimal dua bulan berturut-turut.

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Bahasa pemrograman | PHP 8.2 atau lebih baru |
| Framework backend | CodeIgniter 4.7 |
| Arsitektur | MVC, Model-View-Controller |
| Database | MySQL |
| Driver database | MySQLi |
| Pengelola database lokal | dbngin |
| Nama database | `dbkaskita` |
| Port database | `3309` |
| UI framework | Bootstrap 5 |
| Admin template | FreeDash-lite dari AdminMart |
| Testing | PHPUnit 10.5 |
| Data dummy | FakerPHP |
| Session | CodeIgniter 4 Session |
| Upload file | CodeIgniter 4 UploadedFile |

Asset Bootstrap dan komponen UI sudah tersedia di dalam template FreeDash-lite. Aplikasi tidak membutuhkan Bootstrap tambahan dari CDN untuk berjalan.

## Role dan Hak Akses

| Fitur | Pengurus | Warga |
|---|:---:|:---:|
| Dashboard | Ya | Ya |
| Melihat dan mengelola data warga | Ya | Tidak |
| Melihat seluruh data iuran | Ya | Tidak |
| Memverifikasi pembayaran | Ya | Tidak |
| Melihat tagihan pribadi | Tidak | Ya |
| Mengunggah bukti transfer | Tidak | Ya |
| Melihat riwayat pembayaran pribadi | Tidak | Ya |
| Mencatat dan mengelola pengeluaran | Ya | Tidak |
| Mengelola kategori pengeluaran | Ya | Tidak |
| Mengatur nominal iuran | Ya | Tidak |
| Melihat laporan | Ya | Statistik terbatas |
| Mengubah profil pribadi | Ya melalui akun aktif | Ya |

## Fitur Utama

### Autentikasi dan Registrasi

- Login berdasarkan username dan password.
- Logout dengan penghapusan session.
- Registrasi warga baru pada branch `main`.
- Akun hasil registrasi memiliki status menunggu persetujuan (`is_active = 0`).
- Pengurus dapat menyetujui atau menolak pendaftar baru.
- Password pada branch `main` disimpan dengan `password_hash()` dan diverifikasi menggunakan `password_verify()`.

### Dashboard Pengurus

Dashboard pengurus menampilkan ringkasan pemasukan, pengeluaran, saldo kas, jumlah warga yang sudah dan belum membayar, grafik pemasukan dan pengeluaran, warga macet, serta pendaftar baru yang menunggu persetujuan.

### Dashboard Warga

Dashboard warga menampilkan status tagihan bulan berjalan, total tunggakan, beberapa pembayaran terakhir, dan akses untuk membayar iuran apabila tagihan belum lunas.

### Manajemen Warga

Pengurus dapat melihat, menambah, mengubah, menghapus secara soft delete, menyetujui, dan menolak data warga. Daftar warga juga menampilkan status pembayaran yang dihitung dari histori pembayaran.

### Iuran dan Pembayaran

- Pengurus dapat melihat rekap iuran berdasarkan bulan, tahun, rentang periode, blok, dan status.
- Pengurus dapat membuka detail pembayaran yang menunggu verifikasi.
- Pengurus dapat menerima atau menolak pembayaran dengan catatan.
- Warga dapat membayar seluruh tunggakan sekaligus atau memilih periode tertentu.
- Pembayaran sebagian mengikuti prinsip FIFO, yaitu tunggakan paling lama harus dilunasi lebih dahulu.
- Warga dapat mengunggah bukti transfer.
- Pembayaran yang diterima memiliki status `terverifikasi`.
- Pembayaran yang belum diperiksa memiliki status `pending`.
- Pembayaran yang ditolak memiliki status `ditolak`.
- Kuitansi tersedia untuk pembayaran yang sudah terverifikasi.

### Pengeluaran dan Kategori

Pengurus dapat mengelola kategori pengeluaran dan mencatat pengeluaran berdasarkan kategori, tanggal, nominal, keterangan, foto nota, serta dokumentasi pendukung.

### Pengaturan Iuran

Pengurus dapat mengatur nominal iuran, tanggal jatuh tempo, periode berlaku, toleransi tunggakan, metode pembayaran bank, metode QRIS, daftar jalan, dan daftar blok rumah.

### Laporan

Laporan dapat difilter berdasarkan bulan dan tahun. Isi laporan meliputi pemasukan, pengeluaran per kategori, saldo, warga yang sudah membayar, warga yang belum membayar, serta warga dengan status macet. Warga mendapatkan tampilan laporan yang lebih terbatas untuk informasi publik dan statistik.

## Persyaratan Sistem

Pastikan perangkat sudah memiliki:

- PHP 8.2 atau lebih baru.
- Composer.
- MySQL atau dbngin.
- Ekstensi PHP `intl`, `mbstring`, `json`, `mysqlnd`, dan `curl`.
- Web browser modern.

Node.js tidak diperlukan untuk menjalankan aplikasi dari asset yang sudah tersedia di repository. Folder sumber FreeDash-lite tetap disimpan di `public/FreeDash` untuk kebutuhan pengembangan template.

## Instalasi

### 1. Clone repository

```bash
git clone <url-repository>
cd kas-kita
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Buat database

Buat database MySQL dengan nama yang sesuai konfigurasi:

```sql
CREATE DATABASE dbkaskita
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;
```

### 4. Atur file `.env`

Pastikan konfigurasi database minimal seperti berikut:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = dbkaskita
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3309
```

Sesuaikan `username`, `password`, `hostname`, dan `port` dengan instalasi MySQL lokal. Pada konfigurasi proyek ini, dbngin menggunakan port `3309`.

### 5. Jalankan migration

```bash
php spark migrate --all
```

### 6. Isi data demo dengan seeder

```bash
php spark db:seed DatabaseSeeder
```

`DatabaseSeeder` akan mengosongkan tabel yang dikelola oleh seeder menggunakan `TRUNCATE` sebelum memasukkan data demo. Jangan menjalankan perintah ini pada database produksi atau database yang berisi data penting.

### 7. Jalankan aplikasi

```bash
php spark serve --host localhost --port 8080
```

Buka alamat berikut di browser:

```text
http://localhost:8080/login
```

## Konfigurasi Environment

Konfigurasi utama yang digunakan proyek:

| Konfigurasi | Nilai default proyek |
|---|---|
| Environment | `development` |
| Host database | `localhost` |
| Database | `dbkaskita` |
| Username database | `root` |
| Password database | kosong pada konfigurasi lokal awal |
| Driver | `MySQLi` |
| Port | `3309` |
| Base URL pengembangan | `http://localhost:8080/` |

Untuk deployment, jangan menggunakan password database kosong dan jangan menjalankan aplikasi dengan `CI_ENVIRONMENT = development`.

## Seeder dan Akun Demo

### Perintah seeder

Seeder utama yang dipanggil oleh `DatabaseSeeder` adalah:

1. `MasterWilayahSeeder`
2. `UserSeeder`
3. `PengaturanIuranSeeder`
4. `KategoriPengeluaranSeeder`
5. `PembayaranSeeder`
6. `PengeluaranSeeder`
7. `PengaturanSistemSeeder`
8. `MetodePembayaranSeeder`

### Akun login tetap

| Username | Password | Role | Nama | Status |
|---|---|---|---|---|
| `admin` | `admin123` | Pengurus | Budi Santoso, Ketua RT | Aktif |
| `bendahara` | `admin123` | Pengurus | Agus Hariyanto, Bendahara | Aktif |
| `warga1` | `farros123` | Warga | Farros Rifantiarno | Aktif |

### Akun warga hasil generator

`UserSeeder` juga membuat akun warga dengan pola berikut:

| Username | Password | Role | Status |
|---|---|---|---|
| `warga2` sampai `warga21` | `warga123` | Warga | Aktif |
| `warga22` sampai `warga24` | `warga123` | Warga | Menunggu persetujuan |

Nama, blok rumah, nomor rumah, jalan, nomor telepon, dan tanggal data untuk akun hasil generator dibuat menggunakan Faker sehingga dapat berubah setiap kali seeder dijalankan. Akun `warga22` sampai `warga24` tidak dapat login sebelum diaktifkan oleh pengurus.

Total data user yang dibuat adalah 26 akun:

- 2 akun pengurus.
- 21 akun warga aktif, termasuk `warga1`.
- 3 akun warga pending.

### Cara login setelah seeding

1. Buka `http://localhost:8080/login`.
2. Masukkan salah satu akun pada tabel di atas.
3. Gunakan `admin` atau `bendahara` untuk menguji fitur pengurus.
4. Gunakan `warga1` untuk menguji tagihan, pembayaran, dan laporan warga.

## Data Demo yang Dihasilkan

### Pengaturan iuran

- Nominal iuran: `Rp50.000` per bulan.
- Tanggal jatuh tempo: tanggal `20`.
- Toleransi tunggakan: `2` periode.
- Status pengaturan: aktif.

### Kategori pengeluaran

Kategori default yang dimasukkan:

- `Kas`: kebutuhan operasional RT.
- `Sosial`: bantuan sosial warga.
- `Konsumsi`: acara dan pertemuan warga.

### Wilayah demo

- Blok R, maksimal 10 nomor rumah.
- Blok S, maksimal 15 nomor rumah.
- Blok T, maksimal 6 nomor rumah.
- Jalan Anggada 1.
- Jalan Anggada 2.
- Jalan Anggada 3.

### Metode pembayaran demo

- Bank Central Asia (BCA), rekening `8830-1234-5678`, atas nama `Kas RT 06 RW 20 Kuripan`.
- QRIS Kas RT, NMID `ID1024098234120`, atas nama `KAS RT 06 RW 20 KURIPAN`.

### Skenario pembayaran demo

Data pembayaran dibuat dinamis berdasarkan bulan dan tahun saat seeder dijalankan:

- Pengurus dengan ID 1 dan 2 lunas sampai bulan berjalan.
- User ID 3, yaitu `warga1`, memiliki pembayaran terverifikasi sampai bulan kelima dan pembayaran pending pada bulan keenam jika bulan tersebut sudah masuk kalender berjalan.
- User ID 4 sampai 15 lunas sampai bulan berjalan.
- User ID 16 sampai 18 memiliki tunggakan satu bulan.
- User ID 19 sampai 21 memiliki tunggakan tiga bulan agar status macet dapat diuji.

### Skenario pengeluaran demo

Seeder membuat enam pengeluaran contoh, antara lain pembelian lampu jalan, santunan warga sakit, perbaikan saluran, konsumsi rapat, perbaikan pos kamling, dan persiapan kegiatan warga. Tanggal pengeluaran mengikuti bulan berjalan dan satu bulan sebelumnya.

## Struktur Folder

```text
kas-kita/
|-- app/
|   |-- Config/             Konfigurasi aplikasi dan route
|   |-- Controllers/        Pengendali request tiap modul
|   |-- Database/
|   |   |-- Migrations/     Struktur dan perubahan database
|   |   |-- Seeds/          Data demo dan akun awal
|   |-- Filters/            Auth filter dan role filter
|   |-- Libraries/          Library aplikasi, termasuk rekap periode iuran
|   |-- Models/             Model database
|   |-- Views/              Template halaman dan komponen UI
|-- docs/
|   |-- tdd.md              Technical Design Document, sumber kebenaran teknis
|   |-- walkthrough.md      Catatan progres implementasi
|   |-- sprint0/             Dokumen perencanaan sprint
|   |-- tdd_changes_tracker.md
|-- public/
|   |-- assets/             Asset aplikasi dan gambar
|   |-- FreeDash/            Source dan distribusi template FreeDash-lite
|   |-- uploads/             File upload bukti dan dokumentasi
|   |-- index.php            Entry point aplikasi
|-- tests/                   Test PHPUnit
|-- writable/                Cache, log, session, dan file runtime
|-- .env                    Konfigurasi environment lokal
|-- composer.json            Dependency dan script Composer
|-- spark                    CLI CodeIgniter 4
```

## Route Utama

### Autentikasi

| Method | URL | Keterangan |
|---|---|---|
| GET | `/login` | Form login |
| POST | `/login` | Proses login |
| GET | `/register` | Form registrasi warga |
| POST | `/register` | Proses registrasi warga |
| GET | `/logout` | Logout |

### Pengurus

| Method | URL | Keterangan |
|---|---|---|
| GET | `/dashboard` | Dashboard pengurus |
| GET | `/warga` | Daftar warga |
| GET/POST | `/warga/create`, `/warga/store` | Tambah warga |
| GET/POST | `/warga/edit/{id}`, `/warga/update/{id}` | Edit warga |
| POST | `/warga/delete/{id}` | Hapus atau nonaktifkan warga |
| POST | `/warga/approve/{id}` | Setujui warga |
| POST | `/warga/reject/{id}` | Tolak warga |
| GET | `/iuran` | Rekap iuran |
| GET | `/iuran/verifikasi/{id}` | Detail verifikasi pembayaran |
| POST | `/iuran/verifikasi/proses/{id}` | Proses verifikasi |
| GET | `/pengeluaran` | Daftar pengeluaran |
| GET/POST | `/pengeluaran/create`, `/pengeluaran/store` | Tambah pengeluaran |
| GET/POST | `/pengeluaran/edit/{id}`, `/pengeluaran/update/{id}` | Edit pengeluaran |
| POST | `/pengeluaran/delete/{id}` | Hapus pengeluaran |
| GET/POST | `/kategori`, `/kategori/create`, `/kategori/store` | Kelola kategori |
| GET/POST | `/pengaturan/iuran`, `/pengaturan/iuran/update` | Pengaturan iuran |
| GET | `/laporan` | Laporan pengurus |

### Warga

| Method | URL | Keterangan |
|---|---|---|
| GET | `/dashboard-warga` | Dashboard warga |
| GET | `/iuran/tagihan` | Daftar tagihan |
| GET | `/iuran/bayar` | Form pembayaran |
| POST | `/iuran/bayar/proses` | Kirim pembayaran dan bukti transfer |
| GET | `/iuran/riwayat` | Riwayat pembayaran |
| GET | `/laporan-warga` | Laporan terbatas warga |
| GET | `/profil` | Profil warga |
| POST | `/profil/update` | Update data profil |
| POST | `/profil/password` | Update password |

Keterangan `{id}` berarti parameter angka ID data. Route pengurus dilindungi role filter pengurus, sedangkan route warga dilindungi role filter warga.

## Alur Penggunaan

### Pengurus

1. Login dengan akun `admin` atau `bendahara`.
2. Periksa ringkasan saldo, pembayaran, tunggakan, dan pendaftar baru di dashboard.
3. Buka menu Warga untuk menyetujui pendaftar yang valid.
4. Buka menu Iuran untuk memeriksa pembayaran pending.
5. Lihat bukti transfer, lalu terima atau tolak dengan catatan.
6. Catat transaksi pada menu Pengeluaran.
7. Kelola kategori dan pengaturan nominal iuran jika diperlukan.
8. Gunakan menu Laporan untuk melihat rekap kas berdasarkan periode.

### Warga

1. Login dengan akun warga aktif.
2. Periksa tagihan pada dashboard atau menu Tagihan Saya.
3. Pilih seluruh tunggakan atau periode tertentu sesuai aturan FIFO.
4. Transfer iuran melalui metode pembayaran yang tersedia.
5. Upload bukti transfer dan kirim pembayaran.
6. Tunggu verifikasi pengurus.
7. Periksa status pada Riwayat Pembayaran.

## Testing

Jalankan seluruh test PHPUnit dengan perintah:

```bash
composer test
```

Atau:

```bash
vendor/bin/phpunit
```

Test menggunakan konfigurasi database testing CodeIgniter. Pastikan test tidak diarahkan ke database development agar data aplikasi tidak tertimpa.

## Perbedaan Branch UTS dan Main

### Branch `uts`

Branch `uts` berfokus pada slicing layout, route, MVC dasar, dan login dummy. Scope-nya belum mencakup database, migration, seeder, filter, CRUD, upload, validasi, dan laporan real.

Pada branch `uts`, login menggunakan akun hardcoded `admin` dengan password `admin123` yang dibandingkan menggunakan MD5 dan session native PHP.

### Branch `main`

Branch `main` adalah branch fitur lengkap. Branch ini mencakup:

- Model dan database.
- Migration dan seeder.
- Session CodeIgniter 4.
- Auth filter dan role filter.
- CRUD data warga, pengeluaran, dan kategori.
- Registrasi serta persetujuan warga.
- Validasi server-side.
- Upload dan verifikasi bukti pembayaran.
- Perhitungan tagihan dan tunggakan.
- Laporan bulanan.
- Hash password menggunakan `password_hash()` dan `password_verify()`.

README ini mendokumentasikan kondisi branch `main`, karena akun dan seeder hanya tersedia pada implementasi fitur lengkap.

## Catatan Keamanan

- Akun dan password pada bagian seeder hanya untuk development atau demo.
- Ganti seluruh password akun demo sebelum aplikasi digunakan di lingkungan nyata.
- Jangan commit file `.env` berisi credential produksi.
- Jangan menjalankan `php spark db:seed DatabaseSeeder` pada database produksi karena tabel seed akan di-truncate.
- Pastikan folder `public` menjadi document root web server. Jangan mengarahkan document root ke root repository.
- Batasi ukuran, ekstensi, dan lokasi file upload pada deployment.
- Jalankan aplikasi produksi dengan environment production dan gunakan password database yang kuat.

## Dokumentasi Proyek

- [Technical Design Document](docs/tdd.md): sumber kebenaran untuk scope, arsitektur, database, fitur, dan alur bisnis.
- [Walkthrough](docs/walkthrough.md): catatan progres implementasi.
- [TDD Changes Tracker](docs/tdd_changes_tracker.md): riwayat perubahan terhadap TDD.
- [Studi Kasus Aplikasi RT](docs/studi-kasus-aplikasi-rt.md): latar belakang dan studi kasus aplikasi.
- [Rencana Sprint](docs/sprint_planning.md): pembagian rencana pengerjaan.

## Lisensi

Project menggunakan kerangka CodeIgniter 4 dan template FreeDash-lite. Detail lisensi masing-masing komponen dapat dilihat pada file lisensi yang disertakan di repository.
