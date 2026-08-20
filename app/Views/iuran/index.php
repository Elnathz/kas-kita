<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<?php
$rekapWarga = $rekap['warga'] ?? [];
$jenisPeriode = $period['jenis'] ?? 'bulanan';
$bulanNama = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];
$mulai = $period['start'] ?? ['bulan' => $bulan_ini, 'tahun' => $tahun_ini];
$selesai = $period['end'] ?? ['bulan' => $bulan_ini, 'tahun' => $tahun_ini];
$periodBounds = $period_bounds ?? [
    'start' => ['bulan' => 1, 'tahun' => $mulai['tahun']],
    'end'   => ['bulan' => $selesai['bulan'], 'tahun' => $selesai['tahun']],
];
$tahunTersedia = $tahun_tersedia ?? range($periodBounds['start']['tahun'], $periodBounds['end']['tahun']);
$bulanUntukTahun = static function (int $tahun) use ($bulanNama, $periodBounds): array {
    $minimum = $tahun === $periodBounds['start']['tahun'] ? $periodBounds['start']['bulan'] : 1;
    $maximum = $tahun === $periodBounds['end']['tahun'] ? $periodBounds['end']['bulan'] : 12;

    return array_filter(
        $bulanNama,
        static fn (string $nama, int $bulan): bool => $bulan >= $minimum && $bulan <= $maximum,
        ARRAY_FILTER_USE_BOTH,
    );
};
$bulanMulaiTersedia = $bulanUntukTahun((int) $mulai['tahun']);
$bulanSelesaiTersedia = $bulanUntukTahun((int) $selesai['tahun']);
$alamatWarga = static function (array $warga): string {
    return trim(($warga['blok_rumah'] ?? '') . ' ' . ($warga['no_rumah'] ?? ''));
};
$badgeStatus = static function (array $warga): array {
    return match ($warga['status']) {
        'terverifikasi' => ['bg-success', 'Lunas'],
        'tunggakan' => ['bg-danger', 'Macet'],
        'belum_bayar' => ['bg-warning text-dark', 'Belum Bayar'],
        default => ['bg-warning text-dark', 'Menunggu Verifikasi'],
    };
};
?>

