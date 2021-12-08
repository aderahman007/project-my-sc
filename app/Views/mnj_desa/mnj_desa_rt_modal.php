<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Hover table card start -->

<form id="form-rt" action="<?= $actionTambahRt; ?>" method="POST">
    <!-- Modal -->
    <?= csrf_field(); ?>
    <div class="modal fade" id="mnj_desa_rtModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah RT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <label class="col-form-label font-weight-bold">Nomor RT <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_rt')) ? 'is-invalid' : ''; ?>" name="no_rt" id="no_rt" placeholder="Nomor rt" value="<?= set_value('no_rt'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_rt'); ?>
                        </div>
                    </div>
                    <div class="col">
                        <label class="col-form-label font-weight-bold">Nomor RW <i class="text-danger">*</i></label>
                        <select name="id_rw" class="form-control <?= ($validation->hasError('id_rw')) ? 'is-invalid' : ''; ?>">
                            <option selected disabled>~~ Pilih ~~</option>
                            <?php foreach ($rw as $key => $value) : ?>
                                <option value="<?= $value['id_rw']; ?>"><?= $value['no_rw']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('rw'); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary loading-cencel" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary loading-simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal Edit -->
<?php foreach ($rt as $d) : ?>
    <div class="modal fade" id="mnj_desa_rt_updateModal<?= $d['id_rt']; ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Nomor RT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-rt-update" action="<?= $actionUpdateRt; ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id_rt" value="<?= $d['id_rt']; ?>">
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Nomor RT <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_rt')) ? 'is-invalid' : ''; ?>" name="no_rt" id="no_rt" placeholder="Nomor RT" value="<?= old('no_rt', $d['no_rt']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_rt'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Nomor RW <i class="text-danger">*</i></label>
                            <select name="id_rw" class="form-control <?= ($validation->hasError('id_rw')) ? 'is-invalid' : ''; ?>">
                                <option selected disabled>~~ Pilih ~~</option>
                                <?php foreach ($rw as $key => $value) : ?>
                                    <option <?= ($value['id_rw'] == $d['id_rw']) ? 'selected' : ''; ?> value="<?= $value['id_rw']; ?>"><?= $value['no_rw']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('rw'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary loading-cencel" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary loading-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/select2/select2.min.js"></script>

<script>
    $("#form-rw").on("submit", function() {
        $(".loading-simpan").html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(".loading-cencel").hide(0);
        $(".loading-simpan").attr('disabled', true);
    });

    $("#form-rw-update").on("submit", function() {
        $(".loading-simpan").html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(".loading-cencel").hide(0);
        $(".loading-simpan").attr('disabled', true);
    });

    $(".form-control").on("click", function() {
        $(".loading-simpan").html('Simpan');
        $(".loading-cencel").show(0);
    });
</script>

<?= $this->endSection(); ?>