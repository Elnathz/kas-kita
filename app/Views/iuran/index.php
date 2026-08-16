<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Daftar Pembayaran Iuran Warga</h4>
                        <p class="text-muted small mb-0">Pantau dan verifikasi pembayaran iuran kas per periode bulan.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option selected>Agustus 2026</option>
                            <option>Juli 2026</option>
                            <option>Juni 2026</option>
                        </select>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option selected>Semua Status</option>
                            <option>Menunggu Verifikasi</option>
                            <option>Terverifikasi</option>
                            <option>Belum Bayar</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Warga</th>
                                <th>No. Rumah</th>
                                <th>Periode</th>
                                <th>Nominal</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Upload</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Ahmad Fauzi</td>
                                <td>Blok A / 01</td>
                                <td>Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td><span class="badge bg-warning text-dark">Menunggu Verifikasi</span></td>
                                <td>15 Agu 2026</td>
                                <td class="text-center">
                                    <a href="<?= base_url('iuran/verifikasi/1') ?>" class="btn btn-sm btn-primary">Verifikasi</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Rina Marlina</td>
                                <td>Blok B / 01</td>
                                <td>Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td><span class="badge bg-success">Terverifikasi</span></td>
                                <td>10 Agu 2026</td>
                                <td class="text-center">
                                    <a href="<?= base_url('iuran/verifikasi/2') ?>" class="btn btn-sm btn-outline-secondary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Budi Santoso</td>
                                <td>Blok A / 02</td>
                                <td>Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td><span class="badge bg-danger">Belum Bayar (Nunggak)</span></td>
                                <td>-</td>
                                <td class="text-center">
                                    <span class="text-muted small">-</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Bambang Susanto</td>
                                <td>Blok A / 04</td>
                                <td>Agustus 2026</td>
                                <td>Rp 50.000</td>
                                <td><span class="badge bg-danger">Macet (3 bln)</span></td>
                                <td>-</td>
                                <td class="text-center">
                                    <span class="text-muted small">-</span>
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
