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

### 18 Agustus 2026 - Standarisasi Status Pembayaran (lunas -> terverifikasi)
- **Sebelum**: Status pembayaran tidak konsisten: beberapa controller pakai `lunas`, beberapa pakai `terverifikasi`, beberapa pakai `menunggu_verifikasi`, bahkan ada yang kosong di database. Akibatnya verifikasi pembayaran tidak pernah berubah state.
- **Sesudah**: Standar status baku: `pending` (sudah upload, belum diverifikasi), `terverifikasi` (disetujui pengurus), `ditolak` (ditolak pengurus). Semua controller dan seeder diupdate. Data existing difix via migration.
- **Alasan**: Bug kritis - form verifikasi mengirim field `action` tapi controller baca field `status` yang tidak ada. Plus mismatch status antara IuranController dan DashboardController.
- **Dampak**: `IuranController`, `DashboardController`, `PembayaranSeeder`, Migration baru, Section 5.2.2 (Status Pembayaran) di TDD.
### 20 Agustus 2026 - Filter Periode dan Rekap Iuran Pengurus
- **Sebelum**: Daftar iuran hanya difilter berdasarkan satu bulan dan tahun, sehingga rekap lintas bulan atau satu tahun tidak tersedia.
- **Sesudah**: Pengurus dapat memilih periode Bulanan, Tahunan, atau Rentang. Setiap warga direkap satu kali untuk periode aktif, dan kartu ringkasan, tab status, serta buku register memakai hasil rekap yang sama.
- **Alasan**: Pengurus perlu memantau pelunasan dan tunggakan pada satu bulan, satu tahun, atau rentang bulan tanpa perhitungan manual.
- **Dampak**: Section 6.4 TDD, `IuranPeriodSummary`, `IuranController`, view daftar iuran, dan test unit rekap iuran.
### 20 Agustus 2026 - Sinkronisasi Periode Iuran Warga dan Pengurus
- **Sebelum**: Halaman warga membentuk tagihan dari batas 12 bulan tersendiri, sedangkan pengurus memakai rekap periode terpilih. Riwayat warga belum memiliki tab tahun dan nominal tabel dapat terpecah menjadi dua baris.
- **Sesudah**: Kedua mode memakai batas periode dari `pengaturan_iuran.berlaku_dari` sampai bulan berjalan. Tagihan warga mengecualikan bulan sebelum warga terdaftar, riwayat memiliki tab tahun, dan nominal memakai tampilan satu baris.
- **Alasan**: Menjaga angka tagihan, pembayaran, dan rekap tetap konsisten antar mode serta mencegah pemilihan periode masa depan.
- **Dampak**: `IuranPeriodSummary`, `IuranController`, view `iuran/index.php`, `iuran/tagihan.php`, `iuran/bayar.php`, `iuran/riwayat.php`, dan test unit periode.
### 20 Agustus 2026 - Sinkronisasi Seeder Data Demo dengan Periode Berjalan
- **Sebelum**: Seeder pengaturan, pembayaran, dan pengeluaran mengunci tanggal tahun 2026, sehingga hasil `migrate:refresh` dapat tidak sesuai dengan bulan dashboard saat aplikasi dijalankan.
- **Sesudah**: Seeder menggunakan tahun berjalan, pembayaran dibuat dari Januari sampai bulan berjalan, dan pengeluaran dibuat untuk bulan berjalan serta bulan sebelumnya.
- **Alasan**: Menjamin data presentasi tetap mengisi card dashboard dan daftar iuran setelah database dibuat ulang.
- **Dampak**: `PengaturanIuranSeeder`, `PembayaranSeeder`, dan `PengeluaranSeeder`.

### 20 Agustus 2026 - CRUD Kategori dan Validasi Pengeluaran
- **Sebelum**: Kategori dapat tersimpan tanpa pemeriksaan duplikasi, sedangkan form pengeluaran menyimpan input tanpa validasi kategori, tanggal, nominal, atau lampiran.
- **Sesudah**: CRUD kategori memvalidasi nama unik dan keberadaan data. Pengeluaran memvalidasi kategori, nominal positif, keterangan, serta menolak tanggal masa depan. Lampiran nota dan dokumentasi disimpan ke `public/uploads/pengeluaran`.
- **Alasan**: Menjamin kategori baru langsung aman dipakai pada dropdown pengeluaran dan mencegah catatan kas yang tidak valid.
- **Dampak**: `KategoriController`, `PengeluaranController`, form kategori, form pengeluaran, dan tampilan monitoring macet.

