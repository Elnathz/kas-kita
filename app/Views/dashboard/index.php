<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- Kartu Ringkasan Statistik Kas RT -->
<!-- ============================================================== -->
<div class="row g-3 mb-4">
    <!-- Saldo Kas RT -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Saldo Kas RT</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($saldoKas, 0, ',', '.') ?></h4>
                </div>
                <div class="bg-light rounded p-2 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="dollar-sign" class="feather-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemasukan Bulan Ini -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Pemasukan Bulan Ini</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($iuranBulanIni, 0, ',', '.') ?></h4>
                </div>
                <div class="bg-light rounded p-2 text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="trending-up" class="feather-icon text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengeluaran Bulan Ini -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Pengeluaran Bulan Ini</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($pengeluaranBulanIni, 0, ',', '.') ?></h4>
                </div>
                <div class="bg-light rounded p-2 text-danger d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="trending-down" class="feather-icon text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Partisipasi Iuran Warga -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-info border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Sudah Bayar Bulan Ini</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap"><?= $wargaSudahBayar ?> <span class="fs-6 text-muted fw-normal">/ <?= $totalWarga ?> Warga</span></h4>
                    <small class="text-success font-12 fw-semibold"><?= date('F Y') ?> (<?= $totalWarga > 0 ? round(($wargaSudahBayar / $totalWarga) * 100) : 0 ?>%)</small>
                </div>
                <div class="bg-light rounded p-2 text-info d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="users" class="feather-icon text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Notifikasi Menunggu Persetujuan (Pendaftar Baru & Pengajuan) -->
<!-- ============================================================== -->
<?php if (!empty($pendaftarBaru)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden border-start border-warning border-4">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i data-feather="bell" class="text-warning me-2" style="width: 18px; height: 18px;"></i>
                    <h5 class="card-title mb-0 fw-bold">Menunggu Persetujuan & Validasi</h5>
                </div>
                <span class="badge bg-warning text-dark"><?= count($pendaftarBaru) ?> Menunggu</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap ps-4">Tipe Pengajuan</th>
                                <th class="text-nowrap">Pemohon (Nama Kepala Keluarga)</th>
                                <th class="text-nowrap">Detail Pengajuan</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pendaftarBaru as $pendaftar): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 font-12 fw-semibold">
                                        <i data-feather="user-plus" class="me-1" style="width: 12px; height: 12px;"></i> Pendaftar Baru
                                    </span>
                                </td>
                                <td class="fw-semibold text-nowrap text-dark"><?= esc($pendaftar['nama']) ?></td>
                                <td>Pendaftaran akun baru di <span class="fw-bold text-dark"><?= esc($pendaftar['alamat']) ?></span></td>
                                <td class="text-muted font-13 text-nowrap"><?= date('d M Y', strtotime($pendaftar['created_at'])) ?></td>
                                <td class="text-center pe-4 text-nowrap">
                                    <!-- Aksi akan diimplementasi di route warga -->
                                    <button class="btn btn-sm btn-success fw-semibold me-1">Setujui</button>
                                    <button class="btn btn-sm btn-outline-danger fw-semibold">Tolak</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ============================================================== -->
<!-- Tabel Monitoring Macet & Verifikasi Pembayaran (Maks 5 Data) -->
<!-- ============================================================== -->
<div class="row g-4">
    <!-- Card Warga Macet -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold">Monitoring Pembayaran Macet</h4>
                        <p class="text-muted small mb-0">Daftar warga yang belum bayar bulan ini.</p>
                    </div>
                    <span class="badge bg-danger"><?= count($wargaMacet) ?> Warga</span>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nama Warga</th>
                                <th class="text-nowrap">Rumah</th>
                                <th class="text-nowrap text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($wargaMacet)): ?>
                                <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada warga macet. Semua lancar!</td></tr>
                            <?php else: ?>
                                <?php foreach($wargaMacet as $macet): ?>
                                <tr>
                                    <td class="fw-semibold text-nowrap text-dark"><?= esc($macet['nama']) ?></td>
                                    <td class="text-nowrap text-dark fw-medium"><?= esc($macet['no_rumah']) ?></td>
                                    <td class="text-center"><span class="badge bg-danger">Belum Bayar</span></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan maks 5 warga macet</small>
                    <a href="<?= base_url('warga') ?>" class="btn btn-sm btn-outline-danger fw-semibold">Lihat Semua Warga</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pembayaran Terbaru Menunggu Verifikasi -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold">Verifikasi Pembayaran Masuk</h4>
                        <p class="text-muted small mb-0">Bukti transfer warga menunggu konfirmasi pengurus.</p>
                    </div>
                    <span class="badge bg-warning text-dark"><?= $menungguVerifikasi ?> Menunggu</span>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nama Warga</th>
                                <th class="text-nowrap">Rumah</th>
                                <th class="text-nowrap">Periode &amp; Nominal</th>
                                <th class="text-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($iuranMenunggu)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada iuran yang menunggu verifikasi.</td></tr>
                            <?php else: ?>
                                <?php foreach($iuranMenunggu as $iuran): ?>
                                <tr>
                                    <td class="fw-semibold text-nowrap text-dark"><?= esc($iuran['nama_warga']) ?></td>
                                    <td class="text-nowrap text-dark fw-medium"><?= esc($iuran['no_rumah']) ?></td>
                                    <td class="text-nowrap">
                                        <span class="fw-bold text-dark">Rp <?= number_format($iuran['nominal'], 0, ',', '.') ?></span>
                                        <small class="text-muted d-block font-12">Bulan <?= $iuran['periode_bulan'] ?> Tahun <?= $iuran['periode_tahun'] ?></small>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('iuran/verifikasi/' . $iuran['id']) ?>" class="btn btn-sm btn-success px-3 fw-semibold">Periksa</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan antrean verifikasi</small>
                    <a href="<?= base_url('iuran') ?>" class="btn btn-sm btn-outline-success fw-semibold">Lihat Semua Iuran</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
