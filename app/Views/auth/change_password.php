<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('sukses_password')) : ?>

    <div class="flash-data-sukses-password" data-flashdata="<?= session()->getFlashdata('sukses_password'); ?>"></div>
<?php endif ?>
<?php if (session()->getFlashdata('error_password')) : ?>

    <div class="flash-data-error-password" data-flashdata="<?= session()->getFlashdata('error_password'); ?>"></div>
<?php endif ?>
<div class="card shadow">
    <div class="card-header py-3 mb-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary">Ubah Password</h5>
        </div>
    </div>
    <div class="card-body">
        <form id="form-rw" action="change_password" method="POST">
            <!-- Modal -->
            <?= csrf_field(); ?>

            <div class="col">
                <label class="col-form-label font-weight-bold">Password Lama <i class="text-danger">*</i></label>
                <input type="password" class="form-control form-control-sm <?= ($validation->hasError('old_password')) ? 'is-invalid' : ''; ?>" name="old_password" id="old_password" placeholder="Password lama" value="<?= set_value('old_password'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('old_password'); ?>
                </div>
            </div>
            <div class="col">
                <label class="col-form-label font-weight-bold">Password Baru <i class="text-danger">*</i></label>
                <input type="password" class="form-control form-control-sm <?= ($validation->hasError('new_password')) ? 'is-invalid' : ''; ?>" name="new_password" id="new_password" placeholder="Password baru" value="<?= set_value('new_password'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('new_password'); ?>
                </div>
            </div>
            <div class="col">
                <label class="col-form-label font-weight-bold">Ulangi Password <i class="text-danger">*</i></label>
                <input type="password" class="form-control form-control-sm <?= ($validation->hasError('repeat_password')) ? 'is-invalid' : ''; ?>" name="repeat_password" id="repeat_password" placeholder="Ulangi password" value="<?= set_value('repeat_password'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('repeat_password'); ?>
                </div>
            </div>

            <div class="row float-right mr-1">
                <a href="<?= site_url('admin'); ?>" class="btn btn-secondary mt-3 mr-3 loading-cencel">Cencel</a>
                <button class="btn btn-primary mt-3 mr-3 loading-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url(); ?>/assets/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    const flashSuksesPassword = $('.flash-data-sukses-password').data('flashdata');
    const flashErrorPassword = $('.flash-data-error-password').data('flashdata');

    if (flashSuksesPassword) {
        Swal.fire({
            title: 'Success',
            text: flashSuksesPassword + " Apakah anda ingin logout dan login dengan password baru anda?",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya ingin logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= site_url('logout'); ?>";
            }
        });
    }
    if (flashErrorPassword) {
        Swal.fire({
            icon: 'error',
            title: "Gagal",
            text: flashErrorPassword,
            type: 'error'
        });
    }
</script>

<?= $this->endSection(); ?>