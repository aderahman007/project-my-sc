<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Hover table card start -->

<form id="form-rw" action="<?= $actionTambahRw; ?>" method="POST">
    <!-- Modal -->
    <?= csrf_field(); ?>
    <div class="modal fade" id="mnj_desa_rwModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah RW</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <label class="col-form-label font-weight-bold">Nomor RW <i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_rw')) ? 'is-invalid' : ''; ?>" name="no_rw" id="no_rw" placeholder="Nomor rw" value="<?= set_value('no_rw'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_rw'); ?>
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
<?php foreach ($rw as $d) : ?>
    <div class="modal fade" id="mnj_desa_rw_updateModal<?= $d['id_rw']; ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Nomor RW</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-rw-update" action="<?= $actionUpdateRw; ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id_rw" value="<?= $d['id_rw']; ?>">
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Nomor RW <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_rw')) ? 'is-invalid' : ''; ?>" name="no_rw" id="no_rw" placeholder="Nomor RW" value="<?= old('no_rw', $d['no_rw']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_rw'); ?>
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