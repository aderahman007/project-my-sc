<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('pesan')) : ?>

    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>
<?php endif ?>
<?php if (session()->getFlashdata('error')) : ?>

    <div class="flash-data-error" data-flashdata="<?= session()->getFlashdata('error'); ?>"></div>
<?php endif ?>
<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?></h5>
        </div>
    </div>
    <div class="card-body">
        <p class="text-secondary font-weight-light mb-1">Masukan data sesuai yang tertera pada Kartu Tanda Penduduk</p>
        <p class="text-secondary font-weight-light mb-1">Pada label yang tertanda <i class="text-danger">*</i> wajib di isi!</p>

        <!-- Divider -->
        <hr class="sidebar-divider mb-4">

        <form id="form-penduduk" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-row">
                <input type="hidden" name="id_penduduk" value="<?= param_encrypt($id_penduduk); ?>">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">No KK <i class="text-danger">*</i></label>
                    <select class="form-control form-control-sm <?= ($validation->hasError('id_kk')) ? 'is-invalid' : ''; ?>" name="id_kk" id="id_kk">
                        <option value="<?= $id_kk; ?>"><?= getNoKK($id_kk); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('id_kk'); ?>
                    </div>
                    <!-- <input type="text" class="form-control form-control-sm" name="no_kk" id="no_kk" placeholder="Nomor kartu keluarga"> -->
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">NIK <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik" id="nik" placeholder="NIK" value="<?= $nik; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nik'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama Lengkap <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?= $nama_lengkap; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_lengkap'); ?>
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
                    <label class="col-form-label font-weight-bold">Pendidikan <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "Tidak/Belum Sekolah" => 'Tidak/Belum Sekolah',
                        "Tamat SD/Sederajat" => 'Tamat SD/Sederajat',
                        "Belum Tamat SD/Sederajat" => 'Belum Tamat SD/Sederajat',
                        "Tamat SLTP/Sederajat" => 'Tamat SLTP/Sederajat',
                        "Tamat SLTA/Sederajat" => 'Tamat SLTA/Sederajat',
                        "Tamat D1" => 'Tamat D1',
                        "Tamat D2" => 'Tamat D2',
                        "Tamat D3" => 'Tamat D3',
                        "Tamat S1" => 'Tamat S1',
                        "Tamat S2" => 'Tamat S2',
                        "Tamat S3" => 'Tamat S3',

                    ];

                    $error = ($validation->hasError('pendidikan')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('pendidikan', $pilihan, $pendidikan, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('pendidikan'); ?>
                    </div>

                </div>
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
                    echo form_dropdown('jenis_pekerjaan', $pilihan, $jenis_pekerjaan, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('jenis_pekerjaan'); ?>
                    </div>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama Ayah <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ayah')) ? 'is-invalid' : ''; ?>" name="nama_ayah" id="nama_ayah" placeholder="Nama Ayah" value="<?= $nama_ayah; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_ayah'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama Ibu <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ibu')) ? 'is-invalid' : ''; ?>" name="nama_ibu" id="nama_ibu" placeholder="Nama Ibu" value="<?= $nama_ibu; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_ibu'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">No Paspor</label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_paspor')) ? 'is-invalid' : ''; ?>" name="no_paspor" id="no_paspor" placeholder="No Paspor" value="<?= $no_paspor; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('no_paspor'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">No Kitas/Kitab</label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_kitas_or_kitab')) ? 'is-invalid' : ''; ?>" name="no_kitas_or_kitab" id="no_kitas_or_kitab" placeholder="No Kitas/Kitab" value="<?= $no_kitas_or_kitab; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('no_kitas_or_kitab'); ?>
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
                    <label class="col-form-label font-weight-bold">Hubungan Dalam Keluarga <i class="text-danger">*</i></label>

                    <?php
                    $pilihan = [
                        ""                  => "~~Pilih~~",
                        "Kepala Keluarga"    => "Kepala Keluarga",
                        "Istri"             => "Istri",
                        "Anak"              => "Anak",
                        "Family Lain"       => "Family Lain",
                    ];

                    $error = ($validation->hasError('hubungan_keluarga')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('hubungan_keluarga', $pilihan, $hubungan_keluarga, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('hubungan_keluarga'); ?>
                    </div>

                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Foto KTP</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="doc_ktp">Choose file...</label>
                        <input type="file" class="custom-file-inputform-control input-group-sm <?= ($validation->hasError('doc_ktp')) ? 'is-invalid' : ''; ?>" name="doc_ktp" id="doc_ktp" value="<?= $doc_ktp; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('doc_ktp'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">

                <?php if ($doc_ktp != null) { ?>
                    <div class="form-group col-md-12">
                        <label class="col-form-label font-weight-bold">Lihat foto KTP</label>
                        <a class="btn btn-sm btn-info form-control" href="<?= base_url('penduduk/viewktp') . '/' . param_encrypt($id_penduduk); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
                    </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 d-flex justify-content-center">
                    <!-- <a style="border-radius: 100%;" href="#" class="btn btn-info mx-auto" id="add-form" data-toggle="tooltip" data-placement="top" title="Tambah form"><i class="fa fa-plus" aria-hidden="true"></i></a> -->
                </div>
                <div class="col-md-4">
                    <div class="float-right">
                        <a href="<?= $cencel; ?>" class="btn btn-secondary mr-3 loading-cencel">Cencel</a>
                        <button class="btn btn-primary loading-simpan">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/select2/select2.min.js"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url(); ?>/assets/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        bsCustomFileInput.init();

        search_noKK();
        dataProvinsi();

        $('#jenis_pekerjaan').select2({
            allowClear: true,
            placeholder: '~~ Pilih ~~',
        });
    });

    function search_noKK() {
        $('#id_kk').select2({
            minimumInputLength: 3,
            allowClear: true,
            placeholder: 'Cari Nomor KK',
            ajax: {
                dataType: 'json',
                url: "<?= site_url('penduduk/search_noKK'); ?>",
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
    }

    function dataProvinsi() {
        $('#provinsi').select2({
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Input Provinsi',
            ajax: {
                dataType: 'json',
                url: "<?= site_url('penduduk/search_provinsi'); ?>",
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
                url: "<?= site_url('penduduk/search_kabupaten'); ?>",
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
                url: "<?= site_url('penduduk/search_kecamatan'); ?>",
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
                url: "<?= site_url('penduduk/search_desa'); ?>",
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
</script>

<script>
    $("#form-penduduk").on("submit", function() {
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
    // alert berhasil
    const flashData = $('.flash-data').data('flashdata');
    const flashDataError = $('.flash-data-error').data('flashdata');

    if (flashData) {
        Swal.fire({
            icon: 'success',
            title: 'Data ' + "<?= $swal; ?>",
            text: 'Berhasil ' + flashData,
            type: 'success'
        });
    }
    if (flashDataError) {
        Swal.fire({
            icon: 'error',
            title: 'Data ' + "<?= $swal; ?>",
            text: 'Gagal ' + flashDataError,
            type: 'error'
        });
    }
</script>


<?= $this->endSection(); ?>