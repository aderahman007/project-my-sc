<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class DomisiliModel extends Model
{
    protected $table                = 'domisili';
    protected $primaryKey           = 'id_penduduk';
    protected $useAutoIncrement     = false;
    protected $allowedFields        = [
        'id_penduduk',
        'alamat',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos'
    ];

    // Dates
    protected $dateFormat           = 'date';

}
