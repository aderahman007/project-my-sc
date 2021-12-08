<?php

namespace App\Controllers;

use App\Models\MutasiPindahModel;

class MutasiPindah extends BaseController
{
    protected $mp;
    protected $db;
    protected $validation;
    public function __construct()
    {
        $this->mp = new MutasiPindahModel();
        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'judul' => 'Mutasi Pindah',
            'aktif' => 'mutasi_pindah',
            'show' => 'mutasi',
            'swal' => 'Mutasi Pindah',
            'pindah' => $this->mp->findAll(),
            'validation' => $this->validation,
            'actionTambah' => site_url('pindah/create'),
            'actionUpdate' => site_url('pindah/update'),
            'cencel' => site_url('pindah')
        ];

        return view('pindah/pindah_list', $data);
    }


    public function load()
    {

        $request = \Config\Services::request();
        $datatable = new MutasiPindahModel($request);

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
                $row[] = date('d-m-Y', strtotime($list->tanggal_pindah));
                $row[] = '<a href="' . site_url('pindah/detail/') . param_encrypt($list->id_penduduk) . '" class="btn btn-info btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a data-toggle="modal" data-target="#pindahModal' . $list->id_pindah . '" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i><a onclick="hapus(' . $list->id_pindah . ')" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>';
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
            'tanggal_pindah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di tambah');
            return redirect()->to('pindah')->withInput()->with('validation', $this->validation);
        }

        // $cek_data = $this->db->table('mutasi_pindah')->where('id_penduduk', $this->request->getVar('nik'))->get();

        $cek_data = $this->mp->where('id_penduduk', $this->request->getVar('nik'))->first();
        $cek_data2 = $this->db->table('peristiwa_kematian')->getWhere(['id_penduduk' => $this->request->getVar('nik')])->getFirstRow('array');

        // dd($cek_data);die;
        if ($cek_data != null) {
            
            if ($cek_data['id_penduduk'] == $this->request->getVar('nik')) {
                session()->setFlashdata('error', 'nik ' . getnik($this->request->getVar('nik')) . ' sudah ada');

                return redirect()->to('pindah')->withInput()->with('validation', $this->validation);
            }
        }else if ($cek_data2 != null) {
            if ($cek_data2['id_penduduk'] == $this->request->getVar('nik')) {
                session()->setFlashdata('error', 'nik ' . getnik($this->request->getVar('nik')) . ' sudah meninggal');

                return redirect()->to('pindah')->withInput()->with('validation', $this->validation);
            }
        } else {
            # code...

            $this->mp->save([
                'id_penduduk' => $this->request->getVar('nik'),
                'tanggal_pindah' => $this->request->getVar('tanggal_pindah'),
                'keterangan' => $this->request->getVar('keterangan'),
                'pencatat' => session()->get('id_user'),
                'timestamp'     => date('Y-m-d H:i:s'),
            ]);


            session()->setFlashdata('pesan', 'di tambah');

            return redirect()->to('pindah');
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
            'tanggal_pindah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di update');
            return redirect()->to('pindah')->withInput()->with('validation', $this->validation);
        }

        $this->mp->save([
            'id_pindah' => $this->request->getVar('id_pindah'),
            'id_penduduk' => $this->request->getVar('nik'),
            'tanggal_pindah' => $this->request->getVar('tanggal_pindah'),
            'keterangan' => $this->request->getVar('keterangan'),
            'pencatat' => session()->get('id_user'),
            'updated'     => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('pesan', 'di update');

        return redirect()->to('pindah');
    }

    public function delete($id)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $this->mp->delete($id);
        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('pindah');
    }

    // Detail 
    public function detail($id_penduduk)
    {
        $penduduk = $this->db->table('penduduk')->select('*')->where('id_penduduk', param_decrypt($id_penduduk))->join('kartu_keluarga', 'kartu_keluarga.id_kk = penduduk.id_kk')->get()->getRow();


        $data = [
            'judul' => 'Detail Mutasi Pindah',
            'aktif' => 'mutasi_pindah',
            'show'  => 'mutasi',
            'penduduk' => $penduduk,
            'pindah' => $this->mp->where('id_penduduk', param_decrypt($id_penduduk))->first(),
            'back'     => site_url('pindah'),
            'update'     => site_url('pindah/update/' . $id_penduduk) 
        ];

        return view('pindah/pindah_detail', $data);
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
