<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJabatanToUsers extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('jabatan', 'users')) {
            $this->forge->addColumn('users', ['jabatan' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'role']]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('jabatan', 'users')) $this->forge->dropColumn('users', 'jabatan');
    }
}
