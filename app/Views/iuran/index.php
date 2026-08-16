<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- ============================================================== -->
<!-- 1. RINGKASAN STATUS KAS IURAN BULAN INI (AGUSTUS 2026) -->
<!-- ============================================================== -->
<div class="row g-3 mb-4">
    <!-- Menunggu Verifikasi -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-warning border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-dark fw-semibold font-12 d-block mb-1">Menunggu Verifikasi</span>
                    <h4 class="text-dark fw-bold mb-0">2 Warga</h4>
                    <small class="text-warning fw-bold font-12">Total: Rp 200.000</small>
                </div>
                <div class="btn-group-vertical">
                    <button class="btn btn-sm btn-outline-warning fw-bold px-2 py-1 font-11" onclick="pilihTabIuran('pills-verif-tab')">
                        Proses
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sudah Lunas -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-dark fw-semibold font-12 d-block mb-1">Sudah Lunas (Agt 2026)</span>
                    <h4 class="text-success fw-bold mb-0">44 KK <span class="fs-6 text-muted fw-normal">(88%)</span></h4>
                    <small class="text-success fw-semibold font-12">Terkumpul: Rp 2.200.000</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Belum Bayar (Bulan Berjalan) -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-dark fw-semibold font-12 d-block mb-1">Belum Bayar (Bulan Ini)</span>
                    <h4 class="text-dark fw-bold mb-0">2 KK</h4>
                    <small class="text-muted font-12">Jatuh tempo: 20 Agu 2026</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Macet (2 Bulan Ke Atas) -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-dark fw-semibold font-12 d-block mb-1">Macet (2 Bln Ke Atas)</span>
                    <h4 class="text-danger fw-bold mb-0">2 KK</h4>
                    <small class="text-danger fw-semibold font-12">Tunggakan: Rp 250.000</small>
                </div>
                <button class="btn btn-sm btn-outline-danger fw-bold px-2 py-1 font-11" onclick="pilihTabIuran('pills-tunggakan-tab')">
                    Tagih
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- 2. DAFTAR TRANSAKSI & MONITORING TAGIHAN BERBASIS ALUR KERJA -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                
                <!-- Toolbar Header & Filter Periode -->
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Daftar Tagihan &amp; Pembayaran Iuran</h4>
                        <p class="text-muted small mb-0">Kelola validasi bukti pembayaran warga dan pantau ketertiban iuran RT.</p>
                    </div>

                    <!-- Filter Periode & Blok -->
                    <div class="d-flex flex-wrap align-items-center gap-2 w-100 w-lg-auto">
                        <select class="form-select form-select-sm" style="min-width: 130px; flex: 1 1 auto;">
                            <option selected>Agustus 2026</option>
                            <option>Juli 2026</option>
                            <option>Juni 2026</option>
                        </select>
                        <select class="form-select form-select-sm" style="min-width: 120px; flex: 1 1 auto;" id="filterBlokSelect" onchange="filterTabelPerBlok(this.value)">
                            <option value="all" selected>Semua Blok</option>
                            <option value="Blok A">Blok A</option>
                            <option value="Blok B">Blok B</option>
                            <option value="Blok C">Blok C</option>
                            <option value="Blok D">Blok D</option>
                        </select>
                    </div>
                </div>

                <!-- Nav Tabs Workflow-Based (Warna Aktif Kontekstual) -->
                <div class="nav-segment-container d-inline-flex p-1 rounded-pill mb-4">
                    <ul class="nav nav-pills border-0 gap-1" id="iuranWorkflowTab" role="tablist">
                        <!-- Tab 1: Menunggu Verifikasi (Kuning/Amber) -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active tab-verif fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-verif-tab" data-bs-toggle="pill" data-bs-target="#pills-verif" type="button" role="tab">
                                <i data-feather="clock" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Menunggu Verifikasi</span>
                                <span class="badge bg-warning text-dark font-11">2</span>
                            </button>
                        </li>
                        <!-- Tab 2: Tunggakan & Belum Bayar (Merah/Danger) -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-tunggakan fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-tunggakan-tab" data-bs-toggle="pill" data-bs-target="#pills-tunggakan" type="button" role="tab">
                                <i data-feather="alert-circle" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Tunggakan &amp; Belum Bayar</span>
                                <span class="badge bg-danger text-white font-11">4</span>
                            </button>
                        </li>
                        <!-- Tab 3: Sudah Lunas (Hijau/Success) -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-lunas fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-lunas-tab" data-bs-toggle="pill" data-bs-target="#pills-lunas" type="button" role="tab">
                                <i data-feather="check-circle" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Sudah Lunas</span>
                                <span class="badge bg-light text-dark font-11">44</span>
                            </button>
                        </li>
                        <!-- Tab 4: Semua Data (Slate/Gelap) -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-semua fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-semua-tab" data-bs-toggle="pill" data-bs-target="#pills-semua" type="button" role="tab">
                                <i data-feather="list" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Semua Data (50)</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Contents -->
                <div class="tab-content" id="iuranWorkflowTabContent">
                    
                    <!-- ============================================================== -->
                    <!-- TAB 1: MENUNGGU VERIFIKASI (BUTUH AKSI PENGURUS) -->
                    <!-- ============================================================== -->
                    <div class="tab-pane fade show active" id="pills-verif" role="tabpanel">
                        <div class="alert alert-warning py-2 px-3 small mb-3 d-flex align-items-center justify-content-between">
                            <span><i data-feather="info" class="feather-icon me-1" style="width: 14px; height: 14px;"></i> Ada <strong>2 bukti transfer warga</strong> yang perlu divalidasi oleh pengurus.</span>
                            <span class="badge bg-warning text-dark">Prioritas Verifikasi</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">Nama Warga</th>
                                        <th class="text-nowrap">Alamat Rumah</th>
                                        <th class="text-nowrap">Periode Bayar</th>
                                        <th class="text-nowrap">Nominal Transfer</th>
                                        <th class="text-nowrap">Waktu Upload</th>
                                        <th class="text-center text-nowrap" style="width: 150px;">Aksi Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Blok B: Hendra Wijaya -->
                                    <tr class="row-iuran" data-blok="Blok B">
                                        <td class="fw-semibold text-dark text-nowrap">Hendra Wijaya</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok B / No. 12</span>
                                            <small class="text-muted d-block">Jl. Melati</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Juni - Agustus 2026</span>
                                            <small class="text-muted d-block">3 Bulan Sekaligus</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-dark fs-6">Rp 150.000</span>
                                            <small class="text-muted d-block">Transfer BCA</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">16 Agu 2026</span>
                                            <small class="text-muted d-block font-11">09:15 WIB</small>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="<?= base_url('iuran/verifikasi/3') ?>" class="btn btn-sm btn-success fw-bold px-3 shadow-sm">
                                                Verifikasi Sekarang
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Blok A: Ahmad Fauzi -->
                                    <tr class="row-iuran" data-blok="Blok A">
                                        <td class="fw-semibold text-dark text-nowrap">Ahmad Fauzi</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok A / No. 02</span>
                                            <small class="text-muted d-block">Jl. Mawar</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Agustus 2026</span>
                                            <small class="text-muted d-block">1 Bulan</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-dark fs-6">Rp 50.000</span>
                                            <small class="text-muted d-block">Scan QRIS</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">15 Agu 2026</span>
                                            <small class="text-muted d-block font-11">14:30 WIB</small>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="<?= base_url('iuran/verifikasi/1') ?>" class="btn btn-sm btn-success fw-bold px-3 shadow-sm">
                                                Verifikasi Sekarang
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- TAB 2: TUNGGAKAN & BELUM BAYAR (FOKUS PENAGIHAN WA) -->
                    <!-- ============================================================== -->
                    <div class="tab-pane fade" id="pills-tunggakan" role="tabpanel">
                        <div class="alert alert-light border py-2 px-3 small mb-3 d-flex align-items-center justify-content-between">
                            <span>Daftar warga dari seluruh blok yang belum melunasi iuran untuk ditindaklanjuti via WA.</span>
                            <span class="text-danger fw-bold font-12">2 Macet • 2 Belum Bayar</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">Nama Warga</th>
                                        <th class="text-nowrap">Alamat Rumah</th>
                                        <th class="text-center text-nowrap">Kategori Status</th>
                                        <th class="text-nowrap">Total Tagihan</th>
                                        <th class="text-nowrap">Keterangan / Jatuh Tempo</th>
                                        <th class="text-center text-nowrap" style="width: 140px;">Tindak Lanjut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Blok A: Bambang Susanto (Macet 3 Bulan) -->
                                    <tr class="row-iuran" data-blok="Blok A">
                                        <td class="fw-semibold text-dark text-nowrap">Bambang Susanto</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok A / No. 04</span>
                                            <small class="text-muted d-block">Jl. Mawar</small>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <span class="badge bg-danger">Macet (3 Bulan)</span>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-danger fs-6">Rp 150.000</span>
                                            <small class="text-muted d-block">Juni, Juli, Agustus</small>
                                        </td>
                                        <td class="text-nowrap text-muted font-12">
                                            Menunggak 3 bulan berturut-turut
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="https://wa.me/6281234567892?text=Halo%20Bapak%20Bambang%2C%20mohon%20konfirmasi%20pembayaran%20kas%20RT%2004." target="_blank" class="btn btn-sm btn-outline-danger fw-semibold">
                                                Tagih WA
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Blok D: Eko Prasetyo (Macet 2 Bulan) -->
                                    <tr class="row-iuran" data-blok="Blok D">
                                        <td class="fw-semibold text-dark text-nowrap">Eko Prasetyo</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok D / No. 05</span>
                                            <small class="text-muted d-block">Jl. Kenanga</small>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <span class="badge bg-danger">Macet (2 Bulan)</span>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-danger fs-6">Rp 100.000</span>
                                            <small class="text-muted d-block">Juli &amp; Agustus 2026</small>
                                        </td>
                                        <td class="text-nowrap text-muted font-12">
                                            Menunggak 2 bulan
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="https://wa.me/6281234567898?text=Halo%20Bapak%20Eko%2C%20mohon%20konfirmasi%20pembayaran%20kas%20RT%2004." target="_blank" class="btn btn-sm btn-outline-danger fw-semibold">
                                                Tagih WA
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Blok A: Farros Rifantiarno (Belum Bayar Bulan Berjalan) -->
                                    <tr class="row-iuran" data-blok="Blok A">
                                        <td class="fw-semibold text-dark text-nowrap">Farros Rifantiarno</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok A / No. 01</span>
                                            <small class="text-muted d-block">Jl. Mawar</small>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <span class="badge bg-warning text-dark">Belum Bayar</span>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-dark fs-6">Rp 50.000</span>
                                            <small class="text-muted d-block">Agustus 2026</small>
                                        </td>
                                        <td class="text-nowrap text-dark font-12">
                                            Bulan berjalan (Jatuh tempo 20 Agu)
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="https://wa.me/6281234567890?text=Halo%20Mas%20Farros%2C%20ini%20pengingat%20iuran%20kas%20RT%20bulan%20Agustus." target="_blank" class="btn btn-sm btn-outline-success fw-semibold">
                                                Kirim WA
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Blok C: Budi Santoso (Belum Bayar Bulan Berjalan) -->
                                    <tr class="row-iuran" data-blok="Blok C">
                                        <td class="fw-semibold text-dark text-nowrap">Budi Santoso</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok C / No. 10</span>
                                            <small class="text-muted d-block">Jl. Anggrek</small>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <span class="badge bg-warning text-dark">Belum Bayar</span>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-dark fs-6">Rp 50.000</span>
                                            <small class="text-muted d-block">Agustus 2026</small>
                                        </td>
                                        <td class="text-nowrap text-dark font-12">
                                            Bulan berjalan (Jatuh tempo 20 Agu)
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="https://wa.me/6281234567894" target="_blank" class="btn btn-sm btn-outline-success fw-semibold">
                                                Kirim WA
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- TAB 3: SUDAH LUNAS (ARSIP SELESAI DARI BLOK A - D) -->
                    <!-- ============================================================== -->
                    <div class="tab-pane fade" id="pills-lunas" role="tabpanel">
                        <div class="alert alert-success py-2 px-3 small mb-3 d-flex align-items-center justify-content-between">
                            <span><i data-feather="check" class="feather-icon me-1" style="width: 14px; height: 14px;"></i> Total <strong>44 transaksi warga</strong> telah lunas dan terverifikasi untuk kas bulan ini.</span>
                            <span class="fw-bold text-success">Total: Rp 2.200.000</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">Nama Warga</th>
                                        <th class="text-nowrap">Alamat Rumah</th>
                                        <th class="text-nowrap">Periode Bayar</th>
                                        <th class="text-nowrap">Nominal Lunas</th>
                                        <th class="text-nowrap">Tanggal Validasi</th>
                                        <th class="text-center text-nowrap" style="width: 130px;">Bukti / Kuitansi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Blok B: Rina Marlina -->
                                    <tr class="row-iuran" data-blok="Blok B">
                                        <td class="fw-semibold text-dark text-nowrap">Rina Marlina</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok B / No. 06</span>
                                            <small class="text-muted d-block">Jl. Melati</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Juli &amp; Agustus 2026</span>
                                            <small class="text-muted d-block">2 Bulan</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-success fs-6">Rp 100.000</span>
                                            <span class="badge bg-success font-11 ms-1">Lunas</span>
                                        </td>
                                        <td class="text-nowrap text-dark font-12">
                                            10 Agu 2026 (Pengurus RT)
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="<?= base_url('iuran/kuitansi/2') ?>" class="btn btn-sm btn-outline-secondary">
                                                Lihat Kuitansi
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Blok C: Siti Aminah -->
                                    <tr class="row-iuran" data-blok="Blok C">
                                        <td class="fw-semibold text-dark text-nowrap">Siti Aminah</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok C / No. 03</span>
                                            <small class="text-muted d-block">Jl. Anggrek</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Agustus 2026</span>
                                            <small class="text-muted d-block">1 Bulan</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-success fs-6">Rp 50.000</span>
                                            <span class="badge bg-success font-11 ms-1">Lunas</span>
                                        </td>
                                        <td class="text-nowrap text-dark font-12">
                                            08 Agu 2026 (Pengurus RT)
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="<?= base_url('iuran/kuitansi/2') ?>" class="btn btn-sm btn-outline-secondary">
                                                Lihat Kuitansi
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Blok D: Dedi Supardi -->
                                    <tr class="row-iuran" data-blok="Blok D">
                                        <td class="fw-semibold text-dark text-nowrap">Dedi Supardi</td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Blok D / No. 02</span>
                                            <small class="text-muted d-block">Jl. Kenanga</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-dark fw-medium">Agustus 2026</span>
                                            <small class="text-muted d-block">1 Bulan</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="fw-bold text-success fs-6">Rp 50.000</span>
                                            <span class="badge bg-success font-11 ms-1">Lunas</span>
                                        </td>
                                        <td class="text-nowrap text-dark font-12">
                                            05 Agu 2026 (Pengurus RT)
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="<?= base_url('iuran/kuitansi/2') ?>" class="btn btn-sm btn-outline-secondary">
                                                Lihat Kuitansi
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- TAB 4: BUKU KAS REGISTER IURAN PER BLOK (ACCORDION BUKA-TUTUP) -->
                    <!-- ============================================================== -->
                    <div class="tab-pane fade" id="pills-semua" role="tabpanel">
                        <!-- Toolbar Buku Kas -->
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
                            <div>
                                <span class="fw-bold text-dark font-14">Buku Register Kas Iuran RT 04 (Periode Agustus 2026)</span>
                                <small class="text-muted d-block">Urutan berdasar nomor rumah dari Blok A s.d Blok D.</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-xs btn-outline-secondary" type="button" onclick="toggleAllIuranBlocks(true)">
                                    Buka Semua
                                </button>
                                <button class="btn btn-xs btn-outline-secondary" type="button" onclick="toggleAllIuranBlocks(false)">
                                    Tutup Semua
                                </button>
                            </div>
                        </div>

                        <!-- Accordion Buku Kas Iuran Per Blok -->
                        <div class="accordion d-flex flex-column gap-3" id="accordionIuranBukuKas">
                            
                            <!-- 1. BUKU KAS BLOK A -->
                            <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-iuran-blok" id="iuran-blok-a">
                                <h2 class="accordion-header" id="headingIuranBlokA">
                                    <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIuranBlokA" aria-expanded="true">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="fw-bold text-dark fs-6">Blok A</span>
                                            <span class="text-muted font-12 fw-normal ms-2">(15 Rumah • Terkumpul Rp 650.000 / Rp 750.000)</span>
                                        </div>
                                        <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                            <span class="badge bg-warning text-dark">1 Verifikasi</span>
                                            <span class="badge bg-warning text-dark">1 Belum</span>
                                            <span class="badge bg-danger">1 Macet</span>
                                            <span class="badge bg-success">12 Lunas</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseIuranBlokA" class="accordion-collapse collapse show">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-nowrap ps-4" style="width: 110px;">No. Rumah</th>
                                                        <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                        <th class="text-nowrap">Periode Tagihan</th>
                                                        <th class="text-nowrap">Nominal (Rp)</th>
                                                        <th class="text-center text-nowrap">Status Kas</th>
                                                        <th class="text-nowrap">Keterangan</th>
                                                        <th class="text-center text-nowrap" style="width: 130px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 01</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Farros Rifantiarno</td>
                                                        <td class="text-nowrap">Agustus 2026</td>
                                                        <td class="fw-bold text-dark text-nowrap">Rp 50.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Jatuh tempo 20 Agu</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-xs btn-outline-success">Kirim WA</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 02</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Ahmad Fauzi</td>
                                                        <td class="text-nowrap">Agustus 2026</td>
                                                        <td class="fw-bold text-dark text-nowrap">Rp 50.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Menunggu Verifikasi</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Scan QRIS (15 Agu)</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="<?= base_url('iuran/verifikasi/1') ?>" class="btn btn-xs btn-success">Verifikasi</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 04</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Bambang Susanto</td>
                                                        <td class="text-nowrap">Juni - Agt 2026</td>
                                                        <td class="fw-bold text-danger text-nowrap">Rp 150.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-danger">Macet (3 Bln)</span></td>
                                                        <td class="text-danger font-12 text-nowrap">Tunggakan 3 bulan</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="https://wa.me/6281234567892" target="_blank" class="btn btn-xs btn-outline-danger">Tagih WA</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 05</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Mulyono</td>
                                                        <td class="text-nowrap">Agustus 2026</td>
                                                        <td class="fw-bold text-success text-nowrap">Rp 50.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Lunas (03 Agu)</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="<?= base_url('iuran/kuitansi/2') ?>" class="btn btn-xs btn-outline-secondary">Kuitansi</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. BUKU KAS BLOK B -->
                            <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-iuran-blok" id="iuran-blok-b">
                                <h2 class="accordion-header" id="headingIuranBlokB">
                                    <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIuranBlokB" aria-expanded="true">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="fw-bold text-dark fs-6">Blok B</span>
                                            <span class="text-muted font-12 fw-normal ms-2">(12 Rumah • Terkumpul Rp 550.000 / Rp 600.000)</span>
                                        </div>
                                        <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                            <span class="badge bg-warning text-dark">1 Verifikasi</span>
                                            <span class="badge bg-success">11 Lunas</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseIuranBlokB" class="accordion-collapse collapse show">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-nowrap ps-4" style="width: 110px;">No. Rumah</th>
                                                        <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                        <th class="text-nowrap">Periode Tagihan</th>
                                                        <th class="text-nowrap">Nominal (Rp)</th>
                                                        <th class="text-center text-nowrap">Status Kas</th>
                                                        <th class="text-nowrap">Keterangan</th>
                                                        <th class="text-center text-nowrap" style="width: 130px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 06</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Rina Marlina</td>
                                                        <td class="text-nowrap">Juli &amp; Agt 2026</td>
                                                        <td class="fw-bold text-success text-nowrap">Rp 100.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Lunas (10 Agu)</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="<?= base_url('iuran/kuitansi/2') ?>" class="btn btn-xs btn-outline-secondary">Kuitansi</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 12</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Hendra Wijaya</td>
                                                        <td class="text-nowrap">Juni - Agt 2026</td>
                                                        <td class="fw-bold text-dark text-nowrap">Rp 150.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Menunggu Verifikasi</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Transfer BCA (16 Agu)</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="<?= base_url('iuran/verifikasi/3') ?>" class="btn btn-xs btn-success">Verifikasi</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. BUKU KAS BLOK C -->
                            <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-iuran-blok" id="iuran-blok-c">
                                <h2 class="accordion-header" id="headingIuranBlokC">
                                    <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIuranBlokC" aria-expanded="true">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="fw-bold text-dark fs-6">Blok C</span>
                                            <span class="text-muted font-12 fw-normal ms-2">(13 Rumah • Terkumpul Rp 550.000 / Rp 650.000)</span>
                                        </div>
                                        <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                            <span class="badge bg-warning text-dark">1 Belum</span>
                                            <span class="badge bg-success">12 Lunas</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseIuranBlokC" class="accordion-collapse collapse show">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-nowrap ps-4" style="width: 110px;">No. Rumah</th>
                                                        <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                        <th class="text-nowrap">Periode Tagihan</th>
                                                        <th class="text-nowrap">Nominal (Rp)</th>
                                                        <th class="text-center text-nowrap">Status Kas</th>
                                                        <th class="text-nowrap">Keterangan</th>
                                                        <th class="text-center text-nowrap" style="width: 130px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 03</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Siti Aminah</td>
                                                        <td class="text-nowrap">Agustus 2026</td>
                                                        <td class="fw-bold text-success text-nowrap">Rp 50.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Lunas (08 Agu)</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="<?= base_url('iuran/kuitansi/2') ?>" class="btn btn-xs btn-outline-secondary">Kuitansi</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 10</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Budi Santoso</td>
                                                        <td class="text-nowrap">Agustus 2026</td>
                                                        <td class="fw-bold text-dark text-nowrap">Rp 50.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Jatuh tempo 20 Agu</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="https://wa.me/6281234567894" target="_blank" class="btn btn-xs btn-outline-success">Kirim WA</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. BUKU KAS BLOK D -->
                            <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-iuran-blok" id="iuran-blok-d">
                                <h2 class="accordion-header" id="headingIuranBlokD">
                                    <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIuranBlokD" aria-expanded="true">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="fw-bold text-dark fs-6">Blok D</span>
                                            <span class="text-muted font-12 fw-normal ms-2">(10 Rumah • Terkumpul Rp 450.000 / Rp 500.000)</span>
                                        </div>
                                        <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                            <span class="badge bg-danger">1 Macet</span>
                                            <span class="badge bg-success">9 Lunas</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseIuranBlokD" class="accordion-collapse collapse show">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-nowrap ps-4" style="width: 110px;">No. Rumah</th>
                                                        <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                        <th class="text-nowrap">Periode Tagihan</th>
                                                        <th class="text-nowrap">Nominal (Rp)</th>
                                                        <th class="text-center text-nowrap">Status Kas</th>
                                                        <th class="text-nowrap">Keterangan</th>
                                                        <th class="text-center text-nowrap" style="width: 130px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 02</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Dedi Supardi</td>
                                                        <td class="text-nowrap">Agustus 2026</td>
                                                        <td class="fw-bold text-success text-nowrap">Rp 50.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                                        <td class="text-muted font-12 text-nowrap">Lunas (05 Agu)</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="<?= base_url('iuran/kuitansi/2') ?>" class="btn btn-xs btn-outline-secondary">Kuitansi</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark text-nowrap">No. 05</td>
                                                        <td class="fw-semibold text-dark text-nowrap">Eko Prasetyo</td>
                                                        <td class="text-nowrap">Juli &amp; Agt 2026</td>
                                                        <td class="fw-bold text-danger text-nowrap">Rp 100.000</td>
                                                        <td class="text-center text-nowrap"><span class="badge bg-danger">Macet (2 Bln)</span></td>
                                                        <td class="text-danger font-12 text-nowrap">Tunggakan 2 bulan</td>
                                                        <td class="text-center text-nowrap pe-4">
                                                            <a href="https://wa.me/6281234567898" target="_blank" class="btn btn-xs btn-outline-danger">Tagih WA</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
