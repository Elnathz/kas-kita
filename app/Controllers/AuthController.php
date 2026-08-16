<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Hardcoded credentials untuk scope UTS
        // 1. Akun Pengurus RT (Admin)
        if ($username === 'admin' && md5($password) === md5('admin123')) {
            session()->set([
                'user_id'   => 1,
                'username'  => 'admin',
                'nama'      => 'Pengurus RT',
                'role'      => 'pengurus',
                'logged_in' => true,
            ]);

            return redirect()->to('/dashboard');
        }

        // 2. Akun Warga (Farros Rifantiarno)
        if (($username === 'farros' || $username === 'farros_r') && (md5($password) === md5('warga123') || md5($password) === md5('farros123') || md5($password) === md5('admin123'))) {
            session()->set([
                'user_id'   => 2,
                'username'  => 'farros_r',
                'nama'      => 'Farros Rifantiarno',
                'role'      => 'warga',
                'logged_in' => true,
            ]);

            return redirect()->to('/dashboard-warga');
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register');
    }

    public function prosesRegister()
    {
        // Pada UTS, dummy sukses registrasi
        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan dari pengurus RT.');
    }
}
