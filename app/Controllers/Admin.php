<?php

namespace App\Controllers;

class Admin extends BaseController
{
	protected $db;
	protected $kk;
	protected $validation;
	public function __construct()
	{
		helper(['my_function']);
		is_admin();
		$this->db      = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
	}

	public function index()
	{
		
		$penduduk_total = $this->db->query("SELECT COUNT(id_penduduk) as total FROM penduduk")->getRow();
		// $hidup = $this->db->query("SELECT COUNT(penduduk.id_penduduk) as hidup FROM penduduk LEFT JOIN peristiwa_kematian USING(id_penduduk) WHERE peristiwa_kematian.id_penduduk IS NULL")->getRow();
		$meninggal = $this->db->query("SELECT COUNT(peristiwa_kematian.id_penduduk) as total FROM penduduk INNER JOIN peristiwa_kematian USING(id_penduduk)")->getRow();
		$pindah = $this->db->query("SELECT COUNT(mutasi_pindah.id_penduduk) as total FROM penduduk RIGHT JOIN mutasi_pindah USING(id_penduduk)")->getRow();
		$kelahiran = $this->db->query("SELECT COUNT(id_lahir) as total FROM peristiwa_lahir")->getRow();
		$datang = $this->db->query("SELECT COUNT(id_datang) as total FROM mutasi_datang")->getRow();

		$kk_total = $this->db->query("SELECT COUNT(id_kk) as total FROM kartu_keluarga")->getRow();

		$lk = $this->db->query("SELECT COUNT(jenis_kelamin) as total FROM penduduk WHERE jenis_kelamin = 'L'")->getRow();

		$pr = $this->db->query("SELECT COUNT(jenis_kelamin) as total FROM penduduk WHERE jenis_kelamin = 'P'")->getRow();

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
			$umur[] = $this->db->query("SELECT COUNT(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) AS umur FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) $key")->getRow();
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
			"Lainnya",
			"Belum/Tidak Bekerja",
		];

		foreach ($data_pekerjaan as $key) {
			$pekerjaan[] = $this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_pekerjaan = '$key'")->getRow();
		}

		$i=0;
		foreach ($data_pekerjaan as $key) {
			$this->db->query("SELECT COUNT(penduduk.id_penduduk) AS pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE NOT jenis_pekerjaan = '$key'")->getRow();
			$i++;
		}

		$data = [
			'judul' => 'Dashboard',
			'show'  => 'dashboard',
			'aktif' => 'dashboard',
			'penduduk_total' => $penduduk_total,
			'kk_total' => $kk_total,
			'datang' => $datang,
			// 'hidup' => $hidup,
			'lk' => $lk,
			'pr' => $pr,
			'jk' => $jk,
			'penduduk' => $penduduk,
			'dusun' => $dusun,
			'rt' => $rt,
			'meninggal' => $meninggal,
			'kelahiran' => $kelahiran,
			'pindah' => $pindah,
			'umur' => $umur,
			'pekerjaan' => $pekerjaan,
			'na' => $i,
			'back' => site_url('dashboard'),
			'detail' => ''
		];

		return view('dashboard', $data);
	}

	public function change_password()
	{
		if (session()->get('role') == 'admin') {
			if ($this->request->getMethod() == 'get') {
				$data = [
					'judul' => 'Change Password Admin',
					'show'  => 'manajement',
					'aktif' => 'mnj_petugas',
					'validation'    => $this->validation,
				];
				return view('auth/change_password', $data);
			} else {
				$validasi = $this->validate([
					'old_password' => [
						'rules' => 'required|min_length[3]',
						'errors' => [
							'required' => 'Password harus di isi',
							'min_length' => 'Password harus di isi minimal 6 angka',
						]
					],
					'new_password' => [
						'rules' => 'required|min_length[6]|differs[old_password]',
						'errors' => [
							'required' => 'Password harus di isi',
							'min_length' => 'Password harus di isi minimal 3 angka',
							'differs' => 'Password harus berbeda dengan password lama'
						]
					],
					'repeat_password' => [
						'rules' => 'required|min_length[3]|matches[new_password]',
						'errors' => [
							'required' => 'Password harus di isi',
							'min_length' => 'Password harus di isi minimal 3 angka',
							'matches' => 'Password tidak sama'
						]
					]
				]);

				if (!$validasi) {
					session()->setFlashdata('error_password', 'Password gagal di update ! (Password tidak valid)');
					return redirect()->to('admin/change_password')->withInput();
				} else {
					$id = session()->get('id_user');
					$old_password = $this->request->getVar('old_password');
					$data = $this->db->table('user')->where('id_user', $id)->get()->getFirstRow('array');
					$cek_password = password_verify($old_password, $data['password']);

					if ($id) {

						if (!$cek_password) {
							session()->setFlashdata('error_password', 'Password Gagal di Update ! (Password Lama Salah)');
							return redirect()->to('admin/change_password');
						} else {
							$changed_password = password_hash($this->request->getVar('repeat_password'), PASSWORD_BCRYPT);

							$this->db->table('user')->where('id_user', $id)->update(['password' => $changed_password]);
							session()->setFlashdata('sukses_password', 'Password Berhasil di Update !');
							return redirect()->to('admin/change_password');
						}
					}
				}
			}
		}
	}

}
