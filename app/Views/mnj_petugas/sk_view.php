<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?= $this->include('layout/css.php'); ?>
</head>

<body>

    <!-- <img class="img-fluid mx-auto" width="2400px" height="3000px" src="<?= base_url('images/sk') . '/' . $sk['doc_sk']; ?>" alt=""> -->

    <embed src="<?= base_url('images/sk') . '/' . $sk['doc_sk']; ?>" type="application/pdf" width="100%" height="630px">

    <?= $this->include('layout/js.php'); ?>

    <script>
        window.print();
    </script>
</body>

</html>