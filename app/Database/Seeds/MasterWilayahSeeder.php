<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterWilayahSeeder extends Seeder
{
    public function run()
    {
        $blokData = [
            ['nama_blok' => 'Blok R', 'maks_nomor' => 10],
            ['nama_blok' => 'Blok S', 'maks_nomor' => 15],
            ['nama_blok' => 'Blok T', 'maks_nomor' => 6],
        ];
        $this->db->table('master_blok')->insertBatch($blokData);

        $jalanData = [
            ['nama_jalan' => 'Jalan Anggada 1'],
            ['nama_jalan' => 'Jalan Anggada 2'],
            ['nama_jalan' => 'Jalan Anggada 3'],
        ];
        $this->db->table('master_jalan')->insertBatch($jalanData);
    }
}
