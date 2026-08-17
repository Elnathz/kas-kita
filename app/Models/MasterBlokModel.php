<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterBlokModel extends Model
{
    protected $table            = 'master_blok';
    protected $primaryKey       = 'id'; 
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_blok', 'maks_nomor'];

    // Dates
    protected $useTimestamps = false;
}
