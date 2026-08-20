<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriPengeluaranModel;
use App\Models\PengeluaranModel;

class PengeluaranController extends BaseController
{
    // Menampilkan halaman daftar data utama
    public function index()
    {
        $pengeluaranModel = new PengeluaranModel();
        $jenisPeriode = (string) ($this->request->getGet('jenis_periode') ?? 'bulanan');
        if (!in_array($jenisPeriode, ['bulanan', 'tahunan', 'semua'], true)) {
            $jenisPeriode = 'bulanan';
        }
        $bulan = (int) ($this->request->getGet('bulan') ?? date('n'));
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));
        $bulan = $bulan >= 1 && $bulan <= 12 ? $bulan : (int) date('n');
        $tahun = $tahun >= 2000 && $tahun <= 2100 ? $tahun : (int) date('Y');

        $query = $pengeluaranModel->select('pengeluaran.*, kategori_pengeluaran.nama_kategori')
                                  ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id');
        if ($jenisPeriode === 'bulanan') {
            $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        } elseif ($jenisPeriode === 'tahunan') {
            $query->where('YEAR(tanggal)', $tahun);
        }
        $pengeluaran = $query->orderBy('tanggal', 'DESC')->findAll();
        $totalTerfilter = array_sum(array_map(static fn (array $item): float => (float) $item['nominal'], $pengeluaran));

        $tahunData = $pengeluaranModel->select('YEAR(tanggal) AS tahun')->distinct()->orderBy('tahun', 'DESC')->findAll();
        $tahunOptions = array_values(array_unique(array_map(static fn (array $item): int => (int) $item['tahun'], $tahunData)));
        if (!in_array((int) date('Y'), $tahunOptions, true)) {
            $tahunOptions[] = (int) date('Y');
        }
        rsort($tahunOptions);

        return view('pengeluaran/index', [
            'pengeluaran' => $pengeluaran,
            'totalTerfilter' => $totalTerfilter,
            'jenisPeriode' => $jenisPeriode,
            'bulanTerpilih' => $bulan,
            'tahunTerpilih' => $tahun,
            'tahunOptions' => $tahunOptions,
        ]);
    }

    // Menampilkan form untuk menambah data baru
    public function create()
    {
        $kategoriModel = new KategoriPengeluaranModel();
        $kategori = $kategoriModel->findAll();
        
        return view('pengeluaran/create', ['kategori' => $kategori]);
    }

    // Memproses penyimpanan data baru ke database
    public function store()
    {
        $data = $this->validatedExpenseData();
        if ($data === null) return redirect()->back()->withInput();

        $uploads = $this->processUploads();
        if ($uploads === false) return redirect()->back()->withInput();

        $pengeluaranModel = new PengeluaranModel();
        $pengeluaranModel->insert(array_merge($data, $uploads, [
            'created_by' => session()->get('id') ?? session()->get('user_id') ?? 1,
        ]));
        return redirect()->to('/pengeluaran')->with('message', 'Data pengeluaran berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengubah data berdasarkan ID
    public function edit($id = null)
    {
        if (!$id) return redirect()->to('/pengeluaran');
        
        $pengeluaranModel = new PengeluaranModel();
        $pengeluaran = $pengeluaranModel->find($id);
        
        if (!$pengeluaran) return redirect()->to('/pengeluaran');
        
        $kategoriModel = new KategoriPengeluaranModel();
        $kategori = $kategoriModel->findAll();

        return view('pengeluaran/edit', [
            'pengeluaran' => $pengeluaran,
            'kategori' => $kategori
        ]);
    }

    // Memproses pembaruan data ke database
    public function update($id = null)
    {
        $pengeluaranModel = new PengeluaranModel();
        if (!$id || !$pengeluaranModel->find($id)) return redirect()->to('/pengeluaran');

        $data = $this->validatedExpenseData();
        if ($data === null) return redirect()->back()->withInput();

        $uploads = $this->processUploads();
        if ($uploads === false) return redirect()->back()->withInput();
        $pengeluaranModel->update($id, array_merge($data, $uploads));
        return redirect()->to('/pengeluaran')->with('message', 'Data pengeluaran berhasil diperbarui.');
    }

    // Menghapus data dari database berdasarkan ID
    public function delete($id = null)
    {
        if (!$id) return redirect()->to('/pengeluaran');
        
        $pengeluaranModel = new PengeluaranModel();
        $pengeluaranModel->delete($id);
        
        return redirect()->to('/pengeluaran')->with('message', 'Data pengeluaran berhasil dihapus.');
    }

    private function validatedExpenseData(): ?array
    {
        $rules = [
            'kategori_id' => 'required|is_natural_no_zero',
            'tanggal' => 'required|valid_date[Y-m-d]',
            'nominal' => 'required|numeric|greater_than[0]',
            'keterangan' => 'required|min_length[3]|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return null;
        }

        $kategoriModel = new KategoriPengeluaranModel();
        if (!$kategoriModel->find($this->request->getPost('kategori_id'))) {
            session()->setFlashdata('errors', ['kategori_id' => 'Kategori pengeluaran tidak ditemukan.']);
            return null;
        }

        $tanggal = (string) $this->request->getPost('tanggal');
        if ($tanggal > date('Y-m-d')) {
            session()->setFlashdata('errors', ['tanggal' => 'Tanggal pengeluaran tidak boleh melebihi hari ini.']);
            return null;
        }

        return [
            'kategori_id' => (int) $this->request->getPost('kategori_id'),
            'tanggal' => $tanggal,
            'nominal' => (float) $this->request->getPost('nominal'),
            'keterangan' => trim((string) $this->request->getPost('keterangan')),
        ];
    }

    private function processUploads(): array|false
    {
        $data = [];
        $uploadPath = FCPATH . 'uploads/pengeluaran';
        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
            session()->setFlashdata('errors', ['file' => 'Folder penyimpanan lampiran tidak dapat dibuat.']);
            return false;
        }

        foreach (['bukti_nota' => 'foto_nota', 'foto_kegiatan' => 'dokumentasi'] as $input => $field) {
            $file = $this->request->getFile($input);
            if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) continue;
            if (!$file->isValid() || $file->hasMoved()) {
                session()->setFlashdata('errors', ['file' => 'Lampiran tidak dapat diproses.']);
                return false;
            }
            if ($file->getSizeByUnit('mb') > 2 || !in_array(strtolower($file->getClientExtension()), ['jpg', 'jpeg', 'png', 'pdf'], true)) {
                session()->setFlashdata('errors', ['file' => 'Lampiran harus berupa JPG, PNG, atau PDF dengan ukuran maksimal 2 MB.']);
                return false;
            }
            $name = $file->getRandomName();
            $file->move($uploadPath, $name);
            $data[$field] = $name;
        }

        return $data;
    }
}
