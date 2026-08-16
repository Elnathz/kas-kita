<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Pencatatan Pengeluaran Kas RT</h4>
                        <p class="text-muted small mb-0">Kelola dan dokumentasikan seluruh alokasi pengeluaran dana kas RT beserta bukti nota.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('pengeluaran/create') ?>" class="btn btn-success d-flex align-items-center gap-1 fw-semibold">
                            <i data-feather="plus" class="feather-icon"></i>
                            <span>Catat Pengeluaran Baru</span>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="width: 50px;">No</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Kategori</th>
                                <th class="text-nowrap">Keterangan / Keperluan</th>
                                <th class="text-nowrap">Nominal</th>
                                <th class="text-nowrap text-center">Bukti Nota</th>
                                <th class="text-nowrap text-center" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap">1</td>
                                <td class="text-nowrap text-muted">14 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Kas Operasional</td>
                                <td class="text-dark fw-semibold text-nowrap">Pembelian lampu penerangan jalan gang RT 03</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 350.000</td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-secondary py-1 px-2" onclick="alert('Demo: Lihat nota nota_lampu.jpg')">Lihat Nota</button>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('pengeluaran/edit/1') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus pengeluaran')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">2</td>
                                <td class="text-nowrap text-muted">10 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Sosial</td>
                                <td class="text-dark fw-semibold text-nowrap">Santunan warga sakit (Bpk. Mulyono)</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 500.000</td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-secondary py-1 px-2" onclick="alert('Demo: Lihat kuitansi kuitansi_santunan.jpg')">Lihat Nota</button>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('pengeluaran/edit/2') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus pengeluaran')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">3</td>
                                <td class="text-nowrap text-muted">08 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Kas Operasional</td>
                                <td class="text-dark fw-semibold text-nowrap">Kerja bakti &amp; perbaikan saluran gang Mawar</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 750.000</td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-secondary py-1 px-2" onclick="alert('Demo: Lihat nota nota_material.jpg')">Lihat Nota</button>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('pengeluaran/edit/4') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus pengeluaran')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">4</td>
                                <td class="text-nowrap text-muted">05 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Konsumsi</td>
                                <td class="text-dark fw-semibold text-nowrap">Konsumsi snack rapat bulanan pengurus RT</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 250.000</td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-secondary py-1 px-2" onclick="alert('Demo: Lihat nota nota_snack.jpg')">Lihat Nota</button>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('pengeluaran/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus pengeluaran')">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end fw-bold text-dark">Total Pengeluaran Bulan Ini (Agustus 2026):</th>
                                <th colspan="3" class="fw-bold text-dark fs-6">Rp 1.850.000</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
