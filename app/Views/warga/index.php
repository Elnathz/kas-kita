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
                    <button class="btn btn-sm btn-success fw-bold rounded-2 px-3 filter-blok-btn active" onclick="filterBlok('all', this)">Semua Blok (50 KK)</button>
                    <button class="btn btn-sm btn-outline-secondary fw-semibold rounded-2 px-3 filter-blok-btn" onclick="filterBlok('blok-a', this)">Blok A (15 KK)</button>
                    <button class="btn btn-sm btn-outline-secondary fw-semibold rounded-2 px-3 filter-blok-btn" onclick="filterBlok('blok-b', this)">Blok B (12 KK)</button>
                    <button class="btn btn-sm btn-outline-secondary fw-semibold rounded-2 px-3 filter-blok-btn" onclick="filterBlok('blok-c', this)">Blok C (13 KK)</button>
                    <button class="btn btn-sm btn-outline-secondary fw-semibold rounded-2 px-3 filter-blok-btn" onclick="filterBlok('blok-d', this)">Blok D (10 KK)</button>
                </div>

                <!-- ============================================================== -->
                <!-- ACCORDION GRUP DATA WARGA PER BLOK (MURNI KEPENDUDUKAN) -->
                <!-- ============================================================== -->
                <div class="accordion d-flex flex-column gap-3" id="accordionWargaBlok">
                    
                    <!-- ============================================================== -->
                    <!-- 1. GRUP BLOK A -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-a">
                        <h2 class="accordion-header" id="headingBlokA">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokA" aria-expanded="true" aria-controls="collapseBlokA">
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="fw-bold text-dark fs-6">Blok A</span>
                                    <span class="text-muted font-12 fw-normal ms-2">(Kapasitas 15 Rumah • 15 Terdaftar)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center font-12 text-muted">
                                    <span>15 Kepala Keluarga Aktif</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokA" class="accordion-collapse collapse show" aria-labelledby="headingBlokA">
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
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 01</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Mawar</td>
                                                <td class="fw-semibold text-nowrap text-dark">Farros Rifantiarno</td>
                                                <td class="text-nowrap text-muted">farros_r</td>
                                                <td class="text-nowrap">081234567890</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/1') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Farros Rifantiarno', 'Blok A / No. 01 (Jl. Mawar)', 1)">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 02</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Mawar</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Agus Hariyanto
                                                </td>
                                                <td class="text-nowrap text-muted">admin</td>
                                                <td class="text-nowrap">081234567891</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-primary text-white">Pengurus RT</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/2') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Agus Hariyanto', 'Blok A / No. 02 (Jl. Mawar)', 2)">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 04</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Mawar</td>
                                                <td class="fw-semibold text-nowrap text-dark">Bambang Susanto</td>
                                                <td class="text-nowrap text-muted">bambang_s</td>
                                                <td class="text-nowrap">081234567892</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Bambang Susanto', 'Blok A / No. 04 (Jl. Mawar)', 3)">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- 2. GRUP BLOK B -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-b">
                        <h2 class="accordion-header" id="headingBlokB">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokB" aria-expanded="true" aria-controls="collapseBlokB">
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="fw-bold text-dark fs-6">Blok B</span>
                                    <span class="text-muted font-12 fw-normal ms-2">(Kapasitas 12 Rumah • 12 Terdaftar)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center font-12 text-muted">
                                    <span>12 Kepala Keluarga Aktif</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokB" class="accordion-collapse collapse show" aria-labelledby="headingBlokB">
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
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 06</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Melati</td>
                                                <td class="fw-semibold text-nowrap text-dark">Rina Marlina</td>
                                                <td class="text-nowrap text-muted">rina_m</td>
                                                <td class="text-nowrap">081234567893</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/4') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Rina Marlina', 'Blok B / No. 06 (Jl. Melati)', 4)">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 12</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Melati</td>
                                                <td class="fw-semibold text-nowrap text-dark">Hendra Wijaya</td>
                                                <td class="text-nowrap text-muted">hendra_w</td>
                                                <td class="text-nowrap">081234567895</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/6') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Hendra Wijaya', 'Blok B / No. 12 (Jl. Melati)', 6)">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- 3. GRUP BLOK C -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-c">
                        <h2 class="accordion-header" id="headingBlokC">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokC" aria-expanded="true" aria-controls="collapseBlokC">
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="fw-bold text-dark fs-6">Blok C</span>
                                    <span class="text-muted font-12 fw-normal ms-2">(Kapasitas 13 Rumah • 13 Terdaftar)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center font-12 text-muted">
                                    <span>13 Kepala Keluarga Aktif</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokC" class="accordion-collapse collapse show" aria-labelledby="headingBlokC">
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
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 03</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Anggrek</td>
                                                <td class="fw-semibold text-nowrap text-dark">Siti Aminah</td>
                                                <td class="text-nowrap text-muted">siti_a</td>
                                                <td class="text-nowrap">081234567896</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/7') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Siti Aminah', 'Blok C / No. 03 (Jl. Anggrek)', 7)">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 10</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Anggrek</td>
                                                <td class="fw-semibold text-nowrap text-dark">Budi Santoso</td>
                                                <td class="text-nowrap text-muted">budi_santoso</td>
                                                <td class="text-nowrap">081234567894</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Budi Santoso', 'Blok C / No. 10 (Jl. Anggrek)', 3)">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- 4. GRUP BLOK D -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-d">
                        <h2 class="accordion-header" id="headingBlokD">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokD" aria-expanded="true" aria-controls="collapseBlokD">
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="fw-bold text-dark fs-6">Blok D</span>
                                    <span class="text-muted font-12 fw-normal ms-2">(Kapasitas 10 Rumah • 10 Terdaftar)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center font-12 text-muted">
                                    <span>10 Kepala Keluarga Aktif</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokD" class="accordion-collapse collapse show" aria-labelledby="headingBlokD">
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
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 02</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Kenanga</td>
                                                <td class="fw-semibold text-nowrap text-dark">Dedi Supardi</td>
                                                <td class="text-nowrap text-muted">dedi_s</td>
                                                <td class="text-nowrap">081234567897</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/8') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Dedi Supardi', 'Blok D / No. 02 (Jl. Kenanga)', 8)">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 05</td>
                                                <td class="text-nowrap text-dark fw-medium">Jl. Kenanga</td>
                                                <td class="fw-semibold text-nowrap text-dark">Eko Prasetyo</td>
                                                <td class="text-nowrap text-muted">eko_p</td>
                                                <td class="text-nowrap">081234567898</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-light text-dark border">Warga</span></td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Aktif</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/5') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="konfirmasiHapus('Eko Prasetyo', 'Blok D / No. 05 (Jl. Kenanga)', 5)">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

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
