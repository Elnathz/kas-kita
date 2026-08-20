<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToPengaturanIuran extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('updated_at', 'pengaturan_iuran')) {
            $this->forge->addColumn('pengaturan_iuran', ['updated_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'created_at']]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('updated_at', 'pengaturan_iuran')) {
            $this->forge->dropColumn('pengaturan_iuran', 'updated_at');
        }
    }
}
