<?php

declare(strict_types=1);



// Autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';

use League\Route\Router;
use src\core\Session;
use src\core\Response;
use MemCachier\MemcacheSASL as Cache;


$m = new Cache();
$m->addServer('memcached', 11211);

if (CONF_DEV_MOD) {
    showErrors();
    //cacheStats($m);
}
$session = new Session(); // Inicia a sessão
$request = getRequest(); // Obter requisição
$router = new Router(); // Inicia o roteador

// ROUTES
require_once __DIR__ . '/../src/routes/dashboardRoutes.php';
require_once __DIR__ . '/../src/routes/analiseRoutes.php';
require_once __DIR__ . '/../src/routes/diffVisRoutes.php';
require_once __DIR__ . '/../src/routes/readRoutes.php';

// Enviar Resposta
(new Response($router, $request));
