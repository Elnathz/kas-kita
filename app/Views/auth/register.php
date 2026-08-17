<?= $this->extend('layouts/clear') ?>
<?= $this->section('content') ?>
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative min-vh-100 py-4"
    style="background: url(<?= base_url('FreeDash/src/assets/images/big/auth-bg.jpg') ?>) no-repeat center center; background-size: cover;">
    <div class="auth-box row shadow-lg rounded overflow-hidden" style="max-width: 960px; width: 95%;">
        <!-- Side Banner Image -->
        <div class="col-lg-5 d-none d-lg-block modal-bg-img p-0" style="background-image: url(<?= base_url('assets/images/auth-banner.jpg') ?>); background-size: cover; background-position: center;">
            <div class="h-100 w-100 d-flex flex-column justify-content-end p-4" style="background: linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(4,120,87,0.92) 100%);">
                <h3 class="text-white fw-bold mb-1">Kas Kita</h3>
                <p class="text-white-50 mb-0">Daftarkan diri Anda sebagai warga untuk kemudahan pemantauan dan pembayaran iuran kas RT secara transparan.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-7 bg-white p-4 p-md-5">
            <div class="text-center mb-3">
                <img src="<?= base_url('assets/images/logo-vertical.svg') ?>" alt="Logo Kas Kita" class="img-fluid mb-2" style="height: 95px; width: auto;">
                <h4 class="fw-bold text-dark mb-1">Form Pendaftaran Warga</h4>
                <p class="text-muted small mb-0">Pilih identitas rumah dan lengkapi akun Anda</p>
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
                    <div class="col-12">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nama">Nama Kepala Keluarga</label>
                            <input class="form-control" id="nama" name="nama" type="text" placeholder="Contoh: Ahmad Fauzi" maxlength="100" required autofocus>
                        </div>
                    </div>

                    <!-- Pilihan Blok Rumah (Custom Dropdown) -->
                    <div class="col-sm-4">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownBlokRumah">Blok Rumah</label>
                            <div class="dropdown">
                                <input type="hidden" name="blok_rumah" id="input_blok_rumah" value="" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center" type="button" id="dropdownBlokRumah" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedBlokText" class="text-muted text-truncate me-2">Pilih Blok...</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownBlokRumah" style="max-height: 180px; overflow-y: auto;">
                                    <?php if(isset($master_blok) && !empty($master_blok)): ?>
                                        <?php foreach ($master_blok as $blok) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectBlokOption('<?= $blok['nama_blok'] ?>', <?= $blok['maks_nomor'] ?>)">
                                                    <?= $blok['nama_blok'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><span class="dropdown-item text-muted small">Data blok belum diatur</span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Nomor Rumah (Custom Scrollable Dropdown) -->
                    <div class="col-sm-4">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNoRumah">Nomor Rumah</label>
                            <div class="dropdown">
                                <input type="hidden" name="no_rumah" id="input_no_rumah" value="" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center" type="button" id="dropdownNoRumah" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                    <span id="selectedNoRumahText" class="text-muted text-truncate me-2">Pilih Blok Dulu</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNoRumah" id="ulNomorRumah" style="max-height: 180px; overflow-y: auto;">
                                    <!-- Options will be generated by JS -->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Nama Jalan (Custom Dropdown) -->
                    <div class="col-sm-4">
                        <div class="form-group mb-0">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNamaJalan">Nama Jalan</label>
                            <div class="dropdown">
                                <input type="hidden" name="nama_jalan" id="input_nama_jalan" value="" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center" type="button" id="dropdownNamaJalan" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedJalanText" class="text-muted text-truncate me-2">Pilih Jalan...</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNamaJalan" style="max-height: 180px; overflow-y: auto;">
                                    <?php if(isset($master_jalan) && !empty($master_jalan)): ?>
                                        <?php foreach ($master_jalan as $jalan) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_nama_jalan', 'selectedJalanText', '<?= $jalan['nama_jalan'] ?>')">
                                                    <?= $jalan['nama_jalan'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><span class="dropdown-item text-muted small">Data jalan belum diatur</span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
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
                </div>

                <div class="alert alert-info border-0 p-2 mt-3 mb-3 small d-flex align-items-center">
                    <i data-feather="info" class="feather-icon text-info me-2 flex-shrink-0"></i>
                    <span>Wilayah: <strong>RT 06 / RW 20</strong>, Kecamatan Purwodadi, Kabupaten Grobogan. Akun akan diverifikasi pengurus RT sebelum aktif.</span>
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
function selectOption(inputId, textId, val) {
    document.getElementById(inputId).value = val;
    const txt = document.getElementById(textId);
    txt.innerText = val;
    txt.className = 'text-dark fw-semibold text-truncate me-2';
}

function selectBlokOption(namaBlok, maksNomor) {
    selectOption('input_blok_rumah', 'selectedBlokText', namaBlok);
    
    // Reset and enable Nomor Rumah
    const dropdownNo = document.getElementById('dropdownNoRumah');
    const ulNomor = document.getElementById('ulNomorRumah');
    
    dropdownNo.disabled = false;
    document.getElementById('selectedNoRumahText').innerText = 'Pilih No...';
    document.getElementById('selectedNoRumahText').className = 'text-muted text-truncate me-2';
    document.getElementById('input_no_rumah').value = '';
    
    ulNomor.innerHTML = '';
    
    for (let i = 1; i <= maksNomor; i++) {
        let nomorFormatted = String(i).padStart(2, '0');
        let li = document.createElement('li');
        li.innerHTML = `<a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_no_rumah', 'selectedNoRumahText', 'No. ${nomorFormatted}')">No. ${nomorFormatted}</a>`;
        ulNomor.appendChild(li);
    }
}

function validateForm() {
    const blok = document.getElementById('input_blok_rumah').value;
    const noRumah = document.getElementById('input_no_rumah').value;
    const jalan = document.getElementById('input_nama_jalan').value;

    if (!blok) {
        showAppToast('Silakan pilih blok rumah terlebih dahulu.', 'warning', 'Blok Rumah Kosong');
        return false;
    }
    if (!noRumah) {
        showAppToast('Silakan pilih nomor rumah terlebih dahulu.', 'warning', 'Nomor Rumah Kosong');
        return false;
    }
    if (!jalan) {
        showAppToast('Silakan pilih nama jalan terlebih dahulu.', 'warning', 'Nama Jalan Kosong');
        return false;
    }

    const pwd = document.getElementById('password').value;
    const pwdConfirm = document.getElementById('password_confirm').value;

    if (pwd !== pwdConfirm) {
        showAppToast('Konfirmasi password tidak cocok dengan kata sandi yang dimasukkan.', 'danger', 'Password Tidak Cocok');
        document.getElementById('password_confirm').focus();
        return false;
    }
    return true;
}
</script>
<?= $this->endSection() ?>
