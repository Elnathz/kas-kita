# Sprint Planning - Kas-Kita

**Deadline**: 18 Agustus 2026
**Mulai**: 16 Agustus 2026 (siang)
**Durasi Efektif**: ~2 hari

---

## Sprint 0: Foundation dan Branch UTS (16 Agustus 2026)

**Target**: Seluruh layout slicing + routing + dummy login selesai di branch `uts`

### Sprint 0.1: Project Setup (16 Agustus, siang)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 1  | Init git repo, buat .gitignore               | 10 menit | [ ]    |
| 2  | Fix konfigurasi .env (port 3309, dbkaskita)   | 5 menit  | [ ]    |
| 3  | Clone FreeDash-lite, ekstrak assets ke public | 20 menit | [ ]    |
| 4  | Commit initial setup                          | 5 menit  | [ ]    |

### Sprint 0.2: Layout Slicing (16 Agustus, siang-sore)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 5  | Buat layout utama (app.php) dari FreeDash    | 30 menit | [ ]    |
| 6  | Slicing komponen header (header.php)          | 20 menit | [ ]    |
| 7  | Slicing komponen sidebar (sidebar.php)        | 30 menit | [ ]    |
| 8  | Slicing komponen footer (footer.php)          | 10 menit | [ ]    |
| 9  | Buat halaman login (standalone, tanpa sidebar)| 20 menit | [ ]    |
| 10 | Test visual: semua komponen render dengan benar| 15 menit | [ ]    |
| 11 | Commit layout slicing                         | 5 menit  | [ ]    |

### Sprint 0.3: Controller dan View Skeleton (16 Agustus, sore-malam)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 12 | Buat LoginController (hardcoded auth, md5)    | 20 menit | [ ]    |
| 13 | Buat DashboardController + view (dummy data)  | 20 menit | [ ]    |
| 14 | Buat WargaController + views (index, create, edit) | 30 menit | [ ] |
| 15 | Buat IuranController + views (index, bayar, riwayat, tagihan, verifikasi) | 40 menit | [ ] |
| 16 | Buat PengeluaranController + views (index, create, edit) | 30 menit | [ ] |
| 17 | Buat KategoriController + views (index, create, edit)    | 20 menit | [ ] |
| 18 | Buat LaporanController + view (index)         | 15 menit | [ ]    |
| 19 | Buat PengaturanController + view (iuran)      | 15 menit | [ ]    |

### Sprint 0.4: Routes dan Final UTS (16 Agustus, malam)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 20 | Setup semua routes di Routes.php              | 20 menit | [ ]    |
| 21 | Dynamic sidebar: highlight active menu        | 15 menit | [ ]    |
| 22 | Test semua route bisa diakses                 | 15 menit | [ ]    |
| 23 | Test login flow (login -> dashboard -> logout)| 10 menit | [ ]    |
| 24 | Final review branch uts                       | 15 menit | [ ]    |
| 25 | Commit final + push branch uts                | 5 menit  | [ ]    |

---

## Sprint 1: Branch Main - Database dan Auth (17 Agustus 2026, pagi)

**Target**: Database ready, auth beneran, CRUD warga

### Sprint 1.1: Database Foundation (17 Agustus, pagi)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 26 | Merge branch uts ke main                      | 5 menit  | [ ]    |
| 27 | Buat migration tabel users                    | 15 menit | [ ]    |
| 28 | Buat migration tabel pengaturan_iuran         | 10 menit | [ ]    |
| 29 | Buat migration tabel pembayaran               | 15 menit | [ ]    |
| 30 | Buat migration tabel kategori_pengeluaran     | 10 menit | [ ]    |
| 31 | Buat migration tabel pengeluaran              | 15 menit | [ ]    |
| 32 | Buat seeder (users, kategori default)         | 20 menit | [ ]    |
| 33 | Run migration + seeder, verifikasi            | 10 menit | [ ]    |

### Sprint 1.2: Auth Real (17 Agustus, pagi)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 34 | Buat UserModel                                | 15 menit | [ ]    |
| 35 | Update LoginController: auth dari database    | 20 menit | [ ]    |
| 36 | Implementasi password_hash dan password_verify| 10 menit | [ ]    |
| 37 | Buat AuthFilter (cek login)                   | 15 menit | [ ]    |
| 38 | Buat RoleFilter (cek role)                    | 15 menit | [ ]    |
| 39 | Register filter di Filters.php dan Routes.php | 10 menit | [ ]    |
| 40 | Test login/logout flow dengan data dari DB    | 10 menit | [ ]    |

---

## Sprint 2: Branch Main - CRUD dan Validasi (17 Agustus 2026, siang-sore)

**Target**: Semua CRUD berfungsi dengan validasi

