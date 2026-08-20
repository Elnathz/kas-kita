<div class="qris-card position-relative bg-white mx-auto overflow-hidden shadow-sm" style="max-width: 380px; border-radius: 12px; border: 1px solid #ddd; font-family: 'Inter', sans-serif;">
    <!-- Background Patterns -->
    <div class="position-absolute w-100 h-100" style="opacity: 0.05; background-image: radial-gradient(#000 1px, transparent 1px); background-size: 10px 10px; z-index: 0;"></div>
    
    <!-- Red Accent Top Left -->
    <div class="position-absolute bg-danger" style="width: 150px; height: 150px; transform: rotate(45deg); top: -75px; left: -75px; z-index: 1;"></div>
    
    <!-- Red Accent Bottom Right -->
    <div class="position-absolute bg-danger" style="width: 250px; height: 250px; transform: rotate(45deg); bottom: -125px; right: -125px; z-index: 1;"></div>

    <div class="position-relative p-4" style="z-index: 2;">
        <!-- Header Logos -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center bg-white px-2 py-1 rounded shadow-sm" style="margin-left: 20px;">
                <span class="fw-bold fs-4 fst-italic me-1" style="color: #002B5B; letter-spacing: -1px;">QRIS</span>
                <div class="lh-1" style="font-size: 8px; color: #444;">
                    <span class="fw-bold d-block">QR Code Standar</span>
                    <span>Pembayaran Nasional</span>
                </div>
            </div>
            <div class="bg-white px-2 py-1 rounded shadow-sm">
                <!-- GPN Logo Placeholder -->
                <div class="fw-bold fst-italic" style="color: #002B5B; font-size: 18px; border-bottom: 2px solid #DC3545; line-height: 1;">GPN</div>
            </div>
        </div>

        <!-- Merchant Info -->
        <div class="text-center mb-3">
            <h5 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;"><?= $merchant_name ?? 'KAS RT' ?></h5>
            <p class="mb-0 text-dark font-12">NMID: <?= $nmid ?? 'ID1024098234120' ?></p>
            <p class="mb-0 text-muted" style="font-size: 10px;">TID: <?= $tid ?? 'A01' ?></p>
        </div>

        <!-- QR Code Image -->
        <div class="bg-white p-2 border border-2 mx-auto mb-3 shadow-sm" style="width: 200px; height: 200px; border-radius: 8px;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= urlencode('https://qris.id/pay?merchant=' . ($nmid ?? 'ID1024098234120')) ?>" alt="QR Code" class="w-100 h-100">
        </div>

        <!-- Slogan -->
        <div class="text-center mb-4">
            <h6 class="fw-bold text-dark mb-1 font-12">SATU QRIS UNTUK SEMUA</h6>
            <p class="mb-0 text-muted" style="font-size: 9px;">Cek aplikasi penyelenggara di: <span class="text-dark fw-medium">www.aspi-qris.id</span></p>
        </div>

        <!-- Footer Info -->
        <div class="d-flex justify-content-between align-items-end mt-4">
            <div style="font-size: 8px; color: #666; margin-bottom: -10px;">
                <p class="mb-0">Dicetak oleh: [Bank BCA]</p>
                <p class="mb-0">Versi cetak: 1.0.0</p>
            </div>
            
            <div class="text-end text-white position-relative" style="z-index: 3; margin-right: 15px; margin-bottom: 5px;">
                <p class="mb-2 fw-bold text-start ps-1" style="font-size: 9px;">Cara bayar dengan QRIS:</p>
                <div class="d-flex gap-2 justify-content-end">
                    <div class="text-center">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-1 text-danger" style="width: 24px; height: 24px; font-weight: bold; font-size: 12px;">1</div>
                        <span style="font-size: 7px; display: block; max-width: 40px; line-height: 1;">Buka Aplikasi</span>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-1 text-danger" style="width: 24px; height: 24px; font-weight: bold; font-size: 12px;">2</div>
                        <span style="font-size: 7px; display: block; max-width: 40px; line-height: 1;">Scan QR</span>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-1 text-danger" style="width: 24px; height: 24px; font-weight: bold; font-size: 12px;">3</div>
                        <span style="font-size: 7px; display: block; max-width: 40px; line-height: 1;">Bayar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
