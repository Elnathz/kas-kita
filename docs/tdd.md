# Technical Design Document (TDD) - Kas Kita

**Versi**: 1.0
**Tanggal**: 16 Agustus 2026
**Proyek**: Aplikasi Manajemen Kas RT
**Nama Aplikasi**: Kas Kita

---

## 1. Ringkasan Proyek

Kas Kita adalah aplikasi berbasis web untuk memudahkan pengurus RT dalam mencatat pemasukan (iuran warga) dan pengeluaran kas RT. Aplikasi ini memiliki dua jenis pengguna: **pengurus** dan **warga**. Warga dapat melakukan pembayaran iuran melalui upload bukti transfer, sedangkan pengurus memvalidasi pembayaran, memantau status iuran, mencatat pengeluaran, dan mendapatkan laporan bulanan.

---

## 2. Tech Stack

| Komponen     | Teknologi                    |
|-------------|------------------------------|
| Framework   | CodeIgniter 4.7              |
| PHP         | >= 8.2                       |
| CSS         | Bootstrap 5 (FreeDash-lite)  |
| Database    | MySQL via dbngin             |
| DB Name     | dbkaskita                    |
| DB Port     | 3309                         |
| DB Driver   | MySQLi                       |
| Template    | FreeDash-lite (adminmart)    |

---

## 3. Arsitektur Aplikasi

### 3.1 Pattern

MVC (Model-View-Controller) sesuai standar CodeIgniter 4.

```
Request -> Routes -> Filter (main only) -> Controller -> Model -> Database
                                              |
                                              v
                                            View -> Response
```

### 3.2 Struktur MVC

- **Model**: Interaksi dengan database, validasi data (branch main)
- **View**: Template HTML dengan Bootstrap 5 dari FreeDash-lite
- **Controller**: Business logic, routing handler

---

## 4. Pengguna dan Hak Akses

### 4.1 Role

| Role     | Deskripsi                                          |
|----------|-----------------------------------------------------|
| Pengurus | Mengelola data warga, memvalidasi pembayaran, mencatat pengeluaran, melihat laporan, mengatur nominal iuran |
| Warga    | Melihat tagihan, melakukan pembayaran (upload bukti), melihat riwayat pembayaran |

### 4.2 Matriks Hak Akses

| Fitur                        | Pengurus | Warga |
|------------------------------|----------|-------|
| Dashboard                   | Ya       | Ya    |
| Lihat data warga             | Ya       | Tidak |
| Tambah/edit/hapus warga      | Ya       | Tidak |
| Lihat semua iuran            | Ya       | Tidak |
| Validasi pembayaran          | Ya       | Tidak |
| Lihat tagihan sendiri        | Tidak    | Ya    |
| Upload bukti transfer        | Tidak    | Ya    |
| Lihat riwayat bayar sendiri  | Tidak    | Ya    |
| Catat pengeluaran            | Ya       | Tidak |
| Kelola kategori pengeluaran  | Ya       | Tidak |
| Lihat laporan bulanan        | Ya       | Ya (Statistik) |
| Atur nominal iuran           | Ya       | Tidak |

---

## 5. Desain Database

### 5.1 ERD (Entity Relationship)

```
users 1---* pembayaran
users 1---* pengeluaran (pencatat)
kategori_pengeluaran 1---* pengeluaran
pengaturan_iuran (standalone config)
```

### 5.2 Tabel

#### 5.2.1 `users`

| Kolom        | Tipe           | Constraint          | Keterangan                |
|-------------|----------------|----------------------|---------------------------|
| id          | INT            | PK, AUTO_INCREMENT   |                           |
| nama        | VARCHAR(100)   | NOT NULL             | Nama lengkap              |
| username    | VARCHAR(50)    | NOT NULL, UNIQUE     | Untuk login               |
| password    | VARCHAR(255)   | NOT NULL             | Hash md5 (uts) / password_hash (main) |
| role        | ENUM           | NOT NULL             | 'pengurus', 'warga'      |
| no_rumah    | VARCHAR(10)    | NULL                 | Nomor rumah               |
| no_telepon  | VARCHAR(20)    | NULL                 | Nomor telepon/WA          |
| alamat      | TEXT           | NULL                 | Alamat lengkap            |
| is_active   | TINYINT(1)     | DEFAULT 1            | Status aktif              |
| created_at  | DATETIME       | DEFAULT CURRENT_TIMESTAMP |                      |
| updated_at  | DATETIME       | ON UPDATE CURRENT_TIMESTAMP |                    |

