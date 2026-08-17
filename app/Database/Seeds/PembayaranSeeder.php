<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $currentMonth = 8; // Agustus
        $currentYear = 2026;

        // Warga 3 (Farros) - Lunas s/d Juli, Agustus menunggu verifikasi
        for ($m = 1; $m <= 7; $m++) {
            $data[] = $this->createPayment(3, $m, $currentYear, 'lunas', date('Y-m-d H:i:s', strtotime("2026-$m-10")));
        }
        $data[] = $this->createPayment(3, 8, $currentYear, 'pending', date('Y-m-d H:i:s', strtotime("2026-08-15")), true);

        // Warga 4 s/d 15 (Lancar) - Lunas s/d Agustus
        for ($userId = 4; $userId <= 15; $userId++) {
            for ($m = 1; $m <= 8; $m++) {
                $data[] = $this->createPayment($userId, $m, $currentYear, 'lunas', date('Y-m-d H:i:s', strtotime("2026-$m-12")));
            }
        }

        // Warga 16 s/d 18 (Nunggak 1 bulan) - Lunas s/d Juli
        for ($userId = 16; $userId <= 18; $userId++) {
            for ($m = 1; $m <= 7; $m++) {
                $data[] = $this->createPayment($userId, $m, $currentYear, 'lunas', date('Y-m-d H:i:s', strtotime("2026-$m-14")));
            }
        }

        // Warga 19 s/d 21 (Macet) - Lunas s/d Mei
        for ($userId = 19; $userId <= 21; $userId++) {
            for ($m = 1; $m <= 5; $m++) {
                $data[] = $this->createPayment($userId, $m, $currentYear, 'lunas', date('Y-m-d H:i:s', strtotime("2026-$m-10")));
            }
        }

        $this->db->table('pembayaran')->insertBatch($data);
    }

    private function createPayment($userId, $bulan, $tahun, $status, $createdAt, $isPending = false)
    {
        return [
            'user_id'        => $userId,
            'periode_bulan'  => $bulan,
            'periode_tahun'  => $tahun,
            'nominal'        => 50000.00,
            'bukti_transfer' => 'dummy_bukti.jpg',
            'status'         => $status,
            'catatan'        => null,
            'verified_by'    => $isPending ? null : 1, // Admin 1
            'verified_at'    => $isPending ? null : $createdAt,
            'created_at'     => $createdAt,
        ];
    }
}
