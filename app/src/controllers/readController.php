<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\responseJson;
use src\traits\Csv;
use src\core\View;
use src\core\Controller;
use src\classes\LoadRide;
use src\classes\Coordinates;
use src\models\rideBD;
use Laminas\Diactoros\Response;
use stdClass;


class readController extends Controller
{
    use responseJson, Csv;

    private $ride;
    private $riders; // Recebe os dados dos ciclistas

    public View $view; // Responsavel por renderizar a view home

    public function __construct()
    {
        $this->view = new View(__DIR__, get_class($this));
        $this->riders = $this->totalRiders();
    }

    public function totalRiders()
    {
        $riders = [];

        for ($i = 1; $i <= 19; $i++) {

            $this->ride = (new rideBD())->bootstrap("$i");
            $rider = new stdClass();
            $rider->name = "$i";
            $rider->table = "rider$i";
            $rider->atividade = $this->ride->getRowsNumber();
            array_push($riders, $rider);
        }
        return ['riders' => $riders];
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
            'totalCiclistas' => 19,
            'totalAtividades' => $totalAtividades
        ];

        return $data;
    }

    public function exportCSV(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Buscando dados no BD
        $rider = (new rideBD())->bootstrap(strval($request->id));
        $total = $rider->getRowsNumber();

        //Criando cabeçalho do arquivo CSV
        if ($request->id == 1) {
            $this->createCSV(
                'dataset_iury_distances.csv',
                ['rider', 'pedalada', 'datetime', 'distance(KM)', 'total_trackpoints'],
                true,
                'w'
            );
        }

        // Criando linha do arquivo CSV
        $records = [];
        for ($i = 1; $i <= $total; $i++) {

            $cycled = $rider->findById($i);

            $record = [
                $cycled->data()->rider,
                $cycled->data()->id,
                $cycled->data()->datetime,
                $cycled->data()->distance_haversine,
                $cycled->data()->total_trackpoints
            ];

            $result = $this->createCSV('dataset_iury_distances.csv', $record, false, 'a');
            array_push($records, $result);
        }

        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erros
        if (in_array(false, $records)) {
            return $this->responseJson(false, "Erro ao criar CSV do rider $request->id", null);
        }

        return $this->responseJson(true, "CSV do rider $request->id concluído", "sem retorno de dados");
    }


    // Renderiza a view read
    public function read(): Response
    {
        // Dados para renderização no template
        $data = $this->dataTheme('Extrair Arquivos');
        $this->view->addData($data, '../theme/theme');
        $this->view->addData($data, '../scripts/scripts');

        // dados para renderização em metaData 
        $data = $this->metaData();
        $data += ['url_csv' => url('exportCSV')];
        $this->view->addData($data, 'resumo');

        // dados para renderização em read_table 
        $data = ['riders' => $this->riders['riders']];
        $data += ['url_getBbox' => url('bbox')];
        $data += ['url_sendBbox' => url('sendBbox')];
        $this->view->addData($data, 'read_table');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    // Obtendo os valores dos arquivos 
    public function readData(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Obtendo dados do dataset
        $this->ride = new LoadRide($request->rider, $request->atividade);
        $result = $this->ride->extractData();

        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erros
        if ($result === true) {
            return $this->responseJson(true, "Valores da atividade $request->atividade extraídos", "sem retorno de dados");
        }

        return $this->responseJson(false, $result, null);
    }

    public function bbox(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Obtendo dados do dataset
        $this->ride = new Coordinates($request->rider, $request->atividade);
        $result = $this->ride->getCoordinates();

        if ($result) {
            return $this->responseJson(true, "Coordenadas encontradas", $result);
        } else {
            return $this->responseJson(false, "Problema nas Coordenadas", $result);
        }
    }

    public function sendBbox(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Obtendo dados do dataset

        $this->ride = new Coordinates($request->rider, $request->atividade);
        $result = $this->ride->sendBbox($request->bbox, $request->centroid);

        if ($result) {
            return $this->responseJson(true, "Coordenadas salvas no BD", $result);
        } else {
            return $this->responseJson(false, "Problema em salvar as coordenadas no BD", $result);
        }
    }
}
