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
        margin-right: 0mm;
        font-size: 12px !important;
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

  <div class="row mt-2">
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
            <th scope="col" class="align-middle text-center">No</th>
            <th scope="col" class="align-middle text-center">Nik</th>
            <th scope="col" class="align-middle text-center">Nama Lengkap</th>
            <th scope="col" class="align-middle text-center">Alamat</th>
            <th scope="col" class="align-middle text-center">Dusun</th>
            <th scope="col" class="align-middle text-center">Rt</th>
            <th scope="col" class="align-middle text-center">TTL</th>
            <th scope="col" class="align-middle text-center">Usia</th>
            <th scope="col" class="align-middle text-center">Kelamin</th>
            <th scope="col" class="align-middle text-center">Agama</th>
            <th scope="col" class="align-middle text-center">Status Perkawinan</th>
            <th scope="col" class="align-middle text-center">Hubungan Keluarga</th>
            <th scope="col" class="align-middle text-center">Pekerjaan</th>
          </tr>
        </thead>
        <tbody>

          <!-- cek apakah ada data atau tidak -->
          <?php if (count((array)$penduduk) == 0) : ?>
            <td class="align-middle text-center" colspan="13">Data Penduduk Kosong</td>
          <?php endif ?>

          <!-- looping data jika ada data -->
          <?php $no = 1;
          foreach ($penduduk as $key_penduduk => $value_penduduk) : ?>
            <tr>
              <td class="align-middle text-center"><?= $no++; ?></td>
              <td class="align-middle text-center"><?= $value_penduduk['nik']; ?></td>
              <td class="align-middle"><?= $value_penduduk['nama_lengkap']; ?></td>
              <td class="align-middle"><?= $value_penduduk['alamat']; ?></td>
              <td class="align-middle"><?= 'Dusun ' . getRw($value_penduduk['rw']); ?></td>
              <td class="align-middle"><?= getRt($value_penduduk['rt']); ?></td>
              <td class="align-middle"><?= $value_penduduk['tempat_lahir'] . ', ' . date('d-m-Y', strtotime($value_penduduk['tanggal_lahir'])); ?></td>
              <td class="align-middle text-center"><?= $value_penduduk['usia']; ?></td>
              <td class="align-middle text-center"><?= ($value_penduduk['jenis_kelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan'; ?></td>
              <td class="align-middle"><?= $value_penduduk['agama']; ?></td>
              <td class="align-middle"><?= $value_penduduk['status_perkawinan']; ?></td>
              <td class="align-middle"><?= $value_penduduk['hubungan_keluarga']; ?></td>
              <td class="align-middle"><?= $value_penduduk['jenis_pekerjaan']; ?></td>

            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
      <br>
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