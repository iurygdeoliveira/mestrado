<?php

declare(strict_types=1);

$router->get('/read', 'src\controllers\readController::read');
$router->get('/preprocessar', 'src\controllers\readController::preprocessar');
$router->post('/preprocessarData', 'src\controllers\readController::preprocessarData');