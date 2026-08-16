<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Edit Data Warga</h4>
                        <p class="text-muted small mb-0">Perbarui informasi identitas warga RT.</p>
                    </div>
                    <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('warga/update/1') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="Ahmad Fauzi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="username">Username Login</label>
                            <input type="text" class="form-control" id="username" name="username" value="ahmad_fauzi" maxlength="20" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="password">Ganti Password (Opsional)</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="no_telepon">Nomor Telepon / WA</label>
                            <input type="tel" class="form-control" id="no_telepon" name="no_telepon" value="081234567890" inputmode="numeric" 
                                pattern="[0-9]{10,15}" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>

                        <!-- Dropdown Wilayah RT -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="blok_rumah">Blok Rumah</label>
                            <select class="form-select" id="blok_rumah" name="blok_rumah" required>
                                <option value="Blok A" selected>Blok A</option>
                                <option value="Blok B">Blok B</option>
                                <option value="Blok C">Blok C</option>
                                <option value="Blok D">Blok D</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="no_rumah">Nomor Rumah</label>
                            <select class="form-select" id="no_rumah" name="no_rumah" required>
                                <?php for ($i = 1; $i <= 30; $i++) : ?>
                                    <?php $nomor = sprintf('%02d', $i); ?>
                                    <option value="No. <?= $nomor ?>" <?= ($nomor === '01') ? 'selected' : '' ?>>No. <?= $nomor ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nama_jalan">Nama Jalan</label>
                            <select class="form-select" id="nama_jalan" name="nama_jalan" required>
                                <option value="Jl. Mawar" selected>Jl. Mawar</option>
                                <option value="Jl. Melati">Jl. Melati</option>
                                <option value="Jl. Anggrek">Jl. Anggrek</option>
                                <option value="Jl. Kenanga">Jl. Kenanga</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="role">Role Akun</label>
                            <select class="form-select" id="role" name="role">
                                <option value="warga" selected>Warga RT</option>
                                <option value="pengurus">Pengurus RT</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="is_active">Status Akun</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" selected>Aktif (Disetujui)</option>
                                <option value="0">Nonaktif / Menunggu Approval</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('warga') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-success fw-semibold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
