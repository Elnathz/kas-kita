<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PengaturanController extends BaseController
{
    public function iuran()
    {
        return view('pengaturan/iuran');
    }

    public function updateIuran()
    {
        return redirect()->to('/pengaturan/iuran');
    }
}
