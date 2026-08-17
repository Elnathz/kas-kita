<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- Header Toolbar -->
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="card-title fw-bold mb-1">Daftar Warga RT 04</h4>
                        <p class="text-muted small mb-0">Master data kependudukan kepala keluarga dikelompokkan rapi per blok pemukiman warga.</p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="toggleAllAccordions(true)">
                            <i data-feather="maximize-2" class="feather-icon" style="width: 14px; height: 14px;"></i>
                            <span>Buka Semua</span>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="toggleAllAccordions(false)">
                            <i data-feather="minimize-2" class="feather-icon" style="width: 14px; height: 14px;"></i>
                            <span>Tutup Semua</span>
                        </button>
                        <a href="<?= base_url('warga/create') ?>" class="btn btn-sm btn-success d-flex align-items-center gap-1 fw-semibold px-3">
                            <i data-feather="plus" class="feather-icon"></i>
                            <span>Tambah Warga</span>
                        </a>
                    </div>
                </div>

                <!-- Filter Cepat Per Blok -->
                <div class="d-flex flex-wrap gap-2 mb-4 p-2 bg-light rounded-3 border">
                    <button class="btn btn-sm btn-success fw-bold rounded-2 px-3 filter-blok-btn active" onclick="filterBlok('all', this)">Semua Blok (<?= $totalWarga ?> KK)</button>
                    <?php foreach ($dataWargaPerBlok as $namaBlok => $dataBlok): ?>
                        <button class="btn btn-sm btn-outline-secondary fw-semibold rounded-2 px-3 filter-blok-btn" onclick="filterBlok('<?= strtolower(str_replace(' ', '-', $namaBlok)) ?>', this)"><?= esc($namaBlok) ?> (<?= count($dataBlok['warga']) ?> KK)</button>
                    <?php endforeach; ?>
                </div>

                <!-- ============================================================== -->
                <!-- ACCORDION GRUP DATA WARGA PER BLOK (MURNI KEPENDUDUKAN) -->
                <!-- ============================================================== -->
                <div class="accordion d-flex flex-column gap-3" id="accordionWargaBlok">
                    
                    <?php foreach ($dataWargaPerBlok as $namaBlok => $dataBlok): ?>
                    <?php 
                        $blokIdStr = strtolower(str_replace(' ', '-', $namaBlok));
                        $wargaCount = count($dataBlok['warga']);
                        $kapasitas = $dataBlok['kapasitas'];
                    ?>
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-<?= $blokIdStr ?>">
                        <h2 class="accordion-header" id="heading<?= $blokIdStr ?>">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $blokIdStr ?>" aria-expanded="true" aria-controls="collapse<?= $blokIdStr ?>">
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="fw-bold text-dark fs-6"><?= esc($namaBlok) ?></span>
                                    <span class="text-muted font-12 fw-normal ms-2">(Kapasitas <?= $kapasitas ?> Rumah • <?= $wargaCount ?> Terdaftar)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center font-12 text-muted">
                                    <span><?= $wargaCount ?> Kepala Keluarga Aktif</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse<?= $blokIdStr ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?= $blokIdStr ?>">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap ps-4" style="width: 100px;">No. Rumah</th>
                                                <th class="text-nowrap" style="width: 130px;">Nama Jalan</th>
                                                <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                <th class="text-nowrap">Username</th>
                                                <th class="text-nowrap">Nomor WhatsApp</th>
                                                <th class="text-nowrap text-center">Role Akun</th>
                                                <th class="text-nowrap text-center">Status Akun</th>
                                                <th class="text-nowrap text-center" style="width: 130px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($wargaCount == 0): ?>
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted py-4">Belum ada warga yang terdaftar di blok ini.</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($dataBlok['warga'] as $warga): ?>
                                                <tr>
                                                    <td class="ps-4 fw-bold text-dark text-nowrap"><?= esc($warga['no_rumah']) ?></td>
                                                    <td class="text-nowrap text-dark fw-medium"><?= esc($warga['nama_jalan']) ?></td>
                                                    <td class="fw-semibold text-nowrap text-dark"><?= esc($warga['nama']) ?></td>
                                                    <td class="text-nowrap text-muted"><?= esc($warga['username']) ?></td>
                                                    <td class="text-nowrap"><?= esc($warga['no_hp']) ?></td>
                                                    <td class="text-center text-nowrap">
                                                        <?php if($warga['role'] == 'pengurus'): ?>
                                                            <span class="badge bg-primary text-white">Pengurus RT</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light text-dark border">Warga</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        <?php if($warga['is_active']): ?>
                                                            <span class="badge bg-success">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center text-nowrap pe-4">
                                                        <a href="<?= base_url('warga/edit/' . $warga['id']) ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                        <!-- Meneruskan ID ke fungsi javascript hapus -->
                                                        <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('<?= addslashes($warga['nama']) ?>', '<?= addslashes($warga['blok_rumah']) ?> / <?= addslashes($warga['no_rumah']) ?> (<?= addslashes($warga['nama_jalan']) ?>)', <?= $warga['id'] ?>)">Hapus</button>
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
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL KONFIRMASI HAPUS DATA WARGA -->
<!-- ============================================================== -->
<div class="modal fade" id="modalHapusWarga" tabindex="-1" aria-labelledby="modalHapusWargaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalHapusWargaLabel">
                    <i data-feather="alert-triangle" class="feather-icon me-2 text-white" style="width: 18px; height: 18px;"></i>
                    Konfirmasi Hapus Data Warga
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2 text-dark">Apakah Anda yakin ingin menghapus data warga berikut?</p>
                <div class="p-3 bg-light rounded border mb-3">
                    <h6 class="fw-bold text-dark mb-1" id="hapusNamaWarga">-</h6>
                    <small class="text-muted" id="hapusAlamatWarga">-</small>
                </div>
                <div class="alert alert-warning font-12 py-2 px-3 mb-0">
                    <i data-feather="info" class="feather-icon me-1" style="width: 14px; height: 14px;"></i>
                    Peringatan: Seluruh riwayat tagihan dan bukti pembayaran iuran warga ini akan terhapus.
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger fw-semibold px-4" onclick="eksekusiHapus()">
                    Ya, Hapus Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script Accordion Buka-Tutup, Filter Blok, dan Modal Hapus -->
