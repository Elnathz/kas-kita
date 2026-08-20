<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        $bulanBerjalan = new \DateTimeImmutable('first day of this month');
        $bulanSebelumnya = $bulanBerjalan->modify('-1 month');
        $tanggalPeriode = static function (\DateTimeImmutable $periode, int $hari): string {
            return $periode->modify('+' . ($hari - 1) . ' days')->format('Y-m-d');
        };
        $sekarang = date('Y-m-d H:i:s');

        $data = [
            [
                'kategori_id' => 1,
                'keterangan'  => 'Pembelian lampu jalan dan penerangan gang RT 03',
                'nominal'     => 350000.00,
                'tanggal'     => $tanggalPeriode($bulanBerjalan, 14),
                'foto_nota'   => 'buktitf1.jpeg',
                'dokumentasi' => 'wargahorizontal.jpeg',
                'created_by'  => 1,
                'created_at'  => $sekarang,
                'updated_at'  => $sekarang,
            ],
            [
                'kategori_id' => 2,
                'keterangan'  => 'Santunan warga sakit',
                'nominal'     => 500000.00,
                'tanggal'     => $tanggalPeriode($bulanBerjalan, 10),
                'foto_nota'   => 'buktitf2.jpeg',
                'dokumentasi' => 'wargahorizontal.jpeg',
                'created_by'  => 1,
                'created_at'  => $sekarang,
                'updated_at'  => $sekarang,
            ],
            [
                'kategori_id' => 1,
                'keterangan'  => 'Kerja bakti dan perbaikan saluran gang Mawar',
                'nominal'     => 750000.00,
                'tanggal'     => $tanggalPeriode($bulanBerjalan, 8),
                'foto_nota'   => 'buktitf1.jpeg',
                'dokumentasi' => 'wargahorizontal.jpeg',
                'created_by'  => 1,
                'created_at'  => $sekarang,
                'updated_at'  => $sekarang,
            ],
            [
                'kategori_id' => 3,
                'keterangan'  => 'Konsumsi rapat rutin RT',
                'nominal'     => 250000.00,
                'tanggal'     => $tanggalPeriode($bulanBerjalan, 5),
                'foto_nota'   => 'buktitf2.jpeg',
                'dokumentasi' => 'wargahorizontal.jpeg',
                'created_by'  => 1,
                'created_at'  => $sekarang,
                'updated_at'  => $sekarang,
            ],
            [
                'kategori_id' => 1,
                'keterangan'  => 'Pengecatan dan perbaikan atap pos kamling',
                'nominal'     => 800000.00,
                'tanggal'     => $tanggalPeriode($bulanSebelumnya, 20),
                'foto_nota'   => 'buktitf1.jpeg',
                'dokumentasi' => 'wargahorizontal.jpeg',
                'created_by'  => 1,
                'created_at'  => $sekarang,
                'updated_at'  => $sekarang,
            ],
            [
                'kategori_id' => 3,
                'keterangan'  => 'Persiapan kegiatan warga',
                'nominal'     => 1200000.00,
                'tanggal'     => $tanggalPeriode($bulanSebelumnya, 28),
                'foto_nota'   => 'buktitf2.jpeg',
                'dokumentasi' => 'wargahorizontal.jpeg',
                'created_by'  => 1,
                'created_at'  => $sekarang,
                'updated_at'  => $sekarang,
            ],
        ];

        $this->db->table('pengeluaran')->truncate();
        $this->db->table('pengeluaran')->insertBatch($data);
    }
}