#### 5.2.2 `pengaturan_iuran`

| Kolom         | Tipe           | Constraint          | Keterangan                |
|--------------|----------------|----------------------|---------------------------|
| id           | INT            | PK, AUTO_INCREMENT   |                           |
| nominal      | DECIMAL(12,2)  | NOT NULL             | Nominal iuran per bulan   |
| berlaku_dari | DATE           | NOT NULL             | Tanggal mulai berlaku     |
| created_at   | DATETIME       | DEFAULT CURRENT_TIMESTAMP |                      |
| created_by   | INT            | FK -> users.id       | Pengurus yang mengatur    |

#### 5.2.3 `pembayaran`

| Kolom            | Tipe           | Constraint          | Keterangan                    |
|-----------------|----------------|----------------------|-------------------------------|
| id              | INT            | PK, AUTO_INCREMENT   |                               |
| user_id         | INT            | FK -> users.id       | Warga yang membayar           |
| periode_bulan   | INT            | NOT NULL             | Bulan (1-12)                  |
| periode_tahun   | INT            | NOT NULL             | Tahun                         |
| nominal         | DECIMAL(12,2)  | NOT NULL             | Jumlah yang dibayar           |
| bukti_transfer  | VARCHAR(255)   | NULL                 | Path file bukti               |
| status          | ENUM           | NOT NULL             | 'pending', 'terverifikasi', 'ditolak' |
| catatan         | TEXT           | NULL                 | Catatan dari pengurus         |
| verified_by     | INT            | FK -> users.id, NULL | Pengurus yang memverifikasi   |
| verified_at     | DATETIME       | NULL                 | Waktu verifikasi              |
| created_at      | DATETIME       | DEFAULT CURRENT_TIMESTAMP |                           |
| updated_at      | DATETIME       | ON UPDATE CURRENT_TIMESTAMP |                         |

**Constraint**: UNIQUE(user_id, periode_bulan, periode_tahun) - satu warga hanya bisa bayar sekali per bulan.

#### 5.2.4 `kategori_pengeluaran`

| Kolom       | Tipe          | Constraint          | Keterangan              |
|------------|---------------|----------------------|--------------------------|
| id         | INT           | PK, AUTO_INCREMENT   |                          |
| nama       | VARCHAR(50)   | NOT NULL, UNIQUE     | Nama kategori            |
| deskripsi  | TEXT          | NULL                 | Penjelasan kategori      |
| is_active  | TINYINT(1)    | DEFAULT 1            | Status aktif             |
| created_at | DATETIME      | DEFAULT CURRENT_TIMESTAMP |                     |

**Data default**: Kas, Sosial, Konsumsi (via seeder).

#### 5.2.5 `pengeluaran`

| Kolom         | Tipe           | Constraint          | Keterangan              |
|--------------|----------------|----------------------|--------------------------|
| id           | INT            | PK, AUTO_INCREMENT   |                          |
| kategori_id  | INT            | FK -> kategori_pengeluaran.id | Kategori        |
| tanggal      | DATE           | NOT NULL             | Tanggal pengeluaran      |
| nominal      | DECIMAL(12,2)  | NOT NULL             | Jumlah pengeluaran       |
| keterangan   | TEXT           | NOT NULL             | Deskripsi pengeluaran    |
| created_by   | INT            | FK -> users.id       | Pengurus pencatat        |
| created_at   | DATETIME       | DEFAULT CURRENT_TIMESTAMP |                     |
| updated_at   | DATETIME       | ON UPDATE CURRENT_TIMESTAMP |                   |

---

## 6. Fitur dan Halaman

### 6.1 Autentikasi

#### Login

- **URL**: `/login`
- **Method**: GET (form), POST (proses)
- **Branch UTS**: Hardcoded credentials (`admin` / md5 hash dari `admin123`), simpan di session native PHP
- **Branch main**: Validasi dari database, session CI4, filter auth

#### Registrasi Warga Baru (Branch Main)