### 20 Agustus 2026 - Penyesuaian Zona Waktu Aplikasi
- **Sebelum**: CodeIgniter memakai UTC, sehingga batas tanggal form dan periode dashboard dapat bergeser dari waktu lokal RT.
- **Sesudah**: Zona waktu aplikasi menggunakan `Asia/Jakarta` sesuai lingkungan operasional.
- **Alasan**: Tanggal hari ini pada form dan periode seed harus mengikuti waktu Indonesia.
- **Dampak**: `app/Config/App.php`, tampilan tanggal, dan seeder data demo.

### 20 Agustus 2026 - Sinkronisasi Timestamp Kategori Pengeluaran
- **Sebelum**: Model kategori mengaktifkan timestamp `created_at` dan `updated_at`, tetapi tabel hanya memiliki `created_at`, sehingga create kategori gagal dengan error kolom `updated_at` tidak ditemukan.
- **Sesudah**: Tabel kategori memiliki kedua kolom timestamp melalui migration baru.
- **Alasan**: Menyamakan struktur database dengan konfigurasi model agar create dan update kategori berjalan.
- **Dampak**: Migration kategori dan `KategoriPengeluaranModel`.

### 20 Agustus 2026 - Filter Periode Pengeluaran
- **Sebelum**: Tabel pengeluaran menampilkan seluruh tanggal, tetapi total di footer hanya menghitung bulan berjalan.
- **Sesudah**: Daftar pengeluaran default ke satu bulan dan menyediakan pilihan satu tahun atau semua periode. Total selalu mengikuti data yang sedang ditampilkan.
- **Alasan**: Menghindari perbedaan antara isi tabel dan angka total.
- **Dampak**: `PengeluaranController` dan view `pengeluaran/index.php`.

### 20 Agustus 2026 - Sinkronisasi Laporan Kas dan Identitas Wilayah
- **Sebelum**: Laporan hanya menerima bulan dan tahun, kartu saldo tidak mengikuti periode secara konsisten, rincian pengeluaran tidak menampilkan lampiran, dan kop serta tanda tangan memakai teks wilayah statis.
- **Sesudah**: Laporan mendukung satu bulan, satu tahun, dan semua periode. Kartu, rincian pengeluaran, serta rekap warga memakai periode yang sama. Nota dan dokumentasi ditautkan dari asset seed atau folder upload. Kop laporan membaca pengaturan wilayah, sedangkan Ketua RT dan Bendahara diambil dari jabatan pengurus.
- **Alasan**: Menjamin laporan dapat dipakai untuk presentasi tanpa angka, identitas wilayah, atau penandatangan yang berbeda dari data aplikasi.
- **Dampak**: `LaporanController`, view laporan, `PengaturanSistemModel`, kolom `jabatan` users, migration, dan seeder wilayah.
- Form administrasi wilayah di `PengaturanController` dan `pengaturan/iuran.php` juga sekarang menyimpan perubahan ke `pengaturan_sistem`.

### 20 Agustus 2026 - Sinkronisasi Master Jalan Seeder
- **Sebelum**: Seeder warga memakai nama jalan lama yang tidak ada di master jalan.
- **Sesudah**: Semua warga demo memakai `Jalan Anggada 1`, `Jalan Anggada 2`, atau `Jalan Anggada 3` sesuai `MasterWilayahSeeder`.
- **Alasan**: Dropdown dan tabel warga harus memakai sumber nama jalan yang sama.
- **Dampak**: `UserSeeder` dan data warga hasil seed.

