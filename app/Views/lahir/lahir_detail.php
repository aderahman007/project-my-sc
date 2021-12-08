<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div id="cover-spin"></div>
        <div class="card-header py-3">
            <div class="row ml-1 mr-1">
                <h5 class="m-0 font-weight-bold text-primary">Detail Kelahiran</h5>
                <div class="ml-auto">
                    <a href="<?= $back; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                    <a href="<?= $update; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Edit Kelahiran</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-12">
                    <h5 class="font-weight-bold text-center m-0">PROVINSI LAMPUNG</h5>
                    <h6 class="font-weight-bold text-center mb-3">KABUPATEN LAMPUNG SELATAN</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th width="38%">Nama</th>
                            <td><?= $lahir->nama; ?></td>
                        </tr>

                        <tr>
                            <th width="38%">Tempat Lahir</th>
                            <td><?= $lahir->tempat_lahir; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Hari Lahir</th>
                            <td><?= $lahir->hari_lahir; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Tanggal Lahir</th>
                            <td><?= date('d-m-Y', strtotime($lahir->tanggal_lahir)); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Jenis kelamin</th>
                            <td><?= ($lahir->jenis_kelamin == "L") ? "Laki-Laki" : "Perempuan"; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Alamat Lahir</th>
                            <td><?= $lahir->alamat_lahir; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Keterangan</th>
                            <td><?= $lahir->keterangan; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-bordered">

                        <tr>
                            <th width="38%">Nama Ayah</th>
                            <td><?= $lahir->nama_ayah; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Nama Ibu</th>
                            <td><?= $lahir->nama_ibu; ?></td>
                        </tr>
                        <tr height="70px">
                            <th scope="row">Alamat Orang Tua</th>
                            <td><?= $lahir->alamat_ortu . ', ' . $lahir->dusun_ortu . ', RW.' . getRw($lahir->rw_ortu) . ', RT.' . getRt($lahir->rt_ortu); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Pencatat</th>
                            <td><?= getPetugas($lahir->pencatat); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Tanggal di Tambahkan</th>
                            <td><?= date('d-m-Y H:i:s', strtotime($lahir->timestamp)); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Tanggal di Update</th>
                            <td><?= ($lahir->updated == null) ? '' : date('d-m-Y H:i:s', strtotime($lahir->updated)); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div id="cover-spin"></div>
            <div class="card-header py-3">
                <div class="row ml-1 mr-1">
                    <h5 class="m-0 font-weight-bold text-primary">Foto Akte Kelahiran</h5>
                </div>
            </div>
            <div class="card-body">
                <?php if ($lahir->doc_akte != null) { ?>
                    <div class="text-center">
                        <img class="img-fluid" src="<?= base_url('images/akte') . '/' . $lahir->doc_akte; ?>" alt="">
                        <a class="btn btn-sm btn-info form-control mt-5" href="<?= base_url('PeristiwaLahir/viewakte') . '/' . param_encrypt($lahir->id_lahir); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
                    </div>
                <?php } else { ?>
                    <h3 class="text-center">Foto belum di upload</h3>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<?= $this->endSection(); ?>