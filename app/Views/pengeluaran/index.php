<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Pencatatan Pengeluaran Kas RT</h4>
                        <p class="text-muted small mb-0">Kelola dan dokumentasikan seluruh alokasi dana kas RT.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('pengeluaran/create') ?>" class="btn btn-success d-flex align-items-center gap-1">
                            <i data-feather="plus" class="feather-icon"></i>
                            <span>Catat Pengeluaran</span>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Keterangan / Keperluan</th>
                                <th>Nominal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>14 Agu 2026</td>
                                <td><span class="badge bg-primary">Kas Operasional</span></td>
                                <td class="fw-semibold">Pembelian lampu penerangan jalan gang RT 03</td>
                                <td class="text-danger fw-bold">Rp 350.000</td>
                                <td class="text-center">
                                    <a href="<?= base_url('pengeluaran/edit/1') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus pengeluaran')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>10 Agu 2026</td>
                                <td><span class="badge bg-info text-white">Sosial</span></td>
                                <td class="fw-semibold">Santunan warga sakit (Bpk. Mulyono)</td>
                                <td class="text-danger fw-bold">Rp 500.000</td>
                                <td class="text-center">
                                    <a href="<?= base_url('pengeluaran/edit/2') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus pengeluaran')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>05 Agu 2026</td>
                                <td><span class="badge bg-warning text-dark">Konsumsi</span></td>
                                <td class="fw-semibold">Konsumsi snack rapat bulanan pengurus RT</td>
                                <td class="text-danger fw-bold">Rp 250.000</td>
                                <td class="text-center">
                                    <a href="<?= base_url('pengeluaran/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus pengeluaran')">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
