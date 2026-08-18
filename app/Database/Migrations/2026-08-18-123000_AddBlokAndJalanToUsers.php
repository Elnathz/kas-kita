<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBlokAndJalanToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'blok_rumah' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'role'
            ],
            'nama_jalan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'no_rumah'
            ],
        ];

        $this->forge->addColumn('users', $fields);

        // Backfill existing data
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $users = $builder->get()->getResult();

        foreach ($users as $user) {
            if (!empty($user->no_rumah) && strpos($user->no_rumah, '/') !== false) {
                $parts = explode('/', $user->no_rumah);
                $blokChar = trim($parts[0]);
                $noUrut = trim($parts[1]);
                
                $blokRumah = 'Blok ' . $blokChar;
                $noRumahClean = 'No. ' . $noUrut;
                // Assuming typical data based on create view
                $namaJalan = 'Jl. Mawar'; 

                $builder->where('id', $user->id)->update([
                    'blok_rumah' => $blokRumah,
                    'no_rumah' => $noRumahClean,
                    'nama_jalan' => $namaJalan
                ]);
            }
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'blok_rumah');
        $this->forge->dropColumn('users', 'nama_jalan');
    }
}
