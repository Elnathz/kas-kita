<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PengeluaranController extends BaseController
{
    public function index()
    {
        return view('pengeluaran/index');
    }

    public function create()
    {
        return view('pengeluaran/create');
    }

    public function store()
    {
        return redirect()->to('/pengeluaran');
    }

    public function edit($id = 1)
    {
        return view('pengeluaran/edit', ['id' => $id]);
    }

    public function update($id = 1)
    {
        return redirect()->to('/pengeluaran');
    }

    public function delete($id = 1)
    {
        return redirect()->to('/pengeluaran');
    }
}
