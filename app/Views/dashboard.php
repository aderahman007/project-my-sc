<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Page Heading -->

<?php if (session()->getFlashdata('error')) : ?>

  <div class="flash-data-error" data-flashdata="<?= session()->getFlashdata('error'); ?>"></div>
<?php endif ?>
<?php if (session()->getFlashdata('pesan')) : ?>

  <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>
<?php endif ?>

<div class="row">
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
              Kepala Keluarga (Total)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $kk_total->total; ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
              Penduduk (Total)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penduduk_total->total; ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">RT (Total)
            </div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= count($rt); ?></div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-female fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
              RW (Total)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($dusun); ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-male fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- Content Row -->

<?php

$label_kelamin = ['Laki-Laki', 'Perempuan'];
$kelamin = [$lk->total / $penduduk_total->total * 100, $pr->total / $penduduk_total->total * 100];

$label_umur_sekolah = ['0-3', '4-6', '7-12', '13-15', '16-18', '> 19'];
$umur_sekolah = [
  ['y' => ($umur[0]->umur == 0) ? 0 : $umur[0]->umur / $penduduk_total->total * 100],
  ['y' => $umur[1]->umur / $penduduk_total->total * 100],
  ['y' => $umur[2]->umur / $penduduk_total->total * 100],
  ['y' => $umur[3]->umur / $penduduk_total->total * 100],
  ['y' => $umur[4]->umur / $penduduk_total->total * 100],
  ['y' => $umur[5]->umur / $penduduk_total->total * 100],
];

$label_umur_kerja = ['10-14', '15-19', '20-26', '27-40', '41-58', '> 59'];
$umur_kerja = [
  ['y' => $umur[6]->umur / $penduduk_total->total * 100],
  ['y' => $umur[7]->umur / $penduduk_total->total * 100],
  ['y' => $umur[8]->umur / $penduduk_total->total * 100],
  ['y' => $umur[9]->umur / $penduduk_total->total * 100],
  ['y' => $umur[10]->umur / $penduduk_total->total * 100],
  ['y' => $umur[11]->umur / $penduduk_total->total * 100],
];

$label_data_pekerjaan = ['Petani', 'Buruh Tani', 'PNS', 'TNI', 'POLRI', 'Karyawan Swasta', 'Pedagang', 'Wiraswatawan', 'Pensiunan', 'Buruh Bangunan', 'Peternak', 'Pengemudi mobil', 'buruh Industri', 'Lainya', 'Belum/Tidak Bekerja', 'NA'];
$data_pekerjaan = [
  ['y' => ($pekerjaan[0]->pekerjaan == 0) ? 0 : $pekerjaan[0]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[1]->pekerjaan == 0) ? 0 : $pekerjaan[1]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[2]->pekerjaan == 0) ? 0 : $pekerjaan[2]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[3]->pekerjaan == 0) ? 0 : $pekerjaan[3]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[4]->pekerjaan == 0) ? 0 : $pekerjaan[4]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[5]->pekerjaan == 0) ? 0 : $pekerjaan[5]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[6]->pekerjaan == 0) ? 0 : $pekerjaan[6]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[7]->pekerjaan == 0) ? 0 : $pekerjaan[7]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[8]->pekerjaan == 0) ? 0 : $pekerjaan[8]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[9]->pekerjaan == 0) ? 0 : $pekerjaan[9]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[10]->pekerjaan == 0) ? 0 : $pekerjaan[10]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[11]->pekerjaan == 0) ? 0 : $pekerjaan[11]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[12]->pekerjaan == 0) ? 0 : $pekerjaan[12]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[13]->pekerjaan == 0) ? 0 : $pekerjaan[13]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($pekerjaan[14]->pekerjaan == 0) ? 0 : $pekerjaan[14]->pekerjaan / $penduduk_total->total * 100],
  ['y' => ($na == 0) ? 0 : $na / $penduduk_total->total * 100],
];
?>


<div class="row mb-3">
  <div class="col-md-3">
    <div class="card">
      <canvas id="jenis_kelamin" style="height: 370px; width: 100%; padding: 5px;"></canvas>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <canvas id="umur_sekolah" style="height: 370px; width: 100%; padding: 5px;"></canvas>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <canvas id="umur_kerja" style="height: 370px; width: 100%; padding: 5px;"></canvas>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <canvas id="pekerjaan" style="height: 370px; width: 100%; padding: 5px;"></canvas>
    </div>
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-12">
    <div class="float-right">
      <button type="button" id="btn-more" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-eye"></i> Klik for more !</button>
    </div>
  </div>
</div>

