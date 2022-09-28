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
    <link href="<?= css('app.min.css') ?>" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= css('app-dark.min.css') ?>" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="<?= css('jquery-ui.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= css('jquery.tipsy.css') ?>" rel="stylesheet" type="text/css" />

    <style>
        .modal-backdrop {
            z-index: 2;
        }

        .btn-3 {
            background: lighten(#E1332D, 3%);
            border: 1px solid darken(#E1332D, 4%);
            box-shadow: 0px 2px 0 darken(#E1332D, 5%), 2px 4px 6px darken(#E1332D, 2%);
            font-weight: 900;
            letter-spacing: 1px;
            transition: all 150ms linear;
        }

        .btn-3:hover {
            background: darken(#E1332D, 1.5%);
            border: 1px solid rgba(#000, .05);
            box-shadow: 1px 1px 2px rgba(#fff, .2);
            color: lighten(#E1332D, 18%);
            text-decoration: none;
            text-shadow: -1px -1px 0 darken(#E1332D, 9.5%);
            transition: all 250ms linear;
        }
    </style>

</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <?= $this->section('content') ?>
</body>

</html>