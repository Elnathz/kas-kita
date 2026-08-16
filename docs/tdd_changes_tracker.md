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

