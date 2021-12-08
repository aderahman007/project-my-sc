<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= $this->include('layout/css.php'); ?>
</head>

<body>

    <img class="img-fluid mx-auto" width="2400px" height="3000px" src="<?= base_url('images/akte') . '/' . $akte['doc_akte']; ?>" alt="">

    <?= $this->include('layout/js.php'); ?>

</body>

</html>