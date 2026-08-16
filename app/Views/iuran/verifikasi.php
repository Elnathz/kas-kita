<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Alert Status Warga jika Menunggak / Macet -->
        <div class="alert alert-warning border-0 rounded p-3 mb-4 d-flex align-items-center">
            <i data-feather="alert-triangle" class="feather-icon text-warning me-2"></i>
            <div>
                <strong>Informasi Status Warga:</strong> Warga ini sebelumnya memiliki catatan <strong>1 bulan tunggakan</strong>. Pastikan nominal pembayaran telah mencakup bulan berjalan.
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Verifikasi Pembayaran Iuran</h4>
                        <p class="text-muted small mb-0">Periksa kesesuaian bukti transfer dengan nominal tagihan.</p>
                    </div>
                    <a href="<?= base_url('iuran') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted small text-uppercase mb-3">Detail Transaksi</h6>
                        <div class="p-3 bg-light rounded">
                            <div class="mb-2">
                                <span class="text-muted small d-block">Nama Warga</span>
                                <span class="fw-semibold text-dark">Ahmad Fauzi</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted small d-block">No. Rumah</span>
                                <span class="fw-semibold text-dark">Blok A / 01</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted small d-block">Periode Iuran</span>
                                <span class="fw-semibold text-dark">Agustus 2026</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted small d-block">Nominal Ditransfer</span>
                                <span class="fw-bold text-success fs-5">Rp 50.000</span>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Tanggal Upload</span>
                                <span class="text-dark">15 Agustus 2026, 14:30 WIB</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted small text-uppercase mb-3">Bukti Transfer</h6>
                        <div class="border rounded p-2 text-center bg-light">
                            <img src="<?= base_url('FreeDash/src/assets/images/big/img1.jpg') ?>" alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 250px; object-fit: cover;">
                            <div class="mt-2">
                                <a href="<?= base_url('FreeDash/src/assets/images/big/img1.jpg') ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i data-feather="external-link" class="feather-icon"></i> Lihat Ukuran Penuh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="<?= base_url('iuran/verifikasi/proses/' . ($id ?? 1)) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small" for="catatan">Catatan Verifikasi (Opsional jika disetujui, Wajib jika ditolak)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Contoh: Bukti transfer terverifikasi masuk ke rekening RT."></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" name="action" value="tolak" class="btn btn-outline-danger">Tolak Pembayaran</button>
                        <button type="submit" name="action" value="terima" class="btn btn-success">Terima & Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
