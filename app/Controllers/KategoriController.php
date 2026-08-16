<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class KategoriController extends BaseController
{
    public function index()
    {
        return view('kategori/index');
    }

    public function create()
    {
        return view('kategori/create');
    }

    public function store()
    {
        return redirect()->to('/kategori');
    }

    public function edit($id = 1)
    {
        return view('kategori/edit', ['id' => $id]);
    }

    public function update($id = 1)
    {
        return redirect()->to('/kategori');
    }

    public function delete($id = 1)
    {
        return redirect()->to('/kategori');
    }
}
