<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Hover table card start -->
<div class="card shadow mb-4">
    <?php if (session()->getFlashdata('pesan')) : ?>

        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')) : ?>

        <div class="flash-data-error" data-flashdata="<?= session()->getFlashdata('error'); ?>"></div>
    <?php endif ?>
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul; ?></h5>
            <!-- <button data-toggle="modal" data-target="#mnj_desaModal" class="btn btn-primary btn-sm ml-auto"><i class="fa fa-plus-circle"></i> Tambah Mutasi Pindah</button> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="my-table" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Desa</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Kepala Desa</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul_dusun; ?></h5>
            <button data-toggle="modal" data-target="#mnj_desa_dusunModal" class="btn btn-primary btn-sm ml-auto"><i class="fa fa-plus-circle"></i> Tambah Dusun</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="my-table-dusun" width="100%">
                <thead>
                    <tr>
                        <th width="8%" class="text-center align-middle">No</th>
                        <th>Nomor RW</th>
                        <th>Dusun</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($dusun as $d) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= getRw($d['id_rw']); ?></td>
                            <td><?= $d['dusun']; ?></td>
                            <td class="text-center align-middle">
                                <a data-toggle="modal" data-target="#mnj_desa_dusun_updateModal<?= $d['id_dusun']; ?>" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-pencil-square-o"></i></a>
                                <a onclick="hapus_dusun(<?= $d['id_dusun']; ?>)" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul_rw; ?></h5>
            <button data-toggle="modal" data-target="#mnj_desa_rwModal" class="btn btn-primary btn-sm ml-auto"><i class="fa fa-plus-circle"></i> Tambah RW</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="my-table-rw" width="100%">
                <thead>
                    <tr>
                        <th width="8%" class="text-center align-middle">No</th>
                        <th>No RW</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($rw as $d) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= $d['no_rw']; ?></td>
                            <td class="text-center align-middle">
                                <a data-toggle="modal" data-target="#mnj_desa_rw_updateModal<?= $d['id_rw']; ?>" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-pencil-square-o"></i></a>
                                <a onclick="hapus_rw(<?= $d['id_rw']; ?>)" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div id="cover-spin"></div>
    <div class="card-header py-3">
        <div class="row ml-1 mr-1">
            <h5 class="m-0 font-weight-bold text-primary"><?= $judul_rt; ?></h5>
            <button data-toggle="modal" data-target="#mnj_desa_rtModal" class="btn btn-primary btn-sm ml-auto"><i class="fa fa-plus-circle"></i> Tambah RT</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="my-table-rt" width="100%">
                <thead>
                    <tr>
                        <th width="8%" class="text-center align-middle">No</th>
                        <th>No RT</th>
                        <th>No RW</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($rt as $d) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= $d['no_rt']; ?></td>
                            <td class="text-center align-middle"><?= getRw($d['id_rw']); ?></td>
                            <td class="text-center align-middle">
                                <a data-toggle="modal" data-target="#mnj_desa_rt_updateModal<?= $d['id_rt']; ?>" class="btn btn-warning btn-sm mr-2 mb-2" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-pencil-square-o"></i></a>
                                <a onclick="hapus_rt(<?= $d['id_rt']; ?>)" class="btn btn-danger btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('mnj_desa/mnj_desa_dusun_modal'); ?>
<?= $this->include('mnj_desa/mnj_desa_rw_modal'); ?>
<?= $this->include('mnj_desa/mnj_desa_rt_modal'); ?>
<?= $this->include('mnj_desa/mnj_desa_modal'); ?>
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
        $('[data-toggle="tooltip"]').tooltip();
        loadData();

        $('#my-table-dusun').dataTable();
        $('#my-table-rw').dataTable();
        $('#my-table-rt').dataTable();
        // rf();
    });

    // function rf() {
    //     $('#my-table-rw').html(Response);
    // }

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
                    url: "<?= site_url('MnjDesa/load'); ?>",
                    type: "POST",
                    error: function() { // error handling
                        $(".tabel_serverside-error").html("");
                        $("#my-table").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                        $("#tabel_serverside_processing").css("display", "none");

                    }
                },
                columnDefs: [{
                        targets: [0],
                        className: "text-center align-middle"
                    },
                    {
                        targets: [1],
                        className: "align-middle"
                    },
                    {
                        targets: [3],
                        className: "text-center align-middle"
                    },
                    {
                        targets: [4, 5],
                        className: "text-center align-middle"
                    },
                    {
                        targets: [2],
                        className: "align-middle"
                    },
                    {
                        targets: [6],
                        orderable: false,
                        className: "text-center align-middle"
                    },
                ],
                "drawCallback": function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }

            });


        });
    }

    //fungsi dan alert hapus
    function hapus_dusun(id) {
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
                    url: site_url + "/mnj_desa/delete_dusun/" + id,
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
                        Swal.fire({
                            title: 'Data ' + "<?= $swal_dusun; ?>",
                            text: 'Berhasil di hapus!',
                            icon: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = site_url + "/mnj_desa";
                            }
                        })

                    }
                });
            }
        })

    }

    //fungsi dan alert hapus
    function hapus_rw(id) {
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
                    url: site_url + "/mnj_desa/delete_rw/" + id,
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
                        Swal.fire({
                            title: 'Data ' + "<?= $swal_rw; ?>",
                            text: 'Berhasil di hapus!',
                            icon: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = site_url + "/mnj_desa";
                            }
                        })
                    }
                });
            }
        })

    }

    //fungsi dan alert hapus
    function hapus_rt(id) {
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
                    url: site_url + "/mnj_desa/delete_rt/" + id,
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
                        Swal.fire({
                            title: 'Data ' + "<?= $swal_rt; ?>",
                            text: 'Berhasil di hapus!',
                            icon: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = site_url + "/mnj_desa";
                            }
                        })
                    }
                });
            }
        })

    }
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
</script>



<!-- Hover table card end -->
<?= $this->endSection(); ?>