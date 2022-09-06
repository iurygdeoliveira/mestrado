<?php

declare(strict_types=1);

$router->get('/', 'src\controllers\dashboardController::dashboard');
$router->post('/maxDistance', 'src\controllers\dashboardController::maxDistance');
$router->post('/searchRiders', 'src\controllers\dashboardController::searchRiders');
