<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixPembayaranStatusLunasToTerverifikasi extends Migration
{
    public function up()
    {
        // Update semua status 'lunas' yang lama ke 'terverifikasi'
        $this->db->query("UPDATE pembayaran SET status = 'terverifikasi' WHERE status = 'lunas'");

        // Update status kosong yang memiliki verified_by (artinya sudah diverifikasi dulu)
        $this->db->query("UPDATE pembayaran SET status = 'terverifikasi' WHERE (status = '' OR status IS NULL) AND verified_by IS NOT NULL");

        // Update status kosong tanpa verified_by ke pending
        $this->db->query("UPDATE pembayaran SET status = 'pending' WHERE (status = '' OR status IS NULL) AND verified_by IS NULL");
    }

    public function down()
    {
        // Rollback: terverifikasi -> lunas
        $this->db->query("UPDATE pembayaran SET status = 'lunas' WHERE status = 'terverifikasi'");
    }
}
