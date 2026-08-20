<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MetodePembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'jenis' => ['type' => 'VARCHAR', 'constraint' => 30],
            'nama_metode' => ['type' => 'VARCHAR', 'constraint' => 100],
            'nomor' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'atas_nama' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'detail' => ['type' => 'TEXT', 'null' => true],
            'gambar' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('metode_pembayaran');
    }

    public function down() { $this->forge->dropTable('metode_pembayaran'); }
}
