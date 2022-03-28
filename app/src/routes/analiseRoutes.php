<?php

declare(strict_types=1);

$router->get('/analise', 'src\controllers\analiseController::analise');
$router->post('/getDataTable', 'src\controllers\analiseController::getDataTable');
