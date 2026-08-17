<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriPengeluaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'       => 'Kas',
                'deskripsi'  => 'Pengeluaran untuk keperluan kas operasional RT',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Sosial',
                'deskripsi'  => 'Pengeluaran untuk bantuan sosial warga',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Konsumsi',
                'deskripsi'  => 'Pengeluaran untuk acara dan pertemuan warga',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('kategori_pengeluaran')->insertBatch($data);
    }
}
