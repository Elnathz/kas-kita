<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PembayaranModel;
use App\Models\PengeluaranModel;
use App\Models\PengaturanIuranModel;
use App\Models\PengaturanSistemModel;
use App\Libraries\IuranPeriodSummary;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $pembayaranModel;
    protected $pengeluaranModel;
    protected $pengaturanIuranModel;
    protected $pengaturanSistemModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->pengaturanIuranModel = new PengaturanIuranModel();
        $this->pengaturanSistemModel = new PengaturanSistemModel();
    }

    // Menampilkan halaman daftar data utama
    public function index()
    {
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');

        // Total Warga Aktif
        $totalWarga = $this->userModel->where('is_active', 1)->countAllResults();

        // Total Iuran Terkumpul Bulan Ini (yang terverifikasi)
        $iuranBulanIni = $this->pembayaranModel
            ->where('periode_bulan', $currentMonth)
            ->where('periode_tahun', $currentYear)
            ->where('status', 'terverifikasi')
            ->selectSum('nominal')
            ->first()['nominal'] ?? 0;

        // Total Pengeluaran Bulan Ini
        $pengeluaranBulanIni = $this->pengeluaranModel
            ->where('MONTH(tanggal)', $currentMonth)
            ->where('YEAR(tanggal)', $currentYear)
            ->selectSum('nominal')
            ->first()['nominal'] ?? 0;

        // Saldo Kas Saat Ini (Total Iuran Terverifikasi - Total Pengeluaran)
        $totalPemasukan = $this->pembayaranModel->where('status', 'terverifikasi')->selectSum('nominal')->first()['nominal'] ?? 0;
        
        // Warga Sudah Bayar Bulan Ini
        $wargaSudahBayar = $this->pembayaranModel
            ->where('periode_bulan', $currentMonth)
            ->where('periode_tahun', $currentYear)
            ->where('status', 'terverifikasi')
            ->groupBy('user_id')
            ->countAllResults();

        $totalPengeluaran = $this->pengeluaranModel->selectSum('nominal')->first()['nominal'] ?? 0;
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        // Iuran Menunggu Verifikasi
        $menungguVerifikasi = $this->pembayaranModel->where('status', 'pending')->countAllResults();

        // Pembayaran Menunggu Verifikasi (List)
        $iuranMenunggu = $this->pembayaranModel
            ->select('pembayaran.*, users.nama as nama_warga, users.no_rumah, users.blok_rumah')
            ->join('users', 'users.id = pembayaran.user_id')
            ->where('pembayaran.status', 'pending')
            ->orderBy('pembayaran.created_at', 'ASC')
            ->findAll();

        // Pendaftar Baru Menunggu Persetujuan
        $pendaftarBaru = $this->userModel
            ->where('is_active', 0)
            ->orderBy('created_at', 'DESC')
            ->find();

        // Ambil pengaturan Iuran aktif
        $pengaturan = $this->currentPolicy();
        $toleransi_macet = $pengaturan && isset($pengaturan['toleransi_macet']) ? (int)$pengaturan['toleransi_macet'] : 2;

        // Warga Macet
        // Warga disebut macet jika belum bayar selama >= toleransi_macet bulan.
        // Untuk query ini, kita ambil semua warga yang aktif, 
        // lalu hitung berapa bulan sejak mereka bergabung atau sejak bulan pertama tahun ini (untuk mock).
        // Lebih aman kita hitung tunggakan asli.
        // Karena ini kompleks untuk query tunggal, kita ambil data lalu filter via PHP.
        
        $wargaAktif = $this->userModel->where('is_active', 1)->findAll();
        $pembayaranAktif = $this->pembayaranModel
            ->where('status', 'terverifikasi')
            ->orWhere('status', 'pending')
            ->findAll();

        $wargaMacet = [];
        foreach ($wargaAktif as $w) {
            // Hitung bulan belum terbayar dari awal tahun sampai bulan berjalan
            $tunggakan = 0;
            $joinedMonth = (int)date('m', strtotime($w['created_at']));
            $joinedYear = (int)date('Y', strtotime($w['created_at']));
            
            for ($i = 1; $i <= $currentMonth; $i++) {
                // Skip jika sebelum bergabung
                if ($currentYear < $joinedYear || ($currentYear == $joinedYear && $i < $joinedMonth)) {
                    continue;
                }
                
                $sudahBayar = false;
                foreach ($pembayaranAktif as $p) {
                    if ($p['user_id'] == $w['id'] && $p['periode_bulan'] == $i && $p['periode_tahun'] == $currentYear) {
                        $sudahBayar = true;
                        break;
                    }
                }
                
                if (!$sudahBayar) {
                    $tunggakan++;
                }
            }
            
            if ($tunggakan >= $toleransi_macet) {
                // Hitung total nominal tunggakan
                $w['total_tunggakan'] = $tunggakan * (int) ($pengaturan['nominal'] ?? 0);
                $w['bulan_tunggakan'] = $tunggakan;
                $wargaMacet[] = $w;
                if (count($wargaMacet) >= 5) break; // Limit 5
            }
        }

        $data = [
            'totalWarga' => $totalWarga,
            'wargaSudahBayar' => $wargaSudahBayar,
            'iuranBulanIni' => $iuranBulanIni,
            'pengeluaranBulanIni' => $pengeluaranBulanIni,
            'saldoKas' => $saldoKas,
            'menungguVerifikasi' => $menungguVerifikasi,
            'iuranMenunggu' => $iuranMenunggu,
            'pendaftarBaru' => $pendaftarBaru,
            'wargaMacet' => $wargaMacet,
            'toleransiMacet' => $toleransi_macet,
        ];

        return view('dashboard/index', $data); 
    }

    // Menampilkan dashboard atau laporan khusus untuk warga
    public function warga()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        $user = $this->userModel->find($userId) ?? [];

        $pengaturan = $this->currentPolicy();
        $nominalIuran = $pengaturan ? (int) $pengaturan['nominal'] : 0;

        $settings = $this->pengaturanIuranModel->orderBy('berlaku_dari', 'ASC')->findAll();
        $bounds = IuranPeriodSummary::resolveBounds(
            $settings[0]['berlaku_dari'] ?? null,
            $currentMonth,
            $currentYear,
        );
        $period = IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'rentang',
            'bulan_awal' => $bounds['start']['bulan'],
            'tahun_awal' => $bounds['start']['tahun'],
            'bulan_akhir' => $bounds['end']['bulan'],
            'tahun_akhir' => $bounds['end']['tahun'],
        ], $currentMonth, $currentYear, $bounds);

        $pembayaranBulanIni = $this->pembayaranModel
            ->where('user_id', $userId)
            ->where('periode_bulan', $currentMonth)
            ->where('periode_tahun', $currentYear)
            ->first();
            
        $statusBulanIni = 'Belum Bayar';
        if ($pembayaranBulanIni) {
            if ($pembayaranBulanIni['status'] == 'terverifikasi') {
                $statusBulanIni = 'Lunas';
            } elseif ($pembayaranBulanIni['status'] == 'pending') {
                $statusBulanIni = 'Menunggu Verifikasi';
            } elseif ($pembayaranBulanIni['status'] == 'ditolak') {
                $statusBulanIni = 'Ditolak';
            }
        }
        $tagihanBulanBerjalan = (int) ($pembayaranBulanIni['nominal'] ?? $nominalIuran);

        $pembayaranSaya = $this->pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('periode_tahun', 'ASC')
            ->orderBy('periode_bulan', 'ASC')
            ->findAll();
        $billingSaya = IuranPeriodSummary::residentBilling($user, $pembayaranSaya, $period, $nominalIuran);
        $totalTunggakanSaya = (int) $billingSaya['total_tagihan'];
        $jumlahTunggakanSaya = count($billingSaya['tagihan']);
        
        $riwayatPembayaran = $this->pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('periode_tahun', 'DESC')
            ->orderBy('periode_bulan', 'DESC')
            ->limit(20)
            ->find();
            
        $pembayaranTerakhir = $this->pembayaranModel
            ->where('user_id', $userId)
            ->where('status', 'terverifikasi')
            ->orderBy('created_at', 'DESC')
            ->first();

        // Total Iuran Terbayar Tahun Ini (Saya)
        $totalIuranSayaTahunIni = $this->pembayaranModel
            ->where('user_id', $userId)
            ->where('periode_tahun', $currentYear)
            ->where('status', 'terverifikasi')
            ->selectSum('nominal')
            ->first()['nominal'] ?? 0;
            
        $bulanLunasSaya = $this->pembayaranModel
            ->where('user_id', $userId)
            ->where('periode_tahun', $currentYear)
            ->where('status', 'terverifikasi')
            ->countAllResults();

        // Transparansi Saldo Kas
        $totalPemasukan = $this->pembayaranModel->where('status', 'terverifikasi')->selectSum('nominal')->first()['nominal'] ?? 0;
        $totalPengeluaran = $this->pengeluaranModel->selectSum('nominal')->first()['nominal'] ?? 0;
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        $wilayah = [];
        foreach ($this->pengaturanSistemModel->where('kategori', 'wilayah')->findAll() as $row) {
            $wilayah[$row['kunci']] = $row['nilai'];
        }

        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        // Pengeluaran bulan berjalan, sama dengan periode default laporan.
        $awalBulanBerjalan = sprintf('%04d-%02d-01', $currentYear, $currentMonth);
        $akhirBulanBerjalan = date('Y-m-t', strtotime($awalBulanBerjalan));
        $pengeluaranTerakhir = $this->pengeluaranModel
            ->select('pengeluaran.*, kategori_pengeluaran.nama_kategori')
            ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id')
            ->where('tanggal >=', $awalBulanBerjalan)
            ->where('tanggal <=', $akhirBulanBerjalan)
            ->orderBy('tanggal', 'DESC')
            ->find();

        $data = [
            'user' => $user,
            'nominalIuran' => $nominalIuran,
            'tagihanBulanBerjalan' => $tagihanBulanBerjalan,
            'statusBulanIni' => $statusBulanIni,
            'riwayatPembayaran' => $riwayatPembayaran,
            'pembayaranTerakhir' => $pembayaranTerakhir,
            'totalTunggakanSaya' => $totalTunggakanSaya,
            'jumlahTunggakanSaya' => $jumlahTunggakanSaya,
            'totalIuranSayaTahunIni' => $totalIuranSayaTahunIni,
            'bulanLunasSaya' => $bulanLunasSaya,
            'saldoKas' => $saldoKas,
            'pengeluaranTerakhir' => $pengeluaranTerakhir,
            'wilayah' => $wilayah,
            'bulanNama' => $bulanNama,
            'tahunSekarang' => $currentYear,
        ];

        return view('dashboard/warga', $data);
    }

    private function currentPolicy(): ?array
    {
        return IuranPeriodSummary::effectiveSetting(
            $this->pengaturanIuranModel->orderBy('berlaku_dari', 'ASC')->findAll()
        );
    }
}
