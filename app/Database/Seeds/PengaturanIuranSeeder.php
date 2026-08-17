<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanIuranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nominal'      => 50000.00,
            'berlaku_dari' => '2026-01-01',
            'created_by'   => 1, // Budi Santoso (Pengurus)
            'created_at'   => date('Y-m-d H:i:s'),
        ];

        $this->db->table('pengaturan_iuran')->insert($data);
    }
}
