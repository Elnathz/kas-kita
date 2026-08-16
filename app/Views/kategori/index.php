<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Kategori Pengeluaran</h4>
                        <p class="text-muted small mb-0">Kelola pos-pos alokasi pengeluaran kas RT.</p>
                    </div>
                    <a href="<?= base_url('kategori/create') ?>" class="btn btn-success d-flex align-items-center gap-1">
                        <i data-feather="plus" class="feather-icon"></i>
                        <span>Tambah Kategori</span>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi / Alokasi</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="fw-semibold">Kas Operasional</td>
                                <td>Pemeliharaan fasilitas umum, listrik pos, kebersihan, keamanan</td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('kategori/edit/1') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus kategori')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="fw-semibold">Sosial</td>
                                <td>Bantuan duka cita, santunan warga sakit, bantuan bencana</td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('kategori/edit/2') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus kategori')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="fw-semibold">Konsumsi</td>
                                <td>Konsumsi rapat bulanan pengurus RT dan kegiatan warga</td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('kategori/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus kategori')">Hapus</button>
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
