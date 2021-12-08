<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?></h5>
        </div>
    </div>
    <div class="card-body">
        <p class="text-secondary font-weight-light">Masukan data sesuai yang tertera pada KTP atau Kartu Keluarga dan alamat domisili</p>
        <p class="text-secondary font-weight-light mb-1">Pada label yang tertanda <i class="text-danger">*</i> wajib di isi!</p>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <form id="form-kk" action="<?= $action; ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-row">
                <input type="hidden" name="id_datang" value="<?= param_encrypt($id_datang); ?>">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">NIK <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik" id="nik" value="<?= $nik; ?>" placeholder="Nomor induk kependudukan">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nik'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="nama" value="<?= $nama; ?>" placeholder="Nama lengkap">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Jenis Pekerjaan <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "Belum/Tidak Bekerja" => "Belum/Tidak Bekerja",
                        "Mengurus Rumah Tangga" => "Mengurus Rumah Tangga",
                        "Pelajar/Mahasiswa" => "Pelajar/Mahasiswa",
                        "Pensiunan" => "Pensiunan",
                        "Pegawai Negeri Sipil" => "Pegawai Negeri Sipil",
                        "Tentara Nasional Indonesia" => "Tentara Nasional Indonesia",
                        "Kepolisian Ri" => "Kepolisian Ri",
                        "Perdagangan" => "Perdagangan",
                        "Petani/Pekebun" => "Petani/Pekebun",
                        "Peternak" => "Peternak",
                        "Nelayan/Perikanan" => "Nelayan/Perikanan",
                        "Industri" => "Industri",
                        "Konstruksi" => "Konstruksi",
                        "Transportasi" => "Transportasi",
                        "Karyawan Swasta" => "Karyawan Swasta",
                        "Karyawan Bumn" => "Karyawan Bumn",
                        "Karyawan Bumd" => "Karyawan Bumd",
                        "Karyawan Honorer" => "Karyawan Honorer",
                        "Buruh Harian Lepas" => "Buruh Harian Lepas",
                        "Buruh Tani/Perkebunan" => "Buruh Tani/Perkebunan",
                        "Buruh Nelayan/Perikanan" => "Buruh Nelayan/Perikanan",
                        "Buruh Peternakan" => "Buruh Peternakan",
                        "Pembantu Rumah Tangga" => "Pembantu Rumah Tangga",
                        "Tukang Cukur" => "Tukang Cukur",
                        "Tukang Listrik" => "Tukang Listrik",
                        "Tukang Batu" => "Tukang Batu",
                        "Tukang Kayu" => "Tukang Kayu",
                        "Tukang Sol Sepatu" => "Tukang Sol Sepatu",
                        "Tukang Las/Pandai Besi" => "Tukang Las/Pandai Besi",
                        "Tukang Jahit" => "Tukang Jahit",
                        "Tukang Gigi" => "Tukang Gigi",
                        "Penata Rias" => "Penata Rias",
                        "Penata Busana" => "Penata Busana",
                        "Penata Rambut" => "Penata Rambut",
                        "Mekanik" => "Mekanik",
                        "Seniman" => "Seniman",
                        "Tabib" => "Tabib",
                        "Paraji" => "Paraji",
                        "Perancang Busana" => "Perancang Busana",
                        "Penterjemah" => "Penterjemah",
                        "Imam Mesjid" => "Imam Mesjid",
                        "Pendeta" => "Pendeta",
                        "Pastor" => "Pastor",
                        "Wartawan" => "Wartawan",
                        "Ustadz/Mubaligh" => "Ustadz/Mubaligh",
                        "Juru Masak" => "Juru Masak",
                        "Promotor Acara" => "Promotor Acara",
                        "Anggota Dpr-Ri" => "Anggota Dpr-Ri",
                        "Anggota Dpd" => "Anggota Dpd",
                        "Anggota Bpk" => "Anggota Bpk",
                        "Presiden" => "Presiden",
                        "Wakil Presiden" => "Wakil Presiden",
                        "Anggota Mahkamah Konstitusi" => "Anggota Mahkamah Konstitusi",
                        "Anggota Kabinet/Kementerian" => "Anggota Kabinet/Kementerian",
                        "Duta Besar" => "Duta Besar",
                        "Gubernur" => "Gubernur",
                        "Wakil Gubernur" => "Wakil Gubernur",
                        "Bupati" => "Bupati",
                        "Wakil Bupati" => "Wakil Bupati",
                        "Walikota" => "Walikota",
                        "Wakil Walikota" => "Wakil Walikota",
                        "Anggota Dprd Provinsi" => "Anggota Dprd Provinsi",
                        "Anggota Dprd Kabupaten/Kota" => "Anggota Dprd Kabupaten/Kota",
                        "Dosen" => "Dosen",
                        "Guru" => "Guru",
                        "Pilot" => "Pilot",
                        "Pengacara" => "Pengacara",
                        "Notaris" => "Notaris",
                        "Arsitek" => "Arsitek",
                        "Akuntan" => "Akuntan",
                        "Konsultan" => "Konsultan",
                        "Dokter" => "Dokter",
                        "Bidan" => "Bidan",
                        "Perawat" => "Perawat",
                        "Apoteker" => "Apoteker",
                        "Psikiater/Psikolog" => "Psikiater/Psikolog",
                        "Penyiar Televisi" => "Penyiar Televisi",
                        "Penyiar Radio" => "Penyiar Radio",
                        "Pelaut" => "Pelaut",
                        "Peneliti" => "Peneliti",
                        "Sopir" => "Sopir",
                        "Pialang" => "Pialang",
                        "Paranormal" => "Paranormal",
                        "Pedagang" => "Pedagang",
                        "Perangkat Desa" => "Perangkat Desa",
                        "Kepala Desa" => "Kepala Desa",
                        "Biarawati" => "Biarawati",
                        "Wiraswasta" => "Wiraswasta",
                        "Lainnya" => "Lainnya"
                    ];
                    $error = ($validation->hasError('jenis_pekerjaan')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '" id="jenis_pekerjaan"';
                    echo form_dropdown('jenis_pekerjaan', $pilihan, $pekerjaan, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('jenis_pekerjaan'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Agama <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "Islam" => 'Islam',
                        "Kristen" => 'Kristen',
                        "Katholik" => 'Katholik',
                        "Hindu" => 'Hindu',
                        "Budha" => 'Budha',
                        "Konghucu" => 'Konghucu',
                    ];

                    $error = ($validation->hasError('agama')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('agama', $pilihan, $agama, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('agama'); ?>
                    </div>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Tempat Lahir <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('tempat_lahir')) ? 'is-invalid' : ''; ?>" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?= $tempat_lahir; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('tempat_lahir'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Tanggal Lahir <i class="text-danger">*</i></label>
                    <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_lahir')) ? 'is-invalid' : ''; ?>" name="tanggal_lahir" id="tanggal_lahir" placeholder="Tanggal Lahir" value="<?= $tanggal_lahir; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('tanggal_lahir'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Jenis Kelamin <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "L" => 'Laki - Laki',
                        "P" => 'Perempuan',
                    ];

                    $error = ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('jenis_kelamin', $pilihan, $jenis_kelamin, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('jenis_kelamin'); ?>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Golongan Darah <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "A" => 'Golongan Darah A',
                        "B" => 'Golongan Darah B',
                        "AB" => 'Golongan Darah AB',
                        "O" => 'Golongan Darah O',
                    ];

                    $error = ($validation->hasError('golongan_darah')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('golongan_darah', $pilihan, $golongan_darah, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('golongan_darah'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Status Perkawinan <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "Kawin" => 'Kawin',
                        "Belum Kawin" => 'Belum Kawin',
                        "Cerai Hidup" => 'Cerai Hidup',
                        "Cerai Mati" => 'Cerai Mati',
                    ];

                    $error = ($validation->hasError('status_perkawinan')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('status_perkawinan', $pilihan, $status_perkawinan, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('status_perkawinan'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Kewarganegaraan <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "WNI" => 'WNI',
                        "WNA" => 'WNA',
                    ];

                    $error = ($validation->hasError('kewarganegaraan')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('kewarganegaraan', $pilihan, $kewarganegaraan, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kewarganegaraan'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Tanggal Datang <i class="text-danger">*</i></label>
                    <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_datang')) ? 'is-invalid' : ''; ?>" name="tanggal_datang" id="tanggal_datang" placeholder="Tanggal datang" value="<?= $tanggal_datang; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('tanggal_datang'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Foto KTP / Kartu Keluarga <i class="text-danger">*</i></label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="doc_ktp">Choose file...</label>
                        <input type="file" class="custom-file-inputform-control input-group-sm <?= ($validation->hasError('doc_ktp')) ? 'is-invalid' : ''; ?>" name="doc_ktp" id="doc_ktp" value="<?= $doc_ktp ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('doc_ktp'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <?php if ($doc_ktp != null) { ?>
                    <div class="form-group col-md-12">
                        <label class="col-form-label font-weight-bold">Lihat foto kartu keluarga</label>
                        <a class="btn btn-sm btn-info form-control" href="<?= base_url('MutasiDatang/viewktp') . '/' . param_encrypt($id_datang); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
                    </div>
                <?php } ?>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="col-form-label font-weight-bold">Alamat Domisili <i class="text-danger">*</i></label>
                    <textarea class="form-control form-control-sm <?= ($validation->hasError('alamat_domisili')) ? 'is-invalid' : ''; ?>" name="alamat_domisili" id="alamat_domisili" rows="2" placeholder="Nama jalan/No rumah domisili"><?= $alamat_domisili; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat_domisili'); ?>
                    </div>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nomor Dusun Domisili<i class="text-danger">*</i></label>
                    <select name="dusun_domisili" id="dusun_domisili" class="form-control <?= ($validation->hasError('dusun_domisili')) ? 'is-invalid' : ''; ?>">
                        <option selected disabled>~~ Pilih ~~</option>
                        <?php foreach ($d_dusun as $key => $value) : ?>
                            <option <?= ($value['id_dusun'] == $dusun_domisili) ? 'selected' : ''; ?> value="<?= $value['id_dusun']; ?>"><?= $value['dusun']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('dusun_domisili'); ?>
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div class="col-md-6">
                        <label class="col-form-label font-weight-bold">Nomor RW Domisili<i class="text-danger">*</i></label>
                        <select disabled name="rw_domisili" id="rw_domisili" class="form-control <?= ($validation->hasError('id_rw')) ? 'is-invalid' : ''; ?>">
                            <option selected value="<?= $rw_domisili; ?>"><?= ($rw_domisili) ? getRw($rw_domisili) : '~~ Pilih ~~'; ?></option>
                            <!-- <?php foreach ($d_rw as $key => $value) : ?>
                                <option <?= ($value['id_rw'] == $rw_domisili) ? 'selected' : ''; ?> value="<?= $value['id_rw']; ?>"><?= $value['no_rw']; ?></option>
                            <?php endforeach ?> -->
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('rw_domisili'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label font-weight-bold">Nomor RT Domisili <i class="text-danger">*</i></label>
                        <select name="rt_domisili" id="rt_domisili" class="form-control <?= ($validation->hasError('id_rt')) ? 'is-invalid' : ''; ?>">
                            <option selected disabled>~~ Pilih ~~</option>
                            <option <?= ($rt_domisili) ? 'selected' : ''; ?> value="<?= $rt_domisili; ?>"><?= getRt($rt_domisili); ?></option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('rt_domisili'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">

                <div class="form-group col-md-12">
                    <label class="col-form-label font-weight-bold">Keterangan</label>
                    <textarea class="form-control form-control-sm <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" name="keterangan" id="keterangan" rows="2" placeholder="Nama jalan/No rumah domisili"><?= $keterangan; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('keterangan'); ?>
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider my-3">
            <p class="text-secondary font-weight-light">Masukan data asli sesuai yang tertera pada KTP atau Kartu Keluarga</p>
            <!-- Divider -->
            <hr class="sidebar-divider my-3">
            <div class="form-group">
                <label class="col-form-label font-weight-bold">Alamat <i class="text-danger">*</i></label>
                <textarea class="form-control form-control-sm <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" name="alamat" id="alamat" rows="2" placeholder="Nama jalan/No rumah"><?= $alamat; ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alamat'); ?>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">RT/RW <i class="text-danger">*</i></label>
                        <div class="form-row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm <?= ($validation->hasError('rt')) ? 'is-invalid' : ''; ?>" name="rt" id="rt" value="<?= $rt; ?>" placeholder="RT">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('rt'); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm <?= ($validation->hasError('rw')) ? 'is-invalid' : ''; ?>" name="rw" id="rw" value="<?= $rw; ?>" placeholder="RW">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('rw'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Kode Pos <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('kode_pos')) ? 'is-invalid' : ''; ?>" name="kode_pos" id="kode_pos" value="<?= $kode_pos; ?>" placeholder="Kode Pos">
                        <div class="invalid-feedback">
                            <?= $validation->getError('kode_pos'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="col-form-label font-weight-bold">Dusun <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('dusun')) ? 'is-invalid' : ''; ?>" name="dusun" id="dusun" value="<?= $dusun; ?>" placeholder="Kode Pos">
                    <div class="invalid-feedback">
                        <?= $validation->getError('dusun'); ?>
                    </div>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Provinsi <i class="text-danger">*</i></label>
                    <select class="form-control form-control-sm <?= ($validation->hasError('provinsi')) ? 'is-invalid' : ''; ?>" name="provinsi" id="provinsi" placeholder="Provinsi">
                        <option value="<?= $provinsi; ?>"><?= getProvinsi($provinsi); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('provinsi'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Kabupaten <i class="text-danger">*</i></label>
                    <select class="form-control form-control-sm <?= ($validation->hasError('kabupaten')) ? 'is-invalid' : ''; ?>" name="kabupaten" id="kabupaten" placeholder="Kabupaten">
                        <option selected="selected" class="pilihan" value="<?= $kabupaten; ?>"><?= getKabupaten($kabupaten); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kabupaten'); ?>
                    </div>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Kecamatan <i class="text-danger">*</i></label>

                    <select class="form-control form-control-sm <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" name="kecamatan" id="kecamatan" placeholder="Kecamatan">
                        <option value="<?= $kecamatan; ?>"><?= getKecamatan($kecamatan); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kecamatan'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Desa/Kelurahan <i class="text-danger">*</i></label>

                    <select class="form-control form-control-sm <?= ($validation->hasError('desa')) ? 'is-invalid' : ''; ?>" name="desa" id="desa" placeholder="Desa">
                        <option value="<?= $desa; ?>"><?= getDesa($desa); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('desa'); ?>
                    </div>
                </div>
            </div>


            <div class="row float-right">
                <a href="<?= $cencel; ?>" class="btn btn-secondary mt-3 mr-3 loading-cencel">Cencel</a>
                <button class="btn btn-primary mt-3 mr-3 loading-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/select2/select2.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/bs-custom-file-input.min.js"></script>
<script>
    $("#form-kk").on("submit", function() {
        $("#rw_domisili").attr('disabled', false);
        $(".loading-simpan").html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(".loading-cencel").hide(0);
        $(".loading-simpan").attr('disabled', true);
    });

    $(".loading-cencel").on("click", function() {
        $(".loading-cencel").html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(this).addClass('disabled');
        $(".loading-simpan").hide(0);
    });

    $(".form-control").on("click", function() {
        $(".loading-simpan").html('Simpan');
        $(".loading-cencel").show(0);
    });
</script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();

        wilayah();
        getRt();
        getRw();

        $('#jenis_pekerjaan').select2({
            allowClear: true,
            placeholder: '~~ Pilih ~~',
        });

        var uri = '<?= $uri->getSegment(2); ?>';

        if (uri == 'update') {
            // select rt on edit
            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/getRtEdit'); ?>",
                data: {
                    dusun: $('#dusun_domisili').val(),
                    rt: '<?= $rt_domisili; ?>'
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#rt_domisili').html(response.data);
                    }
                }
            });

            // clear form on change in provinsi
            $('#provinsi').change(function() {
                $('#kabupaten').find('option').remove();
                $('#kecamatan').find('option').remove();
                $('#desa').find('option').remove();
            });

            // clear form on change in kabupaten
            $('#kabupaten').change(function() {
                $('#kecamatan').find('option').remove();
                $('#desa').find('option').remove();
            });

            // clear form on change in kecamatan
            $('#kecamatan').change(function() {
                $('#desa').find('option').remove();
            });

            // select2 change kabupaten on edit
            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/search_kabupaten'); ?>",
                data: {
                    provinsi: $('#provinsi').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#kabupaten').html(response.data);
                        var pilih = '<option selected="selected" class="pilihan" value="<?= $kabupaten; ?>"><?= getKabupaten($kabupaten); ?></option>';
                        $('#kabupaten').append(pilih);
                        $('#kabupaten').select2();

                    }
                }
            });

            // select2 change kecamatan on edit
            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/search_kecamatan'); ?>",
                data: {
                    kabupaten: $('#kabupaten').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#kecamatan').html(response.data);
                        var pilih = '<option selected="selected" class="pilihan" value="<?= $kecamatan; ?>"><?= getkecamatan($kecamatan); ?></option>';
                        $('#kecamatan').append(pilih);
                        $('#kecamatan').select2();

                    }
                }
            });

            // select2 change desa on edit
            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/search_desa'); ?>",
                data: {
                    kecamatan: $('#kecamatan').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#desa').html(response.data);
                        var pilih = '<option selected="selected" class="pilihan" value="<?= $desa; ?>"><?= getdesa($desa); ?></option>';
                        $('#desa').append(pilih);
                        $('#desa').select2();

                    }
                }
            });
        }
    });

    function wilayah() {
        $('#provinsi').select2({
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Input Provinsi',
            ajax: {
                dataType: 'json',
                url: "<?= site_url('MutasiDatang/search_provinsi'); ?>",
                delay: 500,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(data, page) {
                    return {
                        results: data
                    }
                }
            }
        });

        $('#provinsi').change(function(e) {
            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/search_kabupaten'); ?>",
                data: {
                    provinsi: $(this).val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#kabupaten').html(response.data);
                        $('#kabupaten').select2({
                            allowClear: true,
                        });
                    }
                }
            });
        });

        $('#kabupaten').change(function(e) {
            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/search_kecamatan'); ?>",
                data: {
                    kabupaten: $(this).val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#kecamatan').html(response.data);
                        $('#kecamatan').select2({
                            allowClear: true,
                        });
                    }
                }
            });
        });

        $('#kecamatan').change(function(e) {

            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/search_desa'); ?>",
                data: {
                    kecamatan: $(this).val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#desa').html(response.data);
                        $('#desa').select2({
                            allowClear: true,
                        });
                    }
                }
            });
        });
    }

    function getRt() {
        $('#dusun_domisili').change(function(e) {
            $.ajax({
                type: "post",
                url: "<?= site_url('MutasiDatang/getrt'); ?>",
                data: {
                    rw_domisili: $(this).val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#rt_domisili').html(response.data);
                    }
                }
            });
        });


    }

    function getRw() {
        $('#dusun_domisili').change(function(e) {
            var rw = $(this).val();
            var text = $(this).find(':selected').text();
            $('#rw_domisili').html('<option value="' + rw + '" selected>' + text.substr(6, 3) + '</option>');
        });
    }
</script>





<?= $this->endSection(); ?>