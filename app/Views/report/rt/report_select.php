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
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?> data kependudukan berdasarkan RT</h5>

        </div>
    </div>
    <div class="card-body">
        <form action="<?= site_url('report/report_rt_cetak'); ?>" method="post" target="_blank">

            <div class="form-row">
                <div class="form-group col-md-7">
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
                    <label class="font-weight-bold">No RT</label>
                    <select name="rt" id="rt" class="form-control" required>
                        <option selected value="">~~ Pilih ~~</option>

                    </select>
                    <div class="invalid-feedback">
                        Silahkan pilih rt
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
<?php foreach ($chart_perempuan as $key) : ?>
    <?php
    $perempuan[] = ['label' => $key['dusun'], 'y' => $key['perempuan']];
    ?>
<?php endforeach ?>
<?php foreach ($chart_laki_laki as $key) : ?>
    <?php
    $laki_laki[] = ['label' => $key['dusun'], 'y' => $key['laki_laki']];
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
    // alert berhasil
    const flashData = $('.flash-data').data('flashdata');
    const flashDataError = $('.flash-data-error').data('flashdata');

    if (flashData) {
        Swal.fire({
            icon: 'success',
            title: 'Data ' + "<?= $swal; ?>",
            text: 'Berhasil ' + flashData,
            type: 'success'
        });
    }
    if (flashDataError) {
        Swal.fire({
            icon: 'error',
            title: 'Data ' + "<?= $swal; ?>",
            text: 'Gagal ' + flashDataError,
            type: 'error'
        });
    }


    function getRt() {
        $('#dusun').change(function(e) {
            $.ajax({
                type: "post",
                url: "<?= site_url('Report/getrt'); ?>",
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

<script>
    window.onload = function() {

        var id_chart = document.getElementById('chartContainer').getContext('2d');
        var chart = new Chart(id_chart, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                        label: 'Laki-Laki',
                        data: <?= json_encode($laki_laki); ?>,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(73, 168, 252, 0.8)',
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Perenpuan',
                        data: <?= json_encode($perempuan); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(73, 168, 252, 0.8)',
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
                        text: 'Diagram Jenis kelamin Berdasarkan RT'
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
                },
            },
            plugins: [ChartDataLabels],
        });

    }
</script>


<?= $this->endSection(); ?>