# Filter Periode dan Rekap Iuran Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Pengurus dapat melihat rekap iuran per warga untuk satu bulan, satu tahun, atau rentang bulan dan tahun, dengan kartu status yang menggunakan periode filter yang sama.

**Architecture:** `IuranPeriodSummary` menjadi unit logika murni untuk membentuk periode dan merekap pembayaran per warga. `IuranController::index()` memuat data, memanggil unit tersebut, lalu mengirim hasil yang sama ke kartu, tab, dan buku register. View hanya memilih parameter periode dan merender hasil rekap tanpa perhitungan finansial baru.

**Tech Stack:** CodeIgniter 4.7, PHP 8.2, PHPUnit 10, Bootstrap 5 dari FreeDash-lite.

**Spec:** `docs/tdd.md` bagian 6.4, serta desain filter periode dan rekap yang disetujui pengguna pada percakapan ini.

## Global Constraints

- TDD adalah source of truth dan perubahan filter periode harus dicatat di `docs/tdd_changes_tracker.md`.
- Tidak menambah dependency atau CDN.
- Tidak memakai emoji, em dash, atau gradient baru pada UI.
- Kartu, tab, dan tabel harus memakai hasil rekap periode yang sama.
- File `IuranController.php` dan `Views/iuran/index.php` sudah memiliki perubahan lokal pengguna. Jangan commit file tersebut tanpa persetujuan setelah diff ditinjau.

---

### Task 1: Test kalkulasi periode dan rekap warga

**Files:**
- Create: `tests/unit/IuranPeriodSummaryTest.php`
- Create: `app/Libraries/IuranPeriodSummary.php`

**Interfaces:**
- Consumes: array filter GET, array warga, array pembayaran, nominal iuran, dan toleransi macet.
- Produces: `resolvePeriod(array $filters, int $defaultMonth, int $defaultYear): array` dan `summarize(array $warga, array $pembayaran, array $period, int $nominal, int $toleransiMacet): array`.

- [x] **Step 1: Tulis test gagal untuk jenis periode**

```php
public function testResolvePeriodBuildsInclusiveMonthlyRange(): void
{
    $period = IuranPeriodSummary::resolvePeriod([
        'jenis_periode' => 'rentang',
        'bulan_awal' => 7,
        'tahun_awal' => 2026,
        'bulan_akhir' => 8,
        'tahun_akhir' => 2026,
    ], 8, 2026);

    $this->assertSame('Juli - Agustus 2026', $period['label']);
    $this->assertSame(['2026-07', '2026-08'], $period['keys']);
}
```

- [x] **Step 2: Jalankan test dan pastikan gagal karena class belum ada**

Run: `php vendor\bin\phpunit --no-coverage --filter IuranPeriodSummaryTest`

Expected: gagal dengan class `App\\Libraries\\IuranPeriodSummary` belum ditemukan.

- [x] **Step 3: Tulis test gagal untuk rekap seorang warga**

```php
public function testSummarizeSeparatesVerifiedPendingAndOutstandingAmounts(): void
{
    $summary = IuranPeriodSummary::summarize($warga, $pembayaran, $period, 50000, 2);

    $this->assertSame(100000, $summary['total_target']);
    $this->assertSame(50000, $summary['total_terverifikasi']);
    $this->assertSame(50000, $summary['total_pending']);
    $this->assertSame(0, $summary['total_sisa']);
    $this->assertTrue($summary['warga'][0]['butuh_verifikasi']);
}
```

- [x] **Step 4: Implementasi minimal library**

```php
final class IuranPeriodSummary
{
    public static function resolvePeriod(array $filters, int $defaultMonth, int $defaultYear): array;

    public static function summarize(
        array $warga,
        array $pembayaran,
        array $period,
        int $nominal,
        int $toleransiMacet
    ): array;
}
```

`resolvePeriod()` harus menyediakan daftar kunci bulan inklusif dan label Bahasa Indonesia. `summarize()` harus menghitung jumlah periode, target, nilai terverifikasi, nilai pending, sisa tagihan, serta flag `butuh_verifikasi`, `punya_tunggakan`, dan `lunas` per warga.

- [x] **Step 5: Jalankan test unit sampai lulus**

Run: `php vendor\bin\phpunit --no-coverage --filter IuranPeriodSummaryTest`

Expected: seluruh test pada kelas lulus.

### Task 2: Integrasikan rekap periode ke controller

**Files:**
- Modify: `app/Controllers/IuranController.php:9-189`
- Test: `tests/unit/IuranPeriodSummaryTest.php`

**Interfaces:**
- Consumes: `IuranPeriodSummary::resolvePeriod()` dan `IuranPeriodSummary::summarize()`.
- Produces: data view `period`, `rekap`, `warga_per_blok`, dan statistik kartu dari rekap yang sama.

- [x] **Step 1: Tambah test gagal untuk batas awal keanggotaan warga**

```php
public function testSummarizeOnlyBillsMonthsAfterResidentJoined(): void
{
    $summary = IuranPeriodSummary::summarize($wargaBergabungAgustus, [], $periodJuliAgustus, 50000, 2);

    $this->assertSame(1, $summary['warga'][0]['jumlah_periode']);
    $this->assertSame(50000, $summary['warga'][0]['total_tagihan']);
}
```

