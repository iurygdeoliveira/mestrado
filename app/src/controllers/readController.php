<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\Datasets;
use src\traits\responseJson;
use src\core\View;
use src\core\Controller;
use src\classes\LoadRide;
use Laminas\Diactoros\Response;
use src\models\rideBD;

class readController extends Controller
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

    // Renderiza a view de dashboard
    public function read(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('Extrair Arquivos');
        $this->view->addData($data, '../theme/theme');
        $this->view->addData($data, '../scripts/scripts');

        // dados para renderização em metaData 
        $this->view->addData($this->metaData(), 'resumo');

        // dados para renderização em begin 
        $data = ['riders' => $this->riders['riders']];
        $data += ['url' => url('extract')];
        $this->view->addData($data, 'read_begin');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    public function preprocessar(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('Pré - Processar os Arquivos');
        $this->view->addData($data, '../theme/theme');

        // dados para renderização em metaData 
        $this->view->addData($this->metaData(), 'resumo');

        // dados para renderização em begin 
        $data = [
            'riders' => $this->riders['riders'],
            'url' => url('preprocessarData')
        ];
        $this->view->addData($data, 'preprocessar_table');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    // Obtendo os nós dos arquivos XML
    public function preprocessarData(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Verificando se o dataset já foi pre-processado
        $nodes = new rideBD();
        $nodes->bootstrap($request->rider);

        if (intval($nodes->find()->count()) == intval($request->total)) {
            return $this->responseJson(true, "Extração Concluída", "sem retorno de dados");
        }

        // Obtendo dados do dataset
        $this->ride = new LoadRide($request->dataset, $request->rider, $request->atividade);
        $result = $this->ride->preprocessar($request->dataset . $request->atividade);

        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erro
        $result = true;
        if ($result === true) {
            return $this->responseJson(true, "Nós da atividade $request->atividade extraídos", "sem retorno de dados");
        }

        return $this->responseJson(false, $result, null);
    }
}
