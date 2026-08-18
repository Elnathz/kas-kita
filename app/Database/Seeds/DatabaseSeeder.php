<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $tables = [
            'pengeluaran',
            'pembayaran',
            'pengaturan_iuran',
            'users',
            'kategori_pengeluaran',
            'master_wilayah',
        ];

        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($tables as $table) {
            if ($this->db->tableExists($table)) {
                $this->db->query('TRUNCATE TABLE `' . $table . '`');
            }
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $this->call('MasterWilayahSeeder');
        $this->call('UserSeeder');
        $this->call('PengaturanIuranSeeder');
        $this->call('KategoriPengeluaranSeeder');
        $this->call('PembayaranSeeder');
        $this->call('PengeluaranSeeder');
    }
}
