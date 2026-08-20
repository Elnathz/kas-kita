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

                <form method="get" action="<?= base_url('pengeluaran') ?>" class="row g-2 align-items-end mb-4 p-3 bg-light rounded border">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold mb-1" for="jenis_periode">Tampilkan Periode</label>
                        <select class="form-select form-select-sm" id="jenis_periode" name="jenis_periode" onchange="ubahFilterPengeluaran()">
                            <option value="bulanan" <?= $jenisPeriode === 'bulanan' ? 'selected' : '' ?>>Satu bulan</option>
                            <option value="tahunan" <?= $jenisPeriode === 'tahunan' ? 'selected' : '' ?>>Satu tahun</option>
                            <option value="semua" <?= $jenisPeriode === 'semua' ? 'selected' : '' ?>>Semua periode</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="filterBulan">
                        <label class="form-label small fw-semibold mb-1" for="bulan">Bulan</label>
                        <select class="form-select form-select-sm" id="bulan" name="bulan">
                            <?php $namaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember']; ?>
                            <?php foreach ($namaBulan as $nomorBulan => $nama): ?>
                                <option value="<?= $nomorBulan ?>" <?= $bulanTerpilih === $nomorBulan ? 'selected' : '' ?>><?= $nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3" id="filterTahun">
                        <label class="form-label small fw-semibold mb-1" for="tahun">Tahun</label>
                        <select class="form-select form-select-sm" id="tahun" name="tahun">
                            <?php foreach ($tahunOptions as $tahun): ?>
                                <option value="<?= $tahun ?>" <?= $tahunTerpilih === $tahun ? 'selected' : '' ?>><?= $tahun ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Terapkan</button>
                    </div>
                </form>

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
                            <?php if (empty($pengeluaran)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada catatan pengeluaran.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($pengeluaran as $p): ?>
                                <?php
                                    $urlLampiran = static function (?string $namaFile): string {
                                        if (!$namaFile) return '';
                                        $upload = FCPATH . 'uploads/pengeluaran/' . $namaFile;
                                        return is_file($upload) ? base_url('uploads/pengeluaran/' . $namaFile) : base_url('assets/images/' . $namaFile);
                                    };
                                ?>
                                <tr>
                                    <td class="ps-3 text-nowrap"><?= $no++ ?></td>
                                    <td class="text-nowrap text-muted font-12"><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                                    <td class="text-nowrap text-dark fw-medium"><?= esc($p['nama_kategori']) ?></td>
                                    <td class="text-dark fw-semibold text-nowrap"><?= esc($p['keterangan']) ?></td>
                                    <td class="text-nowrap fw-bold text-dark">Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                    <td class="text-center text-nowrap">
                                        <?php if (!empty($p['foto_nota'])): ?>
                                        <button class="btn btn-xs btn-outline-secondary me-1" onclick="previewLampiran('nota', '<?= htmlspecialchars($p['keterangan']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= htmlspecialchars($p['foto_nota']) ?>', '<?= htmlspecialchars($urlLampiran($p['foto_nota'])) ?>')">
                                            <i data-feather="file-text" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Nota
                                        </button>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($p['dokumentasi'])): ?>
                                        <button class="btn btn-xs btn-outline-success" onclick="previewLampiran('kegiatan', '<?= htmlspecialchars($p['keterangan']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= htmlspecialchars($p['dokumentasi']) ?>', '<?= htmlspecialchars($urlLampiran($p['dokumentasi'])) ?>')">
                                            <i data-feather="image" class="feather-icon me-1" style="width: 11px; height: 11px;"></i>Dokumentasi
                                        </button>
                                        <?php endif; ?>

                                        <?php if (empty($p['foto_nota']) && empty($p['dokumentasi'])): ?>
                                        <span class="text-muted font-12">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap pe-3">
                                        <a href="<?= base_url('pengeluaran/edit/' . $p['id']) ?>" class="btn btn-xs btn-outline-warning me-1">Edit</a>
                                        <form action="<?= base_url('pengeluaran/delete/' . $p['id']) ?>" method="post" class="d-inline" id="formHapusPengeluaran<?= $p['id'] ?>">
                                            <?= csrf_field() ?>
                                            <button type="button" class="btn btn-xs btn-outline-danger" onclick="konfirmasiHapusPengeluaran('<?= htmlspecialchars($p['keterangan']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', <?= $p['id'] ?>)">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end fw-bold text-dark ps-3">Total Pengeluaran <?= $jenisPeriode === 'bulanan' ? 'Bulan ' . esc($namaBulan[$bulanTerpilih]) . ' ' . esc($tahunTerpilih) : ($jenisPeriode === 'tahunan' ? 'Tahun ' . esc($tahunTerpilih) : 'Semua Periode') ?>:</th>
                                <th colspan="3" class="fw-bold text-dark fs-6 pe-3">Rp <?= number_format($totalTerfilter ?? 0, 0, ',', '.') ?></th>
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
<style>
    #previewStage {
        min-height: 300px;
        max-height: 68vh;
        overflow: auto;
        background: #eef1f4;
    }
    #previewImage {
        max-width: 100%;
        max-height: 62vh;
        object-fit: contain;
        transform-origin: center center;
        transition: transform .15s ease;
        cursor: zoom-in;
    }
    #previewImage.is-zoomed { cursor: grab; }
    #previewImage.is-dragging { cursor: grabbing; }
    .preview-toolbar .btn { min-width: 36px; }
