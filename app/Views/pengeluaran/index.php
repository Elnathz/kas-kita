<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Pencatatan Pengeluaran Kas RT</h4>
                        <p class="text-muted small mb-0">Kelola dan dokumentasikan seluruh alokasi pengeluaran dana kas RT beserta bukti nota dan foto kegiatan.</p>
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
                                <th class="text-nowrap ps-3" style="width: 50px;">No</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Kategori</th>
                                <th class="text-nowrap">Keterangan / Keperluan</th>
                                <th class="text-nowrap">Nominal</th>
                                <th class="text-nowrap text-center" style="width: 200px;">Bukti &amp; Dokumentasi</th>
                                <th class="text-nowrap text-center" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 1. Pembelian Lampu (Hanya Nota) -->
                            <tr>
                                <td class="ps-3 text-nowrap">1</td>
                                <td class="text-nowrap text-muted font-12">14 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Kas Operasional</td>
                                <td class="text-dark fw-semibold text-nowrap">Pembelian lampu penerangan jalan gang RT 03</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 350.000</td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-xs btn-outline-secondary" onclick="previewLampiran('nota', 'Pembelian Lampu Penerangan Gang', 'Rp 350.000', 'nota_lampu_jalan.jpg')">
                                        <i data-feather="file-text" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Lihat Nota
                                    </button>
                                </td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('pengeluaran/edit/1') ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusPengeluaran('Pembelian lampu penerangan jalan gang RT 03', 'Rp 350.000', 1)">Hapus</button>
                                </td>
                            </tr>

                            <!-- 2. Santunan Warga Sakit (Nota + Foto Kegiatan) -->
                            <tr>
                                <td class="ps-3 text-nowrap">2</td>
                                <td class="text-nowrap text-muted font-12">10 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Sosial</td>
                                <td class="text-dark fw-semibold text-nowrap">Santunan warga sakit (Bpk. Mulyono)</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 500.000</td>
                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <button class="btn btn-xs btn-outline-secondary" onclick="previewLampiran('nota', 'Kuitansi Santunan Warga Sakit', 'Rp 500.000', 'kuitansi_santunan_mulyono.jpg')">
                                            <i data-feather="file-text" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Lihat Nota
                                        </button>
                                        <button class="btn btn-xs btn-outline-success" onclick="previewLampiran('kegiatan', 'Dokumentasi Penyerahan Santunan Warga', 'Bpk. Mulyono (Blok A / No. 05)', 'foto_penyerahan_santunan.jpg')">
                                            <i data-feather="image" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Dokumentasi
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('pengeluaran/edit/2') ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusPengeluaran('Santunan warga sakit (Bpk. Mulyono)', 'Rp 500.000', 2)">Hapus</button>
                                </td>
                            </tr>

                            <!-- 3. Kerja Bakti Saluran (Nota + Foto Kegiatan) -->
                            <tr>
                                <td class="ps-3 text-nowrap">3</td>
                                <td class="text-nowrap text-muted font-12">08 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Kas Operasional</td>
                                <td class="text-dark fw-semibold text-nowrap">Kerja bakti &amp; perbaikan saluran gang Mawar</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 750.000</td>
                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <button class="btn btn-xs btn-outline-secondary" onclick="previewLampiran('nota', 'Nota Toko Bangunan Saluran Air', 'Rp 750.000', 'nota_semen_pasir.jpg')">
                                            <i data-feather="file-text" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Lihat Nota
                                        </button>
                                        <button class="btn btn-xs btn-outline-success" onclick="previewLampiran('kegiatan', 'Dokumentasi Kerja Bakti Saluran Gang Mawar', 'Minggu Pagi, 08 Agustus 2026', 'foto_kerja_bakti_saluran.jpg')">
                                            <i data-feather="image" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Dokumentasi
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('pengeluaran/edit/4') ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusPengeluaran('Kerja bakti & perbaikan saluran gang Mawar', 'Rp 750.000', 4)">Hapus</button>
                                </td>
                            </tr>

                            <!-- 4. Konsumsi Snack Rapat (Nota + Foto Kegiatan) -->
                            <tr>
                                <td class="ps-3 text-nowrap">4</td>
                                <td class="text-nowrap text-muted font-12">05 Agu 2026</td>
                                <td class="text-nowrap text-dark fw-medium">Konsumsi</td>
                                <td class="text-dark fw-semibold text-nowrap">Konsumsi snack rapat bulanan pengurus RT</td>
                                <td class="text-nowrap fw-bold text-dark">Rp 250.000</td>
                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <button class="btn btn-xs btn-outline-secondary" onclick="previewLampiran('nota', 'Struk Belanja Snack Bakery', 'Rp 250.000', 'struk_snack_rapat.jpg')">
                                            <i data-feather="file-text" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Lihat Nota
                                        </button>
                                        <button class="btn btn-xs btn-outline-success" onclick="previewLampiran('kegiatan', 'Dokumentasi Rapat Bulanan Pengurus RT', 'Rabu Malam di Balai Warga', 'foto_rapat_pengurus.jpg')">
                                            <i data-feather="image" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Dokumentasi
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center text-nowrap pe-3">
                                    <a href="<?= base_url('pengeluaran/edit/3') ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                    <button class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusPengeluaran('Konsumsi snack rapat bulanan pengurus RT', 'Rp 250.000', 3)">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end fw-bold text-dark ps-3">Total Pengeluaran Bulan Ini (Agustus 2026):</th>
                                <th colspan="3" class="fw-bold text-dark fs-6 pe-3">Rp 1.850.000</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL PREVIEW LAMPIRAN (NOTA / FOTO KEGIATAN) -->
