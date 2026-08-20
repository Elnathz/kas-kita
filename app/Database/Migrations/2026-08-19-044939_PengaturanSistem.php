<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PengaturanSistem extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'kunci' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nilai' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kunci');
        $this->forge->createTable('pengaturan_sistem');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan_sistem');
    }
}