</style>
<div class="modal fade" id="modalPreviewLampiran" tabindex="-1" aria-labelledby="modalPreviewLampiranLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" id="previewDialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="modalPreviewLampiranLabel">
                    <span id="previewModalHeaderTitle">Lampiran Pengeluaran</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="preview-toolbar d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomPreview(-0.2)" title="Perkecil">−</button>
                    <span class="small text-muted" id="previewZoomLabel">100%</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomPreview(0.2)" title="Perbesar">+</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetPreviewZoom()">Reset</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="togglePreviewFullscreen()">
                        <i data-feather="maximize-2" style="width: 14px; height: 14px;"></i> Layar penuh
                    </button>
                </div>
                <div id="previewStage" class="p-3 rounded-3 border d-flex align-items-center justify-content-center mb-3">
                    <div id="previewIconContainer" class="d-flex align-items-center justify-content-center w-100 h-100">
                        <i data-feather="image" class="text-success" style="width: 48px; height: 48px;"></i>
                    </div>
                </div>
                <div>
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
                <a id="previewDownload" class="btn btn-success btn-sm fw-semibold" href="#" download>
                    <i data-feather="download" style="width: 14px; height: 14px;"></i> Unduh File
                </a>
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
let previewScale = 1;
let previewImagePath = '';

function previewLampiran(tipe, judul, subjudul, namaFile, fileUrl) {
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
    
    const imagePath = fileUrl;
    previewImagePath = imagePath;
    resetPreviewZoom();
    document.getElementById('previewDownload').href = imagePath;
    document.getElementById('previewDownload').setAttribute('download', namaFile);
    const iconContainer = document.getElementById('previewIconContainer');
    if (/\.pdf$/i.test(namaFile)) {
        iconContainer.innerHTML = '<a href="' + imagePath + '" target="_blank" rel="noopener" class="btn btn-outline-danger"><i data-feather="file-text"></i> Buka file PDF</a>';
    } else {
        iconContainer.innerHTML = '<img id="previewImage" src="' + imagePath + '" alt="Pratinjau lampiran" class="rounded border shadow-sm">';
        document.getElementById('previewImage').addEventListener('dblclick', function () {
            previewScale = previewScale > 1 ? 1 : 2;
            applyPreviewZoom();
        });
    }

    const modalEl = document.getElementById('modalPreviewLampiran');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
    
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

function applyPreviewZoom() {
    const image = document.getElementById('previewImage');
    const label = document.getElementById('previewZoomLabel');
    if (image) {
        image.style.transform = 'scale(' + previewScale + ')';
        image.classList.toggle('is-zoomed', previewScale > 1);
    }
    label.textContent = Math.round(previewScale * 100) + '%';
}

function zoomPreview(step) {
    previewScale = Math.min(3, Math.max(1, previewScale + step));
    applyPreviewZoom();
}

function resetPreviewZoom() {
    previewScale = 1;
    applyPreviewZoom();
}

function togglePreviewFullscreen() {
    const dialog = document.getElementById('previewDialog');
    dialog.classList.toggle('modal-fullscreen');
    document.getElementById('previewStage').style.maxHeight = dialog.classList.contains('modal-fullscreen') ? '78vh' : '68vh';
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
    if (idPengeluaranDihapus) {
        document.getElementById('formHapusPengeluaran' + idPengeluaranDihapus).submit();
    }
}
</script>

<script>
function ubahFilterPengeluaran() {
    const jenis = document.getElementById('jenis_periode').value;
    document.getElementById('filterBulan').style.display = jenis === 'bulanan' ? '' : 'none';
    document.getElementById('filterTahun').style.display = jenis === 'semua' ? 'none' : '';
}
ubahFilterPengeluaran();
</script>

<?= $this->endSection() ?>
