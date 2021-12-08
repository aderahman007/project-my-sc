<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Page Heading -->

<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?> data kependudukan desa</h5>

        </div>
    </div>
    <div class="card-body">
        <form action="<?= site_url('report/report_desa_cetak'); ?>" method="post" target="_blank" id="kirim">

            <div class="form-row">
                <div class="form-group col-md-11">
                    <label class="font-weight-bold">Silahkan Pilih Tahun <sup class="text-primary"> Jika di kosongkan akan mereport semua data berdasarkan desa</sup></label>
                    <select name="tahun" id="tahun" class="form-control">
                        <option selected value="">~~ Pilih ~~</option>
                        <?php foreach ($tahun as $key => $value) : ?>
                            <option value="<?= $value['tahun']; ?>"><?= $value['tahun']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-md-1 align-self-end">
                    <button id="cetak" type="submit" class="btn btn-info float-right"><i class="fas fa-print"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php foreach ($chart as $key) : ?>
    <?php
    // $penduduk[] = "{dusun:'" . getDusun($key['dusun']) . "', penduduk:" . $key['penduduk'] . "}";
    $penduduk[] = ['label' => $key['dusun'], 'y' => $key['penduduk'] / $total * 100];
    ?>
<?php endforeach ?>

<div class="card">
    <div class="card-body">

        <canvas id="chartContainer" style="height: 370px; width: 100%; padding: 5px;"></canvas>
    </div>
</div>



<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<!-- DataTabes -->
<!-- Page level plugins -->
<script src="<?= base_url(); ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>


<script>
    $(document).ready(function() {
        getRt();
    });
</script>

<script>
    var data = <?= json_encode($penduduk); ?>;
    var data_label = [];
    $.each(data, function(i, e) {
        data_label[i] = data[i].label;
    });

    window.onload = function() {
        var id_chart = document.getElementById('chartContainer').getContext('2d');
        var chart = new Chart(id_chart, {
            type: 'pie',
            data: {
                labels: data_label,
                datasets: [{
                    label: 'Persentase data kependudukan desa branti raya',
                    data: <?= json_encode($penduduk); ?>,
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
                        'rgba(119, 227, 244, 0.8)',
                        'rgba(244, 165, 119, 0.8)',

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
                        text: 'Persentase data kependudukan desa branti raya'
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
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
        
    }
</script>
<script>
    function getRt() {
        $('#dusun').change(function(e) {
            $.ajax({
                type: "post",
                url: "<?= site_url('mnjpetugas/getrt'); ?>",
                data: {
                    dusun: $(this).val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('#rt').html(response.data);
                    }
                }
            });
        });

    }
</script>



<?= $this->endSection(); ?>