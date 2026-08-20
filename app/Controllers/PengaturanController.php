<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PengaturanController extends BaseController
{
    // Menampilkan pengaturan tarif iuran
    public function iuran()
    {
        $masterBlokModel = new \App\Models\MasterBlokModel();
        $masterJalanModel = new \App\Models\MasterJalanModel();
        $sistemModel = new \App\Models\PengaturanSistemModel();
        $userModel = new \App\Models\UserModel();
        $iuranModel = new \App\Models\PengaturanIuranModel();
        $metodeModel = new \App\Models\MetodePembayaranModel();
        $wilayah = [];
        foreach ($sistemModel->where('kategori', 'wilayah')->findAll() as $row) {
            $wilayah[$row['kunci']] = $row['nilai'];
        }
        $pengurus = $userModel->where('role', 'pengurus')->where('is_active', 1)->orderBy('nama', 'ASC')->findAll();
        $riwayatIuran = $iuranModel->orderBy('berlaku_dari', 'DESC')->findAll();
        $kebijakanAktif = \App\Libraries\IuranPeriodSummary::effectiveSetting($riwayatIuran);
        $tanggalHariIni = date('Y-m-d');
        foreach ($riwayatIuran as &$riwayat) {
            $pembuat = $userModel->find($riwayat['created_by'] ?? 0);
            $riwayat['created_by_nama'] = $pembuat['nama'] ?? 'Pengurus';
            if (($riwayat['berlaku_dari'] ?? '') > $tanggalHariIni) {
                $riwayat['status_label'] = 'Terjadwal';
            } elseif ($kebijakanAktif && (int) $riwayat['id'] === (int) $kebijakanAktif['id']) {
                $riwayat['status_label'] = 'Aktif';
            } else {
                $riwayat['status_label'] = 'Arsip';
            }
        }
        unset($riwayat);
        
        $data = [
            'master_blok' => $masterBlokModel->findAll(),
            'master_jalan' => $masterJalanModel->findAll(),
            'wilayah' => $wilayah,
            'pengurus' => $pengurus,
            'ketuaId' => $this->findOfficerId($pengurus, 'Ketua RT'),
            'bendaharaId' => $this->findOfficerId($pengurus, 'Bendahara'),
            'kebijakanAktif' => $kebijakanAktif,
            'riwayatIuran' => $riwayatIuran,
            'metodePembayaran' => $metodeModel->orderBy('is_active', 'DESC')->orderBy('id', 'ASC')->findAll(),
        ];
        
        return view('pengaturan/iuran', $data);
    }

    // Memproses pembaruan data tarif iuran
    public function updateIuran()
    {
        $sistemModel = new \App\Models\PengaturanSistemModel();
        $wilayahKeys = ['rt', 'rw', 'kelurahan', 'kecamatan', 'kota', 'provinsi'];
        foreach ($wilayahKeys as $key) {
            $nilai = trim((string) $this->request->getPost($key));
            if ($nilai === '') continue;
            $row = $sistemModel->where('kategori', 'wilayah')->where('kunci', $key)->first();
            if ($row) $sistemModel->update($row['id'], ['nilai' => $nilai]);
            else $sistemModel->insert(['kategori' => 'wilayah', 'kunci' => $key, 'nilai' => $nilai]);
        }

        if ($this->request->getPost('nominal') !== null) {
            $nominal = (int) $this->request->getPost('nominal');
            $tempo = (int) $this->request->getPost('tanggal_jatuh_tempo');
            $toleransi = (int) $this->request->getPost('toleransi_macet');
            $berlakuDari = (string) $this->request->getPost('berlaku_dari');
            if ($nominal < 1 || $tempo < 1 || $tempo > 28 || $toleransi < 1 || !$berlakuDari) {
                return redirect()->to('/pengaturan/iuran')->with('error', 'Kebijakan iuran tidak valid.');
            }
            $tanggalHariIni = date('Y-m-d');
            $tanggalEfektif = date('Y-m-d', strtotime($berlakuDari));
            $langsungBerlaku = $tanggalEfektif <= $tanggalHariIni;
            $db = \Config\Database::connect();
            if ($langsungBerlaku) {
                $db->table('pengaturan_iuran')->where('is_active', 1)->update(['is_active' => 0]);
            }
            (new \App\Models\PengaturanIuranModel())->insert([
                'nominal' => $nominal,
                'tanggal_jatuh_tempo' => $tempo,
                'toleransi_macet' => $toleransi,
                'berlaku_dari' => $berlakuDari,
                'is_active' => $langsungBerlaku ? 1 : 0,
                'created_by' => session()->get('id') ?? session()->get('user_id') ?? 1,
            ]);
            $pesan = $langsungBerlaku
                ? 'Kebijakan iuran berhasil disimpan.'
                : 'Kebijakan iuran dijadwalkan dan mulai berlaku pada ' . date('d-m-Y', strtotime($tanggalEfektif)) . '.';
            return redirect()->to('/pengaturan/iuran')->with('success', $pesan);
        }

        $ketuaId = (int) $this->request->getPost('ketua_id');
        $bendaharaId = (int) $this->request->getPost('bendahara_id');
        if ($ketuaId > 0 || $bendaharaId > 0) {
            if ($ketuaId > 0 && $ketuaId === $bendaharaId) {
                return redirect()->to('/pengaturan/iuran')->with('error', 'Ketua RT dan Bendahara harus dipilih dari dua akun yang berbeda.');
            }
            $db = \Config\Database::connect();
            $db->table('users')->where('role', 'pengurus')->update(['jabatan' => null]);
            if ($ketuaId > 0) $db->table('users')->where('id', $ketuaId)->where('role', 'pengurus')->update(['jabatan' => 'Ketua RT']);
            if ($bendaharaId > 0) $db->table('users')->where('id', $bendaharaId)->where('role', 'pengurus')->update(['jabatan' => 'Bendahara']);
        }

        return redirect()->to('/pengaturan/iuran')->with('success', 'Pengaturan wilayah berhasil diperbarui.');
    }

    // Menyimpan data metode pembayaran baru
    public function storeMetode()
    {
        $data = $this->validateMetode();
        if ($data === null) return redirect()->to('/pengaturan/iuran')->with('error', 'Data metode pembayaran belum lengkap.');
        (new \App\Models\MetodePembayaranModel())->insert($data);
        return redirect()->to('/pengaturan/iuran')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    // Menyimpan perubahan data metode pembayaran
    public function updateMetode($id = null)
    {
        $model = new \App\Models\MetodePembayaranModel();
        if (!$id || !$model->find($id)) return redirect()->to('/pengaturan/iuran')->with('error', 'Metode pembayaran tidak ditemukan.');
        $data = $this->validateMetode();
        if ($data === null) return redirect()->to('/pengaturan/iuran')->with('error', 'Data metode pembayaran belum lengkap.');
        $model->update($id, $data);
        return redirect()->to('/pengaturan/iuran')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    // Menghapus data metode pembayaran
    public function deleteMetode($id = null)
    {
        $model = new \App\Models\MetodePembayaranModel();
        if ($id && $model->find($id)) $model->delete($id);
        return redirect()->to('/pengaturan/iuran')->with('success', 'Metode pembayaran berhasil dihapus.');
    }

    private function validateMetode(): ?array
    {
        $jenis = trim((string) $this->request->getPost('jenis'));
        $nama = trim((string) $this->request->getPost('nama_metode'));
        if ($jenis === '' || $nama === '') return null;
        $data = [
            'jenis' => $jenis,
            'nama_metode' => $nama,
            'nomor' => trim((string) $this->request->getPost('nomor')),
            'atas_nama' => trim((string) $this->request->getPost('atas_nama')),
            'detail' => trim((string) $this->request->getPost('detail')),
            'is_active' => 1,
        ];
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!in_array(strtolower($file->getClientExtension()), ['jpg', 'jpeg', 'png', 'webp'], true) || $file->getSizeByUnit('mb') > 2) return null;
            $path = FCPATH . 'uploads/metode-pembayaran';
            if (!is_dir($path)) mkdir($path, 0775, true);
            $name = $file->getRandomName();
            $file->move($path, $name);
            $data['gambar'] = $name;
        }
        return $data;
    }

    private function findOfficerId(array $pengurus, string $jabatan): int
    {
        foreach ($pengurus as $person) {
            if (($person['jabatan'] ?? '') === $jabatan) return (int) $person['id'];
        }
        return 0;
    }

    // Menyimpan data nama jalan baru
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

    // Menyimpan data nama blok rumah baru
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

    // Menghapus data jalan dari sistem
    public function deleteJalan($id)
    {
        $jalanModel = new \App\Models\MasterJalanModel();
        $jalanModel->delete($id);
        return redirect()->to('/pengaturan/iuran')->with('success', 'Jalan berhasil dihapus.');
    }

    // Menghapus data blok rumah dari sistem
    public function deleteBlok($id)
    {
        $blokModel = new \App\Models\MasterBlokModel();
        $blokModel->delete($id);
        return redirect()->to('/pengaturan/iuran')->with('success', 'Blok berhasil dihapus.');
    }
}
