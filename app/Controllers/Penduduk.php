<?php

namespace App\Controllers;

use App\Models\PendudukModel;
use App\Models\KkModel;
use CodeIgniter\HTTP\RequestInterface;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request;
 */

class Penduduk extends BaseController
{
    protected $db;
    protected $penduduk;
    protected $kk;
    protected $validation;
    public function __construct()
    {
        $this->penduduk     = new PendudukModel();
        $this->kk           = new KkModel();
        $this->db           = \Config\Database::connect();
        $this->validation   = \Config\Services::validation();
    }

    public function index()
    {
        $dusun = $this->db->table('dusun')->get()->getResultArray();

        $rt = $this->db->table('rt')->get()->getResultArray();

        $data = [
            'judul' => 'List Penduduk',
            'aktif' => 'individu',
            'show'  => 'kependudukan',
            'swal' => 'Penduduk',
            'dusun' => $dusun,
            'rt' => $rt,
        ];

        return view('penduduk/penduduk_list', $data);
    }

    public function loadPenduduk()
    {
        $request = \Config\Services::request();
        $datatable = new PendudukModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nik;
                $row[] = $list->nama_lengkap;
                $row[] = $list->alamat;
                $row[] = ($list->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan';
                $row[] = getStatus($list->id_penduduk);
                $row[] = '<a href="' . site_url('penduduk/detail/') . param_encrypt($list->id_penduduk) . '" class="btn btn-info btn-sm mr-2 mb-2 detail" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a href="' . site_url('penduduk/update/') .  param_encrypt($list->id_penduduk) . '" class="btn btn-warning btn-sm mr-2 mb-2 edit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a><a onclick="hapus(' . $list->id_penduduk . ')" class="btn btn-danger btn-sm mb-2"><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Hapus"></i></a>';
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

    public function detail($id_penduduk)
    {
        $penduduk = $this->db->table('penduduk')->select('*')->join('kartu_keluarga', 'kartu_keluarga.id_kk = penduduk.id_kk')->where('id_penduduk', param_decrypt($id_penduduk))->get()->getRow();


        $data = [
            'judul' => 'Detail penduduk',
            'aktif' => 'individu',
            'show'  => 'kependudukan',
            'penduduk' => $penduduk,
            'back'     => site_url('penduduk'),
            'update'     => site_url('penduduk/update/') . $id_penduduk
        ];

        return view('penduduk/penduduk_detail', $data);
    }


    public function create()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        // dd($this->request->getVar());die;
        if (empty($this->request->getVar())) {
            $data = [
                'judul' => 'Tambah Penduduk',
                'aktif' => 'individu',
                'show'  => 'kependudukan',
                'swal'      => 'Kartu Keluarga',
                'id_penduduk' => set_value('id_penduduk'),
                'id_kk' => set_value('id_kk'),
                'nik' => set_value('nik'),
                'nama_lengkap' => set_value('nama_lengkap'),
                'agama' => set_value('agama'),
                'tempat_lahir' => set_value('tempat_lahir'),
                'tanggal_lahir' => set_value('tanggal_lahir'),
                'pendidikan' => set_value('pendidikan'),
                'jenis_pekerjaan' => set_value('jenis_pekerjaan'),
                'no_paspor' => set_value('no_paspor'),
                'no_kitas_or_kitab' => set_value('no_kitas_or_kitab'),
                'jenis_kelamin' => set_value('jenis_kelamin'),
                'nama_ayah' => set_value('nama_ayah'),
                'nama_ibu' => set_value('nama_ibu'),
                'golongan_darah' => set_value('golongan_darah'),
                'status_perkawinan' => set_value('status_perkawinan'),
                'kewarganegaraan' => set_value('kewarganegaraan'),
                'hubungan_keluarga' => set_value('hubungan_keluarga'),
                'doc_ktp' => set_value('doc_ktp'),
                'validation' => $this->validation,
                'action' => site_url('penduduk/create'),
                'cencel' => site_url('penduduk')
            ];
            return view('penduduk/penduduk_form', $data);
        } else {
            $doc_ktp     = $this->request->getFile('doc_ktp');
            $filename   = $this->request->getVar('nik') . '.' . $doc_ktp->guessExtension();

            if (!$doc_ktp->isValid()) {
                $validasi_penduduk = $this->validasi_penduduk($this->request->getVar('nik'));

                if (!$validasi_penduduk) {
                    return redirect()->back()->withInput();
                }

                // Save Penduduk
                $this->penduduk->save([
                    'id_kk' => $this->request->getVar('id_kk'),
                    'nik' => $this->request->getVar('nik'),
                    'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                    'agama' => $this->request->getVar('agama'),
                    'tempat_lahir' => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                    'pendidikan' => $this->request->getVar('pendidikan'),
                    'jenis_pekerjaan' => $this->request->getVar('jenis_pekerjaan'),
                    'no_paspor' => $this->request->getVar('no_paspor'),
                    'no_kitas_or_kitab' => $this->request->getVar('no_kitas_or_kitab'),
                    'nama_ayah' => $this->request->getVar('nama_ayah'),
                    'nama_ibu' => $this->request->getVar('nama_ibu'),
                    'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                    'golongan_darah' => $this->request->getVar('golongan_darah'),
                    'status_perkawinan' => $this->request->getVar('status_perkawinan'),
                    'kewarganegaraan' => $this->request->getVar('kewarganegaraan'),
                    'hubungan_keluarga' => $this->request->getVar('hubungan_keluarga'),
                    'pencatat' => session()->get('id_user'),
                    'timestamp'     => date('Y-m-d H:i:s'),
                ]);

                session()->setFlashdata('pesan', 'di tambah');
                return redirect()->to('penduduk');
            } else {
                $validasi_penduduk = $this->validasi_penduduk($this->request->getVar('nik'));

                if (!$validasi_penduduk) {
                    return redirect()->to('penduduk/create')->withInput();
                }


                // Save Penduduk
                $this->penduduk->save([
                    'id_kk' => $this->request->getVar('id_kk'),
                    'nik' => $this->request->getVar('nik'),
                    'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                    'agama' => $this->request->getVar('agama'),
                    'tempat_lahir' => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                    'pendidikan' => $this->request->getVar('pendidikan'),
                    'jenis_pekerjaan' => $this->request->getVar('jenis_pekerjaan'),
                    'no_paspor' => $this->request->getVar('no_paspor'),
                    'no_kitas_or_kitab' => $this->request->getVar('no_kitas_or_kitab'),
                    'nama_ayah' => $this->request->getVar('nama_ayah'),
                    'nama_ibu' => $this->request->getVar('nama_ibu'),
                    'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                    'golongan_darah' => $this->request->getVar('golongan_darah'),
                    'status_perkawinan' => $this->request->getVar('status_perkawinan'),
                    'kewarganegaraan' => $this->request->getVar('kewarganegaraan'),
                    'hubungan_keluarga' => $this->request->getVar('hubungan_keluarga'),
                    'pencatat' => session()->get('id_user'),
                    'doc_ktp' => $filename,
                    'timestamp'     => date('Y-m-d H:i:s'),
                ]);

                $doc_ktp->move('images/ktp', $filename);

                session()->setFlashdata('pesan', 'di tambah');
                return redirect()->to('penduduk');
            }
        }
    }


    public function update($id_penduduk)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $penduduk = $this->penduduk->where('id_penduduk', param_decrypt($id_penduduk))->first();

        if ($this->request->getPost()) {
            $validasiPenduduk = $this->validasi_penduduk(param_decrypt($id_penduduk));

            if (!$validasiPenduduk) {
                return redirect()->back()->withInput();
            }

            $doc_ktp     = $this->request->getFile('doc_ktp');
            $filename   = $this->request->getVar('nik') . '.' . $doc_ktp->guessExtension();

            if (!$doc_ktp->isValid()) {

                $this->penduduk->save([
                    'id_penduduk' => param_decrypt($this->request->getVar('id_penduduk')),
                    'id_kk' => $this->request->getVar('id_kk'),
                    'nik' => $this->request->getVar('nik'),
                    'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                    'agama' => $this->request->getVar('agama'),
                    'tempat_lahir' => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                    'pendidikan' => $this->request->getVar('pendidikan'),
                    'jenis_pekerjaan' => $this->request->getVar('jenis_pekerjaan'),
                    'no_paspor' => $this->request->getVar('no_paspor'),
                    'no_kitas_or_kitab' => $this->request->getVar('no_kitas_or_kitab'),
                    'nama_ayah' => $this->request->getVar('nama_ayah'),
                    'nama_ibu' => $this->request->getVar('nama_ibu'),
                    'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                    'golongan_darah' => $this->request->getVar('golongan_darah'),
                    'status_perkawinan' => $this->request->getVar('status_perkawinan'),
                    'kewarganegaraan' => $this->request->getVar('kewarganegaraan'),
                    'hubungan_keluarga' => $this->request->getVar('hubungan_keluarga'),
                    'pencatat' => session()->get('id_user'),
                    'updated'     => date('Y-m-d H:i:s'),
                ]);
            } else {

                @unlink('images/ktp' . '/' . $penduduk['doc_ktp']);
                $this->penduduk->save([
                    'id_penduduk' => param_decrypt($this->request->getVar('id_penduduk')),
                    'id_kk' => $this->request->getVar('id_kk'),
                    'nik' => $this->request->getVar('nik'),
                    'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                    'agama' => $this->request->getVar('agama'),
                    'tempat_lahir' => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                    'pendidikan' => $this->request->getVar('pendidikan'),
                    'jenis_pekerjaan' => $this->request->getVar('jenis_pekerjaan'),
                    'no_paspor' => $this->request->getVar('no_paspor'),
                    'no_kitas_or_kitab' => $this->request->getVar('no_kitas_or_kitab'),
                    'nama_ayah' => $this->request->getVar('nama_ayah'),
                    'nama_ibu' => $this->request->getVar('nama_ibu'),
                    'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                    'golongan_darah' => $this->request->getVar('golongan_darah'),
                    'status_perkawinan' => $this->request->getVar('status_perkawinan'),
                    'kewarganegaraan' => $this->request->getVar('kewarganegaraan'),
                    'hubungan_keluarga' => $this->request->getVar('hubungan_keluarga'),
                    'pencatat' => session()->get('id_user'),
                    'doc_ktp' => $filename,
                    'updated'     => date('Y-m-d H:i:s'),
                ]);
                $doc_ktp->move('images/ktp', $filename);
            }

            session()->setFlashdata('pesan', 'di update');
            return redirect()->to('penduduk');
        } else {

            $data = [
                'judul' => 'Update Penduduk',
                'aktif' => 'individu',
                'show' => 'kependudukan',
                'swal' => 'Data Penduduk',
                'id_penduduk' => set_value('id_penduduk', $penduduk['id_penduduk']),
                'id_kk' => set_value('id_kk', $penduduk['id_kk']),
                'nik' => set_value('nik', $penduduk['nik']),
                'nama_lengkap' => set_value('nama_lengkap', $penduduk['nama_lengkap']),
                'agama' => set_value('agama', $penduduk['agama']),
                'tempat_lahir' => set_value('tempat_lahir', $penduduk['tempat_lahir']),
                'tanggal_lahir' => set_value('tanggal_lahir', $penduduk['tanggal_lahir']),
                'pendidikan' => set_value('pendidikan', $penduduk['pendidikan']),
                'jenis_pekerjaan' => set_value('jenis_pekerjaan', $penduduk['jenis_pekerjaan']),
                'no_paspor' => set_value('no_paspor', $penduduk['no_paspor']),
                'no_kitas_or_kitab' => set_value('no_kitas_or_kitab', $penduduk['no_kitas_or_kitab']),
                'jenis_kelamin' => set_value('jenis_kelamin', $penduduk['jenis_kelamin']),
                'nama_ayah' => set_value('nama_ayah', $penduduk['nama_ayah']),
                'nama_ibu' => set_value('nama_ibu', $penduduk['nama_ibu']),
                'golongan_darah' => set_value('golongan_darah', $penduduk['golongan_darah']),
                'status_perkawinan' => set_value('status_perkawinan', $penduduk['status_perkawinan']),
                'kewarganegaraan' => set_value('kewarganegaraan', $penduduk['kewarganegaraan']),
                'hubungan_keluarga' => set_value('hubungan_keluarga', $penduduk['hubungan_keluarga']),
                'doc_ktp' => set_value('doc_ktp', $penduduk['doc_ktp']),
                'validation' => $this->validation,
                'action' => site_url('penduduk/update/' . $id_penduduk),
                'cencel' => site_url('penduduk')
            ];

            return view('penduduk/penduduk_form', $data);
        }
    }

