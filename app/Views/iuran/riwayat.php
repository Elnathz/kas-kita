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
                            <?php if (empty($pembayaran)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat pembayaran iuran.</td>
                            </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($pembayaran as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-semibold"><?= date('F Y', mktime(0, 0, 0, $p['periode_bulan'], 1, $p['periode_tahun'])) ?></td>
                                    <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                    <td><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                                    <td>
                                        <?php if ($p['status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                        <?php elseif ($p['status'] == 'lunas'): ?>
                                            <span class="badge bg-success">Terverifikasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?= esc($p['catatan'] ?? '-') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
