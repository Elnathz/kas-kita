<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-9 mx-auto">
        <!-- Alert Tunggakan jika ada -->
        <div class="alert alert-warning border-0 rounded p-3 mb-4 d-flex align-items-center">
            <i data-feather="alert-circle" class="feather-icon text-warning me-2"></i>
            <div>
                <strong>Perhatian:</strong> Anda memiliki <strong>2 bulan tagihan iuran</strong> yang belum lunas (Juli & Agustus 2026). Anda dapat melunasi sekaligus atau mencicil per bulan (dimulai dari bulan tertua).
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Tagihan & Pembayaran Iuran Kas</h4>
                        <p class="text-muted small mb-0">Pilih periode bulan yang ingin Anda bayar, lalu unggah bukti transfer.</p>
                    </div>
                </div>

                <form action="<?= base_url('iuran/bayar/proses') ?>" method="post" enctype="multipart/form-data" id="formBayar">
                    <?= csrf_field() ?>

                    <!-- Pilihan Periode Tagihan yang Belum Lunas -->
                    <h6 class="fw-bold text-dark mb-3">1. Pilih Periode yang Ingin Dibayar:</h6>
                    
                    <div class="border rounded p-3 bg-light mb-4">
                        <div class="form-check mb-3 pb-2 border-bottom">
                            <input class="form-check-input" type="checkbox" id="checkAll" onchange="toggleSelectAll(this)">
                            <label class="form-check-label fw-bold text-primary" for="checkAll">
                                Bayar Semua Sekaligus (2 Bulan)
                            </label>
                        </div>

                        <!-- Item Bulan 1 (Tunggakan Tertua) -->
                        <div class="form-check d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <input class="form-check-input period-check" type="checkbox" name="periode[]" value="2026-07" id="p_jul" data-nominal="50000" checked onchange="calculateTotal()">
                                <label class="form-check-label fw-semibold text-dark ms-2" for="p_jul">
                                    Juli 2026 <span class="badge bg-danger ms-1">Tunggakan Bulan Lalu</span>
                                </label>
                            </div>
                            <span class="fw-bold text-dark">Rp 50.000</span>
                        </div>

                        <!-- Item Bulan 2 (Bulan Berjalan) -->
                        <div class="form-check d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <input class="form-check-input period-check" type="checkbox" name="periode[]" value="2026-08" id="p_agu" data-nominal="50000" checked onchange="calculateTotal()">
                                <label class="form-check-label fw-semibold text-dark ms-2" for="p_agu">
                                    Agustus 2026 <span class="badge bg-warning text-dark ms-1">Bulan Berjalan</span>
                                </label>
                            </div>
                            <span class="fw-bold text-dark">Rp 50.000</span>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">Total yang Harus Ditransfer:</span>
                            <span class="fw-bold text-success fs-4" id="displayTotal">Rp 100.000</span>
                        </div>
                    </div>

                    <!-- Rekening Tujuan Kas RT -->
                    <h6 class="fw-bold text-dark mb-3">2. Transfer ke Rekening Kas RT:</h6>
                    <div class="alert alert-info border-0 rounded p-3 mb-4">
                        <div class="row g-2 small">
                            <div class="col-sm-6">
                                <strong>Bank BCA:</strong> 123-456-7890<br>
                                a.n. Kas RT 04 RW 12
                            </div>
                            <div class="col-sm-6">
                                <strong>Bank Mandiri:</strong> 987-654-3210<br>
                                a.n. Kas RT 04 RW 12
                            </div>
                        </div>
                    </div>

                    <!-- Upload Bukti Transfer -->
                    <h6 class="fw-bold text-dark mb-3">3. Unggah Bukti Transfer:</h6>
                    <div class="mb-4">
                        <label class="form-label text-muted small" for="bukti_transfer">Format gambar (JPG, PNG) maksimum 2MB</label>
                        <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept="image/jpeg,image/png" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">Kirim Konfirmasi Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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
    
    // Update Select All state
    const checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.checked = (checkedCount === checks.length && checks.length > 0);
    }
}

function toggleSelectAll(master) {
    const checks = document.querySelectorAll('.period-check');
    checks.forEach(c => {
        c.checked = master.checked;
    });
    calculateTotal();
}
</script>
<?= $this->endSection() ?>
