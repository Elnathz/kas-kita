<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterJalanModel extends Model
{
    protected $table            = 'master_jalan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_jalan'];

    // Dates
    protected $useTimestamps = false;
}
