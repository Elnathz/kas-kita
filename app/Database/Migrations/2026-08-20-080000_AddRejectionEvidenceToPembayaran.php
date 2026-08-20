<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRejectionEvidenceToPembayaran extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('bukti_penolakan', 'pembayaran')) {
            $this->forge->addColumn('pembayaran', [
                'bukti_penolakan' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'bukti_transfer',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('bukti_penolakan', 'pembayaran')) {
            $this->forge->dropColumn('pembayaran', 'bukti_penolakan');
        }
    }
}
