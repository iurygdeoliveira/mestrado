<?php

declare(strict_types=1);

$router->get('/', 'src\controllers\dashboardController::dashboard');
$router->post('/maxDistance', 'src\controllers\dashboardController::maxDistance');
$router->post('/searchRiders', 'src\controllers\dashboardController::searchRiders');
$router->post('/pointInitial', 'src\controllers\dashboardController::pointInitial');
$router->post('/boundingBox', 'src\controllers\dashboardController::bbox');
$router->post('/coordinates', 'src\controllers\dashboardController::coordinates');
$router->post('/centroid', 'src\controllers\dashboardController::centroid');
