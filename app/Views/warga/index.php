<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Daftar Warga RT</h4>
                        <p class="text-muted small mb-0">Kelola data warga RT dan pantau status kelancaran pembayaran iuran.</p>
                    </div>
                    <a href="<?= base_url('warga/create') ?>" class="btn btn-success d-flex align-items-center gap-1">
                        <i data-feather="plus" class="feather-icon"></i>
                        <span>Tambah Warga</span>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>No. Rumah</th>
                                <th>No. Telepon / WA</th>
                                <th>Status Pembayaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="fw-semibold">Ahmad Fauzi</td>
                                <td>ahmad.fauzi</td>
                                <td>Blok A / 01</td>
                                <td>081234567890</td>
                                <td><span class="badge bg-success">Lancar</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('warga/edit/1') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="fw-semibold">Budi Santoso</td>
                                <td>budi.santoso</td>
                                <td>Blok A / 02</td>
                                <td>081234567891</td>
                                <td><span class="badge bg-warning text-dark">Nunggak (1 bln)</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('warga/edit/2') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="fw-semibold">Bambang Susanto</td>
                                <td>bambang.s</td>
                                <td>Blok A / 04</td>
                                <td>081234567892</td>
                                <td><span class="badge bg-danger">Macet (>= 2 bln)</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('warga/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="fw-semibold">Rina Marlina</td>
                                <td>rina.marlina</td>
                                <td>Blok B / 01</td>
                                <td>081234567893</td>
                                <td><span class="badge bg-success">Lancar</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('warga/edit/4') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
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
