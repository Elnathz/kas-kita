<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Edit Data Warga</h4>
                        <p class="text-muted small mb-0">Perbarui data profil warga yang terdaftar.</p>
                    </div>
                    <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('warga/update/' . ($id ?? 1)) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="Ahmad Fauzi" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="username">Username Login</label>
                            <input type="text" class="form-control" id="username" name="username" value="ahmad.fauzi" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="password">Password Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tetap">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="no_rumah">Nomor Rumah</label>
                            <input type="text" class="form-control" id="no_rumah" name="no_rumah" value="Blok A / 01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="no_telepon">Nomor Telepon / WA</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="081234567890" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold small" for="role">Role Pengguna</label>
                            <select class="form-select" id="role" name="role">
                                <option value="warga" selected>Warga RT</option>
                                <option value="pengurus">Pengurus RT</option>
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label text-dark fw-semibold small" for="alamat">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">Jl. Mawar No. 01, RT 03/RW 05</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('warga') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-success">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
