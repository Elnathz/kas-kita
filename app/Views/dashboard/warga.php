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
                            <span class="text-white font-11 fw-bold text-uppercase letter-spacing-1">Akun Warga RT 04</span>
                        </div>
                        <h2 class="fw-bold text-white mb-3">Selamat Datang, <span class="text-success">Farros Rifantiarno</span></h2>
                        
                        <div class="d-flex flex-wrap gap-4 text-white-50 font-14">
                            <div class="d-flex align-items-center bg-black bg-opacity-25 rounded px-3 py-2 border border-white border-opacity-10">
                                <i data-feather="map-pin" class="text-white-50 me-2" style="width: 16px; height: 16px;"></i>
                                <span class="text-white fw-medium">Blok A / No. 01, Jl. Mawar</span>
                            </div>
                            <div class="d-flex align-items-center bg-black bg-opacity-25 rounded px-3 py-2 border border-white border-opacity-10">
                                <i data-feather="phone" class="text-white-50 me-2" style="width: 16px; height: 16px;"></i>
                                <span class="text-white fw-medium">081234567890</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sisi Kanan: Tagihan Berjalan -->
                    <div class="col-xl-4">
                        <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-25 shadow" style="backdrop-filter: blur(8px);">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <span class="text-white-50 small d-block mb-1">Tagihan Bulan Berjalan</span>
                                    <h3 class="fw-bold text-white mb-0">Rp 50.000</h3>
                                    <small class="text-success fw-semibold">Agustus 2026</small>
                                </div>
                                <div class="bg-success bg-opacity-25 border border-success border-opacity-25 text-success rounded-3 p-2">
                                    <i data-feather="file-text" style="width: 24px; height: 24px;"></i>
                                </div>
                            </div>
                            <a href="<?= base_url('iuran/bayar') ?>" class="btn btn-success w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center py-2 transition-all">
                                <i data-feather="credit-card" class="me-2" style="width: 16px; height: 16px;"></i> Bayar Iuran Sekarang
                            </a>
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
        <div class="card border-0 shadow-sm border-start border-warning border-4 h-100 mb-0">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small d-block mb-1">Status Iuran Agustus 2026</span>
                    <h5 class="text-warning fw-bold mb-0">Belum Dibayar</h5>
                    <small class="text-muted font-12">Jatuh tempo: 20 Agu 2026</small>
                </div>
                <div class="bg-light rounded p-2 text-warning d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i data-feather="clock" class="feather-icon text-warning"></i>
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
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 50.000</h4>
                    <small class="text-muted font-12">1 Periode Belum Lunas</small>
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
                    <span class="text-muted small d-block mb-1">Iuran Terbayar (2026)</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 350.000</h4>
                    <small class="text-success font-12 fw-semibold">7 Bulan Lunas (Jan - Jul)</small>
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
                    <span class="text-muted small d-block mb-1">Total Saldo Kas RT 04</span>
                    <h4 class="text-dark fw-bold mb-0 text-nowrap">Rp 12.650.000</h4>
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
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Juli 2026</td>
                                <td class="text-nowrap text-dark fw-bold">Rp 50.000</td>
                                <td class="text-nowrap text-muted">10 Jul 2026</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-xs btn-outline-secondary" onclick="lihatBuktiTransfer('Juli 2026', 'Rp 50.000', '10 Jul 2026 - 14:20 WIB', 'bukti_transfer_juli_farros.jpg')">Lihat</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Juni 2026</td>
                                <td class="text-nowrap text-dark fw-bold">Rp 50.000</td>
                                <td class="text-nowrap text-muted">08 Jun 2026</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-xs btn-outline-secondary" onclick="lihatBuktiTransfer('Juni 2026', 'Rp 50.000', '08 Jun 2026 - 11:05 WIB', 'bukti_transfer_juni_farros.jpg')">Lihat</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap">Mei 2026</td>
                                <td class="text-nowrap text-dark fw-bold">Rp 50.000</td>
                                <td class="text-nowrap text-muted">12 Mei 2026</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Terverifikasi</span></td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-xs btn-outline-secondary" onclick="lihatBuktiTransfer('Mei 2026', 'Rp 50.000', '12 Mei 2026 - 09:45 WIB', 'bukti_transfer_mei_farros.jpg')">Lihat</button>
                                </td>
                            </tr>
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
                        <p class="text-muted small mb-0">Penggunaan dana kas RT terkini untuk lingkungan.</p>
                    </div>
                    <a href="<?= base_url('laporan-warga') ?>" class="btn btn-sm btn-outline-primary fw-semibold">Laporan</a>
                </div>

                <div class="list-group list-group-flush flex-grow-1">
                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0 fw-semibold text-dark font-14">Lampu Penerangan Gang Mawar</h6>
                                <small class="text-muted">14 Agu 2026 • Operasional</small>
                            </div>
                            <span class="text-danger fw-bold text-nowrap font-14">Rp 350.000</span>
                        </div>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0 fw-semibold text-dark font-14">Santunan Warga Sakit (Bpk. Mulyono)</h6>
                                <small class="text-muted">10 Agu 2026 • Dana Sosial</small>
                            </div>
                            <span class="text-danger fw-bold text-nowrap font-14">Rp 500.000</span>
                        </div>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0 fw-semibold text-dark font-14">Konsumsi Rapat Bulanan Pengurus</h6>
                                <small class="text-muted">05 Agu 2026 • Konsumsi</small>
                            </div>
                            <span class="text-danger fw-bold text-nowrap font-14">Rp 250.000</span>
                        </div>
                    </div>
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
                    <div class="mb-2">
                        <i data-feather="image" class="text-success" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1" id="modalBuktiPeriode">-</h6>
                    <span class="text-success fw-bold fs-6 d-block mb-1" id="modalBuktiNominal">-</span>
                    <small class="text-muted d-block mb-2 font-12" id="modalBuktiWaktu">-</small>
                    <span class="badge bg-white text-dark border font-11 px-2 py-1" id="modalBuktiFilename">bukti_transfer.jpg</span>
                </div>
                <div class="alert alert-success font-12 py-2 px-3 mb-0">
                    <i data-feather="check-circle" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Bukti pembayaran telah divalidasi lunas oleh bendahara RT.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-sm fw-semibold" onclick="showAppToast('File bukti transfer berhasil diunduh.', 'success', 'Unduhan Berhasil')">
                    Unduh Bukti
                </button>
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

    const modalEl = document.getElementById('modalLihatBuktiTransfer');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}
</script>
<?= $this->endSection() ?>
