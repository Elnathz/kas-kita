<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<?php
$user = $user ?? [];
$wilayah = $wilayah ?? [];
$bulanNama = $bulanNama ?? [];
$tahunSekarang = (int) ($tahunSekarang ?? date('Y'));
$bulanBerjalan = $bulanNama[(int) date('n')] ?? date('F');
$lokasiWarga = trim(($user['blok_rumah'] ?? '') . ' / ' . ($user['no_rumah'] ?? '') . ' - ' . ($user['nama_jalan'] ?? ''), " /-");
$formatWilayahLabel = static function (string $prefix, $nilai): string {
    $nilai = trim((string) $nilai);
    if ($nilai === '') return $prefix;
    $nilai = preg_replace('/^' . preg_quote($prefix, '/') . '\\s*/i', '', $nilai);
    return $prefix . ' ' . trim($nilai);
};
$identitasWilayah = $formatWilayahLabel('RT', $wilayah['rt'] ?? '') . ' / ' . $formatWilayahLabel('RW', $wilayah['rw'] ?? '');
$urlLampiranDashboard = static function (?string $namaFile): string {
    if (!$namaFile) return '';
    $uploadPath = FCPATH . 'uploads/pengeluaran/' . $namaFile;
    return is_file($uploadPath) ? base_url('uploads/pengeluaran/' . $namaFile) : base_url('assets/images/' . $namaFile);
};
?>
<style>
.dashboard-history-scroll {
    max-height: 330px;
    overflow-y: auto;
}
.bukti-preview-stage {
    min-height: 360px;
    max-height: 68vh;
    overflow: auto;
    background: #eef1f4;
}
.bukti-preview-image {
    max-width: 100%;
    max-height: 62vh;
    object-fit: contain;
    transform-origin: center center;
    transition: transform .15s ease;
    cursor: zoom-in;
}
.bukti-preview-image.is-zoomed { cursor: grab; }
.bukti-preview-toolbar .btn { min-width: 36px; }
.dashboard-expense-list {
    max-height: 340px;
    overflow-y: auto;
}
.dashboard-expense-attachment .btn { font-size: 11px; }
.expense-preview-stage {
    min-height: 360px;
    max-height: 68vh;
    overflow: auto;
    background: #eef1f4;
}
.expense-preview-image {
    max-width: 100%;
    max-height: 62vh;
    object-fit: contain;
    transform-origin: center center;
    transition: transform .15s ease;
}
.expense-preview-image.is-zoomed { cursor: grab; }
.expense-preview-toolbar .btn { min-width: 36px; }
</style>
<!-- ============================================================== -->
<!-- Hero Banner Tagihan Iuran Warga -->
<!-- ============================================================== -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden position-relative" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <!-- Efek Cahaya / Glow -->
            <div class="position-absolute" style="top: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, rgba(16,185,129,0) 70%); border-radius: 50%;"></div>
            <div class="position-absolute" style="bottom: -50px; left: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, rgba(16,185,129,0) 70%); border-radius: 50%;"></div>
            
            <div class="card-body p-4 p-lg-5 position-relative z-1 text-white">
                <div class="row align-items-center justify-content-between g-4">
                    <!-- Sisi Kiri: Profil Singkat -->
                    <div class="col-xl-7">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 rounded-pill px-3 py-1 mb-3 border border-white border-opacity-25" style="backdrop-filter: blur(4px);">
                            <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px; box-shadow: 0 0 8px #10b981;"></div>
                            <span class="text-white font-11 fw-bold text-uppercase letter-spacing-1">Akun Warga Kas-Kita</span>
                        </div>
                        <h2 class="fw-bold text-white mb-3">Selamat Datang, <span class="text-success"><?= esc($user['nama'] ?? '-') ?></span></h2>
                        
                        <div class="d-flex flex-wrap gap-4 text-white-50 font-14">
                            <div class="d-flex align-items-center bg-black bg-opacity-25 rounded px-3 py-2 border border-white border-opacity-10">
                                <i data-feather="map-pin" class="text-white-50 me-2" style="width: 16px; height: 16px;"></i>
                                <span class="text-white fw-medium"><?= esc($lokasiWarga ?: '-') ?></span>
                            </div>
                            <div class="d-flex align-items-center bg-black bg-opacity-25 rounded px-3 py-2 border border-white border-opacity-10">
                                <i data-feather="phone" class="text-white-50 me-2" style="width: 16px; height: 16px;"></i>
                                <span class="text-white fw-medium"><?= esc($user['no_telepon'] ?? '-') ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sisi Kanan: Tagihan Berjalan -->
                    <div class="col-xl-4">
                        <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-25 shadow" style="backdrop-filter: blur(8px);">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <span class="text-white-50 small d-block mb-1">Tagihan Bulan Berjalan</span>
                                    <h3 class="fw-bold text-white mb-0">Rp <?= number_format($tagihanBulanBerjalan ?? $nominalIuran, 0, ',', '.') ?></h3>
                                    <small class="text-success fw-semibold"><?= esc($bulanBerjalan . ' ' . $tahunSekarang) ?></small>
                                </div>
                                <div class="bg-success bg-opacity-25 border border-success border-opacity-25 text-success rounded-3 p-2">
                                    <i data-feather="file-text" style="width: 24px; height: 24px;"></i>
                                </div>
                            </div>
                            <?php if($statusBulanIni == 'Lunas'): ?>
                                <button class="btn btn-success w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center py-2 transition-all disabled">
                                    <i data-feather="check-circle" class="me-2" style="width: 16px; height: 16px;"></i> Sudah Lunas
                                </button>
                            <?php elseif($statusBulanIni == 'Menunggu Verifikasi'): ?>
                                <button class="btn btn-warning w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center py-2 transition-all disabled">
                                    <i data-feather="clock" class="me-2" style="width: 16px; height: 16px;"></i> Menunggu Verifikasi
                                </button>
                            <?php else: ?>
                                <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-success w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center py-2 transition-all">
                                    <i data-feather="credit-card" class="me-2" style="width: 16px; height: 16px;"></i> Bayar Iuran Sekarang
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Kartu Ringkasan Personal Warga -->
<!-- ============================================================== -->
<div class="row g-3 mb-4">
    <!-- Status Pembayaran Bulan Ini -->
    <div class="col-sm-6 col-xl-3">
        <?php 
            $statusColor = 'warning';
            $statusIcon = 'clock';
            if($statusBulanIni == 'Lunas') {
                $statusColor = 'success';
                $statusIcon = 'check-circle';
            } elseif ($statusBulanIni == 'Ditolak') {
                $statusColor = 'danger';
                $statusIcon = 'x-circle';
            }
        ?>
        <div class="card border-0 shadow-sm border-start border-<?= $statusColor ?> border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Status Iuran <?= esc($bulanBerjalan . ' ' . $tahunSekarang) ?></span>
                    <h5 class="text-<?= $statusColor ?> fw-bold mb-0"><?= $statusBulanIni ?></h5>
                    <small class="text-muted font-12">Bulan Ini</small>
                </div>
                <div class="bg-light rounded p-2 text-<?= $statusColor ?> d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="<?= $statusIcon ?>" class="feather-icon text-<?= $statusColor ?>"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tunggakan Saya -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Tagihan Saya</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($totalTunggakanSaya, 0, ',', '.') ?></h4>
                    <small class="text-muted font-12"><?= $totalTunggakanSaya > 0 ? $jumlahTunggakanSaya . ' Periode Belum Lunas' : 'Tidak Ada Tunggakan' ?></small>
                </div>
                <div class="bg-light rounded p-2 text-danger d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="alert-circle" class="feather-icon text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Iuran Terbayar Tahun Ini -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Iuran Terbayar (<?= date('Y') ?>)</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($totalIuranSayaTahunIni, 0, ',', '.') ?></h4>
                    <small class="text-success font-12 fw-semibold"><?= $bulanLunasSaya ?> Bulan Lunas</small>
                </div>
                <div class="bg-light rounded p-2 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="check-circle" class="feather-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Transparansi Saldo Kas RT Saat Ini -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Total Saldo Kas RT Terkini</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp <?= number_format($saldoKas, 0, ',', '.') ?></h4>
                    <small class="text-muted font-12">Transparan &amp; Terbuka</small>
                </div>
                <div class="bg-light rounded p-2 text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="shield" class="feather-icon text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Konten Bawah: Riwayat Saya & Transparansi Pengeluaran RT -->
