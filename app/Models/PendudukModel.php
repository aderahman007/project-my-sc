<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class PendudukModel extends Model
{
    protected $table                = 'penduduk';
    protected $primaryKey           = 'id_penduduk';
    protected $allowedFields        = [
        'id_kk',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama',
        'status_perkawinan',
        'hubungan_keluarga',
        'kewarganegaraan',
        'pendidikan',
        'jenis_pekerjaan',
        'no_paspor',
        'no_kitas_or_kitab',
        'nama_ayah',
        'nama_ibu',
        'pencatat',
        'doc_ktp',
        'timestamp',
        'updated',
    ];

    // Dates
    protected $dateFormat           = 'date';

    protected $column_order = [null, 'nik', 'nama_lengkap', 'alamat', 'jenis_kelamin'];
    protected $column_search = ['nik', 'nama_lengkap'];
    protected $order = ['nik' => 'ASC'];
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
        $this->dt = $this->db->table($this->table)->join('kartu_keluarga', 'kartu_keluarga.id_kk = penduduk.id_kk');
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
