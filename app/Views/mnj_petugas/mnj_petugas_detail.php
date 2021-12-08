<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary">Detail Petugas</h5>
            <div class="ml-auto">
                <a href="<?= $back; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                <a href="<?= $update; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Edit Petugas</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th width="38%">NIK</th>
                        <td><?= $user['nik']; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Nama</th>
                        <td><?= $user['nama']; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Email</th>
                        <td><?= $user['email']; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Dusun</th>
                        <td><?= getDusun($user['dusun']); ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Rt</th>
                        <td><?= getRt($user['rt']); ?></td>
                    </tr>


                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th width="38%">Password</th>
                        <td><?= '************'; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Role</th>
                        <td><?= $user['role']; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Nomor SK</th>
                        <td><?= $user['nomor_sk']; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Tanggal di Tetapkan</th>
                        <td><?= date('d-m-Y', strtotime($user['tanggal_ditetapkan'])); ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Tanggal Berakhir</th>
                        <td><?= date('d-m-Y', strtotime($user['tanggal_berakhir'])); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary">File SK</h5>
        </div>
    </div>
    <div class="card-body">
        <?php if ($user['doc_sk'] != null) { ?>
            <div class="text-center">
                <embed src="<?= base_url('images/sk') . '/' . $user['doc_sk']; ?>" type="application/pdf" width="100%" height="600px">
                <!-- <a class="btn btn-sm btn-info form-control mt-5" href="<?= base_url('MnjPetugas/viewSK') . '/' . $user['id_user']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat SK</a> -->
            </div>
        <?php } else { ?>
            <h3 class="text-center">SK belum di upload</h3>
        <?php } ?>
    </div>
</div>
<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script>
    $(".loading").on("click", function() {
        $(this).html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(this).addClass('disabled');
    });
</script>
<?= $this->endSection(); ?>