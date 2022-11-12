<?php

declare(strict_types=1);

$router->get('/read', 'src\controllers\readController::read');
$router->post('/readData', 'src\controllers\readController::readData');
$router->get('/preprocessar', 'src\controllers\readController::preprocessar');
$router->post('/preprocessarData', 'src\controllers\readController::preprocessarData');
$router->post('/exportData', 'src\controllers\readController::exportData');
$router->post('/exportDistances', 'src\controllers\readController::exportDistances');
$router->post('/fixDistances', 'src\controllers\readController::fixDistances');
$router->get('/findOutliers', 'src\controllers\readController::findOutliers');
$router->get('/createSegment', 'src\controllers\readController::createSegment');
$router->get('/countData', 'src\controllers\readController::countData');
$router->post('/smoothOutliers', 'src\controllers\readController::smoothOutliers');
$router->post('/fixHeartrate', 'src\controllers\readController::fixHeartrate');
$router->post('/fixID', 'src\controllers\readController::fixID');
$router->post('/deleteData', 'src\controllers\readController::deleteData');
$router->post('/bbox', 'src\controllers\readController::bbox');
$router->post('/sendBbox', 'src\controllers\readController::sendBbox');
$router->post('/identifyFiles', 'src\controllers\readController::identifyFiles');
