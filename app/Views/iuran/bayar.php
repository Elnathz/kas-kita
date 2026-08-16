<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Form Pembayaran Iuran Kas</h4>
                        <p class="text-muted small mb-0">Silakan transfer sesuai nominal dan unggah bukti transfer yang sah.</p>
                    </div>
                    <a href="<?= base_url('iuran/tagihan') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <!-- Info Rekening Kas RT -->
                <div class="alert alert-info border-0 rounded p-3 mb-4">
                    <h6 class="fw-bold mb-2 text-primary">Rekening Tujuan Kas RT:</h6>
                    <div class="row g-2 small">
                        <div class="col-sm-6">
                            <strong>Bank BCA:</strong> 123-456-7890<br>
                            a.n. Kas RT 03 RW 05
                        </div>
                        <div class="col-sm-6">
                            <strong>Bank Mandiri:</strong> 987-654-3210<br>
                            a.n. Kas RT 03 RW 05
                        </div>
                    </div>
                </div>

                <form action="<?= base_url('iuran/bayar/proses') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="periode_bulan">Periode Bulan</label>
                            <select class="form-select" id="periode_bulan" name="periode_bulan" required>
                                <option value="8" selected>Agustus</option>
                                <option value="7">Juli</option>
                                <option value="6">Juni</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="periode_tahun">Periode Tahun</label>
                            <input type="number" class="form-control" id="periode_tahun" name="periode_tahun" value="2026" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="nominal">Nominal Iuran (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" value="50000" readonly>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label text-dark fw-semibold small" for="bukti_transfer">Unggah Bukti Transfer (JPG, PNG - Max 2MB)</label>
                            <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept="image/jpeg,image/png" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('iuran/tagihan') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-success">Kirim Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
