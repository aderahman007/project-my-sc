<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Page Heading -->


<?php if (session()->getFlashdata('pesan')) : ?>

    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>
<?php endif ?>
<?php if (session()->getFlashdata('error')) : ?>

    <div class="flash-data-error" data-flashdata="<?= session()->getFlashdata('error'); ?>"></div>
<?php endif ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?> data kependudukan berdasarkan dusun</h5>

        </div>
    </div>
    <div class="card-body">
        <form action="<?= site_url('report/report_dusun_cetak'); ?>" method="post" target="_blank">

            <div class="form-row">
                <div class="form-group col-md-9">
                    <label class="font-weight-bold">Silahkan Pilih Dusun</label>
                    <select name="dusun" id="dusun" class="form-control" required>
                        <option selected value="">~~ Pilih ~~</option>
                        <?php foreach ($dusun as $key => $value) : ?>
                            <option value="<?= $value['id_dusun']; ?>"><?= $value['dusun']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Silahkan pilih dusun
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label class="font-weight-bold">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        <option selected value="">~~ Pilih ~~</option>
                        <?php foreach ($tahun as $key => $value) : ?>
                            <option value="<?= $value['tahun']; ?>"><?= $value['tahun']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Silahkan pilih tahun
                    </div>
                </div>
                <div class="form-group col-md-1 align-self-end">
                    <button class="btn btn-info float-right"><i class="fas fa-print"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php foreach ($chart_kematian as $key) : ?>
    <?php
    $kematian[] = ['label' => $key['dusun'], 'y' => $key['kematian']];
    ?>
<?php endforeach ?>
<?php foreach ($chart_pindah as $key) : ?>
    <?php
    $pindah[] = ['label' => $key['dusun'], 'y' => $key['pindah']];
    ?>
<?php endforeach ?>
<?php foreach ($chart_lahir as $key) : ?>
    <?php
    $lahir[] = ['label' => $key['dusun'], 'y' => $key['lahir']];
    ?>
<?php endforeach ?>
<?php foreach ($chart_datang as $key) : ?>
    <?php
    $datang[] = ['label' => $key['dusun'], 'y' => $key['datang']];
    ?>
<?php endforeach ?>
<div class="card">
    <div class="card-body">

        <canvas id="chartContainer" style="height: 370px; width: 100%;"></canvas>
    </div>
</div>

<!-- Required Jquery -->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<!-- DataTabes -->
<!-- Page level plugins -->
<script src="<?= base_url(); ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Sweetalert2 -->
<script src="<?= base_url(); ?>/assets/sweetalert2/sweetalert2.all.min.js"></script>


<script>
    $(document).ready(function() {
        getRt();
    });
</script>

<script>
    window.onload = function() {

        var id_chart = document.getElementById('chartContainer').getContext('2d');
        var chart = new Chart(id_chart, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                        label: 'Kematian',
                        data: <?= json_encode($kematian); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Lahir',
                        data: <?= json_encode($lahir); ?>,
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Pindah',
                        data: <?= json_encode($pindah); ?>,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Datang',
                        data: <?= json_encode($datang); ?>,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        padding: {
                            bottom: 15
                        },
                        display: true,
                        text: 'Diagram Mutasi dan Peristiwa'
                    },
                    datalabels: {
                        formatter: function(value, context) {
                            // console.log(context.dataset.data[context.dataIndex].y);
                            return context.dataset.data[context.dataIndex].y;
                        }
                    },
                },
                parsing: {
                    xAxisKey: 'label',
                    yAxisKey: 'y'
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
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