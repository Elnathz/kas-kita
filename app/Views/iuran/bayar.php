<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<style>
.iuran-nominal {
    min-width: 110px;
    white-space: nowrap;
}
.payment-method-card {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 1rem;
    height: 100%;
    background: #fff;
}
.payment-method-body {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}
.payment-method-details {
    min-width: 0;
    flex: 1 1 auto;
}
.payment-method-preview {
    width: 132px;
    height: 132px;
    flex: 0 0 132px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: .45rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #f8fafc;
}
.payment-method-preview img {
    display: block;
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
}
.qris-preview-trigger {
    display: block;
    border: 0;
    cursor: zoom-in;
    background: transparent;
}
.qris-preview-trigger:focus-visible {
    outline: 2px solid #0d6efd;
    outline-offset: 3px;
    border-radius: 8px;
}
.qris-modal-stage {
    min-height: 420px;
    max-height: 76vh;
    overflow: auto;
    background: #eef1f4;
}
#qrisPreviewImage {
    max-width: 100%;
    max-height: 68vh;
    object-fit: contain;
    transform-origin: center center;
    transition: transform .15s ease;
    cursor: zoom-in;
}
#qrisPreviewImage.is-zoomed { cursor: grab; }
.qris-preview-toolbar .btn { min-width: 36px; }
@media (max-width: 575.98px) {
    .payment-method-body {
        flex-direction: column;
    }
    .payment-method-preview {
        width: 150px;
        height: 150px;
        flex-basis: 150px;
        align-self: center;
    }
}
</style>
<div class="row">
    <div class="col-lg-9 mx-auto">
        <!-- Alert Tunggakan -->
        <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis d-flex align-items-start p-3 mb-4 rounded-3 shadow-sm">
            <i data-feather="alert-circle" class="me-3 flex-shrink-0 mt-1" style="width: 20px; height: 20px;"></i>
            <div>
                <h6 class="fw-bold mb-1">Pemberitahuan Tunggakan</h6>
                <p class="mb-0 font-13">Anda memiliki <strong><?= count($tagihan_list) ?> bulan tagihan iuran</strong> yang belum lunas. Sistem menerapkan metode pembayaran berurutan (FIFO), bulan terlama harus dilunasi lebih dahulu.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                        <i data-feather="credit-card" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">Form Pembayaran Iuran</h5>
                        <p class="text-muted small mb-0 mt-1">Pilih periode tagihan dari <?= esc($period['label'] ?? 'periode aktif') ?> dan unggah bukti transfer</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="<?= base_url('iuran/bayar/proses') ?>" method="post" enctype="multipart/form-data" id="formBayar" onsubmit="return validatePayment()">
                    <?= csrf_field() ?>

                    <!-- Pilihan Periode Tagihan -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3"><span class="bg-light text-muted px-2 py-1 rounded me-2">1</span>Pilih Periode Tagihan</h6>
                        
                        <div class="border rounded-3 p-0 overflow-hidden">
                            <div class="bg-light p-3 border-bottom d-flex justify-content-between align-items-center">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="checkAll" checked onchange="toggleSelectAll(this)">
                                    <label class="form-check-label fw-bold text-dark" for="checkAll">
                                        Bayar Semua Sekaligus (<?= count($tagihan_list) ?> Bulan)
                                    </label>
                                </div>
                            </div>

                            <div class="p-3">
                                <?php if (empty($tagihan_list)): ?>
                                    <div class="text-center py-3">
                                        <p class="mb-0 text-success fw-bold">Semua tagihan iuran Anda sudah lunas.</p>
                                    </div>
                                <?php else: ?>
                                    <?php $i = 0; foreach ($tagihan_list as $t): ?>
                                    <!-- Item Bulan <?= $i + 1 ?> -->
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input period-check" type="checkbox" name="periode[]" value="<?= $t['tahun'] . '-' . sprintf('%02d', $t['bulan']) ?>" id="p_<?= $t['tahun'] ?>_<?= $t['bulan'] ?>" data-nominal="<?= $t['tarif'] ?>" checked onchange="handleCheck(<?= $i ?>)">
                                            <!-- array periode[] akan diproses controller multibayar -->
                                            <label class="form-check-label ms-2 cursor-pointer" for="p_<?= $t['tahun'] ?>_<?= $t['bulan'] ?>">
                                                <span class="d-block fw-semibold text-dark">Iuran <?= esc($t['label']) ?></span>
                                                <?php if ($t['status'] == 'Tunggakan'): ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle font-11 mt-1">Tunggakan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle font-11 mt-1">Bulan Berjalan</span>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                        <span class="fw-bold text-dark iuran-nominal">Rp <?= number_format($t['tarif'], 0, ',', '.') ?></span>
                                    </div>
                                    <?php $i++; endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="bg-success-subtle bg-opacity-50 p-3 border-top d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">Total Tagihan:</span>
                                <span class="fw-bold text-success fs-4" id="displayTotal">Rp 0</span>
                                <input type="hidden" name="nominal" id="inputNominal" value="0">
                            </div>
                        </div>
                    </div>

                    <!-- Rekening Tujuan Kas RT -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3"><span class="bg-light text-muted px-2 py-1 rounded me-2">2</span>Tujuan Transfer</h6>
                        <div class="row g-3">
                            <?php foreach (($metodePembayaran ?? []) as $metode): ?>
                                <?php $gambarMetode = !empty($metode['gambar']) ? (is_file(FCPATH . 'uploads/metode-pembayaran/' . $metode['gambar']) ? base_url('uploads/metode-pembayaran/' . $metode['gambar']) : base_url('assets/images/' . $metode['gambar'])) : ''; ?>
                                <div class="col-md-6">
                                    <div class="payment-method-card shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="badge <?= $metode['jenis'] === 'qris' ? 'bg-danger' : 'bg-primary' ?> me-2"><?= esc(strtoupper($metode['jenis'])) ?></span>
                                                <span class="fw-bold text-dark font-14"><?= esc($metode['nama_metode']) ?></span>
                                            </div>
                                        </div>
                                        <div class="payment-method-body">
                                            <div class="payment-method-details">
                                                <?php if (!empty($metode['nomor'])): ?><h5 class="fw-bold text-dark mb-1 font-monospace"><?= esc($metode['nomor']) ?></h5><?php endif; ?>
                                                <?php if (!empty($metode['atas_nama'])): ?><span class="text-muted small d-block">a.n. <?= esc($metode['atas_nama']) ?></span><?php endif; ?>
                                                <?php if (!empty($metode['detail'])): ?><small class="text-muted d-block mt-2"><?= esc($metode['detail']) ?></small><?php endif; ?>
                                            </div>
                                            <?php if ($gambarMetode): ?>
                                                <div class="payment-method-preview">
                                                    <?php if ($metode['jenis'] === 'qris'): ?>
                                                        <button type="button" class="qris-preview-trigger p-0" onclick="lihatQris(<?= esc(json_encode($gambarMetode), 'attr') ?>, <?= esc(json_encode($metode['nama_metode']), 'attr') ?>)">
                                                            <img src="<?= esc($gambarMetode) ?>" alt="<?= esc($metode['nama_metode']) ?>">
                                                        </button>
                                                    <?php else: ?>
                                                        <img src="<?= esc($gambarMetode) ?>" alt="<?= esc($metode['nama_metode']) ?>">
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (empty($metodePembayaran)): ?>
                                <div class="col-12"><div class="alert alert-warning mb-0">Belum ada metode pembayaran aktif. Hubungi pengurus RT.</div></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Upload Bukti Transfer -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3"><span class="bg-light text-muted px-2 py-1 rounded me-2">3</span>Bukti Transfer</h6>
                        <div class="rounded-3 p-4 text-center" style="border: 2px dashed #10b981; background-color: #f0fdf4;">
                            <i data-feather="upload-cloud" class="text-success mb-2" style="width: 36px; height: 36px;"></i>
                            <div class="mb-3">
                                <span class="d-block fw-bold text-success mb-1">Pilih gambar atau tarik ke sini</span>
                                <span class="text-success small" style="opacity: 0.8;">Format didukung: JPG, JPEG, PNG (Maks. 2MB)</span>
                            </div>
                            <input type="file" class="form-control border-success text-success w-75 mx-auto shadow-sm" id="bukti_transfer" name="bukti_transfer" accept="image/jpeg,image/png" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('dashboard-warga') ?>" class="btn btn-outline-secondary fw-semibold px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm" id="btnSubmit">Kirim Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalQrisPreview" tabindex="-1" aria-labelledby="modalQrisPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" id="qrisPreviewDialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="modalQrisPreviewLabel">
                    <i data-feather="maximize" class="feather-icon text-danger me-2" style="width: 16px; height: 16px;"></i>
                    <span id="qrisPreviewTitle">QRIS Kas RT</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="qris-preview-toolbar d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomQris(-0.2)" title="Perkecil"><i data-feather="zoom-out" style="width: 14px; height: 14px;"></i></button>
                    <span class="small text-muted" id="qrisPreviewZoomLabel">100%</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomQris(0.2)" title="Perbesar"><i data-feather="zoom-in" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetQrisZoom()">Reset</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleQrisFullscreen()"><i data-feather="maximize-2" style="width: 14px; height: 14px;"></i> Layar penuh</button>
                </div>
                <div class="qris-modal-stage p-3 rounded-3 border d-flex align-items-center justify-content-center">
                    <img id="qrisPreviewImage" src="" alt="QRIS Kas RT" class="rounded border shadow-sm">
                </div>
                <span class="badge bg-white text-dark border font-11 px-2 py-1 mt-3" id="qrisPreviewFilename">qris.jpg</span>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <a id="qrisPreviewDownload" class="btn btn-success btn-sm fw-semibold" href="#" download><i data-feather="download" style="width: 14px; height: 14px;"></i> Unduh QRIS</a>
            </div>
        </div>
    </div>
