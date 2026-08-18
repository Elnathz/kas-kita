# Walkthrough Progress Kas-Kita

## 18 Agustus 2026 - Perbaikan Bug Dashboard
- Memperbaiki error `Undefined variable $wargaSudahBayar` di `DashboardController.php` baris 84.
- Menambahkan query untuk menghitung jumlah warga yang sudah membayar bulan ini dengan status `terverifikasi` pada `pembayaranModel`.
- Menyesuaikan struktur tabel `users` dengan kode aktual (menambahkan `blok_rumah` dan `nama_jalan` via migrasi) karena kode Controller dan UI sangat bergantung pada dua kolom tersebut yang sebelumnya tidak ada di database.
- Melakukan backfill data agar `no_rumah` dan `blok_rumah` terpecah secara rapi bagi warga yang sudah ada.
- Memperbaiki bug di mana `WargaController` membaca `no_hp` yang salah (seharusnya `no_telepon` sesuai allowedFields model).
- Mencatat penyimpangan TDD ini ke dalam `docs/tdd_changes_tracker.md`.
- **(Baru)** Mengubah nama kolom `nama` menjadi `nama_kategori` pada tabel `kategori_pengeluaran` via migrasi. Ini dilakukan karena semua kode (Model, View, Controller) mengharapkan nama kolom tersebut, sehingga menghindari error `Unknown column` di halaman Pengeluaran.
