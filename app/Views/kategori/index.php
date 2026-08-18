<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3 mb-md-4 gap-2">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Kategori Pengeluaran</h4>
                        <p class="text-muted small mb-0">Kelola pos-pos alokasi pengeluaran kas RT.</p>
                    </div>
                    <a href="<?= base_url('kategori/create') ?>" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 fw-semibold px-3">
                        <i data-feather="plus" class="feather-icon" style="width: 14px; height: 14px;"></i>
                        <span>Tambah Kategori</span>
                    </a>
                </div>

                <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success border-0 py-2 px-3 mb-3 small">
                    <?= esc(session()->getFlashdata('message')) ?>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 py-2 px-3 mb-3 small">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap ps-3" style="width: 50px;">No</th>
                                <th class="text-nowrap" style="width: 200px;">Nama Kategori</th>
                                <th>Deskripsi / Alokasi</th>
                                <th class="text-center text-nowrap pe-3" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($kategori)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada kategori. Tambahkan kategori baru.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($kategori as $i => $k): ?>
                            <tr>
                                <td class="ps-3 text-nowrap"><?= $i + 1 ?></td>
                                <td class="fw-semibold text-dark text-nowrap"><?= esc($k['nama_kategori']) ?></td>
                                <td class="text-muted font-12"><?= esc($k['deskripsi'] ?? '-') ?></td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('kategori/edit/' . $k['id']) ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapus(<?= $k['id'] ?>, '<?= esc($k['nama_kategori']) ?>')">Hapus</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalHapusLabel">
                    <i data-feather="alert-triangle" class="feather-icon me-2 text-white" style="width: 18px; height: 18px;"></i>
                    Konfirmasi Hapus Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-dark mb-2">Yakin ingin menghapus kategori berikut?</p>
                <div class="p-3 bg-light rounded border mb-3">
                    <span class="text-muted small d-block mb-1">Nama Kategori:</span>
                    <h6 class="fw-bold text-dark mb-0 fs-6" id="namaKategoriTarget">-</h6>
                </div>
                <div class="alert alert-warning font-12 py-2 px-3 mb-0">
                    <i data-feather="info" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Jika kategori ini sudah digunakan di pengeluaran, penghapusan akan ditolak.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusKategori" method="post" action="" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm fw-semibold px-3">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function konfirmasiHapus(id, nama) {
    document.getElementById('namaKategoriTarget').textContent = nama;
    document.getElementById('formHapusKategori').action = '<?= base_url('kategori/delete/') ?>' + id;
    const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
    modal.show();
    if (typeof feather !== 'undefined') feather.replace();
}
</script>
<?= $this->endSection() ?>
