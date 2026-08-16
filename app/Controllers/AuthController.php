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
        $validUsername = 'admin';
        $validPasswordHash = md5('admin123');

        if ($username === $validUsername && md5($password) === $validPasswordHash) {
            session()->set([
                'user_id'   => 1,
                'username'  => 'admin',
                'nama'      => 'Pengurus RT',
                'role'      => 'pengurus',
                'logged_in' => true,
            ]);

            return redirect()->to('/dashboard');
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
