<?php

declare(strict_types=1);

$router->get('/popular', 'src\controllers\loadController::load');
$router->post('/saveData', 'src\controllers\loadController::saveData');
