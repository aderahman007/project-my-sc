<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Penduduk</title>


  <!-- Custom styles for this template-->
  <link href="<?= base_url(); ?>/assets/css/sb-admin-2.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/assets/select2/select2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style type="text/css" media="print">
    @media print {
      @page {
        size: landscape;
        /* margin: 0mm; */
        margin-top: 15mm;
        margin-bottom: 15mm;
        padding: 0px;
      }

      th {
        background-color: honeydew;
      }

      body {
        margin-top: 50mm;
        margin-bottom: 50mm;
        margin-left: 0mm;
        margin-right: 0mm
      }

      .pagebreak {
        clear: both;
        page-break-before: always;
        page-break-after: always;
      }

      .no-border {
        border-top: none !important;
      }



      /* table {
                page-break-inside: auto
            } */

      /* page-break-after works, as well */

    }
  </style>
</head>

<body class="mx-5 my-5 text-black justify-content-center">

  <div class="row">
    <img src="<?= base_url('images/desa/' . $mnj_desa['logo']); ?>" class="rounded d-block mb-3 ml-5" alt="Logo" width="80px" height="80px">
    <div class="col text-center">
      <h4 class="mb-0 mx-auto"><?= $judul1; ?></h3>
        <h5 class="mb-0 mx-auto">Desa <?= getDesa($mnj_desa['desa']) . ' ' . getDusun($dusun); ?></h5>
        <?php if ($tahun != "") : ?>
          <h5 class="mb-3 mx-auto"><?= 'Per-Tahun ' . $tahun; ?></h5>
        <?php endif ?>
    </div>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr class="table-active">
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Tempat Lahir</th>
        <th scope="col">Tanggal Lahir</th>
        <th scope="col">RT</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($lahir == null) : ?>
        <tr>
          <td colspan="5" class="text-center">Data Kosong</td>
        </tr>
      <?php endif ?>
      <?php $no = 1;
      foreach ($lahir as $key => $value) : ?>
        <tr>
          <th class="text-center" scope="row" width="5%"><?= $no++; ?></th>
          <td><?= $value['nama']; ?></td>
          <td><?= $value['tempat_lahir']; ?></td>
          <td class="text-center"><?= $value['tanggal_lahir']; ?></td>
          <td class="text-center"><?= $value['rt_ortu']; ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <br>
  <div class="row">
    <div class="ml-auto mr-3">
      <p>Branti Raya, <?= convertTanggal(date('Y-m-d')); ?></p><br><br>
      <p><?= $mnj_desa['kepala_desa']; ?></p>
    </div>
  </div>

  <div class="pagebreak"></div>


  <div class="row">
    <img src="<?= base_url('images/desa/' . $mnj_desa['logo']); ?>" class="rounded d-block mb-3 ml-5" alt="Logo" width="80px" height="80px">
    <div class="col text-center">
      <h4 class="mb-0 mx-auto"><?= $judul2; ?></h3>
        <h5 class="mb-0 mx-auto">Desa <?= getDesa($mnj_desa['desa']) . ' ' . getDusun($dusun); ?></h5>
        <?php if ($tahun != "") : ?>
          <h5 class="mb-3 mx-auto"><?= 'Per-Tahun ' . $tahun; ?></h5>
        <?php endif ?>
    </div>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr class="table-active">
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">tanggal_kematian</th>
        <th scope="col">RT</th>
        <th scope="col">TPU</th>
      </tr>
    </thead>
    <tbody>

      <?php if ($kematian == null) : ?>
        <tr>
          <td colspan="5" class="text-center">Data Kosong</td>
        </tr>
      <?php endif ?>
      <?php $no = 1;
      foreach ($kematian as $key => $value) : ?>
        <tr>
          <th class="text-center" scope="row" width="5%"><?= $no++; ?></th>
          <td><?= $value['nama_lengkap']; ?></td>
          <td><?= $value['tanggal_kematian']; ?></td>
          <td class="text-center"><?= getRt($value['rt']); ?></td>
          <td class="text-center"><?= $value['tpu']; ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <br><br><br><br>
  <div class="row">
    <div class="ml-auto mr-3">
      <p>Branti Raya, <?= convertTanggal(date('Y-m-d')); ?></p><br><br><br>
      <p><?= $mnj_desa['kepala_desa']; ?></p>
    </div>
  </div>
  <br><br><br><br>

  <div class="pagebreak"></div>

  <div class="row">
    <img src="<?= base_url('images/desa/' . $mnj_desa['logo']); ?>" class="rounded d-block mb-3 ml-5" alt="Logo" width="80px" height="80px">
    <div class="col text-center">
      <h4 class="mb-0 mx-auto"><?= $judul3; ?></h3>
        <h5 class="mb-0 mx-auto">Desa <?= getDesa($mnj_desa['desa']) . ' ' . getDusun($dusun); ?></h5>
        <?php if ($tahun != "") : ?>
          <h5 class="mb-3 mx-auto"><?= 'Per-Tahun ' . $tahun; ?></h5>
        <?php endif ?>
    </div>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr class="table-active">
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">NIK</th>
        <th scope="col">Nomor KK</th>
        <th scope="col">tanggal_pindah</th>
        <th scope="col">RT</th>
        <th scope="col">Alamat Tujuan Pindah</th>
      </tr>
    </thead>
    <tbody>

      <?php if ($pindah == null) : ?>
        <tr>
          <td colspan="7" class="text-center">Data Kosong</td>
        </tr>
      <?php endif ?>
      <?php $no = 1;
      foreach ($pindah as $key => $value) : ?>
        <tr>
          <th class="text-center" scope="row" width="5%"><?= $no++; ?></th>
          <td><?= $value['nama_lengkap']; ?></td>
          <td><?= $value['nik']; ?></td>
          <td><?= $value['no_kk']; ?></td>
          <td><?= $value['tanggal_pindah']; ?></td>
          <td class="text-center"><?= getRt($value['rt']); ?></td>
          <td><?= $value['keterangan']; ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <br><br><br>
  <div class="row">
    <div class="ml-auto mr-3">
      <p>Branti Raya, <?= convertTanggal(date('Y-m-d')); ?></p><br><br><br>
      <p><?= $mnj_desa['kepala_desa']; ?></p>
    </div>
  </div>
  <br><br>

  <div class="pagebreak"></div>
  <div class="row">
    <img src="<?= base_url('images/desa/' . $mnj_desa['logo']); ?>" class="rounded d-block mb-3 ml-5" alt="Logo" width="80px" height="80px">
    <div class="col text-center">
      <h4 class="mb-0 mx-auto"><?= $judul1; ?></h3>
        <h5 class="mb-0 mx-auto">Desa <?= getDesa($mnj_desa['desa']) . ' ' . getDusun($dusun); ?></h5>
        <?php if ($tahun != "") : ?>
          <h5 class="mb-3 mx-auto"><?= 'Per-Tahun ' . $tahun; ?></h5>
        <?php endif ?>
    </div>
  </div>


  <table class="table table-bordered">
    <thead>
      <tr class="table-active">
        <th scope="col">No</th>
        <th scope="col">Jenis Kelamin Penduduk</th>
        <th scope="col">Jumlah</th>
        <th scope="col">Persentase</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // $h_total = 0;
      // $perempuan = 0;
      // $pria = 0;

      if ($total != null) {
        $h_total = $total->total;
      } else {
        $h_total = 0;
      }

      if ($pr != null) {
        $perempuan = $pr->total;
      } else {
        $perempuan = 0;
      }

      if ($lk != null) {
        $pria = $lk->total;
      } else {
        $pria = 0;
      }

      ?>
      <tr>
        <th scope="row" class="align-middle text-center">1</th>
        <td>Laki-Laki</td>
        <td class="text-center"><?= $pria ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($pria * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">2</th>
        <td>Perempuan</td>
        <td class="text-center"><?= $perempuan; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($perempuan * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">3</th>
        <td class="text-center">Jumlah</td>
        <td class="text-center"><?= $perempuan + $pria; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format(($pria * 100 / $h_total) + ($perempuan * 100 / $h_total), 1) . ' %'; ?></td>
      </tr>

    </tbody>
  </table>
  <br><br><br>
  <div class="row">
    <div class="ml-auto mr-3">
      <p>Branti Raya, <?= convertTanggal(date('Y-m-d')); ?></p><br><br><br>
      <p><?= $mnj_desa['kepala_desa']; ?></p>
    </div>
  </div>
  <br><br>

  <div class="pagebreak"></div>
  <div class="row mt-2">
    <img src="<?= base_url('images/desa/' . $mnj_desa['logo']); ?>" class="rounded d-block ml-5" alt="Logo" width="80px" height="80px">
    <div class="col text-center">
      <h4 class="mb-0 mx-auto"><?= $judul2; ?></h4>
      <h5 class="mb-0 mx-auto">Desa <?= getDesa($mnj_desa['desa']) . ' ' . getDusun($dusun); ?></h5>
      <?php if ($tahun != "") : ?>
        <h5 class="mb-3 mx-auto"><?= 'Per-Tahun ' . $tahun; ?></h5>
      <?php endif ?>
    </div>
  </div>
  <table class="table table-sm table-bordered">
    <thead>
      <tr class="table-active">
        <th scope="col">No</th>
        <th scope="col">Kelompok Usia Sekolah</th>
        <th scope="col">Kelompok Usia Kerja</th>
        <th scope="col">Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $umur_0 = 0;
      $umur_4 = 0;
      $umur_7 = 0;
      $umur_13 = 0;
      $umur_16 = 0;
      $umur_19 = 0;


      // echo $umur[2]->umur;die;


      if ($umur[0] != null) {
        $umur_0 = $umur[0]->umur;
      }

      if ($umur[1] != null) {
        $umur_4 = $umur[1]->umur;
      }

      if ($umur[2] != null) {
        $umur_7 = $umur[2]->umur;
      }

      if ($umur[3] != null) {
        $umur_13 = $umur[3]->umur;
      }

      if ($umur[4] != null) {
        $umur_16 = $umur[4]->umur;
      }

      if ($umur[5] != null) {
        $umur_19 = $umur[5]->umur;
      }

      ?>
      <tr>
        <th scope="row" class="align-middle text-center">1</th>
        <td class="text-center">0 - 3 Tahun</td>
        <td class="text-center">-</td>
        <td class="text-center"><?= $umur_0; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">2</th>
        <td class="text-center">4 - 6 Tahun</td>
        <td class="text-center">-</td>
        <td class="text-center"><?= $umur_4; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">3</th>
        <td class="text-center">7 - 12 Tahun</td>
        <td class="text-center">-</td>
        <td class="text-center"><?= $umur_7; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">4</th>
        <td class="text-center">13 - 15 Tahun</td>
        <td class="text-center">-</td>
        <td class="text-center"><?= $umur_13; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">5</th>
        <td class="text-center">16 - 18 Tahun</td>
        <td class="text-center">-</td>
        <td class="text-center"><?= $umur_16; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">5</th>
        <td class="text-center">> 19 Tahun</td>
        <td class="text-center">-</td>
        <td class="text-center"><?= $umur_19; ?></td>
      </tr>
      <!-- batas kelompok usia -->
      <?php
      $umur_10 = 0;
      $umur_15 = 0;
      $umur_20 = 0;
      $umur_27 = 0;
      $umur_41 = 0;
      $umur_59 = 0;



      if ($umur[6] != null) {
        $umur_10 = $umur[6]->umur;
      }

      if ($umur[7] != null) {
        $umur_15 = $umur[7]->umur;
      }

      if ($umur[8] != null) {
        $umur_20 = $umur[8]->umur;
      }

      if ($umur[9] != null) {
        $umur_27 = $umur[9]->umur;
      }

      if ($umur[10] != null) {
        $umur_41 = $umur[10]->umur;
      }

      if ($umur[11] != null) {
        $umur_59 = $umur[11]->umur;
      }



      ?>
      <tr>
        <th scope="row" class="align-middle text-center">6</th>
        <td class="text-center">-</td>
        <td class="text-center">10 - 14 Tahun</td>
        <td class="text-center"><?= $umur_10; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">7</th>
        <td class="text-center">-</td>
        <td class="text-center">15 - 19 Tahun</td>
        <td class="text-center"><?= $umur_15; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">8</th>
        <td class="text-center">-</td>
        <td class="text-center">20 - 26 Tahun</td>
        <td class="text-center"><?= $umur_20; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">9</th>
        <td class="text-center">-</td>
        <td class="text-center">27 - 40 Tahun</td>
        <td class="text-center"><?= $umur_27; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">10</th>
        <td class="text-center">-</td>
        <td class="text-center">41 - 58 Tahun</td>
        <td class="text-center"><?= $umur_41; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">11</th>
        <td class="text-center">-</td>
        <td class="text-center">> 59 Tahun</td>
        <td class="text-center"><?= $umur_59; ?></td>
      </tr>


    </tbody>
  </table>
  <br>
  <div class="row">
    <div class="ml-auto mr-3">
      <p>Branti Raya, <?= convertTanggal(date('Y-m-d')); ?></p><br><br><br>
      <p><?= $mnj_desa['kepala_desa']; ?></p>
    </div>
  </div>
  <br>

  <div class="pagebreak"></div>

  <div class="row mt-2">
    <img src="<?= base_url('images/desa/' . $mnj_desa['logo']); ?>" class="rounded d-block mb-3 ml-5" alt="Logo" width="80px" height="80px">
    <div class="col text-center">
      <h4 class="mb-0 mx-auto"><?= $judul3; ?></h4>
      <h5 class="mb-0 mx-auto">Desa <?= getDesa($mnj_desa['desa']) . ' ' . getDusun($dusun); ?></h5>
      <?php if ($tahun != "") : ?>
        <h5 class="mb-3 mx-auto"><?= 'Per-Tahun ' . $tahun; ?></h5>
      <?php endif ?>
    </div>
  </div>


  <table class="table table-sm table-bordered">
    <thead>
      <tr class="table-active">
        <th scope="col">No</th>
        <th scope="col">Jenis Pekerjaan</th>
        <th scope="col">Jumlah</th>
        <th scope="col">Persentase</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $h_petani = 0;
      $h_buruh_tani = 0;
      $h_pns = 0;
      $h_tni = 0;
      $h_polisi = 0;
      $h_karyawan_swasta = 0;
      $h_pedagang = 0;
      $h_wiraswasta = 0;
      $h_pensiunan = 0;
      $h_buruh_harian_lepas = 0;
      $h_peternak = 0;
      $h_sopir = 0;
      $h_industri = 0;
      $h_lainnya = 0;


      if ($pekerjaan[0] != null) {
        $h_petani = $pekerjaan[0]->pekerjaan;
      }

      if ($pekerjaan[1] != null) {
        $h_buruh_tani = $pekerjaan[1]->pekerjaan;
      }

      if ($pekerjaan[2] != null) {
        $h_pns = $pekerjaan[2]->pekerjaan;
      }

      if ($pekerjaan[3] != null) {
        $h_tni = $pekerjaan[3]->pekerjaan;
      }

      if ($pekerjaan[4] != null) {
        $h_polisi = $pekerjaan[4]->pekerjaan;
      }

      if ($pekerjaan[5] != null) {
        $h_karyawan_swasta = $pekerjaan[5]->pekerjaan;
      }

      if ($pekerjaan[6] != null) {
        $h_pedagang = $pekerjaan[6]->pekerjaan;
      }

      if ($pekerjaan[7] != null) {
        $h_wiraswasta = $pekerjaan[7]->pekerjaan;
      }

      if ($pekerjaan[8] != null) {
        $h_pensiunan = $pekerjaan[8]->pekerjaan;
      }

      if ($pekerjaan[9] != null) {
        $h_buruh_harian_lepas = $pekerjaan[9]->pekerjaan;
      }

      if ($pekerjaan[10] != null) {
        $h_peternak = $pekerjaan[10]->pekerjaan;
      }

      if ($pekerjaan[11] != null) {
        $h_sopir = $pekerjaan[11]->pekerjaan;
      }

      if ($pekerjaan[12] != null) {
        $h_industri = $pekerjaan[12]->pekerjaan;
      }

      if ($pekerjaan[13] != null) {
        $h_lainnya = $pekerjaan[13]->pekerjaan;
      }
      ?>

      <tr>
        <th scope="row" class="align-middle text-center">1</th>
        <td>Petani</td>
        <td class="text-center"><?= $h_petani ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_petani * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">2</th>
        <td>Buruh tani</td>
        <td class="text-center"><?= $h_buruh_tani; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_buruh_tani * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">3</th>
        <td>PNS</td>
        <td class="text-center"><?= $h_pns; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_pns * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">3</th>
        <td>TNI</td>
        <td class="text-center"><?= $h_tni; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_tni * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">3</th>
        <td>POLRI</td>
        <td class="text-center"><?= $h_polisi; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_polisi * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">4</th>
        <td>Karyawan swasta</td>
        <td class="text-center"><?= $h_karyawan_swasta; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_karyawan_swasta * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">5</th>
        <td>Pedagang</td>
        <td class="text-center"><?= $h_pedagang; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_pedagang * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">6</th>
        <td>Wiraswastawan</td>
        <td class="text-center"><?= $h_wiraswasta; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_wiraswasta * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">7</th>
        <td>Pensiunan</td>
        <td class="text-center"><?= $h_pensiunan; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_pensiunan * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">8</th>
        <td>Buruh bangunan/ Tukang</td>
        <td class="text-center"><?= $h_buruh_harian_lepas; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_buruh_harian_lepas * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">9</th>
        <td>Peternak</td>
        <td class="text-center"><?= $h_peternak; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_peternak * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">10</th>
        <td>Pengemudi mobil</td>
        <td class="text-center"><?= $h_sopir; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_sopir * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">11</th>
        <td>Buruh industri</td>
        <td class="text-center"><?= $h_industri; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_industri * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">11</th>
        <td>Lainnya</td>
        <td class="text-center"><?= $h_lainnya; ?></td>
        <td class="text-center"><?= ($h_total == 0) ? 0 : number_format($h_lainnya * 100 / $h_total, 1) . ' %'; ?></td>
      </tr>
      <tr>
        <th scope="row" class="align-middle text-center">12</th>
        <td class="text-center">Jumlah</td>
        <?php
        $h_totalnya = $h_petani + $h_buruh_tani + $h_pns + $h_tni + $h_polisi + $h_karyawan_swasta + $h_pedagang + $h_wiraswasta + $h_pensiunan + $h_buruh_harian_lepas + $h_peternak + $h_sopir + $h_industri;

        ($h_total == 0) ? $h_total_persen = 0 : $h_total_persen = ($h_petani * 100 / $h_total) + ($h_buruh_tani * 100 / $h_total) + ($h_pns * 100 / $h_total) + ($h_tni * 100 / $h_total) + ($h_polisi * 100 / $h_total) + ($h_karyawan_swasta * 100 / $h_total) + ($h_pedagang * 100 / $h_total) + ($h_wiraswasta * 100 / $h_total) + ($h_pensiunan * 100 / $h_total) + ($h_buruh_harian_lepas * 100 / $h_total) + ($h_peternak * 100 / $h_total) + ($h_sopir * 100 / $h_total) + ($h_industri * 100 / $h_total);
        ?>
        <td class="text-center"><?= $h_totalnya; ?></td>
        <td class="text-center"><?= number_format($h_total_persen, 1) . ' %'; ?></td>
      </tr>

    </tbody>
  </table>
  <div class="row">
    <div class="ml-auto mr-3">
      <p>Branti Raya, <?= convertTanggal(date('Y-m-d')); ?></p><br>
      <p><?= $mnj_desa['kepala_desa']; ?></p>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>

  <script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


  <!-- Core plugin JavaScript-->
  <script src="<?= base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url(); ?>/assets/js/sb-admin-2.js"></script>
  <script src="<?= base_url(); ?>/assets/select2/select2.min.js"></script>

  <!-- DataTabes -->
  <script src="<?= base_url(); ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Sweetalert2 -->
  <script src="<?= base_url(); ?>/assets/sweetalert2/sweetalert2.all.min.js"></script>

  <script src="https://use.fontawesome.com/d8106aabf4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
  <script src="<?= base_url(); ?>/assets/jquery-validation/dist/jquery.validate.min.js"></script>

  <script>
    window.print();
    // return false;
  </script>
</body>

</html>