- **URL**: `/register`
- **Method**: GET (form pendaftaran), POST (proses registrasi)
- **Input Terstandar**:
  - Nama Lengkap Kepala Keluarga
  - Blok Rumah *(Dropdown terstandar: Blok A, Blok B, dll)*
  - Nomor Rumah *(Dropdown terstandar: No. 01 s/d No. 30)*
  - Nama Jalan *(Dropdown terstandar: Jl. Mawar, Jl. Melati, dll)*
  - Nomor Telepon / WA (numerik)
  - Username (maks 20 karakter) & Password
- **Status Akun Awal**: `is_active = 0` (Menunggu Persetujuan Pengurus)
- **Alur Persetujuan**: Pengurus dapat melihat daftar pendaftar baru di dashboard / menu Warga, lalu memilih **Setujui** (`is_active = 1`) atau **Tolak**.
- **Login Guard**: Jika warga login saat status masih `is_active = 0`, sistem menampilkan pesan: *"Akun Anda sedang menunggu persetujuan dari pengurus RT."*

#### Logout

- **URL**: `/logout`
- **Method**: GET
- **Aksi**: Hapus session, redirect ke login

### 6.2 Dashboard

#### Dashboard Pengurus

- **URL**: `/dashboard`
- **Menampilkan**:
  - Total pemasukan bulan ini
  - Total pengeluaran bulan ini
  - Saldo kas (total pemasukan - total pengeluaran keseluruhan)
  - Jumlah warga yang sudah bayar bulan ini
  - Jumlah warga yang belum bayar bulan ini
  - Grafik pemasukan vs pengeluaran 6 bulan terakhir (branch main)
  - Daftar warga yang belum bayar bulan ini (branch main)
  - Notifikasi/tabel Pendaftar Baru & Pengajuan Pindah Rumah yang Menunggu Persetujuan

#### Dashboard Warga

- **URL**: `/dashboard`
- **Menampilkan**:
  - Status tagihan bulan ini (sudah/belum bayar)
  - Total tunggakan (jika ada)
  - Riwayat 5 pembayaran terakhir
  - Tombol bayar iuran (jika belum bayar)

### 6.3 Manajemen Warga (Pengurus Only)

#### Daftar Warga

- **URL**: `/warga`
- **Method**: GET
- **Menampilkan**: Tabel daftar warga (nama, no rumah, telepon, status pembayaran)
- **Status pembayaran** ditampilkan sebagai badge:
  - `Lancar` (hijau) - tidak ada tunggakan
  - `Nunggak` (kuning) - belum bayar 1 bulan terakhir
  - `Macet` (merah) - belum bayar >= 2 bulan berturut-turut
- Status ini dihitung real-time dari tabel pembayaran, bukan kolom di database

#### Tambah Warga

- **URL**: `/warga/create` (form), `/warga/store` (proses)
- **Method**: GET (form), POST (proses)
- **Input**: Nama, username, password, no rumah, telepon, alamat

#### Edit Warga

- **URL**: `/warga/edit/{id}` (form), `/warga/update/{id}` (proses)
- **Method**: GET (form), POST (proses)

#### Hapus Warga

- **URL**: `/warga/delete/{id}`
- **Method**: POST (soft delete via is_active)

### 6.4 Iuran dan Pembayaran

#### Daftar Iuran (Pengurus)

- **URL**: `/iuran`
- **Method**: GET
- **Menampilkan**: Rekap status iuran per warga untuk periode yang dipilih.
- **Filter periode**:
  - Bulanan: pilih bulan dan tahun.
  - Tahunan: pilih tahun dan rekap dari Januari sampai bulan berjalan untuk tahun aktif, atau Januari hingga Desember untuk tahun yang sudah selesai.
  - Rentang: pilih bulan dan tahun awal serta akhir.
- **Filter tambahan**: Blok. Status ditampilkan melalui tab Menunggu Verifikasi, Tunggakan & Belum Bayar, Sudah Lunas, dan Semua Data.
- Untuk periode lebih dari satu bulan, tiap warga tampil satu kali dengan total tagihan, nilai terverifikasi, nilai pending, sisa tagihan, dan status rekap.
- Kartu ringkasan dan buku register memakai periode filter yang sama.

#### Validasi Pembayaran (Pengurus)

- **URL**: `/iuran/verifikasi/{id}`
- **Method**: GET (detail), POST (proses verifikasi)
- **Aksi**: Lihat bukti transfer, terima atau tolak dengan catatan
- **Info tambahan**: Jika warga berstatus "macet", tampilkan alert banner di atas halaman sebagai konteks bagi pengurus

#### Tagihan & Bayar Iuran (Warga)

