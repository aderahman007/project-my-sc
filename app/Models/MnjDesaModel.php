<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MnJDesaModel extends Model
{
    protected $table                = 'mnj_desa';
    protected $primaryKey           = 'id';
    protected $allowedFields        = [
        'id',
        'nama_desa',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'logo',
        'kepala_desa',
        'tentang_desa',
        'email',
        'no_hp',
        'link_fb',
        'link_ig',
        'link_twitter',
        'link_youtube',
    ];

    // Dates
    protected $dateFormat           = 'date';

    protected $column_order = [null, 'nama_desa', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'kepala_desa', 'desa', 'kepala_desa', null];
    protected $column_search = ['nama_desa', 'provinsi', 'kepala_desa', 'desa'];
    protected $order = ['id' => 'DESC'];
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
        $this->dt = $this->db->table($this->table);
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
