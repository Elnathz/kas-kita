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
                        <p class="text-muted small mb-0">Kelola data kepala keluarga yang dikelompokkan rapi per blok pemukiman warga.</p>
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
                <!-- ACCORDION GRUP DATA WARGA PER BLOK -->
                <!-- ============================================================== -->
                <div class="accordion d-flex flex-column gap-3" id="accordionWargaBlok">
                    
                    <!-- ============================================================== -->
                    <!-- 1. GRUP BLOK A (JL. MAWAR) -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-a">
                        <h2 class="accordion-header" id="headingBlokA">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokA" aria-expanded="true" aria-controls="collapseBlokA">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success font-13 px-2 py-1">Blok A</span>
                                    <span class="text-dark fs-6">Jl. Mawar</span>
                                    <span class="text-muted font-12 fw-normal">(15 Rumah • Partisipasi 87%)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                    <span class="badge bg-success">13 Lunas</span>
                                    <span class="badge bg-warning text-dark">1 Belum</span>
                                    <span class="badge bg-danger">1 Macet</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokA" class="accordion-collapse collapse show" aria-labelledby="headingBlokA">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap ps-4" style="width: 120px;">No. Rumah</th>
                                                <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                <th class="text-nowrap">Username</th>
                                                <th class="text-nowrap">Nomor WhatsApp</th>
                                                <th class="text-nowrap text-center">Status Iuran (Agustus)</th>
                                                <th class="text-nowrap text-center" style="width: 140px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 01</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Farros Rifantiarno
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">farros_r</td>
                                                <td class="text-nowrap">081234567890</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/1') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 02</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Ahmad Fauzi
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">ahmad_fauzi</td>
                                                <td class="text-nowrap">081234567891</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Lancar</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/2') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 04</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Bambang Susanto
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">bambang_s</td>
                                                <td class="text-nowrap">081234567892</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-danger">Macet (3 Bln)</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- 2. GRUP BLOK B (JL. MELATI) -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-b">
                        <h2 class="accordion-header" id="headingBlokB">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokB" aria-expanded="true" aria-controls="collapseBlokB">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success font-13 px-2 py-1">Blok B</span>
                                    <span class="text-dark fs-6">Jl. Melati</span>
                                    <span class="text-muted font-12 fw-normal">(12 Rumah • Partisipasi 92%)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                    <span class="badge bg-success">11 Lunas</span>
                                    <span class="badge bg-warning text-dark">1 Belum</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokB" class="accordion-collapse collapse show" aria-labelledby="headingBlokB">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap ps-4" style="width: 120px;">No. Rumah</th>
                                                <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                <th class="text-nowrap">Username</th>
                                                <th class="text-nowrap">Nomor WhatsApp</th>
                                                <th class="text-nowrap text-center">Status Iuran (Agustus)</th>
                                                <th class="text-nowrap text-center" style="width: 140px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 06</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Rina Marlina
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">rina_m</td>
                                                <td class="text-nowrap">081234567893</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Lancar</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/4') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 12</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Hendra Wijaya
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">hendra_w</td>
                                                <td class="text-nowrap">081234567895</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Menunggu Verifikasi</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/6') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- 3. GRUP BLOK C (JL. ANGGREK) -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-c">
                        <h2 class="accordion-header" id="headingBlokC">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokC" aria-expanded="true" aria-controls="collapseBlokC">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success font-13 px-2 py-1">Blok C</span>
                                    <span class="text-dark fs-6">Jl. Anggrek</span>
                                    <span class="text-muted font-12 fw-normal">(13 Rumah • Partisipasi 85%)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                    <span class="badge bg-success">11 Lunas</span>
                                    <span class="badge bg-warning text-dark">2 Belum</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokC" class="accordion-collapse collapse show" aria-labelledby="headingBlokC">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap ps-4" style="width: 120px;">No. Rumah</th>
                                                <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                <th class="text-nowrap">Username</th>
                                                <th class="text-nowrap">Nomor WhatsApp</th>
                                                <th class="text-nowrap text-center">Status Iuran (Agustus)</th>
                                                <th class="text-nowrap text-center" style="width: 140px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 10</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Budi Santoso
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">budi_santoso</td>
                                                <td class="text-nowrap">081234567894</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/3') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 03</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Siti Aminah
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">siti_a</td>
                                                <td class="text-nowrap">081234567896</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Lancar</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/7') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Demo: Hapus data')">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- 4. GRUP BLOK D (JL. KENANGA) -->
                    <!-- ============================================================== -->
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-sm item-blok-wrapper" id="item-blok-d">
                        <h2 class="accordion-header" id="headingBlokD">
                            <button class="accordion-button bg-white text-dark py-3 px-4 fw-bold d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlokD" aria-expanded="true" aria-controls="collapseBlokD">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success font-13 px-2 py-1">Blok D</span>
                                    <span class="text-dark fs-6">Jl. Kenanga</span>
                                    <span class="text-muted font-12 fw-normal">(10 Rumah • Partisipasi 90%)</span>
                                </div>
                                <div class="ms-auto me-3 d-none d-md-flex align-items-center gap-1 font-12">
                                    <span class="badge bg-success">9 Lunas</span>
                                    <span class="badge bg-warning text-dark">1 Belum</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBlokD" class="accordion-collapse collapse show" aria-labelledby="headingBlokD">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap ps-4" style="width: 120px;">No. Rumah</th>
                                                <th class="text-nowrap">Nama Kepala Keluarga</th>
                                                <th class="text-nowrap">Username</th>
                                                <th class="text-nowrap">Nomor WhatsApp</th>
                                                <th class="text-nowrap text-center">Status Iuran (Agustus)</th>
                                                <th class="text-nowrap text-center" style="width: 140px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark text-nowrap">No. 02</td>
                                                <td class="fw-semibold text-nowrap text-dark">
                                                    Dedi Supardi
                                                    <span class="badge bg-light text-dark border ms-1 font-11">Warga</span>
                                                </td>
                                                <td class="text-nowrap text-muted">dedi_s</td>
                                                <td class="text-nowrap">081234567897</td>
                                                <td class="text-center text-nowrap"><span class="badge bg-success">Lancar</span></td>
                                                <td class="text-center text-nowrap pe-4">
                                                    <a href="<?= base_url('warga/edit/8') ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
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
            </div>
        </div>
    </div>
</div>

<!-- Script Accordion Buka-Tutup & Filter Blok -->
<script>
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
