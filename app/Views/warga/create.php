<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <!-- Form Header -->
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Tambah Data Warga Baru</h4>
                        <p class="text-muted small mb-0">Lengkapi formulir berikut untuk mendaftarkan warga ke sistem Kas Kita.</p>
                    </div>
                    <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('warga/store') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <!-- ============================================================== -->
                    <!-- 1. IDENTITAS KEPALA KELUARGA & AKUN -->
                    <!-- ============================================================== -->
                    <div class="mb-4 pb-3 border-bottom">
                        <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                            <i data-feather="user" class="feather-icon text-success me-2" style="width: 18px; height: 18px;"></i>
                            <span>1. Identitas Kepala Keluarga &amp; Akun</span>
                        </h6>

                        <div class="row g-3">
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
                    </div>

                    <!-- ============================================================== -->
                    <!-- 2. ALAMAT RUMAH DI LINGKUNGAN RT 04 (CUSTOM SCROLLABLE DROPDOWNS) -->
                    <!-- ============================================================== -->
                    <div class="mb-4 pb-3 border-bottom">
                        <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                            <i data-feather="home" class="feather-icon text-success me-2" style="width: 18px; height: 18px;"></i>
                            <span>2. Alamat Rumah di Lingkungan RT 04</span>
                        </h6>

                        <div class="row g-3">
                            <!-- Pilihan Blok Rumah (Custom Dropdown) -->
                            <div class="col-md-4">
                                <label class="form-label text-dark fw-semibold small mb-1" for="dropdownBlok">Blok Pemukiman</label>
                                <div class="dropdown">
                                    <input type="hidden" name="blok_rumah" id="input_blok_rumah" value="" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownBlok" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedBlokText" class="text-muted">Pilih Blok...</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownBlok" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach ($master_blok as $blok) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="pilihBlok('<?= esc($blok['nama_blok']) ?>', <?= $blok['maks_nomor'] ?>)">
                                                    <?= esc($blok['nama_blok']) ?> (Kapasitas <?= $blok['maks_nomor'] ?>)
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Pilihan Nomor Rumah (Custom Scrollable Dropdown) -->
                            <div class="col-md-4">
                                <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNoRumah">Nomor Rumah</label>
                                <div class="dropdown">
                                    <input type="hidden" name="no_rumah" id="input_no_rumah" value="" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNoRumah" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                        <span id="selectedNoRumahText" class="text-muted">Pilih Blok Dulu...</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNoRumah" id="dropdownNoRumahList" style="max-height: 180px; overflow-y: auto;">
                                        <!-- Opsi nomor rumah akan dirender via JS -->
                                    </ul>
                                </div>
                            </div>

                            <!-- Pilihan Nama Jalan (Custom Dropdown) -->
                            <div class="col-md-4">
                                <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNamaJalan">Nama Jalan</label>
                                <div class="dropdown">
                                    <input type="hidden" name="nama_jalan" id="input_nama_jalan" value="" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNamaJalan" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedJalanText" class="text-muted">Pilih Jalan...</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNamaJalan" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach ($master_jalan as $jalan) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_nama_jalan', 'selectedJalanText', '<?= esc($jalan['nama_jalan']) ?>')">
                                                    <?= esc($jalan['nama_jalan']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- 3. HAK AKSES AKUN -->
                    <!-- ============================================================== -->
                    <div class="mb-4">
                        <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                            <i data-feather="shield" class="feather-icon text-success me-2" style="width: 18px; height: 18px;"></i>
                            <span>3. Hak Akses Akun</span>
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="role">Role Pengguna</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="warga" selected>Warga RT (Akses Pembayaran &amp; Tagihan)</option>
                                    <option value="pengurus">Pengurus RT (Akses Manajemen Penuh)</option>
                                </select>
                                <span class="text-muted font-11">Pilih 'Pengurus RT' untuk memberikan hak akses pengelola kas.</span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="status">Status Akun</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" selected>Aktif Langsung</option>
                                    <option value="pending">Menunggu Konfirmasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('warga') ?>" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">Daftarkan Warga</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function selectOption(inputId, textSpanId, value) {
    document.getElementById(inputId).value = value;
    const span = document.getElementById(textSpanId);
    span.textContent = value;
    span.classList.remove('text-muted');
    span.classList.add('text-dark', 'fw-semibold');
}

function pilihBlok(namaBlok, maksNomor) {
    // Set value blok
    document.getElementById('input_blok_rumah').value = namaBlok;
    const spanBlok = document.getElementById('selectedBlokText');
    spanBlok.textContent = namaBlok + ' (Kapasitas ' + maksNomor + ')';
    spanBlok.classList.remove('text-muted');
    spanBlok.classList.add('text-dark', 'fw-semibold');

    // Reset value nomor rumah
    document.getElementById('input_no_rumah').value = '';
    const spanNoRumah = document.getElementById('selectedNoRumahText');
    spanNoRumah.textContent = 'Pilih No...';
    spanNoRumah.classList.remove('text-dark', 'fw-semibold');
    spanNoRumah.classList.add('text-muted');

    // Enable button
    document.getElementById('dropdownNoRumah').disabled = false;

    // Generate list nomor rumah sesuai kapasitas
    const ulNoRumah = document.getElementById('dropdownNoRumahList');
    ulNoRumah.innerHTML = ''; // bersihkan list lama
    
    for (let i = 1; i <= maksNomor; i++) {
        let nomorStr = (i < 10 ? '0' : '') + i;
        let textNomor = 'No. ' + nomorStr;
        
        let li = document.createElement('li');
        let a = document.createElement('a');
        a.className = 'dropdown-item py-2';
        a.href = 'javascript:void(0)';
        a.textContent = textNomor;
        a.onclick = function() {
            selectOption('input_no_rumah', 'selectedNoRumahText', textNomor);
        };
        
        li.appendChild(a);
        ulNoRumah.appendChild(li);
    }
}
</script>
<?= $this->endSection() ?>
