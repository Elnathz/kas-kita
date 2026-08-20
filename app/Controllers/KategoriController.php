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

    // Menampilkan halaman daftar data utama
    public function index()
    {
        $kategori = $this->kategoriModel->orderBy('id', 'ASC')->findAll();
        return view('kategori/index', ['kategori' => $kategori]);
    }

    // Menampilkan form untuk menambah data baru
    public function create()
    {
        return view('kategori/create');
    }

    // Memproses penyimpanan data baru ke database
    public function store()
    {
        $nama = trim((string) $this->request->getPost('nama'));
        $rules = [
            'nama'      => 'required|min_length[2]|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->kategoriModel->where('nama_kategori', $nama)->first()) {
            return redirect()->back()->withInput()->with('errors', ['nama' => 'Nama kategori sudah digunakan.']);
        }

        $this->kategoriModel->insert([
            'nama_kategori' => $nama,
            'deskripsi'     => trim((string) $this->request->getPost('deskripsi'))
        ]);

        return redirect()->to('/kategori')->with('message', 'Kategori berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengubah data berdasarkan ID
    public function edit($id = null)
    {
        if (!$id) return redirect()->to('/kategori');

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) return redirect()->to('/kategori');

        return view('kategori/edit', ['kategori' => $kategori]);
    }

    // Memproses pembaruan data ke database
    public function update($id = null)
    {
        if (!$id || !$this->kategoriModel->find($id)) return redirect()->to('/kategori');

        $nama = trim((string) $this->request->getPost('nama'));

        $rules = [
            'nama'      => 'required|min_length[2]|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $duplikat = $this->kategoriModel->where('nama_kategori', $nama)->where('id !=', $id)->first();
        if ($duplikat) {
            return redirect()->back()->withInput()->with('errors', ['nama' => 'Nama kategori sudah digunakan.']);
        }

        $this->kategoriModel->update($id, [
            'nama_kategori' => $nama,
            'deskripsi'     => trim((string) $this->request->getPost('deskripsi'))
        ]);

        return redirect()->to('/kategori')->with('message', 'Kategori berhasil diperbarui.');
    }

    // Menghapus data dari database berdasarkan ID
    public function delete($id = null)
    {
        if (!$id || !$this->kategoriModel->find($id)) return redirect()->to('/kategori');

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