    public function delete($id_penduduk)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        $data_lama = $this->penduduk->where(['id_penduduk' => $id_penduduk])->first();
        @unlink('images/ktp' . '/' . $data_lama['doc_ktp']);
        $this->penduduk->delete($id_penduduk);
        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('penduduk');
    }

    public function viewKtp($id)
    {
        $data['ktp'] = $this->penduduk->select('doc_ktp')->find(param_decrypt($id));
        return view('penduduk/ktp_view', $data);
    }

    function download($id)
    {
        $data = $this->penduduk->find(param_decrypt($id));
        return $this->response->download('images/ktp' . '/' . $data['doc_ktp'], null);
    }

    function download_format()
    {
        return $this->response->download('template_import/tenplate_import_KK_dan_penduduk.xlsx', null);
    }


    public function validasi_penduduk($id_penduduk)
    {
        if (!empty($id_penduduk)) {
            $data_lama = $this->penduduk->where(['id_penduduk' => $id_penduduk])->first();
            if ($data_lama == null) {
                $rulePenduduk = 'required|is_unique[penduduk.nik]';
            } else if ($data_lama['nik'] == $this->request->getVar('nik')) {
                $rulePenduduk = 'required';
            } else {
                $rulePenduduk = 'required|min_length[16]|max_length[16]|is_unique[penduduk.nik]';
            }
        } else {
            $rulePenduduk = 'required|numeric|min_length[16]|max_length[16]|is_unique[penduduk.nik]';
        }
        $validasi = $this->validate([
            'id_kk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID kartu keluarga harus di isi'
                ]
            ],
            'nik' => [
                'rules' => $rulePenduduk,
                'errors' => [
                    'required' => 'Nik harus di isi',
                    'is_unique' => 'Nik sudah ada',
                    'min_length' => 'Nik minimal 16 angka',
                    'max_length' => 'Nik maximal 16 angka',
                    'numeric' => 'Nik harus berupa angka',
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lengkap harus di isi'
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
            'pendidikan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pendidikan harus di isi'
                ]
            ],
            'jenis_pekerjaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Pekerjaan harus di isi'
                ]
            ],
            'nama_ayah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Ayah harus di isi',
                ]
            ],
            'nama_ibu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Ibu harus di isi',
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
            'hubungan_keluarga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Hubungan keluarga harus di isi',
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

        return $validasi;
    }

    public function search_noKK()
    {

        if ($this->request->isAJAX()) {
            $search_no_kk = $this->request->getVar('search');
            $no_kk = $this->db->table('kartu_keluarga')->LIKE('no_kk', $search_no_kk)->get();

            if ($no_kk->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($no_kk->getResultArray() as $row) :
                    $list[$key]['id'] = $row['id_kk'];
                    $list[$key]['text'] = $row['no_kk'];
                    $key++;
                endforeach;
                echo json_encode($list);
            }
        }
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

    public function import()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };
        
        if ($this->request->getMethod() == 'get') {
            $data = [
                'judul'         => 'Import Data Penduduk',
                'aktif'         => 'individu',
                'show'          => 'kependudukan',
                'validation'    => $this->validation,
                'action'        => site_url('penduduk/import'),
                'cencel'        => site_url('penduduk')
            ];
            return view('penduduk/penduduk_import', $data);
        } else {

            $validasi = $this->validate([

                'fileimport' => [
                    'rules' => 'uploaded[fileimport]|ext_in[fileimport,xls,xlsx]',
                    'errors' => [
                        'uploaded' => 'Harus ada file yang di pilih',
                        'ext_in' => 'File harus ber extensi xls atau xlsx'
                    ]
                ],
            ]);


            if (!$validasi) {
                return redirect()->to('penduduk/import')->withInput();
            } else {
                $file = $this->request->getFile('fileimport');

                $ext = $file->getClientExtension();

                if ($ext == 'xls') {
                    $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else {
                    $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }

                $spreadsheet = $render->load($file);

                $data = $spreadsheet->getSheet(1)->toArray();

                $psn_error = [];
                $psn_kurang_16 = [];
                $psn_not_found_kk = [];
                $psn_sukses = [];
                $jml_error = 0;
                $jml_kurang_16 = 0;
                $jml_not_found_kk = 0;
                $jml_sukses = 0;

                foreach ($data as $key => $value) {
                    if ($key == 0) {
                        continue;
                    }

                    $no_kk = $value[0];
                    $nik = $value[1];
                    $nama_lengkap = $value[2];
                    $tempat_lahir = $value[3];
                    $tanggal_lahir = $value[4];
                    $jenis_kelamin = $value[5];
                    $golongan_darah = $value[6];
                    $agama = $value[7];
                    $status_perkawinan = $value[8];
                    $hubungan_keluarga = $value[9];
                    $kewarganegaraan = $value[10];
                    $pendidikan = $value[11];
                    $jenis_pekerjaan = $value[12];
                    $no_paspor = $value[13];
                    $no_kitas_or_kitab = $value[14];
                    $nama_ayah = $value[15];
                    $nama_ibu = $value[16];
                    $pencatat = session()->get('id_user');
                    $doc_ktp = $value[18];
                    $timestamp = $value[19];
                    $updated = $value[20];

                    $cek_no_kk = $this->db->table('kartu_keluarga')->getWhere(['no_kk' => $no_kk])->getResult();

                    $cek_nik = $this->db->table('penduduk')->getWhere(['nik' => $nik])->getResult();

                    $cek_digit = strlen($nik);

                    if (count($cek_no_kk) > 0) {
                        $id_kk = $cek_no_kk[0]->id_kk;

                        if ($cek_digit > 16 || $cek_digit < 16) {
                            $jml_kurang_16++;
                            $psn_kurang_16[] = 'NIK Penduduk : ' . $nik . ' kurang atau lebih dari 16 digit <br>';
                        } else if (count($cek_nik) > 0 || $nik == '') {
                            $jml_error++;

                            $psn_error[] = 'NIK Penduduk : ' . $nik . ' sudah ada <br>';
                        } else {
                            $data_simpan = [
                                'id_kk' => $id_kk,
                                'nik' => $nik,
                                'nama_lengkap' => $nama_lengkap,
                                'tempat_lahir' => $tempat_lahir,
                                'tanggal_lahir' => $tanggal_lahir,
                                'jenis_kelamin' => $jenis_kelamin,
                                'golongan_darah' => $golongan_darah,
                                'agama' => $agama,
                                'status_perkawinan' => $status_perkawinan,
                                'hubungan_keluarga' => $hubungan_keluarga,
                                'kewarganegaraan' => $kewarganegaraan,
                                'pendidikan' => $pendidikan,
                                'jenis_pekerjaan' => $jenis_pekerjaan,
                                'no_paspor' => $no_paspor,
                                'no_kitas_or_kitab' => $no_kitas_or_kitab,
                                'nama_ayah' => $nama_ayah,
                                'nama_ibu' => $nama_ibu,
                                'pencatat' => $pencatat,
                                'doc_ktp' => $doc_ktp,
                                'timestamp' => $timestamp,
                                'updated' => $updated,
                            ];

                            $this->db->table('penduduk')->insert($data_simpan);
                            $jml_sukses++;

                            $psn_sukses[] = 'NIK Penduduk : ' . $no_kk . ' berhasil di simpan <br>';
                        }
                    } else {
                        $jml_not_found_kk++;
                        $psn_not_found_kk[] = 'Nomor KK : ' . $no_kk . ' tidak ada pada data kartu keluarga <br>';
                    }
                }


                foreach ($psn_kurang_16 as $key) {
                    $show_kurang_16[] = $key;
                }

                foreach ($psn_not_found_kk as $key) {
                    $show_not_found_kk[] = $key;
                }

                foreach ($psn_error as $key) {
                    $show_error[] = $key;
                }

                foreach ($psn_sukses as $key) {
                    $show_sukses[] = $key;
                }
            }


            if ($jml_sukses > 0) {
                session()->setFlashdata('pesan', '<b>' . $jml_sukses . ' Data Penduduk berhasil disimpan</b> <br><br>');
                session()->setFlashdata('show_sukses', $show_sukses);
            }

            if ($jml_error > 0) {
                session()->setFlashdata('error', '<b>' . $jml_error . ' Data Penduduk gagal disimpan (Data Penduduk Sudah Ada) </b><br><br>');
                session()->setFlashdata('show_error', $show_error);
            }

            if ($jml_kurang_16 > 0) {
                session()->setFlashdata('jml_kurang_16', '<b>' . $jml_kurang_16 . ' Data Penduduk gagal disimpan (Data Penduduk Kurang atau Lebih dari 16 digit)</b> <br><br>');
                session()->setFlashdata('show_kurang_16', $show_kurang_16);
            }

            if ($jml_not_found_kk > 0) {
                session()->setFlashdata('jml_not_found_kk', '<b>' . $jml_not_found_kk . ' Data Penduduk gagal disimpan (Data Penduduk Kurang atau Lebih dari 16 digit)</b> <br><br>');
                session()->setFlashdata('show_not_found_kk', $show_not_found_kk);
            }

            return redirect()->to('penduduk/import');
        }
    }

    public function import_foto_ktp()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };

        if ($this->request->getMethod() == 'get') {
            $data = [
                'judul'         => 'Import Foto KTP',
                'aktif'         => 'individu',
                'show'          => 'kependudukan',
                'validation'    => $this->validation,
                'action'        => site_url('penduduk/import_foto_ktp'),
                'cencel'        => site_url('penduduk')
            ];
            return view('penduduk/penduduk_import_foto_ktp', $data);
        } else {

            $jml_sukses = 0;
            $jml_error = 0;
            $jml_not_png = 0;
            $psn_sukses = [];
            $psn_error = [];
            $psn_not_png = [];

            $validasi = $this->validate([

                'foto_ktp' => [
                    'rules' => 'uploaded[foto_ktp]|mime_in[foto_ktp,image/jpg,image/jpeg,image/png]|max_size[foto_ktp,4096]',
                    'errors' => [
                        'uploaded' => 'Harus ada file yang di pilih',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);


            if (!$validasi) {
                return redirect()->to('penduduk/import_foto_ktp')->withInput();
            } else {
                $files = $this->request->getFiles();
                foreach ($files['foto_ktp'] as $img) {
                    if ($img->getClientExtension() == 'png') {
                        $nama_foto = substr($img->getName(), 0, 16);
                        $cek_foto = $this->db->table('penduduk')->getWhere(['nik' => $nama_foto])->getFirstRow('array');

                        if ($cek_foto != null) {
                            if ($nama_foto == $cek_foto['nik']) {
                                @unlink('images/ktp' . '/' . $cek_foto['doc_ktp']);
                                $valid_name = $img->getName();
                                if ($img->isValid() && !$img->hasMoved()) {
                                    $img->move('images/ktp', $valid_name);
                                    $jml_sukses++;

                                    $psn_sukses[] = 'Foto ' . $valid_name . ' Berhasil di upload!';
                                }
                                // print_r($cek_foto['no_kk']);
                            }
                        } else {
                            $error_name = $img->getName();
                            $jml_error++;

                            $psn_error[] = 'Foto ' . $error_name . ' Gagal di Upload (NIK tidak sesuai)';
                        }
                    } else {
                        $error_name = $img->getName();
                        $jml_not_png++;

                        $psn_not_png[] = 'Foto ' . $error_name . ' Bukan .png';
                    }
                }
                foreach ($psn_sukses as $key) {
                    $show_sukses[] = $key;
                }
                foreach ($psn_error as $key) {
                    $show_error[] = $key;
                }
                foreach ($psn_not_png as $key) {
                    $show_not_png[] = $key;
                }
            }

            if ($jml_sukses > 0) {
                session()->setFlashdata('pesan', '<b>' . $jml_sukses . ' KTP berhasil disimpan</b> <br><br>');
                session()->setFlashdata('show_sukses', $show_sukses);
            }
            if ($jml_error > 0) {
                session()->setFlashdata('error', '<b>' . $jml_error . ' KTP gagal disimpan</b> <br><br>');
                session()->setFlashdata('show_error', $show_error);
            }
            if ($jml_not_png > 0) {
                session()->setFlashdata('not_png', '<b>' . $jml_not_png . ' KTP gagal disimpan</b> <br><br>');
                session()->setFlashdata('show_not_png', $show_not_png);
            }

            return redirect()->to('penduduk/import_foto_ktp');
        }
    }
}
