<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use Illuminate\Support\Str;
use src\core\Session;
use Tracy\Debugger;
use MemCachier\MemcacheSASL as Cache;
use Tracy\Bar;
use Decimal\Decimal;

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
    Debugger::enable(Debugger::DEVELOPMENT, CONF_ERROR_LOG);
    Debugger::timer();
    Debugger::$strictMode = true; // display all errors
    Debugger::$dumpTheme = 'dark';
    Debugger::$maxDepth = 8; // default: 7
    Debugger::$maxLength = 150; // default: 150
    Debugger::$showLocation = true;
}

function bardump($var, $title = '')
{
    Debugger::barDump($var, $title);
}

function cacheStats(Cache $cache)
{

    $status = $cache->getStats('');

    $limit = new Decimal($status['limit_maxbytes']);
    $size = new Decimal($status['bytes']);
    $hits = new Decimal($status['get_hits']);
    $misses = new Decimal($status['get_misses']);
    $itens = new Decimal($status['curr_items']);

    $kilobyte = new Decimal('1024');
    $megabyte = $kilobyte->pow('2')->__toString();
    $gigabyte = $kilobyte->pow('3')->__toString();


    if ($limit->div($gigabyte)->compareTo(1) == -1) {
        bardump([
            'Tamanho (MB)' => $limit->div($megabyte)->__toString(),
            'Utilizado (MB)' => $size->div($megabyte)->__toString(),
            'hits' => $hits->__toString(),
            'misses' => $misses->__toString(),
            'itens' => $itens->__toString(),
        ], __FUNCTION__);
    } else {
        bardump([
            'Tamanho (GB)' => $limit->div($gigabyte)->__toString(),
            'Utilizado (GB)' => $size->div($gigabyte)->__toString(),
            'hits' => $hits->__toString(),
            'misses' => $misses->__toString(),
            'itens' => $itens->__toString(),
        ], __FUNCTION__);
    }
}
