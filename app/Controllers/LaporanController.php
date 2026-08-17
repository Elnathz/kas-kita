<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LaporanController extends BaseController
{
    public function index()
    {
        return view('laporan/index');
    }

    public function warga()
    {
        return view('laporan/index');
    }
}
