<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Edit Data Warga</h4>
                        <p class="text-muted small mb-0">Perbarui informasi identitas warga, alamat rumah, dan hak akses akun.</p>
                    </div>
                    <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form action="<?= base_url('warga/update/1') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <!-- Bagian 1: Identitas Pribadi & Akun -->
                    <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                        <i data-feather="user" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                        <span>1. Identitas Kepala Keluarga &amp; Akun</span>
                    </h6>
                    
                    <div class="row g-3 mb-4">
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

                    <!-- Bagian 2: Alamat Rumah di Lingkungan RT 04 -->
                    <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                        <i data-feather="map-pin" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                        <span>2. Alamat Rumah di Lingkungan RT 04</span>
                    </h6>

                    <div class="row g-3 mb-4 p-3 bg-light rounded">
                        <!-- Dropdown Blok Rumah -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownBlokEdit">Blok Rumah</label>
                            <div class="dropdown">
                                <input type="hidden" name="blok_rumah" id="input_blok_edit" value="Blok A" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownBlokEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedBlokEditText" class="text-dark fw-semibold">Blok A</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownBlokEdit" style="max-height: 180px; overflow-y: auto;">
                                    <?php foreach (['Blok A', 'Blok B', 'Blok C', 'Blok D'] as $blok) : ?>
                                        <li>
                                            <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOptionEdit('input_blok_edit', 'selectedBlokEditText', '<?= $blok ?>')">
                                                <?= $blok ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Dropdown Nomor Rumah -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownNoRumahEdit">Nomor Rumah</label>
                            <div class="dropdown">
                                <input type="hidden" name="no_rumah" id="input_no_rumah_edit" value="No. 01" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownNoRumahEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedNoRumahTextEdit" class="text-dark fw-semibold">No. 01</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNoRumahEdit" style="max-height: 180px; overflow-y: auto;">
                                    <?php for ($i = 1; $i <= 30; $i++) : ?>
                                        <?php $nomor = sprintf('%02d', $i); ?>
                                        <li>
                                            <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOptionEdit('input_no_rumah_edit', 'selectedNoRumahTextEdit', 'No. <?= $nomor ?>')">
                                                No. <?= $nomor ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Dropdown Nama Jalan -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small mb-1" for="dropdownJalanEdit">Nama Jalan</label>
                            <div class="dropdown">
                                <input type="hidden" name="nama_jalan" id="input_jalan_edit" value="Jl. Mawar" required>
                                <button class="form-select text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownJalanEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedJalanEditText" class="text-dark fw-semibold">Jl. Mawar</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownJalanEdit" style="max-height: 180px; overflow-y: auto;">
                                    <?php foreach (['Jl. Mawar', 'Jl. Melati', 'Jl. Anggrek', 'Jl. Kenanga'] as $jalan) : ?>
                                        <li>
                                            <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOptionEdit('input_jalan_edit', 'selectedJalanEditText', '<?= $jalan ?>')">
                                                <?= $jalan ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 3: Status & Hak Akses Akun -->
                    <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                        <i data-feather="shield" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                        <span>3. Status &amp; Hak Akses Akun</span>
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="role">Role Pengguna</label>
                            <select class="form-select" id="role" name="role">
                                <option value="warga" selected>Warga RT (Akses Pembayaran &amp; Tagihan)</option>
                                <option value="pengurus">Pengurus RT (Akses Manajemen Penuh)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="is_active">Status Akun</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" selected>Aktif (Disetujui Pengurus)</option>
                                <option value="0">Nonaktif / Menunggu Approval</option>
                            </select>
                        </div>
                    </div>

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
function selectOptionEdit(inputId, textId, val) {
    document.getElementById(inputId).value = val;
    const txt = document.getElementById(textId);
    txt.innerText = val;
}
</script>
<?= $this->endSection() ?>
