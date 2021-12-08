<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Hover table card start -->

<form id="form-pindah" action="<?= $actionTambah; ?>" method="POST">
    <!-- Modal -->
    <?= csrf_field(); ?>
    <div class="modal fade" id="pindahModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Mutasi Pindah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <p class="text-secondary font-weight-light mb-1">Pada label yang tertanda <i class="text-danger">*</i> wajib di isi!</p>
                    </div>
                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    <div class="col">
                        <label class="col-form-label font-weight-bold">NIK <i class="text-danger">*</i></label>
                        <select class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik" id="nik">
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nik'); ?>
                        </div>
                    </div>
                    <div class="col">
                        <label class="col-form-label font-weight-bold">Tanggal Pindah <i class="text-danger">*</i></label>
                        <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_pindah')) ? 'is-invalid' : ''; ?>" name="tanggal_pindah" id="tanggal_pindah" placeholder="Tanggal Pindah">
                        <div class="invalid-feedback">
                            <?= $validation->getError('tanggal_pindah'); ?>
                        </div>
                    </div>
                    <div class="col">
                        <label class="col-form-label font-weight-bold">Keterangan <sup class="text-primary">Inputkan Alamat Tujuan Pindah</sup></label>
                        <textarea class="form-control form-control-sm <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" name="keterangan" id="keterangan" rows="2" placeholder="Nama jalan/No rumah"></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('keterangan'); ?>
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
<?php foreach ($pindah as $d) : ?>
    <div class="modal fade" id="pindahModal<?= $d['id_pindah']; ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Mutasi Pindah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-pindah-update" action="<?= $actionUpdate; ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="col">
                            <p class="text-secondary font-weight-light mb-1">Pada label yang tertanda <i class="text-danger">*</i> wajib di isi!</p>
                        </div>
                        <!-- Divider -->
                        <hr class="sidebar-divider">
                        <input type="hidden" name="id_pindah" value="<?= $d['id_pindah']; ?>">
                        <input type="hidden" name="nik" value="<?= $d['id_penduduk']; ?>">
                        <div class="col">
                            <label class="col-form-label font-weight-bold">NIK <i class="text-danger">*</i></label>
                            <select class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik" id="nik" disabled>
                                <option value="<?= $d['id_penduduk']; ?>" selected><?= getNik($d['id_penduduk']); ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nik'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Tanggal Pindah <i class="text-danger">*</i></label>
                            <input type="date" class="form-control form-control-sm <?= ($validation->hasError('tanggal_pindah')) ? 'is-invalid' : ''; ?>" name="tanggal_pindah" id="tanggal_pindah" placeholder="Tanggal Pindah" value="<?= $d['tanggal_pindah']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal_pindah'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Keterangan <sup class="text-primary">Inputkan Alamat Tujuan Pindah</sup></label>
                            <textarea class="form-control form-control-sm <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" name="keterangan" id="keterangan" rows="2" placeholder="Nama jalan/No rumah"><?= $d['keterangan']; ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('keterangan'); ?>
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
    $(document).ready(function() {
        search_nik();
    });

    $("#form-pindah").on("submit", function() {
        $(".loading-simpan").html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(".loading-cencel").hide(0);
        $(".loading-simpan").attr('disabled', true);
    });

    $("#form-pindah-update").on("submit", function() {
        $(".loading-simpan").html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(".loading-cencel").hide(0);
        $(".loading-simpan").attr('disabled', true);
    });

    $(".form-control").on("click", function() {
        $(".loading-simpan").html('Simpan');
        $(".loading-cencel").show(0);
    });

    function search_nik() {
        $('#nik').select2({
            width: '100%',
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Input nik',
            ajax: {
                dataType: 'json',
                url: "<?= site_url('MutasiPindah/search_nik'); ?>",
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
</script>

<?= $this->endSection(); ?>