- **URL**: `/iuran/tagihan` atau `/iuran/bayar`
- **Method**: GET (daftar tagihan + form pembayaran), POST (`/iuran/bayar/proses`)
- **Menampilkan**: Rincian seluruh periode iuran sejak `berlaku_dari` sampai bulan berjalan, dengan periode sebelum warga terdaftar dikecualikan.
- **Sinkronisasi periode**: Perhitungan tagihan, pembayaran, dan rekap mengikuti sumber periode yang sama dengan Daftar Iuran Pengurus.
- **Mekanisme Pilihan Pembayaran**:
  - **Opsi Bayar Semua Sekaligus**: Warga melunasi seluruh tunggakan + bulan berjalan sekaligus dengan 1 bukti transfer.
  - **Opsi Bayar Sebagian (Satu per Satu)**: Warga dapat memilih bulan tertentu yang ingin dibayar terlebih dahulu. Sistem mewajibkan pelunasan dengan prinsip **FIFO (First In, First Out)**, yaitu melunasi tunggakan bulan paling lama terlebih dahulu sebelum membayar bulan berikutnya.
- **Input**: Checkbox pilihan bulan tagihan yang ingin dibayar, nominal otomatis terakumulasi, upload bukti transfer.

#### Riwayat Pembayaran (Warga)

- **URL**: `/iuran/riwayat`
- **Method**: GET
- **Menampilkan**: Daftar pembayaran berdasarkan tahun aktif. Tab tahun tersedia sejak awal iuran sampai tahun berjalan; tahun tanpa pembayaran menampilkan keadaan kosong.

### 6.5 Pengeluaran (Pengurus Only)

#### Daftar Pengeluaran

- **URL**: `/pengeluaran`
- **Method**: GET
- **Menampilkan**: Tabel pengeluaran (tanggal, kategori, nominal, keterangan)
- **Filter**: Kategori, bulan, tahun

#### Tambah Pengeluaran

- **URL**: `/pengeluaran/create` (form), `/pengeluaran/store` (proses)
- **Method**: GET (form), POST (proses)
- **Input**: Kategori, tanggal, nominal, keterangan

#### Edit Pengeluaran

- **URL**: `/pengeluaran/edit/{id}` (form), `/pengeluaran/update/{id}` (proses)
- **Method**: GET (form), POST (proses)

#### Hapus Pengeluaran

- **URL**: `/pengeluaran/delete/{id}`
- **Method**: POST

### 6.6 Kategori Pengeluaran (Pengurus Only)

#### Daftar Kategori

- **URL**: `/kategori`
- **Method**: GET

#### Tambah Kategori

- **URL**: `/kategori/create`, `/kategori/store`
- **Method**: GET, POST

#### Edit Kategori

- **URL**: `/kategori/edit/{id}`, `/kategori/update/{id}`
- **Method**: GET, POST

#### Hapus Kategori

- **URL**: `/kategori/delete/{id}`
- **Method**: POST (soft delete)

### 6.7 Pengaturan Iuran (Pengurus Only)

#### Ubah Nominal Iuran

- **URL**: `/pengaturan/iuran`
- **Method**: GET (form), POST (proses)
- **Input**: Nominal baru, tanggal berlaku
- **Catatan**: Nominal lama tetap tersimpan untuk histori

### 6.8 Laporan

#### Laporan Bulanan (Pengurus)

- **URL**: `/laporan`
- **Method**: GET
- **Filter**: Bulan, tahun
- **Menampilkan**:
  - Rekap pemasukan bulan tersebut
  - Rekap pengeluaran per kategori
  - Saldo bulan tersebut
  - Daftar warga yang sudah bayar
  - Daftar warga yang belum bayar
  - Daftar warga pembayaran macet (belum bayar > 2 bulan berturut)

#### Laporan Bulanan (Warga)

- **URL**: `/laporan-warga`
- **Method**: GET
- **Filter**: Bulan, tahun
- **Menampilkan**:
  - Tampilan yang sama dengan Pengurus, namun tanpa tab "Data Lengkap Warga (Internal)".
  - Warga hanya dapat melihat rekap saldo, pengeluaran, bukti nota, dan tab "Statistik per Blok (Publik)".
  - Daftar warga pembayaran macet (belum bayar > 2 bulan berturut)

### 6.9 Profil Warga

