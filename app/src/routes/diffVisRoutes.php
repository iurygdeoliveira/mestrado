<?php

declare(strict_types=1);

$router->get('/diffvis', 'src\controllers\diffVisController::diffvis');
$router->post('/getdatadiffvis', 'src\controllers\diffVisController::getDataDiffVis');
