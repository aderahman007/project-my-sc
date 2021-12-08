<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class PeristiwaKematianModel extends Model
{
    protected $table                = 'peristiwa_kematian';
    protected $primaryKey           = 'id_kematian';
    protected $allowedFields        = [
        'id_kematian',
        'id_penduduk',
        'tanggal_kematian',
        'tpu',
        'keterangan',
        'pencatat',
        'timestamp',
        'updated',
    ];

    // Dates
    protected $dateFormat           = 'date';

    protected $column_order = [null, 'nik', 'nama_lengkap', 'alamat', 'tanggal_kematian', 'tpu', null];
    protected $column_search = ['nik', 'nama_lengkap', 'alamat', 'tanggal_kematian', 'tpu'];
    protected $order = ['tanggal_kematian' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
    }
    
    private function getDatatablesQuery()
    {
        $this->dt = $this->db->table($this->table)->join('penduduk', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk');
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
