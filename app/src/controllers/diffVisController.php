<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\Datasets;
use src\traits\responseJson;
use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;
use src\models\rideBD;


class diffVisController extends Controller
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
    public function diffvis(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('DiffVis');
        $this->view->addData($data, '../theme/theme');
        $this->view->addData($data, '../scripts/scripts');

        // Dados para renderização em metaData 
        $data = $this->metaData();
        $data += ['url' => url('getdatadiffvis')];
        $data += ['url_stats' => CONF_JSON_SERVER . '/diffvis'];
        $this->view->addData($data, 'resumo');

        // Dados para renderização em generateDiffVis 
        $data = ['riders' => $this->riders['riders']];
        $this->view->addData($data, 'generateDiffVis');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    // Obtendo os nós dos arquivos XML
    public function getDataDiffVis(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Verificando se o dataset já foi pre-processado
        $nodes = new rideBD();
        $nodes->bootstrap($request->rider);

        $total = $nodes->find()->count();

        if (!$total) {
            $this->responseJson(true, "Problema no BD", $nodes->message());
        }

        $total = intval($total);
        $response = [];
        for ($id = 1; $id <= $total; $id++) {

            $name = "$id";
            $stringNode = $nodes->findById($id, 'nodes')->nodes;
            $value = count(explode("-", $stringNode));

            array_push($response, [
                'name' => $name,
                'value' => $value,
                'nodes' => $stringNode
            ]);
        }

        return $this->responseJson(true, "Diffvis concluída", $response);
    }
}
