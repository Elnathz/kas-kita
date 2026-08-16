<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- Hero Banner Tagihan Iuran Warga -->
<!-- ============================================================== -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <span class="badge bg-white text-success fw-bold px-3 py-1 mb-2">Akun Warga RT 04</span>
                        <h3 class="fw-bold text-white mb-1">Selamat Datang, Farros Rifantiarno</h3>
                        <p class="text-white-50 mb-0">Alamat: <strong>Blok A / No. 01, Jl. Mawar</strong> • No. Telepon: <strong>081234567890</strong></p>
                    </div>
                    <div class="d-flex flex-column align-items-md-end">
                        <span class="text-white-50 small mb-1">Tagihan Bulan Berjalan:</span>
                        <div class="d-flex align-items-center gap-3">
                            <span class="fs-4 fw-bold text-white">Rp 50.000 <small class="fs-6 fw-normal text-white-50">(Agustus 2026)</small></span>
                            <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-light text-success fw-bold px-4 shadow-sm">
                                <i data-feather="credit-card" class="feather-icon me-1"></i> Bayar Iuran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Kartu Ringkasan Personal Warga -->
<!-- ============================================================== -->
<div class="row g-3 mb-4">
    <!-- Status Pembayaran Bulan Ini -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-warning border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Status Iuran Agustus 2026</span>
                    <h5 class="text-warning fw-bold mb-0">Belum Dibayar</h5>
                    <small class="text-muted font-12">Jatuh tempo: 20 Agu 2026</small>
                </div>
                <div class="bg-light rounded p-2 text-warning d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="clock" class="feather-icon text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tunggakan Saya -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Tagihan Saya</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 50.000</h4>
                    <small class="text-muted font-12">1 Periode Belum Lunas</small>
                </div>
                <div class="bg-light rounded p-2 text-danger d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="alert-circle" class="feather-icon text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Iuran Terbayar Tahun Ini -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Iuran Terbayar (2026)</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 350.000</h4>
                    <small class="text-success font-12 fw-semibold">7 Bulan Lunas (Jan - Jul)</small>
                </div>
                <div class="bg-light rounded p-2 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="check-circle" class="feather-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Transparansi Saldo Kas RT Saat Ini -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Saldo Kas RT 04</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 12.650.000</h4>
                    <small class="text-muted font-12">Transparan &amp; Terbuka</small>
                </div>
                <div class="bg-light rounded p-2 text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="shield" class="feather-icon text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Konten Bawah: Riwayat Saya & Transparansi Pengeluaran RT -->
<!-- ============================================================== -->
<div class="row g-4">
    <!-- Tabel Riwayat Pembayaran Saya -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold">Riwayat Pembayaran Iuran Saya</h4>
                        <p class="text-muted small mb-0">Catatan pembayaran iuran yang telah Anda lakukan.</p>
                    </div>
                    <a href="<?= base_url('iuran/riwayat') ?>" class="btn btn-sm btn-outline-success fw-semibold">Lihat Semua</a>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Periode</th>
                                <th class="text-nowrap">Nominal</th>
                                <th class="text-nowrap">Tanggal Bayar</th>
                                <th class="text-nowrap text-center">Status</th>
                                <th class="text-nowrap text-center">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Juli 2026</td>
                                <td class="text-nowrap text-dark fw-bold">Rp 50.000</td>
                                <td class="text-nowrap text-muted">10 Jul 2026</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="alert('Demo: Tampilkan foto bukti transfer transfer_juli.jpg')">Lihat</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Juni 2026</td>
                                <td class="text-nowrap text-dark fw-bold">Rp 50.000</td>
                                <td class="text-nowrap text-muted">08 Jun 2026</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="alert('Demo: Tampilkan foto bukti transfer transfer_juni.jpg')">Lihat</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Mei 2026</td>
                                <td class="text-nowrap text-dark fw-bold">Rp 50.000</td>
                                <td class="text-nowrap text-muted">12 Mei 2026</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="alert('Demo: Tampilkan foto bukti transfer transfer_mei.jpg')">Lihat</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3 text-end">
                    <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-sm btn-success fw-semibold">
                        <i data-feather="plus-circle" class="feather-icon me-1"></i> Bayar Iuran Periode Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Widget Transparansi Pengeluaran Kas RT -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold">Transparansi Kas RT</h4>
                        <p class="text-muted small mb-0">Penggunaan dana kas RT terkini untuk lingkungan.</p>
                    </div>
                    <a href="<?= base_url('laporan') ?>" class="btn btn-sm btn-outline-primary fw-semibold">Laporan</a>
                </div>

                <div class="list-group list-group-flush flex-grow-1">
                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0 fw-semibold text-dark font-14">Lampu Penerangan Gang Mawar</h6>
                                <small class="text-muted">14 Agu 2026 • Operasional</small>
                            </div>
                            <span class="text-danger fw-bold text-nowrap font-14">Rp 350.000</span>
                        </div>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0 fw-semibold text-dark font-14">Santunan Warga Sakit (Bpk. Mulyono)</h6>
                                <small class="text-muted">10 Agu 2026 • Dana Sosial</small>
                            </div>
                            <span class="text-danger fw-bold text-nowrap font-14">Rp 500.000</span>
                        </div>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0 fw-semibold text-dark font-14">Konsumsi Rapat Bulanan Pengurus</h6>
                                <small class="text-muted">05 Agu 2026 • Konsumsi</small>
                            </div>
                            <span class="text-danger fw-bold text-nowrap font-14">Rp 250.000</span>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-top mt-3 text-center">
                    <small class="text-muted d-block">Dana kas RT dikelola secara terbuka &amp; dapat diaudit seluruh warga.</small>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
