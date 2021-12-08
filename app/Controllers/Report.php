<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Report extends BaseController
{
    protected $db;
    protected $kk;
    protected $validation;
    public function __construct()
    {

        $this->db      = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {

        // query dusun
        $dusun = $this->db->table('dusun')->get()->getResultArray();

        $rt = $this->db->table('rt')->get()->getResultArray();

        $tahun = $this->db->table('penduduk')->select('year(timestamp) as tahun')->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

        $data = [
            'judul' => 'Report',
            'show'  => 'report',
            'aktif' => 'report_penduduk',
            'swal' => 'Report',
            'dusun' => $dusun,
            'rt' => $rt,
            'tahun' => $tahun,
            'validation'    => $this->validation,
        ];

        return view('report/report_select', $data);
    }

    public function report_desa()
    {
        $tahun = $this->db->table('penduduk')->select('year(timestamp) as tahun')->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

        $penduduk = $this->db->query("SELECT dusun.dusun, count(id_penduduk) as penduduk FROM penduduk RIGHT JOIN kartu_keluarga USING(id_kk) RIGHT JOIN dusun ON dusun.id_dusun=kartu_keluarga.dusun group by dusun.id_dusun order by dusun ASC")->getResultArray();
        $total = $this->db->query("SELECT * FROM penduduk")->getNumRows();


        $data = [
            'judul' => 'Report Desa',
            'show'  => 'report',
            'aktif' => 'report_desa',
            'swal' => 'Report',
            'chart' => $penduduk,
            'total' => $total,
            'tahun' => $tahun,
            'validation'    => $this->validation,
        ];

        return view('report/desa/report_select', $data);
    }

    public function report_desa_cetak()
    {
        $tahun = $this->request->getVar('tahun');
        if ($tahun != '') {
            // dd($dusun);die;
            // query manajemen desa
            $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');

            // query total penduduk
            $total = $this->db->query("SELECT COUNT(id_penduduk) AS total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE YEAR(penduduk.timestamp) = $tahun GROUP BY YEAR(penduduk.timestamp)")->getRow();

            // query jenis kelamin
            $lk = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'L' AND YEAR(penduduk.timestamp) = $tahun GROUP BY YEAR(penduduk.timestamp)")->getRow();

            $pr = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'P' AND YEAR(penduduk.timestamp) = $tahun GROUP BY YEAR(penduduk.timestamp)")->getRow();

            $dusun = $this->db->query("SELECT id_dusun, dusun, id_rw FROM dusun")->getResultArray();
            $rt = $this->db->query("SELECT id_rt, no_rt, id_rw FROM rt")->getResultArray();
            $jk = $this->db->query("SELECT jenis_kelamin FROM penduduk GROUP BY jenis_kelamin ORDER BY jenis_kelamin DESC")->getResultArray();
            $penduduk = $this->db->query("SELECT * FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE YEAR(penduduk.timestamp) = $tahun")->getResultArray();

            $data_umur = [
                "BETWEEN 0 AND 3",
                "BETWEEN 4 AND 6",
                "BETWEEN 7 AND 12",
                "BETWEEN 13 AND 15",
                "BETWEEN 16 AND 18",
                "> 19",
                "BETWEEN 10 AND 14",
                "BETWEEN 15 AND 19",
                "BETWEEN 20 AND 26",
                "BETWEEN 27 AND 40",
                "BETWEEN 41 AND 58",
                "> 59"
            ];

            foreach ($data_umur as $key) {
                $umur[] = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) $key AND YEAR(penduduk.timestamp) = $tahun GROUP BY YEAR(penduduk.timestamp)")->getRow();
            }

            $data_pekerjaan = [
                "Petani/Pekebun",
                "Buruh Tani/Perkebunan",
                "Pegawai Negeri Sipil",
                "Tentara Nasional Indonesia",
                "Kepolisian Ri",
                "Karyawan Swasta",
                "Pedagang",
                "Wiraswasta",
                "Pensiunan",
                "Buruh Harian Lepas",
                "Peternak",
                "Sopir",
                "Industri",
                "Lainnya"
            ];

            foreach ($data_pekerjaan as $key) {
                $pekerjaan[] = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = '$key' AND YEAR(penduduk.timestamp) = $tahun GROUP BY YEAR(penduduk.timestamp)")->getRow();
            }


            // 


            $data = [
                'judul' => 'Report Data Penduduk',
                'show'  => '',
                'aktif' => '',
                'judul1' => 'Data Penduduk Berdasarkan Jenis Kelamin',
                'judul2' => 'Data Penduduk Berdasarkan Kelompok Umur',
                'judul3' => 'Data Penduduk Berdasarkan Jenis Pekerjaan',
                'judul4' => 'Data Penduduk Berdasarkan Dusun dan RT',
                'mnj_desa' => $mnj_desa,
                'total' => $total,
                'tahun' => $tahun,
                'lk' => $lk,
                'pr' => $pr,
                'umur' => $umur,
                'pekerjaan' => $pekerjaan,
                'dusun' => $dusun,
                'rt' => $rt,
                'jk' => $jk,
                'penduduk' => $penduduk,

            ];

            // dd($data);die;
            return view('report/desa/report_cetak', $data);
        } else {
            $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');

            // query total penduduk
            $total = $this->db->query("SELECT COUNT(id_penduduk) AS total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk)")->getRow();

            // query jenis kelamin
            $lk = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'L'")->getRow();

            $pr = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'P'")->getRow();

            $dusun = $this->db->query("SELECT id_dusun, dusun, id_rw FROM dusun")->getResultArray();
            $rt = $this->db->query("SELECT id_rt, no_rt, id_rw FROM rt")->getResultArray();
            $jk = $this->db->query("SELECT jenis_kelamin FROM penduduk GROUP BY jenis_kelamin ORDER BY jenis_kelamin DESC")->getResultArray();
            $penduduk = $this->db->query("SELECT * FROM penduduk INNER JOIN kartu_keluarga USING(id_kk)")->getResultArray();

            $data_umur = [
                "BETWEEN 0 AND 3",
                "BETWEEN 4 AND 6",
                "BETWEEN 7 AND 12",
                "BETWEEN 13 AND 15",
                "BETWEEN 16 AND 18",
                "> 19",
                "BETWEEN 10 AND 14",
                "BETWEEN 15 AND 19",
                "BETWEEN 20 AND 26",
                "BETWEEN 27 AND 40",
                "BETWEEN 41 AND 58",
                "> 59"
            ];

            foreach ($data_umur as $key) {
                $umur[] = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) $key AND dusun=10")->getRow();
            }

            $data_pekerjaan = [
                "Petani/Pekebun",
                "Buruh Tani/Perkebunan",
                "Pegawai Negeri Sipil",
                "Tentara Nasional Indonesia",
                "Kepolisian Ri",
                "Karyawan Swasta",
                "Pedagang",
                "Wiraswasta",
                "Pensiunan",
                "Buruh Harian Lepas",
                "Peternak",
                "Sopir",
                "Industri",
                "Lainnya"
            ];

            foreach ($data_pekerjaan as $key) {
                $pekerjaan[] = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = '$key' AND dusun=10")->getRow();
            }


            // 


            $data = [
                'judul' => 'Report Data Penduduk',
                'show'  => '',
                'aktif' => '',
                'judul1' => 'Data Penduduk Berdasarkan Jenis Kelamin',
                'judul2' => 'Data Penduduk Berdasarkan Kelompok Umur',
                'judul3' => 'Data Penduduk Berdasarkan Jenis Pekerjaan',
                'judul4' => 'Data Penduduk Berdasarkan Dusun dan RT',
                'mnj_desa' => $mnj_desa,
                'total' => $total,
                'tahun' => $tahun,
                'lk' => $lk,
                'pr' => $pr,
                'umur' => $umur,
                'pekerjaan' => $pekerjaan,
                'dusun' => $dusun,
                'rt' => $rt,
                'jk' => $jk,
                'penduduk' => $penduduk,

            ];

            // dd($data);die;
            return view('report/desa/report_cetak', $data);
        }
    }

    public function report_dusun()
    {
        // query dusun
        $dusun = $this->db->table('dusun')->get()->getResultArray();

        $chart_kematian = $this->db->query("SELECT dusun.dusun, COUNT(id_kematian) AS kematian FROM peristiwa_kematian RIGHT JOIN penduduk USING(id_penduduk) RIGHT JOIN kartu_keluarga USING(id_kk) RIGHT JOIN dusun ON kartu_keluarga.dusun=dusun.id_dusun GROUP BY dusun.id_dusun")->getResultArray();
        $chart_pindah = $this->db->query("SELECT dusun.dusun, COUNT(id_pindah) AS pindah FROM mutasi_pindah RIGHT JOIN penduduk USING(id_penduduk) RIGHT JOIN kartu_keluarga USING(id_kk) RIGHT JOIN dusun ON kartu_keluarga.dusun=dusun.id_dusun GROUP BY dusun.id_dusun")->getResultArray();
        $chart_datang = $this->db->query("SELECT dusun.dusun, COUNT(id_datang) AS datang FROM mutasi_datang RIGHT JOIN dusun ON mutasi_datang.dusun_domisili=dusun.id_dusun GROUP BY dusun.dusun")->getResultArray();
        $chart_lahir = $this->db->query("SELECT dusun.dusun, COUNT(id_lahir) AS lahir FROM peristiwa_lahir RIGHT JOIN dusun ON peristiwa_lahir.dusun_ortu=dusun.id_dusun GROUP BY dusun.dusun")->getResultArray();

        $tahun = $this->db->table('penduduk')->select('year(timestamp) as tahun')->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

        $total_datang = $this->db->query("SELECT * FROM mutasi_datang")->getNumRows();
        $total_pindah = $this->db->query("SELECT * FROM mutasi_pindah")->getNumRows();
        $total_lahir = $this->db->query("SELECT * FROM peristiwa_lahir")->getNumRows();
        $total_kematian = $this->db->query("SELECT * FROM peristiwa_kematian")->getNumRows();

        $data = [
            'judul' => 'Report Dusun',
            'show'  => 'report',
            'aktif' => 'report_dusun',
            'swal' => 'Report Dusun',
            'dusun' => $dusun,
            'tahun' => $tahun,
            'total_datang' => $total_datang,
            'total_pindah' => $total_pindah,
            'total_lahir' => $total_lahir,
            'total_kematian' => $total_kematian,
            'chart_kematian' => $chart_kematian,
            'chart_pindah' => $chart_pindah,
            'chart_datang' => $chart_datang,
            'chart_lahir' => $chart_lahir,
            'validation'    => $this->validation,
        ];

        return view('report/dusun/report_select', $data);
    }

    public function report_dusun_cetak()
    {
        $dusun = $this->request->getVar('dusun');
        $tahun = $this->request->getVar('tahun');

        if ($tahun != "") {
            $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');

            $pendatang = $this->db->query("SELECT * FROM mutasi_datang INNER JOIN pendatang WHERE YEAR(TIMESTAMP) = $tahun AND dusun_domisili = $dusun")->getResultArray();

            // query total penduduk
            $total = $this->db->query("SELECT COUNT(id_penduduk) AS total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk)")->getRow();

            $pindah = $this->db->query("SELECT * FROM mutasi_pindah INNER JOIN penduduk USING(id_penduduk) INNER JOIN kartu_keluarga USING(id_kk) WHERE dusun = $dusun AND YEAR(mutasi_pindah.timestamp) = $tahun ")->getResultArray();

            $lahir = $this->db->query("SELECT * FROM peristiwa_lahir INNER JOIN pendatang WHERE YEAR(TIMESTAMP) = $tahun AND dusun_ortu = $dusun ")->getResultArray();

            $kematian = $this->db->query("SELECT * FROM peristiwa_kematian INNER JOIN penduduk USING(id_penduduk) INNER JOIN kartu_keluarga USING(id_kk) WHERE dusun = $dusun AND YEAR(peristiwa_kematian.timestamp) = $tahun ")->getResultArray();

            // query total penduduk
            $total = $this->db->query("SELECT COUNT(id_penduduk) AS total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE YEAR(penduduk.timestamp) = $tahun AND dusun=$dusun AND YEAR(penduduk.timestamp) = $tahun GROUP BY YEAR(penduduk.timestamp)")->getRow();

            // query jenis kelamin
            $lk = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'L' AND YEAR(penduduk.timestamp) = $tahun AND dusun=$dusun GROUP BY YEAR(penduduk.timestamp)")->getRow();

            $pr = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'P' AND YEAR(penduduk.timestamp) = $tahun  AND dusun=$dusun GROUP BY YEAR(penduduk.timestamp)")->getRow();

            $rt = $this->db->query("SELECT id_rt, no_rt, id_rw FROM rt")->getResultArray();

            $jk = $this->db->query("SELECT jenis_kelamin FROM penduduk GROUP BY jenis_kelamin ORDER BY jenis_kelamin DESC")->getResultArray();
            $penduduk = $this->db->query("SELECT * FROM penduduk INNER JOIN kartu_keluarga USING(id_kk)")->getResultArray();

            $data_umur = [
                "BETWEEN 0 AND 3",
                "BETWEEN 4 AND 6",
                "BETWEEN 7 AND 12",
                "BETWEEN 13 AND 15",
                "BETWEEN 16 AND 18",
                "> 19",
                "BETWEEN 10 AND 14",
                "BETWEEN 15 AND 19",
                "BETWEEN 20 AND 26",
                "BETWEEN 27 AND 40",
                "BETWEEN 41 AND 58",
                "> 59"
            ];

            foreach ($data_umur as $key) {
                $umur[] = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) $key AND YEAR(penduduk.timestamp) = $tahun AND dusun = $dusun GROUP BY YEAR(penduduk.timestamp)")->getRow();
            }

            $data_pekerjaan = [
                "Petani/Pekebun",
                "Buruh Tani/Perkebunan",
                "Pegawai Negeri Sipil",
                "Tentara Nasional Indonesia",
                "Kepolisian Ri",
                "Karyawan Swasta",
                "Pedagang",
                "Wiraswasta",
                "Pensiunan",
                "Buruh Harian Lepas",
                "Peternak",
                "Sopir",
                "Industri",
                "Lainnya"
            ];

            foreach ($data_pekerjaan as $key) {
                $pekerjaan[] = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = '$key' AND YEAR(penduduk.timestamp) = $tahun AND dusun = $dusun GROUP BY YEAR(penduduk.timestamp)")->getRow();
            }


            $data = [
                'judul' => 'Report Data Penduduk',
                'show'  => '',
                'aktif' => '',
                'judul1' => 'Data Kelahiran',
                'judul2' => 'Data Kematian',
                'judul3' => 'Data Pendatang',
                'judul4' => 'Data Pindah Alamat',
                'mnj_desa' => $mnj_desa,
                'tahun' => $tahun,
                'pendatang' => $pendatang,
                'pindah' => $pindah,
                'lahir' => $lahir,
                'total' => $total,
                'lk' => $lk,
                'pr' => $pr,
                'umur' => $umur,
                'dusun' => $dusun,
                'rt' => $rt,
                'jk' => $jk,
                'penduduk' => $penduduk,
                'pekerjaan' => $pekerjaan,
                'total' => $total,
                'kematian' => $kematian,
            ];

            // dd($data);die;
            return view('report/dusun/report_cetak', $data);
        } else {

            $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');

            $pendatang = $this->db->query("SELECT * FROM mutasi_datang INNER JOIN pendatang WHERE dusun_domisili = $dusun")->getResultArray();

            // query total penduduk
            $total = $this->db->query("SELECT COUNT(id_penduduk) AS total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk)")->getRow();

            $pindah = $this->db->query("SELECT * FROM mutasi_pindah INNER JOIN penduduk USING(id_penduduk) INNER JOIN kartu_keluarga USING(id_kk) WHERE dusun = $dusun")->getResultArray();

            $lahir = $this->db->query("SELECT * FROM peristiwa_lahir INNER JOIN pendatang WHERE dusun_ortu = $dusun")->getResultArray();

            $kematian = $this->db->query("SELECT * FROM peristiwa_kematian INNER JOIN penduduk USING(id_penduduk) INNER JOIN kartu_keluarga USING(id_kk) WHERE dusun = $dusun")->getResultArray();

            // query jenis kelamin
            $lk = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'L' AND dusun=$dusun")->getRow();

            $pr = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin = 'P' AND dusun=$dusun")->getRow();

            $rt = $this->db->query("SELECT id_rt, no_rt, id_rw FROM rt")->getResultArray();

            $jk = $this->db->query("SELECT jenis_kelamin FROM penduduk GROUP BY jenis_kelamin ORDER BY jenis_kelamin DESC")->getResultArray();
            $penduduk = $this->db->query("SELECT * FROM penduduk INNER JOIN kartu_keluarga USING(id_kk)")->getResultArray();

            $data_umur = [
                "BETWEEN 0 AND 3",
                "BETWEEN 4 AND 6",
                "BETWEEN 7 AND 12",
                "BETWEEN 13 AND 15",
                "BETWEEN 16 AND 18",
                "> 19",
                "BETWEEN 10 AND 14",
                "BETWEEN 15 AND 19",
                "BETWEEN 20 AND 26",
                "BETWEEN 27 AND 40",
                "BETWEEN 41 AND 58",
                "> 59"
            ];

            foreach ($data_umur as $key) {
                $umur[] = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) $key AND dusun = $dusun")->getRow();
            }
            $data_pekerjaan = [
                "Petani/Pekebun",
                "Buruh Tani/Perkebunan",
                "Pegawai Negeri Sipil",
                "Tentara Nasional Indonesia",
                "Kepolisian Ri",
                "Karyawan Swasta",
                "Pedagang",
                "Wiraswasta",
                "Pensiunan",
                "Buruh Harian Lepas",
                "Peternak",
                "Sopir",
                "Industri",
                "Lainnya"
            ];

            foreach ($data_pekerjaan as $key) {
                $pekerjaan[] = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = '$key' AND dusun = $dusun")->getRow();
            }

            $data = [
                'judul' => 'Report Data Penduduk',
                'show'  => '',
                'aktif' => '',
                'judul1' => 'Data Kelahiran',
                'judul2' => 'Data Kematian',
                'judul3' => 'Data Pendatang',
                'judul4' => 'Data Pindah Alamat',
                'mnj_desa' => $mnj_desa,
                'tahun' => $tahun,
                'pendatang' => $pendatang,
                'pindah' => $pindah,
                'lahir' => $lahir,
                'lk' => $lk,
                'pr' => $pr,
                'umur' => $umur,
                'dusun' => $dusun,
                'rt' => $rt,
                'jk' => $jk,
                'penduduk' => $penduduk,
                'pekerjaan' => $pekerjaan,
                'total' => $total,
                'kematian' => $kematian,

            ];

            // dd($data);die;
            return view('report/dusun/report_cetak', $data);
        }
    }

    public function report_rt()
    {
        // query dusun
        $dusun = $this->db->table('dusun')->get()->getResultArray();

        $rt = $this->db->table('rt')->get()->getResultArray();

        $tahun = $this->db->table('penduduk')->select('year(timestamp) as tahun')->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

        $chart_laki_laki = $this->db->query("SELECT dusun.dusun, COUNT(jenis_kelamin) AS laki_laki FROM penduduk RIGHT JOIN kartu_keluarga using(id_kk) RIGHT JOIN dusun ON kartu_keluarga.dusun=dusun.id_dusun WHERE jenis_kelamin='L' GROUP BY dusun.dusun")->getResultArray();

        $chart_perempuan = $this->db->query("SELECT dusun.dusun, COUNT(jenis_kelamin) AS perempuan FROM penduduk RIGHT JOIN kartu_keluarga using(id_kk) RIGHT JOIN dusun ON kartu_keluarga.dusun=dusun.id_dusun WHERE jenis_kelamin='P' GROUP BY dusun.dusun")->getResultArray();

        $data = [
            'judul' => 'Report RT',
            'show'  => 'report',
            'aktif' => 'report_rt',
            'swal' => 'Report RT',
            'dusun' => $dusun,
            'rt' => $rt,
            'tahun' => $tahun,
            'chart_laki_laki' => $chart_laki_laki,
            'chart_perempuan' => $chart_perempuan,
            'validation'    => $this->validation,
        ];

        return view('report/rt/report_select', $data);
    }

    public function report_rt_cetak()
    {
        $dusun = $this->request->getVar('dusun');
        $rt = $this->request->getVar('rt');
        $tahun = $this->request->getVar('tahun');

        $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');

        // query dusun
        // $dusun = $this->db->table('dusun')->get()->getResultArray();

        // $rt = $this->db->table('rt')->get()->getResultArray();

        // $nama_kk = $this->db->query("SELECT id_kk, nama_lengkap, hubungan_keluarga, jenis_kelamin FROM penduduk where hubungan_keluarga='Kepala Keluarga'")->getResultArray();

        // $hubungan = $this->db->query("SELECT hubungan_keluarga FROM penduduk GROUP BY hubungan_keluarga ORDER BY hubungan_keluarga DESC")->getResultArray();

        // $jk = $this->db->query("SELECT jenis_kelamin FROM penduduk GROUP BY jenis_kelamin ORDER BY jenis_kelamin DESC")->getResultArray();

        // $penduduk = $this->db->query("SELECT id_kk, nama_lengkap, hubungan_keluarga, jenis_kelamin FROM penduduk")->getResultArray();

        $data = [
            'judul' => 'Report RT',
            'show'  => 'report',
            'aktif' => 'report_rt',
            'swal' => 'Report RT',
            'mnj_desa' => $mnj_desa,
            'dusun' => $dusun,
            'rt' => $rt,
            'tahun' => $tahun,
            'validation'    => $this->validation,
            // 'nama_kk' => $nama_kk,
            // 'hubungan' => $hubungan,
            // 'penduduk' => $penduduk,
            // 'jk' => $jk,
        ];

        return view('report/rt/report_cetak', $data);
    }

    public function report_penduduk()
    {
        $dusun = $this->db->table('dusun')->get()->getResultArray();

        $rt = $this->db->table('rt')->get()->getResultArray();

        $tahun = $this->db->table('penduduk')->select('year(timestamp) as tahun')->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

        $total = $this->db->query("SELECT COUNT(id_penduduk) AS total FROM penduduk INNER JOIN kartu_keluarga USING(id_kk)")->getRowArray();

        $penduduk = $this->db->table('penduduk')->select('COUNT(id_penduduk) AS total, YEAR(TIMESTAMP) AS tahun')->groupBy('YEAR(timestamp)')->limit(5)->get()->getResultArray();

        $data = [
            'judul' => 'Report Penduduk',
            'show'  => 'report',
            'aktif' => 'report_penduduk',
            'swal' => 'Report Penduduk',
            'dusun' => $dusun,
            'rt' => $rt,
            'tahun' => $tahun,
            'penduduk' => $penduduk,
            'total' => $total,
            'validation'    => $this->validation,
        ];

        return view('report/penduduk/report_select', $data);
    }

    public function report_penduduk_cetak()
    {
        $dusun = $this->request->getVar('dusun');
        $rt = $this->request->getVar('rt');
        $tahun = $this->request->getVar('tahun');

        $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');
        if ($dusun == '' and $rt == '' and $tahun == '') {

            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->where('peristiwa_kematian.id_penduduk is null')->get()->getResultArray();


            $data = [
                'judul' => 'Report Penduduk Per Desa',
                'show'  => 'report',
                'aktif' => 'report_penduduk',
                'swal' => 'Report Penduduk',
                'mnj_desa' => $mnj_desa,
                'dusun' => $dusun,
                'rt' => $rt,
                'tahun' => $tahun,
                'penduduk' => $penduduk,
                'validation'    => $this->validation,
            ];
        }else if ($rt == '' and $tahun == '') {
            $where = 'peristiwa_kematian.id_penduduk is null and dusun =' . $dusun;
            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->where($where)->get()->getResultArray();


            $data = [
                'judul' => 'Report Penduduk Per Dusun',
                'show'  => 'report',
                'aktif' => 'report_penduduk',
                'swal' => 'Report Penduduk',
                'mnj_desa' => $mnj_desa,
                'dusun' => $dusun,
                'rt' => $rt,
                'tahun' => $tahun,
                'penduduk' => $penduduk,
                'validation'    => $this->validation,
            ];
        } else if ($tahun == '') {
            $where = 'peristiwa_kematian.id_penduduk is null and dusun =' . $dusun . ' and rt =' . $rt;
            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->where($where)->get()->getResultArray();


            $data = [
                'judul' => 'Report Penduduk Per RT',
                'show'  => 'report',
                'aktif' => 'report_penduduk',
                'swal' => 'Report Penduduk',
                'mnj_desa' => $mnj_desa,
                'dusun' => $dusun,
                'rt' => $rt,
                'tahun' => $tahun,
                'penduduk' => $penduduk,
                'validation'    => $this->validation,
            ];
        }else {
            $where = 'peristiwa_kematian.id_penduduk is null and dusun =' . $dusun . ' and rt =' . $rt . ' and year(penduduk.timestamp) =' . $tahun;
            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->where($where)->get()->getResultArray();


            $data = [
                'judul' => 'Report Data Penduduk',
                'show'  => 'report',
                'aktif' => 'report_penduduk',
                'swal' => 'Report Penduduk',
                'mnj_desa' => $mnj_desa,
                'dusun' => $dusun,
                'rt' => $rt,
                'tahun' => $tahun,
                'penduduk' => $penduduk,
                'validation'    => $this->validation,
            ];
        }

        return view('report/penduduk/report_cetak', $data);
    }

    public function report_penduduk_export(){
        $dusun = $this->request->getVar('dusun');
        $rt = $this->request->getVar('rt');
        $tahun = $this->request->getVar('tahun');

        if ($dusun == '' and $rt == '' and $tahun == '') {

            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->where('peristiwa_kematian.id_penduduk is null')->get()->getResultArray();

        } else if ($rt == '' and $tahun == '') {
            $where = 'peristiwa_kematian.id_penduduk is null and dusun =' . $dusun;
            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->where($where)->get()->getResultArray();

        } else if ($tahun == '') {
            $where = 'peristiwa_kematian.id_penduduk is null and dusun =' . $dusun . ' and rt =' . $rt;
            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->where($where)->get()->getResultArray();

        } else {
            $where = 'peristiwa_kematian.id_penduduk is null and dusun =' . $dusun . ' and rt =' . $rt . ' and year(penduduk.timestamp) =' . $tahun;
            $penduduk = $this->db->table('penduduk')->select('nik, nama_lengkap, alamat, dusun, rt, rw, tempat_lahir, tanggal_lahir, timestampdiff(year, tanggal_lahir, curdate()) as usia, jenis_kelamin, agama, status_perkawinan, hubungan_keluarga, jenis_pekerjaan')->join('peristiwa_kematian', 'peristiwa_kematian.id_penduduk = penduduk.id_penduduk', 'left')->join('kartu_keluarga', 'penduduk.id_kk = kartu_keluarga.id_kk')->where($where)->get()->getResultArray();

        }

        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NIK')
            ->setCellValue('B1', 'Nama Lengkap')
            ->setCellValue('C1', 'Alamat')
            ->setCellValue('D1', 'Dusun')
            ->setCellValue('E1', 'Rt')
            ->setCellValue('F1', 'Rw')
            ->setCellValue('G1', 'Tempat Tanggal Lahir')
            ->setCellValue('H1', 'Usia')
            ->setCellValue('I1', 'Kelamin')
            ->setCellValue('J1', 'Agama')
            ->setCellValue('K1', 'Status Perkawinan')
            ->setCellValue('L1', 'Hubungan Keluarga')
            ->setCellValue('M1', 'Pekerjaan');

        $column = 2;
        // tulis data mobil ke cell
        foreach ($penduduk as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, "'" . $data['nik'])
                ->setCellValue('B' . $column, $data['nama_lengkap'])
                ->setCellValue('C' . $column, $data['alamat'])
                ->setCellValue('D' . $column, $data['dusun'])
                ->setCellValue('E' . $column, $data['rt'])
                ->setCellValue('F' . $column, $data['rw'])
                ->setCellValue('G' . $column, $data['tempat_lahir'] . ', ' . $data['tanggal_lahir'])
                ->setCellValue('H' . $column, $data['usia'])
                ->setCellValue('I' . $column, ($data['jenis_kelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan')
                ->setCellValue('J' . $column, $data['agama'])
                ->setCellValue('K' . $column, $data['status_perkawinan'])
                ->setCellValue('L' . $column, $data['hubungan_keluarga'])
                ->setCellValue('M' . $column, $data['jenis_pekerjaan']);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Penduduk';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function getRt()
    {
        if ($this->request->isAJAX()) {
            $id_dusun = $this->request->getVar('dusun');
            $dusun = $this->db->table('dusun')->where('id_dusun', $id_dusun)->get()->getFirstRow('array');
            $isidata = '<option selected value="">~~ Pilih ~~</option>';

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
}

        // query kelompok umur sekolah
        // $nol_3 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 3 AND dusun = $dusun GROUP BY dusun")->getRow();

        // $empat_6 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 4 AND 6 AND dusun = $dusun GROUP BY dusun")->getRow();

        // $tujuh_12 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 7 AND 12 AND dusun = $dusun GROUP BY dusun")->getRow();

        // $tigabelas_15 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 15 AND dusun = $dusun GROUP BY dusun")->getRow();

        // $enambelas_18 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 16 AND 18 AND dusun = $dusun GROUP BY dusun")->getRow();

        // $lebihdari_19 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 19 AND dusun = $dusun GROUP BY dusun")->getRow();

        // // query kelompok usia bekerja
        // $sepuluh_14 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan <> 'Belum/Tidak Bekerja' AND jenis_pekerjaan <> 'Pelajar/Mahasiswa' AND TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 10 AND 14 AND dusun = $dusun")->getRow();

        // $limabelas_19 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan <> 'Belum/Tidak Bekerja' AND jenis_pekerjaan <> 'Pelajar/Mahasiswa' AND TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 19 AND dusun = $dusun")->getRow();

        // $duapuluh_26 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan <> 'Belum/Tidak Bekerja' AND jenis_pekerjaan <> 'Pelajar/Mahasiswa' AND TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 26 AND dusun = $dusun")->getRow();

        // $duatujuh_40 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan <> 'Belum/Tidak Bekerja' AND jenis_pekerjaan <> 'Pelajar/Mahasiswa' AND TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 27 AND 40 AND dusun = $dusun")->getRow();

        // $empatsatu_58 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan <> 'Belum/Tidak Bekerja' AND jenis_pekerjaan <> 'Pelajar/Mahasiswa' AND TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 41 AND 58 AND dusun = $dusun")->getRow();

        // $lebihdari_59 = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan <> 'Belum/Tidak Bekerja' AND jenis_pekerjaan <> 'Pelajar/Mahasiswa' AND TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 59 AND dusun = $dusun")->getRow();


        // 'nol_3' => $nol_3,
            // 'empat_6' => $empat_6,
            // 'tujuh_12' => $tujuh_12,
            // 'tigabelas_15' => $tigabelas_15,
            // 'enambelas_18' => $enambelas_18,
            // 'lebihdari_19' => $lebihdari_19,
            // 'sepuluh_14' => $sepuluh_14,
            // 'limabelas_19' => $limabelas_19,
            // 'duapuluh_26' => $duapuluh_26,
            // 'duatujuh_40' => $duatujuh_40,
            // 'empatsatu_58' => $empatsatu_58,
            // 'lebihdari_59' => $lebihdari_59,


            // query jenis pekerjaan
        // $petani = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Petani/Pekebun' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $buruh_tani = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Buruh Tani/Perkebunan' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $pns = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Pegawai Negeri Sipil' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $tni = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Tentara Nasional Indonesia' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $polisi = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Kepolisian Ri' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $karyawan_swasta = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Karyawan Swasta' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $pedagang = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Pedagang' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $wiraswasta = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Wiraswasta' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $pensiunan = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Pensiunan' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $buruh_harian_lepas = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Buruh Harian Lepas' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $peternak = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Peternak' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $sopir = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Sopir' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $industri = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Industri' AND dusun = $dusun GROUP BY dusun")->getRow();

        // $lainya = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = 'Lainnya' AND dusun = $dusun GROUP BY dusun")->getRow();

        // 'petani' => $petani,
        //     'buruh_tani' => $buruh_tani,
        //     'pns' => $pns,
        //     'tni' => $tni,
        //     'polisi' => $polisi,
        //     'karyawan_swasta' => $karyawan_swasta,
        //     'pedagang' => $pedagang,
        //     'wiraswasta' => $wiraswasta,
        //     'pensiunan' => $pensiunan,
        //     'buruh_harian_lepas' => $buruh_harian_lepas,
        //     'peternak' => $peternak,
        //     'sopir' => $sopir,
        //     'industri' => $industri,
        //     'lainya' => $lainya,