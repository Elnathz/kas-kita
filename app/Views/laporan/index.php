<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <!-- Filter Laporan -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <form class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label fw-semibold small text-dark">Periode Laporan:</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select form-select-sm">
                            <option selected>Agustus</option>
                            <option>Juli</option>
                            <option>Juni</option>
                            <option>Mei</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select form-select-sm">
                            <option selected>2026</option>
                            <option>2025</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-primary">Tampilkan</button>
                    </div>
                    <div class="col-auto ms-auto">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                            <i data-feather="printer" class="feather-icon"></i> Cetak Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ringkasan Angka Laporan -->
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm border-start border-success border-4">
            <div class="card-body">
                <span class="text-muted small">Total Pemasukan Iuran</span>
                <h3 class="fw-bold text-success mb-0">Rp 4.500.000</h3>
                <span class="text-muted small">Dari 42 transaksi warga</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4">
            <div class="card-body">
                <span class="text-muted small">Total Pengeluaran</span>
                <h3 class="fw-bold text-danger mb-0">Rp 1.850.000</h3>
                <span class="text-muted small">Dari 3 transaksi pengeluaran</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4">
            <div class="card-body">
                <span class="text-muted small">Surplus / Saldo Bersih Bulan Ini</span>
                <h3 class="fw-bold text-primary mb-0">+ Rp 2.650.000</h3>
                <span class="text-muted small">Pemasukan dikurangi pengeluaran</span>
            </div>
        </div>
    </div>

    <!-- Rincian Pengeluaran per Kategori -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Rincian Pengeluaran per Kategori</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th>Keperluan</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-primary">Kas Operasional</span></td>
                                <td>Lampu penerangan gang RT</td>
                                <td class="text-end fw-semibold">Rp 350.000</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-info text-white">Sosial</span></td>
                                <td>Santunan warga sakit</td>
                                <td class="text-end fw-semibold">Rp 500.000</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning text-dark">Konsumsi</span></td>
                                <td>Snack rapat pengurus</td>
                                <td class="text-end fw-semibold">Rp 250.000</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2" class="text-end">Total Pengeluaran:</th>
                                <th class="text-end text-danger fw-bold">Rp 1.100.000</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pembayaran Warga & Macet -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Status Pembayaran Warga</h5>
                    <span class="badge bg-danger">3 Warga Macet</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Warga</th>
                                <th>No. Rumah</th>
                                <th>Status Periode Ini</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Ahmad Fauzi</td>
                                <td>Blok A / 01</td>
                                <td><span class="badge bg-success">Lunas</span></td>
                                <td class="text-muted small">Tepat waktu</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Rina Marlina</td>
                                <td>Blok B / 01</td>
                                <td><span class="badge bg-success">Lunas</span></td>
                                <td class="text-muted small">Tepat waktu</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Budi Santoso</td>
                                <td>Blok A / 02</td>
                                <td><span class="badge bg-warning text-dark">Nunggak</span></td>
                                <td class="text-muted small">1 bulan berjalan</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Bambang Susanto</td>
                                <td>Blok A / 04</td>
                                <td><span class="badge bg-danger">Macet</span></td>
                                <td class="text-danger small fw-semibold">3 bulan berturut</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
