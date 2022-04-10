<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use Illuminate\Support\Str;
use src\core\Session;


function url(string $path = null): string
{

    if (Str::contains($_SERVER['HTTP_HOST'], 'localhost')) {
        if ($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE;
}

function url_back(): string
{
    return ($_SERVER['HTTP_REFERER'] ?? url());
}

function img(string $path = null): string
{
    if (Str::contains($_SERVER['HTTP_HOST'], 'localhost')) {
        if ($path) {
            return CONF_URL_TEST . "/assets/img/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST . "/assets/img/";
    }

    if ($path) {
        return CONF_URL_BASE . "/assets/img/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/assets/img/";
}

function css(string $path = null): string
{
    if (Str::contains($_SERVER['HTTP_HOST'], 'localhost')) {
        if ($path) {
            return CONF_URL_TEST . "/assets/css/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST . "/assets/css/";
    }

    if ($path) {
        return CONF_URL_BASE . "/assets/css/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/assets/css/";
}

function js(string $path = null): string
{
    if (Str::contains($_SERVER['HTTP_HOST'], 'localhost')) {
        if ($path) {
            return CONF_URL_TEST . "/assets/js/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST . "/assets/js/";
    }

    if ($path) {
        return CONF_URL_BASE . "/assets/js/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/assets/js/";
}


function flash(): ?string
{
    $session = new Session();
    $flash = $session->flash();
    if ($flash) {
        echo $flash;
    }
    return null;
}

function getRequest()
{
    $request = ServerRequestFactory::fromGlobals(
        $_SERVER,
        $_GET,
        $_POST,
        $_COOKIE,
        $_FILES
    );
    return $request;
}

function showErrors()
{
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

function walkRecursive($item, $key)
{
    echo "$key -> $item<br>";
}

function telemetry()
{
    dump("==== Telemetria ====");

    // Tempo de execução da requisição
    $time = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
    dump("Processado em $time segundos");

    // Memoria Utilizada
    // Uma regra básica é utilizar 1/4 da memória do servidor para o php
    $memory = memory_get_peak_usage();
    $memory = number_format($memory / (1024 * 1024), 2);
    dump("Memoria utilizada $memory M");

    // Sessão
    dump("==== SESSION: " . session_id() . " ====");
    dump($_SESSION);
    dump("=================");

    // Cache necessário para aplicação
    dump("==== Cache suficiente para aplicação ====");
    dump(realpath_cache_size() . "K");
    dump("=========================================");

    // Opcache
    dump("==== Configuração do Opcache ====");
    dump(opcache_get_configuration());
    dump("=================================");
}
