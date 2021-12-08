<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?></h5>
            <div class="ml-auto">

                <a href="<?= site_url('kk/download_format'); ?>" class="btn btn-info btn-sm loading"><i class="fa fa-download"></i> Download format import</a>

            </div>
        </div>
    </div>
    <div class="card-body">

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
                <?php
                $i = session()->getFlashdata('show_sukses');
                foreach ($i as $key) {
                    echo $key . '<br>';
                }

                ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error'); ?>
                <?php
                $i = session()->getFlashdata('show_error');
                foreach ($i as $key) {
                    echo $key . '<br>';
                }

                ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('jml_kurang_16')) : ?>
            <div class="alert alert-warning" role="alert">
                <?= session()->getFlashdata('jml_kurang_16'); ?>
                <?php
                $i = session()->getFlashdata('show_kurang_16');
                foreach ($i as $key) {
                    echo $key . '<br>';
                }

                ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('jml_not_found_kk')) : ?>
            <div class="alert alert-warning" role="alert">
                <?= session()->getFlashdata('jml_not_found_kk'); ?>
                <?php
                $i = session()->getFlashdata('show_not_found_kk');
                foreach ($i as $key) {
                    echo $key . '<br>';
                }

                ?>
            </div>
        <?php endif ?>

        <form id="form-penduduk" action="<?= $action; ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-row">
                <div class="col-md-12">
                    <label class="font-weight-bold">Pilih File Excel</label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-10">
                    <div class="custom-file">
                        <?= csrf_field(); ?>
                        <label class="custom-file-label" for="fileimport">Choose file...</label>
                        <input type="file" class="custom-file-input form-control input-group-sm <?= ($validation->hasError('fileimport')) ? 'is-invalid' : ''; ?>" name="fileimport" id="fileimport">
                        <div class="invalid-feedback">
                            <?= $validation->getError('fileimport'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary ml-2 loading-simpan">Import</button>
                </div>
            </div>

        </form>
    </div>
</div>
<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/select2/select2.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/bs-custom-file-input.min.js"></script>
<script>
    $("#form-penduduk").on("submit", function() {
        $('#provinsi').attr('disabled', false);
        $('#kabupaten').attr('disabled', false);
        $('#kecamatan').attr('disabled', false);
        $('#desa').attr('disabled', false);
        $(".loading-simpan").html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(".loading-simpan").attr('disabled', true);
    });
</script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();

        // wilayah();
    });
</script>



<?= $this->endSection(); ?>