<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use Illuminate\Support\Str;
use src\core\Session;
use Tracy\Debugger;


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
