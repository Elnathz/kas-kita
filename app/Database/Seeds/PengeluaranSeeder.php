<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Bulan Agustus
            [
                'kategori_id' => 1, // Kas Operasional
                'keterangan'  => 'Pembelian lampu jalan & penerangan gang RT 03',
                'nominal'     => 350000.00,
                'tanggal'     => '2026-08-14',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'kategori_id' => 2, // Sosial
                'keterangan'  => 'Santunan warga sakit (Bpk. Mulyono)',
                'nominal'     => 500000.00,
                'tanggal'     => '2026-08-10',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'kategori_id' => 1, // Kas
                'keterangan'  => 'Kerja bakti & perbaikan saluran gang Mawar',
                'nominal'     => 750000.00,
                'tanggal'     => '2026-08-08',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'kategori_id' => 3, // Konsumsi
                'keterangan'  => 'Konsumsi rapat rutin RT',
                'nominal'     => 250000.00,
                'tanggal'     => '2026-08-05',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            
            // Bulan Juli
            [
                'kategori_id' => 1,
                'keterangan'  => 'Pengecatan dan perbaikan atap pos kamling',
                'nominal'     => 800000.00,
                'tanggal'     => '2026-07-20',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-1 months')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-1 months')),
            ],
            [
                'kategori_id' => 4, // Acara
                'keterangan'  => 'Persiapan Lomba 17-an (perlengkapan & umbul-umbul)',
                'nominal'     => 1200000.00,
                'tanggal'     => '2026-07-28',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-1 months')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-1 months')),
            ]
        ];

        $this->db->table('pengeluaran')->insertBatch($data);
    }
}
