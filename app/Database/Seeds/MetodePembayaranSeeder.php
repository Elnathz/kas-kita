<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $this->db->table('metode_pembayaran')->insertBatch([
            ['jenis' => 'bank', 'nama_metode' => 'Bank Central Asia (BCA)', 'nomor' => '8830-1234-5678', 'atas_nama' => 'Kas RT 06 RW 20 Kuripan', 'detail' => 'Transfer bank untuk pembayaran iuran kas RT.', 'gambar' => null, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['jenis' => 'qris', 'nama_metode' => 'QRIS Kas RT', 'nomor' => 'ID1024098234120', 'atas_nama' => 'KAS RT 06 RW 20 KURIPAN', 'detail' => 'Scan menggunakan mobile banking atau e-wallet.', 'gambar' => 'qris.jpeg', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