<div id="table-show" class="row">
  <div class="col-md-12">
    <div class="table-responsive shadow">
      <table class="table table-bordered table-hover">
        <thead class="bg-primary text-white">
          <tr>
            <th scope="col">Dusun</th>
            <th scope="col">RT</th>
            <th scope="col">Laki - Laki</th>
            <th scope="col">Perempuan</th>
            <th scope="col">Total KK</th>
            <th scope="col">Total Penduduk</th>
          </tr>
        </thead>
        <tbody class="align-middle text-center">
          <?php foreach ($dusun as $key_dusun => $value_dusun) : ?>
            <tr>
              <td class="align-middle text-center"><?= $value_dusun['dusun']; ?></td>
              <td>
                <table class="table table-borderless table-hover">
                  <tbody class="align-middle text-center">
                    <?php foreach ($rt as $key_rt => $value_rt) : ?>
                      <?php if ($value_dusun['id_rw'] == $value_rt['id_rw']) : ?>
                        <tr>
                          <td><?= $value_rt['no_rt']; ?></td>
                        </tr>
                      <?php endif ?>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </td>
              <?php foreach ($jk as $key_jk => $value_jk) : ?>

                <td>
                  <table class="table table-borderless table-hover">
                    <tbody class="align-middle text-center">
                      <?php foreach ($rt as $key_rt => $value_rt) : ?>
                        <?php if ($value_rt['id_rw'] == $value_dusun['id_rw']) : ?>
                          <?php $p = 0; ?>
                          <tr>
                            <td class="text-primary">
                              <?php foreach ($penduduk as $key_penduduk => $value_penduduk) : ?>
                                <?php if ($value_penduduk['jenis_kelamin'] == $value_jk['jenis_kelamin']) : ?>
                                  <?php if ($value_rt['id_rt'] == $value_penduduk['rt']) : ?>
                                    <?php $p += 1; ?>
                                  <?php endif ?>
                                <?php endif ?>
                              <?php endforeach ?>
                              <?= $p; ?>
                            </td>
                          </tr>
                        <?php endif ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </td>
              <?php endforeach ?>

              <?php
              $db = \Config\Database::connect();
              $kk = $db->query("SELECT COUNT(id_kk) AS total FROM kartu_keluarga 
              WHERE dusun={$value_dusun['id_dusun']} GROUP BY dusun")->getRow();

              ($kk != null) ? $h_total = $kk->total : $h_total = 0;

              ?>

              <td class="align-middle text-center text-primary"><?= ($h_total == 0) ? 0 : $h_total; ?></td>

              <?php
              $query = $db->query("SELECT COUNT(id_penduduk) AS total FROM penduduk 
              INNER JOIN kartu_keluarga USING(id_kk)
              WHERE dusun={$value_dusun['id_dusun']} GROUP BY dusun")->getRow();

              ($query != null) ? $h_total = $query->total : $h_total = 0;

              ?>

              <td class="align-middle text-center text-primary"><?= ($h_total == 0) ? 0 : $h_total; ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url(); ?>/assets/sweetalert2/sweetalert2.all.min.js"></script>

<script>
  // alert berhasil
  const flashData = $('.flash-data').data('flashdata');
  const flashDataError = $('.flash-data-error').data('flashdata');


  if (flashData) {
    Swal.fire({
      icon: 'success',
      title: 'Hi ' + "<?= session()->get('nama'); ?>",
      text: 'Anda ' + flashData,
      type: 'success'
    });
  }
  if (flashDataError) {
    Swal.fire({
      icon: 'error',
      title: "Not Allowed",
      text: flashDataError,
      type: 'error'
    });
  }
</script>

<script>
  window.onload = function() {

    var jk = document.getElementById('jenis_kelamin').getContext('2d');
    var jkChart = new Chart(jk, {
      type: 'pie',
      data: {
        labels: <?= json_encode($label_kelamin); ?>,
        datasets: [{
          label: 'Persentase jenis kelamin',
          data: <?= json_encode($kelamin); ?>,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 99, 132, 0.2)',
          ],
          borderColor: [
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            padding: {
              bottom: 30
            },
            display: true,
            text: 'Persentase jenis kelamin'
          },
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 5,
              boxHeight: 5,
              usePointStyle: true
            }
          },
          datalabels: {
            formatter: function(value, context) {
              // console.log(context.dataset.data[context.dataIndex].y);
              return context.dataset.data[context.dataIndex].toFixed(1) + '%';
            },
            anchor: 'end',
            align: 'start',
            offset: 15
          },
          tooltip: {
            callbacks: {
              label: (context) => {
                return `${context.label} : ${context.parsed.toFixed(1)}%`;
              }
            }
          }
        },
      },
      plugins: [ChartDataLabels],
    });

    var umur_sekolah = document.getElementById('umur_sekolah').getContext('2d');
    var sekolah = new Chart(umur_sekolah, {
      type: 'pie',
      data: {
        labels: <?= json_encode($label_umur_sekolah); ?>,
        datasets: [{
          label: 'Persentase Umur Sekolah',
          data: <?= json_encode($umur_sekolah); ?>,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            padding: {
              bottom: 40
            },
            display: true,
            text: 'Persentase Umur Sekolah'
          },
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 5,
              boxHeight: 5,
              usePointStyle: true
            }
          },
          labels: {
            render: 'percentage'
          },
          datalabels: {
            formatter: function(value, context) {
              // console.log(context.dataset.data[context.dataIndex].y);
              return context.dataset.data[context.dataIndex].y.toFixed(1) + '%';
            },
            anchor: 'end',
            align: 'start',
            offset: 15
          },
          tooltip: {
            callbacks: {
              label: (context) => {
                return `${context.label} : ${context.parsed.toFixed(1)}%`;
              }
            }
          }
        },
        parsing: {
          key: 'y'
        }
      },
      plugins: [ChartDataLabels],
    });

    var umur_kerja = document.getElementById('umur_kerja').getContext('2d');
    var kerja = new Chart(umur_kerja, {
      type: 'pie',
      data: {
        labels: <?= json_encode($label_umur_kerja); ?>,
        datasets: [{
          label: 'Persentase Umur Kerja',
          data: <?= json_encode($umur_kerja); ?>,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            padding: {
              bottom: 40
            },
            display: true,
            text: 'Persentase Umur Kerja'
          },
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 5,
              boxHeight: 5,
              usePointStyle: true
            }
          },
          labels: {
            render: 'percentage'
          },
          datalabels: {
            formatter: function(value, context) {
              // console.log(context.dataset.data[context.dataIndex].y);
              return context.dataset.data[context.dataIndex].y.toFixed(1) + '%';
            },
            anchor: 'end',
            align: 'start',
            offset: 15
          },
          tooltip: {
            callbacks: {
              label: (context) => {
                return `${context.label} : ${context.parsed.toFixed(1)}%`;
              }
            }
          }
        },
        parsing: {
          key: 'y'
        }
      },
      plugins: [ChartDataLabels],
    });

    var pekerjaan = document.getElementById('pekerjaan').getContext('2d');
    var kerja = new Chart(pekerjaan, {
      type: 'pie',
      data: {
        labels: <?= json_encode($label_data_pekerjaan); ?>,
        datasets: [{
          label: 'Persentase Pekerjaan',
          data: <?= json_encode($data_pekerjaan); ?>,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(97, 247, 177, 0.8)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(249, 129, 191, 0.8)',
            'rgba(213, 129, 249, 0.8)',
            'rgba(129, 249, 223, 0.8)',
            'rgba(129, 249, 178, 0.8)',
            'rgba(228, 249, 129, 0.8)',

          ],
          borderColor: [
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
            'rgba(73, 168, 252, 0.8)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            padding: {
              bottom: 40
            },
            display: true,
            text: 'Persentase Pekerjaan'
          },
          legend: {
            position: 'bottom',
            labels: {
              padding: 4,
              boxWidth: 5,
              boxHeight: 5,
              usePointStyle: true,
              font: {
                size: 10
              }
            }
          },
          labels: {
            render: 'percentage'
          },
          datalabels: {
            formatter: function(value, context) {
              // console.log(context.dataset.data[context.dataIndex].y);
              return context.dataset.data[context.dataIndex].y.toFixed(1) + '%';
            },
            anchor: 'end',
            align: 'start',
            offset: 15
          },
          tooltip: {
            callbacks: {
              label: (context) => {
                return `${context.label} : ${context.parsed.toFixed(1)}%`;
              }
            }
          }
        },
        parsing: {
          key: 'y'
        }
      },
      plugins: [ChartDataLabels],
    });


  }
</script>

<script>
  $('#table-show').hide();
  $('#btn-more').click(function(e) {
    e.preventDefault();
    $('#table-show').toggleClass('table-hide');
    if ($('#table-show').hasClass('table-hide')) {
      $('#table-show').show();
      $('#btn-more').html('<i class="fas fa-eye-slash"></i> Klik for Hide !');
    } else {
      $('#table-show').hide();
      $('#btn-more').html('<i class="fas fa-eye"></i> Klik for More !');
    }
  });
</script>



<?= $this->endSection(); ?>