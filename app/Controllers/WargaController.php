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
                'warga' => []
            ];
        }

        foreach ($users as $user) {
            if (isset($dataWargaPerBlok[$user['blok_rumah']])) {
                $dataWargaPerBlok[$user['blok_rumah']]['warga'][] = $user;
                $totalWarga++;
            }
        }

        $data = [
            'dataWargaPerBlok' => $dataWargaPerBlok,
            'totalWarga' => $totalWarga
        ];

        return view('warga/index', $data);
    }

    public function create()
    {
        $masterJalanModel = new \App\Models\MasterJalanModel();
        
        $data = [
            'master_blok' => $this->masterBlokModel->findAll(),
            'master_jalan' => $masterJalanModel->findAll()
        ];
        return view('warga/create', $data);
    }

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

    public function delete($id = null)
    {
        if ($id) {
            $this->userModel->delete($id);
            return redirect()->to('/warga')->with('message', 'Warga berhasil dihapus.');
        }
        return redirect()->to('/warga');
    }
}
