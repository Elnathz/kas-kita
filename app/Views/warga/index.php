<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Daftar Warga RT 04</h4>
                        <p class="text-muted small mb-0">Kelola data warga RT dan pantau status kelancaran pembayaran iuran.</p>
                    </div>
                    <a href="<?= base_url('warga/create') ?>" class="btn btn-success d-flex align-items-center gap-1">
                        <i data-feather="plus" class="feather-icon"></i>
                        <span>Tambah Warga</span>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="width: 50px;">No</th>
                                <th class="text-nowrap">Nama Lengkap</th>
                                <th class="text-nowrap">Username</th>
                                <th class="text-nowrap">Alamat Rumah</th>
                                <th class="text-nowrap">Nomor WhatsApp</th>
                                <th class="text-nowrap text-center">Status Iuran (Agustus)</th>
                                <th class="text-nowrap text-center" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap">1</td>
                                <td class="fw-semibold text-nowrap text-dark">Farros Rifantiarno</td>
                                <td class="text-nowrap text-muted">farros_r</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok A / No. 01</span>
                                    <span class="text-muted small d-block">Jl. Mawar</span>
                                </td>
                                <td class="text-nowrap">081234567890</td>
                                <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('warga/edit/1') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">2</td>
                                <td class="fw-semibold text-nowrap text-dark">Ahmad Fauzi</td>
                                <td class="text-nowrap text-muted">ahmad_fauzi</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok A / No. 02</span>
                                    <span class="text-muted small d-block">Jl. Mawar</span>
                                </td>
                                <td class="text-nowrap">081234567891</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Lancar</span></td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('warga/edit/2') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">3</td>
                                <td class="fw-semibold text-nowrap text-dark">Rina Marlina</td>
                                <td class="text-nowrap text-muted">rina_m</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok B / No. 06</span>
                                    <span class="text-muted small d-block">Jl. Melati</span>
                                </td>
                                <td class="text-nowrap">081234567893</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Lancar</span></td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('warga/edit/4') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">4</td>
                                <td class="fw-semibold text-nowrap text-dark">Budi Santoso</td>
                                <td class="text-nowrap text-muted">budi_santoso</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok C / No. 10</span>
                                    <span class="text-muted small d-block">Jl. Anggrek</span>
                                </td>
                                <td class="text-nowrap">081234567894</td>
                                <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('warga/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">5</td>
                                <td class="fw-semibold text-nowrap text-dark">Bambang Susanto</td>
                                <td class="text-nowrap text-muted">bambang_s</td>
                                <td class="text-nowrap">
                                    <span class="text-dark fw-medium">Blok A / No. 04</span>
                                    <span class="text-muted small d-block">Jl. Mawar</span>
                                </td>
                                <td class="text-nowrap">081234567892</td>
                                <td class="text-center text-nowrap"><span class="badge bg-danger">Macet (3 Bln)</span></td>
                                <td class="text-center text-nowrap">
                                    <a href="<?= base_url('warga/edit/5') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
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
