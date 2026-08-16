<?= $this->extend('layouts/clear') ?>
<?= $this->section('content') ?>
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative min-vh-100"
    style="background: url(<?= base_url('FreeDash/src/assets/images/big/auth-bg.jpg') ?>) no-repeat center center; background-size: cover;">
    <div class="auth-box row shadow-lg rounded overflow-hidden" style="max-width: 900px; width: 95%;">
        <!-- Side Banner Image -->
        <div class="col-lg-6 col-md-5 d-none d-md-block modal-bg-img p-0" style="background-image: url(<?= base_url('FreeDash/src/assets/images/big/3.jpg') ?>); background-size: cover; background-position: center;">
            <div class="h-100 w-100 d-flex flex-column justify-content-end p-4" style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(4,120,87,0.85) 100%);">
                <h3 class="text-white fw-bold mb-1">Kas Kita</h3>
                <p class="text-white-50 mb-0">Transparansi dan kemudahan pengelolaan kas serta iuran warga RT.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-6 col-md-7 bg-white p-4 p-lg-5">
            <div class="text-center mb-4">
                <img src="<?= base_url('FreeDash/src/assets/images/logo-icon.png') ?>" alt="Logo Kas Kita" class="img-fluid mb-2" style="max-height: 48px;">
                <h3 class="fw-bold mb-1" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Kas Kita</h3>
                <p class="text-muted small">Silakan masuk menggunakan akun Anda</p>
            </div>

            <!-- Flash Success Notification -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show small py-2" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Flash Error Notification -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show small py-2" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form class="mt-3" action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                    <label class="form-label text-dark fw-semibold small" for="username">Username</label>
                    <input class="form-control" id="username" name="username" type="text"
                        placeholder="Contoh: admin" required autofocus>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label text-dark fw-semibold small" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password"
                        placeholder="Masukkan password" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success fw-semibold py-2">Masuk ke Sistem</button>
                </div>

                <div class="text-center small text-muted mb-3">
                    Belum punya akun warga? <a href="<?= base_url('register') ?>" class="text-success fw-bold text-decoration-none">Daftar di sini</a>
                </div>

                <div class="p-3 bg-light rounded text-center small text-muted">
                    <strong>Demo Login (UTS):</strong><br>
                    Username: <code>admin</code> | Password: <code>admin123</code>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
