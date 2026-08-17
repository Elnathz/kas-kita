<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-9 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="card-title fw-bold mb-0">Rincian Tagihan Iuran Saya</h4>
                    <span class="badge bg-danger fs-6">2 Bulan Belum Lunas</span>
                </div>
                <p class="text-muted small">Berikut adalah status dan rincian seluruh tagihan iuran kas RT Anda.</p>

                <div class="table-responsive mb-4">
                    <table class="table table-hover align-middle border">
                        <thead class="table-light">
                            <tr>
                                <th>Periode Bulan</th>
                                <th>Tarif Iuran</th>
                                <th>Status Tagihan</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tagihan_list)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-success fw-bold">
                                    <i data-feather="check-circle" class="feather-icon me-2"></i>Semua tagihan Anda sudah lunas!
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($tagihan_list as $t): ?>
                                <tr>
                                    <td class="fw-semibold"><?= date('F Y', mktime(0, 0, 0, $t['bulan'], 1, $t['tahun'])) ?></td>
                                    <td>Rp <?= number_format($t['tarif'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($t['status'] == 'Tunggakan'): ?>
                                            <span class="badge bg-danger">Tunggakan</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Bulan Berjalan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end fw-bold text-dark">Rp <?= number_format($t['tarif'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total Seluruh Tagihan:</th>
                                <th class="text-end text-danger fw-bold fs-5">Rp <?= number_format($total_tagihan, 0, ',', '.') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 p-3 bg-light rounded">
                    <div>
                        <span class="text-muted small d-block">Ingin mencicil atau melunasi seluruhnya?</span>
                        <strong class="text-dark">Pilih opsi pembayaran sesuai kemampuan Anda</strong>
                    </div>
                    <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-success d-flex align-items-center gap-2">
                        <i data-feather="credit-card" class="feather-icon"></i>
                        <span>Bayar Tagihan Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