function pilihTabIuran(tabBtnId) {
    const tabEl = document.getElementById(tabBtnId);
    if (tabEl) {
        const tab = new bootstrap.Tab(tabEl);
        tab.show();
    }
}

function filterTabelPerBlok(blokVal) {
    // 1. Filter baris tabel di Tab 1, 2, 3
    const rows = document.querySelectorAll('.row-iuran');
    rows.forEach(row => {
        if (blokVal === 'all' || row.getAttribute('data-blok') === blokVal) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });

    // 2. Filter accordion di Tab 4 (Buku Kas)
    const blocks = document.querySelectorAll('.item-iuran-blok');
    blocks.forEach(b => {
        if (blokVal === 'all') {
            b.style.display = 'block';
        } else {
            const mapBlokId = {
                'Blok A': 'iuran-blok-a',
                'Blok B': 'iuran-blok-b',
                'Blok C': 'iuran-blok-c',
                'Blok D': 'iuran-blok-d'
            };
            if (b.id === mapBlokId[blokVal]) {
                b.style.display = 'block';
                const collapse = b.querySelector('.accordion-collapse');
                bootstrap.Collapse.getOrCreateInstance(collapse, { toggle: false }).show();
            } else {
                b.style.display = 'none';
            }
        }
    });
}

function toggleAllIuranBlocks(open) {
    const collapsibles = document.querySelectorAll('#accordionIuranBukuKas .accordion-collapse');
    collapsibles.forEach(c => {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(c, { toggle: false });
        if (open) {
            bsCollapse.show();
        } else {
            bsCollapse.hide();
        }
    });
}
</script>

<?= $this->endSection() ?>
