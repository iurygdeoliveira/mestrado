<?php

declare(strict_types=1);

$router->get('/read', 'src\controllers\readController::read');
$router->post('/extract', 'src\controllers\readController::extractData');
