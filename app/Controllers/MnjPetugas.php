<?php

namespace App\Controllers;

use App\Models\MnjPetugasModel;
use App\Models\PendudukModel;

class MnjPetugas extends BaseController
{
    protected $db;
    protected $mp;
    protected $validation;
    public function __construct()
    {
        helper(['my_function']);
        is_admin();
        $this->mp = new MnjPetugasModel();
        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {

        $data = [
            'judul' => 'List Petugas',
            'aktif' => 'mnj_petugas',
            'show'  => 'manajement',
            'swal' => 'Petugas'
        ];

        return view('mnj_petugas/mnj_petugas_list', $data);
    }



    public function load()
    {
        $request = \Config\Services::request();
        $datatable = new MnjPetugasModel($request);

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
                $row[] = $list->email;
                $row[] = $list->nomor_sk;
                $row[] = '<a href="' . site_url('mnj_petugas/detail/') . $list->id_user . '" class="btn btn-info btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a href="' . site_url('mnj_petugas/update/') .  $list->id_user . '" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a><a onclick="hapus(' . $list->id_user . ')" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>';
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

    public function detail($id_user)
    {
        $data = [
            'judul'     => 'Detail Petugas',
            'aktif'     => 'mnj_petugas',
            'show'      => 'manajement',
            'swal'      => 'Petugas',
            'user'        => $this->mp->find($id_user),
            'back'     => site_url('petugas'),
            'update'     => site_url('mnj_petugas/update/') . $id_user
        ];

        // dd($data);die;


        return view('mnj_petugas/mnj_petugas_detail', $data);
    }

    public function create()
    {

        if ($this->request->getMethod() == 'get') {
            $data = [
                'judul'         => 'Tambah Petugas',
                'aktif'         => 'mnj_petugas',
                'show'          => 'manajement',
                'id_user'         => set_value('id_user'),
                'nik'         => set_value('nik'),
                'nama'         => set_value('nama'),
                'email'        => set_value('email'),
                'password'         => set_value('password'),
                'role'            => set_value('role'),
                'nomor_sk'            => set_value('nomor_sk'),
                'tanggal_ditetapkan'          => set_value('tanggal_ditetapkan'),
                'tanggal_berakhir'          => set_value('tanggal_berakhir'),
                'dusun'          => set_value('dusun'),
                'rt'          => set_value('rt'),
                'doc_sk'     => set_value('doc_sk'),
                'data_dusun' => $this->db->table('dusun')->get()->getResultArray(),
                'data_rt' => $this->db->table('rt')->get()->getResultArray(),
                'validation'    => $this->validation,
                'uri' => service('uri'),
                'action'        => site_url('mnj_petugas/create'),
                'cencel'        => site_url('mnj_petugas')
            ];
            return view('mnj_petugas/mnj_petugas_form', $data);
        } else {
            // dd($this->request->getVar());die;
            $validasi = $this->validate([
                'nik' => [
                    'rules' => 'required|numeric|min_length[16]|max_length[16]|is_unique[user.nik]',
                    'errors' => [
                        'required' => 'Nik harus di isi',
                        'is_unique' => 'Nik sudah ada',
                        'min_length' => 'Nik minimal 16 angka',
                        'max_length' => 'Nik maximal 16 angka',
                        'numeric' => 'Nik harus berupa angka',
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama harus di isi'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[user.email]',
                    'errors' => [
                        'required' => 'email harus di isi',
                        'is_unique' => 'Email sudah ada',
                        'valid_email' => 'email harus di isi',
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'password harus di isi'
                    ]
                ],
                'role' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'role harus di isi'
                    ]
                ],
                'nomor_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'nomor sk harus di isi'
                    ]
                ],
                'tanggal_ditetapkan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal ditetapkan harus di isi'
                    ]
                ],
                'tanggal_berakhir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal berakhir harus di isi'
                    ]
                ],
                'dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi'
                    ]
                ],
                'rt' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'RT harus di isi'
                    ]
                ],
                'doc_sk' => [
                    'rules' => 'uploaded[doc_sk]|mime_in[doc_sk,application/pdf]|max_size[doc_sk,4096]',
                    'errors' => [
                        'uploaded' => 'Harus Ada File yang diupload',
                        'mime_in' => 'File Extention Harus Berupa pdf',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);

            if (!$validasi) {
                return redirect()->to('mnj_petugas/create')->withInput();
            }


            $doc_sk     = $this->request->getFile('doc_sk');
            $filename   = $this->request->getVar('nik') . '.' . $doc_sk->guessExtension();

            $this->mp->save([
                'nik'                   => $this->request->getVar('nik'),
                'nama'                  => $this->request->getVar('nama'),
                'email'                 => $this->request->getVar('email'),
                'password'              => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'role'                  => $this->request->getVar('role'),
                'nomor_sk'              => $this->request->getVar('nomor_sk'),
                'tanggal_ditetapkan'    => $this->request->getVar('tanggal_ditetapkan'),
                'tanggal_berakhir'      => $this->request->getVar('tanggal_berakhir'),
                'dusun'      => $this->request->getVar('dusun'),
                'rt'      => $this->request->getVar('rt'),
                'doc_sk'                => $filename,
                'sessions'              => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            ]);

            $doc_sk->move('images/sk', $filename);


            session()->setFlashdata('pesan', 'di tambah');

            return redirect()->to('mnj_petugas');
        }
    }


    public function update($id_user)
    {
        $data_lama = $this->mp->where(['id_user' => $id_user])->first();

        if ($data_lama['nik'] == $this->request->getVar('nik')) {
            $ruleNik = 'required';
        } else {
            $ruleNik = 'required|numeric|min_length[16]|max_length[16]|is_unique[user.nik]';
        }

        if ($data_lama['email'] == $this->request->getVar('email')) {
            $ruleEmail = 'required';
        }else {
            $ruleEmail = 'required|valid_email|is_unique[user.email]';
        }


        if ($this->request->getMethod() == 'get') {
            $row = $this->mp->where('id_user', $id_user)->first();

            $data = [
                'judul'         => 'Tambah Petugas',
                'aktif'         => 'mnj_petugas',
                'show'          => 'manajement',
                'id_user'         => set_value('id_user', $row['id_user']),
                'nik'         => set_value('nik', $row['nik']),
                'nama'         => set_value('nama', $row['nama']),
                'email'        => set_value('email', $row['email']),
                'role'            => set_value('role', $row['role']),
                'nomor_sk'            => set_value('nomor_sk', $row['nomor_sk']),
                'tanggal_ditetapkan'          => set_value('tanggal_ditetapkan', $row['tanggal_ditetapkan']),
                'tanggal_berakhir'          => set_value('tanggal_berakhir', $row['tanggal_berakhir']),
                'dusun'      => set_value('dusun', $row['dusun']),
                'rt'      => set_value('rt', $row['rt']),
                'doc_sk'     => set_value('doc_sk', $row['doc_sk']),
                'data_dusun' => $this->db->table('dusun')->get()->getResultArray(),
                'data_rt' => $this->db->table('rt')->get()->getResultArray(),
                'validation'    => $this->validation,
                'uri' => service('uri'),
                'action'        => site_url('mnj_petugas/update'),
                'cencel'        => site_url('mnj_petugas')
            ];

            return view('mnj_petugas/mnj_petugas_form', $data);
        } else {
            $validasi = $this->validate([
                'nik' => [
                    'rules' => $ruleNik,
                    'errors' => [
                        'required' => 'Nik harus di isi',
                        'is_unique' => 'Nik sudah ada',
                        'min_length' => 'Nik minimal 16 angka',
                        'max_length' => 'Nik maximal 16 angka',
                        'numeric' => 'Nik harus berupa angka',
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama harus di isi'
                    ]
                ],
                'email' => [
                    'rules' => $ruleEmail,
                    'errors' => [
                        'required' => 'email harus di isi',
                        'is_unique' => 'Email sudah ada',
                        'valid_email' => 'email harus di isi',
                    ]
                ],
                'role' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'role harus di isi'
                    ]
                ],
                'nomor_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'nomor sk harus di isi'
                    ]
                ],
                'tanggal_ditetapkan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal ditetapkan harus di isi'
                    ]
                ],
                'tanggal_berakhir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal berakhir harus di isi'
                    ]
                ],
                'dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi'
                    ]
                ],
                'rt' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'RT harus di isi'
                    ]
                ],
                'doc_sk' => [
                    'rules' => 'mime_in[doc_sk,application/pdf]|max_size[doc_sk,4096]',
                    'errors' => [
                        'mime_in' => 'File Extention Harus Berupa pdf',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);


            if (!$validasi) {
                return redirect()->to('mnj_petugas/update/' . $id_user)->withInput();
            } else {
                $doc_sk     = $this->request->getFile('doc_sk');
                $filename   = $this->request->getVar('nik') . '.' . $doc_sk->guessExtension();

                if ($this->request->getVar('password') != null) {
                    $password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                } else {
                    $password = $data_lama['password'];
                }

                if (!$doc_sk->isValid()) {
                    $this->mp->save([
                        'id_user'               => $this->request->getVar('id_user'),
                        'nik'                   => $this->request->getVar('nik'),
                        'nama'                  => $this->request->getVar('nama'),
                        'email'                 => $this->request->getVar('email'),
                        'password'              => $password,
                        'role'                  => $this->request->getVar('role'),
                        'nomor_sk'              => $this->request->getVar('nomor_sk'),
                        'tanggal_ditetapkan'    => $this->request->getVar('tanggal_ditetapkan'),
                        'tanggal_berakhir'      => $this->request->getVar('tanggal_berakhir'),
                        'dusun'      => $this->request->getVar('dusun'),
                        'rt'      => $this->request->getVar('rt'),
                        'doc_sk'                => $data_lama['doc_sk'],
                        'sessions'              => $password,
                    ]);
                    session()->setFlashdata('pesan', 'di ubah');
                    return redirect()->to('mnj_petugas');
                } else {
                    @unlink('images/sk' . '/' . $data_lama['doc_sk']);

                    $this->mp->save([
                        'id_user'               => $this->request->getVar('id_user'),
                        'nik'                   => $this->request->getVar('nik'),
                        'nama'                  => $this->request->getVar('nama'),
                        'email'                 => $this->request->getVar('email'),
                        'password'              => $password,
                        'role'                  => $this->request->getVar('role'),
                        'nomor_sk'              => $this->request->getVar('nomor_sk'),
                        'tanggal_ditetapkan'    => $this->request->getVar('tanggal_ditetapkan'),
                        'tanggal_berakhir'      => $this->request->getVar('tanggal_berakhir'),
                        'dusun'      => $this->request->getVar('dusun'),
                        'rt'      => $this->request->getVar('rt'),
                        'doc_sk'                => $filename,
                        'sessions'              => $password,
                    ]);

                    $doc_sk->move('images/sk', $filename);

                    session()->setFlashdata('pesan', 'di ubah');
                    return redirect()->to('mnj_petugas');
                }
            }
        }
    }

    public function delete($id_user)
    {
        $data_lama = $this->mp->where(['id_user' => $id_user])->first();
        @unlink('images/sk' . '/' . $data_lama['doc_sk']);
        $this->mp->delete($id_user);
        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('mnj_petugas');
    }


    function download($id)
    {
        $data = $this->mp->find($id);
        return $this->response->download('images/sk' . '/' . $data['doc_sk'], null);
    }

    public function viewSK($id)
    {
        $data['sk'] = $this->mp->select('doc_sk')->find($id);
        return view('mnj_petugas/sk_view', $data);
    }

    public function getRt()
    {
        if ($this->request->isAJAX()) {
            $id_dusun = $this->request->getVar('dusun');
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
            $id_dusun = $this->request->getVar('rw');
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
