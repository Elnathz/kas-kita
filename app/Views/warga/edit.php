<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <!-- Form Header -->
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Edit Data Warga</h4>
                        <p class="text-muted small mb-0">Perbarui informasi identitas warga, alamat rumah, dan hak akses akun.</p>
                    </div>
                    <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('warga/update/' . $warga['id']) ?>" method="post">
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
                                <label class="form-label text-dark fw-semibold small mb-1" for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($warga['nama']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="username">Username Login</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= esc($warga['username']) ?>" maxlength="20" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="password">Ganti Password (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="6" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="no_telepon">Nomor WhatsApp / HP</label>
                                <input type="tel" class="form-control" id="no_telepon" name="no_telepon" value="<?= esc($warga['no_telepon'] ?? '') ?>" inputmode="numeric" 
                                    pattern="[0-9]{10,15}" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
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
                                <label class="form-label text-dark fw-semibold small mb-1" for="dropdownBlokEdit">Blok Pemukiman</label>
                                <div class="dropdown">
                                    <input type="hidden" name="blok_rumah" id="input_blok_edit" value="<?= esc($warga['blok_rumah']) ?>" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownBlokEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedBlokEditText" class="text-dark fw-semibold"><?= esc($warga['blok_rumah']) ?></span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownBlokEdit" style="max-height: 180px; overflow-y: auto;">
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

                            <!-- Pilihan Nomor Rumah (Custom Scrollable Dropdown Maks 5 View) -->
                            <div class="col-md-4">
                                <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNoRumahEdit">Nomor Rumah</label>
                                <div class="dropdown">
                                    <input type="hidden" name="no_rumah" id="input_no_rumah_edit" value="<?= esc($warga['no_rumah']) ?>" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNoRumahEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedNoRumahEditText" class="text-dark fw-semibold"><?= esc($warga['no_rumah']) ?></span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNoRumahEdit" id="dropdownNoRumahList" style="max-height: 180px; overflow-y: auto;">
                                        <!-- Will be populated by JS if a new block is selected, but currently showing default list for simplicity or initial load -->
                                        <li>
                                            <a class="dropdown-item py-2" href="javascript:void(0)">
                                                <?= esc($warga['no_rumah']) ?> (Terpilih)
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Pilihan Nama Jalan (Custom Dropdown) -->
                            <div class="col-md-4">
                                <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNamaJalanEdit">Nama Jalan</label>
                                <div class="dropdown">
                                    <input type="hidden" name="nama_jalan" id="input_nama_jalan_edit" value="<?= esc($warga['nama_jalan']) ?>" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNamaJalanEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedJalanEditText" class="text-dark fw-semibold"><?= esc($warga['nama_jalan']) ?></span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNamaJalanEdit" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach ($master_jalan as $jalan) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_nama_jalan_edit', 'selectedJalanEditText', '<?= esc($jalan['nama_jalan']) ?>')">
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
                    <!-- 3. STATUS & HAK AKSES AKUN -->
                    <!-- ============================================================== -->
                    <div class="mb-4">
                        <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                            <i data-feather="shield" class="feather-icon text-success me-2" style="width: 18px; height: 18px;"></i>
                            <span>3. Status &amp; Hak Akses Akun</span>
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="role">Role Pengguna</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="warga" <?= $warga['role'] == 'warga' ? 'selected' : '' ?>>Warga RT (Akses Pembayaran &amp; Tagihan)</option>
                                    <option value="pengurus" <?= $warga['role'] == 'pengurus' ? 'selected' : '' ?>>Pengurus RT (Akses Manajemen Penuh)</option>
                                </select>
                                <span class="text-muted font-11">Pilih 'Pengurus RT' untuk memberikan hak akses pengelola kas.</span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="status">Status Akun</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" <?= $warga['is_active'] ? 'selected' : '' ?>>Aktif (Disetujui Pengurus)</option>
                                    <option value="pending" <?= !$warga['is_active'] ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('warga') ?>" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">Simpan Perubahan</button>
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
    document.getElementById('input_blok_edit').value = namaBlok;
    const spanBlok = document.getElementById('selectedBlokEditText');
    spanBlok.textContent = namaBlok;
    spanBlok.classList.remove('text-muted');
    spanBlok.classList.add('text-dark', 'fw-semibold');

    // Reset value nomor rumah
    document.getElementById('input_no_rumah_edit').value = '';
    const spanNoRumah = document.getElementById('selectedNoRumahEditText');
    spanNoRumah.textContent = 'Pilih No...';
    spanNoRumah.classList.remove('text-dark', 'fw-semibold');
    spanNoRumah.classList.add('text-muted');

    // Enable button
    document.getElementById('dropdownNoRumahEdit').disabled = false;

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
            selectOption('input_no_rumah_edit', 'selectedNoRumahEditText', textNomor);
        };
        
        li.appendChild(a);
        ulNoRumah.appendChild(li);
    }
}

// Saat halaman dimuat, trigger generate nomor rumah berdasarkan blok yang terpilih
document.addEventListener('DOMContentLoaded', function() {
    let currentBlok = '<?= esc($warga['blok_rumah']) ?>';
    let currentNo = '<?= esc($warga['no_rumah']) ?>';
    
    <?php foreach ($master_blok as $blok) : ?>
    if (currentBlok === '<?= esc($blok['nama_blok']) ?>') {
        pilihBlok('<?= esc($blok['nama_blok']) ?>', <?= $blok['maks_nomor'] ?>);
        selectOption('input_no_rumah_edit', 'selectedNoRumahEditText', currentNo);
    }
    <?php endforeach; ?>
});
</script>
<?= $this->endSection() ?>
