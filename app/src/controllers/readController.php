<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\Datasets;
use src\core\View;
use src\core\Controller;
use src\classes\LoadRide;
use Laminas\Diactoros\Response;


class readController extends Controller
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
    public function read(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('Extrair Arquivos');
        $this->view->addData($data, '../theme/theme');
        $this->view->addData($data, '../scripts/scripts');

        // dados para renderização em metaData 
        $this->view->addData($this->metaData(), 'metaData');

        // dados para renderização em begin 
        $data = ['riders' => $this->riders['riders']];
        $data += ['url' => url('extract')];
        $this->view->addData($data, 'begin');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    // public function analiseAjax(): Response
    // {
    //     // Dados para renderização no template
    //     $data = ['title' => "Análise Exploratória | CycleVis"];

    //     // dados para renderização em metaData 
    //     $data += ['metaData' => $this->metaData()];

    //     // dados para renderização em begin 
    //     $data += ['beginData' => $this->beginData()];
    //     $data += ['url' => url('getDataTable')];

    //     return $this->responseJson(
    //         [
    //             'status' => true,
    //             'message' => "Cadastro realizado com sucesso",
    //             'response' => $data
    //         ]
    //     );
    // }

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

    // Obtendo os nós dos arquivos XML
    public function extractData(): Response
    {

        set_time_limit(120);
        ini_set('memory_limit', '-1');
        $request = getRequest()->getParsedBody();
        $this->ride = new LoadRide($request['dataset'], $request['rider'], $request['atividade']);
        $result = $this->ride->extract($request['dataset'] . $request['atividade']);
        dump($result);
        exit;

        // Arquivo não encontrado
        if ($result->fail()) {
            return $this->responseJson(
                [
                    'status' => false,
                    'message' => $result->message(),
                    'response' => null
                ]
            );
        }

        // Dados não foram salvos no BD
        // if (!$result->save()) {
        //     return $this->responseJson(
        //         [
        //             'status' => false,
        //             'message' => $result->message(),
        //             'response' => null
        //         ]
        //     );
        // }

        // Dados extraidos com sucesso
        return $this->responseJson(
            [
                'status' => true,
                'message' => "Informação extraída com sucesso",
                'response' => $result->data()
            ]
        );
    }
}
