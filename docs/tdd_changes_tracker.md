# TDD Changes Tracker - Kas-Kita

Log perubahan terhadap Technical Design Document (TDD).

---

## Format Entry

```markdown
## [Tanggal] - [Judul Perubahan]
- **Sebelum**: [deskripsi kondisi sebelum]
- **Sesudah**: [deskripsi kondisi sesudah]
- **Alasan**: [mengapa berubah]
- **Dampak**: [file/fitur apa yang terdampak]
```

---

## Riwayat Perubahan

### 16 Agustus 2026 - Initial TDD Creation
- **Sebelum**: Belum ada TDD
- **Sesudah**: TDD v1.0 dibuat dengan scope lengkap (branch uts dan main)
- **Alasan**: Inisialisasi proyek
- **Dampak**: Semua file dan fitur

### 16 Agustus 2026 - Tambah Mekanisme Status Pembayaran Macet
- **Sebelum**: Deteksi tunggakan hanya disebutkan sekilas tanpa detail implementasi
- **Sesudah**: Ditambahkan mekanisme status pembayaran warga (Lancar/Nunggak/Macet) yang dihitung real-time dari tabel pembayaran. Muncul di 3 tempat: tabel warga (badge), dashboard pengurus (card khusus), halaman verifikasi (alert banner). Klasifikasi: 0 bulan = Lancar, 1 bulan = Nunggak, >= 2 bulan berturut = Macet
- **Alasan**: Kebutuhan pengurus untuk mengetahui warga yang pembayarannya macet
- **Dampak**: Section 6.3 (Daftar Warga), Section 6.4 (Validasi Pembayaran), Section 6.2 (Dashboard Pengurus), Section 8.2 (Alur Deteksi Tunggakan)

### 16 Agustus 2026 - Penggabungan Tagihan & Opsi Pembayaran Fleksibel
- **Sebelum**: Halaman Tagihan dan Bayar Iuran dipisah tanpa mekanisme pemilihan bulan tunggakan
- **Sesudah**: Halaman disatukan (Tagihan & Pembayaran) dengan opsi pembayaran fleksibel: warga bisa memilih bayar satu per satu (wajib melunasi bulan paling lama/FIFO terlebih dahulu) atau bayar seluruh tunggakan sekaligus dengan 1 bukti transfer
- **Alasan**: Efisiensi UX (mobile-first) dan fleksibilitas keuangan warga yang ingin menyicil tunggakan
- **Dampak**: Section 6.4 (Tagihan & Bayar Iuran), Section 8.1 (Alur Pembayaran Iuran), View `app/Views/iuran/tagihan.php` & `app/Views/iuran/bayar.php`

### 16 Agustus 2026 - Penambahan Fitur Registrasi Mandiri Warga dengan Approval Pengurus (Branch Main)
- **Sebelum**: Akun warga hanya dapat dibuatkan secara manual oleh pengurus melalui menu Tambah Warga
- **Sesudah**: Warga dapat mendaftar mandiri via form `/register` dengan status awal `is_active = 0` (Menunggu Persetujuan). Pengurus memverifikasi dan menyetujui akun warga sebelum dapat login ke sistem
- **Alasan**: Memudahkan warga menentukan username/password sendiri sekaligus menjaga keamanan data kas RT dari pengguna luar
- **Dampak**: Section 6.1 (Registrasi Warga Baru), Section 8.4 (Alur Registrasi & Persetujuan), Route `/register`, Controller Auth & Warga (Branch Main)

### 16 Agustus 2026 - Standarisasi Dropdown Identitas Rumah & Wilayah RT
- **Sebelum**: Input alamat dan nomor rumah berupa teks bebas manual yang rentan format tidak seragam
- **Sesudah**: Input alamat distandarisasi menggunakan pilihan dropdown: Blok Rumah (Blok A-D), Nomor Rumah (No. 01-30), dan Nama Jalan Lingkungan. Pengurus dapat mengelola daftar pilihan ini di menu Pengaturan
- **Alasan**: Menghindari kesalahan ketik, menjaga konsistensi format data warga 100% rapi, dan mempermudah pencarian/filter
- **Dampak**: View `auth/register.php`, `warga/create.php`, `warga/edit.php`, `pengaturan/iuran.php`, Section 6.1 & 6.3 TDD

