<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<?php
$namaBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
?>

<!-- KOP SURAT (Hanya saat cetak) -->
<div class="d-none d-print-block mb-4 pb-3 border-bottom text-center">
    <h3 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">RUKUN TETANGGA 04 / RUKUN WARGA 12</h3>
    <h5 class="fw-bold mb-1 text-uppercase">KELURAHAN SUKAMAJU, KECAMATAN COBLONG</h5>
    <p class="mb-0 small text-muted">Sekretariat: Balai Pertemuan RT 04, Jl. Mawar No. 01 &bull; Telp/WA: 081234567890</p>
    <div class="mt-3 pt-2 border-top border-dark border-2">
        <h4 class="fw-bold mb-0 text-uppercase">LAPORAN PERTANGGUNGJAWABAN KAS BULAN <?= strtoupper($namaBulan[$bulan] ?? '') ?> <?= $tahun ?></h4>
    </div>
</div>

<div class="row g-4">
    <!-- Header & Filter Periode -->
    <div class="col-12 d-print-none">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Laporan Rekapitulasi Kas RT</h4>
                        <p class="text-muted small mb-0">Transparansi alokasi pengeluaran, dokumentasi kegiatan, dan partisipasi iuran warga RT 04.</p>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form class="d-flex align-items-center gap-2 m-0" method="get"
                              action="<?= base_url($isWarga ? 'laporan-warga' : 'laporan') ?>">
                            <select class="form-select form-select-sm" name="bulan" style="width: 115px;">
                                <?php foreach ($namaBulan as $nb => $nm): ?>
                                <option value="<?= $nb ?>" <?= $nb == $bulan ? 'selected' : '' ?>><?= $nm ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-select form-select-sm" name="tahun" style="width: 85px;">
                                <?php foreach ($tahunOptions as $ty): ?>
                                <option value="<?= $ty ?>" <?= $ty == $tahun ? 'selected' : '' ?>><?= $ty ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success fw-semibold px-3">Filter</button>
                        </form>

                        <div class="vr mx-1 d-none d-sm-block"></div>

                        <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" onclick="window.print()">
                            <i data-feather="printer" class="feather-icon" style="width: 14px; height: 14px;"></i>
                            <span>Cetak PDF</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Stat Cards -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Pemasukan Iuran</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($totalPemasukanBulan, 0, ',', '.') ?></h4>
                    <small class="text-success font-12 fw-semibold"><?= $jumlahTransaksiBulan ?> Transaksi Warga Lunas</small>
                </div>
                <div class="bg-light rounded p-2 text-success d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="trending-up" class="feather-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Pengeluaran</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($totalPengeluaranBulan, 0, ',', '.') ?></h4>
                    <small class="text-danger font-12 fw-semibold"><?= $jumlahKegiatanBulan ?> Kegiatan / Transaksi</small>
                </div>
                <div class="bg-light rounded p-2 text-danger d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="trending-down" class="feather-icon text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-<?= $arusKasBulan >= 0 ? 'success' : 'danger' ?> border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Arus Kas Bulan Ini</span>
                    <h4 class="text-<?= $arusKasBulan >= 0 ? 'success' : 'danger' ?> fw-bold mb-0 text-nowrap">
                        <?= $arusKasBulan >= 0 ? '+ ' : '- ' ?>Rp <?= number_format(abs($arusKasBulan), 0, ',', '.') ?>
                    </h4>
                    <small class="text-muted font-12"><?= $arusKasBulan >= 0 ? 'Surplus' : 'Defisit' ?> Kas Bulan Ini</small>
                </div>
                <div class="bg-light rounded p-2 d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="<?= $arusKasBulan >= 0 ? 'plus-circle' : 'minus-circle' ?>" class="feather-icon text-<?= $arusKasBulan >= 0 ? 'success' : 'danger' ?>"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Saldo Kas RT Terkini</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($saldoKumulatif, 0, ',', '.') ?></h4>
                    <small class="text-primary font-12 fw-semibold">Kas Kumulatif RT 04</small>
                </div>
                <div class="bg-light rounded p-2 text-primary d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="shield" class="feather-icon text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 1: Rincian Pengeluaran dari DB -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
                    <div>
                        <h4 class="card-title fw-bold mb-1">1. Rincian Pengeluaran Kas RT</h4>
                        <p class="text-muted small mb-0">Pertanggungjawaban penggunaan dana kas RT bulan <?= $namaBulan[$bulan] ?> <?= $tahun ?>.</p>
                    </div>
                    <span class="badge bg-success-subtle text-success-emphasis border border-success px-3 py-2 d-print-none">
                        Transparansi Terbuka Seluruh Warga
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="width: 50px;">No</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Pos Kategori</th>
                                <th>Rincian Keperluan / Kegiatan</th>
                                <th class="text-end text-nowrap">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pengeluaranBulan)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada pengeluaran pada bulan ini.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($pengeluaranBulan as $i => $p): ?>
                            <tr>
                                <td class="text-nowrap"><?= $i + 1 ?></td>
                                <td class="text-muted small text-nowrap"><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                                <td class="text-nowrap text-dark fw-medium"><?= esc($p['nama_kategori'] ?? 'Lainnya') ?></td>
                                <td class="text-dark fw-medium"><?= esc($p['keterangan']) ?></td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end fw-bold text-dark">Total Realisasi Pengeluaran <?= $namaBulan[$bulan] ?> <?= $tahun ?>:</th>
                                <th class="text-end fw-bold text-dark fs-6">Rp <?= number_format($totalPengeluaranBulan, 0, ',', '.') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 2: Rekapitulasi Partisipasi Iuran Warga -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">2. Rekapitulasi Partisipasi Iuran Warga</h4>
                        <p class="text-muted small mb-0">Statistik kepatuhan warga dan monitoring penagihan iuran kas RT.</p>
                    </div>
                    <div class="nav-segment-container d-inline-flex p-1 rounded-pill d-print-none">
                        <ul class="nav nav-pills border-0 gap-1" id="laporanTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-1"
                                        id="publik-tab" data-bs-toggle="tab" data-bs-target="#publik" type="button" role="tab">
                                    <i data-feather="bar-chart-2" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                    <span>Statistik per Blok</span>
                                </button>
                            </li>
                            <?php if (!$isWarga): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-1"
                                        id="internal-tab" data-bs-toggle="tab" data-bs-target="#internal" type="button" role="tab">
                                    <i data-feather="lock" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                    <span>Data Lengkap Warga</span>
                                </button>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="tab-content" id="laporanTabContent">
                    <!-- TAB 1: Statistik per Blok -->
                    <div class="tab-pane fade show active" id="publik" role="tabpanel">
                        <div class="row g-3 mb-4">
                            <?php foreach ($wargaPerBlok as $namaBlok => $info): ?>
                            <?php
                                $jmlWarga  = count($info['warga']);
                                $persen    = $jmlWarga > 0 ? round(($info['lunas'] / $jmlWarga) * 100) : 0;
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0 font-14">Blok <?= esc($namaBlok) ?></h6>
                                        <span class="badge bg-light text-dark border font-11"><?= $jmlWarga ?> Rumah</span>
                                    </div>
                                    <h3 class="fw-bold text-<?= $persen >= 70 ? 'success' : ($persen >= 40 ? 'warning' : 'danger') ?> mb-2">
                                        <?= $persen ?>% <span class="fs-6 fw-normal text-muted font-12">Lunas</span>
                                    </h3>
                                    <div class="d-flex align-items-center gap-1 font-12 pt-2 border-top flex-wrap">
                                        <span class="text-success fw-bold"><?= $info['lunas'] ?> Lunas</span>
                                        <span class="text-muted">&bull;</span>
                                        <?php if ($info['pending'] > 0): ?>
                                        <span class="text-primary fw-bold"><?= $info['pending'] ?> Proses</span>
                                        <span class="text-muted">&bull;</span>
                                        <?php endif; ?>
                                        <span class="text-warning fw-bold text-dark"><?= $info['belum'] ?> Belum</span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php if (empty($wargaPerBlok)): ?>
                            <div class="col-12">
                                <p class="text-muted text-center py-3">Belum ada data blok.</p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="alert alert-light border d-flex align-items-center justify-content-between p-3 mb-0">
                            <div>
                                <span class="fw-bold text-dark d-block">Tingkat Partisipasi Iuran Warga RT 04:</span>
                                <small class="text-muted">
                                    Total <?= $totalLunas ?> dari <?= $totalWarga ?> Kepala Keluarga
                                    (<?= $persentasePartisipasi ?>%) telah berpartisipasi dalam pembayaran iuran bulan ini.
                                </small>
                            </div>
                            <span class="fs-4 fw-bold text-<?= $persentasePartisipasi >= 70 ? 'success' : ($persentasePartisipasi >= 40 ? 'warning' : 'danger') ?>">
                                <?= $persentasePartisipasi ?>%
                            </span>
                        </div>
                    </div>

                    <!-- TAB 2: Data Lengkap Warga (Khusus Pengurus) -->
                    <?php if (!$isWarga): ?>
                    <div class="tab-pane fade" id="internal" role="tabpanel">
                        <div class="alert alert-warning py-2 px-3 small mb-3 d-flex align-items-center justify-content-between">
                            <span><strong>Arsip Internal Pengurus:</strong> Data ini khusus digunakan untuk keperluan penagihan dan monitoring internal RT.</span>
                            <span class="badge bg-danger"><?= $totalBelum ?> Warga Belum Bayar</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">Nama Kepala Keluarga</th>
                                        <th class="text-nowrap">Alamat Rumah</th>
                                        <th class="text-center text-nowrap">Status Pembayaran</th>
                                        <th class="text-center text-nowrap" style="width: 110px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $allWarga = [];
                                    foreach ($wargaPerBlok as $namaBlok => $info) {
                                        foreach ($info['warga'] as $w) {
                                            $w['blok'] = $namaBlok;
                                            $allWarga[] = $w;
                                        }
                                    }
                                    usort($allWarga, function($a, $b) {
                                        return strcmp($a['status'], $b['status']);
                                    });
                                    ?>
                                    <?php foreach ($allWarga as $w): ?>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap"><?= esc($w['nama']) ?></td>
                                        <td class="text-nowrap text-dark fw-medium">Blok <?= esc($w['blok']) ?> / No. <?= esc($w['no_rumah']) ?></td>
                                        <td class="text-center text-nowrap">
                                            <?php if ($w['status'] == 'terverifikasi'): ?>
                                                <span class="badge bg-success">Lunas</span>
                                            <?php elseif ($w['status'] == 'pending'): ?>
                                                <span class="badge bg-primary">Proses Verifikasi</span>
                                            <?php elseif ($w['status'] == 'ditolak'): ?>
                                                <span class="badge bg-danger">Ditolak</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?php if ($w['status'] != 'terverifikasi' && !empty($w['no_telepon'])): ?>
                                            <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', $w['no_telepon']), '0') ?>"
                                               target="_blank" class="btn btn-xs btn-outline-success">Tagih WA</a>
                                            <?php else: ?>
                                            <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($allWarga)): ?>
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data warga.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tanda Tangan (hanya cetak) -->
<div class="d-none d-print-block mt-5 pt-4">
    <div class="d-flex justify-content-between px-4 text-center">
        <div style="width: 250px;">
            <p class="mb-1 text-dark">Mengetahui,<br><strong>Ketua RT 04 RW 12</strong></p>
            <div style="height: 70px;"></div>
            <p class="mb-0 fw-bold text-dark text-decoration-underline">( ________________ )</p>
            <small class="text-muted font-11">Ketua RT</small>
        </div>
        <div style="width: 250px;">
            <p class="mb-1 text-dark"><?= $namaBulan[$bulan] ?> <?= $tahun ?>,<br><strong>Bendahara RT 04 RW 12</strong></p>
            <div style="height: 70px;"></div>
            <p class="mb-0 fw-bold text-dark text-decoration-underline">( ________________ )</p>
            <small class="text-muted font-11">Bendahara RT</small>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
