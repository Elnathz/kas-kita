<?php

namespace App\Controllers;

use App\Libraries\IuranPeriodSummary;
use App\Models\PengaturanIuranModel;
use App\Models\PengaturanSistemModel;
use App\Models\PengeluaranModel;
use App\Models\PembayaranModel;
use App\Models\UserModel;
use App\Models\MasterBlokModel;

class LaporanController extends BaseController
{
    protected $pembayaranModel;
    protected $pengeluaranModel;
    protected $userModel;
    protected $masterBlokModel;
    protected $pengaturanModel;
    protected $pengaturanSistemModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->userModel = new UserModel();
        $this->masterBlokModel = new MasterBlokModel();
        $this->pengaturanModel = new PengaturanIuranModel();
        $this->pengaturanSistemModel = new PengaturanSistemModel();
    }

    // Menampilkan halaman daftar data utama
    public function index() { return $this->tampilLaporan(); }
    // Menampilkan dashboard atau laporan khusus untuk warga
    public function warga() { return $this->tampilLaporan(true); }

    private function tampilLaporan(bool $isWarga = false)
    {
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        $jenisPeriode = (string) ($this->request->getGet('jenis_periode') ?? 'bulanan');
        if (!in_array($jenisPeriode, ['bulanan', 'tahunan', 'semua'], true)) $jenisPeriode = 'bulanan';

        $settingIuran = IuranPeriodSummary::effectiveSetting(
            $this->pengaturanModel->orderBy('berlaku_dari', 'ASC')->findAll()
        );
        $bounds = IuranPeriodSummary::resolveBounds($settingIuran['berlaku_dari'] ?? $currentYear . '-01-01', $currentMonth, $currentYear);
        $bulan = (int) ($this->request->getGet('bulan') ?? $currentMonth);
        $tahun = (int) ($this->request->getGet('tahun') ?? $currentYear);
        $period = $this->resolvePeriod($jenisPeriode, $bulan, $tahun, $bounds, $currentMonth, $currentYear);
        $statusPeriod = IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'rentang',
            'bulan_awal'    => $bounds['start']['bulan'],
            'tahun_awal'    => $bounds['start']['tahun'],
            'bulan_akhir'   => $period['end']['bulan'],
            'tahun_akhir'   => $period['end']['tahun'],
        ], $currentMonth, $currentYear, $bounds);

        $nominalIuran = (int) ($settingIuran['nominal'] ?? 50000);
        $toleransiMacet = max(1, (int) ($settingIuran['toleransi_macet'] ?? 2));
        $warga = $this->userModel->where('is_active', 1)->findAll();
        $pembayaran = $this->pembayaranModel->findAll();
        $rekap = IuranPeriodSummary::summarize($warga, $pembayaran, $period, $nominalIuran, $toleransiMacet, $statusPeriod);

        [$startDate, $endDate] = $this->periodDates($period, $jenisPeriode);
        $expenseQuery = $this->pengeluaranModel
            ->select('pengeluaran.*, kategori_pengeluaran.nama_kategori')
            ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id', 'left')
            ->orderBy('tanggal', 'DESC');
        if ($startDate !== null) $expenseQuery->where('tanggal >=', $startDate)->where('tanggal <=', $endDate);
        $pengeluaran = $expenseQuery->findAll();
        $totalPengeluaran = (int) array_sum(array_map(static fn (array $item): float => (float) $item['nominal'], $pengeluaran));

        $paymentKeys = array_fill_keys($period['keys'], true);
        $totalPemasukan = 0;
        $jumlahTransaksi = 0;
        foreach ($pembayaran as $payment) {
            $key = sprintf('%04d-%02d', (int) ($payment['periode_tahun'] ?? 0), (int) ($payment['periode_bulan'] ?? 0));
            if (isset($paymentKeys[$key]) && $payment['status'] === 'terverifikasi') {
                $totalPemasukan += (int) $payment['nominal'];
                $jumlahTransaksi++;
            }
        }

        $endBalanceDate = $endDate ?? date('Y-m-d');
        $endBalanceMonth = date('Y-m', strtotime($endBalanceDate));
        $totalPemasukanSampaiPeriode = 0;
        foreach ($pembayaran as $payment) {
            $key = sprintf('%04d-%02d', (int) ($payment['periode_tahun'] ?? 0), (int) ($payment['periode_bulan'] ?? 0));
            if ($payment['status'] === 'terverifikasi' && $key <= $endBalanceMonth) $totalPemasukanSampaiPeriode += (int) $payment['nominal'];
        }
        $totalPengeluaranSampaiPeriode = (int) ($this->pengeluaranModel->where('tanggal <=', $endBalanceDate)->selectSum('nominal')->first()['nominal'] ?? 0);

        $wargaPerBlok = [];
        foreach ($this->masterBlokModel->orderBy('nama_blok', 'ASC')->findAll() as $blok) {
            $wargaPerBlok[$blok['nama_blok']] = ['kapasitas' => (int) $blok['maks_nomor'], 'lunas' => 0, 'belum' => 0, 'pending' => 0, 'macet' => 0, 'warga' => []];
        }
        foreach ($rekap['warga'] as $item) {
            $blok = $item['blok_rumah'] ?: 'Belum Ditentukan';
            if (!isset($wargaPerBlok[$blok])) $wargaPerBlok[$blok] = ['kapasitas' => 0, 'lunas' => 0, 'belum' => 0, 'pending' => 0, 'macet' => 0, 'warga' => []];
            $wargaPerBlok[$blok]['warga'][] = $item;
            if ($item['lunas']) $wargaPerBlok[$blok]['lunas']++;
            elseif ($item['macet']) { $wargaPerBlok[$blok]['macet']++; $wargaPerBlok[$blok]['belum']++; }
            elseif ($item['butuh_verifikasi']) $wargaPerBlok[$blok]['pending']++;
            else $wargaPerBlok[$blok]['belum']++;
        }

        $wilayah = [];
        foreach ($this->pengaturanSistemModel->where('kategori', 'wilayah')->findAll() as $row) $wilayah[$row['kunci']] = $row['nilai'];
        $pengurus = $this->userModel->where('role', 'pengurus')->where('is_active', 1)->findAll();
        $ketua = $this->findOfficer($pengurus, 'Ketua RT') ?? ($pengurus[0] ?? null);
        $bendahara = $this->findOfficer($pengurus, 'Bendahara') ?? ($pengurus[1] ?? $pengurus[0] ?? null);

        return view('laporan/index', [
            'bulan' => (int) $period['start']['bulan'], 'tahun' => (int) $period['start']['tahun'], 'jenisPeriode' => $jenisPeriode, 'period' => $period,
            'nominal_iuran' => $nominalIuran, 'totalPemasukanBulan' => $totalPemasukan, 'jumlahTransaksiBulan' => $jumlahTransaksi,
            'totalPengeluaranBulan' => $totalPengeluaran, 'jumlahKegiatanBulan' => count($pengeluaran), 'arusKasBulan' => $totalPemasukan - $totalPengeluaran,
            'saldoKumulatif' => $totalPemasukanSampaiPeriode - $totalPengeluaranSampaiPeriode, 'pengeluaranBulan' => $pengeluaran,
            'wargaPerBlok' => $wargaPerBlok, 'rekapWarga' => $rekap['warga'], 'totalWarga' => $rekap['statistik']['total_warga'],
            'totalLunas' => $rekap['statistik']['lunas'], 'totalBelum' => $rekap['statistik']['belum_bayar'] + $rekap['statistik']['macet'],
            'totalMacet' => $rekap['statistik']['macet'], 'totalPending' => $rekap['statistik']['menunggu_verifikasi'],
            'persentasePartisipasi' => $rekap['statistik']['total_warga'] > 0 ? round(($rekap['statistik']['lunas'] / $rekap['statistik']['total_warga']) * 100) : 0,
            'tahunOptions' => IuranPeriodSummary::availableYears($bounds), 'wilayah' => $wilayah, 'ketua' => $ketua, 'bendahara' => $bendahara, 'isWarga' => $isWarga,
        ]);
    }

    private function resolvePeriod(string $jenis, int $bulan, int $tahun, array $bounds, int $currentMonth, int $currentYear): array
    {
        if ($jenis === 'semua') {
            return IuranPeriodSummary::resolvePeriod(['jenis_periode' => 'rentang', 'bulan_awal' => $bounds['start']['bulan'], 'tahun_awal' => $bounds['start']['tahun'], 'bulan_akhir' => $bounds['end']['bulan'], 'tahun_akhir' => $bounds['end']['tahun']], $currentMonth, $currentYear, $bounds);
        }
        return IuranPeriodSummary::resolvePeriod(['jenis_periode' => $jenis, 'bulan' => $bulan, 'tahun' => $tahun, 'tahun_tahunan' => $tahun], $currentMonth, $currentYear, $bounds);
    }

    private function periodDates(array $period, string $jenis): array
    {
        if ($jenis === 'semua') return [null, null];
        $start = sprintf('%04d-%02d-01', $period['start']['tahun'], $period['start']['bulan']);
        $end = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $period['end']['tahun'], $period['end']['bulan'])));
        return [$start, $end];
    }

    private function findOfficer(array $pengurus, string $jabatan): ?array
    {
        foreach ($pengurus as $person) if (($person['jabatan'] ?? '') === $jabatan || stripos((string) ($person['nama'] ?? ''), $jabatan) !== false) return $person;
        return null;
    }
}