### 17 Agustus 2026 - Izin Akses Laporan Kas Bulanan untuk Warga (Transparansi Terbatas)
- **Sebelum**: Warga sama sekali tidak diizinkan mengakses laporan kas bulanan (hanya Pengurus). Menu Laporan di sidebar juga membuat status mode berubah kembali menjadi Pengurus.
- **Sesudah**: Warga diberikan hak akses untuk melihat Laporan Kas Bulanan dengan URL baru `/laporan-warga`. Tampilan untuk warga dibatasi; mereka hanya bisa melihat statistik ringkasan dan statistik partisipasi per blok (Tab Publik), tanpa bisa melihat Tab Internal yang berisi data detail keterlambatan per individu.
- **Alasan**: Menjalankan core value aplikasi yaitu "Manajemen Kas RT yang Transparan" sehingga warga berhak mengetahui alokasi dana dan saldo RT, dengan tetap menjaga etika dan privasi data personal (tunggakan warga lain).
- **Dampak**: Section 4.2 (Matriks Hak Akses), Section 6.8 (Laporan), Route `/laporan-warga`, `LaporanController`, `sidebar.php`, `header.php`, `dashboard/warga.php`, dan `laporan/index.php`.

### 17 Agustus 2026 - Mekanisme Profil Warga & Dashboard Approval
- **Sebelum**: Warga tidak bisa mengubah informasi apa pun, dan Pengurus tidak memiliki panel notifikasi pendaftar baru yang terpusat di Dashboard.
- **Sesudah**: Dibuat rute /profil untuk warga. Perubahan data kontak (No WA), nama, dan password tersimpan langsung. Perubahan fisik rumah (Blok & Nomor) masuk ke status "Pengajuan". Di Dashboard Pengurus ditambahkan tabel _Menunggu Persetujuan_ untuk menyetujui akun baru dan pengajuan pindah rumah.
- **Alasan**: Menjaga integritas data finansial rumah namun tetap memberikan kebebasan pada warga, serta mempercepat *awareness* pengurus.
- **Dampak**: Section 6.2 (Dashboard Pengurus), Section 6.9 (Profil Warga baru), View dashboard/index.php, View profil/index.php.

### 18 Agustus 2026 - Penambahan Kolom Blok dan Jalan di Tabel Users
- **Sebelum**: Tabel `users` di TDD hanya memiliki kolom `no_rumah` (format gabungan) dan `alamat`, sedangkan kode di UI form dan Controller mengharapkan `blok_rumah` dan `nama_jalan` yang terpisah.
- **Sesudah**: Menambahkan kolom `blok_rumah` dan `nama_jalan` secara eksplisit ke dalam struktur tabel `users` (via migrasi) agar sinkron dengan input form. Data `no_rumah` diubah menjadi murni nomor tanpa prefix blok.
- **Alasan**: Menghindari error `Undefined array key "blok_rumah"` di Controller yang mengekstraksi blok secara paksa dari array database yang tidak memilikinya, dan untuk menyesuaikan dengan "kondisi kode aktual" seperti yang disarankan.
- **Dampak**: Skema Database (Section 5.2.1), Model `UserModel` (`$allowedFields`), Migrasi Database `Users`.

### 18 Agustus 2026 - Penyesuaian Kolom Tabel Kategori Pengeluaran
- **Sebelum**: Tabel `kategori_pengeluaran` di TDD dan database menggunakan kolom `nama` untuk menyimpan nama kategori.
- **Sesudah**: Kolom `nama` diubah menjadi `nama_kategori` melalui migrasi database.
- **Alasan**: Semua *Controller* (`PengeluaranController`, `DashboardController`), *Model*, dan *View* sudah ditulis dengan menggunakan parameter/kunci `nama_kategori`. Sesuai instruksi untuk mengikuti *kondisi kode aktual*, maka tabel database disesuaikan agar tidak memunculkan `Unknown column` error.
- **Dampak**: Skema Database (Section 5.2.4), Migrasi Database `KategoriPengeluaran`.
