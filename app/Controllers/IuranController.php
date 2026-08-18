<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IuranController extends BaseController
{
    public function index()
    {
        $pembayaranModel    = new \App\Models\PembayaranModel();
        $userModel          = new \App\Models\UserModel();
        $masterBlokModel    = new \App\Models\MasterBlokModel();
        $pengaturanModel    = new \App\Models\PengaturanIuranModel();

        $bulan_ini  = (int)date('m');
        $tahun_ini  = (int)date('Y');

        // Ambil nominal iuran dari database
        $pengaturan    = $pengaturanModel->orderBy('berlaku_dari', 'DESC')->first();
        $nominal_iuran = $pengaturan ? (int)$pengaturan['nominal'] : 50000;

        // Ambil semua warga
        $warga = $userModel->where('role', 'warga')->findAll();

        // Ambil semua pembayaran dengan join ke users
        $pembayaran = $pembayaranModel
            ->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan, users.no_telepon')
            ->join('users', 'users.id = pembayaran.user_id')
            ->orderBy('pembayaran.created_at', 'DESC')
            ->findAll();

        // Hitung statistik cards bulan ini
        $menunggu_verifikasi = 0;
        $total_verifikasi    = 0;
        $lunas               = 0;
        $total_lunas         = 0;

        foreach ($pembayaran as $p) {
            if ($p['periode_bulan'] == $bulan_ini && $p['periode_tahun'] == $tahun_ini) {
                if ($p['status'] == 'pending') {
                    $menunggu_verifikasi++;
                    $total_verifikasi += $p['nominal'];
                } elseif ($p['status'] == 'terverifikasi') {
                    $lunas++;
                    $total_lunas += $p['nominal'];
                }
            }
        }

        $total_warga = count($warga);
        $belum_bayar = $total_warga - $lunas - $menunggu_verifikasi;
        if ($belum_bayar < 0) $belum_bayar = 0;

        $macet           = 0;
        $total_tunggakan = 0;

        // Group warga per blok
        $master_blok    = $masterBlokModel->findAll();
        $warga_per_blok = [];
        foreach ($master_blok as $blok) {
            $warga_per_blok[$blok['nama_blok']] = [
                'kapasitas' => $blok['maks_nomor'],
                'warga'     => [],
                'terkumpul' => 0,
                'target'    => 0
            ];
        }

        foreach ($warga as $w) {
            $blok = $w['blok_rumah'];
            if (!isset($warga_per_blok[$blok])) continue;

            $status      = 'belum_bayar';
            $nominal_bayar = 0;
            $keterangan  = 'Belum bayar bulan ini';
            $pembayaran_id = null;

            // Cari pembayaran bulan ini
            foreach ($pembayaran as $p) {
                if ($p['user_id'] == $w['id'] && $p['periode_bulan'] == $bulan_ini && $p['periode_tahun'] == $tahun_ini) {
                    $status        = $p['status'];
                    $nominal_bayar = $p['nominal'];
                    $pembayaran_id = $p['id'];
                    if ($status == 'pending')        $keterangan = 'Menunggu Verifikasi';
                    if ($status == 'terverifikasi')  $keterangan = 'Lunas';
                    if ($status == 'ditolak')        $keterangan = 'Ditolak - Perlu Upload Ulang';
                    break;
                }
            }

            // Cek tunggakan: ambil bulan terakhir yang terverifikasi
            $last_paid_bulan = 0;
            $last_paid_tahun = 0;
            foreach ($pembayaran as $p) {
                if ($p['user_id'] == $w['id'] && ($p['status'] == 'terverifikasi' || $p['status'] == 'pending')) {
                    if ($p['periode_tahun'] > $last_paid_tahun || ($p['periode_tahun'] == $last_paid_tahun && $p['periode_bulan'] > $last_paid_bulan)) {
                        $last_paid_bulan = (int)$p['periode_bulan'];
                        $last_paid_tahun = (int)$p['periode_tahun'];
                    }
                }
            }

            // Hitung tunggakan hanya jika belum bayar bulan ini
            if ($status == 'belum_bayar' && $last_paid_tahun > 0) {
                if ($last_paid_tahun == $tahun_ini) {
                    $tunggakan_bulan = $bulan_ini - $last_paid_bulan - 1;
                } else {
                    // Tahun sebelumnya
                    $tunggakan_bulan = (12 - $last_paid_bulan) + $bulan_ini - 1;
                }

                if ($tunggakan_bulan > 0) {
                    $status      = 'tunggakan';
                    $keterangan  = "Tunggakan $tunggakan_bulan bulan";
                    $macet++;
                    $total_tunggakan += ($tunggakan_bulan * $nominal_iuran);
                }
            }

            $warga_per_blok[$blok]['warga'][] = [
                'id'            => $w['id'],
                'no_rumah'      => $w['no_rumah'],
                'nama'          => $w['nama'],
                'status'        => $status,
                'nominal'       => $nominal_bayar,
                'keterangan'    => $keterangan,
                'no_hp'         => $w['no_telepon'] ?? '0',
                'pembayaran_id' => $pembayaran_id
            ];
            $warga_per_blok[$blok]['target'] += $nominal_iuran;
            if ($status == 'terverifikasi') {
                $warga_per_blok[$blok]['terkumpul'] += $nominal_bayar;
            }
        }

        $data = [
            'pembayaran'          => $pembayaran,
            'menunggu_verifikasi' => $menunggu_verifikasi,
            'total_verifikasi'    => $total_verifikasi,
            'lunas'               => $lunas,
            'total_lunas'         => $total_lunas,
            'belum_bayar'         => $belum_bayar,
            'macet'               => $macet,
            'total_tunggakan'     => $total_tunggakan,
            'warga_per_blok'      => $warga_per_blok,
            'total_warga'         => $total_warga,
            'bulan_ini'           => $bulan_ini,
            'tahun_ini'           => $tahun_ini,
            'nominal_iuran'       => $nominal_iuran
        ];

        return view('iuran/index', $data);
    }

    public function tagihan()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $pembayaranModel = new \App\Models\PembayaranModel();
        $pengaturanModel = new \App\Models\PengaturanIuranModel();

        $pengaturan = $pengaturanModel->orderBy('berlaku_dari', 'DESC')->first();
        $tarif      = $pengaturan ? (int)$pengaturan['nominal'] : 50000;

        $pembayaran = $pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('periode_tahun', 'DESC')
            ->orderBy('periode_bulan', 'DESC')
            ->findAll();

        $bulan_ini  = (int)date('m');
        $tahun_ini  = (int)date('Y');

        // Buat set periode yang sudah dibayar/pending
        $periode_terbayar = [];
        foreach ($pembayaran as $p) {
            if ($p['status'] == 'terverifikasi' || $p['status'] == 'pending') {
                $periode_terbayar[$p['periode_tahun'] . '-' . $p['periode_bulan']] = $p['status'];
            }
        }

        // Cari bulan pertama yang belum terbayar
        $tagihan_list = [];
        $total_tagihan = 0;

        // Cek sampai 12 bulan ke belakang
        for ($i = 11; $i >= 0; $i--) {
            $cek_bulan = $bulan_ini - $i;
            $cek_tahun = $tahun_ini;
            if ($cek_bulan <= 0) {
                $cek_bulan += 12;
                $cek_tahun--;
            }
            $key = $cek_tahun . '-' . $cek_bulan;
            if (!isset($periode_terbayar[$key])) {
                $status = ($cek_bulan == $bulan_ini && $cek_tahun == $tahun_ini) ? 'Bulan Berjalan' : 'Tunggakan';
                $tagihan_list[] = [
                    'bulan'  => $cek_bulan,
                    'tahun'  => $cek_tahun,
                    'tarif'  => $tarif,
                    'status' => $status
                ];
                $total_tagihan += $tarif;
            }
        }

        return view('iuran/tagihan', [
            'tagihan_list'  => $tagihan_list,
            'total_tagihan' => $total_tagihan
        ]);
    }

    public function bayar()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $pembayaranModel = new \App\Models\PembayaranModel();
        $pengaturanModel = new \App\Models\PengaturanIuranModel();

        $pengaturan = $pengaturanModel->orderBy('berlaku_dari', 'DESC')->first();
        $tarif      = $pengaturan ? (int)$pengaturan['nominal'] : 50000;

        $pembayaran = $pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('periode_tahun', 'DESC')
            ->orderBy('periode_bulan', 'DESC')
            ->findAll();

        $bulan_ini = (int)date('m');
        $tahun_ini = (int)date('Y');

        $periode_terbayar = [];
        foreach ($pembayaran as $p) {
            if ($p['status'] == 'terverifikasi' || $p['status'] == 'pending') {
                $periode_terbayar[$p['periode_tahun'] . '-' . $p['periode_bulan']] = true;
            }
        }

        $tagihan_list = [];
        for ($i = 11; $i >= 0; $i--) {
            $cek_bulan = $bulan_ini - $i;
            $cek_tahun = $tahun_ini;
            if ($cek_bulan <= 0) {
                $cek_bulan += 12;
                $cek_tahun--;
            }
            $key = $cek_tahun . '-' . $cek_bulan;
            if (!isset($periode_terbayar[$key])) {
                $status = ($cek_bulan == $bulan_ini && $cek_tahun == $tahun_ini) ? 'Bulan Berjalan' : 'Tunggakan';
                $tagihan_list[] = [
                    'bulan'  => $cek_bulan,
                    'tahun'  => $cek_tahun,
                    'tarif'  => $tarif,
                    'status' => $status
                ];
            }
        }

        return view('iuran/bayar', ['tagihan_list' => $tagihan_list, 'tarif' => $tarif]);
    }

    public function prosesBayar()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $pembayaranModel = new \App\Models\PembayaranModel();

        // Cek apakah periode yang sama sudah ada (pending/terverifikasi)
        $periode_bulan = (int)$this->request->getPost('periode_bulan');
        $periode_tahun = (int)$this->request->getPost('periode_tahun');

        $existing = $pembayaranModel
            ->where('user_id', $userId)
            ->where('periode_bulan', $periode_bulan)
            ->where('periode_tahun', $periode_tahun)
            ->whereIn('status', ['pending', 'terverifikasi'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Pembayaran untuk periode ini sudah ada atau sedang diproses.');
        }

        $file    = $this->request->getFile('bukti_transfer');
        $namaFile = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/bukti', $namaFile);
        }

        $pembayaranModel->insert([
            'user_id'       => $userId,
            'periode_bulan' => $periode_bulan,
            'periode_tahun' => $periode_tahun,
            'nominal'       => $this->request->getPost('nominal'),
            'bukti_transfer' => $namaFile,
            'status'        => 'pending',
            'catatan'       => $this->request->getPost('catatan')
        ]);

        return redirect()->to('/iuran/riwayat')->with('message', 'Pembayaran berhasil diupload. Menunggu verifikasi pengurus.');
    }

    public function riwayat()
    {
        $userId = session()->get('id') ?? session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $pembayaranModel = new \App\Models\PembayaranModel();

        $pembayaran = $pembayaranModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('iuran/riwayat', ['pembayaran' => $pembayaran]);
    }

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

    public function prosesVerifikasi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');

        $pembayaranModel = new \App\Models\PembayaranModel();

        // Baca 'action' dari form (button name="action" value="terima"/"tolak")
        $action = $this->request->getPost('action');

        if ($action === 'terima') {
            $status = 'terverifikasi';
        } elseif ($action === 'tolak') {
            $status = 'ditolak';
        } else {
            return redirect()->to('/iuran')->with('error', 'Aksi tidak valid.');
        }

        $data = [
            'status'      => $status,
            'catatan'     => $this->request->getPost('catatan'),
            'verified_by' => session()->get('id') ?? session()->get('user_id'),
            'verified_at' => date('Y-m-d H:i:s')
        ];

        $pembayaranModel->update($id, $data);

        $pesan = ($status === 'terverifikasi')
            ? 'Pembayaran berhasil diverifikasi.'
            : 'Pembayaran ditolak. Warga akan diminta upload ulang.';

        return redirect()->to('/iuran')->with('message', $pesan);
    }

    public function kuitansi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');
        $pembayaranModel = new \App\Models\PembayaranModel();

        $pembayaran = $pembayaranModel
            ->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan')
            ->join('users', 'users.id = pembayaran.user_id')
            ->find($id);

        if (!$pembayaran) return redirect()->to('/iuran');

        return view('iuran/kuitansi', ['pembayaran' => $pembayaran]);
    }
}