</div>

<script>
let qrisPreviewScale = 1;
function applyQrisZoom() {
    const image = document.getElementById('qrisPreviewImage');
    const label = document.getElementById('qrisPreviewZoomLabel');
    image.style.transform = 'scale(' + qrisPreviewScale + ')';
    image.classList.toggle('is-zoomed', qrisPreviewScale > 1);
    label.textContent = Math.round(qrisPreviewScale * 100) + '%';
}
function zoomQris(step) {
    qrisPreviewScale = Math.min(3, Math.max(1, qrisPreviewScale + step));
    applyQrisZoom();
}
function resetQrisZoom() {
    qrisPreviewScale = 1;
    applyQrisZoom();
}
function toggleQrisFullscreen() {
    const dialog = document.getElementById('qrisPreviewDialog');
    const stage = dialog.querySelector('.qris-modal-stage');
    dialog.classList.toggle('modal-fullscreen');
    stage.style.maxHeight = dialog.classList.contains('modal-fullscreen') ? '82vh' : '76vh';
}
function lihatQris(url, nama) {
    const image = document.getElementById('qrisPreviewImage');
    const download = document.getElementById('qrisPreviewDownload');
    const filename = url.split('/').pop() || 'qris.jpg';
    document.getElementById('qrisPreviewTitle').textContent = nama;
    document.getElementById('qrisPreviewFilename').textContent = filename;
    image.src = url;
    download.href = url;
    download.setAttribute('download', filename);
    resetQrisZoom();
    new bootstrap.Modal(document.getElementById('modalQrisPreview')).show();
    if (typeof feather !== 'undefined') feather.replace();
}

