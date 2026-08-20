<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        $paymentDate = static function (int $month, int $day) use ($currentYear): string {
            return date('Y-m-d H:i:s', mktime(12, 0, 0, $month, $day, $currentYear));
        };

        // Pengurus (User 1 dan 2) lunas sampai bulan berjalan.
        for ($userId = 1; $userId <= 2; $userId++) {
            for ($month = 1; $month <= $currentMonth; $month++) {
                $data[] = $this->createPayment($userId, $month, $currentYear, 'terverifikasi', $paymentDate($month, 12));
            }
        }

        // Warga 3 (akun warga pertama): Januari-Mei terverifikasi,
        // Juni menunggu verifikasi, Juli dan Agustus belum membayar.
        for ($month = 1; $month <= min(5, $currentMonth); $month++) {
            $data[] = $this->createPayment(3, $month, $currentYear, 'terverifikasi', $paymentDate($month, 10));
        }
        if ($currentMonth >= 6) {
            $data[] = $this->createPayment(3, 6, $currentYear, 'pending', $paymentDate(6, 15), true);
        }

        // Warga 4 sampai 15 lunas sampai bulan berjalan.
        for ($userId = 4; $userId <= 15; $userId++) {
            for ($month = 1; $month <= $currentMonth; $month++) {
                $data[] = $this->createPayment($userId, $month, $currentYear, 'terverifikasi', $paymentDate($month, 12));
            }
        }

        // Warga 16 sampai 18 menunggak satu bulan.
        for ($userId = 16; $userId <= 18; $userId++) {
            for ($month = 1; $month <= max(0, $currentMonth - 1); $month++) {
                $data[] = $this->createPayment($userId, $month, $currentYear, 'terverifikasi', $paymentDate($month, 14));
            }
        }

        // Warga 19 sampai 21 menunggak tiga bulan agar status macet terlihat.
        for ($userId = 19; $userId <= 21; $userId++) {
            for ($month = 1; $month <= max(0, $currentMonth - 3); $month++) {
                $data[] = $this->createPayment($userId, $month, $currentYear, 'terverifikasi', $paymentDate($month, 10));
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
            'bukti_transfer' => 'assets/images/buktitf1.jpeg',
            'status'         => $status,
            'catatan'        => null,
            'verified_by'    => $isPending ? null : 1,
            'verified_at'    => $isPending ? null : $createdAt,
            'created_at'     => $createdAt,
        ];
    }
}
