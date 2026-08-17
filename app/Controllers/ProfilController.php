<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfilController extends BaseController
{
    public function index()
    {
        return view('profil/index');
    }

    public function update()
    {
        // Dalam implementasi nyata (branch main), data disimpan ke DB.
        // Untuk mock-up UTS, redirect dengan pesan sukses.
        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui. Pengajuan perubahan alamat (jika ada) sedang menunggu persetujuan pengurus.');
    }

    public function updatePassword()
    {
        return redirect()->to('/profil')->with('success', 'Password berhasil diperbarui.');
    }
}
