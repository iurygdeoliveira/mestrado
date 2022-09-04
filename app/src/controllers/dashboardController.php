<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;
use src\traits\Validate;
use src\traits\Url;
use src\traits\responseJson;
use src\classes\Distance;

class dashboardController extends Controller
{
    use Validate, Url, responseJson;

    public View $view; // Responsavel por renderizar a view home
    public $rider;

    public function __construct()
    {
        $this->view = new View(__DIR__, get_class($this));
    }

    // Renderiza a view de dashboard
    public function dashboard(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('Dashboard');
        $this->view->addData($data, '../theme/theme');
        $this->view->addData($data, '../scripts/scripts');
        $data += ['url_maxDistance' => url('maxDistance')];
        $this->view->addData($data, '../scripts/getMaxDistance');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    public function maxDistance(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Obtendo dados do dataset
        $this->rider = new Distance($request->rider);
        $result = $this->rider->maxDistance();

        return $this->responseJson(true, "Distância máxima do $request->rider encontrada", $result);
    }
}
