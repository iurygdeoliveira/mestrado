<?php

/**
 * Parâmetros de Configuração do Sistema
 */

declare(strict_types=1);

define("CONF_DEV_MOD", true);
define("CONF_PROD_MOD", false);

// ###  PROJECT URLs ###
define("CONF_URL_SCHEME", "http");
define("CONF_URL_BASE", "https://ccd9-186-193-187-105.ngrok.io");
define("CONF_URL_TEST", "http://localhost");
define("CONF_URL_ELEVATION_GOOGLE", "https://maps.googleapis.com/maps/api/elevation/json?locations=");
define("CONF_URL_ELEVATION_BING", "https://dev.virtualearth.net/REST/v1/Elevation/List?points=");
define("CONF_URL_OPEN_STREET_MAP", "https://nominatim.openstreetmap.org");

// ### DATES ###
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

// ### VIEW ###
define("CONF_VIEW_THEME", "hyper");
define("CONF_VIEW_ASSETS", __DIR__ . "/../../public/assets");

// ### DESCRIPTION ###
define("CONF_SITE_LANG", "pt-BR");
define("CONF_SITE_DESCRIPTION", "pt-BR");
define("CONF_SITE_AUTHOR", "Iury Gomes de Oliveira");

// ### LOGS ###
define("CONF_ERROR_LOG", __DIR__ . "/../storage/errors/");

// ### LOGS ###
define("CONF_CSV_RIDERS", __DIR__ . "/../storage/dataset_projeto_cyclevis/");

// ### DOTENV ###
define("CONF_DOTENV", "/var/www/html/");

// ### DATASETS ###
define("CONF_RIDER1_DATASET1", __DIR__ . "/../datasets/dataset1/Rider1/");
define("CONF_RIDER2_DATASET1", __DIR__ . "/../datasets/dataset1/Rider2/");
define("CONF_RIDER3_DATASET1", __DIR__ . "/../datasets/dataset1/Rider3/");
define("CONF_RIDER4_DATASET1", __DIR__ . "/../datasets/dataset1/Rider4/");
define("CONF_RIDER5_DATASET1", __DIR__ . "/../datasets/dataset1/Rider5/");
define("CONF_RIDER6_DATASET1", __DIR__ . "/../datasets/dataset1/Rider6/");
define("CONF_RIDER7_DATASET1", __DIR__ . "/../datasets/dataset1/Rider7/");
define("CONF_RIDER8_DATASET1", __DIR__ . "/../datasets/dataset1/Rider8/");
define("CONF_RIDER9_DATASET1", __DIR__ . "/../datasets/dataset1/Rider9/");
define("CONF_RIDER1_DATASET2", __DIR__ . "/../datasets/dataset2/Rider1/");
define("CONF_RIDER2_DATASET2", __DIR__ . "/../datasets/dataset2/Rider2/");
define("CONF_RIDER3_DATASET2", __DIR__ . "/../datasets/dataset2/Rider3/");
define("CONF_RIDER4_DATASET2", __DIR__ . "/../datasets/dataset2/Rider4/");
define("CONF_RIDER5_DATASET2", __DIR__ . "/../datasets/dataset2/Rider5/");
define("CONF_RIDER6_DATASET2", __DIR__ . "/../datasets/dataset2/Rider6/");
define("CONF_RIDER7_DATASET2", __DIR__ . "/../datasets/dataset2/Rider7/");
define("CONF_RIDER1_DATASET3", __DIR__ . "/../datasets/dataset3/Rider1/");
define("CONF_RIDER3_DATASET3", __DIR__ . "/../datasets/dataset3/Rider3/");
define("CONF_RIDER6_DATASET3", __DIR__ . "/../datasets/dataset3/Rider6/");
define("CONF_RIDER7_DATASET3", __DIR__ . "/../datasets/dataset3/Rider7/");
define("CONF_RIDER8_DATASET3", __DIR__ . "/../datasets/dataset3/Rider8/");
define("CONF_RIDER9_DATASET3", __DIR__ . "/../datasets/dataset3/Rider9/");
define("CONF_RIDER10_DATASET3", __DIR__ . "/../datasets/dataset3/Rider10/");
define("CONF_RIDER12_DATASET3", __DIR__ . "/../datasets/dataset3/Rider12/");
define("CONF_RIDER13_DATASET3", __DIR__ . "/../datasets/dataset3/Rider13/");
define("CONF_RIDER14_DATASET3", __DIR__ . "/../datasets/dataset3/Rider14/");
define("CONF_RIDER1_DATASET4", __DIR__ . "/../datasets/dataset4/Rider1/");
define("CONF_RIDER3_DATASET4", __DIR__ . "/../datasets/dataset4/Rider3/");
define("CONF_RIDER4_DATASET4", __DIR__ . "/../datasets/dataset4/Rider4/");
