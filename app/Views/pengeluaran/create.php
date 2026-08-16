<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Catat Pengeluaran Kas RT</h4>
                        <p class="text-muted small mb-0">Dokumentasikan penggunaan dana kas RT beserta kategorinya.</p>
                    </div>
                    <a href="<?= base_url('pengeluaran') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('pengeluaran/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="kategori_id">Kategori Pengeluaran</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="1">Kas Operasional</option>
                                <option value="2">Sosial</option>
                                <option value="3">Konsumsi</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="tanggal">Tanggal Pengeluaran</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="nominal">Nominal Pengeluaran (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Contoh: 250000" required>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label text-dark fw-semibold small" for="keterangan">Keterangan / Keperluan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Jelaskan rincian keperluan pengeluaran..." required></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('pengeluaran') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Pengeluaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
