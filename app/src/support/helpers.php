<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use Illuminate\Support\Str;
use src\core\Session;
use Tracy\Debugger;
use MemCachier\MemcacheSASL as Cache;
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

/**
 * Retorna o caminho para a pasta JS, ou o caminho para um arquivo específico dentro da pasta JS
 *
 * @param string path O caminho para o arquivo.
 *
 * @return string o caminho para a pasta js.
 */
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


/**
 * Se houver uma mensagem flash, faça eco e retorne null
 * 
 * @return ?string null
 */
function flash(): ?string
{
    $session = new Session();
    $flash = $session->flash();
    if ($flash) {
        echo $flash;
    }
    return null;
}

/**
 * Cria um objeto de solicitação PSR-7 a partir das variáveis ​​globais
 */
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

/**
 * Ele cria um novo manipulador de erros Whoops, registra-o, cria um novo DebugBar e cria um novo
 * DebugBarRenderer
 */
function showErrors()
{

    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

function dumpexit($var, $line, $file, $function)
{
    var_dump(
        [
            'function' => $function,
            'file' => $file,
            'line' => $line,
            'var' => $var
        ]
    );
    exit;
}

/**
 * É uma função que recebe um objeto de cache e retorna uma barra de depuração com as estatísticas do cache
 * @param Cache de cache O objeto de cache.
 */
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
        dump([
            'Tamanho (MB)' => $limit->div($megabyte)->__toString(),
            'Utilizado (MB)' => $size->div($megabyte)->__toString(),
            'hits' => $hits->__toString(),
            'misses' => $misses->__toString(),
            'itens' => $itens->__toString(),
        ]);
    } else {
        dump([
            'Tamanho (GB)' => $limit->div($gigabyte)->__toString(),
            'Utilizado (GB)' => $size->div($gigabyte)->__toString(),
            'hits' => $hits->__toString(),
            'misses' => $misses->__toString(),
            'itens' => $itens->__toString(),
        ]);
    }
}
