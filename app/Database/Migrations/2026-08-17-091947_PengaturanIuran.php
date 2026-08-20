<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PengaturanIuran extends Migration
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
            'nominal' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'tanggal_jatuh_tempo' => [
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => true,
            ],
            'berlaku_dari' => [
                'type' => 'DATE',
            ],
            'toleransi_macet' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 3,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengaturan_iuran');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan_iuran');
    }
}
