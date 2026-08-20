<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToKategoriPengeluaran extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('updated_at', 'kategori_pengeluaran')) {
            $this->forge->addColumn('kategori_pengeluaran', [
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'created_at',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('updated_at', 'kategori_pengeluaran')) {
            $this->forge->dropColumn('kategori_pengeluaran', 'updated_at');
        }
    }
}
