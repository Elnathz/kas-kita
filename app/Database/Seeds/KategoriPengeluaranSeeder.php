<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriPengeluaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori'       => 'Kas',
                'deskripsi'  => 'Pengeluaran untuk keperluan kas operasional RT',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori'       => 'Sosial',
                'deskripsi'  => 'Pengeluaran untuk bantuan sosial warga',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori'       => 'Konsumsi',
                'deskripsi'  => 'Pengeluaran untuk acara dan pertemuan warga',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('kategori_pengeluaran')->insertBatch($data);
    }
}
