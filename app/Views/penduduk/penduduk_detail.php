<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div id="cover-spin"></div>
        <div class="card-header py-3">
            <div class="row ml-1 mr-1">
                <h5 class="m-0 font-weight-bold text-primary">Detail Penduduk</h5>
                <div class="ml-auto">
                    <a href="<?= $back; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                    <a href="<?= $update; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Edit Penduduk</a>
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
                            <td><?= $penduduk->nama_lengkap; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Tempat/Tanggal Lahir</th>
                            <td><?= $penduduk->tempat_lahir . ', ' . date('d-m-Y', strtotime($penduduk->tanggal_lahir)); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Jenis Kelamin</th>
                            <td><?= ($penduduk->jenis_kelamin == 'L') ? 'Laki - Laki' : "Perempuan"; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Agama</th>
                            <td><?= $penduduk->agama; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Pekerjaan</th>
                            <td><?= $penduduk->jenis_pekerjaan; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Golongan Darah</th>
                            <td><?= $penduduk->golongan_darah; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Pendidikan</th>
                            <td><?= $penduduk->pendidikan; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Pekerjaan</th>
                            <td><?= $penduduk->jenis_pekerjaan; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Nama Ayah</th>
                            <td><?= $penduduk->nama_ayah; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Nama Ibu</th>
                            <td><?= $penduduk->nama_ibu; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th width="38%">Alamat</th>
                            <td><?= $penduduk->alamat; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">RT/RW</th>
                            <td><?= getRt($penduduk->rt) . '/' . getRw($penduduk->rw); ?></td>
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
                            <th width="38%">Status</th>
                            <td><?= getStatus($penduduk->id_penduduk); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Hubungan Keluarga</th>
                            <td><?= $penduduk->hubungan_keluarga; ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Pencatat</th>
                            <td><?= getPetugas($penduduk->pencatat); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Tanggal di Tambahkan</th>
                            <td><?= date('d-m-Y H:i:s', strtotime($penduduk->timestamp)); ?></td>
                        </tr>
                        <tr>
                            <th width="38%">Tanggal di Update</th>
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
                <h5 class="m-0 font-weight-bold text-primary">Foto kartu keluarga</h5>
            </div>
        </div>
        <div class="card-body">
            <?php if ($penduduk->doc_kk != null) { ?>
                <div class="text-center">
                    <img class="img-fluid" src="<?= base_url('images/kk') . '/' . $penduduk->doc_kk; ?>" alt="">
                    <a class="btn btn-sm btn-info form-control mt-5" href="<?= base_url('kk/viewkk') . '/' . param_encrypt($penduduk->id_kk); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
                </div>
            <?php } else { ?>
                <h3 class="text-center">Foto belum di upload</h3>
            <?php } ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div id="cover-spin"></div>
        <div class="card-header py-3">
            <div class="row ml-1 mr-1">
                <h5 class="m-0 font-weight-bold text-primary">Foto KTP</h5>
            </div>
        </div>
        <div class="card-body">
            <?php if ($penduduk->doc_ktp != null) { ?>
                <div class="text-center">
                    <img class="img-fluid" src="<?= base_url('images/ktp') . '/' . $penduduk->doc_ktp; ?>" alt="">
                    <a class="btn btn-sm btn-info form-control mt-5" href="<?= base_url('penduduk/viewKtp') . '/' . param_encrypt($penduduk->id_penduduk); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
                </div>
            <?php } else { ?>
                <h3 class="text-center">Foto belum di upload</h3>
            <?php } ?>
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