<!-- ============================================================== -->
<div class="row g-4">
    <!-- Tabel Riwayat Pembayaran Saya -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold">Riwayat Pembayaran Iuran Saya</h4>
                        <p class="text-muted small mb-0">Catatan pembayaran iuran yang telah Anda lakukan.</p>
                    </div>
                    <a href="<?= base_url('iuran/riwayat') ?>" class="btn btn-sm btn-outline-success fw-semibold">Lihat Semua</a>
                </div>

                <div class="table-responsive flex-grow-1 dashboard-history-scroll">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Periode</th>
                                <th class="text-nowrap">Nominal</th>
                                <th class="text-nowrap">Tanggal Bayar</th>
                                <th class="text-nowrap text-center">Status</th>
                                <th class="text-nowrap text-center">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($riwayatPembayaran)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat pembayaran.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($riwayatPembayaran as $riwayat): ?>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap"><?= esc($bulanNama[(int) $riwayat['periode_bulan']] ?? '-') ?> <?= esc($riwayat['periode_tahun']) ?></td>
                                        <td class="text-nowrap text-dark fw-bold">Rp <?= number_format($riwayat['nominal'], 0, ',', '.') ?></td>
                                        <td class="text-nowrap text-muted"><?= date('d M Y', strtotime($riwayat['created_at'])) ?></td>
                                        <td class="text-center text-nowrap">
                                            <?php if($riwayat['status'] == 'terverifikasi'): ?>
                                                <span class="badge bg-success">Terverifikasi</span>
                                            <?php elseif($riwayat['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Ditolak</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?php
                                            $isDitolak = $riwayat['status'] === 'ditolak';
                                            $buktiRiwayat = $isDitolak
                                                ? ($riwayat['bukti_penolakan'] ?? '')
                                                : ($riwayat['bukti_transfer'] ?? '');
                                            $jenisBukti = $isDitolak ? 'Bukti Pengurus' : 'Bukti Transfer';
                                            ?>
                                            <?php if($buktiRiwayat || ($isDitolak && !empty($riwayat['catatan']))): ?>
                                                <button class="btn btn-xs btn-outline-secondary" onclick="lihatBuktiTransfer(<?= esc(json_encode($jenisBukti), 'attr') ?>, <?= esc(json_encode(($bulanNama[(int) $riwayat['periode_bulan']] ?? '-') . ' ' . $riwayat['periode_tahun']), 'attr') ?>, <?= esc(json_encode('Rp ' . number_format($riwayat['nominal'], 0, ',', '.')), 'attr') ?>, <?= esc(json_encode(date('d M Y - H:i', strtotime($riwayat['created_at'])) . ' WIB'), 'attr') ?>, <?= esc(json_encode($buktiRiwayat), 'attr') ?>, <?= esc(json_encode($riwayat['catatan'] ?? ''), 'attr') ?>)">Lihat</button>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3 text-end">
                    <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-sm btn-success fw-semibold">
                        <i data-feather="plus-circle" class="feather-icon me-1"></i> Bayar Iuran Periode Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Widget Transparansi Pengeluaran Kas RT -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold">Transparansi Kas RT</h4>
                    <p class="text-muted small mb-0">Pengeluaran dana <?= esc($identitasWilayah) ?> terkini.</p>
                    </div>
                    <a href="<?= base_url('laporan-warga') ?>" class="btn btn-sm btn-outline-primary fw-semibold">Laporan</a>
                </div>

                <div class="list-group list-group-flush flex-grow-1 dashboard-expense-list">
                    <?php if(empty($pengeluaranTerakhir)): ?>
                        <div class="text-center text-muted py-4">Belum ada pengeluaran.</div>
                    <?php else: ?>
                        <?php foreach($pengeluaranTerakhir as $pengeluaran): ?>
                            <div class="list-group-item px-0 py-2 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark font-14"><?= esc($pengeluaran['keterangan']) ?></h6>
                                        <div class="dashboard-expense-attachment d-flex flex-wrap gap-1 mt-2">
                                            <?php if (!empty($pengeluaran['foto_nota'])): ?>
                                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="lihatLampiranDashboard('Nota', <?= esc(json_encode($pengeluaran['keterangan']), 'attr') ?>, <?= esc(json_encode($pengeluaran['foto_nota']), 'attr') ?>, <?= esc(json_encode($urlLampiranDashboard($pengeluaran['foto_nota'])), 'attr') ?>)">
                                                    <i data-feather="file-text" style="width: 12px; height: 12px;"></i> Nota
                                                </button>
                                            <?php endif; ?>
                                            <?php if (!empty($pengeluaran['dokumentasi'])): ?>
                                                <button type="button" class="btn btn-xs btn-outline-success" onclick="lihatLampiranDashboard('Dokumentasi', <?= esc(json_encode($pengeluaran['keterangan']), 'attr') ?>, <?= esc(json_encode($pengeluaran['dokumentasi']), 'attr') ?>, <?= esc(json_encode($urlLampiranDashboard($pengeluaran['dokumentasi'])), 'attr') ?>)">
                                                    <i data-feather="image" style="width: 12px; height: 12px;"></i> Dokumentasi
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted"><?= date('d M Y', strtotime($pengeluaran['tanggal'])) ?> • <?= esc($pengeluaran['nama_kategori']) ?></small>
                                    </div>
                                    <span class="text-danger fw-bold text-nowrap font-14">Rp <?= number_format($pengeluaran['nominal'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="pt-3 border-top mt-3 text-center">
                    <small class="text-muted d-block">Dana kas <?= esc($identitasWilayah) ?> dikelola secara terbuka dan dapat diaudit seluruh warga.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDashboardLampiran" tabindex="-1" aria-labelledby="modalDashboardLampiranLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" id="dashboardLampiranDialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="modalDashboardLampiranLabel">
                    <i data-feather="file" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                    <span id="dashboardLampiranJenis">Lampiran</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="expense-preview-toolbar d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomLampiranDashboard(-0.2)" title="Perkecil"><i data-feather="zoom-out" style="width: 14px; height: 14px;"></i></button>
                    <span class="small text-muted" id="dashboardLampiranZoomLabel">100%</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomLampiranDashboard(0.2)" title="Perbesar"><i data-feather="zoom-in" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetLampiranDashboardZoom()">Reset</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleLampiranDashboardFullscreen()"><i data-feather="maximize-2" style="width: 14px; height: 14px;"></i> Layar penuh</button>
                </div>
                <div class="expense-preview-stage p-3 rounded-3 border d-flex align-items-center justify-content-center">
                    <div id="dashboardLampiranWrapper" class="d-flex align-items-center justify-content-center w-100 h-100"></div>
                </div>
                <h6 class="fw-bold text-dark mb-1 mt-3" id="dashboardLampiranTitle">-</h6>
                <span class="badge bg-white text-dark border font-11 px-2 py-1" id="dashboardLampiranFilename">-</span>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <a id="dashboardLampiranDownload" class="btn btn-success btn-sm fw-semibold" href="#" download><i data-feather="download" style="width: 14px; height: 14px;"></i> Unduh File</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pratinjau Bukti Transfer Warga -->
<div class="modal fade" id="modalLihatBuktiTransfer" tabindex="-1" aria-labelledby="modalLihatBuktiTransferLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" id="modalBuktiDialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="modalLihatBuktiTransferLabel">
                    <i data-feather="file-text" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                    <span id="modalBuktiJenis">Bukti Transfer</span> Pembayaran Iuran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="bukti-preview-toolbar d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomBukti(-0.2)" title="Perkecil">
                        <i data-feather="zoom-out" style="width: 14px; height: 14px;"></i>
                    </button>
                    <span class="small text-muted" id="modalBuktiZoomLabel">100%</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomBukti(0.2)" title="Perbesar">
                        <i data-feather="zoom-in" style="width: 14px; height: 14px;"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetBuktiZoom()">Reset</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleBuktiFullscreen()">
                        <i data-feather="maximize-2" style="width: 14px; height: 14px;"></i> Layar penuh
                    </button>
                </div>
                <div id="modalBuktiStage" class="bukti-preview-stage p-3 rounded-3 border d-flex align-items-center justify-content-center mb-3">
                    <div class="d-flex align-items-center justify-content-center w-100 h-100" id="modalBuktiImageWrapper">
                        <i data-feather="image" class="text-success" style="width: 48px; height: 48px;"></i>
                    </div>
                </div>
                <h6 class="fw-bold text-dark mb-1" id="modalBuktiPeriode">-</h6>
                <span class="text-success fw-bold fs-6 d-block mb-1" id="modalBuktiNominal">-</span>
                <small class="text-muted d-block mb-2 font-12" id="modalBuktiWaktu">-</small>
                <span class="badge bg-white text-dark border font-11 px-2 py-1" id="modalBuktiFilename">bukti_transfer.jpg</span>
                <div id="modalBuktiCatatanWrapper" class="alert alert-danger text-start font-12 py-2 px-3 mt-3 mb-3 d-none">
                    <div class="fw-semibold mb-1"><i data-feather="message-square" style="width: 14px; height: 14px;"></i> Catatan Pengurus</div>
                    <div id="modalBuktiCatatan"></div>
                </div>
                <div class="alert alert-success font-12 py-2 px-3 mb-0 text-start">
                    <i data-feather="check-circle" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Dokumen ini tersimpan sebagai arsip digital RT.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <a id="modalBuktiDownload" class="btn btn-success btn-sm fw-semibold" href="#" download>
                    <i data-feather="download" style="width: 14px; height: 14px;"></i> Unduh File
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let dashboardLampiranScale = 1;
function applyLampiranDashboardZoom() {
    const image = document.getElementById('dashboardLampiranImage');
    const label = document.getElementById('dashboardLampiranZoomLabel');
    if (image) {
        image.style.transform = 'scale(' + dashboardLampiranScale + ')';
        image.classList.toggle('is-zoomed', dashboardLampiranScale > 1);
    }
    if (label) label.textContent = Math.round(dashboardLampiranScale * 100) + '%';
}
function zoomLampiranDashboard(step) {
    dashboardLampiranScale = Math.min(3, Math.max(1, dashboardLampiranScale + step));
    applyLampiranDashboardZoom();
}
function resetLampiranDashboardZoom() {
    dashboardLampiranScale = 1;
    applyLampiranDashboardZoom();
}
function toggleLampiranDashboardFullscreen() {
    const dialog = document.getElementById('dashboardLampiranDialog');
    const stage = dialog.querySelector('.expense-preview-stage');
    dialog.classList.toggle('modal-fullscreen');
    stage.style.maxHeight = dialog.classList.contains('modal-fullscreen') ? '78vh' : '68vh';
}
function lihatLampiranDashboard(jenis, judul, filename, url) {
    document.getElementById('dashboardLampiranJenis').textContent = jenis;
    document.getElementById('dashboardLampiranTitle').textContent = judul;
    document.getElementById('dashboardLampiranFilename').textContent = filename;
    const wrapper = document.getElementById('dashboardLampiranWrapper');
    const download = document.getElementById('dashboardLampiranDownload');
    wrapper.innerHTML = '';
    download.href = url;
    download.setAttribute('download', filename.split('/').pop());
    resetLampiranDashboardZoom();
    if (/\.(jpeg|jpg|gif|png|webp)$/i.test(filename)) {
        const image = document.createElement('img');
        image.id = 'dashboardLampiranImage';
        image.src = url;
        image.alt = jenis;
        image.className = 'expense-preview-image rounded border shadow-sm';
        image.addEventListener('dblclick', resetLampiranDashboardZoom);
        wrapper.appendChild(image);
        applyLampiranDashboardZoom();
    } else {
        const link = document.createElement('a');
        link.href = url;
        link.target = '_blank';
        link.rel = 'noopener';
        link.className = 'btn btn-outline-primary';
        link.textContent = 'Buka Dokumen';
        wrapper.appendChild(link);
    }
    new bootstrap.Modal(document.getElementById('modalDashboardLampiran')).show();
    if (typeof feather !== 'undefined') feather.replace();
}

let buktiPreviewScale = 1;

function resolveBuktiUrl(filename) {
    const baseUrl = '<?= base_url() ?>';
    if (filename.startsWith('assets/') || filename.startsWith('uploads/')) return baseUrl + filename;
    return baseUrl + 'uploads/bukti/' + filename;
}

function applyBuktiZoom() {
    const image = document.getElementById('modalBuktiImage');
    const label = document.getElementById('modalBuktiZoomLabel');
    if (image) {
        image.style.transform = 'scale(' + buktiPreviewScale + ')';
        image.classList.toggle('is-zoomed', buktiPreviewScale > 1);
    }
    if (label) label.textContent = Math.round(buktiPreviewScale * 100) + '%';
}

function zoomBukti(step) {
    buktiPreviewScale = Math.min(3, Math.max(1, buktiPreviewScale + step));
    applyBuktiZoom();
}

function resetBuktiZoom() {
    buktiPreviewScale = 1;
    applyBuktiZoom();
}

function toggleBuktiFullscreen() {
    const dialog = document.getElementById('modalBuktiDialog');
    const stage = document.getElementById('modalBuktiStage');
    dialog.classList.toggle('modal-fullscreen');
    stage.style.maxHeight = dialog.classList.contains('modal-fullscreen') ? '78vh' : '68vh';
}

function lihatBuktiTransfer(jenis, periode, nominal, waktu, filename, catatan = '') {
    document.getElementById('modalBuktiJenis').textContent = jenis;
    document.getElementById('modalBuktiPeriode').textContent = 'Iuran Kas RT: ' + periode;
    document.getElementById('modalBuktiNominal').textContent = nominal;
    document.getElementById('modalBuktiWaktu').textContent = 'Diupload pada ' + waktu;
    document.getElementById('modalBuktiFilename').textContent = filename;

    const url = filename ? resolveBuktiUrl(filename) : '';
    const wrapper = document.getElementById('modalBuktiImageWrapper');
    wrapper.innerHTML = '';
    resetBuktiZoom();
    const download = document.getElementById('modalBuktiDownload');
    download.href = url || '#';
    download.classList.toggle('d-none', !url);
    if (url) download.setAttribute('download', filename.split('/').pop());

    const catatanWrapper = document.getElementById('modalBuktiCatatanWrapper');
    document.getElementById('modalBuktiCatatan').textContent = catatan || '';
    catatanWrapper.classList.toggle('d-none', !catatan);

    if (!filename) {
        wrapper.innerHTML = '<div class="text-muted font-13 py-5">Lampiran pengurus tidak tersedia.</div>';
    } else if (filename.match(/\.(jpeg|jpg|gif|png|webp)$/i)) {
        const image = document.createElement('img');
        image.id = 'modalBuktiImage';
        image.src = url;
        image.alt = jenis;
        image.className = 'bukti-preview-image rounded border shadow-sm';
        image.addEventListener('dblclick', resetBuktiZoom);
        wrapper.appendChild(image);
        applyBuktiZoom();
    } else {
        const link = document.createElement('a');
        link.href = url;
        link.target = '_blank';
        link.rel = 'noopener';
        link.className = 'btn btn-outline-primary';
        link.textContent = 'Buka Dokumen';
        wrapper.appendChild(link);
    }

    const modalEl = document.getElementById('modalLihatBuktiTransfer');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}
</script>
<?= $this->endSection() ?>
