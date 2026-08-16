<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Riwayat Pembayaran Iuran Saya</h4>
                        <p class="text-muted small mb-0">Catatan riwayat seluruh setoran iuran kas bulanan Anda.</p>
                    </div>
                    <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-success btn-sm">Bayar Iuran</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nominal</th>
                                <th>Tanggal Bayar</th>
                                <th>Status Verifikasi</th>
                                <th>Catatan Pengurus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="fw-semibold">Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td>15 Agu 2026</td>
                                <td><span class="badge bg-warning text-dark">Menunggu Verifikasi</span></td>
                                <td class="text-muted small">-</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="fw-semibold">Juli 2026</td>
                                <td>Rp 50.000</td>
                                <td>10 Jul 2026</td>
                                <td><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-muted small">Pembayaran valid, terima kasih.</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="fw-semibold">Juni 2026</td>
                                <td>Rp 50.000</td>
                                <td>05 Jun 2026</td>
                                <td><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-muted small">Lunas.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
