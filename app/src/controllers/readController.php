<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\Datasets;
use src\traits\responseJson;
use src\traits\Csv;
use src\core\View;
use src\core\Controller;
use src\classes\LoadRide;
use src\models\rideBD;
use Laminas\Diactoros\Response;

class readController extends Controller
{
    use Datasets, responseJson, Csv;

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

    public function exportCSV(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Buscando dados no BD
        $rider = new rideBD();
        $rider->bootstrap(strval($request->id));
        $data = $rider->find()->fetch(true);

        //Criando cabeçalho do arquivo CSV
        if ($request->id == 1) {
            $this->createCSV(
                'riders.csv',
                ['Creator', 'Rider', 'Atividade', 'Total_nodes', 'Datetime', 'Country', 'City', 'Road', 'Latitude_Inicial', 'Longitude_Inicial', 'Latitude_Final', 'Longitude_Final', 'Duration', 'Distance', 'Speed', 'Cadence', 'HeartRate', 'Calories', 'Temperature', 'Total_Trackpoints'],
                true,
                'w'
            );
        }

        // Criando linha do arquivo CSV
        $records = [];
        foreach ($data as $key => $value) {
            $record = [
                $value->data()->creator,
                $request->id,
                $value->data()->id,
                strlen($value->data()->nodes),
                $value->data()->datetime,
                $value->data()->country,
                $value->data()->city,
                $value->data()->road,
                $value->data()->latitude_inicial,
                $value->data()->longitude_inicial,
                $value->data()->latitude_final,
                $value->data()->longitude_final,
                $value->data()->duration,
                $value->data()->distance,
                $value->data()->speed,
                $value->data()->cadence,
                $value->data()->heartrate,
                $value->data()->calories,
                $value->data()->temperature,
                $value->data()->total_trackpoints
            ];

            array_push($records, $record);
        }

        $result = $this->createCSV('riders.csv', $records, false, 'a');

        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erros
        if ($result === true) {
            return $this->responseJson(true, "CSV do rider $request->id concluído", "sem retorno de dados");
        }

        return $this->responseJson(false, $result, null);
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
        $data += ['url' => url('readData')];
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
        $this->ride = new LoadRide($request->dataset, $request->rider, $request->atividade);
        $result = $this->ride->extractData($request->dataset . $request->atividade);

        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erros
        if ($result === true) {
            return $this->responseJson(true, "Valores da atividade $request->atividade extraídos", "sem retorno de dados");
        }

        return $this->responseJson(false, $result, null);
    }
}
