<?php

namespace App\Controllers;

use App\Models\PeristiwaLahirModel;

class PeristiwaLahir extends BaseController
{
    protected $pl;
    protected $db;
    protected $validation;
    public function __construct()
    {
        $this->pl = new PeristiwaLahirModel();
        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'judul' => 'Peristiwa Lahir',
            'aktif' => 'kelahiran',
            'show' => 'peristiwa',
            'swal' => 'Peristiwa Lahir',
        ];

        return view('lahir/lahir_list', $data);
    }

    public function load()
    {
        $request = \Config\Services::request();
        $datatable = new PeristiwaLahirModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama;
                $row[] = $list->hari_lahir . ', ' . date('d-m-Y', strtotime($list->tanggal_lahir));
                $row[] = $list->jenis_kelamin;
                $row[] = $list->nama_ayah;
                $row[] = $list->nama_ibu;
                $row[] = '<a href="' . site_url('lahir/detail/') . param_encrypt($list->id_lahir) . '" class="btn btn-info btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a href="' . site_url('lahir/update/') .  param_encrypt($list->id_lahir) . '" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a><a onclick="hapus(' . $list->id_lahir . ')" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>';
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            // print_r($output);die;
            echo json_encode($output);
        }
    }

    public function create()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        if ($this->request->getMethod() == "get") {
            # code...
            $data = [
                'judul'             => 'Peristiwa Lahir',
                'aktif'             => 'kelahiran',
                'show'              => 'peristiwa',
                'swal'              => 'Peristiwa Lahir',
                'id_lahir'          => set_value('id_lahir'),
                'nama'              => set_value('nama'),
                'tempat_lahir'      => set_value('tempat_lahir'),
                'hari_lahir'        => set_value('hari_lahir'),
                'tanggal_lahir'     => set_value('tanggal_lahir'),
                'jenis_kelamin'     => set_value('jenis_kelamin'),
                'alamat_lahir'            => set_value('alamat_lahir'),
                'nama_ayah'         => set_value('nama_ayah'),
                'nama_ibu'          => set_value('nama_ibu'),
                'alamat_ortu'       => set_value('alamat_ortu'),
                'dusun_ortu'       => set_value('dusun_ortu'),
                'rw_ortu'       => set_value('rw_ortu'),
                'rt_ortu'       => set_value('rt_ortu'),
                'keterangan'        => set_value('keterangan'),
                'doc_akte'        => set_value('doc_akte'),
                'validation'        => $this->validation,
                'uri' => service('uri'),
                'o_dusun' => $this->db->table('dusun')->get()->getResultArray(),
                'o_rw' => $this->db->table('rw')->get()->getResultArray(),
                'o_rt' => $this->db->table('rt')->get()->getResultArray(),
                'action'            => site_url('lahir/create'),
                'cencel'            => site_url('lahir')
            ];

            return view('lahir/lahir_form', $data);
        } else {
            // dd($this->request->getVar());die;
            $validasi = $this->validate([
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempat Lahir harus di isi'
                    ]
                ],
                'hari_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari Lahir harus di isi'
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Lahir harus di isi'
                    ]
                ],
                'alamat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'nama_ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama ayah harus di isi',
                    ]
                ],
                'nama_ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama ibu harus di isi',
                    ]
                ],
                'alamat_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat orang tua harus di isi',
                    ]
                ],
                'dusun_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi',
                    ]
                ],
                'rw_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'RW harus di isi',
                    ]
                ],
                'rt_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'RT harus di isi',
                    ]
                ],
                'doc_akte' => [
                    'rules' => 'mime_in[doc_akte,image/jpg,image/jpeg,image/png]|max_size[doc_akte,4096]',
                    'errors' => [
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],

            ]);

            if (!$validasi) {
                return redirect()->to('lahir/create')->withInput();
            }

            $doc_akte     = $this->request->getFile('doc_akte');
            $filename   = $doc_akte->getRandomName();

            if (!$doc_akte->isValid()) {
                # code...
                $this->pl->save([
                    'nama'              => $this->request->getVar('nama'),
                    'tempat_lahir'      => $this->request->getVar('tempat_lahir'),
                    'hari_lahir'     => $this->request->getVar('hari_lahir'),
                    'tanggal_lahir'     => $this->request->getVar('tanggal_lahir'),
                    'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                    'alamat_lahir'   => $this->request->getVar('alamat_lahir'),
                    'nama_ayah'    => $this->request->getVar('nama_ayah'),
                    'nama_ibu'    => $this->request->getVar('nama_ibu'),
                    'alamat_ortu'    => $this->request->getVar('alamat_ortu'),
                    'dusun_ortu'    => $this->request->getVar('dusun_ortu'),
                    'rw_ortu'    => $this->request->getVar('rw_ortu'),
                    'rt_ortu'    => $this->request->getVar('rt_ortu'),
                    'keterangan'    => $this->request->getVar('keterangan'),
                    'pencatat'          => session()->get('id_user'),
                    'timestamp'     => date('Y-m-d H:i:s'),
                ]);
    
                session()->setFlashdata('pesan', 'di tambah');
                return redirect()->to('lahir');
            }else {
                $this->pl->save([
                    'nama'              => $this->request->getVar('nama'),
                    'tempat_lahir'      => $this->request->getVar('tempat_lahir'),
                    'hari_lahir'     => $this->request->getVar('hari_lahir'),
                    'tanggal_lahir'     => $this->request->getVar('tanggal_lahir'),
                    'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                    'alamat_lahir'   => $this->request->getVar('alamat_lahir'),
                    'nama_ayah'    => $this->request->getVar('nama_ayah'),
                    'nama_ibu'    => $this->request->getVar('nama_ibu'),
                    'alamat_ortu'    => $this->request->getVar('alamat_ortu'),
                    'dusun_ortu'    => $this->request->getVar('dusun_ortu'),
                    'rw_ortu'    => $this->request->getVar('rw_ortu'),
                    'rt_ortu'    => $this->request->getVar('rt_ortu'),
                    'keterangan'    => $this->request->getVar('keterangan'),
                    'pencatat'          => session()->get('id_user'),
                    'doc_akte'          => $filename,
                    'timestamp'     => date('Y-m-d H:i:s'),
                ]);

                $doc_akte->move('images/akte', $filename);

                session()->setFlashdata('pesan', 'di tambah');
                return redirect()->to('lahir');
            }

        }
    }

    public function update($id_lahir)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $lahir = $this->pl->where('id_lahir', param_decrypt($id_lahir))->first();

        if ($this->request->getMethod() == 'get') {

            // dd($lahir);die;

            $data = [
                'judul' => 'Peristiwa Lahir',
                'aktif' => 'kelahiran',
                'show' => 'peristiwa',
                'swal' => 'Peristiwa Lahir',
                'id_lahir'         => set_value('id_lahir', $lahir['id_lahir']),
                'nama'              => set_value('nama', $lahir['nama']),
                'tempat_lahir'      => set_value('tempat_lahir', $lahir['tempat_lahir']),
                'hari_lahir'     => set_value('hari_lahir', $lahir['hari_lahir']),
                'tanggal_lahir'     => set_value('tanggal_lahir', $lahir['tanggal_lahir']),
                'jenis_kelamin'     => set_value('jenis_kelamin', $lahir['jenis_kelamin']),
                'alamat_lahir'     => set_value('alamat_lahir', $lahir['alamat_lahir']),
                'nama_ayah'    => set_value('nama_ayah', $lahir['nama_ayah']),
                'nama_ibu' => set_value('nama_ibu', $lahir['nama_ibu']),
                'alamat_ortu'   => set_value('alamat_ortu', $lahir['alamat_ortu']),
                'dusun_ortu'   => set_value('dusun_ortu', $lahir['dusun_ortu']),
                'rw_ortu'   => set_value('rw_ortu', $lahir['rw_ortu']),
                'rt_ortu'   => set_value('rt_ortu', $lahir['rt_ortu']),
                'keterangan'        => set_value('keterangan', $lahir['keterangan']),
                'doc_akte'        => set_value('doc_akte', $lahir['doc_akte']),
                'validation'        => $this->validation,
                'uri' => service('uri'),
                'o_dusun' => $this->db->table('dusun')->get()->getResultArray(),
                'o_rw' => $this->db->table('rw')->get()->getResultArray(),
                'o_rt' => $this->db->table('rt')->get()->getResultArray(),
                'action'            => site_url('lahir/update/' . $id_lahir),
                'cencel'            => site_url('lahir')
            ];

            return view('lahir/lahir_form', $data);
        } else {
            $validasi = $this->validate([
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempat Lahir harus di isi'
                    ]
                ],
                'hari_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari Lahir harus di isi'
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Lahir harus di isi'
                    ]
                ],
                'alamat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'dusun_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi',
                    ]
                ],
                'rw_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'RW harus di isi',
                    ]
                ],
                'rt_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'RT harus di isi',
                    ]
                ],
                'nama_ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama ayah harus di isi',
                    ]
                ],
                'nama_ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama ibu harus di isi',
                    ]
                ],
                'alamat_ortu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat orang tua harus di isi',
                    ]
                ],
                'doc_akte' => [
                    'rules' => 'mime_in[doc_akte,image/jpg,image/jpeg,image/png]|max_size[doc_akte,4096]',
                    'errors' => [
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);

            if (!$validasi) {
                return redirect()->back()->withInput();
            }

            $doc_akte     = $this->request->getFile('doc_akte');
            $filename   = $doc_akte->getRandomName();

            if (!$doc_akte->isValid()) {
                
                # code...
                $this->pl->save([
                    'id_lahir'         => param_decrypt($this->request->getVar('id_lahir')),
                    'nama'              => $this->request->getVar('nama'),
                    'tempat_lahir'      => $this->request->getVar('tempat_lahir'),
                    'hari_lahir'      => $this->request->getVar('hari_lahir'),
                    'tanggal_lahir'     => $this->request->getVar('tanggal_lahir'),
                    'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                    'alamat_lahir'     => $this->request->getVar('alamat_lahir'),
                    'nama_ayah'    => $this->request->getVar('nama_ayah'),
                    'nama_ibu' => $this->request->getVar('nama_ibu'),
                    'alamat_ortu'   => $this->request->getVar('alamat_ortu'),
                    'dusun_ortu'   => $this->request->getVar('dusun_ortu'),
                    'rw_ortu'   => $this->request->getVar('rw_ortu'),
                    'rt_ortu'   => $this->request->getVar('rt_ortu'),
                    'keterangan'        => $this->request->getVar('keterangan'),
                    'pencatat'          => session()->get('id_user'),
                    'updated'     => date('Y-m-d H:i:s'),
                ]);
    
                session()->setFlashdata('pesan', 'di ubah');
                return redirect()->to('lahir');
            }else {
                @unlink('images/akte' . '/' . $lahir['doc_akte']); 
                $this->pl->save([
                    'id_lahir'         => param_decrypt($this->request->getVar('id_lahir')),
                    'nama'              => $this->request->getVar('nama'),
                    'tempat_lahir'      => $this->request->getVar('tempat_lahir'),
                    'hari_lahir'      => $this->request->getVar('hari_lahir'),
                    'tanggal_lahir'     => $this->request->getVar('tanggal_lahir'),
                    'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                    'alamat_lahir'     => $this->request->getVar('alamat_lahir'),
                    'nama_ayah'    => $this->request->getVar('nama_ayah'),
                    'nama_ibu' => $this->request->getVar('nama_ibu'),
                    'alamat_ortu'   => $this->request->getVar('alamat_ortu'),
                    'dusun_ortu'   => $this->request->getVar('dusun_ortu'),
                    'rw_ortu'   => $this->request->getVar('rw_ortu'),
                    'rt_ortu'   => $this->request->getVar('rt_ortu'),
                    'keterangan'        => $this->request->getVar('keterangan'),
                    'doc_akte'        => $filename,
                    'pencatat'          => session()->get('id_user'),
                    'updated'     => date('Y-m-d H:i:s'),
                ]);

                $doc_akte->move('images/akte', $filename);

                session()->setFlashdata('pesan', 'di ubah');
                return redirect()->to('lahir');
            }

        }
    }

    public function delete($id)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $lahir = $this->pl->where('id_lahir', $id)->first();
        @unlink('images/akte' . '/' . $lahir['doc_akte']); 
        $this->pl->delete($id);
        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('lahir');
    }

    public function detail($id_lahir)
    {
        $lahir = $this->db->table('peristiwa_lahir')->where('id_lahir', param_decrypt($id_lahir))->get()->getRow();

        // dd($lahir);die;

        $data = [
            'judul' => 'Peristiwa Lahir',
            'aktif' => 'kelahiran',
            'show' => 'peristiwa',
            'swal' => 'Peristiwa Lahir',
            'lahir' => $lahir,
            'back'     => site_url('lahir'),
            'update'     => site_url('lahir/update/' . $id_lahir) 
        ];

        return view('lahir/lahir_detail', $data);
    }

    public function getRt()
    {
        if ($this->request->isAJAX()) {
            $id_dusun = $this->request->getVar('rw_ortu');
            $dusun = $this->db->table('dusun')->where('id_dusun', $id_dusun)->get()->getFirstRow('array');
            $isidata = '<option selected disabled value="">~~ Pilih ~~</option>';

            $rt = $this->db->table('rt')->where('id_rw', $dusun['id_rw'])->get();

            foreach ($rt->getResultArray() as $row) :
                $isidata .= '<option value="' . $row['id_rt'] . '">' . $row['no_rt'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];

            echo json_encode($msg);
        }
    }

    public function getRtEdit()
    {
        if ($this->request->isAJAX()) {
            $id_dusun = $this->request->getVar('dusun');
            $rt_db = $this->request->getVar('rt');

            $dusun = $this->db->table('dusun')->where('id_dusun', $id_dusun)->get()->getFirstRow('array');
            $isidata = '<option selected disabled value="">~~ Pilih ~~</option>';

            $rt = $this->db->table('rt')->where('id_rw', $dusun['id_rw'])->get();

            foreach ($rt->getResultArray() as $row) :
                $isidata .= '<option ' . (($row['id_rt'] == $rt_db) ? 'selected' : '') . ' value="' . $row['id_rt'] . '">' . $row['no_rt'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];

            echo json_encode($msg);
        }
    }

    public function viewAkte($id)
    {
        $data['akte'] = $this->pl->select('doc_akte')->find(param_decrypt($id));
        return view('lahir/akte_view', $data);
    }

}