- [x] **Step 2: Jalankan test dan pastikan gagal pada perhitungan periode warga baru**

Run: `php vendor\bin\phpunit --no-coverage --filter IuranPeriodSummaryTest`

Expected: test gagal karena bulan sebelum warga bergabung masih ikut tertagih.

- [x] **Step 3: Ganti kalkulasi satu bulan di `index()`**

1. Ambil query `jenis_periode`, bulan dan tahun awal, serta bulan dan tahun akhir.
2. Buat `$period` melalui `IuranPeriodSummary::resolvePeriod()`.
3. Muat pembayaran hanya pada rentang `$period` dengan kondisi Query Builder terkelompok pada tahun dan bulan.
4. Buat `$rekap` melalui `IuranPeriodSummary::summarize()`.
5. Bentuk `warga_per_blok` dari `$rekap['warga']` dan akumulasi target serta terkumpul per blok.
6. Kirim statistik kartu dari `$rekap['statistik']`, bukan dari waktu server.

- [x] **Step 4: Jalankan test unit sampai lulus**

Run: `php vendor\bin\phpunit --no-coverage --filter IuranPeriodSummaryTest`

Expected: seluruh test pada kelas lulus.

### Task 3: Render filter dan rekap dari data periode aktif

**Files:**
- Modify: `app/Views/iuran/index.php:1-509`

**Interfaces:**
- Consumes: `$period`, `$rekap`, `$warga_per_blok`, `$master_blok`, dan statistik kartu yang berasal dari controller.
- Produces: form GET dengan `jenis_periode`, rekap per warga pada seluruh tab, kartu status yang menyebut periode aktif.

- [x] **Step 1: Tambah filter jenis periode**

Gunakan tiga pilihan: `Bulanan`, `Tahunan`, dan `Rentang`. Bulanan menampilkan bulan dan tahun. Tahunan hanya menampilkan tahun. Rentang menampilkan bulan dan tahun awal serta akhir. Tombol `Terapkan` mengirim semua filter sekaligus dan JavaScript mencegah periode akhir lebih awal dari periode mulai.

- [x] **Step 2: Gunakan label periode untuk semua teks kontekstual**

Ganti teks `Bln Ini`, `Bulan Ini`, tanggal jatuh tempo, dan `Agustus 2026` dengan `<?= esc($period['label']) ?>` atau data periode yang setara.

- [x] **Step 3: Ubah baris menjadi rekap warga**

Setiap baris menampilkan periode, jumlah bulan, total tagihan, terverifikasi, pending, sisa tagihan, status, dan aksi yang relevan. Tab Menunggu Verifikasi memakai flag `butuh_verifikasi`; tab Tunggakan memakai `punya_tunggakan`; tab Lunas memakai `lunas`; tab Semua Data memakai semua warga.

- [x] **Step 4: Periksa sintaks JavaScript**

Hapus kurung kurawal penutup berlebih setelah `toggleAllIuranBlocks()` dan pertahankan fungsi tab serta accordion.

### Task 4: Dokumentasi dan verifikasi

**Files:**
- Modify: `docs/tdd.md`
- Modify: `docs/tdd_changes_tracker.md`
- Modify: `docs/walkthrough.md` jika progress modul iuran dicatat di sana.

**Interfaces:**
- Consumes: implementasi filter periode yang lulus test.
- Produces: TDD dan tracker yang mendeskripsikan filter Bulanan, Tahunan, dan Rentang serta rekap per warga.

- [x] **Step 1: Perbarui TDD bagian Daftar Iuran**

Ganti deskripsi filter menjadi jenis periode Bulanan, Tahunan, dan Rentang, lalu nyatakan bahwa hasil pada periode lebih dari satu bulan direkap per warga.

- [x] **Step 2: Tambah entry tracker perubahan TDD**

Catat kondisi filter sebelumnya, perilaku rekap baru, alasan kebutuhan monitoring lintas periode, dan file yang terdampak.

- [ ] **Step 3: Jalankan verifikasi**

```powershell
php vendor\bin\phpunit --no-coverage
php -l app\Libraries\IuranPeriodSummary.php
php -l app\Controllers\IuranController.php
php -l app\Views\iuran\index.php
```

Lakukan smoke test manual pada `/iuran` untuk Bulanan, Tahunan, dan Rentang Juli-Agustus 2026. Pastikan angka empat kartu berubah mengikuti filter dan tidak ada teks periode yang hardcode.

- [ ] **Step 4: Tinjau diff sebelum commit**

Run: `git diff -- app/Controllers/IuranController.php app/Views/iuran/index.php app/Libraries/IuranPeriodSummary.php tests/unit/IuranPeriodSummaryTest.php docs`

Expected: perubahan hanya mencakup rekap periode dan dokumentasinya. Jangan commit file yang telah kotor sejak awal tanpa persetujuan pengguna.
### Task 5: Sinkronisasi mode warga dan batas tampilan

- [x] Gunakan `berlaku_dari` sampai bulan berjalan sebagai batas periode bersama.
- [x] Gunakan periode eligible warga pada tagihan dan pembayaran warga.
- [x] Tambahkan tab tahun pada riwayat pembayaran warga.
- [x] Paksa kolom nominal tetap satu baris.
