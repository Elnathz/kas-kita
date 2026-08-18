<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameNamaKategori extends Migration
{
    public function up()
    {
        $fields = [
            'nama' => [
                'name'       => 'nama_kategori',
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ];
        $this->forge->modifyColumn('kategori_pengeluaran', $fields);
    }

    public function down()
    {
        $fields = [
            'nama_kategori' => [
                'name'       => 'nama',
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ];
        $this->forge->modifyColumn('kategori_pengeluaran', $fields);
    }
}
