<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                        <i data-feather="user" class="text-success" style="width: 30px; height: 30px;"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-white mb-1">Pengaturan Akun & Profil</h3>
                        <p class="text-white-50 mb-0">Kelola informasi pribadi, alamat tinggal, dan keamanan akun Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
        <i data-feather="check-circle" class="feather-icon me-2"></i>
        <div><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Kolom Kiri: Info Pribadi & Alamat -->
    <div class="col-lg-8 order-2 order-lg-1">
        <!-- Card Info Pribadi -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                <i data-feather="info" class="text-primary me-2" style="width: 18px; height: 18px;"></i>
                <h5 class="card-title mb-0 fw-bold">Informasi Pribadi</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('profil/update') ?>" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Nama Kepala Keluarga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="Farros Rifantiarno" required>
                            <small class="text-muted font-12 mt-1">Perubahan nama akan langsung tersimpan.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" value="farros_r" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Nomor WhatsApp / Telepon <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i data-feather="phone" style="width: 16px; height: 16px;"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" name="telepon" value="081234567890" required>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary fw-semibold px-4">Simpan Perubahan Pribadi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card Alamat Rumah (Approval Required) -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                <i data-feather="map-pin" class="text-warning me-2" style="width: 18px; height: 18px;"></i>
                <h5 class="card-title mb-0 fw-bold">Alamat & Identitas Rumah</h5>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis d-flex align-items-start p-3 mb-4 rounded-3">
                    <i data-feather="alert-triangle" class="me-2 flex-shrink-0 mt-1" style="width: 18px; height: 18px;"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Pengajuan Perubahan Alamat</h6>
                        <p class="mb-0 font-13">Data alamat terikat dengan catatan iuran kas. Perubahan pada Blok, Nomor Rumah, atau Nama Jalan tidak akan langsung tersimpan, melainkan <strong>dikirim ke Pengurus RT untuk divalidasi</strong> terlebih dahulu.</p>
                    </div>
                </div>

                <form action="<?= base_url('profil/update') ?>" method="POST">
                    <div class="row g-3">
                        <!-- Pilihan Blok Rumah (Custom Dropdown) -->
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="form-label text-dark fw-semibold small mb-1">Blok Rumah</label>
                                <div class="dropdown">
                                    <input type="hidden" name="blok_rumah" id="input_blok_rumah" value="Blok A" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center" type="button" id="dropdownBlokRumah" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedBlokText" class="text-dark fw-semibold">Blok A</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownBlokRumah" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach (['Blok A', 'Blok B', 'Blok C', 'Blok D'] as $blok) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_blok_rumah', 'selectedBlokText', '<?= $blok ?>')">
                                                    <?= $blok ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Nomor Rumah (Custom Scrollable Dropdown) -->
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="form-label text-dark fw-semibold small mb-1">Nomor Rumah</label>
                                <div class="dropdown">
                                    <input type="hidden" name="no_rumah" id="input_no_rumah" value="No. 01" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center" type="button" id="dropdownNoRumah" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedNoRumahText" class="text-dark fw-semibold">No. 01</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNoRumah" style="max-height: 180px; overflow-y: auto;">
                                        <?php for ($i = 1; $i <= 30; $i++) : ?>
                                            <?php $nomor = sprintf('%02d', $i); ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_no_rumah', 'selectedNoRumahText', 'No. <?= $nomor ?>')">
                                                    No. <?= $nomor ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Nama Jalan (Custom Dropdown) -->
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="form-label text-dark fw-semibold small mb-1">Nama Jalan</label>
                                <div class="dropdown">
                                    <input type="hidden" name="nama_jalan" id="input_nama_jalan" value="Jl. Mawar" required>
                                    <button class="form-select text-start d-flex justify-content-between align-items-center" type="button" id="dropdownNamaJalan" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedJalanText" class="text-dark fw-semibold">Jl. Mawar</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0" aria-labelledby="dropdownNamaJalan" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach (['Jl. Mawar', 'Jl. Melati', 'Jl. Anggrek', 'Jl. Kenanga'] as $jalan) : ?>
                                            <li>
                                                <a class="dropdown-item py-2" href="javascript:void(0)" onclick="selectOption('input_nama_jalan', 'selectedJalanText', '<?= $jalan ?>')">
                                                    <?= $jalan ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-warning fw-semibold px-4 text-dark shadow-sm">Ajukan Perubahan Alamat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Keamanan & Status -->
    <div class="col-lg-4 order-1 order-lg-2">
        <!-- Card Status Keanggotaan -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden position-relative" style="background: linear-gradient(145deg, #1e293b, #0f172a);">
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i data-feather="shield" style="width: 100px; height: 100px; color: #fff;"></i>
            </div>
            <div class="card-body p-4 position-relative z-1 text-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="text-success fw-bold mb-0">Status Keanggotaan</h6>
                    <div class="bg-success text-white rounded-pill px-3 py-1 fw-bold font-12 d-flex align-items-center shadow-sm">
                        <i data-feather="check-circle" class="me-1" style="width: 14px; height: 14px;"></i> Warga Aktif
                    </div>
                </div>
                
                <h4 class="fw-bold mb-1">Kepala Keluarga</h4>
                <p class="text-white-50 font-13 mb-4">Telah diverifikasi oleh Pengurus RT 04</p>
                
                <div class="bg-white bg-opacity-10 rounded-3 p-3" style="backdrop-filter: blur(4px);">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                            <i data-feather="calendar" class="text-white" style="width: 16px; height: 16px;"></i>
                        </div>
                        <div>
                            <span class="d-block text-white-50 font-11 text-uppercase letter-spacing-1">Bergabung Sejak</span>
                            <span class="fw-semibold text-white font-13">10 Jan 2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Keamanan / Password -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                <i data-feather="lock" class="text-danger me-2" style="width: 18px; height: 18px;"></i>
                <h5 class="card-title mb-0 fw-bold">Keamanan Akun</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('profil/password') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark font-13">Password Saat Ini</label>
                        <input type="password" class="form-control form-control-sm" name="old_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark font-13">Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="new_password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark font-13">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="confirm_password" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger fw-semibold">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function selectOption(inputId, textId, val) {
    document.getElementById(inputId).value = val;
    const txt = document.getElementById(textId);
    txt.innerText = val;
    txt.classList.remove('text-muted');
    txt.classList.add('text-dark', 'fw-semibold');
}

if (typeof feather !== 'undefined') {
    feather.replace();
}
</script>
<?= $this->endSection() ?>
