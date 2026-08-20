<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    // Menampilkan halaman daftar data utama
    public function index()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (session()->get('isLoggedIn')) {
            if (session()->get('role') === 'pengurus') {
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/dashboard-warga');
            }
        }

        return view('auth/login');
    }

    // Menampilkan halaman login pengguna
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            if ($user['is_active'] == 0) {
                return redirect()->back()->with('error', 'Akun Anda sedang menunggu persetujuan dari pengurus RT.');
            }

            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id'          => $user['id'],
                    'user_id'     => $user['id'],
                    'username'    => $user['username'],
                    'nama'        => $user['nama'],
                    'role'        => $user['role'],
                    'active_role' => $user['role'],
                    'isLoggedIn'  => true,
                ]);

                if ($user['role'] === 'pengurus') {
                    return redirect()->to('/dashboard');
                } else {
                    return redirect()->to('/dashboard-warga');
                }
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }

    // Memproses logout dan menghapus session pengguna
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Mengganti peran pengguna secara instan (mode testing)
    public function switchRole()
    {
        if (session()->get('role') === 'pengurus') {
            $currentActive = session()->get('active_role') ?? session()->get('role');
            if ($currentActive === 'pengurus') {
                session()->set('active_role', 'warga');
                return redirect()->to('/dashboard-warga');
            } else {
                session()->set('active_role', 'pengurus');
                return redirect()->to('/dashboard');
            }
        }
        return redirect()->back();
    }

    // Menampilkan form pendaftaran warga baru
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $masterBlokModel = new \App\Models\MasterBlokModel();
        $masterJalanModel = new \App\Models\MasterJalanModel();
        $sistemModel = new \App\Models\PengaturanSistemModel();
        $wilayah = [];
        foreach ($sistemModel->where('kategori', 'wilayah')->findAll() as $row) {
            $wilayah[$row['kunci']] = $row['nilai'];
        }

        $data = [
            'master_blok' => $masterBlokModel->findAll(),
            'master_jalan' => $masterJalanModel->findAll(),
            'wilayah' => $wilayah,
        ];

        return view('auth/register', $data);
    }

    // Memproses penyimpanan data registrasi warga
    public function prosesRegister()
    {
        $userModel = new UserModel();

        $data = [
            'nama'        => $this->request->getPost('nama'),
            'username'    => $this->request->getPost('username'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'        => 'warga',
            'active_role' => 'warga',
            'no_rumah'    => $this->request->getPost('no_rumah'),
            'no_telepon'  => $this->request->getPost('no_telepon'),
            'alamat'      => $this->request->getPost('alamat'),
            'is_active'   => 0, // Pending approval
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan dari pengurus RT.');
    }
}
