# Walkthrough Progress Kas-Kita

## 18 Agustus 2026 - Perbaikan Bug Dashboard
- Memperbaiki error `Undefined variable $wargaSudahBayar` di `DashboardController.php` baris 84.
- Menambahkan query untuk menghitung jumlah warga yang sudah membayar bulan ini dengan status `terverifikasi` pada `pembayaranModel`.
- Menyesuaikan struktur tabel `users` dengan kode aktual (menambahkan `blok_rumah` dan `nama_jalan` via migrasi) karena kode Controller dan UI sangat bergantung pada dua kolom tersebut yang sebelumnya tidak ada di database.
- Melakukan backfill data agar `no_rumah` dan `blok_rumah` terpecah secara rapi bagi warga yang sudah ada.
- Memperbaiki bug di mana `WargaController` membaca `no_hp` yang salah (seharusnya `no_telepon` sesuai allowedFields model).
- Mencatat penyimpangan TDD ini ke dalam `docs/tdd_changes_tracker.md`.
- **(Baru)** Mengubah nama kolom `nama` menjadi `nama_kategori` pada tabel `kategori_pengeluaran` via migrasi. Ini dilakukan karena semua kode (Model, View, Controller) mengharapkan nama kolom tersebut, sehingga menghindari error `Unknown column` di halaman Pengeluaran.

## 18 Agustus 2026 - Perbaikan Akses Tagihan & Sinkronisasi Session Warga
- **Masalah**: Halaman `iuran/tagihan`, `iuran/bayar`, dan `iuran/riwayat` selalu me-redirect user kembali ke `dashboard-warga` saat dibuka.
- **Penyebab**: `AuthController::login()` hanya menyimpan `session('user_id')`, sedangkan method di `IuranController` dan `DashboardController` melakukan pengecekan `$userId = session()->get('id')`. Karena bernilai `null`, controller langsung melempar redirect ke `/login` yang kemudian dibalikkan lagi ke `/dashboard-warga`.
- **Solusi**:
  - Menyimpan kedua key (`id` dan `user_id`) pada session di `AuthController.php`.
  - Menambahkan fallback `$userId = session()->get('id') ?? session()->get('user_id')` pada semua controller terkait.
  - Memastikan seluruh modul warga dan pengurus tersambung ke database tanpa data hardcoded.

