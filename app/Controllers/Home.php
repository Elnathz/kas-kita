<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Menampilkan halaman daftar data utama
    public function index(): string
    {
        return view('welcome_message');
    }
}
