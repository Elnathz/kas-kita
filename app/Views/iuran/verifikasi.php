<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Alert Status Warga jika Menunggak / Macet -->
        <?php if ($error = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 rounded p-3 mb-4"><?= esc($error) ?></div>
        <?php endif; ?>
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
                                <span class="fw-semibold text-dark"><?= esc($pembayaran['nama'] ?? 'N/A') ?></span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted small d-block">No. Rumah</span>
                                <span class="fw-semibold text-dark"><?= esc($pembayaran['blok_rumah'] ?? '') ?> / <?= esc($pembayaran['no_rumah'] ?? '') ?></span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted small d-block">Periode Iuran</span>
                                <span class="fw-semibold text-dark"><?= date('F Y', mktime(0, 0, 0, $pembayaran['periode_bulan'] ?? 1, 1, $pembayaran['periode_tahun'] ?? 2026)) ?></span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted small d-block">Nominal Ditransfer</span>
                                <span class="fw-bold text-success fs-5">Rp <?= number_format($pembayaran['nominal'] ?? 0, 0, ',', '.') ?></span>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Tanggal Upload</span>
                                <span class="text-dark"><?= date('d F Y, H:i', strtotime($pembayaran['created_at'] ?? 'now')) ?> WIB</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted small text-uppercase mb-3">Bukti Transfer</h6>
                        <div class="border rounded p-2 text-center bg-light">
                            <?php
                            $buktiPath = trim((string) ($pembayaran['bukti_transfer'] ?? ''));
                            if ($buktiPath === '') {
                                $bukti = base_url('assets/images/buktitf1.jpeg');
                            } elseif (str_starts_with($buktiPath, 'assets/') || str_starts_with($buktiPath, 'uploads/')) {
                                $bukti = base_url($buktiPath);
                            } else {
                                $bukti = base_url('uploads/bukti/' . $buktiPath);
                            }
                            ?>
                            <img src="<?= esc($bukti) ?>" alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 250px; object-fit: cover;">
                            <div class="mt-2">
                                <a href="<?= esc($bukti) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i data-feather="external-link" class="feather-icon"></i> Lihat Ukuran Penuh
                                </a>
                            </div>
                        </div>
                        <?php if (!empty($pembayaran['bukti_penolakan'])): ?>
                            <div class="alert alert-light border mt-3 mb-0 small">
                                <strong>Bukti penolakan tersimpan:</strong>
                                <a href="<?= base_url($pembayaran['bukti_penolakan']) ?>" target="_blank" rel="noopener">Lihat bukti pengurus</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <form id="formVerifikasiIuran" action="<?= base_url('iuran/verifikasi/proses/' . ($id ?? 1)) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small" for="catatan">Catatan Verifikasi (Opsional jika disetujui, Wajib jika ditolak)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Contoh: Nominal tidak sesuai rekening koran RT."><?= esc(old('catatan')) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small" for="bukti_penolakan">Bukti Pendukung Penolakan</label>
                        <input class="form-control" type="file" id="bukti_penolakan" name="bukti_penolakan" accept=".jpg,.jpeg,.png,.webp,.pdf">
                        <div class="form-text">Wajib jika menolak. Maksimal 2 MB, format JPG, PNG, WEBP, atau PDF.</div>
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
<script>
document.getElementById('formVerifikasiIuran')?.addEventListener('submit', function (event) {
    const action = event.submitter?.value;
    if (action !== 'tolak') return;

    const catatan = document.getElementById('catatan');
    const bukti = document.getElementById('bukti_penolakan');
    if (!catatan?.value.trim() || !bukti?.files.length) {
        event.preventDefault();
        if (typeof showAppToast === 'function') {
            showAppToast('Penolakan wajib disertai catatan dan bukti pendukung.', 'warning', 'Data Penolakan Belum Lengkap');
        }
    }
});
</script>
<?= $this->endSection() ?>
