<?php

declare(strict_types=1);

$router->get('/read', 'src\controllers\readController::read');
$router->post('/readData', 'src\controllers\readController::readData');
$router->get('/preprocessar', 'src\controllers\readController::preprocessar');
$router->post('/preprocessarData', 'src\controllers\readController::preprocessarData');
$router->post('/exportCSV', 'src\controllers\readController::exportCSV');
