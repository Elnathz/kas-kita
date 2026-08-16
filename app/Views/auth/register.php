<?= $this->extend('layouts/clear') ?>
<?= $this->section('content') ?>
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative min-vh-100 py-4"
    style="background: url(<?= base_url('FreeDash/src/assets/images/big/auth-bg.jpg') ?>) no-repeat center center; background-size: cover;">
    <div class="auth-box row shadow-lg rounded overflow-hidden" style="max-width: 960px; width: 95%;">
        <!-- Side Banner Image -->
        <div class="col-lg-5 d-none d-lg-block modal-bg-img p-0" style="background-image: url(<?= base_url('FreeDash/src/assets/images/big/3.jpg') ?>); background-size: cover; background-position: center;">
            <div class="h-100 w-100 d-flex flex-column justify-content-end p-4" style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(4,120,87,0.88) 100%);">
                <h3 class="text-white fw-bold mb-1">Kas Kita</h3>
                <p class="text-white-50 mb-0">Daftarkan diri Anda sebagai warga untuk kemudahan pemantauan dan pembayaran iuran kas RT secara transparan.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-7 bg-white p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="<?= base_url('FreeDash/src/assets/images/logo-icon.png') ?>" alt="Logo Kas Kita" class="img-fluid mb-2" style="max-height: 42px;">
                <h3 class="fw-bold mb-1" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Pendaftaran Warga Baru</h3>
                <p class="text-muted small mb-0">Lengkapi data akun Anda di bawah ini</p>
            </div>

            <!-- Flash Error Notification -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show small py-2" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="post" id="formRegister" onsubmit="return validateForm()">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <!-- Nama Kepala Keluarga -->
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nama">Nama Kepala Keluarga</label>
                            <input class="form-control" id="nama" name="nama" type="text" placeholder="Contoh: Ahmad Fauzi" maxlength="100" required autofocus>
                        </div>
                    </div>

                    <!-- Nomor / Blok Rumah -->
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="no_rumah">Nomor / Blok Rumah</label>
                            <input class="form-control" id="no_rumah" name="no_rumah" type="text" placeholder="Contoh: Blok A / 05" maxlength="30" required>
                        </div>
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="no_telepon">Nomor WhatsApp / HP</label>
                            <input class="form-control" id="no_telepon" name="no_telepon" type="tel" inputmode="numeric" 
                                pattern="[0-9]{10,15}" maxlength="15" placeholder="Contoh: 081234567890" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="username">Username (Maks 20 Karakter)</label>
                            <input class="form-control" id="username" name="username" type="text" maxlength="20" 
                                pattern="[a-zA-Z0-9_.]+" placeholder="Contoh: ahmad_fauzi" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password" minlength="6" maxlength="50" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="password_confirm">Konfirmasi Password</label>
                            <input class="form-control" id="password_confirm" name="password_confirm" type="password" minlength="6" maxlength="50" placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="col-12">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="alamat">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" maxlength="255" placeholder="Jl. Mawar No. 12 RT 03 RW 05"></textarea>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 p-2 mt-3 mb-3 small d-flex align-items-center">
                    <i data-feather="info" class="feather-icon text-info me-2 flex-shrink-0"></i>
                    <span>Akun Anda akan diverifikasi oleh pengurus RT sebelum dapat digunakan untuk login.</span>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success fw-semibold py-2">Daftar Sekarang</button>
                </div>

                <div class="text-center small text-muted">
                    Sudah memiliki akun? <a href="<?= base_url('login') ?>" class="text-success fw-bold text-decoration-none">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    const pwd = document.getElementById('password').value;
    const pwdConfirm = document.getElementById('password_confirm').value;

    if (pwd !== pwdConfirm) {
        alert('Konfirmasi password tidak cocok dengan password yang dimasukkan.');
        document.getElementById('password_confirm').focus();
        return false;
    }
    return true;
}
</script>
<?= $this->endSection() ?>
