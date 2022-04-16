<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\Datasets;
use src\traits\responseJson;
use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;


class mapvizController extends Controller
{
    use Datasets, responseJson;

    private $riders; // Recebe os dados dos ciclistas

    public View $view; // Responsavel por renderizar a view home

    public function __construct()
    {
        $this->view = new View(__DIR__, get_class($this));
        $this->riders = $this->datasets();
    }

    private function metaData(): array
    {
        // Dados para renderização do dataTable
        $ciclistas = $this->riders['riders'];

        $totalAtividades = 0;
        foreach ($ciclistas as $ciclista) {

            $totalAtividades += $ciclista->atividade;
        }

        $data = [
            'totalCiclistas' => 29,
            'totalAtividades' => $totalAtividades,
            'totalDatasets' => 4
        ];

        return $data;
    }

    // Renderiza a view de mapviz
    public function mapviz(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('MapVis');
        $this->view->addData($data, '../theme/theme');
        $this->view->addData($data, '../scripts/scripts');

        // dados para renderização em metaData 
        $data = $this->metaData();
        $data += ['url' => url('getDataMapviz')];
        $this->view->addData($data, 'resumo');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }
}
