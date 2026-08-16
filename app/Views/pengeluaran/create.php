<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Catat Pengeluaran Kas RT</h4>
                        <p class="text-muted small mb-0">Dokumentasikan penggunaan dana kas RT beserta kategori dan unggah bukti nota belanja.</p>
                    </div>
                    <a href="<?= base_url('pengeluaran') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('pengeluaran/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="kategori_id">Kategori Pengeluaran</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="" disabled selected>Pilih Kategori Pos Kas...</option>
                                <option value="1">Kas Operasional (Lampu, Kebersihan, Keamanan)</option>
                                <option value="2">Sosial (Santunan Sakit, Duka Cita)</option>
                                <option value="3">Konsumsi (Rapat, Kegiatan Warga)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="tanggal">Tanggal Pengeluaran</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nominal">Nominal Pengeluaran (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Contoh: 250000" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="keterangan">Keterangan / Keperluan Lengkap</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Jelaskan rincian keperluan pengeluaran..." required></textarea>
                        </div>

                        <!-- Upload Bukti Nota / Kuitansi -->
                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="bukti_nota">Upload Bukti Nota / Kuitansi (Opsional)</label>
                            <input type="file" class="form-control" id="bukti_nota" name="bukti_nota" accept="image/png, image/jpeg, image/jpg, application/pdf">
                            <span class="text-muted font-12 d-block mt-1">Format: JPG, PNG, atau PDF (Maks. 2MB). Foto nota atau kuitansi fisik untuk transparansi audit kas.</span>
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
