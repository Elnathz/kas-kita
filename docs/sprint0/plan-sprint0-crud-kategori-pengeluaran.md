# Plan CRUD Kategori dan Pengeluaran

## Tujuan

Memastikan kategori pengeluaran dapat dibuat, diubah, dan dihapus dengan aman serta langsung tersedia pada form pencatatan pengeluaran.

## Cakupan

1. Validasi nama kategori unik dan pengecekan data sebelum ubah atau hapus.
2. Validasi kategori, nominal, keterangan, dan tanggal pengeluaran.
3. Menolak tanggal pengeluaran di masa depan; tanggal hari ini dan tanggal lampau tetap diperbolehkan.
4. Menyimpan lampiran nota dan dokumentasi pada folder upload aplikasi.
5. Menampilkan pesan validasi pada form agar pengguna dapat memperbaiki input.

## Verifikasi

- Lint controller dan view yang berubah.
- Jalankan seluruh PHPUnit.
- Uji alur manual: buat kategori, buka form pengeluaran, simpan pengeluaran, edit, dan hapus.