### Sprint 2.1: CRUD Warga (17 Agustus, siang)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 41 | Buat WargaModel                               | 10 menit | [ ]    |
| 42 | Implementasi WargaController::index (read)    | 15 menit | [ ]    |
| 43 | Implementasi create + store dengan validasi   | 20 menit | [ ]    |
| 44 | Implementasi edit + update dengan validasi    | 20 menit | [ ]    |
| 45 | Implementasi delete (soft delete)             | 10 menit | [ ]    |
| 46 | Test semua CRUD warga                         | 10 menit | [ ]    |

### Sprint 2.2: CRUD Kategori Pengeluaran (17 Agustus, siang)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 47 | Buat KategoriModel                            | 10 menit | [ ]    |
| 48 | Implementasi CRUD kategori dengan validasi    | 25 menit | [ ]    |
| 49 | Test CRUD kategori                            | 5 menit  | [ ]    |

### Sprint 2.3: CRUD Pengeluaran (17 Agustus, sore)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 50 | Buat PengeluaranModel                         | 10 menit | [ ]    |
| 51 | Implementasi CRUD pengeluaran dengan validasi | 30 menit | [ ]    |
| 52 | Test CRUD pengeluaran                         | 10 menit | [ ]    |

### Sprint 2.4: Pengaturan Iuran (17 Agustus, sore)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 53 | Buat PengaturanIuranModel                     | 10 menit | [ ]    |
| 54 | Implementasi ubah nominal iuran               | 20 menit | [ ]    |
| 55 | Test pengaturan iuran                         | 5 menit  | [ ]    |

---

## Sprint 3: Branch Main - Pembayaran dan Laporan (17 Agustus malam - 18 Agustus pagi)

**Target**: Fitur pembayaran dan laporan lengkap

### Sprint 3.1: Pembayaran Iuran (17 Agustus, malam)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 56 | Buat PembayaranModel                          | 15 menit | [ ]    |
| 57 | Implementasi tagihan warga (auto-generate)    | 30 menit | [ ]    |
| 58 | Implementasi bayar iuran + upload bukti       | 30 menit | [ ]    |
| 59 | Implementasi riwayat pembayaran warga         | 15 menit | [ ]    |
| 60 | Implementasi daftar iuran (pengurus view)     | 20 menit | [ ]    |
| 61 | Implementasi verifikasi pembayaran            | 25 menit | [ ]    |
| 62 | Test alur pembayaran end-to-end               | 15 menit | [ ]    |

### Sprint 3.2: Dashboard Real Data (18 Agustus, pagi)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 63 | Update dashboard pengurus dengan data real    | 30 menit | [ ]    |
| 64 | Update dashboard warga dengan data real       | 20 menit | [ ]    |
| 65 | Dynamic sidebar berdasarkan role              | 15 menit | [ ]    |

### Sprint 3.3: Laporan (18 Agustus, pagi)

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 66 | Implementasi laporan bulanan                  | 30 menit | [ ]    |
| 67 | Deteksi warga macet                           | 20 menit | [ ]    |
| 68 | Test laporan                                  | 10 menit | [ ]    |

---

## Sprint 4: Polish dan Final (18 Agustus 2026, siang)

**Target**: QA, bug fix, final review

| No | Task                                        | Estimasi  | Status |
|----|----------------------------------------------|----------|--------|
| 69 | Error pages (404, 403)                        | 15 menit | [ ]    |
| 70 | Flash messages di semua form                  | 20 menit | [ ]    |
| 71 | Responsive check (mobile first)               | 20 menit | [ ]    |
| 72 | Full regression test semua fitur              | 30 menit | [ ]    |
| 73 | Fix bugs yang ditemukan                       | 30 menit | [ ]    |
| 74 | Final commit + push branch main               | 10 menit | [ ]    |

---

## Ringkasan Timeline

| Waktu                     | Sprint   | Focus                          |
|---------------------------|----------|--------------------------------|
| 16 Agustus, siang-sore    | Sprint 0 | Setup + Layout Slicing         |
| 16 Agustus, sore-malam    | Sprint 0 | Controllers + Routes (UTS)     |
| 17 Agustus, pagi          | Sprint 1 | Database + Auth                |
| 17 Agustus, siang-sore    | Sprint 2 | CRUD + Validasi                |
| 17 Agustus, malam         | Sprint 3 | Pembayaran                     |
| 18 Agustus, pagi          | Sprint 3 | Dashboard + Laporan            |
| 18 Agustus, siang         | Sprint 4 | Polish + Final                 |

---

## Catatan

1. Estimasi waktu adalah waktu kerja efektif, belum termasuk istirahat
2. Total estimasi: ~15 jam kerja efektif dalam 2 hari
3. Sprint 0 (branch uts) harus selesai di hari pertama (16 Agustus)
4. Sprint 1-4 (branch main) diselesaikan di 17-18 Agustus
5. Setiap sprint selesai, commit dan push
6. Jika ada fitur yang molor, prioritaskan fitur core (auth, CRUD, pembayaran) daripada fitur nice-to-have (grafik, responsive polish)
