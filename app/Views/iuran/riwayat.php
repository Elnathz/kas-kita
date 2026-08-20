<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?><?php
$bulanNama = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
];
$tahunAktif = $tahun_aktif ?? date('Y');
$tahunTersedia = $tahun_tersedia ?? [$tahunAktif];
?>
<style>
.iuran-nominal {
    min-width: 110px;
    white-space: nowrap;
}
.riwayat-bukti-stage {
    min-height: 360px;
    max-height: 68vh;
    overflow: auto;
    background: #eef1f4;
}
.riwayat-bukti-image {
    max-width: 100%;
    max-height: 62vh;
    object-fit: contain;
    transform-origin: center center;
    transition: transform .15s ease;
    cursor: zoom-in;
}
.riwayat-bukti-image.is-zoomed { cursor: grab; }
.riwayat-bukti-toolbar .btn { min-width: 36px; }
</style>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Riwayat Pembayaran Iuran Saya</h4>
                        <p class="text-muted small mb-0">Catatan pembayaran iuran Anda untuk tahun <?= esc($tahunAktif) ?>.</p>
                    </div>
                    <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-success btn-sm">Bayar Iuran</a>
                </div>

                <div class="nav nav-pills gap-2 mb-4" role="tablist" aria-label="Pilih tahun riwayat pembayaran">
                    <?php foreach ($tahunTersedia as $tahun): ?>
                        <a class="nav-link <?= (int) $tahun === (int) $tahunAktif ? 'active' : '' ?>" href="<?= base_url('iuran/riwayat') ?>?tahun=<?= $tahun ?>">
                            <?= esc($tahun) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th class="iuran-nominal">Nominal</th>
                                <th>Tanggal Bayar</th>
                                <th>Status Verifikasi</th>
                                <th>Bukti Transfer</th>
                                <th>Lampiran Pengurus</th>
                                <th>Catatan Pengurus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pembayaran)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat pembayaran iuran.</td>
                            </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($pembayaran as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-semibold"><?= esc($bulanNama[(int) $p['periode_bulan']] ?? '-') ?> <?= esc($p['periode_tahun']) ?></td>
                                    <td class="iuran-nominal">Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                    <td><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                                    <td>
                                        <?php if ($p['status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                        <?php elseif ($p['status'] == 'terverifikasi'): ?>
                                            <span class="badge bg-success">Terverifikasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <?php if (!empty($p['bukti_transfer'])): ?>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="lihatRiwayatBukti('Bukti Transfer', <?= esc(json_encode(($bulanNama[(int) $p['periode_bulan']] ?? '-') . ' ' . $p['periode_tahun']), 'attr') ?>, <?= esc(json_encode('Rp ' . number_format($p['nominal'], 0, ',', '.')), 'attr') ?>, <?= esc(json_encode(date('d M Y - H:i', strtotime($p['created_at'])) . ' WIB'), 'attr') ?>, <?= esc(json_encode($p['bukti_transfer']), 'attr') ?>, '')">Lihat</button>
                                        <?php else: ?>-
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <?php if ($p['status'] === 'ditolak' && !empty($p['bukti_penolakan'])): ?>
                                            <button type="button" class="btn btn-xs btn-outline-danger" onclick="lihatRiwayatBukti('Lampiran Pengurus', <?= esc(json_encode(($bulanNama[(int) $p['periode_bulan']] ?? '-') . ' ' . $p['periode_tahun']), 'attr') ?>, <?= esc(json_encode('Rp ' . number_format($p['nominal'], 0, ',', '.')), 'attr') ?>, <?= esc(json_encode(date('d M Y - H:i', strtotime($p['verified_at'] ?? $p['created_at'])) . ' WIB'), 'attr') ?>, <?= esc(json_encode($p['bukti_penolakan']), 'attr') ?>, <?= esc(json_encode($p['catatan'] ?? ''), 'attr') ?>)">Lihat</button>
                                        <?php else: ?>-
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small" style="min-width: 220px;">
                                        <?php if ($p['status'] === 'ditolak' && !empty($p['catatan'])): ?>
                                            <span class="text-danger"><?= esc($p['catatan']) ?></span>
                                        <?php else: ?>-
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRiwayatBukti" tabindex="-1" aria-labelledby="modalRiwayatBuktiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" id="riwayatBuktiDialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="modalRiwayatBuktiLabel">
                    <i data-feather="file-text" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                    <span id="riwayatBuktiJenis">Bukti Transfer</span> Pembayaran Iuran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="riwayat-bukti-toolbar d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomRiwayatBukti(-0.2)" title="Perkecil"><i data-feather="zoom-out" style="width: 14px; height: 14px;"></i></button>
                    <span class="small text-muted" id="riwayatBuktiZoomLabel">100%</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomRiwayatBukti(0.2)" title="Perbesar"><i data-feather="zoom-in" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetRiwayatBuktiZoom()">Reset</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleRiwayatBuktiFullscreen()"><i data-feather="maximize-2" style="width: 14px; height: 14px;"></i> Layar penuh</button>
                </div>
                <div id="riwayatBuktiStage" class="riwayat-bukti-stage p-3 rounded-3 border d-flex align-items-center justify-content-center mb-3">
                    <div id="riwayatBuktiWrapper" class="d-flex align-items-center justify-content-center w-100 h-100"></div>
                </div>
                <h6 class="fw-bold text-dark mb-1" id="riwayatBuktiPeriode">-</h6>
                <span class="text-success fw-bold fs-6 d-block mb-1" id="riwayatBuktiNominal">-</span>
                <small class="text-muted d-block mb-2 font-12" id="riwayatBuktiWaktu">-</small>
                <span class="badge bg-white text-dark border font-11 px-2 py-1" id="riwayatBuktiFilename">-</span>
                <div id="riwayatBuktiCatatanWrapper" class="alert alert-danger text-start font-12 py-2 px-3 mt-3 mb-0 d-none">
                    <div class="fw-semibold mb-1"><i data-feather="message-square" style="width: 14px; height: 14px;"></i> Catatan Pengurus</div>
                    <div id="riwayatBuktiCatatan"></div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <a id="riwayatBuktiDownload" class="btn btn-success btn-sm fw-semibold" href="#" download><i data-feather="download" style="width: 14px; height: 14px;"></i> Unduh File</a>
            </div>
        </div>
    </div>
</div>

<script>
let riwayatBuktiScale = 1;
function resolveRiwayatBuktiUrl(filename) {
    const baseUrl = '<?= base_url() ?>';
    if (filename.startsWith('assets/') || filename.startsWith('uploads/')) return baseUrl + filename;
    return baseUrl + 'uploads/bukti/' + filename;
}
function applyRiwayatBuktiZoom() {
    const image = document.getElementById('riwayatBuktiImage');
    const label = document.getElementById('riwayatBuktiZoomLabel');
    if (image) {
        image.style.transform = 'scale(' + riwayatBuktiScale + ')';
        image.classList.toggle('is-zoomed', riwayatBuktiScale > 1);
    }
    if (label) label.textContent = Math.round(riwayatBuktiScale * 100) + '%';
}
function zoomRiwayatBukti(step) {
    riwayatBuktiScale = Math.min(3, Math.max(1, riwayatBuktiScale + step));
    applyRiwayatBuktiZoom();
}
function resetRiwayatBuktiZoom() {
    riwayatBuktiScale = 1;
    applyRiwayatBuktiZoom();
}
function toggleRiwayatBuktiFullscreen() {
    const dialog = document.getElementById('riwayatBuktiDialog');
    const stage = document.getElementById('riwayatBuktiStage');
    dialog.classList.toggle('modal-fullscreen');
    stage.style.maxHeight = dialog.classList.contains('modal-fullscreen') ? '78vh' : '68vh';
}
function lihatRiwayatBukti(jenis, periode, nominal, waktu, filename, catatan = '') {
    document.getElementById('riwayatBuktiJenis').textContent = jenis;
    document.getElementById('riwayatBuktiPeriode').textContent = 'Iuran Kas RT: ' + periode;
    document.getElementById('riwayatBuktiNominal').textContent = nominal;
    document.getElementById('riwayatBuktiWaktu').textContent = 'Diunggah pada ' + waktu;
    document.getElementById('riwayatBuktiFilename').textContent = filename || 'Tidak ada lampiran';
    const wrapper = document.getElementById('riwayatBuktiWrapper');
    wrapper.innerHTML = '';
    const download = document.getElementById('riwayatBuktiDownload');
    const catatanWrapper = document.getElementById('riwayatBuktiCatatanWrapper');
    document.getElementById('riwayatBuktiCatatan').textContent = catatan || '';
    catatanWrapper.classList.toggle('d-none', !catatan);
    resetRiwayatBuktiZoom();

    if (!filename) {
        wrapper.innerHTML = '<div class="text-muted font-13 py-5">Lampiran tidak tersedia.</div>';
        download.classList.add('d-none');
    } else {
        const url = resolveRiwayatBuktiUrl(filename);
        download.href = url;
        download.setAttribute('download', filename.split('/').pop());
        download.classList.remove('d-none');
        if (/\.(jpeg|jpg|gif|png|webp)$/i.test(filename)) {
            const image = document.createElement('img');
            image.id = 'riwayatBuktiImage';
            image.src = url;
            image.alt = jenis;
            image.className = 'riwayat-bukti-image rounded border shadow-sm';
            image.addEventListener('dblclick', resetRiwayatBuktiZoom);
            wrapper.appendChild(image);
            applyRiwayatBuktiZoom();
        } else {
            const link = document.createElement('a');
            link.href = url;
            link.target = '_blank';
            link.rel = 'noopener';
            link.className = 'btn btn-outline-primary';
            link.textContent = 'Buka Dokumen';
            wrapper.appendChild(link);
        }
    }
    new bootstrap.Modal(document.getElementById('modalRiwayatBukti')).show();
    if (typeof feather !== 'undefined') feather.replace();
}
</script>
<?= $this->endSection() ?>
