# Walkthrough Progress Kas-Kita

## 18 Agustus 2026 - Perbaikan Bug Dashboard
- Memperbaiki error `Undefined variable $wargaSudahBayar` di `DashboardController.php` baris 84.
- Menambahkan query untuk menghitung jumlah warga yang sudah membayar bulan ini dengan status `terverifikasi` pada `pembayaranModel`.
- Menyesuaikan struktur tabel `users` dengan kode aktual (menambahkan `blok_rumah` dan `nama_jalan` via migrasi) karena kode Controller dan UI sangat bergantung pada dua kolom tersebut yang sebelumnya tidak ada di database.
- Melakukan backfill data agar `no_rumah` dan `blok_rumah` terpecah secara rapi bagi warga yang sudah ada.
- Memperbaiki bug di mana `WargaController` membaca `no_hp` yang salah (seharusnya `no_telepon` sesuai allowedFields model).
- Mencatat penyimpangan TDD ini ke dalam `docs/tdd_changes_tracker.md`.
- **(Baru)** Mengubah nama kolom `nama` menjadi `nama_kategori` pada tabel `kategori_pengeluaran` via migrasi. Ini dilakukan karena semua kode (Model, View, Controller) mengharapkan nama kolom tersebut, sehingga menghindari error `Unknown column` di halaman Pengeluaran.

### Sesi 2 (Saat Ini)
- **Bug Fix Pembayaran Iuran Multi-Bulan**:
  - Mengubah struktur form di `app/Views/iuran/bayar.php` agar tidak ada `input hidden` yang melakukan override (sehingga menyebabkan hanya bulan terbaru yang terkirim).
  - Mengubah `IuranController::prosesBayar()` menjadi mendukung multiple array `periode[]`, sehingga tagihan yang dicheck sekaligus dapat diproses dalam 1 upload bukti transfer (`insertBatch`).
- **Bug Fix List Tagihan Siluman**:
  - Menambahkan pembatasan/limitasi logika `IuranController::tagihan` dan `IuranController::bayar` agar hanya menagih iuran untuk bulan di mana warga tersebut **sudah didaftarkan** (berdasarkan kolom `created_at` di tabel users). Mencegah warga baru ditagih tunggakan bulan/tahun sebelumnya.
- **Handling Status "Ditolak"**:
  - Memastikan logika filtering status "ditolak" di Controller masuk kembali sebagai tagihan yang "Unpaid" asalkan warga tidak mensubmit ulang bulan yang sama secara redundan.
  - Mengubah informasi alert tunggakan "2 bulan" yang awalnya hardcoded di view agar dinamis sesuai jumlah tagihan aktual.

## 18 Agustus 2026 - Perbaikan Akses Tagihan & Sinkronisasi Session Warga
- **Masalah**: Halaman `iuran/tagihan`, `iuran/bayar`, dan `iuran/riwayat` selalu me-redirect user kembali ke `dashboard-warga` saat dibuka.
- **Penyebab**: `AuthController::login()` hanya menyimpan `session('user_id')`, sedangkan method di `IuranController` dan `DashboardController` melakukan pengecekan `$userId = session()->get('id')`. Karena bernilai `null`, controller langsung melempar redirect ke `/login` yang kemudian dibalikkan lagi ke `/dashboard-warga`.
- **Solusi**:
  - Menyimpan kedua key (`id` dan `user_id`) pada session di `AuthController.php`.
  - Menambahkan fallback `$userId = session()->get('id') ?? session()->get('user_id')` pada semua controller terkait.
  - Memastikan seluruh modul warga dan pengurus tersambung ke database tanpa data hardcoded.

## 19 Agustus 2026 - Fitur Setujui/Tolak Pendaftar Baru
- **Masalah**: Tombol "Setujui" dan "Tolak" pada tabel Pendaftar Baru di halaman Dashboard belum berfungsi.
- **Solusi**:
  - Menambahkan route POST `/warga/approve/(:num)` dan `/warga/reject/(:num)` di `Routes.php` khusus role pengurus.
  - Menambahkan method `approve($id)` di `WargaController` untuk mengupdate status `is_active` pendaftar menjadi `1` (Aktif).
  - Menambahkan method `reject($id)` di `WargaController` untuk menghapus pendaftar dari database (`delete()`).
  - Mengubah tombol di `app/Views/dashboard/index.php` menjadi tag `<form>` dengan method POST yang menunjuk ke masing-masing route.

