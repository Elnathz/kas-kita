<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Edit Kategori Pengeluaran</h4>
                        <p class="text-muted small mb-0">Perbarui pos kategori pengeluaran kas RT.</p>
                    </div>
                    <a href="<?= base_url('kategori') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger py-2 px-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('kategori/update/' . $kategori['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small" for="nama">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                               value="<?= esc(old('nama', $kategori['nama_kategori'])) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small" for="deskripsi">Deskripsi / Rincian Pos</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= esc(old('deskripsi', $kategori['deskripsi'] ?? '')) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('kategori') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-success">Perbarui Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