<style>
.iuran-nominal,
th.text-end,
td.text-end {
    min-width: 110px;
    white-space: nowrap;
}
</style>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-warning border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-dark fw-semibold font-12 d-block mb-1">Menunggu Verifikasi</span>
                    <h4 class="text-dark fw-bold mb-0"><?= $menunggu_verifikasi ?> Warga</h4>
                    <small class="text-warning fw-bold font-12">Total: Rp <?= number_format($total_verifikasi, 0, ',', '.') ?></small>
                </div>
                <button class="btn btn-sm btn-outline-warning fw-bold px-2 py-1 font-11" type="button" onclick="pilihTabIuran('pills-verif-tab')">
                    Proses
                </button>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-success border-4 h-100 mb-0">
            <div class="card-body p-3">
                <span class="text-dark fw-semibold font-12 d-block mb-1">Sudah Lunas</span>
                <h4 class="text-success fw-bold mb-0"><?= $lunas ?> KK <span class="fs-6 text-muted fw-normal">(<?= $total_warga > 0 ? round(($lunas / $total_warga) * 100) : 0 ?>%)</span></h4>
                <small class="text-success fw-semibold font-12">Terkumpul: Rp <?= number_format($total_lunas, 0, ',', '.') ?></small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 mb-0">
            <div class="card-body p-3">
                <span class="text-dark fw-semibold font-12 d-block mb-1">Belum Bayar</span>
                <h4 class="text-dark fw-bold mb-0"><?= $belum_bayar ?> KK</h4>
                <small class="text-muted font-12">Periode: <?= esc($period['label']) ?></small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-dark fw-semibold font-12 d-block mb-1">Macet</span>
                    <h4 class="text-danger fw-bold mb-0"><?= $macet ?> KK</h4>
                    <small class="text-danger fw-semibold font-12">Kumulatif: Rp <?= number_format($total_tunggakan, 0, ',', '.') ?></small>
                </div>
                <button class="btn btn-sm btn-outline-danger fw-bold px-2 py-1 font-11" type="button" onclick="pilihTabIuran('pills-tunggakan-tab')">
                    Tagih
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Daftar Tagihan &amp; Pembayaran Iuran</h4>
                        <p class="text-muted small mb-0">Rekap tagihan warga untuk periode <?= esc($period['label']) ?>.</p>
                    </div>

                    <form id="filterForm" action="<?= base_url('iuran') ?>" method="get" class="d-flex flex-column flex-md-row flex-wrap align-items-md-center gap-2 w-100 w-xl-auto" onsubmit="return validasiRentangIuran()">
                        <select class="form-select form-select-sm" name="jenis_periode" id="jenisPeriode" onchange="aturFilterPeriodeIuran()">
                            <option value="bulanan" <?= $jenisPeriode === 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
                            <option value="tahunan" <?= $jenisPeriode === 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
                            <option value="rentang" <?= $jenisPeriode === 'rentang' ? 'selected' : '' ?>>Rentang</option>
                        </select>

                        <div id="filterBulanan" class="d-flex gap-2">
                            <select class="form-select form-select-sm" name="bulan">
                                <?php foreach ($bulanMulaiTersedia as $nomor => $nama): ?>
                                    <option value="<?= $nomor ?>" <?= $mulai['bulan'] === $nomor ? 'selected' : '' ?>><?= esc($nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-select form-select-sm" name="tahun">
                                <?php foreach ($tahunTersedia as $tahun): ?>
                                    <option value="<?= $tahun ?>" <?= $mulai['tahun'] === $tahun ? 'selected' : '' ?>><?= $tahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="filterTahunan" class="d-none">
                            <select class="form-select form-select-sm" name="tahun_tahunan">
                                <?php foreach ($tahunTersedia as $tahun): ?>
                                    <option value="<?= $tahun ?>" <?= $mulai['tahun'] === $tahun ? 'selected' : '' ?>><?= $tahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="filterRentang" class="d-flex flex-column flex-md-row gap-2 d-none">
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-sm" name="bulan_awal" id="bulanAwal">
                                    <?php foreach ($bulanMulaiTersedia as $nomor => $nama): ?>
                                        <option value="<?= $nomor ?>" <?= $mulai['bulan'] === $nomor ? 'selected' : '' ?>><?= esc($nama) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-select form-select-sm" name="tahun_awal" id="tahunAwal">
                                    <?php foreach ($tahunTersedia as $tahun): ?>
                                        <option value="<?= $tahun ?>" <?= $mulai['tahun'] === $tahun ? 'selected' : '' ?>><?= $tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <span class="align-self-center text-muted small">sampai</span>
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-sm" name="bulan_akhir" id="bulanAkhir">
                                    <?php foreach ($bulanSelesaiTersedia as $nomor => $nama): ?>
                                        <option value="<?= $nomor ?>" <?= $selesai['bulan'] === $nomor ? 'selected' : '' ?>><?= esc($nama) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-select form-select-sm" name="tahun_akhir" id="tahunAkhir">
                                    <?php foreach ($tahunTersedia as $tahun): ?>
                                        <option value="<?= $tahun ?>" <?= $selesai['tahun'] === $tahun ? 'selected' : '' ?>><?= $tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <select class="form-select form-select-sm" name="blok">
                            <option value="all" <?= $blok_ini === 'all' ? 'selected' : '' ?>>Semua Blok</option>
                            <?php foreach ($master_blok as $blok): ?>
                                <option value="<?= esc($blok['nama_blok']) ?>" <?= $blok_ini === $blok['nama_blok'] ? 'selected' : '' ?>><?= esc($blok['nama_blok']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button class="btn btn-sm btn-primary px-3" type="submit">Terapkan</button>
                    </form>
                </div>

                <div class="alert alert-light border py-2 px-3 small mb-3">
                    <i data-feather="calendar" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Menampilkan rekap periode <strong><?= esc($period['label']) ?></strong>. Setiap warga hanya tampil satu kali. Status Macet dihitung kumulatif dari awal kebijakan sampai periode ini.
                </div>

                <div class="nav-segment-container d-inline-flex p-1 rounded-pill mb-4">
                    <ul class="nav nav-pills border-0 gap-1" id="iuranWorkflowTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active tab-verif fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-verif-tab" data-bs-toggle="pill" data-bs-target="#pills-verif" type="button" role="tab">
                                <i data-feather="clock" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Menunggu Verifikasi</span>
                                <span class="badge bg-warning text-dark font-11"><?= $menunggu_verifikasi ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-tunggakan fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-tunggakan-tab" data-bs-toggle="pill" data-bs-target="#pills-tunggakan" type="button" role="tab">
                                <i data-feather="alert-circle" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Tunggakan &amp; Belum Bayar</span>
                                <span class="badge bg-danger text-white font-11"><?= $macet + $belum_bayar ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-lunas fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-lunas-tab" data-bs-toggle="pill" data-bs-target="#pills-lunas" type="button" role="tab">
                                <i data-feather="check-circle" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Sudah Lunas</span>
                                <span class="badge bg-light text-dark font-11"><?= $lunas ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-semua fw-bold btn-sm py-2 px-3 rounded-pill d-flex align-items-center gap-2" id="pills-semua-tab" data-bs-toggle="pill" data-bs-target="#pills-semua" type="button" role="tab">
                                <i data-feather="list" class="feather-icon" style="width: 14px; height: 14px;"></i>
                                <span>Semua Data (<?= $total_warga ?>)</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="iuranWorkflowTabContent">
                    <div class="tab-pane fade show active" id="pills-verif" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Warga</th>
                                        <th>Alamat</th>
                                        <th>Periode</th>
                                        <th class="text-end">Pending</th>
                                        <th class="text-end">Sisa Tagihan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $adaPending = false; ?>
                                    <?php foreach ($rekapWarga as $warga): ?>
                                        <?php if (!$warga['butuh_verifikasi']) continue; ?>
                                        <?php $adaPending = true; ?>
                                        <tr>
                                            <td class="fw-semibold text-dark"><?= esc($warga['nama']) ?></td>
                                            <td><?= esc($alamatWarga($warga)) ?></td>
                                            <td><?= esc($warga['periode_label']) ?></td>
                                            <td class="text-end text-warning fw-bold">Rp <?= number_format($warga['total_pending'], 0, ',', '.') ?></td>
                                            <td class="text-end">Rp <?= number_format($warga['total_sisa'], 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <?php $pembayaranPending = $warga['pembayaran_pending'][0] ?? null; ?>
                                                <?php if ($pembayaranPending): ?>
                                                    <a class="btn btn-xs btn-outline-warning" href="<?= base_url('iuran/verifikasi/' . $pembayaranPending['id']) ?>">Verifikasi</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (!$adaPending): ?>
                                        <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada pembayaran yang menunggu verifikasi pada periode ini.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-tunggakan" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Warga</th>
                                        <th>Alamat</th>
                                        <th>Periode</th>
                                        <th class="text-center">Bulan Belum Bayar</th>
                                        <th class="text-end">Sisa Tagihan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $adaTunggakan = false; ?>
                                    <?php foreach ($rekapWarga as $warga): ?>
                                        <?php if (!$warga['punya_tunggakan']) continue; ?>
                                        <?php $adaTunggakan = true; ?>
                                        <tr>
                                            <td class="fw-semibold text-dark"><?= esc($warga['nama']) ?></td>
                                            <td><?= esc($alamatWarga($warga)) ?></td>
                                            <td><?= esc($warga['periode_label']) ?></td>
                                            <td class="text-center"><?= $warga['bulan_belum_bayar'] ?> bulan</td>
                                            <td class="text-end text-danger fw-bold">Rp <?= number_format($warga['total_sisa'], 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <?php $nomorWa = \App\Libraries\IuranPeriodSummary::normalizePhone($warga['no_telepon'] ?? ''); ?>
                                                <?php $statusTagihan = !empty($warga['macet']) ? ' Saat ini statusnya tercatat sebagai tunggakan macet.' : ''; ?>
                                                <?php $pesanTagihan = "Halo Bapak/Ibu {$warga['nama']},\n\nKami dari pengurus RT mengingatkan bahwa iuran kas RT periode {$period['label']} masih memiliki tunggakan {$warga['bulan_belum_bayar']} bulan dengan total Rp " . number_format($warga['total_sisa'], 0, ',', '.') . ".{$statusTagihan}\n\nMohon melakukan pembayaran melalui menu Bayar Iuran. Jika pembayaran sudah dilakukan, silakan unggah bukti transfer agar dapat segera diverifikasi oleh pengurus.\n\nTerima kasih atas perhatian dan kerja samanya."; ?>
                                                <?php if ($nomorWa !== ''): ?>
                                                    <a class="btn btn-xs btn-outline-success" target="_blank" href="https://wa.me/<?= esc($nomorWa) ?>?text=<?= rawurlencode($pesanTagihan) ?>">Kirim WA</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (!$adaTunggakan): ?>
                                        <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada tunggakan pada periode ini.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-lunas" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Warga</th>
                                        <th>Alamat</th>
                                        <th>Periode</th>
                                        <th class="text-center">Bulan Lunas</th>
                                        <th class="text-end">Total Terverifikasi</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $adaLunas = false; ?>
                                    <?php foreach ($rekapWarga as $warga): ?>
                                        <?php if (!$warga['lunas']) continue; ?>
                                        <?php $adaLunas = true; ?>
                                        <tr>
                                            <td class="fw-semibold text-dark"><?= esc($warga['nama']) ?></td>
                                            <td><?= esc($alamatWarga($warga)) ?></td>
                                            <td><?= esc($warga['periode_label']) ?></td>
                                            <td class="text-center"><?= $warga['jumlah_periode'] ?> bulan</td>
                                            <td class="text-end text-success fw-bold">Rp <?= number_format($warga['total_terverifikasi'], 0, ',', '.') ?></td>
                                            <td class="text-center"><span class="badge bg-success">Lunas</span></td>
                                            <td class="text-center">
                                                <?php $pembayaranTerverifikasi = $warga['pembayaran_terverifikasi'][0] ?? null; ?>
                                                <?php if ($pembayaranTerverifikasi): ?>
                                                    <div class="d-inline-flex flex-wrap justify-content-center gap-1">
                                                        <a class="btn btn-xs btn-outline-primary" href="<?= base_url('iuran/kuitansi/' . $pembayaranTerverifikasi['id']) ?>">Kuitansi</a>
                                                        <?php $nomorWa = \App\Libraries\IuranPeriodSummary::normalizePhone($warga['no_telepon'] ?? ''); ?>
                                                        <?php if ($nomorWa !== ''): ?>
                                                            <?php $pesanKuitansi = "Halo Bapak/Ibu {$warga['nama']},\n\nPembayaran iuran kas RT periode {$period['label']} sebesar Rp " . number_format($warga['total_terverifikasi'], 0, ',', '.') . " sudah diverifikasi. Kuitansi resmi dapat dibuka melalui menu Kuitansi.\n\nTerima kasih."; ?>
                                                            <a class="btn btn-xs btn-outline-success" target="_blank" href="https://wa.me/<?= esc($nomorWa) ?>?text=<?= rawurlencode($pesanKuitansi) ?>">Kirim WA</a>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (!$adaLunas): ?>
                                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada warga yang lunas pada periode ini.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-semua" role="tabpanel">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
                            <div>
                                <span class="fw-bold text-dark font-14">Buku Register Kas Iuran RT 04</span>
                                <small class="text-muted d-block">Periode <?= esc($period['label']) ?>. Urutan berdasarkan blok dan nomor rumah.</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-xs btn-outline-secondary" type="button" onclick="toggleAllIuranBlocks(true)">Buka Semua</button>
                                <button class="btn btn-xs btn-outline-secondary" type="button" onclick="toggleAllIuranBlocks(false)">Tutup Semua</button>
                            </div>
                        </div>

                        <div class="accordion d-flex flex-column gap-3" id="accordionIuranBukuKas">
                            <?php $blokIndex = 1; ?>
                            <?php foreach ($warga_per_blok as $namaBlok => $blokData): ?>
                                <div class="accordion-item border rounded-3 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header" id="headingIuranBlok<?= $blokIndex ?>">
                                        <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIuranBlok<?= $blokIndex ?>" aria-expanded="true">
                                            <span><?= esc($namaBlok) ?></span>
                                            <span class="text-muted font-12 fw-normal ms-2">(<?= count($blokData['warga']) ?> KK, Terkumpul Rp <?= number_format($blokData['terkumpul'], 0, ',', '.') ?> / Rp <?= number_format($blokData['target'], 0, ',', '.') ?>)</span>
                                        </button>
                                    </h2>
                                    <div id="collapseIuranBlok<?= $blokIndex ?>" class="accordion-collapse collapse show">
                                        <div class="accordion-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="ps-4">No. Rumah</th>
                                                            <th>Nama Warga</th>
                                                            <th>Periode</th>
                                                            <th class="text-end">Tagihan</th>
                                                            <th class="text-end">Terverifikasi</th>
                                                            <th class="text-end">Pending</th>
                                                            <th class="text-end">Sisa</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center pe-4">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($blokData['warga'] as $warga): ?>
                                                            <?php [$badgeClass, $badgeLabel] = $badgeStatus($warga); ?>
                                                            <tr>
                                                                <td class="ps-4 fw-bold"><?= esc($warga['no_rumah']) ?></td>
                                                                <td class="fw-semibold text-dark"><?= esc($warga['nama']) ?></td>
                                                                <td><?= esc($warga['periode_label']) ?></td>
                                                                <td class="text-end">Rp <?= number_format($warga['total_tagihan'], 0, ',', '.') ?></td>
                                                                <td class="text-end text-success">Rp <?= number_format($warga['total_terverifikasi'], 0, ',', '.') ?></td>
                                                                <td class="text-end text-warning">Rp <?= number_format($warga['total_pending'], 0, ',', '.') ?></td>
                                                                <td class="text-end <?= $warga['total_sisa'] > 0 ? 'text-danger fw-bold' : '' ?>">Rp <?= number_format($warga['total_sisa'], 0, ',', '.') ?></td>
                                                                <td class="text-center"><span class="badge <?= $badgeClass ?>"><?= $badgeLabel ?></span></td>
                                                                <td class="text-center pe-4">
                                                                    <?php $pembayaranPending = $warga['pembayaran_pending'][0] ?? null; ?>
                                                                    <?php $pembayaranTerverifikasi = $warga['pembayaran_terverifikasi'][0] ?? null; ?>
                                                                    <?php if ($pembayaranPending): ?>
                                                                        <a class="btn btn-xs btn-outline-warning" href="<?= base_url('iuran/verifikasi/' . $pembayaranPending['id']) ?>">Verifikasi</a>
                                                                    <?php elseif ($pembayaranTerverifikasi): ?>
                                                                        <div class="d-inline-flex flex-wrap justify-content-center gap-1">
                                                                            <a class="btn btn-xs btn-outline-primary" href="<?= base_url('iuran/kuitansi/' . $pembayaranTerverifikasi['id']) ?>">Kuitansi</a>
                                                                            <?php $nomorWa = \App\Libraries\IuranPeriodSummary::normalizePhone($warga['no_telepon'] ?? ''); ?>
                                                                            <?php if ($nomorWa !== ''): ?>
                                                                                <?php $pesanKuitansi = "Halo Bapak/Ibu {$warga['nama']},\n\nPembayaran iuran kas RT periode {$period['label']} sebesar Rp " . number_format($warga['total_terverifikasi'], 0, ',', '.') . " sudah diverifikasi. Kuitansi resmi dapat dibuka melalui menu Kuitansi.\n\nTerima kasih."; ?>
                                                                                <a class="btn btn-xs btn-outline-success" target="_blank" href="https://wa.me/<?= esc($nomorWa) ?>?text=<?= rawurlencode($pesanKuitansi) ?>">Kirim WA</a>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                        <?php if (empty($blokData['warga'])): ?>
                                                            <tr><td colspan="9" class="text-center py-3 text-muted">Belum ada warga aktif di blok ini untuk periode ini.</td></tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $blokIndex++; ?>
                            <?php endforeach; ?>
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
        bootstrap.Tab.getOrCreateInstance(tabEl).show();
    }
}

function aturFilterPeriodeIuran() {
    const jenis = document.getElementById('jenisPeriode').value;
    const filters = {
        bulanan: document.getElementById('filterBulanan'),
        tahunan: document.getElementById('filterTahunan'),
        rentang: document.getElementById('filterRentang'),
    };

    Object.entries(filters).forEach(([namaFilter, element]) => {
        const aktif = namaFilter === jenis;
        element.classList.toggle('d-none', !aktif);
        element.querySelectorAll('select').forEach((select) => {
            select.disabled = !aktif;
        });
    });
}

function validasiRentangIuran() {
    if (document.getElementById('jenisPeriode').value !== 'rentang') {
        return true;
    }

    const awal = (Number(document.getElementById('tahunAwal').value) * 12) + Number(document.getElementById('bulanAwal').value);
    const akhir = (Number(document.getElementById('tahunAkhir').value) * 12) + Number(document.getElementById('bulanAkhir').value);

    if (akhir < awal) {
        if (typeof showAppToast === 'function') {
            showAppToast('Periode akhir tidak boleh lebih awal dari periode mulai.', 'warning', 'Periode Tidak Valid');
        }
        return false;
    }

    return true;
}

function toggleAllIuranBlocks(open) {
    document.querySelectorAll('#accordionIuranBukuKas .accordion-collapse').forEach((element) => {
        const collapse = bootstrap.Collapse.getOrCreateInstance(element, {toggle: false});
        if (open) {
            collapse.show();
        } else {
            collapse.hide();
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    aturFilterPeriodeIuran();

    const tab = new URLSearchParams(window.location.search).get('tab');
    if (tab === 'tunggakan') {
        pilihTabIuran('pills-tunggakan-tab');
    }
});
</script>

<?= $this->endSection() ?>
