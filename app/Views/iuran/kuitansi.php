<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<?php
$wilayah = $wilayah ?? [];
$bendahara = $bendahara ?? [];
$nomorWa = \App\Libraries\IuranPeriodSummary::normalizePhone($pembayaran['no_telepon'] ?? '');
$periodeLabel = date('F Y', mktime(0, 0, 0, (int) ($pembayaran['periode_bulan'] ?? 1), 1, (int) ($pembayaran['periode_tahun'] ?? date('Y'))));
$pesanWa = 'Halo Bapak/Ibu ' . ($pembayaran['nama'] ?? '') . ",\n\nBerikut kuitansi resmi pembayaran iuran kas RT periode " . $periodeLabel . ' sebesar Rp ' . number_format((float) ($pembayaran['nominal'] ?? 0), 0, ',', '.') . ".\n\nPembayaran sudah diverifikasi oleh pengurus RT. Terima kasih atas partisipasinya.";
$wilayahSingkat = 'RT ' . ($wilayah['rt'] ?? '-') . ' / RW ' . ($wilayah['rw'] ?? '-');
$wilayahLengkap = trim(($wilayah['kelurahan'] ?? '') . ', ' . ($wilayah['kecamatan'] ?? '') . ', ' . ($wilayah['kota'] ?? '') . ', ' . ($wilayah['provinsi'] ?? ''), ' ,');
?>
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        
        <!-- Action Toolbar (Hidden during print) -->
        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between mb-3 gap-2 d-print-none">
            <a href="<?= base_url('iuran') ?>" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center gap-1">
                <i data-feather="arrow-left" class="feather-icon" style="width: 14px; height: 14px;"></i>
                <span>Kembali</span>
            </a>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <?php if ($nomorWa !== ''): ?>
                <a href="https://wa.me/<?= esc($nomorWa) ?>?text=<?= rawurlencode($pesanWa) ?>" target="_blank" class="btn btn-outline-success btn-sm d-inline-flex align-items-center justify-content-center gap-1">
                    <i data-feather="send" class="feather-icon" style="width: 14px; height: 14px;"></i>
                    <span>Kirim WA</span>
                </a>
                <?php endif; ?>
                <button onclick="window.print()" class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center gap-1 fw-semibold">
                    <i data-feather="printer" class="feather-icon" style="width: 14px; height: 14px;"></i>
                    <span>Cetak / PDF</span>
                </button>
            </div>
        </div>

        <!-- Official Receipt Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative print-clean-card">

            <div class="card-body p-3 p-md-5">
                
                <!-- Receipt Header / KOP (Responsif Mobile & Desktop) -->
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between pb-3 border-bottom mb-4 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                            <i data-feather="shield" class="feather-icon text-white" style="width: 22px; height: 22px;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0 font-14">RUKUN TETANGGA <?= esc($wilayah['rt'] ?? '-') ?> / RW <?= esc($wilayah['rw'] ?? '-') ?></h6>
                            <span class="text-muted font-11 d-block">Sistem Pengelolaan Kas Warga - Kas-Kita</span>
                            <span class="text-muted font-10"><?= esc($wilayahLengkap) ?></span>
                        </div>
                    </div>
                    <div class="text-start text-sm-end w-100 w-sm-auto pt-2 pt-sm-0 border-top border-sm-top-0">
                        <span class="badge bg-light text-dark border font-10 px-2 py-1 mb-1 d-inline-block">KUITANSI PEMBAYARAN</span>
                        <div class="text-muted font-11 mb-1">
                            No: <strong class="text-dark">KW-RT04/2026/08/0023</strong>
                        </div>
                        <span class="badge bg-success font-10 px-2 py-1">
                            <i data-feather="check-circle" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>
                            Lunas Terverifikasi
                        </span>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="mb-4">
                    <div class="row g-3">
                        
                        <!-- Telah Diterima Dari -->
                        <div class="col-sm-4 text-muted font-13">Telah Diterima Dari</div>
                        <div class="col-sm-8">
                            <span class="fw-bold text-dark font-15 d-block"><?= esc($pembayaran['nama'] ?? 'N/A') ?></span>
                            <span class="text-dark font-13"><?= esc($pembayaran['blok_rumah'] ?? '') ?> / <?= esc($pembayaran['no_rumah'] ?? '') ?> (<?= esc($pembayaran['nama_jalan'] ?? '') ?>)</span>
                        </div>

                        <!-- Untuk Pembayaran -->
                        <div class="col-sm-4 text-muted font-13">Untuk Pembayaran</div>
                        <div class="col-sm-8">
                            <span class="text-dark fw-semibold font-14 d-block">Iuran Pengelolaan Kas RT 04</span>
                            <span class="text-muted font-12">Periode: <?= date('F Y', mktime(0, 0, 0, $pembayaran['periode_bulan'] ?? 1, 1, $pembayaran['periode_tahun'] ?? 2026)) ?></span>
                        </div>

                        <!-- Jumlah Uang -->
                        <div class="col-sm-4 text-muted font-13">Jumlah Pembayaran</div>
                        <div class="col-sm-8">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="fw-bold text-success fs-4 d-block">Rp <?= number_format($pembayaran['nominal'] ?? 0, 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <!-- Metode & Waktu Verifikasi -->
                        <div class="col-sm-4 text-muted font-13">Metode &amp; Validasi</div>
                        <div class="col-sm-8 font-13 text-dark">
                            <div>Metode: <strong>Transfer</strong></div>
                            <div>Divalidasi Oleh: <strong>Pengurus RT</strong></div>
                            <div>Waktu Validasi: <span class="text-muted"><?= date('d F Y, H:i', strtotime($pembayaran['verified_at'] ?? 'now')) ?> WIB</span></div>
                        </div>

                    </div>
                </div>

                <!-- Footer Signatures -->
                <div class="pt-4 border-top mt-4">
                    <div class="d-flex justify-content-between align-items-end text-center">
                        <div class="text-start font-12 text-muted" style="max-width: 250px;">
                            <i data-feather="info" class="feather-icon me-1" style="width: 12px; height: 12px;"></i>
                            Kuitansi ini merupakan bukti pembayaran sah yang diterbitkan secara elektronik oleh Sistem Kas-Kita <?= esc($wilayahSingkat) ?>.
                        </div>
                        <div style="width: 220px;">
                            <span class="font-12 text-muted d-block mb-1"><?= esc($wilayah['kota'] ?? '') ?>, <?= date('d F Y', strtotime($pembayaran['verified_at'] ?? 'now')) ?><br><strong><?= esc($bendahara['nama'] ?? 'Bendahara RT') ?></strong></span>
                            
                            <!-- Digital Signature & RT Stamp Overlay -->
                            <div class="position-relative d-inline-block my-1" style="height: 65px; width: 170px;">
                                <!-- Cap Digital RT 04 -->
                                <div class="position-absolute top-50 start-50 translate-middle opacity-50" style="pointer-events: none; z-index: 1;">
                                    <div class="rounded-circle border border-2 border-primary d-flex flex-column align-items-center justify-content-center text-primary fw-bold" style="width: 70px; height: 70px; transform: rotate(-12deg); border-style: dashed !important;">
                                        <span style="font-size: 7px;" class="text-uppercase">PENGURUS RT</span>
                                        <span class="fw-bolder font-10">RT <?= esc($wilayah['rt'] ?? '-') ?></span>
                                        <span style="font-size: 7px;">RW <?= esc($wilayah['rw'] ?? '-') ?></span>
                                    </div>
                                </div>
                                <!-- Tanda Tangan Farros Rifantiarno SVG -->
                                <svg class="position-relative" style="z-index: 2;" width="150" height="60" viewBox="0 0 160 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 45 C35 15, 45 10, 50 25 C55 40, 40 55, 30 50 C20 45, 45 20, 65 30 C75 35, 80 48, 90 35 C98 25, 105 40, 115 32 C125 25, 135 38, 145 28 M40 32 L85 30 M15 52 Q70 48, 150 42" stroke="#0c2d6b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            <span class="fw-bold text-dark font-13 text-decoration-underline d-block">( Bendahara )</span>
                            <small class="text-muted font-11">Sistem Kas-Kita</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
@media print {
    body {
        background: #ffffff !important;
    }
    .left-sidebar, .topbar, .page-breadcrumb, .btn, .d-print-none {
        display: none !important;
    }
    .page-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }
    .print-clean-card {
        box-shadow: none !important;
        border: 1px solid #000 !important;
    }
}
</style>
<?= $this->endSection() ?>
