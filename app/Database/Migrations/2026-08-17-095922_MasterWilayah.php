<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterWilayah extends Migration
{
    public function up()
    {
        // Tabel master_blok
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_blok' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'maks_nomor' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_blok');

        // Tabel master_jalan
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jalan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_jalan');
    }

    public function down()
    {
        $this->forge->dropTable('master_jalan');
        $this->forge->dropTable('master_blok');
    }
}
