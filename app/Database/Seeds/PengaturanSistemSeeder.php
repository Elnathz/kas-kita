<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanSistemSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Wilayah
            ['kategori' => 'wilayah', 'kunci' => 'rt', 'nilai' => 'RT 06', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'wilayah', 'kunci' => 'rw', 'nilai' => 'RW 20', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'wilayah', 'kunci' => 'kelurahan', 'nilai' => 'Kuripan', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'wilayah', 'kunci' => 'kecamatan', 'nilai' => 'Purwodadi', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'wilayah', 'kunci' => 'kota', 'nilai' => 'Grobogan', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'wilayah', 'kunci' => 'provinsi', 'nilai' => 'Jawa Tengah', 'created_at' => date('Y-m-d H:i:s')],

            // Rekening Bank
            ['kategori' => 'pembayaran_bank', 'kunci' => 'bank_nama', 'nilai' => 'Bank Central Asia (BCA)', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'pembayaran_bank', 'kunci' => 'bank_rekening', 'nilai' => '8830-1234-5678', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'pembayaran_bank', 'kunci' => 'bank_atas_nama', 'nilai' => 'Kas RT 06 RW 20 Kuripan', 'created_at' => date('Y-m-d H:i:s')],

            // QRIS
            ['kategori' => 'pembayaran_qris', 'kunci' => 'qris_merchant', 'nilai' => 'KAS RT 06 RW 20 KURIPAN', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'pembayaran_qris', 'kunci' => 'qris_nmid', 'nilai' => 'ID1024098234120', 'created_at' => date('Y-m-d H:i:s')],
            ['kategori' => 'pembayaran_qris', 'kunci' => 'qris_image', 'nilai' => 'assets/img/qris.jpeg', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('pengaturan_sistem')->insertBatch($data);
    }
}
