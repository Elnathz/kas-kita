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

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap ps-3" style="width: 50px;">No</th>
                                <th class="text-nowrap" style="width: 180px;">Nama Kategori</th>
                                <th>Deskripsi / Alokasi</th>
                                <th class="text-center text-nowrap" style="width: 100px;">Status</th>
                                <th class="text-center text-nowrap pe-3" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 text-nowrap">1</td>
                                <td class="fw-semibold text-dark text-nowrap">Kas Operasional</td>
                                <td class="text-muted font-12">Pemeliharaan fasilitas umum, listrik pos, kebersihan, keamanan</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('kategori/edit/1') ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusKategori('Kas Operasional')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 text-nowrap">2</td>
                                <td class="fw-semibold text-dark text-nowrap">Sosial</td>
                                <td class="text-muted font-12">Bantuan duka cita, santunan warga sakit, bantuan bencana</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('kategori/edit/2') ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusKategori('Sosial')">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 text-nowrap">3</td>
                                <td class="fw-semibold text-dark text-nowrap">Konsumsi</td>
                                <td class="text-muted font-12">Konsumsi rapat bulanan pengurus RT dan kegiatan warga</td>
                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('kategori/edit/3') ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusKategori('Konsumsi')">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Kategori -->
<div class="modal fade" id="modalHapusKategori" tabindex="-1" aria-labelledby="modalHapusKategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalHapusKategoriLabel">
                    <i data-feather="alert-triangle" class="feather-icon me-2 text-white" style="width: 18px; height: 18px;"></i>
                    Konfirmasi Hapus Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-dark mb-2">Apakah Anda yakin ingin menghapus pos kategori pengeluaran berikut?</p>
                <div class="p-3 bg-light rounded border mb-3">
                    <span class="text-muted small d-block mb-1">Nama Kategori Pengeluaran:</span>
                    <h6 class="fw-bold text-dark mb-0 fs-6" id="namaKategoriDihapus">-</h6>
                </div>
                <div class="alert alert-warning font-12 py-2 px-3 mb-0">
                    <i data-feather="info" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Pengeluaran terdahulu yang menggunakan pos ini tetap tersimpan dalam arsip pembukuan kas.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-sm fw-semibold px-3" onclick="eksekusiHapusKategori()">
                    Ya, Hapus Kategori
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let kategoriTarget = '';
function konfirmasiHapusKategori(nama) {
    kategoriTarget = nama;
    document.getElementById('namaKategoriDihapus').textContent = nama;
    const modalEl = document.getElementById('modalHapusKategori');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

function eksekusiHapusKategori() {
    const modalEl = document.getElementById('modalHapusKategori');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }
    showAppToast(`Kategori "${kategoriTarget}" berhasil dihapus dari daftar pos pengeluaran.`, 'info', 'Kategori Terhapus');
}
</script>
<?= $this->endSection() ?>
