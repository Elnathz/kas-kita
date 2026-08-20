<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfilController extends BaseController
{
    // Menampilkan halaman daftar data utama
    public function index()
    {
        return view('profil/index');
    }

    // Memproses pembaruan data ke database
    public function update()
    {
        // Dalam implementasi nyata (branch main), data disimpan ke DB.
        // Untuk mock-up UTS, redirect dengan pesan sukses.
        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui. Pengajuan perubahan alamat (jika ada) sedang menunggu persetujuan pengurus.');
    }

    // Memproses perubahan kata sandi pengguna
    public function updatePassword()
    {
        return redirect()->to('/profil')->with('success', 'Password berhasil diperbarui.');
    }
}
