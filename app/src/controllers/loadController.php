<?php

declare(strict_types=1);

namespace src\controllers;

use src\class\LoadRide;
use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;

class loadController extends Controller
{

    private $ride;

    public View $view; // Responsavel por renderizar a view home

    public function __construct()
    {
        $this->view = new View(__DIR__, get_class($this));
    }

    // Renderiza a view de dashboard
    public function load(): Response
    {
        // Dados para renderização no template
        $this->view->addData($this->dataTheme('Carregar Dados'), 'theme');

        $this->ride = new LoadRide(CONF_RIDER1_DATASET1, '1');
        $this->ride->loadRide();

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }
}
