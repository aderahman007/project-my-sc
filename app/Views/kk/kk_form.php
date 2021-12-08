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
        <p class="text-secondary font-weight-light">Masukan data sesuai yang tertera pada Kartu Keluarga</p>
        <p class="text-secondary font-weight-light mb-1">Pada label yang tertanda <i class="text-danger">*</i> wajib di isi!</p>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <form id="form-kk" action="<?= $action; ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-row">
                <input type="hidden" name="id_kk" value="<?= param_encrypt($id_kk) ?>">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">No KK <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_kk')) ? 'is-invalid' : ''; ?>" name="no_kk" id="no_kk" value="<?= $no_kk; ?>" placeholder="Nomor kartu keluarga">
                    <div class="invalid-feedback">
                        <?= $validation->getError('no_kk'); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Dusun <i class="text-danger">*</i></label>
                        <select name="dusun" id="dusun" class="form-control form-control-sm <?= ($validation->hasError('dusun')) ? 'is-invalid' : ''; ?>">
                            <option selected disabled>~~ Pilih ~~</option>
                            <?php foreach ($data_dusun as $key => $value) : ?>
                                <option <?= ($value['id_dusun'] == $dusun) ? 'selected' : ''; ?> value="<?= $value['id_dusun']; ?>"><?= $value['dusun']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('dusun'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">RT/RW <i class="text-danger">*</i></label>
                        <div class="form-row">
                            <div class="col-sm-6">
                                <select name="rt" id="rt" class="form-control form-control-sm <?= ($validation->hasError('id_rt')) ? 'is-invalid' : ''; ?>">
                                    <option selected disabled>~~ Pilih ~~</option>
                                    <option <?= ($rt) ? 'selected' : ''; ?> value="<?= $rt; ?>"><?= getRt($rt); ?></option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('rt_ortu'); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <select disabled name="rw" id="rw" class="form-control form-control-sm <?= ($validation->hasError('id_rw')) ? 'is-invalid' : ''; ?>">
                                    <option selected value="<?= $rw; ?>"><?= ($rw) ? getRw($rw) : '~~ Pilih ~~'; ?></option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label font-weight-bold">Alamat <i class="text-danger">*</i></label>
                <textarea class="form-control form-control-sm <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" name="alamat" id="alamat" rows="2" placeholder="Nama jalan/No rumah"><?= $alamat; ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alamat'); ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Foto Kartu Keluarga <i class="text-danger">*</i></label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="doc_kk">Choose file...</label>
                        <input type="file" class="custom-file-input form-control input-group-sm <?= ($validation->hasError('doc_kk')) ? 'is-invalid' : ''; ?>" name="doc_kk" id="doc_kk" value="<?= $doc_kk; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('doc_kk'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Kode Pos <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('kode_pos')) ? 'is-invalid' : ''; ?>" name="kode_pos" id="kode_pos" value="<?= $kode_pos; ?>" placeholder="Kode Pos">
                    <div class="invalid-feedback">
                        <?= $validation->getError('kode_pos'); ?>
                    </div>

                </div>
            </div>
            <div class="form-row">
                <?php if ($doc_kk != null) { ?>
                    <div class="form-group col-md-12">
                        <label class="col-form-label font-weight-bold">Lihat foto kartu keluarga</label>
                        <a class="btn btn-sm btn-info form-control" href="<?= base_url('kk/viewkk') . '/' . param_encrypt($id_kk); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
                    </div>
                <?php } ?>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Provinsi <i class="text-danger">*</i></label>
                    <select class="form-control form-control-sm <?= ($validation->hasError('provinsi')) ? 'is-invalid' : ''; ?>" name="provinsi" id="provinsi" placeholder="Provinsi" disabled>
                        <option value="<?= $mnj_desa['provinsi']; ?>"><?= getProvinsi($mnj_desa['provinsi']); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('provinsi'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Kabupaten <i class="text-danger">*</i></label>
                    <select class="form-control form-control-sm <?= ($validation->hasError('kabupaten')) ? 'is-invalid' : ''; ?>" name="kabupaten" id="kabupaten" placeholder="Kabupaten" disabled>
                        <option value="<?= $mnj_desa['kabupaten']; ?>"><?= getKabupaten($mnj_desa['kabupaten']); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kabupaten'); ?>
                    </div>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Kecamatan <i class="text-danger">*</i></label>

                    <select class="form-control form-control-sm <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" name="kecamatan" id="kecamatan" placeholder="Kecamatan" disabled>
                        <option value="<?= $mnj_desa['kecamatan']; ?>"><?= getKecamatan($mnj_desa['kecamatan']); ?></option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kecamatan'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Desa/Kelurahan <i class="text-danger">*</i></label>

                    <select class="form-control form-control-sm <?= ($validation->hasError('desa')) ? 'is-invalid' : ''; ?>" name="desa" id="desa" placeholder="Desa" disabled>
                        <option value="<?= $mnj_desa['desa']; ?>"><?= getDesa($mnj_desa['desa']); ?></option>
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
        $('#provinsi').attr('disabled', false);
        $('#kabupaten').attr('disabled', false);
        $('#kecamatan').attr('disabled', false);
        $('#desa').attr('disabled', false);
        $('#rw').attr('disabled', false);
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

        // wilayah();

        getRt();
        getRw();

        var uri = '<?= $uri->getSegment(2); ?>';

        if (uri == 'update') {
            $.ajax({
                type: "post",
                url: "<?= site_url('Kk/getRtEdit'); ?>",
                data: {
                    dusun: $('#dusun').val(),
                    rt: '<?= $rt; ?>'
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#rt').html(response.data);
                    }
                }
            });
        }
    });

    function wilayah() {
        $('#provinsi').select2({
            'val': '18',
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Input Provinsi',
            ajax: {
                dataType: 'json',
                url: "<?= site_url('kk/search_provinsi'); ?>",
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
            },

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
        $('#dusun').change(function(e) {
            $.ajax({
                type: "post",
                url: "<?= site_url('Kk/getrt'); ?>",
                data: {
                    rw: $(this).val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#rt').html(response.data);
                    }
                }
            });
        });

    }

    function getRw() {
        $('#dusun').change(function(e) {
            var rw = $(this).val();
            var text = $(this).find(':selected').text();
            $('#rw').html('<option value="' + rw + '" selected>' + text.substr(6, 3) + '</option>');
        });
    }
</script>



<?= $this->endSection(); ?>