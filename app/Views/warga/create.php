<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Tambah Data Warga Baru</h4>
                        <p class="text-muted small mb-0">Lengkapi formulir berikut untuk mendaftarkan warga ke sistem Kas Kita.</p>
                    </div>
                    <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('warga/store') ?>" method="post" onsubmit="return validateWargaCreate()">
                    <?= csrf_field() ?>
                    
                    <!-- Bagian 1: Identitas Pribadi & Akun -->
                    <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                        <i data-feather="user" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                        <span>1. Identitas Kepala Keluarga &amp; Akun</span>
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nama">Nama Lengkap (Kepala Keluarga)</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Ahmad Fauzi" required autofocus>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="username">Username Login</label>
                            <input type="text" class="form-control" id="username" name="username" maxlength="20" placeholder="Contoh: ahmad_fauzi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="password">Password Awal</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="no_telepon">Nomor WhatsApp / HP</label>
                            <input type="tel" class="form-control" id="no_telepon" name="no_telepon" inputmode="numeric" 
                                pattern="[0-9]{10,15}" maxlength="15" placeholder="Contoh: 081234567890" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                    </div>

                    <!-- Bagian 2: Alamat Rumah di Lingkungan RT 04 -->
                    <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                        <i data-feather="map-pin" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                        <span>2. Alamat Rumah di Lingkungan RT 04</span>
                    </h6>

                    <div class="row g-3 mb-4 p-3 bg-light rounded">
                        <!-- Dropdown Blok Rumah -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownBlokCreate">Blok Rumah</label>
                            <div class="dropdown">
                                <input type="hidden" name="blok_rumah" id="input_blok_create" value="" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownBlokCreate" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedBlokCreateText" class="text-muted">Pilih Blok...</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownBlokCreate" style="max-height: 180px; overflow-y: auto;">
                                    <?php foreach (['Blok A', 'Blok B', 'Blok C', 'Blok D'] as $blok) : ?>
                                        <li>
                                            <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOptionCreate('input_blok_create', 'selectedBlokCreateText', '<?= $blok ?>')">
                                                <?= $blok ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Dropdown Nomor Rumah -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNoRumahCreate">Nomor Rumah</label>
                            <div class="dropdown">
                                <input type="hidden" name="no_rumah" id="input_no_rumah_create" value="" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNoRumahCreate" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedNoRumahTextCreate" class="text-muted">Pilih No...</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNoRumahCreate" style="max-height: 180px; overflow-y: auto;">
                                    <?php for ($i = 1; $i <= 30; $i++) : ?>
                                        <?php $nomor = sprintf('%02d', $i); ?>
                                        <li>
                                            <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOptionCreate('input_no_rumah_create', 'selectedNoRumahTextCreate', 'No. <?= $nomor ?>')">
                                                No. <?= $nomor ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Dropdown Nama Jalan -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownJalanCreate">Nama Jalan</label>
                            <div class="dropdown">
                                <input type="hidden" name="nama_jalan" id="input_jalan_create" value="" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownJalanCreate" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedJalanCreateText" class="text-muted">Pilih Jalan...</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownJalanCreate" style="max-height: 180px; overflow-y: auto;">
                                    <?php foreach (['Jl. Mawar', 'Jl. Melati', 'Jl. Anggrek', 'Jl. Kenanga'] as $jalan) : ?>
                                        <li>
                                            <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOptionCreate('input_jalan_create', 'selectedJalanCreateText', '<?= $jalan ?>')">
                                                <?= $jalan ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 3: Hak Akses Akun -->
                    <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                        <i data-feather="shield" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                        <span>3. Hak Akses Akun</span>
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="role">Role Pengguna</label>
                            <select class="form-select" id="role" name="role">
                                <option value="warga" selected>Warga RT (Akses Pembayaran &amp; Tagihan)</option>
                                <option value="pengurus">Pengurus RT (Akses Manajemen Penuh)</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('warga') ?>" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">Simpan Data Warga</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function selectOptionCreate(inputId, textId, val) {
    document.getElementById(inputId).value = val;
    const txt = document.getElementById(textId);
    txt.innerText = val;
    txt.classList.remove('text-muted');
    txt.classList.add('text-dark', 'fw-semibold');
}

function validateWargaCreate() {
    const blok = document.getElementById('input_blok_create').value;
    const noRumah = document.getElementById('input_no_rumah_create').value;
    const jalan = document.getElementById('input_jalan_create').value;

    if (!blok || !noRumah || !jalan) {
        alert('Silakan lengkapi pilihan Blok, Nomor Rumah, dan Nama Jalan warga.');
        return false;
    }
    return true;
}
</script>
<?= $this->endSection() ?>
