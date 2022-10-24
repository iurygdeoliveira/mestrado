<?php

declare(strict_types=1);

$router->get('/read', 'src\controllers\readController::read');
$router->post('/readData', 'src\controllers\readController::readData');
$router->get('/preprocessar', 'src\controllers\readController::preprocessar');
$router->post('/preprocessarData', 'src\controllers\readController::preprocessarData');
$router->post('/exportData', 'src\controllers\readController::exportData');
$router->post('/exportDistances', 'src\controllers\readController::exportDistances');
$router->post('/deleteData', 'src\controllers\readController::deleteData');
$router->post('/bbox', 'src\controllers\readController::bbox');
$router->post('/sendBbox', 'src\controllers\readController::sendBbox');
$router->post('/identifyFiles', 'src\controllers\readController::identifyFiles');
