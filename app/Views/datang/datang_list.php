<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page Heading -->
<div class="card shadow mb-4">
    <?php if (session()->getFlashdata('pesan')) : ?>

        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')) : ?>

        <div class="flash-data-error" data-flashdata="<?= session()->getFlashdata('error'); ?>"></div>
    <?php endif ?>
    <?php if (session()->getFlashdata('not_allowed')) : ?>

        <div class="flash-data-not-allowed" data-flashdata="<?= session()->getFlashdata('not_allowed'); ?>"></div>
    <?php endif ?>
    <div id="cover-spin"></div>
    <div class="card-header py-3 mb-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?></h5>
            <a href="<?= site_url('datang/create'); ?>" class="btn btn-primary btn-sm ml-auto loading"><i class="fa fa-plus-circle"></i> Tambah Mutasi Datang</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="my-table" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nik</th>
                        <th>Nama</th>
                        <th>Alamat Domisili</th>
                        <th>Tanggal Datang</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
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
        loadData();
    });

    function loadData() {
        $(document).ready(function() {
            var site_url = "<?php echo site_url(); ?>";
            var dataTable = $('#my-table').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                responsive: true,
                order: [],
                ajax: {
                    url: "<?= site_url('datang/load'); ?>",
                    type: "POST",
                    error: function() { // error handling
                        $(".tabel_serverside-error").html("");
                        $("#my-table").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                        $("#tabel_serverside_processing").css("display", "none");

                    }
                },
                columnDefs: [{
                        targets: [0],
                        orderable: false,
                        className: "text-center align-middle"
                    },
                    {
                        targets: [1],
                        className: "align-middle text-center",
                        width: '18%'
                    },
                    {
                        targets: [2],
                        className: "align-middle",
                        width: '18%'
                    },
                    {
                        targets: [3],
                        className: "align-middle",
                        width: '28%'
                    },
                    {
                        targets: [4],
                        className: "align-middle text-center",
                        width: '12%'
                    },
                    {
                        targets: [5],
                        width: '10%',
                        className: "text-center align-middle"
                    },
                    {
                        targets: [6],
                        width: '15%',
                        className: "text-center align-middle"
                    },
                ],
                "drawCallback": function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });


        });
    }
</script>

<script>
    // alert berhasil
    const flashData = $('.flash-data').data('flashdata');
    const flashDataError = $('.flash-data-error').data('flashdata');
    const not_allowed = $('.flash-data-not-allowed').data('flashdata');

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
    if (not_allowed) {
        Swal.fire({
            icon: 'error',
            title: "Not Allowed",
            text: not_allowed,
            type: 'error'
        });
    }


    //fungsi dan alert hapus
    function hapus(id) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Data akan di hapus permanent!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                var csrf = $('meta[name="csrf-token"]').attr('content');
                var site_url = "<?php echo site_url(); ?>";
                $.ajax({
                    url: site_url + "datang/delete/" + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf
                    },
                    beforeSend: function() {
                        $('#cover-spin').show(0);
                    },
                    success: function() {
                        $('#cover-spin').hide(0);
                        Swal.fire(
                            'Data ' + "<?= $swal; ?>",
                            'Berhasil di hapus!',
                            'success'
                        )
                        loadData();
                    }
                });
            }
        })

    }

    function changeStatus(id_datang) {
        var site_url = "<?php echo site_url(); ?>";
        var title = "Klik diluar popup untuk cencel";
        Swal.fire({
            title: 'Ubah Status Penduduk',
            footer: '<a href="' + site_url + 'MutasiDatang/changeStatusHidup/' + id_datang + '" class="btn btn-success btn-sm mr-3">Hidup</a><a href="' + site_url + 'MutasiDatang/changeStatusMeninggal/' + id_datang + '" class="btn btn-dark btn-sm mr-3">Meninggal</a><a href="' + site_url + 'MutasiDatang/changeStatusPindah/' + id_datang + '" class="btn btn-secondary btn-sm mr-3">Pindah</a>',
            showConfirmButton: false,
        })
    }
</script>

<script>
    $(".loading").on("click", function() {
        $(this).html('<i class="fa fa-spin fa-spinner"></i> loading');
        $(this).addClass('disabled');
    });
</script>

<?= $this->endSection(); ?>