<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="card-title fw-bold mb-0">Informasi Tagihan Iuran</h4>
                    <span class="badge bg-danger fs-6">Belum Lunas</span>
                </div>
                <p class="text-muted small">Berikut adalah rincian tagihan iuran kas RT Anda untuk periode bulan berjalan beserta tunggakan (jika ada).</p>

                <div class="p-3 bg-light rounded mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Nama Warga:</span>
                        <span class="fw-semibold text-dark">Ahmad Fauzi</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Nomor Rumah:</span>
                        <span class="fw-semibold text-dark">Blok A / 01</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Iuran Kas per Bulan:</span>
                        <span class="fw-semibold text-dark">Rp 50.000</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Total Yang Harus Dibayar:</span>
                        <span class="fw-bold text-danger fs-4">Rp 50.000</span>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-success d-flex align-items-center gap-2">
                        <i data-feather="upload" class="feather-icon"></i>
                        <span>Bayar & Upload Bukti Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
