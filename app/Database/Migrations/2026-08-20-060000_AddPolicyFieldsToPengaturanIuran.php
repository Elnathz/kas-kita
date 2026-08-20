<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPolicyFieldsToPengaturanIuran extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('tanggal_jatuh_tempo', 'pengaturan_iuran')) {
            $this->forge->addColumn('pengaturan_iuran', ['tanggal_jatuh_tempo' => ['type' => 'TINYINT', 'constraint' => 2, 'null' => true, 'after' => 'nominal']]);
        }
        if (!$this->db->fieldExists('is_active', 'pengaturan_iuran')) {
            $this->forge->addColumn('pengaturan_iuran', ['is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1, 'after' => 'toleransi_macet']]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('tanggal_jatuh_tempo', 'pengaturan_iuran')) $this->forge->dropColumn('pengaturan_iuran', 'tanggal_jatuh_tempo');
        if ($this->db->fieldExists('is_active', 'pengaturan_iuran')) $this->forge->dropColumn('pengaturan_iuran', 'is_active');
    }
}
