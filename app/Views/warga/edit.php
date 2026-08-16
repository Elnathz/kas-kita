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

                <form action="<?= base_url('warga/update/1') ?>" method="post">
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
                                <input type="text" class="form-control" id="nama" name="nama" value="Ahmad Fauzi" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="username">Username Login</label>
                                <input type="text" class="form-control" id="username" name="username" value="ahmad_fauzi" maxlength="20" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="password">Ganti Password (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="6" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="no_telepon">Nomor WhatsApp / HP</label>
                                <input type="tel" class="form-control" id="no_telepon" name="no_telepon" value="081234567890" inputmode="numeric" 
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
                                    <input type="hidden" name="blok_rumah" id="input_blok_edit" value="Blok A (Kapasitas 15)" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownBlokEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedBlokEditText" class="text-dark fw-semibold">Blok A (Kapasitas 15)</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownBlokEdit" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach (['Blok A (Kapasitas 15)', 'Blok B (Kapasitas 12)', 'Blok C (Kapasitas 13)', 'Blok D (Kapasitas 10)'] as $blok) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_blok_edit', 'selectedBlokEditText', '<?= $blok ?>')">
                                                    <?= $blok ?>
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
                                    <input type="hidden" name="no_rumah" id="input_no_rumah_edit" value="No. 01" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNoRumahEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedNoRumahEditText" class="text-dark fw-semibold">No. 01</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNoRumahEdit" style="max-height: 180px; overflow-y: auto;">
                                        <?php for ($i = 1; $i <= 30; $i++) : ?>
                                            <?php $nomor = sprintf('%02d', $i); ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_no_rumah_edit', 'selectedNoRumahEditText', 'No. <?= $nomor ?>')">
                                                    No. <?= $nomor ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Pilihan Nama Jalan (Custom Dropdown) -->
                            <div class="col-md-4">
                                <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNamaJalanEdit">Nama Jalan</label>
                                <div class="dropdown">
                                    <input type="hidden" name="nama_jalan" id="input_nama_jalan_edit" value="Jl. Mawar" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNamaJalanEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedJalanEditText" class="text-dark fw-semibold">Jl. Mawar</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNamaJalanEdit" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach (['Jl. Mawar', 'Jl. Melati', 'Jl. Anggrek', 'Jl. Kenanga'] as $jalan) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_nama_jalan_edit', 'selectedJalanEditText', '<?= $jalan ?>')">
                                                    <?= $jalan ?>
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
                                    <option value="warga" selected>Warga RT (Akses Pembayaran &amp; Tagihan)</option>
                                    <option value="pengurus">Pengurus RT (Akses Manajemen Penuh)</option>
                                </select>
                                <span class="text-muted font-11">Pilih 'Pengurus RT' untuk memberikan hak akses pengelola kas.</span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small mb-1" for="status">Status Akun</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" selected>Aktif (Disetujui Pengurus)</option>
                                    <option value="pending">Menunggu Konfirmasi</option>
                                    <option value="inactive">Nonaktif (Pindah / Tidak Aktif)</option>
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
</script>
<?= $this->endSection() ?>
