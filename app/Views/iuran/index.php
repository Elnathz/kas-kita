<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Daftar Pembayaran Iuran Warga</h4>
                        <p class="text-muted small mb-0">Pantau kelancaran, verifikasi bukti transfer, dan tindak lanjuti tunggakan iuran warga RT.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option selected>Semua Periode</option>
                            <option>Agustus 2026</option>
                            <option>Juli 2026</option>
                            <option>Juni 2026</option>
                        </select>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option selected>Semua Status</option>
                            <option>Menunggu Verifikasi</option>
                            <option>Lunas</option>
                            <option>Belum Bayar</option>
                            <option>Macet (2 Bulan Ke Atas)</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nama Warga</th>
                                <th class="text-nowrap">Alamat Rumah</th>
                                <th class="text-nowrap">Periode Iuran</th>
                                <th class="text-nowrap">Nominal Tagihan</th>
                                <th class="text-nowrap text-center">Status</th>
                                <th class="text-nowrap">Tanggal Bayar / Keterangan</th>
                                <th class="text-nowrap text-center" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 1. Menunggu Verifikasi (Paling Baru: 16 Agu 2026) -->
                            <tr>
                                <td class="fw-semibold text-nowrap text-dark">Hendra Wijaya</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok B / No. 12</span>
                                    <span class="text-muted small d-block">Jl. Melati</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-dark">Juni - Agustus 2026</span>
                                    <span class="text-muted small d-block">3 Bulan Sekaligus</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 150.000</span>
                                    <span class="text-muted small d-block">Pelunasan Sekaligus</span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                </td>
                                <td class="text-nowrap text-dark">
                                    <span class="fw-medium">16 Agu 2026</span>
                                    <small class="text-muted d-block font-12">Pukul 09:15 WIB</small>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('iuran/verifikasi/3') ?>" class="btn btn-sm btn-success fw-semibold px-3">Verifikasi</a>
                                </td>
                            </tr>

                            <!-- 2. Menunggu Verifikasi (15 Agu 2026) -->
                            <tr>
                                <td class="fw-semibold text-nowrap text-dark">Ahmad Fauzi</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok A / No. 01</span>
                                    <span class="text-muted small d-block">Jl. Mawar</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-dark">Agustus 2026</span>
                                    <span class="text-muted small d-block">1 Bulan</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 50.000</span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                </td>
                                <td class="text-nowrap text-dark">
                                    <span class="fw-medium">15 Agu 2026</span>
                                    <small class="text-muted d-block font-12">Pukul 14:30 WIB</small>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('iuran/verifikasi/1') ?>" class="btn btn-sm btn-success fw-semibold px-3">Verifikasi</a>
                                </td>
                            </tr>

                            <!-- 3. Lunas (10 Agu 2026) -->
                            <tr>
                                <td class="fw-semibold text-nowrap text-dark">Rina Marlina</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok B / No. 06</span>
                                    <span class="text-muted small d-block">Jl. Melati</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-dark">Juli &amp; Agustus 2026</span>
                                    <span class="text-muted small d-block">2 Bulan</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 100.000</span>
                                    <span class="text-muted small d-block">@ Rp 50.000 / bln</span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge bg-success">Lunas</span>
                                </td>
                                <td class="text-nowrap text-dark">
                                    <span class="fw-medium">10 Agu 2026</span>
                                    <small class="text-success d-block font-12">Diverifikasi 10 Agu</small>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('iuran/verifikasi/2') ?>" class="btn btn-sm btn-outline-secondary">Bukti Transfer</a>
                                </td>
                            </tr>

                            <!-- 4. Belum Bayar (Bulan Berjalan / Belum Jatuh Tempo) -->
                            <tr>
                                <td class="fw-semibold text-nowrap text-dark">Farros Rifantiarno</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok A / No. 01</span>
                                    <span class="text-muted small d-block">Jl. Mawar</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-dark">Agustus 2026</span>
                                    <span class="text-muted small d-block">Bulan Berjalan</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 50.000</span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge bg-warning text-dark">Belum Bayar</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-muted small">Jatuh tempo: <strong>20 Agu 2026</strong></span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="https://wa.me/6281234567890?text=Halo%20Farros,%20mengingatkan%20iuran%20kas%20RT%2004%20bulan%20Agustus%202026%20sebesar%20Rp%2050.000%20(jatuh%20tempo%2020%20Agustus)." target="_blank" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1">
                                        <i data-feather="message-circle" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                        <span>Tagih WA</span>
                                    </a>
                                </td>
                            </tr>

                            <!-- 5. Belum Bayar (Bulan Berjalan) -->
                            <tr>
                                <td class="fw-semibold text-nowrap text-dark">Budi Santoso</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok A / No. 02</span>
                                    <span class="text-muted small d-block">Jl. Mawar</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-dark">Agustus 2026</span>
                                    <span class="text-muted small d-block">Bulan Berjalan</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">Rp 50.000</span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge bg-warning text-dark">Belum Bayar</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-muted small">Jatuh tempo: <strong>20 Agu 2026</strong></span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="https://wa.me/6281234567891?text=Halo%20Bapak%20Budi,%20mengingatkan%20iuran%20kas%20RT%2004%20bulan%20Agustus%202026%20sebesar%20Rp%2050.000%20(jatuh%20tempo%2020%20Agustus)." target="_blank" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1">
                                        <i data-feather="message-circle" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                        <span>Tagih WA</span>
                                    </a>
                                </td>
                            </tr>

                            <!-- 6. Macet (Tunggakan 3 Bulan sejak Juni) -->
                            <tr>
                                <td class="fw-semibold text-nowrap text-dark">Bambang Susanto</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok A / No. 04</span>
                                    <span class="text-muted small d-block">Jl. Mawar</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-dark">Juni - Agustus 2026</span>
                                    <span class="text-danger small d-block">Menunggak 3 Bulan</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-danger">Rp 150.000</span>
                                    <span class="text-danger small d-block">Akumulasi 3 Bulan</span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge bg-danger">Macet (3 Bln)</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-danger small fw-semibold">Menunggak sejak Juni 2026</span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="https://wa.me/6281234567892?text=Halo%20Bapak%20Bambang,%20mengingatkan%20total%20tunggakan%20iuran%20kas%20RT%2004%20(3%20Bulan)%20sebesar%20Rp%20150.000." target="_blank" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1">
                                        <i data-feather="message-circle" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                        <span>Tagih WA</span>
                                    </a>
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
