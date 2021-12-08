<?php

namespace App\Models;

use CodeIgniter\Model;

class MutasiDatangModel extends Model
{
    protected $table                = 'mutasi_datang';
    protected $primaryKey           = 'id_datang';
    protected $allowedFields        = [
        'id_datang',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'alamat_domisili',
        'dusun_domisili',
        'rw_domisili',
        'rt_domisili',
        'tanggal_datang',
        'pencatat',
        'doc_ktp',
        'keterangan',
        'status',
        'event_status',
        'timestamp',
        'updated',
    ];

    // Dates
    protected $dateFormat           = 'date';

    protected $column_order = [null, 'nik', 'nama', 'alamat_domisili', 'tanggal_datang', 'doc_ktp'];
    protected $column_search = ['nik', 'nama', 'tanggal_datang', 'pencatat', 'alamat_domisili'];
    protected $order = ['tanggal_datang' => 'DESC'];
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
        $this->dt = $this->db->table($this->table)->join('pendatang', 'mutasi_datang.id_datang = pendatang.id_datang');
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
