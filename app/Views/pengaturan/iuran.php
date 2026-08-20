<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<?php
$kebijakanAktif = $kebijakanAktif ?? [];
$nominalAktif = (int) ($kebijakanAktif['nominal'] ?? 50000);
$tempoAktif = (int) ($kebijakanAktif['tanggal_jatuh_tempo'] ?? 20);
$toleransiAktif = (int) ($kebijakanAktif['toleransi_macet'] ?? 2);
$berlakuAktif = $kebijakanAktif['berlaku_dari'] ?? date('Y-m-d');
$metodeBankAktif = null;
$metodeQrisAktif = null;
foreach (($metodePembayaran ?? []) as $metode) {
    if (($metode['jenis'] ?? '') === 'bank' && $metodeBankAktif === null) $metodeBankAktif = $metode;
    if (($metode['jenis'] ?? '') === 'qris' && $metodeQrisAktif === null) $metodeQrisAktif = $metode;
}
$atasNamaBank = $metodeBankAktif['atas_nama'] ?? ('Kas ' . trim(($wilayah['rt'] ?? '') . ' ' . ($wilayah['rw'] ?? '') . ' ' . ($wilayah['kelurahan'] ?? '')));
$namaMerchantQris = $metodeQrisAktif['atas_nama'] ?? ('KAS ' . trim(($wilayah['rt'] ?? '') . ' ' . ($wilayah['rw'] ?? '') . ' ' . ($wilayah['kelurahan'] ?? '')));
$nmidQris = $metodeQrisAktif['nomor'] ?? 'ID1024098234120';
?>
<div class="row g-4">
    <!-- ============================================================== -->
    <!-- KOLOM KIRI: PENGATURAN TARIF, JATUH TEMPO & RIWAYAT -->
    <!-- ============================================================== -->
    <div class="col-lg-7">
        <!-- Pengaturan Tarif & Kebijakan Iuran -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="card-title fw-bold mb-1">Pengaturan Tarif &amp; Jatuh Tempo Iuran</h4>
                    <p class="text-muted small mb-0">Atur besaran tarif iuran bulanan wajib, tanggal jatuh tempo penagihan, dan batas toleransi tunggakan warga RT.</p>
                </div>

                <!-- Kartu Status Kebijakan Aktif Saat Ini (High Contrast & Clear) -->
                <div class="p-3 bg-white rounded-3 border shadow-sm mb-4">
                    <div class="row g-3 text-center text-sm-start">
                        <div class="col-sm-4 border-end-sm">
                            <span class="text-dark fw-bold small d-block mb-1">Nominal Iuran Aktif</span>
                            <h4 class="fw-bold text-success mb-0">Rp <?= number_format($nominalAktif, 0, ',', '.') ?> <span class="fs-6 text-dark fw-medium">/ bulan</span></h4>
                        </div>
                        <div class="col-sm-4 border-end-sm">
                            <span class="text-dark fw-bold small d-block mb-1">Tanggal Jatuh Tempo</span>
                            <h4 class="fw-bold text-warning mb-0">Tanggal <?= $tempoAktif ?> <span class="fs-6 text-dark fw-medium">/ bulan</span></h4>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-dark fw-bold small d-block mb-1">Kategori Macet</span>
                            <h4 class="fw-bold text-danger mb-0"><?= $toleransiAktif ?> Bulan <span class="fs-6 text-dark fw-medium">ke atas</span></h4>
                        </div>
                    </div>
                </div>

                <form action="<?= base_url('pengaturan/iuran/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nominal">Nominal Iuran Bulanan (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" value="<?= esc($nominalAktif) ?>" placeholder="Contoh: 50000" required>
                            <span class="text-muted font-12">Besaran iuran pokok setiap kepala keluarga.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo Bulanan</label>
                            <select class="form-select" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" required>
                                <?php for ($d = 1; $d <= 28; $d++) : ?>
                                    <option value="<?= $d ?>" <?= ($d == $tempoAktif) ? 'selected' : '' ?>>
                                        Tanggal <?= $d ?> setiap bulan <?= ($d == $tempoAktif) ? '(Aktif Saat Ini)' : '' ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <span class="text-muted font-12">Batas akhir pembayaran sebelum masuk pengingat WA.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="toleransi_macet">Batas Kategori Status Macet</label>
                            <select class="form-select" id="toleransi_macet" name="toleransi_macet">
                                <?php for ($t = 2; $t <= 6; $t++): ?><option value="<?= $t ?>" <?= $t === $toleransiAktif ? 'selected' : '' ?>><?= $t ?> Bulan Menunggak<?= $t === 2 ? ' (Standar)' : '' ?></option><?php endfor; ?>
                            </select>
                            <span class="text-muted font-12">Kriteria warga otomatis masuk kategori macet.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="berlaku_dari">Mulai Berlaku Tanggal</label>
                            <input type="date" class="form-control" id="berlaku_dari" name="berlaku_dari" value="<?= esc($berlakuAktif) ?>" required>
                            <span class="text-muted font-12">Waktu kebijakan baru mulai diberlakukan.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-success fw-semibold px-4">Simpan Kebijakan Iuran</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Perubahan Tarif & Kebijakan Iuran (Audit Trail) -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Riwayat Perubahan Kebijakan Iuran</h5>
                        <p class="text-muted small mb-0">Log audit riwayat penyesuaian tarif iuran oleh pengurus RT.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nominal</th>
                                <th class="text-nowrap">Jatuh Tempo</th>
                                <th class="text-nowrap">Mulai Berlaku</th>
                                <th class="text-nowrap">Diubah Oleh (Akun)</th>
                                <th class="text-nowrap text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (($riwayatIuran ?? []) as $riwayat): ?>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Rp <?= number_format($riwayat['nominal'], 0, ',', '.') ?></td>
                                <td class="text-nowrap">Tanggal <?= esc($riwayat['tanggal_jatuh_tempo'] ?? '-') ?> / bulan</td>
                                <td class="text-nowrap"><?= date('d F Y', strtotime($riwayat['berlaku_dari'])) ?></td>
                                <td class="text-nowrap"><span class="text-dark fw-medium"><?= esc($riwayat['created_by_nama']) ?></span><small class="text-muted d-block font-11">Pengurus RT</small></td>
                                <?php $statusKebijakan = $riwayat['status_label'] ?? (!empty($riwayat['is_active']) ? 'Aktif' : 'Arsip'); ?>
                                <td class="text-center text-nowrap"><span class="badge <?= $statusKebijakan === 'Aktif' ? 'bg-success' : ($statusKebijakan === 'Terjadwal' ? 'bg-warning text-dark' : 'bg-secondary') ?>"><?= esc($statusKebijakan) ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($riwayatIuran)): ?><tr><td colspan="5" class="text-center text-muted py-3">Belum ada riwayat kebijakan.</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- KOLOM KANAN: PENGATURAN WILAYAH ADMINISTRASI & REKENING / QRIS -->
    <!-- ============================================================== -->
    <div class="col-lg-5">
        <!-- Pengaturan Identitas & Wilayah RT Lengkap -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="card-title fw-bold mb-1">Pengaturan Wilayah RT</h4>
                    <p class="text-muted small mb-0">Identitas administratif wilayah dan manajemen daftar blok serta jalan.</p>
                </div>

                <form action="<?= base_url('pengaturan/iuran/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <!-- RT & RW -->
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="rt">Nomor RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" value="<?= esc($wilayah['rt'] ?? '') ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="rw">Nomor RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" value="<?= esc($wilayah['rw'] ?? '') ?>" required>
                        </div>

                        <!-- Kelurahan & Kecamatan -->
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="kelurahan">Kelurahan / Desa</label>
                            <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="<?= esc($wilayah['kelurahan'] ?? '') ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="kecamatan">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?= esc($wilayah['kecamatan'] ?? '') ?>" required>
                        </div>

                        <!-- Kota/Kabupaten & Provinsi -->
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="kota">Kota / Kabupaten</label>
                            <input type="text" class="form-control" id="kota" name="kota" value="<?= esc($wilayah['kota'] ?? '') ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="provinsi">Provinsi</label>
                            <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?= esc($wilayah['provinsi'] ?? '') ?>" required>
                        </div>

                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="ketua_id">Ketua RT</label>
                            <select class="form-select" id="ketua_id" name="ketua_id" required>
                                <option value="">Pilih Ketua RT</option>
                                <?php foreach ($pengurus as $person): ?>
                                    <option value="<?= esc($person['id']) ?>" <?= (int) $ketuaId === (int) $person['id'] ? 'selected' : '' ?>><?= esc($person['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="bendahara_id">Bendahara</label>
                            <select class="form-select" id="bendahara_id" name="bendahara_id" required>
                                <option value="">Pilih Bendahara</option>
                                <?php foreach ($pengurus as $person): ?>
                                    <option value="<?= esc($person['id']) ?>" <?= (int) $bendaharaId === (int) $person['id'] ? 'selected' : '' ?>><?= esc($person['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-success fw-semibold px-4 w-100">
                                Simpan Data Administrasi RT/RW
                            </button>
                        </div>
                    </div>
                </form>

                <div class="row g-3 mt-1">
                    <!-- ============================================================== -->
                    <!-- MANAJER BLOK RUMAH & MAKSIMAL NOMOR RUMAH -->
                    <!-- ============================================================== -->
                        <div class="col-12 pt-2 border-top">
                            <label class="form-label text-dark fw-bold small mb-2 d-flex justify-content-between align-items-center">
                                <span>Daftar Blok &amp; Kapasitas Nomor Rumah</span>
                                <span class="badge bg-light text-muted font-11">Pilihan Registrasi</span>
                            </label>
                            
                            <!-- Container Badge Chips Blok dengan Kapasitas Nomor -->
                            <div id="containerChipsBlok" class="d-flex flex-wrap gap-2 mb-3 p-2 bg-light rounded border">
                                <?php if(isset($master_blok) && !empty($master_blok)): ?>
                                    <?php foreach($master_blok as $blok): ?>
                                        <span class="badge bg-white text-dark border px-2 py-2 d-inline-flex align-items-center gap-1 font-12 shadow-sm chip-item" data-blok="<?= $blok['nama_blok'] ?>" data-max="<?= $blok['maks_nomor'] ?>">
                                            <strong><?= $blok['nama_blok'] ?></strong> <span class="text-muted font-11">(No. 01 - <?= sprintf('%02d', $blok['maks_nomor']) ?>)</span>
                                            <form action="<?= base_url('pengaturan/iuran/blok/delete/'.$blok['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus blok ini?');">
                                                <button type="submit" class="btn btn-link text-danger p-0 ms-1 text-decoration-none fw-bold border-0 bg-transparent">&times;</button>
                                            </form>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Input Form Tambah Blok dengan Jumlah Nomor Rumah (Lega & Rapi) -->
                            <form action="<?= base_url('pengaturan/iuran/blok/add') ?>" method="post">
                                <div class="p-2 bg-light rounded border mb-2">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-6">
                                            <label class="form-label text-dark fw-semibold font-11 mb-1" for="inputNewBlok">Nama Blok</label>
                                            <input type="text" class="form-control form-control-sm" name="nama_blok" id="inputNewBlok" placeholder="Cth: Blok E" required>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label text-dark fw-semibold font-11 mb-1" for="inputMaxNomor">Maks No.</label>
                                            <input type="number" class="form-control form-control-sm" name="maks_nomor" id="inputMaxNomor" placeholder="15" value="15" min="1" max="99" required>
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-sm btn-success fw-semibold w-100 font-12" type="submit">
                                                + Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- ============================================================== -->
                        <!-- MANAJER NAMA JALAN (INTERACTIVE CHIPS UI) -->
                        <!-- ============================================================== -->
                        <div class="col-12 pt-2 border-top">
                            <label class="form-label text-dark fw-bold small mb-2 d-flex justify-content-between align-items-center">
                                <span>Daftar Pilihan Nama Jalan</span>
                                <span class="badge bg-light text-muted font-11">Pilihan Registrasi</span>
                            </label>

                            <!-- Container Badge Chips Jalan -->
                            <div id="containerChipsJalan" class="d-flex flex-wrap gap-2 mb-3 p-2 bg-light rounded border">
                                <?php if(isset($master_jalan) && !empty($master_jalan)): ?>
                                    <?php foreach($master_jalan as $jalan): ?>
                                        <span class="badge bg-white text-dark border px-2 py-2 d-inline-flex align-items-center gap-1 font-12 shadow-sm chip-item">
                                            <?= $jalan['nama_jalan'] ?> 
                                            <form action="<?= base_url('pengaturan/iuran/jalan/delete/'.$jalan['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus jalan ini?');">
                                                <button type="submit" class="btn btn-link text-danger p-0 ms-1 text-decoration-none fw-bold border-0 bg-transparent">&times;</button>
                                            </form>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Input Form Tambah Jalan (Lega & Rapi) -->
                            <form action="<?= base_url('pengaturan/iuran/jalan/add') ?>" method="post">
                                <div class="p-2 bg-light rounded border">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-8">
                                            <label class="form-label text-dark fw-semibold font-11 mb-1" for="inputNewJalan">Nama Jalan Baru</label>
                                            <input type="text" class="form-control form-control-sm" name="nama_jalan" id="inputNewJalan" placeholder="Cth: Jl. Cempaka" required>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success fw-semibold w-100 font-12" type="submit">
                                                + Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- REKENING BANK & QRIS PEMBAYARAN KAS RT -->
        <!-- ============================================================== -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Rekening Bank &amp; QRIS RT</h5>
                        <p class="text-muted small mb-0">Metode transfer pembayaran iuran untuk seluruh warga.</p>
                    </div>
                </div>

                <?php foreach (($metodePembayaran ?? []) as $metode): ?>
                <div class="p-3 bg-white rounded-3 mb-3 border shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark font-14"><?= esc($metode['nama_metode']) ?></span>
                        <span class="badge <?= $metode['jenis'] === 'qris' ? 'bg-primary' : 'bg-success' ?>"><?= esc(strtoupper($metode['jenis'])) ?></span>
                    </div>
                    <?php if (!empty($metode['nomor'])): ?><span class="fs-5 text-dark fw-bold d-block"><?= esc($metode['nomor']) ?></span><?php endif; ?>
                    <?php if (!empty($metode['atas_nama'])): ?><small class="text-muted">a.n. <?= esc($metode['atas_nama']) ?></small><?php endif; ?>
                    <div class="d-flex gap-2 mt-2">
                        <button type="button" class="btn btn-xs btn-outline-warning" onclick="document.getElementById('edit-metode-<?= esc($metode['id']) ?>').classList.toggle('d-none')">Edit</button>
                        <form method="post" action="<?= base_url('pengaturan/iuran/metode/delete/' . $metode['id']) ?>" onsubmit="return confirm('Hapus metode pembayaran ini?');" class="d-inline">
                            <?= csrf_field() ?><button type="submit" class="btn btn-xs btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                    <div id="edit-metode-<?= esc($metode['id']) ?>" class="d-none mt-3 pt-3 border-top">
                        <form action="<?= base_url('pengaturan/iuran/metode/update/' . $metode['id']) ?>" method="post" enctype="multipart/form-data" class="row g-2">
                            <?= csrf_field() ?>
                            <div class="col-4"><select name="jenis" class="form-select form-select-sm"><option value="bank" <?= $metode['jenis'] === 'bank' ? 'selected' : '' ?>>Bank</option><option value="qris" <?= $metode['jenis'] === 'qris' ? 'selected' : '' ?>>QRIS</option><option value="ewallet" <?= $metode['jenis'] === 'ewallet' ? 'selected' : '' ?>>E-Wallet</option></select></div>
                            <div class="col-8"><input name="nama_metode" class="form-control form-control-sm" value="<?= esc($metode['nama_metode']) ?>" required></div>
                            <div class="col-6"><input name="nomor" class="form-control form-control-sm" value="<?= esc($metode['nomor'] ?? '') ?>" placeholder="Nomor / NMID"></div>
                            <div class="col-6"><input name="atas_nama" class="form-control form-control-sm" value="<?= esc($metode['atas_nama'] ?? '') ?>" placeholder="Atas nama"></div>
                            <div class="col-8"><input name="detail" class="form-control form-control-sm" value="<?= esc($metode['detail'] ?? '') ?>" placeholder="Keterangan"></div>
                            <div class="col-4"><input type="file" name="gambar" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp"></div>
                            <div class="col-12"><button class="btn btn-warning btn-sm w-100" type="submit">Simpan Perubahan</button></div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
                <form action="<?= base_url('pengaturan/iuran/metode/store') ?>" method="post" enctype="multipart/form-data" class="border rounded p-3 bg-light">
                    <?= csrf_field() ?><h6 class="fw-bold mb-3">Tambah Metode Pembayaran</h6>
                    <div class="row g-2">
                        <div class="col-4"><select name="jenis" class="form-select form-select-sm" required><option value="bank">Bank</option><option value="qris">QRIS</option><option value="ewallet">E-Wallet</option></select></div>
                        <div class="col-8"><input name="nama_metode" class="form-control form-control-sm" placeholder="Nama metode" required></div>
                        <div class="col-6"><input name="nomor" class="form-control form-control-sm" placeholder="Nomor rekening / NMID"></div>
                        <div class="col-6"><input name="atas_nama" class="form-control form-control-sm" placeholder="Atas nama"></div>
                        <div class="col-8"><input name="detail" class="form-control form-control-sm" placeholder="Keterangan"></div>
                        <div class="col-4"><input type="file" name="gambar" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp"></div>
                        <div class="col-12"><button class="btn btn-success btn-sm w-100" type="submit">Tambah Metode</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL KELOLA REKENING BANK & UPLOAD QRIS RT -->
<!-- ============================================================== -->
<div class="modal fade" id="modalKelolaRekening" tabindex="-1" aria-labelledby="modalKelolaRekeningLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalKelolaRekeningLabel">
                    <i data-feather="settings" class="feather-icon me-2 text-white" style="width: 18px; height: 18px;"></i>
                    Kelola Rekening Bank &amp; QRIS Kas RT
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Nav Tabs Modal (Bank vs QRIS) -->
                <ul class="nav nav-pills mb-4 nav-justified" id="pills-tab-payment" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="pills-bank-tab" data-bs-toggle="pill" data-bs-target="#pills-bank" type="button" role="tab">
                            1. Rekening Bank Transfer
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="pills-qris-tab" data-bs-toggle="pill" data-bs-target="#pills-qris" type="button" role="tab">
                            2. Unggah &amp; Kelola QRIS
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabPaymentContent">
                    <!-- TAB 1: FORM REKENING BANK -->
                    <div class="tab-pane fade show active" id="pills-bank" role="tabpanel">
                        <form action="#" method="post" id="formBankSettings">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold small mb-1" for="nama_bank">Nama Bank</label>
                                    <select class="form-select" id="nama_bank" name="nama_bank">
                                        <option value="BCA" selected>Bank Central Asia (BCA)</option>
                                        <option value="Mandiri">Bank Mandiri</option>
                                        <option value="BRI">Bank Rakyat Indonesia (BRI)</option>
                                        <option value="BNI">Bank Negara Indonesia (BNI)</option>
                                        <option value="BSI">Bank Syariah Indonesia (BSI)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold small mb-1" for="no_rekening">Nomor Rekening</label>
                                    <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="8830-1234-5678" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark fw-semibold small mb-1" for="atas_nama">Atas Nama Rekening</label>
                                    <input type="text" class="form-control" id="atas_nama" name="atas_nama" value="<?= esc($atasNamaBank) ?>" required>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- TAB 2: FORM QRIS RT -->
                    <div class="tab-pane fade" id="pills-qris" role="tabpanel">
                        <form action="#" method="post" enctype="multipart/form-data" id="formQrisSettings">
                            <div class="row g-3 align-items-start">
                                <div class="col-md-5 text-center">
                                    <div style="transform: scale(0.65); transform-origin: top center; margin-bottom: -150px;">
                                        <?= $this->include('components/qris_card') ?>
                                    </div>
                                    <small class="text-muted d-block mt-4 font-11">Pratinjau QRIS Aktif</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold small mb-1" for="nama_merchant">Nama Merchant QRIS</label>
                                        <input type="text" class="form-control" id="nama_merchant" name="nama_merchant" value="<?= esc($namaMerchantQris) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold small mb-1" for="nmid">NMID (Nomor Merchant ID)</label>
                                        <input type="text" class="form-control" id="nmid" name="nmid" value="<?= esc($nmidQris) ?>" required>
                                    </div>
                                    <div>
                                        <label class="form-label text-dark fw-semibold small mb-1" for="file_qris">Unggah File Gambar QRIS Baru</label>
                                        <input type="file" class="form-control" id="file_qris" name="file_qris" accept="image/png, image/jpeg, image/jpg, image/svg+xml">
                                        <span class="text-muted font-11">Format: JPG, PNG, atau SVG (Maks. 2MB).</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success fw-semibold px-4" onclick="savePaymentSettings()">
                    Simpan Metode Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL KONFIRMASI HAPUS MASTER BLOK / JALAN -->
<!-- ============================================================== -->
<div class="modal fade" id="modalKonfirmasiHapusWilayah" tabindex="-1" aria-labelledby="modalKonfirmasiHapusWilayahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalKonfirmasiHapusWilayahLabel">
                    <i data-feather="alert-triangle" class="feather-icon me-2 text-white" style="width: 18px; height: 18px;"></i>
                    Konfirmasi Hapus Data Master
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2 text-dark">Apakah Anda yakin ingin menghapus data master berikut dari pilihan registrasi warga?</p>
                <div class="p-3 bg-light rounded border mb-3">
                    <span class="badge bg-secondary mb-1" id="modalHapusWilayahJenis">Master Blok Pemukiman</span>
                    <h6 class="fw-bold text-dark mb-0 fs-6" id="modalHapusWilayahNama">Blok A (No. 01 - 15)</h6>
                </div>
                <div class="alert alert-warning font-12 py-2 px-3 mb-0">
                    <i data-feather="info" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Catatan: Data warga yang sudah terdaftar tidak akan hilang, namun opsi ini tidak akan muncul pada formulir pendaftaran warga baru.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger fw-semibold px-4" onclick="eksekusiHapusChipWilayah()">
                    Ya, Hapus Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script Tambah & Hapus Chip Blok & Jalan -->
<script>
let chipTargetToRemove = null;

function addNewBlokWithCapacity() {
    const inputBlok = document.getElementById('inputNewBlok');
    const inputMax = document.getElementById('inputMaxNomor');
    const blokVal = inputBlok.value.trim();
    const maxVal = inputMax.value.trim() || '15';

    if (!blokVal) {
        showAppToast('Silakan ketikkan nama blok terlebih dahulu.', 'warning', 'Nama Blok Kosong');
        return;
    }

    const container = document.getElementById('containerChipsBlok');
    const newSpan = document.createElement('span');
    newSpan.className = 'badge bg-white text-dark border px-2 py-2 d-inline-flex align-items-center gap-1 font-12 shadow-sm chip-item';
    newSpan.setAttribute('data-blok', blokVal);
    newSpan.setAttribute('data-max', maxVal);
    
    const formattedMax = String(maxVal).padStart(2, '0');
    newSpan.innerHTML = `<strong>${blokVal}</strong> <span class="text-muted font-11">(No. 01 - ${formattedMax})</span> <a href="javascript:void(0)" onclick="removeChip(this, 'Master Blok Pemukiman')" class="text-danger ms-1 text-decoration-none fw-bold">&times;</a>`;

    container.appendChild(newSpan);
    inputBlok.value = '';
    inputMax.value = '';
    showAppToast(`Master blok ${blokVal} berhasil ditambahkan ke sistem.`, 'success', 'Blok Ditambahkan');
}

function addNewChip(inputId, containerId) {
    const input = document.getElementById(inputId);
    const value = input.value.trim();
    if (!value) {
        showAppToast('Silakan ketikkan nama jalan terlebih dahulu.', 'warning', 'Nama Jalan Kosong');
        return;
    }

    const container = document.getElementById(containerId);
    const newSpan = document.createElement('span');
    newSpan.className = 'badge bg-white text-dark border px-2 py-2 d-inline-flex align-items-center gap-1 font-12 shadow-sm chip-item';
    newSpan.innerHTML = value + ` <a href="javascript:void(0)" onclick="removeChip(this, 'Master Nama Jalan')" class="text-danger ms-1 text-decoration-none fw-bold">&times;</a>`;

    container.appendChild(newSpan);
    input.value = '';
    showAppToast(`Master nama jalan ${value} berhasil ditambahkan.`, 'success', 'Jalan Ditambahkan');
}

function removeChip(element, jenis) {
    const chip = element.closest('.chip-item');
    if (!chip) return;
    
    chipTargetToRemove = chip;
    
    // Ambil teks label dari chip (hilangkan tanda x)
    const labelClone = chip.cloneNode(true);
    const closeBtn = labelClone.querySelector('a');
    if (closeBtn) closeBtn.remove();
    const cleanText = labelClone.textContent.trim();

    document.getElementById('modalHapusWilayahJenis').textContent = jenis || 'Data Master Wilayah';
    document.getElementById('modalHapusWilayahNama').textContent = cleanText;

    const modalEl = document.getElementById('modalKonfirmasiHapusWilayah');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
    
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

function eksekusiHapusChipWilayah() {
    if (chipTargetToRemove) {
        chipTargetToRemove.remove();
        chipTargetToRemove = null;
        showAppToast('Data master wilayah berhasil dihapus.', 'info', 'Data Terhapus');
    }
    const modalEl = document.getElementById('modalKonfirmasiHapusWilayah');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }
}

function savePaymentSettings() {
    showAppToast('Pengaturan Rekening Bank & QRIS Kas RT berhasil diperbarui!', 'success', 'Metode Bayar Disimpan');
    const modalEl = document.getElementById('modalKelolaRekening');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }
}
</script>

<?= $this->endSection() ?>
