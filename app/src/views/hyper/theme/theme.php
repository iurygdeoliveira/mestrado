<!DOCTYPE html>
<html lang="<?= CONF_SITE_LANG ?>">

<head>
    <meta charset="utf-8" />
    <title><?= $this->e($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= CONF_SITE_DESCRIPTION ?>" />
    <meta content="<?= CONF_SITE_AUTHOR ?>" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= img('favicon.ico') ?>">

    <!-- App css -->
    <link href="<?= css('icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= css('app.min.css') ?>" rel="stylesheet" type="text/css" id="app-style" />
    <link href="<?= css('app-dark.min.css') ?>" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="<?= css('jquery-ui.min.css') ?>" rel="stylesheet" type="text/css" id="dark-style" />

    <style>
        .modal-backdrop {
            z-index: 2;
        }

        .switch {
            background-position: right center !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        }
    </style>

</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <?= $this->section('content') ?>
</body>

</html>