<!-- ============================================================== -->
<div class="modal fade" id="modalPreviewLampiran" tabindex="-1" aria-labelledby="modalPreviewLampiranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="modalPreviewLampiranLabel">
                    <span id="previewModalHeaderTitle">Lampiran Pengeluaran</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="p-4 bg-light rounded-3 border d-flex flex-column align-items-center justify-content-center mb-3" style="min-height: 220px;">
                    <div id="previewIconContainer" class="mb-2">
                        <i data-feather="image" class="text-success" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1" id="previewItemTitle">-</h6>
                    <span class="text-muted font-12 d-block mb-2" id="previewItemSubtitle">-</span>
                    <span class="badge bg-white text-dark border font-11 px-2 py-1" id="previewItemFilename">file.jpg</span>
                </div>
                <p class="text-muted font-12 mb-0">
                    File dokumentasi tersimpan dalam server arsip digital Kas-Kita RT 04.
                </p>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-sm fw-semibold" onclick="showAppToast('File lampiran bukti pengeluaran berhasil diunduh ke perangkat Anda.', 'success', 'Unduhan Berhasil')">
                    Unduh Gambar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL KONFIRMASI HAPUS DATA PENGELUARAN -->
<!-- ============================================================== -->
<div class="modal fade" id="modalHapusPengeluaran" tabindex="-1" aria-labelledby="modalHapusPengeluaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalHapusPengeluaranLabel">
                    <i data-feather="alert-triangle" class="feather-icon me-2 text-white" style="width: 18px; height: 18px;"></i>
                    Konfirmasi Hapus Pengeluaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2 text-dark">Apakah Anda yakin ingin menghapus catatan pengeluaran berikut?</p>
                <div class="p-3 bg-light rounded border mb-3">
                    <h6 class="fw-bold text-dark mb-1" id="hapusKeteranganPengeluaran">-</h6>
                    <span class="text-danger fw-bold fs-6" id="hapusNominalPengeluaran">-</span>
                </div>
                <div class="alert alert-warning font-12 py-2 px-3 mb-0">
                    <i data-feather="info" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Peringatan: Seluruh data nota dan foto dokumentasi kegiatan ini akan dihapus dari buku kas.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger fw-semibold px-4" onclick="eksekusiHapusPengeluaran()">
                    Ya, Hapus Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let idPengeluaranDihapus = null;

function previewLampiran(tipe, judul, subjudul, namaFile) {
    const modalHeaderTitle = document.getElementById('previewModalHeaderTitle');
    const previewTitle = document.getElementById('previewItemTitle');
    const previewSubtitle = document.getElementById('previewItemSubtitle');
    const previewFilename = document.getElementById('previewItemFilename');
    
    if (tipe === 'kegiatan') {
        modalHeaderTitle.innerHTML = '<i data-feather="image" class="feather-icon text-success me-2" style="width: 16px; height: 16px;"></i> Foto Dokumentasi Kegiatan';
    } else {
        modalHeaderTitle.innerHTML = '<i data-feather="file-text" class="feather-icon text-secondary me-2" style="width: 16px; height: 16px;"></i> Bukti Nota / Struk Fisik';
    }

    previewTitle.textContent = judul;
    previewSubtitle.textContent = subjudul;
    previewFilename.textContent = namaFile;

    const modalEl = document.getElementById('modalPreviewLampiran');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
    
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

function konfirmasiHapusPengeluaran(keterangan, nominal, id) {
    idPengeluaranDihapus = id;
    document.getElementById('hapusKeteranganPengeluaran').textContent = keterangan;
    document.getElementById('hapusNominalPengeluaran').textContent = nominal;
    const modalEl = document.getElementById('modalHapusPengeluaran');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

function eksekusiHapusPengeluaran() {
    const modalEl = document.getElementById('modalHapusPengeluaran');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }
    showAppToast('Catatan pengeluaran berhasil dihapus dari buku kas.', 'info', 'Pengeluaran Dihapus');
}
</script>

<?= $this->endSection() ?>
