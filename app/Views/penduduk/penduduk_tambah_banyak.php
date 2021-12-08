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
        <p class="text-secondary font-weight-light mb-1">Masukan data sesuai yang tertera pada Kartu Tanda Penduduk</p>
        <p class="text-secondary font-weight-light mb-1">Pada label yang tertanda <i class="text-danger">*</i> wajib di isi!</p>

        <!-- Divider -->
        <hr class="sidebar-divider mb-4">

        <form id="form-penduduk" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-add-data">
                <div class="form-data">
                    <div class="form-row">
                        <input type="hidden" name="id_penduduk[]" value="">
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">No KK <i class="text-danger">*</i></label>
                            <select class="form-control form-control-sm <?= ($validation->hasError('id_kk')) ? 'is-invalid' : ''; ?>" name="id_kk[]" id="id_kk">
                                <option value="<?= old('id_kk.0'); ?>"><?= getNoKK(old('id_kk.0')); ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('id_kk'); ?>
                            </div>
                            <!-- <input type="text" class="form-control form-control-sm" name="no_kk" id="no_kk" placeholder="Nomor kartu keluarga"> -->
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">NIK <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik[]" id="nik" placeholder="NIK" value="<?= old('nik.0'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nik'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Nama Lengkap <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="nama_lengkap[]" id="nama_lengkap" placeholder="Nama Lengkap" value="">
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
                            echo form_dropdown('agama[]', $pilihan, '', $opt)
                            ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('agama'); ?>
                            </div>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Tempat Lahir <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="tempat_lahir[]" id="tempat_lahir" placeholder="Tempat Lahir" value="">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tempat_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Tanggal Lahir <i class="text-danger">*</i></label>
                            <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_lahir')) ? 'is-invalid' : ''; ?>" name="tanggal_lahir[]" id="tanggal_lahir" placeholder="Tanggal Lahir" value="">
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
                                "TIDAK/BELUM TAMAT SD/SEDERAJAT" => 'TIDAK/BELUM TAMAT SD/SEDERAJAT',
                                "TAMAT SD/SEDERAJAT" => 'TAMAT SD/SEDERAJAT',
                                "TAMAT SLTP/SEDERAJAT" => 'TAMAT SLTP/SEDERAJAT',
                                "TAMAT SLTA/SEDERAJAT" => 'TAMAT SLTA/SEDERAJAT',
                                "TAMAT D1/D2" => 'TAMAT D1/D2',
                                "TAMAT AKADEMI/D3" => 'TAMAT AKADEMI/D3',
                                "TAMAT D4/S1" => 'TAMAT D4/S1',
                                "TAMAT S2/S3" => 'TAMAT S2/S3',
                            ];

                            $error = ($validation->hasError('pendidikan')) ? 'is-invalid' : '';

                            $opt = 'class="form-control form-control-sm ' . $error . '"';
                            echo form_dropdown('pendidikan[]', $pilihan, '', $opt)
                            ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('pendidikan'); ?>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Jenis Pekerjaan <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('jenis_pekerjaan')) ? 'is-invalid' : ''; ?>" name="jenis_pekerjaan[]" id="jenis_pekerjaan" placeholder="Jenis Pekerjaan" value="">
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenis_pekerjaan'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Nama Ayah <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ayah')) ? 'is-invalid' : ''; ?>" name="nama_ayah[]" id="nama_ayah" placeholder="Nama Ayah" value="">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_ayah'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Nama Ibu <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ibu')) ? 'is-invalid' : ''; ?>" name="nama_ibu[]" id="nama_ibu" placeholder="Nama Ibu" value="">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_ibu'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">No Paspor</label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_paspor')) ? 'is-invalid' : ''; ?>" name="no_paspor[]" id="no_paspor" placeholder="No Paspor" value="">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_paspor'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">No Kitas/Kitab</label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_kitas_or_kitab')) ? 'is-invalid' : ''; ?>" name="no_kitas_or_kitab[]" id="no_kitas_or_kitab" placeholder="No Kitas/Kitab" value="">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_kitas_or_kitab'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Jenis Kelamin <i class="text-danger">*</i></label>
                            <div class="row ml-1">
                                <div class="form-check mr-4">
                                    <input class="form-check-input <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin[]" id="jenis_kelamin_l" value="" <?= (old('jenis_kelamin') == 'L') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="jenis_kelamin_l">
                                        Laki-laki
                                    </label>

                                    <input class="form-check-input ml-4 <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin[]" id="jenis_kelamin_p" value="" <?= (old('jenis_kelamin') == 'P') ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-5" for="jenis_kelamin_p">
                                        Perempuan
                                    </label>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jenis_kelamin'); ?>
                                    </div>
                                </div>
                                <div class="form-check">

                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Golongan Darah <i class="text-danger">*</i></label>
                            <div class="row ml-1">
                                <div class="form-check">
                                    <input class="form-check-input <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_a" value="" <?= (old('golongan_darah') == 'A') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="golongan_darah_a">
                                        Gol. darah A
                                    </label>

                                    <input class="form-check-input ml-2 <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_b" value="" <?= (old('golongan_darah') == 'B') ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-4" for="golongan_darah_b">
                                        Gol. darah B
                                    </label>

                                    <input class="form-check-input ml-2 <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_ab" value="" <?= (old('golongan_darah') == 'AB') ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-4" for="golongan_darah_ab">
                                        Gol. darah AB
                                    </label>

                                    <input class="form-check-input ml-2 <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_o" value="" <?= (old('golongan_darah') == 'O') ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-4" for="golongan_darah_o">
                                        Gol. darah O
                                    </label>

                                    <div class="invalid-feedback">
                                        <?= $validation->getError('golongan_darah'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Status Perkawinan <i class="text-danger">*</i></label>
                            <div class="row ml-1">
                                <div class="form-check mr-4">
                                    <input class="form-check-input mr-5 <?= ($validation->hasError('status_perkawinan')) ? 'is-invalid' : ''; ?>" type="radio" name="status_perkawinan[]" id="status_perkawinan_kawin" value="" <?= (old('status_perkawinan') == 'kawin') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="status_perkawinan_kawin">
                                        Kawin
                                    </label>

                                    <input class="form-check-input ml-4 <?= ($validation->hasError('status_perkawinan')) ? 'is-invalid' : ''; ?>" type="radio" name="status_perkawinan[]" id="status_perkawinan_belum_kawin" value="" <?= (old('status_perkawinan') == 'belum kawin') ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-5" for="status_perkawinan_belum_kawin">
                                        Belum Kawin
                                    </label>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('status_perkawinan'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Kewarganegaraan <i class="text-danger">*</i></label>
                            <div class="row ml-1">
                                <div class="form-check mr-3">
                                    <input class="form-check-input <?= ($validation->hasError('kewarganegaraan')) ? 'is-invalid' : ''; ?>" type="radio" name="kewarganegaraan[]" id="kewarganegaraan_wni" value="" <?= (old('kewarganegaraan') == 'WNI') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="kewarganegaraan_wni">
                                        WNI
                                    </label>

                                    <input class="form-check-input ml-4 <?= ($validation->hasError('kewarganegaraan')) ? 'is-invalid' : ''; ?>" type="radio" name="kewarganegaraan[]" id="kewarganegaraan_wna" value="" <?= (old('kewarganegaraan') == 'WNA') ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-5" for="kewarganegaraan_wna">
                                        WNA
                                    </label>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kewarganegaraan'); ?>
                                    </div>
                                </div>
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
                            echo form_dropdown('hubungan_keluarga[]', $pilihan, '', $opt)
                            ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('hubungan_keluarga'); ?>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label font-weight-bold">Foto KTP</label>
                            <div class="custom-file">
                                <label class="custom-file-label" for="doc_ktp">Choose file...</label>
                                <input type="file" class="custom-file-inputform-control input-group-sm <?= ($validation->hasError('doc_ktp')) ? 'is-invalid' : ''; ?>" name="doc_ktp[]" id="doc_ktp" value="">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('doc_ktp'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 d-flex justify-content-center">
                    <a style="border-radius: 100%;" href="#" class="btn btn-info mx-auto" id="add-form" data-toggle="tooltip" data-placement="top" title="Tambah form"><i class="fa fa-plus" aria-hidden="true"></i></a>
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
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        bsCustomFileInput.init();

        search_noKK();
        dataProvinsi();
        tambahForm();
        hapusForm()
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

    function tambahForm() {
        $('#add-form').click(function(e) {
            e.preventDefault();
            $('.form-add-data').append(`
            <div class="form-data">
                <!-- Divider -->
                <hr class="sidebar-divider mb-4">
                <div class="form-row">
                    <input type="hidden" name="id_penduduk[]" value="">
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">No KK <i class="text-danger">*</i></label>
                        <select class="form-control form-control-sm <?= ($validation->hasError('id_kk')) ? 'is-invalid' : ''; ?>" name="id_kk[]" id="id_kk">
                            <option value="<?= old('id_kk.0'); ?>"><?= getNoKK(old('id_kk.0')); ?></option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('id_kk'); ?>
                        </div>
                        <!-- <input type="text" class="form-control form-control-sm" name="no_kk" id="no_kk" placeholder="Nomor kartu keluarga"> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">NIK <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik[]" id="nik" placeholder="NIK" value="<?= old('nik.0'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nik'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Nama Lengkap <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="nama_lengkap[]" id="nama_lengkap" placeholder="Nama Lengkap" value="">
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
                        echo form_dropdown('agama[]', $pilihan, '', $opt)
                        ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('agama'); ?>
                        </div>

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Tempat Lahir <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="tempat_lahir[]" id="tempat_lahir" placeholder="Tempat Lahir" value="">
                        <div class="invalid-feedback">
                            <?= $validation->getError('tempat_lahir'); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Tanggal Lahir <i class="text-danger">*</i></label>
                        <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_lahir')) ? 'is-invalid' : ''; ?>" name="tanggal_lahir[]" id="tanggal_lahir" placeholder="Tanggal Lahir" value="">
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
                            "TIDAK/BELUM TAMAT SD/SEDERAJAT" => 'TIDAK/BELUM TAMAT SD/SEDERAJAT',
                            "TAMAT SD/SEDERAJAT" => 'TAMAT SD/SEDERAJAT',
                            "TAMAT SLTP/SEDERAJAT" => 'TAMAT SLTP/SEDERAJAT',
                            "TAMAT SLTA/SEDERAJAT" => 'TAMAT SLTA/SEDERAJAT',
                            "TAMAT D1/D2" => 'TAMAT D1/D2',
                            "TAMAT AKADEMI/D3" => 'TAMAT AKADEMI/D3',
                            "TAMAT D4/S1" => 'TAMAT D4/S1',
                            "TAMAT S2/S3" => 'TAMAT S2/S3',
                        ];

                        $error = ($validation->hasError('pendidikan')) ? 'is-invalid' : '';

                        $opt = 'class="form-control form-control-sm ' . $error . '"';
                        echo form_dropdown('pendidikan[]', $pilihan, '', $opt)
                        ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('pendidikan'); ?>
                        </div>

                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Jenis Pekerjaan <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('jenis_pekerjaan')) ? 'is-invalid' : ''; ?>" name="jenis_pekerjaan[]" id="jenis_pekerjaan" placeholder="Jenis Pekerjaan" value="">
                        <div class="invalid-feedback">
                            <?= $validation->getError('jenis_pekerjaan'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Nama Ayah <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ayah')) ? 'is-invalid' : ''; ?>" name="nama_ayah[]" id="nama_ayah" placeholder="Nama Ayah" value="">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_ayah'); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Nama Ibu <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ibu')) ? 'is-invalid' : ''; ?>" name="nama_ibu[]" id="nama_ibu" placeholder="Nama Ibu" value="">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_ibu'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">No Paspor</label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_paspor')) ? 'is-invalid' : ''; ?>" name="no_paspor[]" id="no_paspor" placeholder="No Paspor" value="">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_paspor'); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">No Kitas/Kitab</label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_kitas_or_kitab')) ? 'is-invalid' : ''; ?>" name="no_kitas_or_kitab[]" id="no_kitas_or_kitab" placeholder="No Kitas/Kitab" value="">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_kitas_or_kitab'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Jenis Kelamin <i class="text-danger">*</i></label>
                        <div class="row ml-1">
                            <div class="form-check mr-4">
                                <input class="form-check-input <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin[]" id="jenis_kelamin_l" value="" <?= (old('jenis_kelamin') == 'L') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="jenis_kelamin_l">
                                    Laki-laki
                                </label>

                                <input class="form-check-input ml-4 <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin[]" id="jenis_kelamin_p" value="" <?= (old('jenis_kelamin') == 'P') ? 'checked' : ''; ?>>
                                <label class="form-check-label ml-5" for="jenis_kelamin_p">
                                    Perempuan
                                </label>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jenis_kelamin'); ?>
                                </div>
                            </div>
                            <div class="form-check">

                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Golongan Darah <i class="text-danger">*</i></label>
                        <div class="row ml-1">
                            <div class="form-check">
                                <input class="form-check-input <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_a" value="" <?= (old('golongan_darah') == 'A') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="golongan_darah_a">
                                    Gol. darah A
                                </label>

                                <input class="form-check-input ml-2 <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_b" value="" <?= (old('golongan_darah') == 'B') ? 'checked' : ''; ?>>
                                <label class="form-check-label ml-4" for="golongan_darah_b">
                                    Gol. darah B
                                </label>

                                <input class="form-check-input ml-2 <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_ab" value="" <?= (old('golongan_darah') == 'AB') ? 'checked' : ''; ?>>
                                <label class="form-check-label ml-4" for="golongan_darah_ab">
                                    Gol. darah AB
                                </label>

                                <input class="form-check-input ml-2 <?= ($validation->hasError('golongan_darah')) ? 'is-invalid' : ''; ?>" type="radio" name="golongan_darah[]" id="golongan_darah_o" value="" <?= (old('golongan_darah') == 'O') ? 'checked' : ''; ?>>
                                <label class="form-check-label ml-4" for="golongan_darah_o">
                                    Gol. darah O
                                </label>

                                <div class="invalid-feedback">
                                    <?= $validation->getError('golongan_darah'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Status Perkawinan <i class="text-danger">*</i></label>
                        <div class="row ml-1">
                            <div class="form-check mr-4">
                                <input class="form-check-input mr-5 <?= ($validation->hasError('status_perkawinan')) ? 'is-invalid' : ''; ?>" type="radio" name="status_perkawinan[]" id="status_perkawinan_kawin" value="" <?= (old('status_perkawinan') == 'kawin') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status_perkawinan_kawin">
                                    Kawin
                                </label>

                                <input class="form-check-input ml-4 <?= ($validation->hasError('status_perkawinan')) ? 'is-invalid' : ''; ?>" type="radio" name="status_perkawinan[]" id="status_perkawinan_belum_kawin" value="" <?= (old('status_perkawinan') == 'belum kawin') ? 'checked' : ''; ?>>
                                <label class="form-check-label ml-5" for="status_perkawinan_belum_kawin">
                                    Belum Kawin
                                </label>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('status_perkawinan'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Kewarganegaraan <i class="text-danger">*</i></label>
                        <div class="row ml-1">
                            <div class="form-check mr-3">
                                <input class="form-check-input <?= ($validation->hasError('kewarganegaraan')) ? 'is-invalid' : ''; ?>" type="radio" name="kewarganegaraan[]" id="kewarganegaraan_wni" value="" <?= (old('kewarganegaraan') == 'WNI') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="kewarganegaraan_wni">
                                    WNI
                                </label>

                                <input class="form-check-input ml-4 <?= ($validation->hasError('kewarganegaraan')) ? 'is-invalid' : ''; ?>" type="radio" name="kewarganegaraan[]" id="kewarganegaraan_wna" value="" <?= (old('kewarganegaraan') == 'WNA') ? 'checked' : ''; ?>>
                                <label class="form-check-label ml-5" for="kewarganegaraan_wna">
                                    WNA
                                </label>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kewarganegaraan'); ?>
                                </div>
                            </div>
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
                        echo form_dropdown('hubungan_keluarga[]', $pilihan, '', $opt)
                        ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('hubungan_keluarga'); ?>
                        </div>

                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Foto KTP</label>
                        <div class="custom-file">
                            <label class="custom-file-label" for="doc_ktp">Choose file...</label>
                            <input type="file" class="custom-file-inputform-control input-group-sm <?= ($validation->hasError('doc_ktp')) ? 'is-invalid' : ''; ?>" name="doc_ktp[]" id="doc_ktp" value="">
                            <div class="invalid-feedback">
                                <?= $validation->getError('doc_ktp'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 d-flex justify-content-center">
                        <a style="border-radius: 100%;" href="#" class="btn btn-danger mx-auto" id="delete-form" data-toggle="tooltip" data-placement="top" title="Hapus form"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-md-4"></div>
                </div>

            </div>
            `);
        });
    }

    function hapusForm() {
        $(document).on('click', '#delete-form', function(e) {
            e.preventDefault();

            $(this).parents('.form-data').remove();
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


<?= $this->endSection(); ?>