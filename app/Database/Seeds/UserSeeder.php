<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $data = [];

        // 1. Pengurus Utama (Budi)
        $data[] = [
            'nama'       => 'Budi Santoso (Ketua RT)',
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'pengurus',
            'jabatan'    => 'Ketua RT',
            'blok_rumah' => 'Blok R',
            'no_rumah'   => 'No. 01',
            'nama_jalan' => 'Jalan Anggada 1',
            'no_telepon' => '08111111111',
            'alamat'     => 'Blok R / No. 01',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 year')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1 year')),
        ];

        // 2. Pengurus Bendahara (Agus)
        $data[] = [
            'nama'       => 'Agus Hariyanto (Bendahara)',
            'username'   => 'bendahara',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'pengurus',
            'jabatan'    => 'Bendahara',
            'blok_rumah' => 'Blok R',
            'no_rumah'   => 'No. 02',
            'nama_jalan' => 'Jalan Anggada 2',
            'no_telepon' => '08111111112',
            'alamat'     => 'Blok R / No. 02',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 year')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1 year')),
        ];

        // 3. Warga Khusus Demo (Farros)
        $data[] = [
            'nama'       => 'Farros Rifantiarno',
            'username'   => 'warga1',
            'password'   => password_hash('farros123', PASSWORD_DEFAULT),
            'role'       => 'warga',
            'jabatan'    => null,
            'blok_rumah' => 'Blok S',
            'no_rumah'   => 'No. 05',
            'nama_jalan' => 'Jalan Anggada 3',
            'no_telepon' => '08222222222',
            'alamat'     => 'Blok S / No. 05',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-6 months')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-6 months')),
        ];

        // 4. Generate 20 Warga Aktif Lainnya
        $blokList = ['Blok R', 'Blok S', 'Blok T'];
        $jalanList = ['Jalan Anggada 1', 'Jalan Anggada 2', 'Jalan Anggada 3'];
        for ($i = 2; $i <= 21; $i++) {
            $blok = $faker->randomElement($blokList);
            $noRumah = 'No. ' . str_pad($faker->numberBetween(1, 15), 2, '0', STR_PAD_LEFT);
            $jalan = $faker->randomElement($jalanList);
            $data[] = [
                'nama'       => $faker->name,
                'username'   => 'warga' . $i,
                'password'   => password_hash('warga123', PASSWORD_DEFAULT),
                'role'       => 'warga',
                'jabatan'    => null,
                'blok_rumah' => $blok,
                'no_rumah'   => $noRumah,
                'nama_jalan' => $jalan,
                'no_telepon' => '0812' . str_pad((string) $i, 8, '0', STR_PAD_LEFT),
                'alamat'     => "{$blok} / {$noRumah}",
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . $faker->numberBetween(1, 12) . ' months')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // 5. Generate 3 Warga Pending (Belum disetujui / Pendaftar Baru)
        for ($i = 22; $i <= 24; $i++) {
            $blok = $faker->randomElement($blokList);
            $noRumah = 'No. ' . str_pad($faker->numberBetween(1, 15), 2, '0', STR_PAD_LEFT);
            $jalan = $faker->randomElement($jalanList);
            $data[] = [
                'nama'       => $faker->name,
                'username'   => 'warga' . $i,
                'password'   => password_hash('warga123', PASSWORD_DEFAULT),
                'role'       => 'warga',
                'jabatan'    => null,
                'blok_rumah' => $blok,
                'no_rumah'   => $noRumah,
                'nama_jalan' => $jalan,
                'no_telepon' => '0812' . str_pad((string) $i, 8, '0', STR_PAD_LEFT),
                'alamat'     => "{$blok} / {$noRumah}",
                'is_active'  => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . $faker->numberBetween(1, 5) . ' days')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('users')->insertBatch($data);
    }
}
