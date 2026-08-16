<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- ============================================================== -->
<!-- KOP SURAT FORMAL (Hanya Tampil Saat Cetak / Print) -->
<!-- ============================================================== -->
<div class="d-none d-print-block mb-4 pb-3 border-bottom text-center">
    <h3 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">RUKUN TETANGGA 04 / RUKUN WARGA 12</h3>
    <h5 class="fw-bold mb-1 text-uppercase">KELURAHAN SUKAMAJU, KECAMATAN COBLONG</h5>
    <p class="mb-0 small text-muted">Sekretariat: Balai Pertemuan RT 04, Jl. Mawar No. 01 • Telp/WA: 081234567890</p>
    <div class="mt-3 pt-2 border-top border-dark border-2">
        <h4 class="fw-bold mb-0 text-uppercase">LAPORAN PERTANGGUNGJAWABAN KAS BULAN AGUSTUS 2026</h4>
    </div>
</div>

<div class="row g-4">
    <!-- Header & Filter Periode Laporan (Disembunyikan saat cetak) -->
    <div class="col-12 d-print-none">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Laporan Rekapitulasi Kas RT</h4>
                        <p class="text-muted small mb-0">Transparansi alokasi pengeluaran, dokumentasi kegiatan, dan partisipasi iuran warga RT 04.</p>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form class="d-flex align-items-center gap-2 m-0" method="get" action="<?= base_url('laporan') ?>">
                            <select class="form-select form-select-sm" name="bulan" style="width: 110px;">
                                <option value="8" selected>Agustus</option>
                                <option value="7">Juli</option>
                                <option value="6">Juni</option>
                                <option value="5">Mei</option>
                            </select>
                            <select class="form-select form-select-sm" name="tahun" style="width: 85px;">
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success fw-semibold px-3">Filter</button>
                        </form>

                        <div class="vr mx-1 d-none d-sm-block"></div>

                        <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" onclick="window.print()">
                            <i data-feather="printer" class="feather-icon" style="width: 14px; height: 14px;"></i>
                            <span>Cetak PDF</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Angka Keuangan (4 Stat Cards Simetris) -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Pemasukan Iuran (Agt 2026)</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 4.500.000</h4>
                    <small class="text-success font-12 fw-semibold">42 Transaksi Warga Lunas</small>
                </div>
                <div class="bg-light rounded p-2 text-success d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="trending-up" class="feather-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Pengeluaran (Agt 2026)</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 1.850.000</h4>
                    <small class="text-danger font-12 fw-semibold">4 Kegiatan Lingkungan</small>
                </div>
                <div class="bg-light rounded p-2 text-danger d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="trending-down" class="feather-icon text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Surplus Kas (Dinamis: Hijau jika surplus, Merah jika defisit) -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Arus Kas (Surplus)</span>
                    <h4 class="text-success fw-bold mb-0 text-nowrap">+ Rp 2.650.000</h4>
                    <small class="text-muted font-12">Surplus Kas Bulan Ini</small>
                </div>
                <div class="bg-light rounded p-2 text-success d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="plus-circle" class="feather-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Saldo Kas RT Terkini</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 12.650.000</h4>
                    <small class="text-primary font-12 fw-semibold">Kas Kumulatif RT 04</small>
                </div>
                <div class="bg-light rounded p-2 text-primary d-flex align-items-center justify-content-center d-print-none" style="width: 42px; height: 42px;">
                    <i data-feather="shield" class="feather-icon text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- BAGIAN 1: RINCIAN PENGELUARAN KAS RT & BUKTI TRANSPARANSI (FULL-WIDTH) -->
    <!-- ============================================================== -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
                    <div>
                        <h4 class="card-title fw-bold mb-1">1. Rincian Pengeluaran Kas RT &amp; Dokumentasi</h4>
                        <p class="text-muted small mb-0">Pertanggungjawaban penggunaan dana kas RT untuk pemeliharaan fasilitas dan kegiatan warga.</p>
                    </div>
                    <span class="badge bg-success-subtle text-success-emphasis border border-success px-3 py-2 d-print-none">
                        Transparansi Terbuka Seluruh Warga
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="width: 50px;">No</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Pos Kategori</th>
                                <th class="text-nowrap">Rincian Keperluan / Kegiatan</th>
                                <th class="text-end text-nowrap">Nominal (Rp)</th>
                                <th class="text-center text-nowrap d-print-none">Bukti Nota</th>
                                <th class="text-center text-nowrap d-print-none">Foto Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap">1</td>
                                <td class="text-muted small text-nowrap">14 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Kas Operasional</td>
                                <td class="text-dark fw-medium text-nowrap">Pembelian lampu penerangan jalan gang RT 03</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 350.000</td>
                                <td class="text-center text-nowrap d-print-none">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="alert('Demo: Lihat Nota Lampu Gang')">Lihat Nota</button>
                                </td>
                                <td class="text-center text-nowrap d-print-none">
                                    <button class="btn btn-sm btn-outline-success py-0 px-2" onclick="alert('Demo: Lihat Foto Lampu Gang Terpasang')">Foto Hasil</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">2</td>
                                <td class="text-muted small text-nowrap">10 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Sosial</td>
                                <td class="text-dark fw-medium text-nowrap">Santunan warga sakit (Bpk. Mulyono)</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 500.000</td>
                                <td class="text-center text-nowrap d-print-none">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="alert('Demo: Lihat Kuitansi Santunan')">Lihat Kuitansi</button>
                                </td>
                                <td class="text-center text-nowrap d-print-none">
                                    <button class="btn btn-sm btn-outline-success py-0 px-2" onclick="alert('Demo: Lihat Foto Penyerahan Santunan')">Foto Penyerahan</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">3</td>
                                <td class="text-muted small text-nowrap">08 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Kas Operasional</td>
                                <td class="text-dark fw-medium text-nowrap">Kerja bakti &amp; perbaikan saluran gang Mawar</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 750.000</td>
                                <td class="text-center text-nowrap d-print-none">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="alert('Demo: Lihat Nota Material Semen & Pasir')">Lihat Nota</button>
                                </td>
                                <td class="text-center text-nowrap d-print-none">
                                    <button class="btn btn-sm btn-outline-success py-0 px-2" onclick="alert('Demo: Lihat Foto Warga Kerja Bakti')">Foto Kegiatan</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">4</td>
                                <td class="text-muted small text-nowrap">05 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Konsumsi</td>
                                <td class="text-dark fw-medium text-nowrap">Konsumsi snack rapat bulanan pengurus RT</td>
                                <td class="text-end fw-bold text-dark text-nowrap">Rp 250.000</td>
                                <td class="text-center text-nowrap d-print-none">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="alert('Demo: Lihat Struk Belanja Snack')">Lihat Struk</button>
                                </td>
                                <td class="text-center text-nowrap d-print-none">
                                    <span class="text-muted small">-</span>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end fw-bold text-dark">Total Realisasi Pengeluaran Agustus 2026:</th>
                                <th class="text-end fw-bold text-dark fs-6">Rp 1.850.000</th>
                                <th colspan="2" class="d-print-none"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- BAGIAN 2: REKAPITULASI PARTISIPASI & KEPATUHAN IURAN WARGA -->
    <!-- ============================================================== -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">2. Rekapitulasi Partisipasi Iuran Warga</h4>
                        <p class="text-muted small mb-0">Statistik kepatuhan warga dan monitoring penagihan iuran kas RT.</p>
                    </div>

                    <!-- Segmented Glassmorphism Tab Navigasi -->
                    <div class="nav-segment-container d-inline-flex p-1 rounded-pill d-print-none">
                        <ul class="nav nav-pills border-0 gap-1" id="laporanTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-1" id="publik-tab" data-bs-toggle="tab" data-bs-target="#publik" type="button" role="tab">
                                    <i data-feather="bar-chart-2" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                    <span>Statistik per Blok (Publik)</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-1" id="internal-tab" data-bs-toggle="tab" data-bs-target="#internal" type="button" role="tab">
                                    <i data-feather="lock" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                    <span>Data Lengkap Warga (Internal)</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content" id="laporanTabContent">
                    <!-- TAB 1: STATISTIK PARTISIPASI PER BLOK (TERBUKA & ETIS UNTUK PUBLIK WARGA) -->
                    <div class="tab-pane fade show active" id="publik" role="tabpanel">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0 font-14">Blok A</h6>
                                        <span class="badge bg-light text-dark border font-11">15 Rumah</span>
                                    </div>
                                    <h3 class="fw-bold text-success mb-2">87% <span class="fs-6 fw-normal text-muted font-12">Lunas</span></h3>
                                    <div class="d-flex align-items-center gap-1 font-12 pt-2 border-top">
                                        <span class="text-success fw-bold">13 Lunas</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-warning fw-bold text-dark">1 Belum</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-danger fw-bold">1 Macet</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0 font-14">Blok B</h6>
                                        <span class="badge bg-light text-dark border font-11">12 Rumah</span>
                                    </div>
                                    <h3 class="fw-bold text-success mb-2">92% <span class="fs-6 fw-normal text-muted font-12">Lunas</span></h3>
                                    <div class="d-flex align-items-center gap-1 font-12 pt-2 border-top">
                                        <span class="text-success fw-bold">11 Lunas</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-warning fw-bold text-dark">1 Belum</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-muted fw-semibold">0 Macet</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0 font-14">Blok C</h6>
                                        <span class="badge bg-light text-dark border font-11">13 Rumah</span>
                                    </div>
                                    <h3 class="fw-bold text-success mb-2">85% <span class="fs-6 fw-normal text-muted font-12">Lunas</span></h3>
                                    <div class="d-flex align-items-center gap-1 font-12 pt-2 border-top">
                                        <span class="text-success fw-bold">11 Lunas</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-warning fw-bold text-dark">2 Belum</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-muted fw-semibold">0 Macet</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0 font-14">Blok D</h6>
                                        <span class="badge bg-light text-dark border font-11">10 Rumah</span>
                                    </div>
                                    <h3 class="fw-bold text-success mb-2">90% <span class="fs-6 fw-normal text-muted font-12">Lunas</span></h3>
                                    <div class="d-flex align-items-center gap-1 font-12 pt-2 border-top">
                                        <span class="text-success fw-bold">9 Lunas</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-warning fw-bold text-dark">1 Belum</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-muted fw-semibold">0 Macet</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-light border d-flex align-items-center justify-content-between p-3 mb-0">
                            <div>
                                <span class="fw-bold text-dark d-block">Tingkat Partisipasi Iuran Warga RT 04:</span>
                                <small class="text-muted">Total 44 dari 50 Kepala Keluarga (88%) telah berpartisipasi dalam pembayaran iuran bulan ini.</small>
                            </div>
                            <span class="fs-4 fw-bold text-success">88%</span>
                        </div>
                    </div>

                    <!-- TAB 2: DATA LENGKAP WARGA (KHUSUS ARSIP INTERNAL PENGURUS RT) -->
                    <div class="tab-pane fade" id="internal" role="tabpanel">
                        <div class="alert alert-warning py-2 px-3 small mb-3 d-flex align-items-center justify-content-between">
                            <span><strong>Arsip Internal Pengurus:</strong> Data di bawah ini khusus digunakan untuk keperluan penagihan dan monitoring internal RT.</span>
                            <span class="badge bg-danger">3 Warga Macet</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">Nama Kepala Keluarga</th>
                                        <th class="text-nowrap">Alamat Rumah</th>
                                        <th class="text-center text-nowrap">Status Pembayaran</th>
                                        <th class="text-nowrap">Keterangan / Tindak Lanjut</th>
                                        <th class="text-center text-nowrap" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap">Farros Rifantiarno</td>
                                        <td class="text-nowrap text-dark fw-medium">Blok A / No. 01</td>
                                        <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                        <td class="text-muted small text-nowrap">Bulan berjalan (Jatuh tempo 20 Agu)</td>
                                        <td class="text-center text-nowrap">
                                            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-xs btn-outline-success">Tagih WA</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap">Ahmad Fauzi</td>
                                        <td class="text-nowrap text-dark fw-medium">Blok A / No. 02</td>
                                        <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                        <td class="text-muted small text-nowrap">Tepat waktu (15 Agu)</td>
                                        <td class="text-center text-nowrap"><span class="text-muted small">-</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap">Rina Marlina</td>
                                        <td class="text-nowrap text-dark fw-medium">Blok B / No. 06</td>
                                        <td class="text-center text-nowrap"><span class="badge bg-success">Lunas</span></td>
                                        <td class="text-muted small text-nowrap">Pelunasan 2 bulan (10 Agu)</td>
                                        <td class="text-center text-nowrap"><span class="text-muted small">-</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap">Budi Santoso</td>
                                        <td class="text-nowrap text-dark fw-medium">Blok C / No. 10</td>
                                        <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                        <td class="text-muted small text-nowrap">Bulan berjalan (Jatuh tempo 20 Agu)</td>
                                        <td class="text-center text-nowrap">
                                            <a href="https://wa.me/6281234567891" target="_blank" class="btn btn-xs btn-outline-success">Tagih WA</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap">Bambang Susanto</td>
                                        <td class="text-nowrap text-dark fw-medium">Blok A / No. 04</td>
                                        <td class="text-center text-nowrap"><span class="badge bg-danger">Macet (3 Bln)</span></td>
                                        <td class="text-danger small fw-semibold text-nowrap">Menunggak sejak Juni 2026</td>
                                        <td class="text-center text-nowrap">
                                            <a href="https://wa.me/6281234567892" target="_blank" class="btn btn-xs btn-outline-danger">Kirim SP</a>
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

<!-- ============================================================== -->
<!-- KOLOM TANDA TANGAN RESMI (Hanya Tampil Saat Cetak / Print) -->
<!-- ============================================================== -->
<div class="d-none d-print-block mt-5 pt-4">
    <div class="d-flex justify-content-between px-4 text-center">
        <div style="width: 250px;">
            <p class="mb-5">Mengetahui,<br><strong>Ketua RT 04 RW 12</strong></p>
            <p class="mb-0 fw-bold text-decoration-underline">( Agus Hariyanto )</p>
        </div>
        <div style="width: 250px;">
            <p class="mb-5">Bandung, 31 Agustus 2026<br><strong>Bendahara RT 04 RW 12</strong></p>
            <p class="mb-0 fw-bold text-decoration-underline">( Farros Rifantiarno )</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
