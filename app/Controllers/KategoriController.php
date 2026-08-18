<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriPengeluaranModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriPengeluaranModel();
    }

    public function index()
    {
        $kategori = $this->kategoriModel->orderBy('id', 'ASC')->findAll();
        return view('kategori/index', ['kategori' => $kategori]);
    }

    public function create()
    {
        return view('kategori/create');
    }

    public function store()
    {
        $rules = [
            'nama'      => 'required|min_length[2]|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->insert([
            'nama_kategori' => $this->request->getPost('nama'),
            'deskripsi'     => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/kategori')->with('message', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        if (!$id) return redirect()->to('/kategori');

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) return redirect()->to('/kategori');

        return view('kategori/edit', ['kategori' => $kategori]);
    }

    public function update($id = null)
    {
        if (!$id) return redirect()->to('/kategori');

        $rules = [
            'nama'      => 'required|min_length[2]|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama'),
            'deskripsi'     => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/kategori')->with('message', 'Kategori berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        if (!$id) return redirect()->to('/kategori');

        // Cek apakah kategori ini dipakai di pengeluaran
        $db    = \Config\Database::connect();
        $dipakai = $db->table('pengeluaran')->where('kategori_id', $id)->countAllResults();

        if ($dipakai > 0) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak bisa dihapus karena sudah digunakan di ' . $dipakai . ' data pengeluaran.');
        }

        $this->kategoriModel->delete($id);
        return redirect()->to('/kategori')->with('message', 'Kategori berhasil dihapus.');
    }
}
