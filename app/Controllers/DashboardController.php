<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PembayaranModel;
use App\Models\PengeluaranModel;
use App\Models\PengaturanIuranModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $pembayaranModel;
    protected $pengeluaranModel;
    protected $pengaturanIuranModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->pengaturanIuranModel = new PengaturanIuranModel();
    }

    public function index()
    {
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');

        // Total Warga Aktif
        $totalWarga = $this->userModel->where('role', 'warga')->where('is_active', 1)->countAllResults();

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

        // Warga Macet (Contoh dummy query untuk UTS: tampilkan warga dengan tagihan belum lunas)
        // Di sistem nyata, kita menghitung selisih bulan sejak joined. Untuk mock, kita ambil dari yang tidak ada di list bulan ini
        $wargaMacet = $this->userModel
            ->where('role', 'warga')
            ->where('is_active', 1)
            ->whereNotIn('id', function($builder) use ($currentMonth, $currentYear) {
                return $builder->select('user_id')->from('pembayaran')
                    ->where('periode_bulan', $currentMonth)
                    ->where('periode_tahun', $currentYear);
            })->limit(5)->find();

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
        ];

        return view('dashboard/index', $data); 
    }

    public function warga()
    {
        $userId = session()->get('id');
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');

        // Get Nominal Iuran Current
        $pengaturan = $this->pengaturanIuranModel->orderBy('berlaku_dari', 'DESC')->first();
        $nominalIuran = $pengaturan ? $pengaturan['nominal'] : 50000;

        // Cek Pembayaran Bulan Ini
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

        // Total Tunggakan Saya (Mock for UTS)
        $totalTunggakanSaya = $statusBulanIni == 'Belum Bayar' ? $nominalIuran : 0;
        
        $riwayatPembayaran = $this->pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('periode_tahun', 'DESC')
            ->orderBy('periode_bulan', 'DESC')
            ->limit(10)
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

        // Pengeluaran Terakhir
        $pengeluaranTerakhir = $this->pengeluaranModel
            ->select('pengeluaran.*, kategori_pengeluaran.nama_kategori')
            ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id')
            ->orderBy('tanggal', 'DESC')
            ->limit(3)
            ->find();

        $data = [
            'nominalIuran' => $nominalIuran,
            'statusBulanIni' => $statusBulanIni,
            'riwayatPembayaran' => $riwayatPembayaran,
            'pembayaranTerakhir' => $pembayaranTerakhir,
            'totalTunggakanSaya' => $totalTunggakanSaya,
            'totalIuranSayaTahunIni' => $totalIuranSayaTahunIni,
            'bulanLunasSaya' => $bulanLunasSaya,
            'saldoKas' => $saldoKas,
            'pengeluaranTerakhir' => $pengeluaranTerakhir
        ];

        return view('dashboard/warga', $data);
    }
}
