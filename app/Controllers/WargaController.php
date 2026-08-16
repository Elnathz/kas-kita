<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class WargaController extends BaseController
{
    public function index()
    {
        return view('warga/index');
    }

    public function create()
    {
        return view('warga/create');
    }

    public function store()
    {
        return redirect()->to('/warga');
    }

    public function edit($id = 1)
    {
        return view('warga/edit', ['id' => $id]);
    }

    public function update($id = 1)
    {
        return redirect()->to('/warga');
    }

    public function delete($id = 1)
    {
        return redirect()->to('/warga');
    }
}