- **URL**: `/profil`
- **Method**: GET (view), POST (proses ubah data)
- **Aturan Perubahan Data**:
  - Warga dapat langsung mengubah: Nama Lengkap, Username, Password, dan Nomor Telepon/WA (Perubahan langsung tersimpan).
  - Warga tidak dapat langsung mengubah: Blok, Nomor Rumah, dan Nama Jalan. Jika diubah, akan berstatus "Pengajuan Perubahan" yang memerlukan Persetujuan Pengurus (muncul di Dashboard Pengurus).
  - **Tampilan**: Form modern terpisah (Informasi Pribadi, Identitas Rumah, Keamanan Akun).

---

## 7. Layout dan Komponen UI

### 7.1 Layout Utama (app.php)

Template menggunakan FreeDash-lite dengan struktur:

```
+--------------------------------------------------+
| HEADER (top navbar)                               |
+----------+---------------------------------------+
|          |                                        |
| SIDEBAR  |  CONTENT AREA                         |
| (nav)    |                                        |
|          |                                        |
|          +---------------------------------------+
|          | FOOTER                                 |
+----------+---------------------------------------+
```

### 7.2 Komponen

| Komponen     | File                              | Isi                          |
|-------------|-----------------------------------|------------------------------|
| Header      | views/components/header.php       | Navbar atas, user info, logout |
| Sidebar     | views/components/sidebar.php      | Menu navigasi utama          |
| Footer      | views/components/footer.php       | Copyright, info aplikasi     |
| Layout      | views/layouts/app.php             | Wrapper yang include ketiga komponen |

### 7.3 Menu Sidebar

**Menu Pengurus:**
- Dashboard
- Data Warga
- Iuran
  - Daftar Iuran
  - Verifikasi Pembayaran
- Pengeluaran
  - Daftar Pengeluaran
  - Kategori
- Pengaturan Iuran
- Laporan

**Menu Warga:**
- Dashboard
- Tagihan Saya
- Bayar Iuran
- Riwayat Pembayaran

---

## 8. Alur Bisnis

### 8.1 Alur Pembayaran Iuran

```
1. Sistem generate tagihan otomatis tiap awal bulan
2. Warga melihat tagihan di dashboard/halaman tagihan
3. Warga klik "Bayar", pilih periode, upload bukti transfer
4. Status pembayaran = "pending"
5. Pengurus melihat daftar pembayaran pending
6. Pengurus lihat bukti transfer
7. Pengurus klik "Terima" atau "Tolak" dengan catatan
8. Jika diterima: status = "terverifikasi"
9. Jika ditolak: status = "ditolak", warga bisa upload ulang
```

### 8.2 Alur Deteksi Tunggakan dan Status Macet

```
1. Setiap bulan baru, sistem cek siapa yang belum bayar bulan sebelumnya
2. Jika belum bayar, tagihan bulan sebelumnya tetap muncul sebagai tunggakan
3. Warga bisa melihat total tunggakan di dashboard
4. Pengurus bisa melihat daftar warga macet (belum bayar > 2 bulan)
```

**Mekanisme status pembayaran warga:**
- Status dihitung real-time dari tabel `pembayaran`, bukan disimpan di kolom database
- Logic: iterasi mundur dari bulan ini, hitung berapa bulan berturut-turut yang tidak punya record `terverifikasi`
- Berhenti menghitung begitu ketemu bulan yang sudah terbayar
- Klasifikasi:
  - **Lancar**: 0 bulan tunggakan berturut
  - **Nunggak**: 1 bulan tunggakan berturut
  - **Macet**: >= 2 bulan tunggakan berturut-turut

**Tampil di 3 tempat:**
1. **Tabel daftar warga** - badge warna di kolom status
2. **Dashboard pengurus** - card/tabel khusus "Warga Macet"
3. **Halaman verifikasi pembayaran** - alert banner jika warga berstatus macet

### 8.3 Alur Pencatatan Pengeluaran

```
1. Pengurus buka halaman pengeluaran
2. Klik "Tambah Pengeluaran"
3. Pilih kategori, isi tanggal, nominal, keterangan
4. Submit
5. Pengeluaran tercatat dan masuk ke laporan
```

### 8.4 Alur Registrasi dan Persetujuan Warga Baru (Branch Main)

