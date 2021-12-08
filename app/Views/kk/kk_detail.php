<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary">Detail Kartu Keluarga</h5>
            <div class="ml-auto">
                <a href="<?= $back; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                <a href="<?= $update; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Edit KK</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-3">
                <img src="<?= base_url(); ?>/assets/img/garuda.png" width="50px" height="50px" alt="" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h4 class="font-weight-bold text-center">KARTU KELUARGA</h4>
                <h6 class="font-weight-normal text-center">No : <?= $kk['no_kk']; ?></h6>
            </div>
            <div class="col-md-3">
                <!--  -->
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-7">
                <div class="row">
                    <h6 class="col-md-6">Nama Kepala Keluarga</h6>
                    <h6> : <?= (getKepalaKeluarga($kk['id_kk']) != null) ? getKepalaKeluarga($kk['id_kk']) : 'Belum di update' ?></h6>
                </div>
                <div class="row">
                    <h6 class="col-md-6">Alamat</h6>
                    <h6> : <?= $kk['alamat']; ?></h6>
                </div>
                <div class="row">
                    <h6 class="col-md-6">RT/RW</h6>
                    <h6> : <?= $kk['rt'] . '/' . $kk['rw']; ?></h6>
                </div>
                <div class="row">
                    <h6 class="col-md-6">Desa/Kelurahan</h6>
                    <h6> : <?= getDesa($kk['desa']); ?></h6>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <h6 class="col-md-6">Kecamatan</h6>
                    <h6> : <?= getKecamatan($kk['kecamatan']); ?></h6>
                </div>
                <div class="row">
                    <h6 class="col-md-6">Kabupaten/Kota</h6>
                    <h6> : <?= getKabupaten($kk['kabupaten']); ?></h6>
                </div>
                <div class="row">
                    <h6 class="col-md-6">Kode Pos</h6>
                    <h6> : <?= $kk['kode_pos']; ?></h6>
                </div>
                <div class="row">
                    <h6 class="col-md-6">Provinsi</h6>
                    <h6> : <?= getProvinsi($kk['provinsi']); ?></h6>
                </div>
            </div>
        </div>

        <div class="table-responsive">

            <table style="width: 100%; border-collapse: collapse; border: 2px solid black;" class="table table-sm table-bordered mb-1">
                <thead>
                    <tr>
                        <th scope="col" class="text-center  align-middle">No</th>
                        <th scope="col" class="text-center align-middle">Nama Lengkap</th>
                        <th scope="col" class="text-center align-middle">NIK</th>
                        <th scope="col" class="text-center align-middle">Jenis Kelamin</th>
                        <th scope="col" class="text-center align-middle">Tempat Lahir</th>
                        <th width="10%" scope="col" class="text-center align-middle">Tanggal Lahir</th>
                        <th scope="col" class="text-center align-middle">Agama</th>
                        <th scope="col" class="text-center align-middle">Pendidikan</th>
                        <th scope="col" class="text-center align-middle">Jenis Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-primary">
                        <td class="text-center"></td>
                        <td class="text-center">(1)</td>
                        <td class="text-center">(2)</td>
                        <td class="text-center">(3)</td>
                        <td class="text-center">(4)</td>
                        <td class="text-center">(5)</td>
                        <td class="text-center">(6)</td>
                        <td class="text-center">(7)</td>
                        <td class="text-center">(8)</td>
                    </tr>
                    <?php if ($individu == null) : ?>
                        <tr>
                            <td colspan="9" class="text-center">Data belum di update</td>
                        </tr>
                    <?php endif ?>
                    <?php $no = 1;
                    foreach ($individu as $i) : ?>
                        <tr>
                            <th scope="row" class="text-center"><?= $no++; ?></th>
                            <td><?= $i['nama_lengkap']; ?></td>
                            <td><?= $i['nik']; ?></td>
                            <td><?= ($i['jenis_kelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan'; ?></td>
                            <td><?= $i['tempat_lahir']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', strtotime($i['tanggal_lahir'])); ?></td>
                            <td><?= $i['agama']; ?></td>
                            <td><?= $i['pendidikan']; ?></td>
                            <td><?= $i['jenis_pekerjaan']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <!--  -->
            <table style="width: 100%; border-collapse: collapse; border: 2px solid black;" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" scope="col" class="text-center align-middle">No</th>
                        <th rowspan="2" scope="col" class="text-center align-middle">Status Perkawinan</th>
                        <th rowspan="2" scope="col" class="text-center align-middle">Status Hubungan Dalam Keluarga</th>
                        <th rowspan="2" scope="col" class="text-center align-middle">Kewarganegaraan</th>
                        <th colspan="2" scope="col" class="text-center align-middle">Documen Imigrasi</th>

                        <th colspan="2" scope="col" class="text-center align-middle">Nama Orang Tua</th>

                    </tr>
                    <tr>
                        <th scope="col" class="text-center align-middle">No. Paspor</th>
                        <th scope="col" class="text-center align-middle">No. KITAS/KITAP</th>
                        <th scope="col" class="text-center align-middle">Ayah</th>
                        <th scope="col" class="text-center align-middle">Ibu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-primary">
                        <td class="text-center"></td>
                        <td class="text-center">(9)</td>
                        <td class="text-center">(10)</td>
                        <td class="text-center">(11)</td>
                        <td class="text-center">(12)</td>
                        <td class="text-center">(13)</td>
                        <td class="text-center">(14)</td>
                        <td class="text-center">(15)</td>
                    </tr>
                    <?php if ($individu == null) : ?>
                        <tr>
                            <td colspan="9" class="text-center">Data belum di update</td>
                        </tr>
                    <?php endif ?>
                    <?php $no = 1;
                    foreach ($individu as $i) : ?>
                        <tr>
                            <th scope="row" class="text-center"><?= $no++; ?></th>
                            <td><?= $i['status_perkawinan']; ?></td>
                            <td><?= $i['hubungan_keluarga']; ?></td>
                            <td><?= $i['kewarganegaraan']; ?></td>
                            <td class="text-center"><?= ($i['no_paspor'] == '') ? '-' : $i['no_paspor']; ?></td>
                            <td class="text-']center"><?= ($i['no_kitas_or_kitab'] == '') ? '-' : $i['no_kitas_or_kitab']; ?></td>
                            <td><?= $i['nama_ayah']; ?></td>
                            <td><?= $i['nama_ibu']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr height="70px">
                        <th width="38%">Pencatat</th>
                        <td><?= getPetugas($kk['pencatat']); ?></td>
                    </tr>

                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th width="38%">Tanggal di Tambahkan</th>
                        <td><?= date('d-m-Y H:i:s', strtotime($kk['timestamp'])); ?></td>
                    </tr>
                    <tr>
                        <th width="38%">Tanggal di Update</th>
                        <td><?= ($kk['updated'] == null) ? '' : date('d-m-Y H:i:s', strtotime($kk['updated'])); ?></td>
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
        <?php if ($kk['doc_kk'] != null) { ?>
            <div class="text-center">
                <img class="img-fluid" src="<?= base_url('images/kk') . '/' . $kk['doc_kk']; ?>" alt="">
                <a class="btn btn-sm btn-info form-control mt-5" href="<?= base_url('kk/viewkk') . '/' . param_encrypt($kk['id_kk']); ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-search-plus" aria-hidden="true"></i> Lihat foto</a>
            </div>
        <?php } else { ?>
            <h3 class="text-center">Foto belum di upload</h3>
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