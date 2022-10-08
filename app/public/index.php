<?php

declare(strict_types=1);

// Autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';

use League\Route\Router;
use src\core\Session;
use src\core\Response;
use Dotenv\Dotenv;
//use MemCachier\MemcacheSASL as Cache;

$dotenv = Dotenv::createImmutable(CONF_DOTENV);
$dotenv->load();


if (CONF_DEV_MOD) {
    showErrors();
}

$session = new Session(); // Inicia a sessão
$request = getRequest(); // Obter requisição
$router = new Router(); // Inicia o roteador

// ROUTES
require_once __DIR__ . '/../src/routes/dashboardRoutes.php';
require_once __DIR__ . '/../src/routes/testRoutes.php';
require_once __DIR__ . '/../src/routes/readRoutes.php';

// Enviar Resposta
(new Response($router, $request));
