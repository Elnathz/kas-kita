<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-7">
        <!-- Pengaturan Tarif Iuran -->
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nominal">Nominal Iuran Baru (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Contoh: 60000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="berlaku_dari">Mulai Berlaku Tanggal</label>
                            <input type="date" class="form-control" id="berlaku_dari" name="berlaku_dari" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success fw-semibold">Simpan Perubahan Tarif</button>
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

    <!-- Pengaturan Identitas & Wilayah RT -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="card-title fw-bold mb-1">Pengaturan Wilayah RT</h4>
                    <p class="text-muted small mb-0">Kelola identitas RT/RW serta daftar pilihan blok dan jalan yang tersedia untuk formulir warga.</p>
                </div>

                <form action="#" method="post">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="rt">Nomor RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" value="RT 04" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="rw">Nomor RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" value="RW 12" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="daftar_blok">Daftar Pilihan Blok Rumah</label>
                            <input type="text" class="form-control" id="daftar_blok" name="daftar_blok" value="Blok A, Blok B, Blok C, Blok D" placeholder="Pisahkan dengan koma">
                            <span class="text-muted font-12">Pilihan yang akan muncul di dropdown registrasi warga.</span>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="daftar_jalan">Daftar Pilihan Nama Jalan</label>
                            <textarea class="form-control" id="daftar_jalan" name="daftar_jalan" rows="3" placeholder="Pisahkan dengan koma">Jl. Mawar, Jl. Melati, Jl. Anggrek, Jl. Kenanga</textarea>
                            <span class="text-muted font-12">Pilihan jalan lingkungan yang akan muncul di formulir warga.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-success fw-semibold">Simpan Wilayah RT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