## 19 Agustus 2026 - Perbaikan Daftar Warga Kosong
- **Masalah**: Tabel daftar warga di halaman Master Warga (`/warga`) kosong, padahal di dashboard tertulis ada puluhan warga terdaftar.
- **Penyebab**:
  - `UserSeeder.php` belum di-update dengan kolom `blok_rumah` dan `nama_jalan` saat migrasi penambahan kolom tersebut dibuat.
  - Akibatnya, saat `db:seed` dijalankan (setelah migrasi), data warga yang masuk memiliki `blok_rumah` kosong (`""`) dan `no_rumah` masih dalam format lama (`R/01`, `S/05`).
  - View `/warga` mengandalkan nilai kolom `blok_rumah` untuk mengelompokkan data ke dalam tabel masing-masing blok. Karena nilainya kosong dan tidak cocok dengan `master_blok`, data tidak ditampilkan.
- **Solusi**:
  - Mengupdate `app/Database/Seeds/UserSeeder.php` dengan menambahkan array data untuk `blok_rumah`, `no_rumah` format baru (`No. xx`), dan `nama_jalan` agar aman jika di-seed ulang di masa depan.
  - Membuat dan menjalankan script backfill lokal untuk mengonversi data lama yang formatnya rusak (`R/01` menjadi `Blok R`, `No. 01`) tanpa harus menghapus database saat ini.

## 19 Agustus 2026 - Switch Role & Perbaikan Iuran Pengurus
- **Konteks**: Pengurus RT adalah bagian dari warga yang juga wajib membayar iuran, tetapi selama ini tagihannya tidak muncul karena kueri iuran, rekap, dan dashboard selalu memfilter `role = 'warga'`.
- **Solusi**:
  - **Sesi Otentikasi**: Menambahkan key `active_role` pada session saat login.
  - **Tampilan UI**: Mengubah kondisi pengecekan menu dari `role === 'warga'` menjadi `active_role === 'warga'` di Sidebar dan Header.
  - **Fitur Switch Role**: Menambahkan tombol "Beralih ke Warga / Pengurus" di menu Dropdown Profil khusus bagi pengguna yang menjabat sebagai pengurus. Menekan tombol ini akan mengubah nilai `active_role` dan me-redirect ke dashboard yang sesuai (Dashboard Warga atau Dashboard Pengurus).
  - **Filter Hak Akses**: Memodifikasi `RoleFilter.php` agar mengevaluasi hak akses berdasarkan `active_role` bukan role asli.
  - **Kueri Data**: Menghapus kondisi `where('role', 'warga')` di `DashboardController`, `IuranController`, dan `LaporanController` dan menggantinya agar membaca seluruh user yang `is_active = 1`. Dengan demikian, Pengurus kini juga memiliki data tagihan iuran yang dihitung dalam total pemasukan dan tunggakan RT.
## 20 Agustus 2026 - Filter Periode Rekap Iuran
- Menambahkan filter Bulanan, Tahunan, dan Rentang pada daftar iuran pengurus.
- Menyatukan sumber data kartu ringkasan, tab status, dan buku register pada rekap per warga untuk periode aktif.
- Memastikan field filter yang tidak aktif tidak ikut dikirim ke server, sehingga pilihan Tahunan dan Rentang tidak tertimpa nilai Bulanan.
- Menambahkan test unit untuk periode tahunan, rentang, warga baru, pembayaran pending, dan status macet.
## 20 Agustus 2026 - Sinkronisasi Periode Mode Warga
- Menyamakan sumber periode tagihan warga dengan daftar iuran pengurus berdasarkan `berlaku_dari` sampai bulan berjalan.
- Menambahkan tab tahun pada riwayat pembayaran warga dengan keadaan kosong untuk tahun tanpa pembayaran.
- Membatasi pilihan periode agar tidak melewati bulan berjalan dan mengecualikan bulan sebelum warga terdaftar.
- Merapikan kolom nominal agar nilai Rupiah tetap satu baris pada tabel.
## 20 Agustus 2026 - Seeder Dashboard Dinamis
- Mengubah seed pengaturan iuran agar mulai Januari pada tahun berjalan.
- Mengubah seed pembayaran agar membuat data sampai bulan berjalan.
- Mengubah seed pengeluaran agar membuat data bulan berjalan dan bulan sebelumnya.
- Card dashboard tetap dihitung dari query database, sehingga hasil setelah `migrate:refresh` mengikuti data seed terbaru.

## 20 Agustus 2026 - Sinkronisasi Laporan dan Wilayah
- Laporan mendukung filter satu bulan, satu tahun, dan semua periode.
- Kartu ringkasan, rincian pengeluaran, dan rekap warga membaca periode aktif yang sama.
- Nota dan dokumentasi pengeluaran ditampilkan sebagai lampiran.
- Kop laporan membaca identitas wilayah dari pengaturan sistem.
- Jabatan Ketua RT dan Bendahara disimpan pada data pengurus untuk tanda tangan laporan.
