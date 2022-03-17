<?php

declare(strict_types=1);

ob_start();

// Autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';

use League\Route\Router;
use src\core\Session;
use src\core\Response;


if (CONF_DEV_MOD) {
    showErrors();
}

$session = new Session(); // Inicia a sessão
$request = getRequest(); // Obter requisição
$router = new Router(); // Inicia o roteador

// ROUTES
require_once __DIR__ . '/../src/routes/dashboardRoutes.php';
require_once __DIR__ . '/../src/routes/analiseRoutes.php';
require_once __DIR__ . '/../src/routes/loadRoutes.php';

// Enviar Resposta
(new Response($router, $request));

ob_end_flush();
