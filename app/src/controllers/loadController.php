<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\core\Controller;
use src\traits\load_rider;
use Laminas\Diactoros\Response;

class loadController extends Controller
{
    use load_rider;

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

        $this->loadRider(CONF_RIDER1_DATASET1);

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }
}
