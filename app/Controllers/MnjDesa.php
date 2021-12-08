<?php

namespace App\Controllers;

use App\Models\MnjDesaModel;

class MnjDesa extends BaseController
{
    protected $md;
    protected $db;
    protected $validation;
    public function __construct()
    {
        helper(['my_function']);
        is_admin();
        $this->md = new MnjDesaModel();
        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    

    public function index()
    {
        $data = [
            'judul' => 'Manajement Desa',
            'judul_dusun' => 'Manajement Dusun',
            'judul_rw' => 'Manajement RW',
            'judul_rt' => 'Manajement RT',
            'aktif' => 'mnj_desa',
            'show' => 'manajement',
            'swal' => 'Manajement Desa',
            'swal_dusun' => 'Dusun',
            'swal_rw' => 'Data RW',
            'swal_rt' => 'Data RT',
            'mnj_desa' => $this->md->findAll(),
            'dusun' => $this->db->table('dusun')->get()->getResultArray(),
            'rw' => $this->db->table('rw')->get()->getResultArray(),
            'rt' => $this->db->table('rt')->get()->getResultArray(),
            'validation' => $this->validation,
            'actionTambahDusun' => site_url('mnj_desa/create_dusun'),
            'actionUpdateDusun' => site_url('mnj_desa/update_dusun'),
            'actionTambahRw' => site_url('mnj_desa/create_rw'),
            'actionUpdateRw' => site_url('mnj_desa/update_rw'),
            'actionTambahRt' => site_url('mnj_desa/create_rt'),
            'actionUpdateRt' => site_url('mnj_desa/update_rt'),
            'actionUpdate' => site_url('mnj_desa/update'),
            'cencel' => site_url('mnj_desa')
        ];

        return view('mnj_desa/mnj_desa_list', $data);
    }


    public function load()
    {

        $request = \Config\Services::request();
        $datatable = new MnJDesaModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row   = [];
                $row[] = $no;
                $row[] = $list->nama_desa;
                $row[] = getProvinsi($list->provinsi);
                $row[] = getKabupaten($list->kabupaten);
                $row[] = getKecamatan($list->kecamatan);
                $row[] = $list->kepala_desa;
                $row[] = '<a data-toggle="modal" data-target="#mnj_desa_detailModal' . $list->id . '" class="btn btn-info btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a data-toggle="modal" data-target="#mnj_desaModal' . $list->id . '" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i>';
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

    public function update()
    {
        $data_lama = $this->md->where(['id' => $this->request->getVar('id')])->first();
        // dd($this->request->getVar());die;
        $validasi = $this->validate([
            'nama_desa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'kabupaten' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'desa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'kepala_desa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'tentang_desa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'logo' => [
                'rules' => 'mime_in[logo,image/jpg,image/jpeg,image/gif,image/png]|max_size[logo,4096]',
                'errors' => [
                    'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
                    'max_size' => 'Ukuran File Maksimal 2 MB'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'no_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'link_fb' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'link_ig' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'link_twitter' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'link_youtube' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di update');
            return redirect()->to('mnj_desa')->withInput();
        }

        $logo = $this->request->getFile('logo');

        if (!$logo->isValid()) {
            $filename = $data_lama['logo'];
        } else {
            @unlink('images/desa' . '/' . $data_lama['logo']);
            $filename = $logo->getRandomName();
            $logo->move('images/desa', $filename);
        }

        $this->md->save([
            'id' => $this->request->getVar('id'),
            'nama_desa' => $this->request->getVar('nama_desa'),
            'alamat' => $this->request->getVar('alamat'),
            'provinsi' => $this->request->getVar('provinsi'),
            'kabupaten' => $this->request->getVar('kabupaten'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'desa' => $this->request->getVar('desa'),
            'logo' => $filename,
            'kepala_desa' => $this->request->getVar('kepala_desa'),
            'tentang_desa' => $this->request->getVar('tentang_desa'),
            'email' => $this->request->getVar('email'),
            'no_hp' => $this->request->getVar('no_hp'),
            'link_fb' => $this->request->getVar('link_fb'),
            'link_ig' => $this->request->getVar('link_ig'),
            'link_twitter' => $this->request->getVar('link_twitter'),
            'link_youtube' => $this->request->getVar('link_youtube'),
        ]);



        session()->setFlashdata('pesan', 'di update');

        return redirect()->to('mnj_desa');
    }


    // Detail 
    public function detail($id)
    {
        $mnj_desa = $this->md->where(['id' => $id])->first();

        $data = [
            'judul' => 'Detail Desa',
            'aktif' => 'mnj_desa',
            'show'  => 'manajement',
            'mnj_desa' => $mnj_desa,
            'back'     => site_url('mnj_desa'),
            'update'     => site_url('mnj_desa/update/') . $id
        ];

        return view('mnj_desa/mnj_desa_detail', $data);
    }


    public function create_rw(){
        $validasi = $this->validate([
            'no_rw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di tambah');
            return redirect()->to('mnj_desa')->withInput();
        }else {
            # code...

            $this->db->table('rw')->insert([
                'no_rw' => $this->request->getVar('no_rw'),
            ]);


            session()->setFlashdata('pesan', 'di tambah');

            return redirect()->to('mnj_desa');
        }
    }

    public function update_rw()
    {
        // dd($this->request->getVar());die;
        $validasi = $this->validate([
            'no_rw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di update');
            return redirect()->to('mnj_desa')->withInput();
        }

        $id_rw = $this->request->getVar('id_rw');

        $this->db->table('rw')->where('id_rw', $id_rw)->update([
            'no_rw' => $this->request->getVar('no_rw'),
        ]);

        session()->setFlashdata('pesan', 'di update');

        return redirect()->to('mnj_desa');
    }

    public function delete_rw($id_rw)
    {
        $this->db->table('rw')->where('id_rw', $id_rw)->delete();

        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('mnj_desa');
    }

    public function create_rt(){
        $validasi = $this->validate([
            'no_rt' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'id_rw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di tambah');
            return redirect()->to('mnj_desa')->withInput();
        }else {
            # code...

            $this->db->table('rt')->insert([
                'no_rt' => $this->request->getVar('no_rt'),
                'id_rw' => $this->request->getVar('id_rw'),
            ]);


            session()->setFlashdata('pesan', 'di tambah');

            return redirect()->to('mnj_desa');
        }
    }

    public function update_rt()
    {
        // dd($this->request->getVar());die;
        $validasi = $this->validate([
            'no_rt' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'id_rw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di update');
            return redirect()->to('mnj_desa')->withInput();
        }

        $id_rt = $this->request->getVar('id_rt');

        $this->db->table('rt')->where('id_rt', $id_rt)->update([
            'no_rt' => $this->request->getVar('no_rt'),
            'id_rw' => $this->request->getVar('id_rw'),
        ]);

        session()->setFlashdata('pesan', 'di update');

        return redirect()->to('mnj_desa');
    }

    public function delete_rt($id_rt)
    {
        $this->db->table('rt')->where('id_rt', $id_rt)->delete();

        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('mnj_desa');
    }

    public function create_dusun(){
        $validasi = $this->validate([
            'dusun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di tambah');
            return redirect()->to('mnj_desa')->withInput();
        }else {
            # code...

            $this->db->table('dusun')->insert([
                'dusun' => $this->request->getVar('dusun'),
                'id_rw' => $this->request->getVar('id_rw'),
            ]);


            session()->setFlashdata('pesan', 'di tambah');

            return redirect()->to('mnj_desa');
        }
    }

    public function update_dusun()
    {
        // dd($this->request->getVar());die;
        $validasi = $this->validate([
            'dusun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            
        ]);

        if (!$validasi) {
            session()->setFlashdata('error', 'di update');
            return redirect()->to('mnj_desa')->withInput();
        }

        $id_dusun = $this->request->getVar('id_dusun');

        $this->db->table('dusun')->where('id_dusun', $id_dusun)->update([
            'dusun' => $this->request->getVar('dusun'),
            'id_rw' => $this->request->getVar('id_rw'),
        ]);

        session()->setFlashdata('pesan', 'di update');

        return redirect()->to('mnj_desa');
    }

    public function delete_dusun($id_dusun)
    {
        $this->db->table('dusun')->where('id_dusun', $id_dusun)->delete();

        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('mnj_desa');
    }

    public function viewLogo($id)
    {
        $data['logo'] = $this->md->select('logo')->find($id);
        return view('mnj_desa/logo_view', $data);
    }

    public function search_provinsi()
    {

        if ($this->request->isAJAX()) {
            $caridata = $this->request->getVar('search');
            $provinsi = $this->db->table('wilayah_provinsi')->LIKE('nama', $caridata)->get();

            if ($provinsi->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($provinsi->getResultArray() as $row) :
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama'];
                    $key++;
                endforeach;
                echo json_encode($list);
            }
        }
    }

    public function search_kabupaten()
    {
        if ($this->request->isAJAX()) {
            $provinsi = $this->request->getVar('provinsi');

            $kabupaten = $this->db->table('wilayah_kabupaten')->where('provinsi_id', $provinsi)->get();
            $isidata = '<option value="">Input Kabupaten</option>';

            foreach ($kabupaten->getResultArray() as $row) :
                $isidata .= '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];

            echo json_encode($msg);
        }
    }

    public function search_kecamatan()
    {
        if ($this->request->isAJAX()) {
            $kabupaten = $this->request->getVar('kabupaten');

            $kecamatan = $this->db->table('wilayah_kecamatan')->where('kabupaten_id', $kabupaten)->get();
            $isidata = '<option value="">Input Kecamatan</option>';

            foreach ($kecamatan->getResultArray() as $row) :
                $isidata .= '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];

            echo json_encode($msg);
        }
    }

    public function search_desa()
    {
        if ($this->request->isAJAX()) {
            $kecamatan = $this->request->getVar('kecamatan');

            $desa = $this->db->table('wilayah_desa')->where('kecamatan_id', $kecamatan)->get();
            $isidata = '<option value="">Input Desa</option>';

            foreach ($desa->getResultArray() as $row) :
                $isidata .= '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];

            echo json_encode($msg);
        }
    }
}
