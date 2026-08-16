<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row g-4">
    <!-- Header & Filter Periode Laporan -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Laporan Rekapitulasi Kas RT</h4>
                        <p class="text-muted small mb-0">Rekapitulasi pemasukan iuran warga, alokasi pengeluaran, surplus kas, dan status tunggakan.</p>
                    </div>

                    <form class="d-flex flex-wrap align-items-center gap-2" method="get" action="<?= base_url('laporan') ?>">
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select form-select-sm" name="bulan" style="width: auto;">
                                <option value="8" selected>Agustus</option>
                                <option value="7">Juli</option>
                                <option value="6">Juni</option>
                                <option value="5">Mei</option>
                            </select>
                            <select class="form-select form-select-sm" name="tahun" style="width: auto;">
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success fw-semibold px-3">Filter</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 ms-auto ms-md-2" onclick="window.print()">
                            <i data-feather="printer" class="feather-icon" style="width: 14px; height: 14px;"></i>
                            <span>Cetak Laporan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Angka Keuangan (4 Stat Cards Simetris) -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Pemasukan Iuran (Agt 2026)</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 4.500.000</h4>
                    <small class="text-success font-12 fw-semibold">42 Transaksi Warga</small>
                </div>
                <div class="bg-light rounded p-2 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="trending-up" class="feather-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Pengeluaran (Agt 2026)</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 1.850.000</h4>
                    <small class="text-danger font-12 fw-semibold">4 Kegiatan Lingkungan</small>
                </div>
                <div class="bg-light rounded p-2 text-danger d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="trending-down" class="feather-icon text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Surplus Bersih Bulan Ini</span>
                    <h4 class="text-primary fw-bold mb-0 text-nowrap">+ Rp 2.650.000</h4>
                    <small class="text-muted font-12">Pemasukan - Pengeluaran</small>
                </div>
                <div class="bg-light rounded p-2 text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="dollar-sign" class="feather-icon text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-info border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Saldo Kas RT Terkini</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 12.650.000</h4>
                    <small class="text-info font-12 fw-semibold">Kas Kumulatif RT 04</small>
                </div>
                <div class="bg-light rounded p-2 text-info d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="shield" class="feather-icon text-info"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Pengeluaran Kas RT (Kiri) -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Rincian Pengeluaran Bulan Ini</h4>
                        <p class="text-muted small mb-0">Alokasi dana kas RT untuk kegiatan dan sarana warga.</p>
                    </div>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Kategori</th>
                                <th class="text-nowrap">Keterangan / Keperluan</th>
                                <th class="text-end text-nowrap">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted small text-nowrap">14 Agu 2026</td>
                                <td class="text-nowrap"><span class="badge bg-primary">Operasional</span></td>
                                <td class="text-dark fw-medium text-nowrap">Lampu penerangan gang RT</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 350.000</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-nowrap">10 Agu 2026</td>
                                <td class="text-nowrap"><span class="badge bg-info text-white">Sosial</span></td>
                                <td class="text-dark fw-medium text-nowrap">Santunan warga sakit (Bpk. Mulyono)</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 500.000</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-nowrap">08 Agu 2026</td>
                                <td class="text-nowrap"><span class="badge bg-primary">Operasional</span></td>
                                <td class="text-dark fw-medium text-nowrap">Kerja bakti &amp; perbaikan saluran gang</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 750.000</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-nowrap">05 Agu 2026</td>
                                <td class="text-nowrap"><span class="badge bg-warning text-dark">Konsumsi</span></td>
                                <td class="text-dark fw-medium text-nowrap">Konsumsi rapat pengurus RT</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 250.000</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end fw-bold text-dark">Total Pengeluaran Agustus 2026:</th>
                                <th class="text-end text-danger fw-bold fs-6">Rp 1.850.000</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Kepatuhan Pembayaran Warga (Kanan) -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Status Kepatuhan Warga</h4>
                        <p class="text-muted small mb-0">Monitoring kelancaran dan tunggakan iuran kas RT.</p>
                    </div>
                    <span class="badge bg-danger">3 Warga Macet</span>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nama Warga</th>
                                <th class="text-nowrap">Alamat Rumah</th>
                                <th class="text-center text-nowrap">Status</th>
                                <th class="text-nowrap">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Farros Rifantiarno</td>
                                <td class="text-nowrap text-dark fw-medium">Blok A / No. 01</td>
                                <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                <td class="text-muted small text-nowrap">Jatuh tempo 20 Agu</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Ahmad Fauzi</td>
                                <td class="text-nowrap text-dark fw-medium">Blok A / No. 02</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                <td class="text-muted small text-nowrap">Tepat waktu (15 Agu)</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Rina Marlina</td>
                                <td class="text-nowrap text-dark fw-medium">Blok B / No. 06</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                <td class="text-muted small text-nowrap">Pelunasan 2 bulan (10 Agu)</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Budi Santoso</td>
                                <td class="text-nowrap text-dark fw-medium">Blok C / No. 10</td>
                                <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Nunggak</span></td>
                                <td class="text-danger small text-nowrap">1 bulan berjalan</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Bambang Susanto</td>
                                <td class="text-nowrap text-dark fw-medium">Blok A / No. 04</td>
                                <td class="text-center text-nowrap"><span class="badge bg-danger">Macet</span></td>
                                <td class="text-danger small fw-semibold text-nowrap">3 bulan berturut</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Partisipasi iuran bulan ini: <strong>84% (42/50 Warga)</strong></small>
                    <a href="<?= base_url('iuran') ?>" class="btn btn-sm btn-outline-success fw-semibold">Kelola Iuran</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
