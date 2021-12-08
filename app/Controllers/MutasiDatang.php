<?php

namespace App\Controllers;

use App\Models\MutasiDatangModel;

class MutasiDatang extends BaseController
{
    protected $md;
    protected $db;
    protected $validation;
    public function __construct()
    {
        $this->md = new MutasiDatangModel();
        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'judul' => 'Mutasi Datang',
            'aktif' => 'mutasi_datang',
            'show' => 'mutasi',
            'swal' => 'Mutasi Datang',
        ];

        return view('datang/datang_list', $data);
    }

    public function load()
    {
        $request = \Config\Services::request();
        $datatable = new MutasiDatangModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nik;
                $row[] = $list->nama;
                $row[] = substr($list->alamat_domisili, 0, 20) . '...';
                $row[] = date('d-m-Y', strtotime($list->tanggal_datang));
                if ($list->status == 1) {
                    $class = 'success';
                    $text = 'Hidup';
                }else if ($list->status == 2) {
                    $class = 'dark';
                    $text = 'Meninggal';
                }else {
                    $class = 'secondary';
                    $text = 'Pindah';
                }
                $row[] = '<a data-toggle="tooltip" data-placement="top" title="Ubah status hidup" href="#" onclick="changeStatus(' . $list->id_datang . ')" class="badge badge-'. $class .'">'. $text .'</a>';
                $row[] = '<a href="' . site_url('datang/detail/') . param_encrypt($list->id_datang) . '" class="btn btn-info btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a href="' . site_url('datang/update/') .  param_encrypt($list->id_datang) . '" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a><a onclick="hapus(' . $list->id_datang . ')" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>';
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
                'judul'             => 'Mutasi Datang',
                'aktif'             => 'mutasi_datang',
                'show'              => 'mutasi',
                'swal'              => 'Mutasi Datang',
                'id_datang'         => set_value('id_datang'),
                'nik'               => set_value('nik'),
                'nama'              => set_value('nama'),
                'agama'             => set_value('agama'),
                'tempat_lahir'      => set_value('tempat_lahir'),
                'tanggal_lahir'     => set_value('tanggal_lahir'),
                'pekerjaan'         => set_value('jenis_pekerjaan'),
                'jenis_kelamin'     => set_value('jenis_kelamin'),
                'golongan_darah'    => set_value('golongan_darah'),
                'status_perkawinan' => set_value('status_perkawinan'),
                'kewarganegaraan'   => set_value('kewarganegaraan'),
                'alamat_domisili'   => set_value('alamat_domisili'),
                'dusun_domisili'   => set_value('dusun_domisili'),
                'rw_domisili'   => set_value('rw_domisili'),
                'rt_domisili'   => set_value('rt_domisili'),
                'tanggal_datang'    => set_value('tanggal_datang'),
                'doc_ktp'           => set_value('doc_ktp'),
                'keterangan'        => set_value('keterangan'),
                'alamat'            => set_value('alamat'),
                'dusun'             => set_value('dusun'),
                'rt'                => set_value('rt'),
                'rw'                => set_value('rw'),
                'desa'              => set_value('desa'),
                'kecamatan'         => set_value('kecamatan'),
                'kabupaten'         => set_value('kabupaten'),
                'provinsi'          => set_value('provinsi'),
                'kode_pos'          => set_value('kode_pos'),
                'dusun'             => set_value('dusun'),
                'validation'        => $this->validation,
                'uri' => service('uri'),
                'd_dusun' => $this->db->table('dusun')->get()->getResultArray(),
                'd_rw' => $this->db->table('rw')->get()->getResultArray(),
                'd_rt' => $this->db->table('rt')->get()->getResultArray(),
                'action'            => site_url('datang/create'),
                'cencel'            => site_url('datang')
            ];

            return view('datang/datang_form', $data);
        } else {
            $validasi = $this->validate([
                'nik' => [
                    'rules' => 'required|is_unique[mutasi_datang.nik]',
                    'errors' => [
                        'required' => '{field} harus di isi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'agama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Agama harus di isi'
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempat Lahir harus di isi'
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Lahir harus di isi'
                    ]
                ],
                'jenis_pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Pekerjaan harus di isi'
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin harus di isi',
                    ]
                ],
                'golongan_darah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Golongan Darah harus di isi',
                    ]
                ],
                'status_perkawinan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status Perkawinan harus di isi',
                    ]
                ],
                'kewarganegaraan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kewarganegaraan harus di isi',
                    ]
                ],
                'tanggal_datang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'alamat_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'dusun_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'rw_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'rt_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'rt' => [
                    'rules' => 'required|min_length[3]|max_length[3]|numeric',
                    'errors' => [
                        'required' => 'RT harus di isi',
                        'min_length' => 'RT harus di isi minimal 3 angka',
                        'max_length' => 'RT harus di isi maksimal 3 angka',
                        'numeric' => 'RT harus di isi dengan angka'
                    ]
                ],
                'rw' => [
                    'rules' => 'required|min_length[3]|max_length[3]|numeric',
                    'errors' => [
                        'required' => 'RW harus di isi',
                        'min_length' => 'RW harus di isi minimal 3 angka',
                        'max_length' => 'RW harus di isi maksimal 3 angka',
                        'numeric' => 'RW harus di isi dengan angka'
                    ]
                ],
                'kode_pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'provinsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'kabupaten' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'kecamatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi'
                    ]
                ],
                'doc_ktp' => [
                    'rules' => 'uploaded[doc_ktp]|mime_in[doc_ktp,image/jpg,image/jpeg,image/png]|max_size[doc_ktp,4096]',
                    'errors' => [
                        'uploaded' => 'Harus Ada File yang diupload',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);

            if (!$validasi) {
                return redirect()->back()->withInput();
            }

            $doc_ktp     = $this->request->getFile('doc_ktp');
            $filename   = $this->request->getVar('nik') . '.' . $doc_ktp->guessExtension();

            $this->md->save([
                'nik'               => $this->request->getVar('nik'),
                'nama'              => $this->request->getVar('nama'),
                'agama'             => $this->request->getVar('agama'),
                'tempat_lahir'      => $this->request->getVar('tempat_lahir'),
                'tanggal_lahir'     => $this->request->getVar('tanggal_lahir'),
                'pekerjaan'         => $this->request->getVar('jenis_pekerjaan'),
                'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                'golongan_darah'    => $this->request->getVar('golongan_darah'),
                'status_perkawinan' => $this->request->getVar('status_perkawinan'),
                'kewarganegaraan'   => $this->request->getVar('kewarganegaraan'),
                'alamat_domisili'   => $this->request->getVar('alamat_domisili'),
                'dusun_domisili'   => $this->request->getVar('dusun_domisili'),
                'rw_domisili'   => $this->request->getVar('rw_domisili'),
                'rt_domisili'   => $this->request->getVar('rt_domisili'),
                'tanggal_datang'    => $this->request->getVar('tanggal_datang'),
                'doc_ktp'           => $filename,
                'pencatat'          => session()->get('id_user'),
                'keterangan'        => $this->request->getVar('keterangan'),
                'status'            => '1',
                'timestamp'     => date('Y-m-d H:i:s'),
            ]);

            $doc_ktp->move('images/datang', $filename);

            $data_datang = $this->md->where('nik', $this->request->getVar('nik'))->first();

            $this->db->table('pendatang')->insert([
                'id_datang'         => $data_datang['id_datang'],
                'alamat'            => $this->request->getVar('alamat'),
                'dusun'             => $this->request->getVar('dusun'),
                'rt'                => $this->request->getVar('rt'),
                'rw'                => $this->request->getVar('rw'),
                'desa'              => $this->request->getVar('desa'),
                'kecamatan'         => $this->request->getVar('kecamatan'),
                'kabupaten'         => $this->request->getVar('kabupaten'),
                'provinsi'          => $this->request->getVar('provinsi'),
                'kode_pos'          => $this->request->getVar('kode_pos'),
            ]);

            session()->setFlashdata('pesan', 'di tambah');
            return redirect()->to('datang');
            
        }
    }

    public function update($id_datang)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $mutasi_datang = $this->md->where('id_datang', param_decrypt($id_datang))->first();
        $pendatang = $this->db->table('pendatang')->getWhere(['id_datang' => param_decrypt($id_datang)])->getFirstRow('array');
        if ($this->request->getMethod() == 'get') {

            // dd($mutasi_datang);die;

            $data = [
                'judul'             => 'Mutasi Datang',
                'aktif'             => 'mutasi_datang',
                'show'              => 'mutasi',
                'swal'              => 'Mutasi Datang',
                'id_datang'         => set_value('id_datang', $mutasi_datang['id_datang']),
                'nik'               => set_value('nik', $mutasi_datang['nik']),
                'nama'              => set_value('nama', $mutasi_datang['nama']),
                'agama'             => set_value('agama', $mutasi_datang['agama']),
                'tempat_lahir'      => set_value('tempat_lahir', $mutasi_datang['tempat_lahir']),
                'tanggal_lahir'     => set_value('tanggal_lahir', $mutasi_datang['tanggal_lahir']),
                'pekerjaan'         => set_value('jenis_pekerjaan', $mutasi_datang['pekerjaan']),
                'jenis_kelamin'     => set_value('jenis_kelamin', $mutasi_datang['jenis_kelamin']),
                'golongan_darah'    => set_value('golongan_darah', $mutasi_datang['golongan_darah']),
                'status_perkawinan' => set_value('status_perkawinan', $mutasi_datang['status_perkawinan']),
                'kewarganegaraan'   => set_value('kewarganegaraan', $mutasi_datang['kewarganegaraan']),
                'alamat_domisili'   => set_value('alamat_domisili', $mutasi_datang['alamat_domisili']),
                'dusun_domisili'   => set_value('dusun_domisili', $mutasi_datang['dusun_domisili']),
                'rw_domisili'   => set_value('rw_domisili', $mutasi_datang['rw_domisili']),
                'rt_domisili'   => set_value('rt_domisili', $mutasi_datang['rt_domisili']),
                'tanggal_datang'    => set_value('tanggal_datang', $mutasi_datang['tanggal_datang']),
                'doc_ktp'           => set_value('doc_ktp', $mutasi_datang['doc_ktp']),
                'keterangan'        => set_value('keterangan', $mutasi_datang['keterangan']),
                'alamat'            => set_value('alamat', $pendatang['alamat']),
                'dusun'             => set_value('dusun', $pendatang['dusun']),
                'rt'                => set_value('rt', $pendatang['rt']),
                'rw'                => set_value('rw', $pendatang['rw']),
                'desa'              => set_value('desa', $pendatang['desa']),
                'kecamatan'         => set_value('kecamatan', $pendatang['kecamatan']),
                'kabupaten'         => set_value('kabupaten', $pendatang['kabupaten']),
                'provinsi'          => set_value('provinsi', $pendatang['provinsi']),
                'kode_pos'          => set_value('kode_pos', $pendatang['kode_pos']),
                'validation'        => $this->validation,
                'uri' => service('uri'),
                'd_dusun' => $this->db->table('dusun')->get()->getResultArray(),
                'd_rw' => $this->db->table('rw')->get()->getResultArray(),
                'd_rt' => $this->db->table('rt')->get()->getResultArray(),
                'action'            => site_url('datang/update/' . $id_datang),
                'cencel'            => site_url('datang')
            ];

            return view('datang/datang_form', $data);
        }else {
            // dd($this->request->getVar());die;
            $data_lama = $this->md->where(['id_datang' => param_decrypt($id_datang)])->first();

            if ($data_lama['nik'] == $this->request->getVar('nik')) {
                $ruleNik = 'required';
            } else {
                $ruleNik = 'required|numeric|min_length[16]|max_length[16]|is_unique[kartu_keluarga.no_kk]';
            }
            $validasi = $this->validate([
                'nik' => [
                    'rules' => $ruleNik,
                    'errors' => [
                        'required' => '{field} harus di isi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'tanggal_datang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'alamat_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'dusun_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'rw_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'rt_domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'rt' => [
                    'rules' => 'required|min_length[3]|max_length[3]|numeric',
                    'errors' => [
                        'required' => 'RT harus di isi',
                        'min_length' => 'RT harus di isi minimal 3 angka',
                        'max_length' => 'RT harus di isi maksimal 3 angka',
                        'numeric' => 'RT harus di isi dengan angka'
                    ]
                ],
                'rw' => [
                    'rules' => 'required|min_length[3]|max_length[3]|numeric',
                    'errors' => [
                        'required' => 'RW harus di isi',
                        'min_length' => 'RW harus di isi minimal 3 angka',
                        'max_length' => 'RW harus di isi maksimal 3 angka',
                        'numeric' => 'RW harus di isi dengan angka'
                    ]
                ],
                'kode_pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'provinsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'kabupaten' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'kecamatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus di isi',
                    ]
                ],
                'dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi'
                    ]
                ],
                'doc_ktp' => [
                    'rules' => 'mime_in[doc_ktp,image/jpg,image/jpeg,image/png]|max_size[doc_ktp,4096]',
                    'errors' => [
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);

            if (!$validasi) {
                return redirect()->back()->withInput();
            }

            $doc_ktp     = $this->request->getFile('doc_ktp');
            $filename   = $this->request->getVar('nik') . '.' . $doc_ktp->guessExtension();

            if (!$doc_ktp->isValid()) {
                $this->md->save([
                    'id_datang'         => param_decrypt($this->request->getVar('id_datang')),
                    'nik'               => $this->request->getVar('nik'),
                    'nama'              => $this->request->getVar('nama'),
                    'agama'             => $this->request->getVar('agama'),
                    'tempat_lahir'      => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir'     => $this->request->getVar('tanggal_lahir'),
                    'pekerjaan'         => $this->request->getVar('jenis_pekerjaan'),
                    'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                    'golongan_darah'    => $this->request->getVar('golongan_darah'),
                    'status_perkawinan' => $this->request->getVar('status_perkawinan'),
                    'kewarganegaraan'   => $this->request->getVar('kewarganegaraan'),
                    'alamat_domisili'   => $this->request->getVar('alamat_domisili'),
                    'dusun_domisili'   => $this->request->getVar('dusun_domisili'),
                    'rw_domisili'   => $this->request->getVar('rw_domisili'),
                    'rt_domisili'   => $this->request->getVar('rt_domisili'),
                    'tanggal_datang'    => $this->request->getVar('tanggal_datang'),
                    'pencatat'          => session()->get('id_user'),
                    'keterangan'        => $this->request->getVar('keterangan'),
                    'updated'     => date('Y-m-d H:i:s'),
                ]);

                $this->db->table('pendatang')->where('id_datang', param_decrypt($id_datang))->update([
                    'alamat'            => $this->request->getVar('alamat'),
                    'dusun'             => $this->request->getVar('dusun'),
                    'rt'                => $this->request->getVar('rt'),
                    'rw'                => $this->request->getVar('rw'),
                    'desa'              => $this->request->getVar('desa'),
                    'kecamatan'         => $this->request->getVar('kecamatan'),
                    'kabupaten'         => $this->request->getVar('kabupaten'),
                    'provinsi'          => $this->request->getVar('provinsi'),
                    'kode_pos'          => $this->request->getVar('kode_pos'),
                ]);
            }else {
                @unlink('images/datang' . '/' . $data_lama['doc_ktp']);              

                $this->md->save([
                    'id_datang'         => param_decrypt($this->request->getVar('id_datang')),
                    'nik'               => $this->request->getVar('nik'),
                    'nama'              => $this->request->getVar('nama'),
                    'agama'             => $this->request->getVar('agama'),
                    'tempat_lahir'      => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir'     => $this->request->getVar('tanggal_lahir'),
                    'pekerjaan'         => $this->request->getVar('jenis_pekerjaan'),
                    'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                    'golongan_darah'    => $this->request->getVar('golongan_darah'),
                    'status_perkawinan' => $this->request->getVar('status_perkawinan'),
                    'kewarganegaraan'   => $this->request->getVar('kewarganegaraan'),
                    'alamat_domisili'   => $this->request->getVar('alamat_domisili'),
                    'dusun_domisili'   => $this->request->getVar('dusun_domisili'),
                    'rw_domisili'   => $this->request->getVar('rw_domisili'),
                    'rt_domisili'   => $this->request->getVar('rt_domisili'),
                    'tanggal_datang'    => $this->request->getVar('tanggal_datang'),
                    'doc_ktp'           => $filename,
                    'pencatat'          => session()->get('id_user'),
                    'keterangan'        => $this->request->getVar('keterangan'),
                    'updated'     => date('Y-m-d H:i:s'),
                ]);

                $doc_ktp->move('images/datang', $filename);

                $this->db->table('pendatang')->where('id_datang', param_decrypt($id_datang))->update([
                    'alamat'            => $this->request->getVar('alamat'),
                    'dusun'             => $this->request->getVar('dusun'),
                    'rt'                => $this->request->getVar('rt'),
                    'rw'                => $this->request->getVar('rw'),
                    'desa'              => $this->request->getVar('desa'),
                    'kecamatan'         => $this->request->getVar('kecamatan'),
                    'kabupaten'         => $this->request->getVar('kabupaten'),
                    'provinsi'          => $this->request->getVar('provinsi'),
                    'kode_pos'          => $this->request->getVar('kode_pos'),
                ]);

            }
            session()->setFlashdata('pesan', 'di ubah');
            return redirect()->to('datang');
        }
        
    }

    public function delete($id)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $data_lama = $this->md->where(['id_datang' => $id])->first();
        @unlink('images/datang' . '/' . $data_lama['doc_ktp']);
        $this->md->delete($id);
        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('datang');
    }

    public function detail($id_datang){
        $penduduk = $this->db->table('mutasi_datang')->where('mutasi_datang.id_datang', param_decrypt($id_datang))->select('*')->join('pendatang', 'pendatang.id_datang = mutasi_datang.id_datang')->get()->getRow();

        // dd($penduduk);die;

        $data = [
            'judul' => 'Detail Mutasi Datang',
            'aktif' => 'mutasi_datang',
            'show'  => 'mutasi',
            'penduduk' => $penduduk,
            'back'     => site_url('datang'),
            'update'     => site_url('datang/update/') . $id_datang
        ];

        return view('datang/datang_detail', $data);
    }

    public function viewKtp($id)
    {
        $data['ktp'] = $this->md->select('doc_ktp')->find(param_decrypt($id));
        return view('datang/ktp_view', $data);
    }

    function download($id)
    {
        $data = $this->md->find(param_decrypt($id));
        return $this->response->download('images/datang' . '/' . $data['doc_ktp'], null);
    }

    public function changeStatusHidup($id_datang){
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $this->db->table('mutasi_datang')->where('id_datang', $id_datang)->update(['status' => 1, 'event_status'      => date('Y-m-d H:i:s'),]);

        session()->setFlashdata('pesan', 'di ubah');
        return redirect()->to('datang');
    }

    public function changeStatusMeninggal($id_datang){
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $this->db->table('mutasi_datang')->where('id_datang', $id_datang)->update(['status' => 2, 'event_status'      => date('Y-m-d H:i:s'),]);

        session()->setFlashdata('pesan', 'di ubah');
        return redirect()->to('datang');
    }

    public function changeStatusPindah($id_datang){
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $this->db->table('mutasi_datang')->where('id_datang', $id_datang)->update(['status' => 3, 'event_status'      => date('Y-m-d H:i:s'),]);

        session()->setFlashdata('pesan', 'di ubah');
        return redirect()->to('datang');
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

    public function getRt()
    {
        if ($this->request->isAJAX()) {
            $id_dusun = $this->request->getVar('rw_domisili');
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

}
