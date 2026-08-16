<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-7">
        <!-- Pengaturan Tarif & Kebijakan Iuran -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="card-title fw-bold mb-1">Pengaturan Tarif &amp; Jatuh Tempo Iuran</h4>
                    <p class="text-muted small mb-0">Atur besaran tarif iuran bulanan wajib, tanggal jatuh tempo penagihan, dan toleransi tunggakan warga RT.</p>
                </div>

                <!-- Kartu Status Kebijakan Aktif Saat Ini -->
                <div class="p-3 bg-light rounded mb-4">
                    <div class="row g-3">
                        <div class="col-sm-4 border-end">
                            <span class="text-muted small d-block mb-1">Nominal Iuran Aktif</span>
                            <h4 class="fw-bold text-success mb-0">Rp 50.000 <span class="fs-6 text-muted fw-normal">/ bln</span></h4>
                        </div>
                        <div class="col-sm-4 border-end">
                            <span class="text-muted small d-block mb-1">Tanggal Jatuh Tempo</span>
                            <h4 class="fw-bold text-dark mb-0">Tgl 20 <span class="fs-6 text-muted fw-normal">/ bulan</span></h4>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted small d-block mb-1">Kategori Macet</span>
                            <h4 class="fw-bold text-danger mb-0">2 Bulan <span class="fs-6 text-muted fw-normal">ke atas</span></h4>
                        </div>
                    </div>
                </div>

                <form action="<?= base_url('pengaturan/iuran/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="nominal">Nominal Iuran Bulanan (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" value="50000" placeholder="Contoh: 50000" required>
                            <span class="text-muted font-12">Besaran iuran pokok setiap kepala keluarga.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo Bulanan</label>
                            <select class="form-select" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" required>
                                <?php for ($d = 1; $d <= 28; $d++) : ?>
                                    <option value="<?= $d ?>" <?= ($d == 20) ? 'selected' : '' ?>>
                                        Tanggal <?= $d ?> setiap bulan <?= ($d == 20) ? '(Aktif Saat Ini)' : '' ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <span class="text-muted font-12">Batas akhir pembayaran sebelum masuk pengingat WA.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="toleransi_macet">Batas Kategori Status Macet</label>
                            <select class="form-select" id="toleransi_macet" name="toleransi_macet">
                                <option value="2" selected>2 Bulan Menunggak (Direkomendasikan)</option>
                                <option value="3">3 Bulan Menunggak</option>
                                <option value="4">4 Bulan Menunggak</option>
                            </select>
                            <span class="text-muted font-12">Kriteria warga otomatis masuk kategori macet.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="berlaku_dari">Mulai Berlaku Tanggal</label>
                            <input type="date" class="form-control" id="berlaku_dari" name="berlaku_dari" value="<?= date('Y-m-d') ?>" required>
                            <span class="text-muted font-12">Waktu kebijakan baru mulai diberlakukan.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-success fw-semibold px-4">Simpan Kebijakan Iuran</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Perubahan Tarif & Kebijakan Iuran -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Riwayat Perubahan Kebijakan Iuran</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Nominal</th>
                                <th class="text-nowrap">Jatuh Tempo</th>
                                <th class="text-nowrap">Mulai Berlaku</th>
                                <th class="text-nowrap">Diubah Oleh</th>
                                <th class="text-nowrap text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Rp 50.000</td>
                                <td class="text-nowrap">Tgl 20 / bln</td>
                                <td class="text-nowrap">01 Jan 2026</td>
                                <td class="text-nowrap">Ketua RT</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Rp 40.000</td>
                                <td class="text-nowrap">Tgl 15 / bln</td>
                                <td class="text-nowrap">01 Jan 2025</td>
                                <td class="text-nowrap">Ketua RT</td>
                                <td class="text-center text-nowrap"><span class="badge bg-secondary">Arsip</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaturan Identitas & Wilayah RT -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="card-title fw-bold mb-1">Pengaturan Wilayah RT</h4>
                    <p class="text-muted small mb-0">Kelola identitas RT/RW serta daftar pilihan blok dan jalan yang tersedia untuk formulir warga.</p>
                </div>

                <form action="#" method="post">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="rt">Nomor RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" value="RT 04" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small mb-1" for="rw">Nomor RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" value="RW 12" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="daftar_blok">Daftar Pilihan Blok Rumah</label>
                            <input type="text" class="form-control" id="daftar_blok" name="daftar_blok" value="Blok A, Blok B, Blok C, Blok D" placeholder="Pisahkan dengan koma">
                            <span class="text-muted font-12">Pilihan yang akan muncul di dropdown registrasi warga.</span>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-dark fw-semibold small mb-1" for="daftar_jalan">Daftar Pilihan Nama Jalan</label>
                            <input type="text" class="form-control" id="daftar_jalan" name="daftar_jalan" value="Jl. Mawar, Jl. Melati, Jl. Anggrek, Jl. Kenanga" placeholder="Pisahkan dengan koma">
                            <span class="text-muted font-12">Pilihan nama jalan yang masuk ke wilayah RT ini.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-success fw-semibold px-4" onclick="alert('Demo: Data wilayah berhasil diperbarui!')">Simpan Data Wilayah</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rekening Bank Pembayaran Kas RT -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-3">
                    <h5 class="fw-bold mb-1">Rekening Tujuan Pembayaran</h5>
                    <p class="text-muted small mb-0">Informasi rekening yang akan ditampilkan saat warga melakukan konfirmasi transfer iuran.</p>
                </div>

                <div class="p-3 bg-light rounded mb-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark">Bank Central Asia (BCA)</span>
                        <span class="badge bg-success">Utama</span>
                    </div>
                    <span class="fs-5 text-dark fw-semibold d-block">8830-1234-5678</span>
                    <small class="text-muted">a.n Kas RT 04 RW 12</small>
                </div>

                <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="alert('Demo: Ubah rekening pembayaran')">
                    Kelola Rekening Bank &amp; QRIS
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
