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
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?> data Penduduk</h5>

        </div>
    </div>
    <div class="card-body">
        <form id="form-export" method="post" target="_blank">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Silahkan Pilih Dusun</label>
                    <select name="dusun" id="dusun" class="form-control">
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
                    <select name="rt" id="rt" class="form-control">
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
                <div class="form-group col-md-2 align-self-end">
                    <div class="row float-right">
                        <button id="export" class="btn btn-info mr-2 ml-3"><i class="fas fa-file-excel"></i></button>
                        <button id="print" class="btn btn-info mr-2"><i class="fas fa-print"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php foreach ($penduduk as $key) : ?>
    <?php
    $data_penduduk[] = ['label' => $key['tahun'], 'y' => $key['total'] / $total['total'] * 100];

    ?>
<?php endforeach ?>
<div class="card">
    <div class="card-body">

        <canvas id="chartContainer" style="height: 370px; width: 100%; padding:5px;"></canvas>
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
        report();
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

    function report() {
        $('#export').click(function(e) {
            var dusun = $('#dusun').val();
            var rt = $('#rt').val();
            var tahun = $('#tahun').val();

            if (dusun == '' && rt == '' && tahun == '') {
                e.preventDefault();
                Swal.fire({
                    title: 'Proses ini membutuhkan waktu yang sedikit lama',
                    text: "Anda akan meng-export " + "<?= $total['total']; ?>" + " data penduduk!",
                    icon: 'warning',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Export data!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?= site_url('report/report_penduduk_export'); ?>";
                    }
                })
            } else {
                $('#form-export').attr('action', '<?= site_url('report/report_penduduk_export'); ?>');
            }
        })
        $('#print').click(function(e) {
            // e.preventDefault();

            $('#form-export').attr('action', '<?= site_url('report/report_penduduk_cetak'); ?>');
        })
    }
</script>

<script>
    window.onload = function() {
        var id_chart = document.getElementById('chartContainer').getContext('2d');
        var chart = new Chart(id_chart, {
            type: 'bar',
            data: {
                // labels: [],
                datasets: [{
                    label: 'Tahun',
                    data: <?= json_encode($data_penduduk); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(73, 168, 252, 0.8)',
                    ],
                    borderWidth: 1
                }, ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        padding: {
                            bottom: 15
                        },
                        display: true,
                        text: 'Diagram Pertumbuhan Penduduk'
                    },
                    legend:{
                        display: false
                    },
                    datalabels: {
                        formatter: function(value, context) {
                            return context.dataset.data[context.dataIndex].y + '%';
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return `Tahun ${context.label} : ${context.parsed.y}%`;
                            }
                        }
                    }
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