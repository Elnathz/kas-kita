<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IuranController extends BaseController
{
    public function index()
    {
        $pembayaranModel = new \App\Models\PembayaranModel();
        $userModel = new \App\Models\UserModel();
        $masterBlokModel = new \App\Models\MasterBlokModel();

        $bulan_ini = (int)date('m');
        $tahun_ini = (int)date('Y');

        // Fetch all warga
        $warga = $userModel->where('role', 'warga')->findAll();

        // Fetch all pembayaran
        $pembayaran = $pembayaranModel->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan')
                                      ->join('users', 'users.id = pembayaran.user_id')
                                      ->orderBy('pembayaran.created_at', 'DESC')
                                      ->findAll();

        // Data for cards
        $menunggu_verifikasi = 0;
        $total_verifikasi = 0;
        $lunas = 0;
        $total_lunas = 0;

        foreach ($pembayaran as $p) {
            if ($p['periode_bulan'] == $bulan_ini && $p['periode_tahun'] == $tahun_ini) {
                if ($p['status'] == 'pending') {
                    $menunggu_verifikasi++;
                    $total_verifikasi += $p['nominal'];
                } elseif ($p['status'] == 'lunas') {
                    $lunas++;
                    $total_lunas += $p['nominal'];
                }
            }
        }

        $total_warga = count($warga);
        $belum_bayar = $total_warga - $lunas - $menunggu_verifikasi;
        if ($belum_bayar < 0) $belum_bayar = 0;

        $macet = 0; 
        $total_tunggakan = 0;
        $nominal_iuran = 50000; // Assumption

        // Group by blok
        $master_blok = $masterBlokModel->findAll();
        $warga_per_blok = [];
        foreach ($master_blok as $blok) {
            $warga_per_blok[$blok['nama_blok']] = [
                'kapasitas' => $blok['maks_nomor'],
                'warga' => [],
                'terkumpul' => 0,
                'target' => 0
            ];
        }

        foreach ($warga as $w) {
            $blok = $w['blok_rumah'];
            if (isset($warga_per_blok[$blok])) {
                $status = 'belum_bayar';
                $nominal_bayar = 0;
                $keterangan = 'Belum bayar bulan ini';

                // Find payment for this month
                foreach ($pembayaran as $p) {
                    if ($p['user_id'] == $w['id'] && $p['periode_bulan'] == $bulan_ini && $p['periode_tahun'] == $tahun_ini) {
                        $status = $p['status'];
                        $nominal_bayar = $p['nominal'];
                        if ($status == 'pending') $keterangan = 'Menunggu Verifikasi';
                        if ($status == 'lunas') $keterangan = 'Lunas';
                        break;
                    }
                }

                // Check tunggakan
                $last_paid_bulan = 0;
                $last_paid_tahun = 0;
                foreach ($pembayaran as $p) {
                    if ($p['user_id'] == $w['id'] && ($p['status'] == 'lunas' || $p['status'] == 'pending')) {
                        if ($p['periode_tahun'] > $last_paid_tahun || ($p['periode_tahun'] == $last_paid_tahun && $p['periode_bulan'] > $last_paid_bulan)) {
                            $last_paid_bulan = $p['periode_bulan'];
                            $last_paid_tahun = $p['periode_tahun'];
                        }
                    }
                }

                if ($last_paid_tahun == 0) {
                    $last_paid_bulan = $bulan_ini - 2; // Mocking if never paid
                    $last_paid_tahun = $tahun_ini;
                }

                $tunggakan_bulan = 0;
                if ($tahun_ini == $last_paid_tahun) {
                    $tunggakan_bulan = $bulan_ini - $last_paid_bulan - 1; // -1 to exclude current month if not paid
                }

                if ($status == 'belum_bayar' && $tunggakan_bulan > 0) {
                    $status = 'tunggakan';
                    $keterangan = "Tunggakan $tunggakan_bulan bulan";
                    $macet++;
                    $total_tunggakan += ($tunggakan_bulan * $nominal_iuran);
                }

                $warga_per_blok[$blok]['warga'][] = [
                    'id' => $w['id'],
                    'no_rumah' => $w['no_rumah'],
                    'nama' => $w['nama'],
                    'status' => $status,
                    'nominal' => $nominal_bayar,
                    'keterangan' => $keterangan,
                    'no_hp' => $w['no_hp'] ?? '0'
                ];
                $warga_per_blok[$blok]['target'] += $nominal_iuran;
                if ($status == 'lunas') {
                    $warga_per_blok[$blok]['terkumpul'] += $nominal_bayar;
                }
            }
        }

        $data = [
            'pembayaran' => $pembayaran,
            'menunggu_verifikasi' => $menunggu_verifikasi,
            'total_verifikasi' => $total_verifikasi,
            'lunas' => $lunas,
            'total_lunas' => $total_lunas,
            'belum_bayar' => $belum_bayar,
            'macet' => $macet,
            'total_tunggakan' => $total_tunggakan,
            'warga_per_blok' => $warga_per_blok,
            'total_warga' => $total_warga,
            'bulan_ini' => $bulan_ini,
            'tahun_ini' => $tahun_ini
        ];

        return view('iuran/index', $data);
    }

    public function tagihan()
    {
        $userId = session()->get('id');
        if (!$userId) return redirect()->to('/login');

        // Mock data for tagihan for now based on user
        // We'll calculate tunggakan based on current month (8) minus last paid month
        $pembayaranModel = new \App\Models\PembayaranModel();
        
        $pembayaran = $pembayaranModel->where('user_id', $userId)
                                      ->orderBy('periode_tahun', 'DESC')
                                      ->orderBy('periode_bulan', 'DESC')
                                      ->findAll();

        $bulan_ini = (int)date('m');
        $tahun_ini = (int)date('Y');
        
        // Find last paid month
        $last_paid_bulan = 0;
        $last_paid_tahun = 0;
        foreach ($pembayaran as $p) {
            if ($p['status'] == 'lunas' || $p['status'] == 'pending') {
                $last_paid_bulan = $p['periode_bulan'];
                $last_paid_tahun = $p['periode_tahun'];
                break; // Because ordered by desc
            }
        }

        if ($last_paid_tahun == 0) {
            $last_paid_bulan = $bulan_ini - 2; // Mocking if never paid
            $last_paid_tahun = $tahun_ini;
        }

        $tagihan_list = [];
        $total_tagihan = 0;
        $tarif = 50000;

        // Loop from last paid to current month
        for ($b = $last_paid_bulan + 1; $b <= $bulan_ini; $b++) {
            $status = ($b == $bulan_ini) ? 'Bulan Berjalan' : 'Tunggakan';
            $tagihan_list[] = [
                'bulan' => $b,
                'tahun' => $tahun_ini,
                'tarif' => $tarif,
                'status' => $status
            ];
            $total_tagihan += $tarif;
        }

        return view('iuran/tagihan', [
            'tagihan_list' => $tagihan_list,
            'total_tagihan' => $total_tagihan
        ]);
    }

    public function bayar()
    {
        $userId = session()->get('id');
        if (!$userId) return redirect()->to('/login');

        // Reuse tagihan calculation for bayar view
        $pembayaranModel = new \App\Models\PembayaranModel();
        $pembayaran = $pembayaranModel->where('user_id', $userId)
                                      ->orderBy('periode_tahun', 'DESC')
                                      ->orderBy('periode_bulan', 'DESC')
                                      ->findAll();

        $bulan_ini = (int)date('m');
        $tahun_ini = (int)date('Y');
        
        $last_paid_bulan = 0;
        $last_paid_tahun = 0;
        foreach ($pembayaran as $p) {
            if ($p['status'] == 'lunas' || $p['status'] == 'pending') {
                $last_paid_bulan = $p['periode_bulan'];
                $last_paid_tahun = $p['periode_tahun'];
                break;
            }
        }

        if ($last_paid_tahun == 0) {
            $last_paid_bulan = $bulan_ini - 2; 
            $last_paid_tahun = $tahun_ini;
        }

        $tagihan_list = [];
        $tarif = 50000;

        for ($b = $last_paid_bulan + 1; $b <= $bulan_ini; $b++) {
            $status = ($b == $bulan_ini) ? 'Bulan Berjalan' : 'Tunggakan';
            $tagihan_list[] = [
                'bulan' => $b,
                'tahun' => $tahun_ini,
                'tarif' => $tarif,
                'status' => $status
            ];
        }

        return view('iuran/bayar', ['tagihan_list' => $tagihan_list]);
    }

    public function prosesBayar()
    {
        $userId = session()->get('id');
        if (!$userId) return redirect()->to('/login');

        $pembayaranModel = new \App\Models\PembayaranModel();

        // Get file
        $file = $this->request->getFile('bukti_transfer');
        $namaFile = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/bukti', $namaFile);
        }

        $pembayaranModel->insert([
            'user_id' => $userId,
            'periode_bulan' => $this->request->getPost('periode_bulan'),
            'periode_tahun' => $this->request->getPost('periode_tahun'),
            'nominal' => $this->request->getPost('nominal'),
            'bukti_transfer' => $namaFile,
            'status' => 'pending',
            'catatan' => $this->request->getPost('catatan')
        ]);

        return redirect()->to('/iuran/riwayat')->with('message', 'Pembayaran berhasil diupload. Menunggu verifikasi pengurus.');
    }

    public function riwayat()
    {
        $userId = session()->get('id');
        if (!$userId) return redirect()->to('/login');

        $pembayaranModel = new \App\Models\PembayaranModel();
        
        $pembayaran = $pembayaranModel->where('user_id', $userId)
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        return view('iuran/riwayat', ['pembayaran' => $pembayaran]);
    }

    public function verifikasi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');
        $pembayaranModel = new \App\Models\PembayaranModel();
        
        $pembayaran = $pembayaranModel->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan')
                                      ->join('users', 'users.id = pembayaran.user_id')
                                      ->find($id);

        if (!$pembayaran) return redirect()->to('/iuran');

        return view('iuran/verifikasi', ['pembayaran' => $pembayaran]);
    }

    public function prosesVerifikasi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');
        
        $pembayaranModel = new \App\Models\PembayaranModel();
        
        $data = [
            'status' => $this->request->getPost('status'),
            'catatan' => $this->request->getPost('catatan'),
            'verified_by' => session()->get('id'), // Assuming pengurus id is in session
            'verified_at' => date('Y-m-d H:i:s')
        ];

        $pembayaranModel->update($id, $data);

        return redirect()->to('/iuran')->with('message', 'Pembayaran berhasil diverifikasi.');
    }

    public function kuitansi($id = null)
    {
        if (!$id) return redirect()->to('/iuran');
        $pembayaranModel = new \App\Models\PembayaranModel();
        
        $pembayaran = $pembayaranModel->select('pembayaran.*, users.nama, users.blok_rumah, users.no_rumah, users.nama_jalan')
                                      ->join('users', 'users.id = pembayaran.user_id')
                                      ->find($id);

        if (!$pembayaran) return redirect()->to('/iuran');

        return view('iuran/kuitansi', ['pembayaran' => $pembayaran]);
    }
}