<script>
let idWargaYangDihapus = null;

function konfirmasiHapus(nama, alamat, id) {
    idWargaYangDihapus = id;
    document.getElementById('hapusNamaWarga').textContent = nama;
    document.getElementById('hapusAlamatWarga').textContent = alamat;
    const modalEl = document.getElementById('modalHapusWarga');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

function eksekusiHapus() {
    const modalEl = document.getElementById('modalHapusWarga');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }
    showAppToast('Data warga berhasil dihapus dari master kependudukan RT 04.', 'info', 'Warga Terhapus');
}

function toggleAllAccordions(open) {
    const collapsibles = document.querySelectorAll('#accordionWargaBlok .accordion-collapse');
    collapsibles.forEach(c => {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(c, { toggle: false });
        if (open) {
            bsCollapse.show();
        } else {
            bsCollapse.hide();
        }
    });
}

function filterBlok(blokId, btn) {
    // Update active button styling
    document.querySelectorAll('.filter-blok-btn').forEach(b => {
        b.classList.remove('btn-success', 'active');
        b.classList.add('btn-outline-secondary');
    });
    btn.classList.remove('btn-outline-secondary');
    btn.classList.add('btn-success', 'active');

    // Filter items
    const items = document.querySelectorAll('.item-blok-wrapper');
    if (blokId === 'all') {
        items.forEach(item => item.style.display = 'block');
    } else {
        items.forEach(item => {
            if (item.id === 'item-' + blokId) {
                item.style.display = 'block';
                const collapse = item.querySelector('.accordion-collapse');
                bootstrap.Collapse.getOrCreateInstance(collapse, { toggle: false }).show();
            } else {
                item.style.display = 'none';
            }
        });
    }
}
</script>
<?= $this->endSection() ?>
