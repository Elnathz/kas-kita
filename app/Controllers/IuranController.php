<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IuranController extends BaseController
{
    private function getIuranPeriodContext(): array
    {
        $nowMonth = (int) date('n');
        $nowYear = (int) date('Y');
        $firstSetting = (new \App\Models\PengaturanIuranModel())
            ->orderBy('berlaku_dari', 'ASC')
            ->first();
        $settings = (new \App\Models\PengaturanIuranModel())
            ->orderBy('berlaku_dari', 'ASC')
            ->findAll();
        $latestSetting = \App\Libraries\IuranPeriodSummary::effectiveSetting($settings);
        $bounds = \App\Libraries\IuranPeriodSummary::resolveBounds(
            $firstSetting['berlaku_dari'] ?? null,
            $nowMonth,
            $nowYear,
        );
        $currentPeriod = \App\Libraries\IuranPeriodSummary::resolvePeriod(
            [],
            $nowMonth,
            $nowYear,
            $bounds,
        );
        $activePeriod = \App\Libraries\IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'rentang',
            'bulan_awal'    => $bounds['start']['bulan'],
            'tahun_awal'    => $bounds['start']['tahun'],
            'bulan_akhir'   => $bounds['end']['bulan'],
            'tahun_akhir'   => $bounds['end']['tahun'],
        ], $nowMonth, $nowYear, $bounds);

        return [
            'bounds'  => $bounds,
            'current' => $currentPeriod,
            'active'  => $activePeriod,
            'setting' => $latestSetting,
        ];
    }

    // Menampilkan halaman daftar data utama
    public function index()
    {
        $pembayaranModel = new \App\Models\PembayaranModel();
        $userModel = new \App\Models\UserModel();
        $masterBlokModel = new \App\Models\MasterBlokModel();
        $context = $this->getIuranPeriodContext();
        $periodBounds = $context['bounds'];

        $period = \App\Libraries\IuranPeriodSummary::resolvePeriod(
            $this->request->getGet(),
            (int) date('n'),
            (int) date('Y'),
            $periodBounds,
        );
        $statusPeriod = \App\Libraries\IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'rentang',
            'bulan_awal'    => $periodBounds['start']['bulan'],
            'tahun_awal'    => $periodBounds['start']['tahun'],
            'bulan_akhir'   => $period['end']['bulan'],
            'tahun_akhir'   => $period['end']['tahun'],
        ], (int) date('n'), (int) date('Y'), $periodBounds);
        $blok_ini = $this->request->getGet('blok') ?? 'all';

        $pengaturan = $context['setting'];
        $nominal_iuran = $pengaturan ? (int) $pengaturan['nominal'] : 50000;
        $toleransi_macet = $pengaturan && isset($pengaturan['toleransi_macet'])
            ? (int) $pengaturan['toleransi_macet']
            : 2;

        $wargaQuery = $userModel->where('is_active', 1);
        if ($blok_ini !== 'all') {
            $wargaQuery->where('blok_rumah', $blok_ini);
        }
        $warga = $wargaQuery->findAll();

        $pembayaranQuery = $pembayaranModel
            ->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan, users.no_telepon')
            ->join('users', 'users.id = pembayaran.user_id');

        if ($blok_ini !== 'all') {
            $pembayaranQuery->where('users.blok_rumah', $blok_ini);
        }

        $pembayaranQuery->groupStart();
        foreach ($statusPeriod['keys'] as $index => $key) {
            [$tahun, $bulan] = array_map('intval', explode('-', $key));

            if ($index === 0) {
                $pembayaranQuery
                    ->groupStart()
                    ->where('pembayaran.periode_tahun', $tahun)
                    ->where('pembayaran.periode_bulan', $bulan)
                    ->groupEnd();
                continue;
            }

            $pembayaranQuery
                ->orGroupStart()
                ->where('pembayaran.periode_tahun', $tahun)
                ->where('pembayaran.periode_bulan', $bulan)
                ->groupEnd();
        }
        $pembayaranQuery
            ->groupEnd()
            ->orderBy('pembayaran.periode_tahun', 'DESC')
            ->orderBy('pembayaran.periode_bulan', 'DESC');

        $pembayaran = $pembayaranQuery->findAll();
        $rekap = \App\Libraries\IuranPeriodSummary::summarize(
            $warga,
            $pembayaran,
            $period,
            $nominal_iuran,
            $toleransi_macet,
            $statusPeriod,
        );
        $statistik = $rekap['statistik'];

        $master_blok = $masterBlokModel->findAll();
        $warga_per_blok = [];
        foreach ($master_blok as $blok) {
            if ($blok_ini !== 'all' && $blok['nama_blok'] !== $blok_ini) {
                continue;
            }

            $warga_per_blok[$blok['nama_blok']] = [
                'kapasitas' => $blok['maks_nomor'],
                'warga' => [],
                'terkumpul' => 0,
                'target' => 0,
            ];
        }

        foreach ($rekap['warga'] as $wargaRekap) {
            $namaBlok = $wargaRekap['blok_rumah'];
            if (!isset($warga_per_blok[$namaBlok])) {
                continue;
            }

            $warga_per_blok[$namaBlok]['warga'][] = $wargaRekap;
            $warga_per_blok[$namaBlok]['terkumpul'] += $wargaRekap['total_terverifikasi'];
            $warga_per_blok[$namaBlok]['target'] += $wargaRekap['total_tagihan'];
        }

        return view('iuran/index', [
            'pembayaran' => $pembayaran,
            'rekap' => $rekap,
            'period' => $period,
            'menunggu_verifikasi' => $statistik['menunggu_verifikasi'],
            'total_verifikasi' => $statistik['total_pending'],
            'lunas' => $statistik['lunas'],
            'total_lunas' => $statistik['total_terverifikasi'],
            'belum_bayar' => $statistik['belum_bayar'],
            'macet' => $statistik['macet'],
            'total_tunggakan' => $statistik['total_tunggakan'],
            'warga_per_blok' => $warga_per_blok,
            'total_warga' => $statistik['total_warga'],
            'bulan_ini' => $period['end']['bulan'],
            'tahun_ini' => $period['end']['tahun'],
            'blok_ini' => $blok_ini,
            'master_blok' => $master_blok,
            'nominal_iuran' => $nominal_iuran,
            'period_bounds' => $periodBounds,
            'tahun_tersedia' => \App\Libraries\IuranPeriodSummary::availableYears($periodBounds),
        ]);
    }

    // Menampilkan daftar tagihan iuran yang belum lunas
    public function tagihan()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $context = $this->getIuranPeriodContext();
        $userModel = new \App\Models\UserModel();
        $pembayaranModel = new \App\Models\PembayaranModel();
        $pengaturan = $context['setting'];
        $user = $userModel->find($userId);
        $pembayaran = $pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('periode_tahun', 'ASC')
            ->orderBy('periode_bulan', 'ASC')
            ->findAll();
        $tarif = $pengaturan ? (int) $pengaturan['nominal'] : 50000;
        $billing = \App\Libraries\IuranPeriodSummary::residentBilling(
            $user ?? ['id' => $userId],
            $pembayaran,
            $context['active'],
            $tarif,
        );
        $metodePembayaran = (new \App\Models\MetodePembayaranModel())
            ->where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('iuran/tagihan', [
            'tagihan_list'  => $billing['tagihan'],
            'total_tagihan' => $billing['total_tagihan'],
            'period'        => $context['active'],
            'metodePembayaran' => $metodePembayaran,
        ]);
    }

    // Menampilkan form untuk melakukan pembayaran iuran
    public function bayar()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $context = $this->getIuranPeriodContext();
        $userModel = new \App\Models\UserModel();
        $pembayaranModel = new \App\Models\PembayaranModel();
        $pengaturan = $context['setting'];
        $user = $userModel->find($userId);
        $pembayaran = $pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('periode_tahun', 'ASC')
            ->orderBy('periode_bulan', 'ASC')
            ->findAll();
        $tarif = $pengaturan ? (int) $pengaturan['nominal'] : 50000;
        $billing = \App\Libraries\IuranPeriodSummary::residentBilling(
            $user ?? ['id' => $userId],
            $pembayaran,
            $context['active'],
            $tarif,
        );
        $metodePembayaran = (new \App\Models\MetodePembayaranModel())
            ->where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('iuran/bayar', [
            'tagihan_list' => $billing['tagihan'],
            'tarif'        => $tarif,
            'period'       => $context['active'],
            'metodePembayaran' => $metodePembayaran,
        ]);
    }
    // Memproses unggahan bukti bayar dan mengubah status menjadi pending
    public function prosesBayar()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $pembayaranModel = new \App\Models\PembayaranModel();

        $periodes = $this->request->getPost('periode');
        if (empty($periodes) || !is_array($periodes)) {
            return redirect()->back()->with('error', 'Pilih minimal satu bulan tagihan untuk dibayar.');
        }

        $file = $this->request->getFile('bukti_transfer');
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (
            !$file || !$file->isValid() || $file->hasMoved()
            || !in_array(strtolower($file->getClientExtension()), $allowedExtensions, true)
            || $file->getSizeByUnit('mb') > 2
        ) {
            return redirect()->back()->with('error', 'Bukti transfer wajib diunggah, maksimal 2 MB (JPG, PNG, atau WEBP).');
        }

        $uploadPath = FCPATH . 'uploads/bukti';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }
        $namaFile = $file->getRandomName();
        $file->move($uploadPath, $namaFile);

        $nominal_total = (int)$this->request->getPost('nominal');
        $nominal_per_bulan = count($periodes) > 0 ? $nominal_total / count($periodes) : 0;

        $catatan = $this->request->getPost('catatan');

        $dataInsert = [];
        $jumlahDiproses = 0;
        foreach ($periodes as $prd) {
            // format $prd adalah "YYYY-MM"
            $parts = explode('-', $prd);
            if (count($parts) != 2) continue;

            $periode_tahun = (int)$parts[0];
            $periode_bulan = (int)$parts[1];

            // Satu warga hanya boleh memiliki satu baris per periode.
            $existing = $pembayaranModel
                ->where('user_id', $userId)
                ->where('periode_bulan', $periode_bulan)
                ->where('periode_tahun', $periode_tahun)
                ->first();

            if ($existing) {
                if ($existing['status'] === 'ditolak') {
                    $pembayaranModel->update($existing['id'], [
                        'nominal'          => $nominal_per_bulan,
                        'bukti_transfer'   => $namaFile ?: ($existing['bukti_transfer'] ?? null),
                        'bukti_penolakan'  => null,
                        'status'           => 'pending',
                        'catatan'          => $catatan,
                        'verified_by'      => null,
                        'verified_at'      => null,
                    ]);
                    $jumlahDiproses++;
                }
                continue;
            }

            $dataInsert[] = [
                'user_id'        => $userId,
                'periode_bulan'  => $periode_bulan,
                'periode_tahun'  => $periode_tahun,
                'nominal'        => $nominal_per_bulan,
                'bukti_transfer' => $namaFile,
                'status'         => 'pending',
                'catatan'        => $catatan,
            ];
            $jumlahDiproses++;
        }

        if (!empty($dataInsert)) {
            $pembayaranModel->insertBatch($dataInsert);
        }
        if ($jumlahDiproses === 0) {
            return redirect()->back()->with('error', 'Pembayaran untuk periode yang dipilih sudah ada atau sedang diproses.');
        }

        return redirect()->to('/iuran/riwayat')->with('message', 'Pembayaran berhasil diupload. Menunggu verifikasi pengurus.');
    }

    // Menampilkan riwayat pembayaran iuran yang telah dilakukan
    public function riwayat()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $context = $this->getIuranPeriodContext();
        $years = \App\Libraries\IuranPeriodSummary::availableYears($context['bounds']);
        $requestedYear = (int) ($this->request->getGet('tahun') ?? $context['bounds']['end']['tahun']);
        $tahunAktif = in_array($requestedYear, $years, true)
            ? $requestedYear
            : $context['bounds']['end']['tahun'];
        $period = \App\Libraries\IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'tahunan',
            'tahun_tahunan' => $tahunAktif,
        ], $context['bounds']['end']['bulan'], $tahunAktif, $context['bounds']);

        $pembayaranModel = new \App\Models\PembayaranModel();
        $pembayaranQuery = $pembayaranModel
            ->where('user_id', $userId)
            ->where('periode_tahun', $tahunAktif);
        if ($tahunAktif === $context['bounds']['start']['tahun']) {
            $pembayaranQuery->where('periode_bulan >=', $context['bounds']['start']['bulan']);
        }
        if ($tahunAktif === $context['bounds']['end']['tahun']) {
            $pembayaranQuery->where('periode_bulan <=', $context['bounds']['end']['bulan']);
        }
        $pembayaran = $pembayaranQuery
            ->orderBy('periode_bulan', 'DESC')
            ->findAll();

        return view('iuran/riwayat', [
            'pembayaran'     => $pembayaran,
            'tahun_aktif'    => $tahunAktif,
            'tahun_tersedia' => $years,
            'period'         => $period,
        ]);
    }
    // Menampilkan detail pembayaran untuk diverifikasi oleh pengurus
    public function verifikasi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');
        $pembayaranModel = new \App\Models\PembayaranModel();

        $pembayaran = $pembayaranModel
            ->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan, users.no_telepon')
            ->join('users', 'users.id = pembayaran.user_id')
            ->find($id);

        if (!$pembayaran) return redirect()->to('/iuran');

        return view('iuran/verifikasi', ['pembayaran' => $pembayaran, 'id' => $id]);
    }

    // Memproses keputusan (terima/tolak) verifikasi pembayaran
    public function prosesVerifikasi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');

        $pembayaranModel = new \App\Models\PembayaranModel();
        $pembayaran = $pembayaranModel->find($id);
        if (!$pembayaran) {
            return redirect()->to('/iuran')->with('error', 'Pembayaran tidak ditemukan.');
        }

        // Baca 'action' dari form (button name="action" value="terima"/"tolak")
        $action = $this->request->getPost('action');
        $catatan = trim((string) $this->request->getPost('catatan'));

        if ($action === 'terima') {
            $status = 'terverifikasi';
        } elseif ($action === 'tolak') {
            $status = 'ditolak';
            if ($catatan === '') {
                return redirect()->to('/iuran/verifikasi/' . $id)
                    ->withInput()
                    ->with('error', 'Catatan wajib diisi saat menolak pembayaran.');
            }

            $file = $this->request->getFile('bukti_penolakan');
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
            if (
                !$file || !$file->isValid() || $file->hasMoved()
                || !in_array(strtolower($file->getClientExtension()), $allowedExtensions, true)
                || $file->getSizeByUnit('mb') > 2
            ) {
                return redirect()->to('/iuran/verifikasi/' . $id)
                    ->withInput()
                    ->with('error', 'Bukti pendukung wajib diunggah, maksimal 2 MB (JPG, PNG, WEBP, atau PDF).');
            }

            $uploadPath = FCPATH . 'uploads/verifikasi';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }
            $fileName = $file->getRandomName();
            $file->move($uploadPath, $fileName);
            $buktiPenolakan = 'uploads/verifikasi/' . $fileName;
        } else {
            return redirect()->to('/iuran')->with('error', 'Aksi tidak valid.');
        }

        $data = [
            'status'      => $status,
            'catatan'     => $catatan !== '' ? $catatan : null,
            'verified_by' => session()->get('id') ?? session()->get('user_id'),
            'verified_at' => date('Y-m-d H:i:s')
        ];
        if ($status === 'ditolak') {
            $data['bukti_penolakan'] = $buktiPenolakan;
        }

        $pembayaranModel->update($id, $data);

        $pesan = ($status === 'terverifikasi')
            ? 'Pembayaran berhasil diverifikasi.'
            : 'Pembayaran ditolak. Warga akan diminta upload ulang.';

        return redirect()->to('/iuran')->with('message', $pesan);
    }

    // Menampilkan kuitansi digital untuk pembayaran yang lunas
    public function kuitansi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');
        $pembayaranModel = new \App\Models\PembayaranModel();
        $sistemModel = new \App\Models\PengaturanSistemModel();
        $userModel = new \App\Models\UserModel();

        $pembayaran = $pembayaranModel
            ->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan, users.no_telepon')
            ->join('users', 'users.id = pembayaran.user_id')
            ->find($id);

        if (!$pembayaran || $pembayaran['status'] !== 'terverifikasi') {
            return redirect()->to('/iuran')->with('error', 'Kuitansi hanya tersedia untuk pembayaran yang sudah terverifikasi.');
        }

        $wilayah = [];
        foreach ($sistemModel->where('kategori', 'wilayah')->findAll() as $row) {
            $wilayah[$row['kunci']] = $row['nilai'];
        }
        $bendahara = $userModel->where('role', 'pengurus')->where('jabatan', 'Bendahara')->where('is_active', 1)->first();

        return view('iuran/kuitansi', [
            'pembayaran' => $pembayaran,
            'wilayah' => $wilayah,
            'bendahara' => $bendahara,
        ]);
    }
}
