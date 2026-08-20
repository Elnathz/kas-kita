# Plan Sinkronisasi Laporan Kas

## Tujuan

Menyamakan filter, kartu ringkasan, rincian pengeluaran, rekap warga, dan hasil cetak laporan pada periode yang sama.

## Cakupan

1. Filter bulanan, tahunan, dan semua periode.
2. Kartu laporan dihitung dari data periode aktif; saldo memakai akumulasi sampai akhir periode.
3. Rincian pengeluaran menampilkan tautan nota dan dokumentasi.
4. Data internal warga menampilkan bulan tertunggak, sisa tagihan, status, dan penagihan WhatsApp.
5. Kop laporan membaca pengaturan wilayah dan tanda tangan membaca jabatan pengurus.
6. CSS cetak A4 menyembunyikan data internal dan elemen navigasi.

## Verifikasi

- Jalankan migration `AddJabatanToUsers`.
- Jalankan `DatabaseSeeder`.
- Lint controller, view, model, migration, dan seeder.
- Jalankan seluruh PHPUnit.
