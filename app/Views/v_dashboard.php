<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- Kartu Ringkasan Statistik Kas RT -->
<!-- ============================================================== -->
<div class="row">
    <!-- Saldo Kas RT -->
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">Rp 12.650.000</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Saldo Kas RT</h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="dollar-sign" class="feather-icon text-success"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemasukan Bulan Ini -->
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">Rp 4.500.000</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pemasukan Bulan Ini</h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="trending-up" class="feather-icon text-primary"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengeluaran Bulan Ini -->
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">Rp 1.850.000</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pengeluaran Bulan Ini</h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="trending-down" class="feather-icon text-danger"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Partisipasi Iuran Warga -->
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">42 / 50</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Warga Sudah Bayar</h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="users" class="feather-icon text-info"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Warga Pembayaran Macet Alert & Tabel Cepat -->
<!-- ============================================================== -->
<div class="row">
    <!-- Card Warga Macet -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <h4 class="card-title mb-0 fw-bold">Monitoring Pembayaran Macet</h4>
                    <span class="badge bg-danger ms-auto">Belum bayar >= 2 bulan</span>
                </div>
                <p class="text-muted small mb-3">Daftar warga yang menunggak iuran lebih dari 2 bulan berturut-turut untuk ditindaklanjuti.</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Warga</th>
                                <th>No. Rumah</th>
                                <th>Tunggakan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Bambang Susanto</td>
                                <td>Blok A / 04</td>
                                <td>3 Bulan (Rp 150.000)</td>
                                <td><span class="badge bg-danger">Macet</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Hendra Wijaya</td>
                                <td>Blok B / 12</td>
                                <td>2 Bulan (Rp 100.000)</td>
                                <td><span class="badge bg-danger">Macet</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Siti Aminah</td>
                                <td>Blok C / 08</td>
                                <td>2 Bulan (Rp 100.000)</td>
                                <td><span class="badge bg-danger">Macet</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pembayaran Terbaru Menunggu Verifikasi -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <h4 class="card-title mb-0 fw-bold">Verifikasi Pembayaran Masuk</h4>
                    <a href="<?= base_url('iuran') ?>" class="btn btn-sm btn-outline-primary ms-auto">Lihat Semua</a>
                </div>
                <p class="text-muted small mb-3">Bukti transfer iuran warga yang baru masuk dan menunggu konfirmasi pengurus.</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Warga</th>
                                <th>Periode</th>
                                <th>Nominal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Ahmad Fauzi</td>
                                <td>Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td>
                                    <a href="<?= base_url('iuran/verifikasi/1') ?>" class="btn btn-sm btn-primary">Periksa</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Rina Marlina</td>
                                <td>Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td>
                                    <a href="<?= base_url('iuran/verifikasi/2') ?>" class="btn btn-sm btn-primary">Periksa</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Budi Santoso</td>
                                <td>Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td>
                                    <a href="<?= base_url('iuran/verifikasi/3') ?>" class="btn btn-sm btn-primary">Periksa</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>