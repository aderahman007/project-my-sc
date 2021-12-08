<?php

function menuaktif($aktif, $menu)
{
    if ($aktif == $menu) {
        return "active";
    } else {
        return "";
    }
}

// Fungsi untuk menampilkan data dalam bentuk combobox
function combobox($name, $table, $field, $primary_key, $selected)
{
    $db      = \Config\Database::connect();
    $cmb = "<select name='$name' class='form-control select-clear'>";
    $data = $db->table($table)->get()->getResult();
    $cmb .= "<option value=''>-- Pilih --</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$primary_key . "'";
        $cmb .= $selected == $d->$primary_key ? "selected='selected'" : '';
        $cmb .= ">" . strtoupper($d->$field) . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function combobox_sm($name, $table, $field, $primary_key, $selected, $opt)
{
    $db      = \Config\Database::connect();
    $cmb = "<select name='$name' class='form-control form-control-sm  select-clear $opt'>";
    $data = $db->table($table)->get()->getResult();
    $cmb .= "<option value=''>-- Pilih --</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$primary_key . "'";
        $cmb .= $selected == $d->$primary_key ? "selected='selected'" : '';
        $cmb .= ">" . $d->$field . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function getnumdocument($id)
{
    $db      = \Config\Database::connect();
    $q = $db->query("SELECT * FROM document_hubungan_dalam_keluarga WHERE id_hubungan_dalam_keluarga='$id'")->getNumRows();
    return $q;
}

function getKepalaKeluarga($id_kk){
    $db      = \Config\Database::connect();
    $q = $db->query("SELECT nama_lengkap FROM penduduk INNER JOIN kartu_keluarga using(id_kk) WHERE id_kk = $id_kk and hubungan_keluarga = 'Kepala Keluarga'")->getResult() ;
    foreach($q as $i){
        return $i->nama_lengkap;
    }
}

function getJumlahIndividu($id_kk){
    $db      = \Config\Database::connect();
    $q = $db->query("SELECT * FROM penduduk 
                    INNER JOIN kartu_keluarga USING(id_kk)
                    WHERE id_kk = $id_kk")->getNumRows();
    return $q;
}

function getJumlahIndividuPerDusun($id_dusun){
    $db      = \Config\Database::connect();
    $q = $db->query("SELECT * FROM penduduk 
                    INNER JOIN kartu_keluarga USING(id_kk)
                    WHERE dusun=$id_dusun")->getNumRows();
    return $q;
}

function getStatusHubunganKeluarga($id_penduduk){
    $db      = \Config\Database::connect();
    $q = $db->query("SELECT status_hubungan_keluarga FROM hubungan_dalam_keluarga
                    INNER JOIN status_hubungan_dalam_keluarga USING(id_hubungan_dalam_keluarga)
                    WHERE id_penduduk = $id_penduduk")->getResult();
    foreach($q as $i){
        return $i->status_hubungan_keluarga;
    }
}

function getNoKK($id_kk){
    $db      = \Config\Database::connect();
    $q = $db->table('kartu_keluarga')->select('no_kk')->where(['id_kk' => $id_kk])->get();

    foreach($q->getResult() as $k){
        return $k->no_kk;
    }
}

function getnik($id_penduduk){
    $db      = \Config\Database::connect();
    $q = $db->table('penduduk')->select('nik')->where(['id_penduduk' => $id_penduduk])->get();

    foreach($q->getResult() as $k){
        return $k->nik;
    }
}

function getStatusMutasiDatang($id_datang, $status){
    $db      = \Config\Database::connect();
    $datang = $db->table('mutasi_datang')->where('id_datang', $id_datang)->update(['status' => $status]);
    return $datang;
}



function getStatus($id_penduduk){
    $db      = \Config\Database::connect();
    $mutasi_pindah = $db->query("SELECT * FROM mutasi_pindah INNER JOIN penduduk using(id_penduduk) where mutasi_pindah.id_penduduk = '$id_penduduk'");
    $status_hidup = $db->query("SELECT * FROM peristiwa_kematian INNER JOIN penduduk using(id_penduduk) where peristiwa_kematian.id_penduduk = '$id_penduduk'");
    if ($mutasi_pindah->getNumRows() > 0 ) {
        return '<span class="badge badge-secondary">Pindah</span>';
    }else if($status_hidup->getNumRows() > 0){
        return '<span class="badge badge-dark">Meninggal</span>';
    }else {
        return '<span class="badge badge-success">Hidup</span>';
    }
}

function getProvinsi($id){
    if ($id == null) {
        return '';
    }else {
        $db      = \Config\Database::connect();
        $q = $db->table('wilayah_provinsi')->select('nama')->where('id', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->nama;
        }
    }
}
function getDusun($id){
    if ($id == null) {
        return '';
    }else {
        $db      = \Config\Database::connect();
        $q = $db->table('dusun')->select('dusun')->where('id_dusun', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->dusun;
        }
    }
}
function getRw($id){
    if ($id == null) {
        return '';
    }else {
        $db      = \Config\Database::connect();
        $q = $db->table('rw')->select('no_rw')->where('id_rw', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->no_rw;
        }
    }
}
function getRt($id){
    if ($id == null) {
        return '';
    }else {
        $db      = \Config\Database::connect();
        $q = $db->table('rt')->select('no_rt')->where('id_rt', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->no_rt;
        }
    }
}
function getKabupaten($id){
    if ($id == null) {
        return '';
    }else {
        $db      = \Config\Database::connect();
        $q = $db->table('wilayah_kabupaten')->select('nama')->where('id', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->nama;
        }
    }
}
function getKecamatan($id){
    if ($id == null) {
        return '';
    }else {
        $db      = \Config\Database::connect();
        $q = $db->table('wilayah_kecamatan')->select('nama')->where('id', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->nama;
        }
    }
}
function getDesa($id){
    if ($id == null) {
        return '';
    }else {
        $db      = \Config\Database::connect();
        $q = $db->table('wilayah_desa')->select('nama')->where('id', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->nama;
        }
    }
}

function getLogo(){
    $db      = \Config\Database::connect();
    $q = $db->table('mnj_desa')->select('logo')->get();
    foreach ($q->getResult() as $k) {
        return $k->logo;
    }
}

function getPetugas($id)
{
    if ($id == null) {
        return '';
    } else {
        $db      = \Config\Database::connect();
        $q = $db->table('user')->select('nama')->where('id_user', $id)->get();
        foreach ($q->getResult() as $k) {
            return $k->nama;
        }
    }
}

function is_admin()
	{
		if (session()->get('role') != 'admin') {
			header('location:/petugas');
			exit();
			// return redirect()->to('petugas');
		}
	}

function allow_access(){
    $db      = \Config\Database::connect();
    $data = $db->table('user')->getWhere(['id_user' => session()->get('id_user')])->getFirstRow('array');

    $exp = strtotime($data['tanggal_berakhir']);
    $now = strtotime(date('Y-m-d H:m:s'));

    

    if ($now > $exp) {
        return true;
    }

}

function convertTanggal($tanggal, $cetak_hari = false)
{
    $hari = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split       = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}

function param_encrypt($p){
    $encrypter = \Config\Services::encrypter();
    return bin2hex($encrypter->encrypt($p));
}

function param_decrypt($p){
    $encrypter = \Config\Services::encrypter();
    return $encrypter->decrypt(hex2bin($p));
}

function encrypt_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AdeRahman@2021'; // user define private key
    $secret_iv = 'Jabrik@2021'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}


?>