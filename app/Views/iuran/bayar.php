<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-9 mx-auto">
        <!-- Alert Tunggakan -->
        <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis d-flex align-items-start p-3 mb-4 rounded-3 shadow-sm">
            <i data-feather="alert-circle" class="me-3 flex-shrink-0 mt-1" style="width: 20px; height: 20px;"></i>
            <div>
                <h6 class="fw-bold mb-1">Pemberitahuan Tunggakan</h6>
                <p class="mb-0 font-13">Anda memiliki <strong>2 bulan tagihan iuran</strong> yang belum lunas (Juli & Agustus 2026). Sistem menerapkan metode pembayaran berurutan (FIFO), bulan terlama harus dilunasi lebih dahulu.</p>
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
                        <p class="text-muted small mb-0 mt-1">Pilih periode tagihan dan unggah bukti transfer</p>
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
                                        Bayar Semua Sekaligus (2 Bulan)
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
                                            <input class="form-check-input period-check" type="checkbox" name="periode[]" value="<?= $t['tahun'] . '-' . sprintf('%02d', $t['bulan']) ?>" id="p_<?= $t['bulan'] ?>" data-nominal="<?= $t['tarif'] ?>" checked onchange="handleCheck(<?= $i ?>)">
                                            <!-- Kita sisipkan input tersembunyi agar form bayar mengambil periode dari yang dicheck (but the controller currently gets periode_bulan/tahun directly from post. We will modify the form to send an array and process it, but for now we just keep the checkbox logic and let JS calculate total) -->
                                            <input type="hidden" name="periode_bulan" value="<?= $t['bulan'] ?>">
                                            <input type="hidden" name="periode_tahun" value="<?= $t['tahun'] ?>">
                                            <label class="form-check-label ms-2 cursor-pointer" for="p_<?= $t['bulan'] ?>">
                                                <span class="d-block fw-semibold text-dark">Iuran <?= date('F Y', mktime(0, 0, 0, $t['bulan'], 1, $t['tahun'])) ?></span>
                                                <?php if ($t['status'] == 'Tunggakan'): ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle font-11 mt-1">Tunggakan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle font-11 mt-1">Bulan Berjalan</span>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                        <span class="fw-bold text-dark">Rp <?= number_format($t['tarif'], 0, ',', '.') ?></span>
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
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-white shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded p-1 px-2 me-2 font-12 fw-bold">BCA</div>
                                            <span class="fw-bold text-dark font-14">Bank Transfer</span>
                                        </div>
                                        <i data-feather="copy" class="text-muted cursor-pointer" style="width: 16px; height: 16px;" title="Salin Rekening"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-1 font-monospace" style="letter-spacing: 1px;">8830-1234-5678</h4>
                                    <span class="text-muted small">a.n. Kas RT 06 RW 20 Purwodadi</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-white shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger text-white rounded p-1 px-2 me-2 font-12 fw-bold">QRIS</div>
                                            <span class="fw-bold text-dark font-14">E-Wallet</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 68px; height: 68px; overflow: hidden; border-radius: 8px; border: 1px solid #ddd; position: relative;">
                                            <div style="transform: scale(0.18); transform-origin: top left; width: 380px;">
                                                <?= $this->include('components/qris_card') ?>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark font-12 d-block">KAS RT 06 RW 20</span>
                                            <small class="text-muted font-11 d-block mb-1">NMID: ID1024098234120</small>
                                            <a href="javascript:void(0)" class="text-danger font-11 fw-semibold text-decoration-none d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalQris">
                                                <i data-feather="zoom-in" style="width: 12px; height: 12px;" class="me-1"></i> Perbesar QR
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

<!-- Modal Perbesar QRIS -->
<div class="modal fade" id="modalQris" tabindex="-1" aria-labelledby="modalQrisLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-4 pt-2">
                <h5 class="fw-bold text-dark mb-1" id="modalQrisLabel">QRIS Kas RT 06</h5>
                <p class="text-muted small mb-3">Scan menggunakan M-Banking atau E-Wallet Anda</p>
                <div class="mb-3 d-flex justify-content-center">
                    <div style="transform: scale(0.7); transform-origin: center center; margin-bottom: -150px; margin-top: -30px;">
                        <?= $this->include('components/qris_card') ?>
                    </div>
                </div>
                <div class="bg-danger bg-opacity-10 text-danger rounded p-2 px-3 d-inline-block">
                    <span class="d-block font-11 fw-bold">NMID</span>
                    <span class="font-monospace fw-bold">ID1024098234120</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
        if (typeof showAppToast === 'function') {
            showAppToast('Pilih minimal satu bulan tagihan untuk dibayar.', 'warning', 'Peringatan');
        } else {
            alert('Pilih minimal satu bulan tagihan untuk dibayar.');
        }
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
