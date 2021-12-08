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

        <form id="form-kk" action="<?= $action . ($id_user == '' ? '' : '/' . $id_user); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-row">
                <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nik <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik" id="nik" value="<?= $nik; ?>" placeholder="Nik petugas">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nik'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nama <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="nama" value="<?= $nama; ?>" placeholder="Nama petugas">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Email <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" value="<?= $email; ?>" placeholder="Email petugas">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Password <i class="text-danger">*</i></label>
                    <input type="password" class="form-control form-control-sm <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password" value="" placeholder="Password petugas">
                    <div class="invalid-feedback">
                        <?= $validation->getError('password'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Nomor SK <i class="text-danger">*</i></label>
                    <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nomor_sk')) ? 'is-invalid' : ''; ?>" name="nomor_sk" id="nomor_sk" value="<?= $nomor_sk; ?>" placeholder="Nomor SK petugas">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nomor_sk'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Role <i class="text-danger">*</i></label>
                    <?php
                    $pilihan = [
                        "" => "~~Pilih~~",
                        "admin" => 'Admin',
                        "petugas" => 'Petugas',
                    ];

                    $error = ($validation->hasError('role')) ? 'is-invalid' : '';

                    $opt = 'class="form-control form-control-sm ' . $error . '"';
                    echo form_dropdown('role', $pilihan, $role, $opt)
                    ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('role'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Tanggal Ditetapkan <i class="text-danger">*</i></label>
                    <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_ditetapkan')) ? 'is-invalid' : ''; ?>" name="tanggal_ditetapkan" id="tanggal_ditetapkan" placeholder="Tanggal Lahir" value="<?= $tanggal_ditetapkan; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('tanggal_ditetapkan'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Tanggal Berakhir <i class="text-danger">*</i></label>
                    <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_berakhir')) ? 'is-invalid' : ''; ?>" name="tanggal_berakhir" id="tanggal_berakhir" placeholder="Tanggal Lahir" value="<?= $tanggal_berakhir; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('tanggal_berakhir'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">Dusun <i class="text-danger">*</i></label>
                    <select name="dusun" id="dusun" class="form-control form-control-sm <?= ($validation->hasError('dusun')) ? 'is-invalid' : ''; ?>">
                        <option selected disabled>~~ Pilih ~~</option>
                        <?php foreach ($data_dusun as $key_dusun => $value_dusun) : ?>
                            <option <?= ($value_dusun['id_dusun'] == $dusun) ? 'selected' : ''; ?> value="<?= $value_dusun['id_dusun']; ?>"><?= $value_dusun['dusun']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('dusun'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">RT <i class="text-danger">*</i></label>
                    <select name="rt" id="rt" class="form-control form-control-sm <?= ($validation->hasError('rt')) ? 'is-invalid' : ''; ?>">
                        <option selected disabled>~~ Pilih ~~</option>
                        <option <?= ($rt) ? 'selected' : ''; ?> value="<?= $rt; ?>"><?= getRt($rt); ?></option>

                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('rt'); ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label font-weight-bold">File SK <sup>PDF</sup> <i class="text-danger">*</i></label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="doc_sk">Choose file...</label>
                        <input type="file" class="custom-file-input form-control input-group-sm <?= ($validation->hasError('doc_sk')) ? 'is-invalid' : ''; ?>" name="doc_sk" id="doc_sk" value="<?= $doc_sk; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('doc_sk'); ?>
                        </div>
                    </div>
                </div>
                <?php if ($doc_sk != null) { ?>
                    <div class="form-group col-md-6">
                        <label class="col-form-label font-weight-bold">Lihat file SK</label>
                        <a class="btn btn-sm btn-info form-control" href="<?= base_url('mnjPetugas/viewSk') . '/' . $id_user; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat SK</a>
                    </div>
                <?php } ?>
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

        getRt();
        // wilayah();


        var uri = '<?= $uri->getSegment(2); ?>';

        if (uri == 'update') {
            $.ajax({
                type: "post",
                url: "<?= site_url('MnjPetugas/getRtEdit'); ?>",
                data: {
                    rw: $('#dusun').val(),
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
        console.log(uri);
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
                url: "<?= site_url('MnjPetugas/getrt'); ?>",
                data: {
                    dusun: $(this).val()
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
</script>



<?= $this->endSection(); ?>