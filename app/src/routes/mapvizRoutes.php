<?php

declare(strict_types=1);

$router->get('/mapviz', 'src\controllers\mapvizController::mapviz');
$router->post('/getDataMapviz', 'src\controllers\mapvizController::getDataMapviz');
