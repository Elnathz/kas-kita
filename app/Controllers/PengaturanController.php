<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PengaturanController extends BaseController
{
    public function iuran()
    {
        $masterBlokModel = new \App\Models\MasterBlokModel();
        $masterJalanModel = new \App\Models\MasterJalanModel();
        
        $data = [
            'master_blok' => $masterBlokModel->findAll(),
            'master_jalan' => $masterJalanModel->findAll()
        ];
        
        return view('pengaturan/iuran', $data);
    }

    public function updateIuran()
    {
        // TODO: Nanti ini akan dihandle untuk tabel pengaturan utama.
        return redirect()->to('/pengaturan/iuran')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function addJalan()
    {
        $jalanModel = new \App\Models\MasterJalanModel();
        $namaJalan = $this->request->getPost('nama_jalan');
        
        if (!empty($namaJalan)) {
            $jalanModel->insert(['nama_jalan' => $namaJalan]);
            return redirect()->to('/pengaturan/iuran')->with('success', 'Jalan baru berhasil ditambahkan.');
        }
        return redirect()->to('/pengaturan/iuran')->with('error', 'Nama jalan tidak boleh kosong.');
    }

    public function addBlok()
    {
        $blokModel = new \App\Models\MasterBlokModel();
        $namaBlok = $this->request->getPost('nama_blok');
        $maksNomor = $this->request->getPost('maks_nomor');
        
        if (!empty($namaBlok) && !empty($maksNomor)) {
            $blokModel->insert([
                'nama_blok' => $namaBlok,
                'maks_nomor' => $maksNomor
            ]);
            return redirect()->to('/pengaturan/iuran')->with('success', 'Blok baru berhasil ditambahkan.');
        }
        return redirect()->to('/pengaturan/iuran')->with('error', 'Data blok tidak valid.');
    }

    public function deleteJalan($id)
    {
        $jalanModel = new \App\Models\MasterJalanModel();
        $jalanModel->delete($id);
        return redirect()->to('/pengaturan/iuran')->with('success', 'Jalan berhasil dihapus.');
    }

    public function deleteBlok($id)
    {
        $blokModel = new \App\Models\MasterBlokModel();
        $blokModel->delete($id);
        return redirect()->to('/pengaturan/iuran')->with('success', 'Blok berhasil dihapus.');
    }
}
