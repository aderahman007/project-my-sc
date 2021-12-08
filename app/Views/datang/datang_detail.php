<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>


<!-- Page Heading -->
<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary">Detail Penduduk</h5>
            <div class="ml-auto">
                <a href="<?= $back; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                <a href="<?= $update; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Edit Individu</a>
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
                        <th width="38%">NIK</th>
                        <td><?= $penduduk->nik; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Nama</th>
                        <td><?= $penduduk->nama; ?></td>
                    </tr>

                    <tr>
                        <th width="38%">Jenis Kelamin</th>
                        <td><?= ($penduduk->jenis_kelamin == 'L') ? 'Laki-Laki' : 'Perempuan'; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Agama</th>
                        <td><?= $penduduk->agama; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Pekerjaan</th>
                        <td><?= $penduduk->pekerjaan; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Golongan Darah</th>
                        <td><?= $penduduk->golongan_darah; ?></td>
                    </tr>
                    <tr height="70px">
                        <th width="38%">Alamat</th>
                        <td><?= $penduduk->alamat; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Keterangan</th>
                        <td><?= $penduduk->keterangan; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered">

                    <tr>
                        <th width="38%">RT/RW</th>
                        <td><?= $penduduk->rt . '/' . $penduduk->rw; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Kel/Desa</th>
                        <td><?= getDesa($penduduk->desa); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Kecamatan</th>
                        <td><?= getKecamatan($penduduk->kecamatan); ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Kewarganegaraan</th>
                        <td><?= $penduduk->kewarganegaraan; ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Status Perkawinan</th>
                        <td><?= $penduduk->status_perkawinan; ?></td>
                    </tr>
                    <tr>
                        <th width="40%">Status</th>
                        <td><?= getStatus($penduduk->id_datang); ?></td>
                    </tr>
                    <tr>
                        <th width="40%">Pencatat</th>
                        <td><?= getPetugas($penduduk->pencatat); ?></td>
                    </tr>
                    <tr>
                        <th width="40%">Tanggal Datang</th>
                        <td><?= date('d-m-Y H:i:s', strtotime($penduduk->timestamp)); ?></td>
                    </tr>
                    <tr>
                        <th width="40%">Tanggal di Update</th>
                        <td><?= ($penduduk->updated == null) ? '' : date('d-m-Y H:i:s', strtotime($penduduk->updated)); ?></td>
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
            <h5 class="m-0 font-weight-bold text-primary">Foto KTP / kartu keluarga</h5>
        </div>
    </div>
    <div class="card-body">
        <?php if ($penduduk->doc_ktp != null) { ?>
            <div class="text-center">
                <img class="img-fluid" src="<?= base_url('images/datang') . '/' . $penduduk->doc_ktp; ?>" alt="">
                <a class="btn btn-sm btn-info form-control mt-5" href="<?= base_url('MutasiDatang/viewktp') . '/' . param_encrypt($penduduk->id_datang); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
            </div>
        <?php } else { ?>
            <h3 class="text-center">Foto belum di upload</h3>
        <?php } ?>
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