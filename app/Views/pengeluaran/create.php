<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Catat Pengeluaran Kas RT</h4>
                        <p class="text-muted small mb-0">Dokumentasikan penggunaan dana kas RT beserta bukti nota dan foto kegiatan.</p>
                    </div>
                    <a href="<?= base_url('pengeluaran') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger py-2 px-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('pengeluaran/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="kategori_id">Kategori Pos Pengeluaran</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="" disabled <?= old('kategori_id') ? '' : 'selected' ?>>Pilih Kategori Pos Kas...</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= esc($k['id']) ?>" <?= old('kategori_id') == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?> (<?= esc($k['deskripsi']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="tanggal">Tanggal Pengeluaran</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= esc(old('tanggal', date('Y-m-d'))) ?>" max="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nominal">Nominal Pengeluaran (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" value="<?= esc(old('nominal')) ?>" min="1" step="1" placeholder="Contoh: 350000" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="keterangan">Keterangan / Rincian Kegiatan Lengkap</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Pembelian 5 unit lampu LED Philips dan kabel untuk gang RT 03..." required><?= esc(old('keterangan')) ?></textarea>
                        </div>

                        <!-- 1. Upload Bukti Nota / Kuitansi -->
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="bukti_nota">Upload Bukti Nota / Kuitansi</label>
                            <input type="file" class="form-control" id="bukti_nota" name="bukti_nota" accept="image/png, image/jpeg, image/jpg, application/pdf">
                            <span class="text-muted font-12 d-block mt-1">Struk belanja atau nota toko fisik (Maks. 2MB).</span>
                        </div>

                        <!-- 2. Upload Foto Dokumentasi Kegiatan / Hasil Kerja -->
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="foto_kegiatan">Upload Foto Dokumentasi Hasil / Kegiatan</label>
                            <input type="file" class="form-control" id="foto_kegiatan" name="foto_kegiatan" accept="image/png, image/jpeg, image/jpg">
                            <span class="text-muted font-12 d-block mt-1">Foto lampu terpasang, kerja bakti, dll.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('pengeluaran') ?>" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">Simpan Pengeluaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
