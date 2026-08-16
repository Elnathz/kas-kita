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
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 12.650.000</h4>
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
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 4.500.000</h4>
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
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 1.850.000</h4>
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
                    <span class="text-muted small d-block mb-1">Warga Sudah Bayar</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">42 <span class="fs-6 text-muted fw-normal">/ 50 Warga</span></h4>
                </div>
                <div class="bg-light rounded p-2 text-info d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="users" class="feather-icon text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <p class="text-muted small mb-0">Warga yang menunggak $\ge 2$ bulan berturut-turut.</p>
                    </div>
                    <span class="badge bg-danger">Macet (>= 2 Bln)</span>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nama Warga</th>
                                <th class="text-nowrap">Rumah</th>
                                <th class="text-nowrap">Tunggakan</th>
                                <th class="text-nowrap text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-nowrap">Bambang Susanto</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok A / No. 04</span></td>
                                <td class="text-danger fw-semibold text-nowrap">3 Bulan (Rp 150.000)</td>
                                <td class="text-center"><span class="badge bg-danger">Macet</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-nowrap">Hendra Wijaya</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok B / No. 12</span></td>
                                <td class="text-danger fw-semibold text-nowrap">2 Bulan (Rp 100.000)</td>
                                <td class="text-center"><span class="badge bg-danger">Macet</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-nowrap">Siti Aminah</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok C / No. 08</span></td>
                                <td class="text-danger fw-semibold text-nowrap">2 Bulan (Rp 100.000)</td>
                                <td class="text-center"><span class="badge bg-danger">Macet</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-nowrap">Dedi Kusnadi</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok A / No. 15</span></td>
                                <td class="text-danger fw-semibold text-nowrap">2 Bulan (Rp 100.000)</td>
                                <td class="text-center"><span class="badge bg-danger">Macet</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-nowrap">Gunawan Wibowo</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok D / No. 02</span></td>
                                <td class="text-danger fw-semibold text-nowrap">2 Bulan (Rp 100.000)</td>
                                <td class="text-center"><span class="badge bg-danger">Macet</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan 5 dari 5 warga macet</small>
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
                    <span class="badge bg-warning text-dark">5 Menunggu</span>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nama Warga</th>
                                <th class="text-nowrap">Rumah</th>
                                <th class="text-nowrap">Periode & Nominal</th>
                                <th class="text-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contoh 1: Pembayaran 1 Bulan Normal -->
                            <tr>
                                <td class="fw-semibold text-nowrap">Ahmad Fauzi</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok A / No. 01</span></td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 50.000</span>
                                    <small class="text-muted d-block font-12">Agustus 2026</small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('iuran/verifikasi/1') ?>" class="btn btn-sm btn-success px-3 fw-semibold">Periksa</a>
                                </td>
                            </tr>

                            <!-- Contoh 2: Pembayaran 2 Bulan Sekaligus (Pelunasan Tunggakan) -->
                            <tr>
                                <td class="fw-semibold text-nowrap">Rina Marlina</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok B / No. 06</span></td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 100.000</span>
                                    <span class="badge bg-info text-dark font-12 ms-1">2 Bulan (Jul & Agt)</span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('iuran/verifikasi/2') ?>" class="btn btn-sm btn-success px-3 fw-semibold">Periksa</a>
                                </td>
                            </tr>

                            <!-- Contoh 3: Pembayaran 3 Bulan Sekaligus -->
                            <tr>
                                <td class="fw-semibold text-nowrap">Budi Santoso</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok C / No. 10</span></td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 150.000</span>
                                    <span class="badge bg-info text-dark font-12 ms-1">3 Bulan (Jun - Agt)</span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('iuran/verifikasi/3') ?>" class="btn btn-sm btn-success px-3 fw-semibold">Periksa</a>
                                </td>
                            </tr>

                            <!-- Contoh 4: Pembayaran 1 Bulan Normal -->
                            <tr>
                                <td class="fw-semibold text-nowrap">Eko Prasetyo</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok D / No. 05</span></td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 50.000</span>
                                    <small class="text-muted d-block font-12">Agustus 2026</small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('iuran/verifikasi/4') ?>" class="btn btn-sm btn-success px-3 fw-semibold">Periksa</a>
                                </td>
                            </tr>

                            <!-- Contoh 5: Pembayaran 1 Bulan Normal -->
                            <tr>
                                <td class="fw-semibold text-nowrap">Dewi Lestari</td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">Blok B / No. 14</span></td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 50.000</span>
                                    <small class="text-muted d-block font-12">Agustus 2026</small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('iuran/verifikasi/5') ?>" class="btn btn-sm btn-success px-3 fw-semibold">Periksa</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan 5 dari 8 pembayaran baru</small>
                    <a href="<?= base_url('iuran') ?>" class="btn btn-sm btn-outline-success fw-semibold">Lihat Semua Iuran</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
