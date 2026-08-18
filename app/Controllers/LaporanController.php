<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\PengeluaranModel;
use App\Models\UserModel;
use App\Models\MasterBlokModel;
use App\Models\PengaturanIuranModel;

class LaporanController extends BaseController
{
    protected $pembayaranModel;
    protected $pengeluaranModel;
    protected $userModel;
    protected $masterBlokModel;
    protected $pengaturanModel;

    public function __construct()
    {
        $this->pembayaranModel  = new PembayaranModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->userModel        = new UserModel();
        $this->masterBlokModel  = new MasterBlokModel();
        $this->pengaturanModel  = new PengaturanIuranModel();
    }

    public function index()
    {
        return $this->tampilLaporan();
    }

    public function warga()
    {
        return $this->tampilLaporan(true);
    }

    private function tampilLaporan(bool $isWarga = false)
    {
        $bulan  = (int)($this->request->getGet('bulan') ?? date('n'));
        $tahun  = (int)($this->request->getGet('tahun') ?? date('Y'));

        // Validasi rentang
        if ($bulan < 1 || $bulan > 12) $bulan = (int)date('n');
        if ($tahun < 2020 || $tahun > 2099) $tahun = (int)date('Y');

        // Ambil nominal iuran
        $pengaturan    = $this->pengaturanModel->orderBy('berlaku_dari', 'DESC')->first();
        $nominal_iuran = $pengaturan ? (int)$pengaturan['nominal'] : 50000;

        // Total pemasukan bulan ini (terverifikasi)
        $totalPemasukanBulan = $this->pembayaranModel
            ->where('periode_bulan', $bulan)
            ->where('periode_tahun', $tahun)
            ->where('status', 'terverifikasi')
            ->selectSum('nominal')
            ->first()['nominal'] ?? 0;

        $jumlahTransaksiBulan = $this->pembayaranModel
            ->where('periode_bulan', $bulan)
            ->where('periode_tahun', $tahun)
            ->where('status', 'terverifikasi')
            ->countAllResults();

        // Total pengeluaran bulan ini
        $totalPengeluaranBulan = $this->pengeluaranModel
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->selectSum('nominal')
            ->first()['nominal'] ?? 0;

        $jumlahKegiatanBulan = $this->pengeluaranModel
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();

        // Arus kas bulan ini
        $arusKasBulan = $totalPemasukanBulan - $totalPengeluaranBulan;

        // Saldo kumulatif RT (semua waktu)
        $totalPemasukan  = $this->pembayaranModel->where('status', 'terverifikasi')->selectSum('nominal')->first()['nominal'] ?? 0;
        $totalPengeluaran = $this->pengeluaranModel->selectSum('nominal')->first()['nominal'] ?? 0;
        $saldoKumulatif  = $totalPemasukan - $totalPengeluaran;

        // Rincian pengeluaran bulan ini
        $pengeluaranBulan = $this->pengeluaranModel
            ->select('pengeluaran.*, kategori_pengeluaran.nama_kategori')
            ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id', 'left')
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        // Statistik per blok
        $masterBlok = $this->masterBlokModel->findAll();
        $warga      = $this->userModel->where('role', 'warga')->where('is_active', 1)->findAll();

        // Ambil semua pembayaran bulan ini (terverifikasi + pending)
        $pembayaranBulan = $this->pembayaranModel
            ->where('periode_bulan', $bulan)
            ->where('periode_tahun', $tahun)
            ->findAll();

        // Index pembayaran per user
        $statusPerUser = [];
        foreach ($pembayaranBulan as $p) {
            if (!isset($statusPerUser[$p['user_id']]) || $p['status'] == 'terverifikasi') {
                $statusPerUser[$p['user_id']] = $p['status'];
            }
        }

        $statistikBlok  = [];
        $totalWarga     = count($warga);
        $totalLunas     = 0;
        $totalBelum     = 0;
        $totalMacet     = 0;

        $wargaPerBlok = [];
        foreach ($masterBlok as $blok) {
            $wargaPerBlok[$blok['nama_blok']] = [
                'kapasitas' => $blok['maks_nomor'],
                'lunas'     => 0,
                'belum'     => 0,
                'pending'   => 0,
                'warga'     => []
            ];
        }

        foreach ($warga as $w) {
            $blok = $w['blok_rumah'];
            if (!isset($wargaPerBlok[$blok])) {
                $wargaPerBlok[$blok] = ['kapasitas' => 0, 'lunas' => 0, 'belum' => 0, 'pending' => 0, 'warga' => []];
            }

            $status = $statusPerUser[$w['id']] ?? 'belum';
            $wargaPerBlok[$blok]['warga'][] = [
                'nama'      => $w['nama'],
                'no_rumah'  => $w['no_rumah'],
                'no_telepon' => $w['no_telepon'] ?? '',
                'status'    => $status
            ];

            if ($status == 'terverifikasi') {
                $wargaPerBlok[$blok]['lunas']++;
                $totalLunas++;
            } elseif ($status == 'pending') {
                $wargaPerBlok[$blok]['pending']++;
            } else {
                $wargaPerBlok[$blok]['belum']++;
                $totalBelum++;
            }
        }

        // Persentase partisipasi
        $persentasePartisipasi = $totalWarga > 0 ? round(($totalLunas / $totalWarga) * 100) : 0;

        // Daftar tahun yang tersedia untuk filter (dari data pembayaran)
        $db           = \Config\Database::connect();
        $tahunList    = $db->table('pembayaran')->select('DISTINCT YEAR(created_at) as tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();
        $tahunOptions = array_column($tahunList, 'tahun');
        if (!in_array($tahun, $tahunOptions)) {
            $tahunOptions[] = $tahun;
            rsort($tahunOptions);
        }

        $data = [
            'bulan'                  => $bulan,
            'tahun'                  => $tahun,
            'nominal_iuran'          => $nominal_iuran,
            'totalPemasukanBulan'    => (int)$totalPemasukanBulan,
            'jumlahTransaksiBulan'   => $jumlahTransaksiBulan,
            'totalPengeluaranBulan'  => (int)$totalPengeluaranBulan,
            'jumlahKegiatanBulan'    => $jumlahKegiatanBulan,
            'arusKasBulan'           => (int)$arusKasBulan,
            'saldoKumulatif'         => (int)$saldoKumulatif,
            'pengeluaranBulan'       => $pengeluaranBulan,
            'wargaPerBlok'           => $wargaPerBlok,
            'totalWarga'             => $totalWarga,
            'totalLunas'             => $totalLunas,
            'totalBelum'             => $totalBelum,
            'persentasePartisipasi'  => $persentasePartisipasi,
            'tahunOptions'           => $tahunOptions,
            'isWarga'                => $isWarga
        ];

        return view('laporan/index', $data);
    }
}
