<!DOCTYPE html>
<html dir="ltr" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('FreeDash/src/assets/images/favicon.png') ?>">
    <title>Kas-Kita | Masuk</title>
    <link href="<?= base_url('FreeDash/src/dist/css/style.min.css') ?>" rel="stylesheet">
    <?= $this->renderSection('styles') ?>
</head>

<body>
    <div>
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('FreeDash/src/assets/libs/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('FreeDash/src/dist/js/feather.min.js') ?>"></script>
    <script>
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
