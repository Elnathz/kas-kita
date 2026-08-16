<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IuranController extends BaseController
{
    public function index()
    {
        return view('iuran/index');
    }

    public function tagihan()
    {
        return view('iuran/tagihan');
    }

    public function bayar()
    {
        return view('iuran/bayar');
    }

    public function prosesBayar()
    {
        return redirect()->to('/iuran/riwayat');
    }

    public function riwayat()
    {
        return view('iuran/riwayat');
    }

    public function verifikasi($id = 1)
    {
        return view('iuran/verifikasi', ['id' => $id]);
    }

    public function prosesVerifikasi($id = 1)
    {
        return redirect()->to('/iuran');
    }

    public function kuitansi($id = 1)
    {
        return view('iuran/kuitansi', ['id' => $id]);
    }
}
