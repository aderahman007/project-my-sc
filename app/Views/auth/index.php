<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIAP Desa Branti Raya || Login</title>

    <?= $this->include('layout/css'); ?>

</head>

<body class="bg-gradient-light">
    <!-- Image and text -->
    <nav class="navbar navbar-light bg-light">
        <marquee behavior="" direction="">
            <span class="navbar-brand mb-0 h2">
                <h4 class="font-weight-bold text-primary">
                    <?= 'Selamat Datang di Sistem Informasi Penduduk Desa ' . $desa['nama_desa'] . ' Kecamatan ' . getKecamatan($desa['kecamatan']) . ' ' . getKabupaten($desa['kabupaten']) . ' Provinsi ' . getProvinsi($desa['provinsi']); ?>
                </h4>
            </span>
        </marquee>
    </nav>

    <div class="container">
        <?php if (session()->getFlashdata('pesan')) : ?>

            <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>
        <?php endif ?>
        <?php if (session()->getFlashdata('error')) : ?>

            <div class="flash-data-error" data-flashdata="<?= session()->getFlashdata('error'); ?>"></div>
        <?php endif ?>

        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">

            <div class="col-lg-5">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img width="80px" height="80px" src="images/desa/<?= $desa['logo']; ?>" class="rounded mx-auto d-block mb-2" alt="...">
                                        <h1 class="font-weight-bold h4 text-gray-900 mb-4">LOGIN SIAP</h1>
                                    </div>
                                    <form class="user" method="POST" action="<?= $action; ?>">
                                    <?= csrf_field(); ?>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user focus" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." value="<?= old('email'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password">
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?= $this->include('layout/js'); ?>

    <script>
        // alert berhasil
        const flashData = $('.flash-data').data('flashdata');
        const flashDataError = $('.flash-data-error').data('flashdata');

        if (flashData) {
            Swal.fire({
                icon: 'success',
                title: flashData,
                text: 'Selamat anda berhasil login !',
                type: 'success'
            });
        }
        if (flashDataError) {
            Swal.fire({
                icon: 'error',
                title: flashDataError,
                text: 'Gagal silahkan coba lagi !',
                type: 'error'
            });
        }
    </script>

</body>

</html>