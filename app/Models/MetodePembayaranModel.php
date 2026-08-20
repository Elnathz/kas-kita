<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodePembayaranModel extends Model
{
    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['jenis', 'nama_metode', 'nomor', 'atas_nama', 'detail', 'gambar', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
