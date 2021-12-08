<?php

namespace App\Controllers;

use App\Models\PeristiwaKematianModel;

class PeristiwaKematian extends BaseController
{
    protected $pk;
    protected $db;
    protected $validation;
    public function __construct()
    {
        $this->pk = new PeristiwaKematianModel();
        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'judul' => 'Peristiwa Kematian',
            'aktif' => 'kematian',
            'show' => 'peristiwa',
            'swal' => 'Peristiwa Kematian',
            'kematian' => $this->pk->findAll(),
            'validation' => $this->validation,
            'actionTambah' => site_url('kematian/create'),
            'actionUpdate' => site_url('kematian/update'),
            'cencel' => site_url('kematian')
        ];

        return view('kematian/kematian_list', $data);
    }


    public function load()
    {

        $request = \Config\Services::request();
        $datatable = new PeristiwaKematianModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row   = [];
                $row[] = $no;
                $row[] = $list->nik;
                $row[] = $list->nama_lengkap;
                $row[] = date('d-m-Y', strtotime($list->tanggal_kematian));
                $row[] = $list->tpu;
                $row[] = '<a href="' . site_url('kematian/detail/') . param_encrypt($list->id_penduduk) . '" class="btn btn-info btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a data-toggle="modal" data-target="#kematianModal' . $list->id_kematian . '" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i><a onclick="hapus(' . $list->id_kematian . ')" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>';
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];
            echo json_encode($output);
        }
    }

    public function create()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $validasi = $this->validate([
            'nik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'tpu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'tanggal_kematian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di tambah');
            return redirect()->to('kematian')->withInput()->with('validation', $this->validation);
        }

        // $cek_data = $this->db->table('mutasi_kematian')->where('id_penduduk', $this->request->getVar('nik'))->get();

        $cek_data = $this->pk->where('id_penduduk', $this->request->getVar('nik'))->first();
        $cek_data2 = $this->db->table('mutasi_pindah')->getWhere(['id_penduduk' => $this->request->getVar('nik')])->getFirstRow('array');

        // dd($cek_data);die;
        if ($cek_data != null) {
            
            if ($cek_data['id_penduduk'] == $this->request->getVar('nik')) {
                session()->setFlashdata('error', 'nik ' . getnik($this->request->getVar('nik')) . ' sudah ada');

                return redirect()->to('kematian')->withInput()->with('validation', $this->validation);
            }
        } else if($cek_data2 != null){
            if ($cek_data2['id_penduduk'] == $this->request->getVar('nik')) {
                session()->setFlashdata('error', 'nik ' . getnik($this->request->getVar('nik')) . ' sudah ada pindah');

                return redirect()->to('kematian')->withInput()->with('validation', $this->validation);
            }
        }else {
            # code...

            $this->pk->save([
                'id_penduduk' => $this->request->getVar('nik'),
                'tanggal_kematian' => $this->request->getVar('tanggal_kematian'),
                'tpu' => $this->request->getVar('tpu'),
                'keterangan' => $this->request->getVar('keterangan'),
                'pencatat' => session()->get('id_user'),
                'timestamp' => date('Y-m-d H:i:s'),
            ]);


            session()->setFlashdata('pesan', 'di tambah');

            return redirect()->to('kematian');
        }
    }

    public function update()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        // dd($this->request->getVar());die;
        $validasi = $this->validate([
            'nik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'tpu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'tanggal_kematian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di update');
            return redirect()->to('kematian')->withInput()->with('validation', $this->validation);
        }

        $this->pk->save([
            'id_kematian' => $this->request->getVar('id_kematian'),
            'id_penduduk' => $this->request->getVar('nik'),
            'tanggal_kematian' => $this->request->getVar('tanggal_kematian'),
            'tpu' => $this->request->getVar('tpu'),
            'keterangan' => $this->request->getVar('keterangan'),
            'pencatat' => session()->get('id_user'),
            'updated'     => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('pesan', 'di update');

        return redirect()->to('kematian');
    }

    public function delete($id)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $this->pk->delete($id);
        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('kematian');
    }

    // Detail 
    public function detail($id_penduduk)
    {
        $penduduk = $this->db->table('penduduk')->select('*')->where('id_penduduk', param_decrypt($id_penduduk))->join('kartu_keluarga', 'kartu_keluarga.id_kk = penduduk.id_kk')->get()->getRow();


        $data = [
            'judul' => 'Detail Peristiwa Kematian',
            'aktif' => 'kematian',
            'show'  => 'peristiwa',
            'penduduk' => $penduduk,
            'kematian' => $this->pk->where('id_penduduk', param_decrypt($id_penduduk))->first(),
            'back'     => site_url('kematian'),
            'update'     => site_url('kematian/update/' . $id_penduduk), 
        ];

        return view('kematian/kematian_detail', $data);
    }

    public function search_nik()
    {
        if ($this->request->isAJAX()) {
            $caridata = $this->request->getVar('search');
            $penduduk = $this->db->table('penduduk')->LIKE('nik', $caridata)->get();

            if ($penduduk->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($penduduk->getResultArray() as $row) :
                    $list[$key]['id'] = $row['id_penduduk'];
                    $list[$key]['text'] = $row['nik'] . ' - ' . $row['nama_lengkap'];
                    $key++;
                endforeach;
                echo json_encode($list);
            }
        }
    }
}