### 20 Agustus 2026 - Data Pengaturan Iuran dan Metode Pembayaran
- **Sebelum**: Form kebijakan iuran, riwayat kebijakan, rekening bank, dan QRIS masih memakai nilai hardcoded atau tombol simulasi. Form Bayar Warga juga hanya menampilkan satu rekening dan QRIS statis.
- **Sesudah**: Kebijakan iuran disimpan sebagai riwayat di `pengaturan_iuran`, metode pembayaran dapat ditambah, diubah, dan dihapus di tabel `metode_pembayaran`, lalu semua metode aktif otomatis tampil di form Bayar Warga.
- **Alasan**: Perubahan tarif, jatuh tempo, toleransi macet, dan rekening harus berdampak nyata ke seluruh halaman.
- **Dampak**: Migration dan model pengaturan, `PengaturanController`, `IuranController`, Pengaturan Iuran, form Bayar Warga, seeder, dan routes.

### 20 Agustus 2026 - Perbaikan Timestamp Riwayat Kebijakan Iuran
- **Sebelum**: Model `PengaturanIuranModel` menulis `updated_at`, tetapi database lama belum memiliki kolom tersebut sehingga penyimpanan kebijakan gagal dengan error `Unknown column 'updated_at'`.
- **Sesudah**: Kolom `updated_at` tersedia pada tabel `pengaturan_iuran` melalui migration korektif dan migration utama juga mencantumkannya.
- **Alasan**: Menyamakan skema database dengan konfigurasi timestamp model.
- **Dampak**: Migration `AddUpdatedAtToPengaturanIuran` dan proses simpan pengaturan iuran.

### 20 Agustus 2026 - Aktivasi Kebijakan Berdasarkan Tanggal Berlaku
- **Sebelum**: Sistem selalu mengambil kebijakan dengan tanggal `berlaku_dari` paling akhir, termasuk kebijakan yang tanggalnya masih di masa depan. Akibatnya tarif Rp5.000.000 yang mulai 22 Agustus sudah muncul pada 20 Agustus.
- **Sesudah**: Iuran, dashboard, laporan, dan kartu pengaturan hanya memakai kebijakan terakhir yang tanggal berlakunya sudah tercapai. Kebijakan dengan tanggal mendatang berstatus Terjadwal dan tidak menonaktifkan kebijakan aktif saat ini.
- **Alasan**: Tarif baru tidak boleh ditagihkan sebelum tanggal mulai berlaku.
- **Dampak**: `IuranPeriodSummary`, controller iuran, dashboard, laporan, pengaturan iuran, dan test periode.

### 20 Agustus 2026 - Aksi Verifikasi pada Buku Register Iuran
- **Sebelum**: Tab Semua Data hanya menampilkan status pembayaran. Pembayaran pending yang terlihat di register tidak memiliki tombol untuk membuka proses verifikasi.
- **Sesudah**: Setiap baris dengan pembayaran pending menampilkan tombol Verifikasi yang mengarah ke detail verifikasi pembayaran terkait.
- **Alasan**: Pengurus harus dapat memproses pembayaran dari tab mana pun saat memeriksa buku register.
- **Dampak**: View `iuran/index.php`.

### 20 Agustus 2026 - Kuitansi dan Pengiriman WhatsApp dari Register Iuran
- **Sebelum**: Tab Semua Data hanya menyediakan tombol Verifikasi untuk pembayaran pending. Pembayaran lunas belum memiliki tautan kuitansi, dan tombol WhatsApp pada halaman kuitansi masih memakai nomor serta identitas wilayah statis.
- **Sesudah**: Pembayaran lunas pada tab Sudah Lunas dan Semua Data menampilkan tombol Kuitansi dan Kirim WA. Kuitansi hanya dapat dibuka setelah verifikasi, nomor WhatsApp, identitas wilayah, dan bendahara diambil dari database.
- **Alasan**: Pengurus perlu mengirim bukti pembayaran yang benar kepada warga tanpa data demo yang tertinggal.
- **Dampak**: `IuranController`, view `iuran/index.php`, dan view `iuran/kuitansi.php`.

### 20 Agustus 2026 - Akses Kuitansi untuk Pengurus
- **Sebelum**: Route kuitansi berada di grup role warga. Saat pengurus menekan tombol Kuitansi dari daftar iuran, filter role mengarahkan kembali ke dashboard.
- **Sesudah**: Route kuitansi berada di grup autentikasi umum sehingga pengurus dan warga dapat membuka kuitansi pembayaran terverifikasi.
- **Alasan**: Pengurus membutuhkan akses kuitansi dari tab daftar iuran.
- **Dampak**: `app/Config/Routes.php`.