```
1. Warga buka halaman /register
2. Warga mengisi form: Nama lengkap, No Rumah, No Telepon/WA, Username, Password
3. Data tersimpan ke tabel users dengan role 'warga' dan is_active = 0 (Menunggu Persetujuan)
4. Pengurus login dan melihat notifikasi/daftar pendaftar baru di menu Warga
5. Pengurus memverifikasi identitas warga:
   - Jika Disetujui -> is_active diubah menjadi 1 (Warga dapat login dan mengakses dashboard/iuran)
   - Jika Ditolak -> data pendaftaran dihapus atau ditandai ditolak
```

---

## 9. Scope per Branch

### 9.1 Branch UTS

| Komponen          | Status    | Detail                                    |
|-------------------|-----------|-------------------------------------------|
| Layout slicing    | Include   | Header, sidebar, footer, layout utama     |
| Routes            | Include   | Semua route terdefinisi                   |
| Controller        | Include   | Semua controller ada, return view saja    |
| View              | Include   | Semua halaman ada dengan layout           |
| Login             | Include   | Hardcoded, md5, session native            |
| Model             | Exclude   | Belum ada                                 |
| Migration         | Exclude   | Belum ada                                 |
| Seeder            | Exclude   | Belum ada                                 |
| Filter            | Exclude   | Belum ada                                 |
| CRUD              | Exclude   | Belum ada data real                       |
| Validasi          | Exclude   | Belum ada                                 |
| Upload file       | Exclude   | Belum ada                                 |
| Laporan           | Exclude   | Belum ada data                            |

### 9.2 Branch Main (tambahan dari UTS)

| Komponen          | Status    | Detail                                    |
|-------------------|-----------|-------------------------------------------|
| Model             | Include   | Semua model dengan relasi                 |
| Migration         | Include   | Semua tabel                               |
| Seeder            | Include   | Data dummy + kategori default             |
| Filter            | Include   | Auth filter, role filter                  |
| Session           | Include   | CI4 session                               |
| CRUD              | Include   | Create, read, update, delete semua modul  |
| Validasi          | Include   | Server-side validation                    |
| Upload file       | Include   | Upload bukti transfer                     |
| Laporan           | Include   | Report bulanan                            |
| Password          | Include   | password_hash/password_verify             |

---

## 10. Validasi (Branch Main)

### 10.1 Users

| Field     | Rules                                                  |
|-----------|--------------------------------------------------------|
| nama      | required, min_length[3], max_length[100]               |
| username  | required, min_length[3], max_length[50], is_unique     |
| password  | required, min_length[6]                                |
| role      | required, in_list[pengurus,warga]                      |
| no_rumah  | permit_empty, max_length[10]                           |
| no_telepon| permit_empty, max_length[20]                           |

### 10.2 Pembayaran

| Field          | Rules                                              |
|----------------|-----------------------------------------------------|
| periode_bulan  | required, in_list[1,2,3,4,5,6,7,8,9,10,11,12]      |
| periode_tahun  | required, exact_length[4], numeric                   |
| bukti_transfer | required, uploaded, max_size[2048], ext_in[jpg,jpeg,png] |

### 10.3 Pengeluaran

| Field       | Rules                                               |
|-------------|------------------------------------------------------|
| kategori_id | required, numeric, is_not_unique[kategori_pengeluaran.id] |
| tanggal     | required, valid_date                                  |
| nominal     | required, numeric, greater_than[0]                    |
| keterangan  | required, min_length[5]                               |

---

## 11. Response dan Error Handling

### 11.1 Flash Message

Menggunakan CI4 session flashdata untuk notifikasi:
- **Sukses**: Alert hijau dengan pesan keberhasilan
- **Gagal**: Alert merah dengan pesan error
- **Info**: Alert biru untuk informasi
- **Warning**: Alert kuning untuk peringatan

### 11.2 Error Page

- **404**: Halaman tidak ditemukan (custom view)
- **403**: Akses ditolak (custom view)

---

## 12. Keamanan

### 12.1 Branch UTS

- Login dengan md5 (hardcoded)
- Session native PHP untuk menyimpan status login
- Tidak ada filter, akses semua halaman bebas setelah login

### 12.2 Branch Main

- Password hash menggunakan `password_hash()` dan `password_verify()`
- Session CI4
- Auth filter: cek apakah sudah login
- Role filter: cek apakah role sesuai untuk mengakses halaman
- CSRF protection (CI4 built-in)
- Input validation di server-side
- File upload validation (tipe, ukuran)
