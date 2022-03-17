<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;
use SimpleXMLElement;

class loadController extends Controller
{

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

        $this->loadData();

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    private function loadData(): array
    {

        $xmlstr = file_get_contents(__DIR__ . '/../dataset/1.tcx');
        $xml = new SimpleXMLElement($xmlstr);
        dump('Arquivo Original', $xml);
        // dump($xml->Activities);
        // dump($xml->Activities->Activity);
        // dump($xml->Activities->Activity->attributes()['Sport']);

        $xmlstr = file_get_contents(__DIR__ . '/../dataset/f1.gpx');
        $xml = new SimpleXMLElement($xmlstr);
        dump($xml);
        exit;
        return [];
    }
}
