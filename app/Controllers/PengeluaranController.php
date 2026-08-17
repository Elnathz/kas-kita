<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PengeluaranController extends BaseController
{
    public function index()
    {
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $pengeluaran = $pengeluaranModel->select('pengeluaran.*, kategori_pengeluaran.nama_kategori')
                                        ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id')
                                        ->orderBy('tanggal', 'DESC')
                                        ->findAll();
                                        
        $total_bulan_ini = 0;
        $bulan_ini = date('m');
        $tahun_ini = date('Y');
        
        foreach ($pengeluaran as $p) {
            if (date('m', strtotime($p['tanggal'])) == $bulan_ini && date('Y', strtotime($p['tanggal'])) == $tahun_ini) {
                $total_bulan_ini += $p['nominal'];
            }
        }

        return view('pengeluaran/index', [
            'pengeluaran' => $pengeluaran,
            'total_bulan_ini' => $total_bulan_ini
        ]);
    }

    public function create()
    {
        $kategoriModel = new \App\Models\KategoriPengeluaranModel();
        $kategori = $kategoriModel->findAll();
        
        return view('pengeluaran/create', ['kategori' => $kategori]);
    }

    public function store()
    {
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        
        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'created_by' => session()->get('id') ?? 1
        ];
        
        $pengeluaranModel->insert($data);
        return redirect()->to('/pengeluaran')->with('message', 'Data pengeluaran berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        if (!$id) return redirect()->to('/pengeluaran');
        
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $pengeluaran = $pengeluaranModel->find($id);
        
        if (!$pengeluaran) return redirect()->to('/pengeluaran');
        
        $kategoriModel = new \App\Models\KategoriPengeluaranModel();
        $kategori = $kategoriModel->findAll();

        return view('pengeluaran/edit', [
            'pengeluaran' => $pengeluaran,
            'kategori' => $kategori
        ]);
    }

    public function update($id = null)
    {
        if (!$id) return redirect()->to('/pengeluaran');
        
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        
        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
            'keterangan' => $this->request->getPost('keterangan')
        ];
        
        $pengeluaranModel->update($id, $data);
        return redirect()->to('/pengeluaran')->with('message', 'Data pengeluaran berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        if (!$id) return redirect()->to('/pengeluaran');
        
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $pengeluaranModel->delete($id);
        
        return redirect()->to('/pengeluaran')->with('message', 'Data pengeluaran berhasil dihapus.');
    }
}
