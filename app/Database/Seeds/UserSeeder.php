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
            'no_rumah'   => 'R/01',
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
            'no_rumah'   => 'R/02',
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
            'no_rumah'   => 'S/05',
            'no_telepon' => '08222222222',
            'alamat'     => 'Blok S / No. 05',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-6 months')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-6 months')),
        ];

        // 4. Generate 20 Warga Aktif Lainnya
        $blokList = ['R', 'S', 'T'];
        for ($i = 2; $i <= 21; $i++) {
            $blok = $faker->randomElement($blokList);
            $noRumah = str_pad($faker->numberBetween(1, 15), 2, '0', STR_PAD_LEFT);
            $data[] = [
                'nama'       => $faker->name,
                'username'   => 'warga' . $i,
                'password'   => password_hash('warga123', PASSWORD_DEFAULT),
                'role'       => 'warga',
                'no_rumah'   => $blok . '/' . $noRumah,
                'no_telepon' => $faker->phoneNumber,
                'alamat'     => "Blok {$blok} / No. {$noRumah}",
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . $faker->numberBetween(1, 12) . ' months')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // 5. Generate 3 Warga Pending (Belum disetujui / Pendaftar Baru)
        for ($i = 22; $i <= 24; $i++) {
            $blok = $faker->randomElement($blokList);
            $noRumah = str_pad($faker->numberBetween(1, 15), 2, '0', STR_PAD_LEFT);
            $data[] = [
                'nama'       => $faker->name,
                'username'   => 'warga' . $i,
                'password'   => password_hash('warga123', PASSWORD_DEFAULT),
                'role'       => 'warga',
                'no_rumah'   => $blok . '/' . $noRumah,
                'no_telepon' => $faker->phoneNumber,
                'alamat'     => "Blok {$blok} / No. {$noRumah}",
                'is_active'  => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . $faker->numberBetween(1, 5) . ' days')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('users')->insertBatch($data);
    }
}
