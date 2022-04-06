<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\Datasets;
use src\core\View;
use src\core\Controller;
use src\models\rideBD;
use Laminas\Diactoros\Response;


class analiseController extends Controller
{
    use Datasets;

    private $riders; // Recebe os dados dos ciclistas

    public View $view; // Responsavel por renderizar a view home

    public function __construct()
    {
        $this->view = new View(__DIR__, get_class($this));
        $this->riders = $this->datasets();
    }

    // Renderiza a view de dashboard
    public function analise(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('Analise Exploratória');
        $this->view->addData($data, '../theme/theme');
        $this->view->addData($data, '../scripts/scripts');

        // dados para renderização em metaData 
        $this->view->addData($this->metaData(), 'metaData');

        // dados para renderização em begin 
        $data = $this->beginData();
        $data += ['url' => url('getDataTable')];
        $this->view->addData($data, 'begin');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    public function analiseAjax(): Response
    {
        // Dados para renderização no template
        $data = ['title' => "Análise Exploratória | CycleVis"];

        // dados para renderização em metaData 
        $data += ['metaData' => $this->metaData()];

        // dados para renderização em begin 
        $data += ['beginData' => $this->beginData()];
        $data += ['url' => url('getDataTable')];

        return $this->responseJson(
            [
                'status' => true,
                'message' => "Cadastro realizado com sucesso",
                'response' => $data
            ]
        );
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

    private function beginData(): array
    {
        // Dados para renderização do dataTable       

        $data = [
            'riders' => $this->riders['riders']
        ];

        return $data;
    }

    public function getDataTable(): Response
    {

        set_time_limit(60);
        $request = getRequest()->getParsedBody();
        $this->ride = new rideBD();
        $this->ride->bootstrap('ride' . $request['rider']);

        // Arquivo não encontrado
        $result = $this->ride->findById(intval($request['atividade']));
        dump($this->ride);
        dump($result);
        exit;

        $response = ['status' => true, 'message' => "Cadastro realizado com sucesso"];
        return $this->responseJson($response);
    }
}
