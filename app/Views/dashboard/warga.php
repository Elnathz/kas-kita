<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
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
                        <h2 class="fw-bold text-white mb-3">Selamat Datang, <span class="text-success"><?= esc(session()->get('nama')) ?></span></h2>
                        
                        <div class="d-flex flex-wrap gap-4 text-white-50 font-14">
                            <div class="d-flex align-items-center bg-black bg-opacity-25 rounded px-3 py-2 border border-white border-opacity-10">
                                <i data-feather="map-pin" class="text-white-50 me-2" style="width: 16px; height: 16px;"></i>
                                <span class="text-white fw-medium"><?= esc(session()->get('no_rumah')) ?></span>
                            </div>
                            <div class="d-flex align-items-center bg-black bg-opacity-25 rounded px-3 py-2 border border-white border-opacity-10">
                                <i data-feather="phone" class="text-white-50 me-2" style="width: 16px; height: 16px;"></i>
                                <span class="text-white fw-medium"><?= esc(session()->get('no_telepon') ?? '-') ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sisi Kanan: Tagihan Berjalan -->
                    <div class="col-xl-4">
                        <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-25 shadow" style="backdrop-filter: blur(8px);">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <span class="text-white-50 small d-block mb-1">Tagihan Bulan Berjalan</span>
                                    <h3 class="fw-bold text-white mb-0">Rp <?= number_format($nominalIuran, 0, ',', '.') ?></h3>
                                    <small class="text-success fw-semibold"><?= date('F Y') ?></small>
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
                    <span class="text-muted small d-block mb-1">Status Iuran <?= date('F Y') ?></span>
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
                    <small class="text-muted font-12"><?= $totalTunggakanSaya > 0 ? '1 Periode Belum Lunas' : 'Tidak Ada Tunggakan' ?></small>
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

                <div class="table-responsive flex-grow-1">
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
                                        <td class="fw-semibold text-dark text-nowrap">Bulan <?= $riwayat['periode_bulan'] ?> <?= $riwayat['periode_tahun'] ?></td>
                                        <td class="text-nowrap text-dark fw-bold">Rp <?= number_format($riwayat['nominal'], 0, ',', '.') ?></td>
                                        <td class="text-nowrap text-muted"><?= date('d M Y', strtotime($riwayat['created_at'])) ?></td>
                                        <td class="text-center text-nowrap">
                                            <?php if($riwayat['status'] == 'terverifikasi'): ?>
                                                <span class="badge bg-success">Terverifikasi</span>
                                            <?php elseif($riwayat['status'] == 'menunggu_verifikasi'): ?>
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Ditolak</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?php if($riwayat['bukti_transfer']): ?>
                                                <button class="btn btn-xs btn-outline-secondary" onclick="lihatBuktiTransfer('Bulan <?= $riwayat['periode_bulan'] ?> <?= $riwayat['periode_tahun'] ?>', 'Rp <?= number_format($riwayat['nominal'], 0, ',', '.') ?>', '<?= date('d M Y - H:i', strtotime($riwayat['created_at'])) ?> WIB', '<?= esc($riwayat['bukti_transfer']) ?>')">Lihat</button>
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
                        <p class="text-muted small mb-0">Pengeluaran dana kas RT terkini.</p>
                    </div>
                    <a href="<?= base_url('laporan-warga') ?>" class="btn btn-sm btn-outline-primary fw-semibold">Laporan</a>
                </div>

                <div class="list-group list-group-flush flex-grow-1">
                    <?php if(empty($pengeluaranTerakhir)): ?>
                        <div class="text-center text-muted py-4">Belum ada pengeluaran.</div>
                    <?php else: ?>
                        <?php foreach($pengeluaranTerakhir as $pengeluaran): ?>
                            <div class="list-group-item px-0 py-2 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark font-14"><?= esc($pengeluaran['keterangan']) ?></h6>
                                        <small class="text-muted"><?= date('d M Y', strtotime($pengeluaran['tanggal'])) ?> • <?= esc($pengeluaran['nama_kategori']) ?></small>
                                    </div>
                                    <span class="text-danger fw-bold text-nowrap font-14">Rp <?= number_format($pengeluaran['nominal'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="pt-3 border-top mt-3 text-center">
                    <small class="text-muted d-block">Dana kas RT dikelola secara terbuka &amp; dapat diaudit seluruh warga.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pratinjau Bukti Transfer Warga -->
<div class="modal fade" id="modalLihatBuktiTransfer" tabindex="-1" aria-labelledby="modalLihatBuktiTransferLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="modalLihatBuktiTransferLabel">
                    <i data-feather="file-text" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i>
                    Bukti Transfer Pembayaran Iuran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="p-4 bg-light rounded-3 border d-flex flex-column align-items-center justify-content-center mb-3" style="min-height: 200px;">
                    <div class="mb-2" id="modalBuktiImageWrapper">
                        <i data-feather="image" class="text-success" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1" id="modalBuktiPeriode">-</h6>
                    <span class="text-success fw-bold fs-6 d-block mb-1" id="modalBuktiNominal">-</span>
                    <small class="text-muted d-block mb-2 font-12" id="modalBuktiWaktu">-</small>
                    <span class="badge bg-white text-dark border font-11 px-2 py-1" id="modalBuktiFilename">bukti_transfer.jpg</span>
                </div>
                <div class="alert alert-success font-12 py-2 px-3 mb-0 text-start">
                    <i data-feather="check-circle" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Bukti pembayaran akan disimpan sebagai arsip digital RT.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function lihatBuktiTransfer(periode, nominal, waktu, filename) {
    document.getElementById('modalBuktiPeriode').textContent = 'Iuran Kas RT: ' + periode;
    document.getElementById('modalBuktiNominal').textContent = nominal;
    document.getElementById('modalBuktiWaktu').textContent = 'Diupload pada ' + waktu;
    document.getElementById('modalBuktiFilename').textContent = filename;

    // Optional: if filename is actual image URL, you can display it.
    if(filename.match(/\.(jpeg|jpg|gif|png)$/i)) {
        const url = '<?= base_url('uploads/bukti_transfer/') ?>' + filename;
        document.getElementById('modalBuktiImageWrapper').innerHTML = '<img src="'+url+'" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">';
    } else {
        document.getElementById('modalBuktiImageWrapper').innerHTML = '<i data-feather="image" class="text-success" style="width: 48px; height: 48px;"></i>';
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
