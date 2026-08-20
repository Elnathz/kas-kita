<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanIuranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nominal'      => 50000.00,
            'tanggal_jatuh_tempo' => 20,
            'berlaku_dari' => date('Y-01-01'),
            'toleransi_macet' => 2,
            'is_active'    => 1,
            'created_by'   => 1, // Budi Santoso (Pengurus)
            'created_at'   => date('Y-m-d H:i:s'),
        ];

        $this->db->table('pengaturan_iuran')->insert($data);
    }
}
