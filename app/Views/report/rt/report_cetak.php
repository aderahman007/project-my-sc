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

  <div class="row mt-5">
    <img src="<?= base_url('images/desa/' . $mnj_desa['logo']); ?>" class="rounded d-block mb-3 ml-5" alt="Logo" width="80px" height="80px">
    <div class="col text-center">
      <h4 class="mb-0 mx-auto"><?= $judul . ' ' . getRt($rt); ?></h4>
      <h5 class="mb-0 mx-auto">Desa <?= getDesa($mnj_desa['desa']) . ' ' . getKabupaten($mnj_desa['kabupaten']); ?></h5>
      <?php if ($tahun != null) : ?>
        <h5 class="mb-3 mx-auto"><?= 'Per-Tahun ' . $tahun; ?></h5>
      <?php endif ?>
    </div>
  </div>

  <div id="table-show" class="row">
    <div class="col-md-12">
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th scope="col" rowspan="2" class="align-middle">Nama KK</th>
            <th scope="col" colspan="4">Jumlah KK dan Penduduk</th>
            <th scope="col" rowspan="2" class="align-middle">Agama</th>
            <th scope="col" rowspan="2" class="align-middle">Pekerjaan</th>
          </tr>
          <tr>
            <th scope="col">Jumlah KK</th>
            <th scope="col">Laki-Laki</th>
            <th scope="col">Perempuan</th>
            <th scope="col">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <!-- cek tahun dipilih atau tidak -->
          <?php if ($tahun == '') { ?>
            <?php
            $db = \Config\Database::connect();
            $nama_kk = $db->query("SELECT id_penduduk, id_kk, nama_lengkap, hubungan_keluarga, jenis_kelamin FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) where hubungan_keluarga='Kepala Keluarga' and dusun=$dusun and rt=$rt")->getResultArray();
            ?>
            <!-- cek apakah ada data atau tidak -->
            <?php if (count((array)$nama_kk) == 0) : ?>
              <td class="align-middle text-center" colspan="7">Data kependudukan Kosong</td>
            <?php endif ?>

            <!-- looping data jika ada data -->
            <?php foreach ($nama_kk as $key_nama_kk => $value_nama_kk) : ?>
              <tr>
                <td class="align-middle text-center"><?= $value_nama_kk['nama_lengkap']; ?></td>
                <td class="align-middle text-center">
                  <?php
                  $kk = $db->query("SELECT COUNT(id_penduduk) AS kk FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE hubungan_keluarga='Kepala Keluarga' and id_kk={$value_nama_kk['id_kk']} and dusun=$dusun and rt=$rt GROUP BY id_kk")->getRow();
                  ?>
                  <?= ($kk != null) ? $kk->kk : 0; ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $lk = $db->query("SELECT COUNT(id_penduduk) AS lk FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin='L' and id_kk={$value_nama_kk['id_kk']} and dusun=$dusun and rt=$rt GROUP BY id_kk")->getRow();
                  ?>
                  <?= ($lk != null) ? $lk->lk : 0; ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $pr = $db->query("SELECT COUNT(id_penduduk) AS pr FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin='P' and id_kk={$value_nama_kk['id_kk']} and dusun=$dusun and rt=$rt GROUP BY id_kk")->getRow();
                  ?>
                  <?= ($pr != null) ? $pr->pr : 0; ?>
                </td>
                <td class="align-middle text-center">
                  <?= (($lk != null) ? $lk->lk : 0) + (($pr != null) ? $pr->pr : 0); ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $agama = $db->query("SELECT agama AS agama FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE id_kk={$value_nama_kk['id_kk']} and id_penduduk={$value_nama_kk['id_penduduk']} and dusun=$dusun and rt=$rt")->getRow();
                  ?>
                  <?= $agama->agama; ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $jenis_pekerjaan = $db->query("SELECT jenis_pekerjaan AS jenis_pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE id_kk={$value_nama_kk['id_kk']} and id_penduduk={$value_nama_kk['id_penduduk']} and dusun=$dusun and rt=$rt")->getRow();
                  ?>
                  <?= $jenis_pekerjaan->jenis_pekerjaan; ?>
                </td>
              </tr>
            <?php endforeach ?>
            <!-- Jika tahun di isi -->
          <?php } else if ($tahun) { ?>
            <?php
            $db = \Config\Database::connect();
            $nama_kk = $db->query("SELECT id_penduduk, id_kk, nama_lengkap, hubungan_keluarga, jenis_kelamin FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) where hubungan_keluarga='Kepala Keluarga' and dusun=$dusun and rt=$rt and YEAR(penduduk.timestamp)=$tahun")->getResultArray();
            ?>

            <!-- cek apakah datanya ada atau tidak -->
            <?php if (count((array)$nama_kk) == 0) : ?>
              <td class="align-middle text-center" colspan="7">Data kependudukan Kosong</td>
            <?php endif ?>

            <!-- jika ada maka looping data nya -->
            <?php foreach ($nama_kk as $key_nama_kk => $value_nama_kk) : ?>
              <tr>
                <td class="align-middle text-center"><?= $value_nama_kk['nama_lengkap']; ?></td>
                <td class="align-middle text-center">
                  <?php
                  $kk = $db->query("SELECT COUNT(id_penduduk) AS kk FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE hubungan_keluarga='Kepala Keluarga' and id_kk={$value_nama_kk['id_kk']} and dusun=$dusun and rt=$rt and YEAR(penduduk.timestamp)=$tahun GROUP BY id_kk")->getRow();
                  ?>
                  <?= ($kk != null) ? $kk->kk : 0; ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $lk = $db->query("SELECT COUNT(id_penduduk) AS lk FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin='L' and id_kk={$value_nama_kk['id_kk']} and dusun=$dusun and rt=$rt and YEAR(penduduk.timestamp)=$tahun GROUP BY id_kk")->getRow();
                  ?>
                  <?= ($lk != null) ? $lk->lk : 0; ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $pr = $db->query("SELECT COUNT(id_penduduk) AS pr FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE jenis_kelamin='P' and id_kk={$value_nama_kk['id_kk']} and dusun=$dusun and rt=$rt and YEAR(penduduk.timestamp)=$tahun GROUP BY id_kk")->getRow();
                  ?>
                  <?= ($pr != null) ? $pr->pr : 0; ?>
                </td>
                <td class="align-middle text-center">
                  <?= (($lk != null) ? $lk->lk : 0) + (($pr != null) ? $pr->pr : 0); ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $agama = $db->query("SELECT agama AS agama FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE id_kk={$value_nama_kk['id_kk']} and id_penduduk={$value_nama_kk['id_penduduk']} and dusun=$dusun and rt=$rt and YEAR(penduduk.timestamp)=$tahun")->getRow();
                  ?>
                  <?= $agama->agama; ?>
                </td>
                <td class="align-middle text-center">
                  <?php
                  $jenis_pekerjaan = $db->query("SELECT jenis_pekerjaan AS jenis_pekerjaan FROM penduduk INNER JOIN kartu_keluarga USING(id_kk) WHERE id_kk={$value_nama_kk['id_kk']} and id_penduduk={$value_nama_kk['id_penduduk']} and dusun=$dusun and rt=$rt and YEAR(penduduk.timestamp)=$tahun")->getRow();
                  ?>
                  <?= $jenis_pekerjaan->jenis_pekerjaan; ?>
                </td>
              </tr>
            <?php endforeach ?>
          <?php } ?>
        </tbody>
      </table>
      <br><br>
      <div class="row">
        <div class="ml-auto mr-3">
          <p>Branti Raya, <?= convertTanggal(date('Y-m-d')); ?></p><br><br><br>
          <p><?= $mnj_desa['kepala_desa']; ?></p>
        </div>
      </div>
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