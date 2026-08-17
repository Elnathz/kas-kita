<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('MasterWilayahSeeder');
        $this->call('UserSeeder');
        $this->call('PengaturanIuranSeeder');
        $this->call('KategoriPengeluaranSeeder');
        $this->call('PembayaranSeeder');
        $this->call('PengeluaranSeeder');
    }
}