### 20 Agustus 2026 - Resolver Bukti Transfer Seeder
- **Sebelum**: Seeder menyimpan `assets/images/buktitf1.jpeg`, tetapi halaman verifikasi selalu menambahkan prefix `uploads/bukti`, sehingga gambar bukti transfer rusak.
- **Sesudah**: Halaman verifikasi membedakan path asset seed (`assets/...`) dan upload warga (`uploads/...`). Bukti seed memakai `public/assets/images/buktitf1.jpeg` melalui URL `/assets/images/buktitf1.jpeg`.
- **Alasan**: Bukti transfer demo harus tampil pada proses verifikasi tanpa mengubah path upload nyata.
- **Dampak**: Seeder pembayaran dan view `iuran/verifikasi.php`.

### 20 Agustus 2026 - Status Macet Kumulatif pada Filter Bulanan
- **Sebelum**: Rekap bulanan hanya memeriksa satu bulan, sehingga warga yang menunggak sejak awal tahun tetap tampil sebagai Belum Bayar satu bulan dan kartu Macet bernilai nol.
- **Sesudah**: Nilai tagihan tetap mengikuti filter yang dipilih, sedangkan status Macet dihitung dari awal periode kebijakan sampai akhir periode filter.
- **Alasan**: Status macet merupakan indikator akumulasi tunggakan, bukan hanya kondisi satu bulan yang sedang dilihat.
- **Dampak**: `IuranPeriodSummary`, controller iuran dan laporan, serta test rekap periode.

### 20 Agustus 2026 - Bukti Wajib untuk Penolakan Pembayaran
- **Sebelum**: Pengurus dapat menolak pembayaran tanpa catatan dan tanpa bukti pendukung.
- **Sesudah**: Penolakan wajib menyertakan catatan dan upload bukti JPG, PNG, WEBP, atau PDF maksimal 2 MB. Penerimaan tetap tidak mewajibkan catatan maupun upload. Bukti penolakan disimpan terpisah dari bukti transfer warga.
- **Alasan**: Menjamin penolakan dapat dipertanggungjawabkan dan warga menerima alasan yang jelas.
- **Dampak**: Migration pembayaran, `PembayaranModel`, `IuranController`, dan view verifikasi.

### 20 Agustus 2026 - Penggantian Browser Alert dengan Toast Aplikasi
- **Sebelum**: Validasi JavaScript pada verifikasi, filter periode, dan pembayaran memakai dialog `alert()` bawaan browser.
- **Sesudah**: Semua validasi aplikasi memakai toast Bootstrap `showAppToast` yang konsisten dengan desain Kas-Kita. Tidak ada pemanggilan alert browser pada kode aplikasi.
- **Alasan**: Notifikasi harus terintegrasi dengan tampilan aplikasi dan tidak mengganggu alur pengguna dengan dialog browser mentah.
- **Dampak**: View verifikasi iuran, daftar iuran, dan form bayar.

### 20 Agustus 2026 - Sinkronisasi Dashboard Warga
- **Sebelum**: Dashboard warga memakai session dan nilai fallback untuk lokasi, nomor telepon, tarif, serta saldo. Tagihan pembayaran ditolak dihitung nol, riwayat memakai angka bulan, dan bukti ditolak masih membuka bukti transfer warga.
- **Sesudah**: Dashboard membaca profil, wilayah, kebijakan, pemasukan, pengeluaran, dan status pembayaran dari database. Tagihan ditolak kembali masuk sebagai tagihan, riwayat memakai nama bulan dengan area scroll, pending menampilkan bukti transfer warga, dan ditolak menampilkan bukti pengurus jika tersedia.
- **Alasan**: Dashboard warga harus menjadi ringkasan data aktual, bukan tampilan dengan session atau nilai demo yang tertinggal.
- **Dampak**: `DashboardController`, view `dashboard/warga.php`, dan rekap tagihan `IuranPeriodSummary`.
