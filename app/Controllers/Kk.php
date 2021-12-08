<?php

namespace App\Controllers;

use App\Models\KkModel;
use App\Models\PendudukModel;

class KK extends BaseController
{
    protected $db;
    protected $kk;
    protected $validation;
    public function __construct()
    {
        $this->kk = new KkModel();
        $this->individu = new PendudukModel();
        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'judul' => 'List kartu keluarga',
            'aktif' => 'kartu_keluarga',
            'show'  => 'kependudukan',
            'swal' => 'Kartu Keluarga',
        ];

        return view('kk/kk_list', $data);
    }

    public function loadKK()
    {
        $request = \Config\Services::request();
        $datatable = new KkModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->no_kk;
                $row[] = getDusun($list->dusun);
                $row[] = getRt($list->rt) . '/' . getRw($list->rw);
                $row[] = getJumlahIndividu($list->id_kk);
                $row[] = (getKepalaKeluarga($list->id_kk) == '') ? 'Belum di update' : getKepalaKeluarga($list->id_kk);
                $row[] = '<a href="' . site_url('kk/detail/') .
                    param_encrypt($list->id_kk) . '" class="btn btn-info btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-search-plus"></i></a><a href="' . site_url('kk/update/') .  param_encrypt($list->id_kk) . '" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a><a onclick="hapus(' . $list->id_kk . ')" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>';
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

    public function detail($id_kk)
    {
        $fix_id = param_decrypt($id_kk);
        $data = [
            'judul'     => 'Detail kartu keluarga',
            'aktif'     => 'kartu_keluarga',
            'show'      => 'kependudukan',
            'swal'      => 'Kartu Keluarga',
            'kk'        => $this->kk->find($fix_id),
            'individu'  => $this->individu->where('id_kk', $fix_id)->findAll(),
            'back'     => site_url('kk'),
            'update'     => site_url('kk/update/') . $id_kk,
        ];

        // dd($data);die;


        return view('kk/kk_detail', $data);
    }

    public function create()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };

        $dusun = $this->db->table('dusun')->get()->getResultArray();
        $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');
        // dd($mnj_desa);die;

        if ($this->request->getMethod() == 'get') {
            $data = [
                'judul'         => 'Tambah Kartu Keluarga',
                'aktif'         => 'kartu_keluarga',
                'show'          => 'kependudukan',
                'id_kk'         => set_value('id_kk'),
                'no_kk'         => set_value('no_kk'),
                'alamat'        => set_value('alamat'),
                'dusun'         => set_value('dusun'),
                'rt'            => set_value('rt'),
                'rw'            => set_value('rw'),
                'desa'          => set_value('desa'),
                'kecamatan'     => set_value('kecamatan'),
                'kabupaten'     => set_value('kabupaten'),
                'provinsi'      => set_value('provinsi'),
                'kode_pos'      => set_value('kode_pos'),
                'doc_kk'        => set_value('doc_kk'),
                'validation'    => $this->validation,
                'uri' => service('uri'),
                'data_dusun'         => $dusun,
                'mnj_desa'      => $mnj_desa,
                'action'        => site_url('kk/create'),
                'cencel'        => site_url('kk')
            ];
            return view('kk/kk_form', $data);
        } else {
            // dd($this->request->getVar());die;
            $validasi = $this->validate([
                'no_kk' => [
                    'rules' => 'required|numeric|min_length[16]|max_length[16]|is_unique[kartu_keluarga.no_kk]',
                    'errors' => [
                        'required' => 'Nomor kartu keluarga harus di isi',
                        'is_unique' => 'Nomor kartu keluarga sudah ada',
                        'min_length' => 'Nomor kartu keluarga minimal 16 angka',
                        'max_length' => 'Nomor kartu keluarga maximal 16 angka',
                        'numeric' => 'Nomor kartu keluarga harus berupa angka',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus di isi'
                    ]
                ],
                'rt' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'RT harus di isi',
                        'numeric' => 'RT harus di isi dengan angka'
                    ]
                ],
                'rw' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'RW harus di isi',
                        'numeric' => 'RW harus di isi dengan angka'
                    ]
                ],
                'desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Desa harus di isi'
                    ]
                ],
                'kecamatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kecamatan harus di isi'
                    ]
                ],
                'kabupaten' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kabupaten harus di isi'
                    ]
                ],
                'provinsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Provinsi harus di isi'
                    ]
                ],
                'kode_pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kode pos harus di isi'
                    ]
                ],
                'dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi'
                    ]
                ],
                'doc_kk' => [
                    'rules' => 'uploaded[doc_kk]|mime_in[doc_kk,image/jpg,image/jpeg,image/png]|max_size[doc_kk,4096]',
                    'errors' => [
                        'uploaded' => 'Harus Ada File yang diupload',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);

            if (!$validasi) {
                return redirect()->to('kk/create')->withInput();
            }


            $doc_kk     = $this->request->getFile('doc_kk');
            $filename   = $this->request->getVar('no_kk') . '.' . $doc_kk->guessExtension();

            $this->kk->save([
                'no_kk'         => $this->request->getVar('no_kk'),
                'alamat'        => $this->request->getVar('alamat'),
                'dusun'         => $this->request->getVar('dusun'),
                'rt'            => $this->request->getVar('rt'),
                'rw'            => $this->request->getVar('rw'),
                'desa'          => $this->request->getVar('desa'),
                'kecamatan'     => $this->request->getVar('kecamatan'),
                'kabupaten'     => $this->request->getVar('kabupaten'),
                'provinsi'      => $this->request->getVar('provinsi'),
                'kode_pos'      => $this->request->getVar('kode_pos'),
                'pencatat'      => session()->get('id_user'),
                'doc_kk'        => $filename,
                'timestamp'     => date('Y-m-d H:i:s'),
            ]);

            $doc_kk->move('images/kk', $filename);


            session()->setFlashdata('pesan', 'di tambah, silahkan tambahkan anggota keluarga');

            return redirect()->to('penduduk/create');
        }
    }


    public function update($id_kk)
    {

        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };

        $dusun = $this->db->table('dusun')->get()->getResultArray();
        $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');

        if ($this->request->getMethod() == 'post') {
            $data_lama = $this->kk->where(['id_kk' => param_decrypt($id_kk)])->first();

            if ($data_lama['no_kk'] == $this->request->getVar('no_kk')) {
                $ruleNoKK = 'required';
            } else {
                $ruleNoKK = 'required|numeric|min_length[16]|max_length[16]|is_unique[kartu_keluarga.no_kk]';
            }

            $validasi = $this->validate([
                'no_kk' => [
                    'rules' => $ruleNoKK,
                    'errors' => [
                        'required' => 'Nomor kartu keluarga harus di isi',
                        'is_unique' => 'Nomor kartu keluarga sudah ada',
                        'min_length' => 'Nomor kartu keluarga minimal 16 angka',
                        'max_length' => 'Nomor kartu keluarga maximal 16 angka',
                        'numeric' => 'Nomor kartu keluarga harus berupa angka',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus di isi'
                    ]
                ],
                'rt' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'RT harus di isi',
                        'numeric' => 'RT harus di isi dengan angka'
                    ]
                ],
                'rw' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'RW harus di isi',
                        'numeric' => 'RW harus di isi dengan angka'
                    ]
                ],
                'desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Desa harus di isi'
                    ]
                ],
                'kecamatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kecamatan harus di isi'
                    ]
                ],
                'kabupaten' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kabupaten harus di isi'
                    ]
                ],
                'provinsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Provinsi harus di isi'
                    ]
                ],
                'kode_pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kode pos harus di isi'
                    ]
                ],
                'dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dusun harus di isi'
                    ]
                ],
                'doc_kk' => [
                    'rules' => 'mime_in[doc_kk,image/jpg,image/jpeg,image/png]|max_size[doc_kk,4096]',
                    'errors' => [
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);


            if (!$validasi) {
                return redirect()->back()->withInput();
            } else {
                $doc_kk     = $this->request->getFile('doc_kk');
                $filename   = $this->request->getVar('no_kk') . '.' . $doc_kk->guessExtension();

                if (!$doc_kk->isValid()) {
                    $this->kk->save([
                        'id_kk'         => param_decrypt($this->request->getVar('id_kk')),
                        'no_kk'         => $this->request->getVar('no_kk'),
                        'alamat'        => $this->request->getVar('alamat'),
                        'dusun'         => $this->request->getVar('dusun'),
                        'rt'            => $this->request->getVar('rt'),
                        'rw'            => $this->request->getVar('rw'),
                        'desa'          => $this->request->getVar('desa'),
                        'kecamatan'     => $this->request->getVar('kecamatan'),
                        'kabupaten'     => $this->request->getVar('kabupaten'),
                        'provinsi'      => $this->request->getVar('provinsi'),
                        'kode_pos'      => $this->request->getVar('kode_pos'),
                        'pencatat'      => session()->get('id_user'),
                        'doc_kk'        => $data_lama['doc_kk'],
                        'updated'     => date('Y-m-d H:i:s'),
                    ]);
                    session()->setFlashdata('pesan', 'di ubah');
                    return redirect()->to('kk');
                } else {
                    @unlink('images/kk' . '/' . $data_lama['doc_kk']);

                    $this->kk->save([
                        'id_kk'         => param_decrypt($this->request->getVar('id_kk')),
                        'no_kk'         => $this->request->getVar('no_kk'),
                        'alamat'        => $this->request->getVar('alamat'),
                        'dusun'         => $this->request->getVar('dusun'),
                        'rt'            => $this->request->getVar('rt'),
                        'rw'            => $this->request->getVar('rw'),
                        'desa'          => $this->request->getVar('desa'),
                        'kecamatan'     => $this->request->getVar('kecamatan'),
                        'kabupaten'     => $this->request->getVar('kabupaten'),
                        'provinsi'      => $this->request->getVar('provinsi'),
                        'kode_pos'      => $this->request->getVar('kode_pos'),
                        'pencatat'      => session()->get('id_user'),
                        'doc_kk'        => $filename,
                        'updated'     => date('Y-m-d H:i:s'),
                    ]);

                    $doc_kk->move('images/kk', $filename);

                    session()->setFlashdata('pesan', 'di ubah');
                    return redirect()->to('kk');
                }
            }
        } else {
            $row = $this->kk->where('id_kk', param_decrypt($id_kk))->first();

            $data = [
                'judul'         => 'Edit Kartu Keluarga',
                'aktif'         => 'kartu_keluarga',
                'show'          => 'kependudukan',
                'id_kk'         => set_value('id_kk', $row['id_kk']),
                'no_kk'         => set_value('no_kk', $row['no_kk']),
                'alamat'        => set_value('alamat', $row['alamat']),
                'dusun'         => set_value('dusun', $row['dusun']),
                'rt'            => set_value('rt', $row['rt']),
                'rw'            => set_value('rw', $row['rw']),
                'desa'          => set_value('desa', $row['desa']),
                'kecamatan'     => set_value('kecamatan', $row['kecamatan']),
                'kabupaten'     => set_value('kabupaten', $row['kabupaten']),
                'provinsi'      => set_value('provinsi', $row['provinsi']),
                'kode_pos'      => set_value('kode_pos', $row['kode_pos']),
                'doc_kk'        => set_value('doc_kk', $row['doc_kk']),
                'validation'    => $this->validation,
                'uri' => service('uri'),
                'data_dusun'    => $dusun,
                'mnj_desa'      => $mnj_desa,
                'action'        => site_url('kk/update/' . $id_kk),
                'cencel'        => site_url('kk')
            ];

            return view('kk/kk_form', $data);
        }
    }

    public function delete($id_kk)
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };

        $data_lama = $this->kk->where(['id_kk' => $id_kk])->first();
        @unlink('images/kk' . '/' . $data_lama['doc_kk']);
        $this->kk->delete($id_kk);
        session()->setFlashdata('pesan', 'di hapus');
        return redirect()->to('kk');
    }


    function download($id)
    {
        $data = $this->kk->find($id);
        return $this->response->download('images/kk' . '/' . $data['doc_kk'], null);
    }

    function download_format()
    {
        return $this->response->download('template_import/tenplate_import_KK_dan_penduduk.xlsx', null);
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
            $id_dusun = $this->request->getVar('rw');
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

    public function viewKK($id)
    {
        $data['kk'] = $this->kk->select('doc_kk')->find(param_decrypt($id));
        return view('kk/kk_view', $data);
    }

    public function import()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };

        if ($this->request->getMethod() == 'get') {
            $data = [
                'judul'         => 'Import Kartu Keluarga',
                'aktif'         => 'kartu_keluarga',
                'show'          => 'kependudukan',
                'validation'    => $this->validation,
                'action'        => site_url('kk/import'),
                'cencel'        => site_url('kk')
            ];
            return view('kk/kk_import', $data);
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
                return redirect()->to('kk/import')->withInput();
            } else {
                $file = $this->request->getFile('fileimport');

                $ext = $file->getClientExtension();

                if ($ext == 'xls') {
                    $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else {
                    $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }

                $spreadsheet = $render->load($file);

                $data = $spreadsheet->getSheet(0)->toArray();

                $psn_error = [];
                $psn_kurang_16 = [];
                $psn_sukses = [];
                $jml_error = 0;
                $jml_kurang_16 = 0;
                $jml_sukses = 0;

                foreach ($data as $key => $value) {
                    if ($key == 0) {
                        continue;
                    }

                    $no_kk = $value[0];
                    $alamat = $value[1];
                    $dusun = $value[2];
                    $rt = $value[3];
                    $rw = $value[4];
                    $desa = $value[5];
                    $kecamatan = $value[6];
                    $kabupaten = $value[7];
                    $kode_pos = $value[8];
                    $provinsi = $value[9];
                    $pencatat = session()->get('id_user');
                    $doc_kk = $value[11];
                    $timestamp = $value[12];
                    $updated = $value[13];

                    $cek_no_kk = $this->db->table('kartu_keluarga')->getWhere(['no_kk' => $no_kk])->getResult();

                    $cek_digit = strlen($no_kk);

                    if ($cek_digit > 16 || $cek_digit < 16) {
                        $jml_kurang_16++;
                        $psn_kurang_16[] = 'Nomor KK : ' . $no_kk . ' kurang atau lebih dari 16 digit <br>';
                    } else if (count($cek_no_kk) > 0 || $no_kk == '') {
                        $jml_error++;

                        $psn_error[] = 'Nomor KK : ' . $no_kk . ' sudah ada <br>';
                    } else {
                        $data_simpan = [
                            'no_kk' => $no_kk,
                            'alamat' => $alamat,
                            'dusun' => $dusun,
                            'rt' => $rt,
                            'rw' => $rw,
                            'desa' => $desa,
                            'kecamatan' => $kecamatan,
                            'kabupaten' => $kabupaten,
                            'kode_pos' => $kode_pos,
                            'provinsi' => $provinsi,
                            'pencatat' => $pencatat,
                            'doc_kk' => $doc_kk,
                            'timestamp' => $timestamp,
                            'updated' => $updated
                        ];

                        $this->db->table('kartu_keluarga')->insert($data_simpan);
                        $jml_sukses++;

                        $psn_sukses[] = 'Nomor KK : ' . $no_kk . ' berhasil di simpan <br>';
                    }
                }

                foreach ($psn_kurang_16 as $key) {
                    $show_kurang_16[] = $key;
                }

                foreach ($psn_error as $key) {
                    $show_error[] = $key;
                }

                foreach ($psn_sukses as $key) {
                    $show_sukses[] = $key;
                }
            }


            if ($jml_sukses > 0) {
                session()->setFlashdata('pesan', '<b>' . $jml_sukses . ' KK berhasil disimpan</b> <br><br>');
                session()->setFlashdata('show_sukses', $show_sukses);
            }

            if ($jml_error > 0) {
                session()->setFlashdata('error', '<b>' . $jml_error . ' KK gagal disimpan (No KK Sudah Ada)</b><br><br>');
                session()->setFlashdata('show_error', $show_error);
            }

            if ($jml_kurang_16 > 0) {
                session()->setFlashdata('jml_kurang_16', '<b>' . $jml_kurang_16 . ' KK gagal disimpan (No KK Kurang atau Lebih dari 16 digit)</b> <br><br>');
                session()->setFlashdata('show_kurang_16', $show_kurang_16);
            }

            return redirect()->to('kk/import');
        }
    }

    public function import_foto_kk()
    {
        if (allow_access() == true) {
            session()->setFlashdata('not_allowed', 'SK anda sudah expired! Silahkan Hubungi Admin desa untuk perpanjangan SK');
            return redirect()->to(site_url($this->request->uri->getSegment(1)));
        };

        if ($this->request->getMethod() == 'get') {
            $data = [
                'judul'         => 'Import Foto Kartu Keluarga',
                'aktif'         => 'kartu_keluarga',
                'show'          => 'kependudukan',
                'validation'    => $this->validation,
                'action'        => site_url('kk/import_foto_kk'),
                'cencel'        => site_url('kk')
            ];
            return view('kk/kk_import_foto', $data);
        } else {

            $jml_sukses = 0;
            $jml_error = 0;
            $jml_not_png = 0;
            $psn_sukses = [];
            $psn_error = [];
            $psn_not_png = [];

            $validasi = $this->validate([

                'foto_kk' => [
                    'rules' => 'uploaded[foto_kk]|mime_in[foto_kk,image/jpg,image/jpeg,image/png]|max_size[foto_kk,4096]',
                    'errors' => [
                        'uploaded' => 'Harus ada file yang di pilih',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ],
            ]);


            if (!$validasi) {
                return redirect()->to('kk/import_foto_kk')->withInput();
            } else {
                $files = $this->request->getFiles();
                foreach ($files['foto_kk'] as $img) {
                    if ($img->getClientExtension() == 'png') {
                        $nama_foto = substr($img->getName(), 0, 16);
                        $cek_foto = $this->db->table('kartu_keluarga')->getWhere(['no_kk' => $nama_foto])->getFirstRow('array');

                        if ($cek_foto != null) {
                            if ($nama_foto == $cek_foto['no_kk']) {
                                @unlink('images/kk' . '/' . $cek_foto['doc_kk']);
                                $valid_name = $img->getName();
                                if ($img->isValid() && !$img->hasMoved()) {
                                    $img->move('images/kk', $valid_name);
                                    $jml_sukses++;

                                    $psn_sukses[] = 'Foto ' . $valid_name . ' Berhasil di upload!';
                                }
                                // print_r($cek_foto['no_kk']);
                            }
                        } else {
                            $error_name = $img->getName();
                            $jml_error++;

                            $psn_error[] = 'Foto ' . $error_name . ' Gagal di Upload (no_kk tidak sesuai)';
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
                session()->setFlashdata('pesan', '<b>' . $jml_sukses . ' Foto Kartu Keluarga berhasil disimpan</b> <br><br>');
                session()->setFlashdata('show_sukses', $show_sukses);
            }
            if ($jml_error > 0) {
                session()->setFlashdata('error', '<b>' . $jml_error . ' Foto Kartu Keluarga gagal disimpan</b> <br><br>');
                session()->setFlashdata('show_error', $show_error);
            }
            if ($jml_not_png > 0) {
                session()->setFlashdata('not_png', '<b>' . $jml_not_png . ' Foto Kartu Keluarga gagal disimpan</b> <br><br>');
                session()->setFlashdata('show_not_png', $show_not_png);
            }

            return redirect()->to('kk/import_foto_kk');
        }
    }
}
