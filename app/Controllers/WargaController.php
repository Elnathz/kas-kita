<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MasterBlokModel;

class WargaController extends BaseController
{
    protected $userModel;
    protected $masterBlokModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->masterBlokModel = new MasterBlokModel();
    }

    // Menampilkan halaman daftar data utama
    public function index()
    {
        $blokList = $this->masterBlokModel->findAll();
        $users = $this->userModel->orderBy('no_rumah', 'ASC')->findAll();

        $dataWargaPerBlok = [];
        $totalWarga = 0;

        foreach ($blokList as $blok) {
            $dataWargaPerBlok[$blok['nama_blok']] = [
                'id' => $blok['id'],
                'kapasitas' => $blok['maks_nomor'],
                'warga' => [],
                'warga_aktif_count' => 0
            ];
        }

        $totalWargaAktif = 0;
        foreach ($users as $user) {
            if (isset($dataWargaPerBlok[$user['blok_rumah']])) {
                $dataWargaPerBlok[$user['blok_rumah']]['warga'][] = $user;
                $totalWarga++;
                if ($user['is_active'] == 1) {
                    $dataWargaPerBlok[$user['blok_rumah']]['warga_aktif_count']++;
                    $totalWargaAktif++;
                }
            }
        }

        $data = [
            'dataWargaPerBlok' => $dataWargaPerBlok,
            'totalWarga' => $totalWarga,
            'totalWargaAktif' => $totalWargaAktif
        ];

        return view('warga/index', $data);
    }

    // Menampilkan form untuk menambah data baru
    public function create()
    {
        $masterJalanModel = new \App\Models\MasterJalanModel();
        
        $data = [
            'master_blok' => $this->masterBlokModel->findAll(),
            'master_jalan' => $masterJalanModel->findAll()
        ];
        return view('warga/create', $data);
    }

    // Memproses penyimpanan data baru ke database
    public function store()
    {
        $rules = [
            'nama' => 'required',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'no_telepon' => 'required',
            'blok_rumah' => 'required',
            'no_rumah' => 'required',
            'nama_jalan' => 'required',
            'role' => 'required',
            'status' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => md5($this->request->getPost('password')),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'blok_rumah' => $this->request->getPost('blok_rumah'),
            'no_rumah' => $this->request->getPost('no_rumah'),
            'nama_jalan' => $this->request->getPost('nama_jalan'),
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('status') == 'active' ? 1 : 0
        ];

        $this->userModel->insert($data);

        return redirect()->to('/warga')->with('message', 'Warga berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengubah data berdasarkan ID
    public function edit($id = null)
    {
        if (!$id) return redirect()->to('/warga');
        
        $warga = $this->userModel->find($id);
        if (!$warga) return redirect()->to('/warga');

        $masterJalanModel = new \App\Models\MasterJalanModel();
        
        $data = [
            'warga' => $warga,
            'master_blok' => $this->masterBlokModel->findAll(),
            'master_jalan' => $masterJalanModel->findAll()
        ];

        return view('warga/edit', $data);
    }

    // Memproses pembaruan data ke database
    public function update($id = null)
    {
        if (!$id) return redirect()->to('/warga');

        $rules = [
            'nama' => 'required',
            'username' => 'required',
            'no_telepon' => 'required',
            'blok_rumah' => 'required',
            'no_rumah' => 'required',
            'nama_jalan' => 'required',
            'role' => 'required',
            'status' => 'required'
        ];

        // Check unique username only if it changed
        $warga = $this->userModel->find($id);
        if ($warga['username'] !== $this->request->getPost('username')) {
            $rules['username'] = 'required|is_unique[users.username]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'blok_rumah' => $this->request->getPost('blok_rumah'),
            'no_rumah' => $this->request->getPost('no_rumah'),
            'nama_jalan' => $this->request->getPost('nama_jalan'),
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('status') == 'active' ? 1 : 0
        ];

        if (!empty($this->request->getPost('password'))) {
            $data['password'] = md5($this->request->getPost('password'));
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/warga')->with('message', 'Warga berhasil diupdate.');
    }

    // Menghapus data dari database berdasarkan ID
    public function delete($id = null)
    {
        if ($id) {
            $this->userModel->delete($id);
            return redirect()->to('/warga')->with('message', 'Warga berhasil dihapus.');
        }
        return redirect()->to('/warga');
    }

    // Fungsi approve
    public function approve($id = null)
    {
        if ($id) {
            $this->userModel->update($id, ['is_active' => 1]);
            return redirect()->back()->with('message', 'Pendaftar berhasil disetujui.');
        }
        return redirect()->back();
    }

    // Fungsi reject
    public function reject($id = null)
    {
        if ($id) {
            $user = $this->userModel->find($id);
            if ($user) {
                $alasan = $this->request->getPost('alasan') ?? 'Data tidak valid.';
                $no_hp = $user['no_telepon'];
                if (strpos($no_hp, '0') === 0) {
                    $no_hp = '62' . substr($no_hp, 1);
                }
                
                $pesan_wa = "Halo " . $user['nama'] . ",\n\nMohon maaf, pendaftaran akun Kas RT Anda *ditolak*.\n\n*Alasan:* " . $alasan;
                $link_wa = "https://wa.me/" . preg_replace('/[^0-9]/', '', $no_hp) . "?text=" . urlencode($pesan_wa);
                
                $this->userModel->delete($id);
                return redirect()->back()->with('message', 'Pendaftar berhasil ditolak dan dihapus. <a href="' . $link_wa . '" target="_blank" class="btn btn-sm btn-success ms-2">Kirim Penjelasan WA</a>');
            }
        }
        return redirect()->back();
    }
}
