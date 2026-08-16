<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="card-title fw-bold mb-1">Pengaturan Nominal Iuran Kas RT</h4>
                    <p class="text-muted small mb-0">Ubah besaran tarif iuran bulanan wajib yang dibebankan kepada seluruh warga RT.</p>
                </div>

                <div class="p-3 bg-light rounded mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small d-block">Nominal Iuran Saat Ini</span>
                            <h3 class="fw-bold text-success mb-0">Rp 50.000 <span class="fs-6 text-muted fw-normal">/ bulan</span></h3>
                        </div>
                        <span class="badge bg-success">Berlaku Aktif</span>
                    </div>
                </div>

                <form action="<?= base_url('pengaturan/iuran/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="nominal">Nominal Iuran Baru (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Contoh: 60000" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-dark fw-semibold small" for="berlaku_dari">Mulai Berlaku Dari Tanggal</label>
                            <input type="date" class="form-control" id="berlaku_dari" name="berlaku_dari" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Simpan Perubahan Tarif</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Perubahan Tarif Iuran -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Riwayat Perubahan Tarif</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nominal</th>
                                <th>Mulai Berlaku</th>
                                <th>Diubah Oleh</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-dark">Rp 50.000</td>
                                <td>01 Jan 2026</td>
                                <td>Ketua RT</td>
                                <td><span class="badge bg-success">Aktif</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark">Rp 40.000</td>
                                <td>01 Jan 2025</td>
                                <td>Ketua RT</td>
                                <td><span class="badge bg-secondary">Arsip</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
