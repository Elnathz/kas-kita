<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanSistemModel extends Model
{
    protected $table = 'pengaturan_sistem';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['kategori', 'kunci', 'nilai'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
