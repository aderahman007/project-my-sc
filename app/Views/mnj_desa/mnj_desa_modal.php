<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Hover table card start -->
<!-- Modal Edit -->
<?php foreach ($mnj_desa as $d) : ?>
    <div class="modal fade" id="mnj_desaModal<?= $d['id']; ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Desa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-mnj_desa-update" action="<?= $actionUpdate; ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $d['id']; ?>">
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Nama Desa <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('nama_desa')) ? 'is-invalid' : ''; ?>" name="nama_desa" id="nama_desa" placeholder="Nama desa" value="<?= set_value('nama_desa', $d['nama_desa']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_desa'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Provinsi <i class="text-danger">*</i></label>
                            <select class="form-control form-control-sm <?= ($validation->hasError('provinsi')) ? 'is-invalid' : ''; ?>" name="provinsi" id="provinsi" placeholder="Provinsi">
                                <option value="<?= set_value('provinsi', $d['provinsi']); ?>"><?= getProvinsi($d['provinsi']); ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('provinsi'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Kabupaten <i class="text-danger">*</i></label>
                            <select class="form-control form-control-sm <?= ($validation->hasError('kabupaten')) ? 'is-invalid' : ''; ?>" name="kabupaten" id="kabupaten" placeholder="Kabupaten">
                                <option value="<?= set_value('kabupaten', $d['kabupaten']); ?>"><?= getKabupaten($d['kabupaten']); ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kabupaten'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Kecamatan <i class="text-danger">*</i></label>

                            <select class="form-control form-control-sm <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" name="kecamatan" id="kecamatan" placeholder="Kecamatan">
                                <option value="<?= set_value('kecamatan', $d['kecamatan']); ?>"><?= getKecamatan($d['kecamatan']); ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kecamatan'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Desa/Kelurahan <i class="text-danger">*</i></label>

                            <select class="form-control form-control-sm <?= ($validation->hasError('desa')) ? 'is-invalid' : ''; ?>" name="desa" id="desa" placeholder="Desa">
                                <option value="<?= set_value('desa', $d['desa']); ?>"><?= getDesa($d['desa']); ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('desa'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Nama Kepala Desa <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('kepala_desa')) ? 'is-invalid' : ''; ?>" name="kepala_desa" id="kepala_desa" placeholder="kepala desa" value="<?= set_value('kepa_desa', $d['kepala_desa']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('kepala_desa'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Alamat <i class="text-danger">*</i></label>
                            <textarea class="form-control form-control-sm <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" name="alamat" id="alamat" rows="2" placeholder="Alamat"><?= set_value('alamat', $d['alamat']); ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('alamat'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Tentang Desa</label>
                            <textarea class="form-control form-control-sm <?= ($validation->hasError('tentang_desa')) ? 'is-invalid' : ''; ?>" name="tentang_desa" id="tentang_desa" rows="2" placeholder="Tentang Desa"><?= set_value('tentang_desa', $d['tentang_desa']); ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('tentang_desa'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Email <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" placeholder="Email" value="<?= set_value('kepa_desa', $d['email']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">No HP <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>" name="no_hp" id="no_hp" placeholder="No HP" value="<?= set_value('kepa_desa', $d['no_hp']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_hp'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Link Facebook <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('link_fb')) ? 'is-invalid' : ''; ?>" name="link_fb" id="link_fb" placeholder="Link Facebook" value="<?= set_value('link_fb', $d['link_fb']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('link_fb'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Link Instagram <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('link_ig')) ? 'is-invalid' : ''; ?>" name="link_ig" id="link_ig" placeholder="Link Instagram" value="<?= set_value('link_ig', $d['link_ig']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('link_ig'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Link Twitter <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('link_twitter')) ? 'is-invalid' : ''; ?>" name="link_twitter" id="link_twitter" placeholder="Link Twitter" value="<?= set_value('link_twitter', $d['link_twitter']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('link_fb'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Link Youtube <i class="text-danger">*</i></label>
                            <input type="text" class="form-control form-control-sm <?= ($validation->hasError('link_youtube')) ? 'is-invalid' : ''; ?>" name="link_youtube" id="link_youtube" placeholder="Link Youtube" value="<?= set_value('link_youtube', $d['link_youtube']); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('link_youtube'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label font-weight-bold">Logo Desa <i class="text-danger">*</i></label>
                            <div class="custom-file form-control form-control-sm">
                                <label class="custom-file-label" for="logo">Choose file...</label>
                                <input type="file" class="custom-file-inputform-control input-group-sm <?= ($validation->hasError('logo')) ? 'is-invalid' : ''; ?>" name="logo" id="logo" value="<?= set_value('name', $d['desa']); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('logo'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <?php if ($d['logo'] != null) { ?>
                                <label class="col-form-label font-weight-bold">Lihat Logo Desa</label>
                                <a class="btn btn-sm btn-info form-control" href="<?= base_url('MnjDesa/viewLogo') . '/' . $d['id']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat logo</a>
                            <?php } ?>
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

<!-- Modal detail -->
<?php foreach ($mnj_desa as $d) : ?>
    <div class="modal fade" id="mnj_desa_detailModal<?= $d['id']; ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Desa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-mnj_desa-detail">
                    <div class="modal-body">
                        <fieldset disabled>
                            <input type="hidden" name="id" value="<?= $d['id']; ?>">
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Nama Desa <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="nama_desa" id="nama_desa" placeholder="Nama desa" value="<?= $d['nama_desa']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Provinsi <i class="text-danger">*</i></label>
                                <select class="form-control form-control-sm" name="provinsi" id="provinsi" placeholder="provinsi">
                                    <option value="<?= $d['provinsi']; ?>"><?= getProvinsi($d['provinsi']); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Kabupaten <i class="text-danger">*</i></label>
                                <select class="form-control form-control-sm" name="kabupaten" id="kabupaten" placeholder="Kabupaten">
                                    <option value="<?= $d['kabupaten']; ?>"><?= getKabupaten($d['kabupaten']); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Kecamatan <i class="text-danger">*</i></label>

                                <select class="form-control form-control-sm" name="kecamatan" id="kecamatan" placeholder="Kecamatan">
                                    <option value="<?= $d['kecamatan']; ?>"><?= getKecamatan($d['kecamatan']); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Desa/Kelurahan <i class="text-danger">*</i></label>

                                <select class="form-control form-control-sm" name="desa" id="desa" placeholder="Desa">
                                    <option value="<?= $d['desa']; ?>"><?= getDesa($d['desa']); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Nama Kepala Desa <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="kepala_desa" id="kepala_desa" placeholder="kepala desa" value="<?= $d['kepala_desa']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Alamat</label>
                                <textarea class="form-control form-control-sm" name="alamat" id="alamat" rows="2" placeholder="Alamat"><?= $d['alamat']; ?></textarea>
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Tentang Desa</label>
                                <textarea class="form-control form-control-sm" name="tentang_desa" id="tentang_desa" rows="3" placeholder="Tentang Desa"><?= $d['tentang_desa']; ?></textarea>
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Email <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="email" id="email" placeholder="Email " value="<?= $d['email']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">No HP <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="no_hp" id="no_hp" placeholder="no_hp" value="<?= $d['no_hp']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Link Facebook <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="link_fb" id="link_fb" placeholder="link_fb " value="<?= $d['link_fb']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Link Instagram <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="link_ig" id="link_ig" placeholder="link instagram " value="<?= $d['link_ig']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Link Twitter <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="link_twitter" id="link_twitter" placeholder="link_twitter " value="<?= $d['link_twitter']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Link Youtube <i class="text-danger">*</i></label>
                                <input type="text" class="form-control form-control-sm" name="link_youtube" id="link_youtube" placeholder="link_youtube " value="<?= $d['link_youtube']; ?>">
                            </div>
                            <div class="col">
                                <label class="col-form-label font-weight-bold">Logo Desa</label>
                                <img src="<?= base_url('images/desa') . '/' . $d['logo']; ?>" class="rounded-sm mx-auto d-block" alt="logo" width="200px" height="200px">
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary loading-cencel" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/select2/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        bsCustomFileInput.init();

        dataProvinsi()
    });


    function dataProvinsi() {
        $('#provinsi').select2({
            width: '100%',
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Input Provinsi',
            ajax: {
                dataType: 'json',
                url: "<?= site_url('MnjDesa/search_provinsi'); ?>",
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
                url: "<?= site_url('MnjDesa/search_kabupaten'); ?>",
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
                url: "<?= site_url('MnjDesa/search_kecamatan'); ?>",
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
                url: "<?= site_url('MnjDesa/search_desa'); ?>",
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

    $("#form-mnj_desa-update").on("submit", function() {
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