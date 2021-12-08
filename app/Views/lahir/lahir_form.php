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
        <p class="text-secondary font-weight-light mb-1">Pada label yang tertanda <i class="text-danger">*</i> wajib di isi!</p>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <form id="form-kk" action="<?= $action; ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-row">
                <input type="hidden" name="id_lahir" value="<?= param_encrypt($id_lahir); ?>">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="nama" value="<?= $nama; ?>" placeholder="Nama lengkap">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Tempat Lahir <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('tempat_lahir')) ? 'is-invalid' : ''; ?>" name="tempat_lahir" id="tempat_lahir" value="<?= $tempat_lahir; ?>" placeholder="Tempat Lahir">
                    <div class="invalid-feedback">
                        <?= $validation->getError('tempat_lahir'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Hari Lahir <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "Senin" => 'Senin',
                        "Selasa" => 'Selasa',
                        "Rabu" => 'Rabu',
                        "Kamis" => 'Kamis',
                        "Jumat" => 'Jumat',
                        "Sabtu" => 'Sabtu',
                        "Minggu" => 'Minggu',
                    ];

                    $error = ($validation->hasError('hari_lahir')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('hari_lahir', $pilihan, $hari_lahir, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('hari_lahir'); ?>
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
                        "L" => 'Laki-Laki',
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
                    <label class="col-form-label font-weight-bold">Foto Akte Kelahiran</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="doc_akte">Choose file...</label>
                        <input type="file" class="custom-file-inputform-control input-group-sm <?= ($validation->hasError('doc_akte')) ? 'is-invalid' : ''; ?>" name="doc_akte" id="doc_akte" value="<?= $doc_akte ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('doc_akte'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($doc_akte != null) { ?>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            <label class="col-form-label font-weight-bold">Lihat foto kartu keluarga</label>
                            <a class="btn btn-sm btn-info form-control" href="<?= base_url('PeristiwaLahir/viewAkte') . '/' . param_encrypt($id_lahir); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="col-form-label font-weight-bold">Alamat Lahir <i class="text-danger">*</i></label>
                    <textarea class="form-control form-control-sm <?= ($validation->hasError('alamat_lahir')) ? 'is-invalid' : ''; ?>" name="alamat_lahir" id="alamat_lahir" rows="2" placeholder="Nama jalan/No rumah lahir"><?= $alamat_lahir; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat_lahir'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama Ayah <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ayah')) ? 'is-invalid' : ''; ?>" name="nama_ayah" id="nama_ayah" value="<?= $nama_ayah; ?>" placeholder="Nama Ayah">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_ayah'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama Ibu <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_ibu')) ? 'is-invalid' : ''; ?>" name="nama_ibu" id="nama_ibu" value="<?= $nama_ibu; ?>" placeholder="Nama Ibu">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_ibu'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="col-form-label font-weight-bold">Alamat Orang Tua <i class="text-danger">*</i></label>
                    <textarea class="form-control form-control-sm <?= ($validation->hasError('alamat_ortu')) ? 'is-invalid' : ''; ?>" name="alamat_ortu" id="alamat_ortu" rows="2" placeholder="Nama jalan/No rumah domisili"><?= $alamat_ortu; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat_ortu'); ?>
                    </div>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nomor Dusun Orang Tua<i class="text-danger">*</i></label>
                    <select name="dusun_ortu" id="dusun_ortu" class="form-control <?= ($validation->hasError('dusun_ortu')) ? 'is-invalid' : ''; ?>">
                        <option selected disabled>~~ Pilih ~~</option>
                        <?php foreach ($o_dusun as $key => $value) : ?>
                            <option <?= ($value['id_dusun'] == $dusun_ortu) ? 'selected' : ''; ?> value="<?= $value['id_dusun']; ?>"><?= $value['dusun']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('dusun_ortu'); ?>
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div class="col-md-6">
                        <label class="col-form-label font-weight-bold">Nomor RW Orang Tua<i class="text-danger">*</i></label>
                        <select disabled name="rw_ortu" id="rw_ortu" class="form-control <?= ($validation->hasError('id_rw')) ? 'is-invalid' : ''; ?>">
                            <option selected value="<?= $rw_ortu; ?>"><?= ($rw_ortu) ? getRw($rw_ortu) : '~~ Pilih ~~'; ?></option>
                            <!-- <?php foreach ($o_rw as $key => $value) : ?>
                                <option <?= ($value['id_rw'] == $rw_ortu) ? 'selected' : ''; ?> value="<?= $value['id_rw']; ?>"><?= $value['no_rw']; ?></option>
                            <?php endforeach ?> -->
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('rw_ortu'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label font-weight-bold">Nomor RT Orang Tua <i class="text-danger">*</i></label>
                        <select name="rt_ortu" id="rt_ortu" class="form-control <?= ($validation->hasError('id_rt')) ? 'is-invalid' : ''; ?>">
                            <option selected disabled>~~ Pilih ~~</option>
                            <option <?= ($rt_ortu) ? 'selected' : ''; ?> value="<?= $rt_ortu; ?>"><?= getRt($rt_ortu); ?></option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('rt_ortu'); ?>
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
        $('#rw_ortu').attr('disabled', false);
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

        var uri = '<?= $uri->getSegment(2); ?>';

        if (uri == 'update') {
            $.ajax({
                type: "post",
                url: "<?= site_url('PeristiwaLahir/getRtEdit'); ?>",
                data: {
                    dusun: $('#dusun_ortu').val(),
                    rt: '<?= $rt_ortu; ?>'
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#rt_ortu').html(response.data);
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
                url: "<?= site_url('kk/search_kabupaten'); ?>",
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
                url: "<?= site_url('kk/search_kecamatan'); ?>",
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
                url: "<?= site_url('kk/search_desa'); ?>",
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
        $('#dusun_ortu').change(function(e) {
            $.ajax({
                type: "post",
                url: "<?= site_url('PeristiwaLahir/getrt'); ?>",
                data: {
                    rw_ortu: $(this).val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#rt_ortu').html(response.data);
                    }
                }
            });
        });

    }

    function getRw() {
        $('#dusun_ortu').change(function(e) {
            var rw = $(this).val();
            var text = $(this).find(':selected').text();
            $('#rw_ortu').html('<option value="' + rw + '" selected>' + text.substr(6, 3) + '</option>');
        });
    }
</script>



<?= $this->endSection(); ?>