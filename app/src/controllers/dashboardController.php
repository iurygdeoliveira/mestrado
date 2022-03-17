<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;
use src\core\Session;
use src\traits\Validate;
use src\traits\Url;

class dashboardController extends Controller
{
    use Validate, Url;

    public View $view; // Responsavel por renderizar a view home

    public function __construct()
    {
        $this->view = new View(__DIR__, get_class($this));
    }

    // Renderiza a view de dashboard
    public function dashboard(): Response
    {
        // Dados para renderização no template
        $this->view->addData($this->dataTheme('Dashboard'), 'theme'); // 

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }
}