function handleCheck(currentIndex) {
    const checks = document.querySelectorAll('.period-check');
    const isChecked = checks[currentIndex].checked;

    if (isChecked) {
        // Jika mencentang bulan baru, bulan sebelumnya WAJIB tercentang (FIFO)
        for (let i = 0; i < currentIndex; i++) {
            checks[i].checked = true;
        }
    } else {
        // Jika menghapus centang, bulan setelahnya WAJIB ikut terhapus
        for (let i = currentIndex + 1; i < checks.length; i++) {
            checks[i].checked = false;
        }
    }
    
    calculateTotal();
}

function calculateTotal() {
    const checks = document.querySelectorAll('.period-check');
    let total = 0;
    let checkedCount = 0;

    checks.forEach(c => {
        if (c.checked) {
            total += parseInt(c.getAttribute('data-nominal'));
            checkedCount++;
        }
    });

    // Format Rupiah
    document.getElementById('displayTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('inputNominal').value = total;
    
    // Update Select All state
    const checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.checked = (checkedCount === checks.length && checks.length > 0);
    }

    // Disable submit if total is 0
    document.getElementById('btnSubmit').disabled = (checkedCount === 0);
}

// Set initial total on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

function toggleSelectAll(master) {
    const checks = document.querySelectorAll('.period-check');
    checks.forEach(c => {
        c.checked = master.checked;
    });
    calculateTotal();
}

function validatePayment() {
    const checks = document.querySelectorAll('.period-check');
    let hasChecked = false;
    checks.forEach(c => {
        if (c.checked) hasChecked = true;
    });

    if (!hasChecked) {
        showAppToast('Pilih minimal satu bulan tagihan untuk dibayar.', 'warning', 'Peringatan');
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>
<?= $this->endSection() ?>
