<?= $this->extend('layouts/clear') ?>
<?= $this->section('content') ?>
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative min-vh-100"
    style="background: url(<?= base_url('FreeDash/src/assets/images/big/auth-bg.jpg') ?>) no-repeat center center; background-size: cover;">
    <div class="auth-box row shadow-lg rounded overflow-hidden" style="max-width: 900px; width: 95%;">
        <!-- Side Banner Image -->
        <div class="col-lg-6 col-md-5 d-none d-md-block modal-bg-img p-0" style="background-image: url(<?= base_url('assets/images/auth-banner.jpg') ?>); background-size: cover; background-position: center;">
            <div class="h-100 w-100 d-flex flex-column justify-content-end p-4" style="background: linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(4,120,87,0.92) 100%);">
                <h3 class="text-white fw-bold mb-1">Kas Kita</h3>
                <p class="text-white-50 mb-0">Transparansi dan kemudahan pengelolaan kas serta iuran warga RT.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-6 col-md-7 bg-white p-4 p-lg-5">
            <div class="text-center mb-4">
                <img src="<?= base_url('assets/images/logo-vertical.svg') ?>" alt="Logo Kas Kita" class="img-fluid mb-2" style="height: 115px; width: auto;">
                <p class="text-muted small mb-0">Silakan masuk menggunakan akun Anda</p>
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

            <form class="mt-3" action="<?= base_url('login') ?>" method="post" id="formLogin">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                    <label class="form-label text-dark fw-semibold small" for="username">Username</label>
                    <input class="form-control" id="username" name="username" type="text"
                        placeholder="Contoh: admin / farros" required autofocus>
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

                <!-- Helper Demo UTS (2 Role) -->
                <div class="p-3 bg-light rounded text-center small border">
                    <span class="text-dark fw-semibold d-block mb-2 font-12">Pilih Cepat Akun Demo (UTS):</span>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-xs btn-outline-success font-12 py-1 px-2" onclick="setLogin('admin', 'admin123')">
                            Pengurus (admin)
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-primary font-12 py-1 px-2" onclick="setLogin('farros', 'warga123')">
                            Warga (Farros)
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setLogin(u, p) {
    document.getElementById('username').value = u;
    document.getElementById('password').value = p;
    document.getElementById('formLogin').submit();
}
</script>
<?= $this->endSection() ?>
