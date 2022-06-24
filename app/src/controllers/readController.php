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
        $rider = (new rideBD())->bootstrap(strval($request->id));
        $total = $rider->getRowsNumber();

        //Criando cabeçalho do arquivo CSV
        if ($request->id == 1) {
            $this->createCSV(
                'dataset_iury.csv',
                ['creator', 'rider', 'activity', 'nodes_in_file', 'datetime', 'locality_osm(country|city|road)', 'locality_google(country|city|road)', 'locality_bing(country|city|road)', 'bounding_box', 'coordinates_percentage', 'latitudes', 'longitudes',  'elevation_percentage', 'elevation_gps', 'elevation_from_google', 'duration_percentage', 'duration_gps', 'duration_calculated', 'distance_gps', 'distance_calculated', 'speed_gps', 'speed_calculated', 'cadence_percentage', 'cadence_gps(avg)', 'cadence_calculated(avg)', 'heartrate_percentage', 'heart_gps(avg)', 'heartrate_calculated(avg)', 'altitude_percentage', 'altitude_max', 'altitude_min', 'altitude_gps(avg)', 'altitude_with_threshold', 'elevation_gain', 'gradient', 'temperature_percentage', 'temperature_gps(avg)', 'temperature_calculated(avg)', 'calories_percentage', 'calories_gps(avg)', 'calories_calculated(avg)', 'total_trackpoints'],
                true,
                'w'
            );
        }

        // Criando linha do arquivo CSV
        $records = [];
        for ($i = 1; $i <= $total; $i++) {

            $cycled = $rider->findById($i);

            $record = [
                $cycled->data()->creator,
                $request->id,
                $cycled->data()->id,
                $cycled->data()->nodes,
                $cycled->data()->datetime,
                $cycled->data()->address_openstreetmap,
                $cycled->data()->address_google,
                $cycled->data()->address_bing,
                $cycled->data()->bbox,
                $cycled->data()->coordinates_percentage,
                $cycled->data()->latitudes,
                $cycled->data()->longitudes,
                $cycled->data()->elevation_percentage,
                $cycled->data()->elevation_file,
                $cycled->data()->elevation_google,
                $cycled->data()->time_percentage,
                $cycled->data()->duration_file,
                $cycled->data()->duration_php,
                $cycled->data()->time_percentage,
                $cycled->data()->duration_file,
                $cycled->data()->duration_php,
                $cycled->data()->distance_file,
                $cycled->data()->distance_php,
                $cycled->data()->speed_file,
                $cycled->data()->speed_php,
                $cycled->data()->cadence_percentage,
                $cycled->data()->cadence_file,
                $cycled->data()->cadence_php,
                $cycled->data()->heartrate_percentage,
                $cycled->data()->heartrate_file,
                $cycled->data()->heartrate_php,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $cycled->data()->temperature_percentage,
                $cycled->data()->temperature_file,
                $cycled->data()->temperature_php,
                $cycled->data()->calories_percentage,
                $cycled->data()->calories_file,
                $cycled->data()->calories_php,
                $cycled->data()->total_trackpoints
            ];

            $result = $this->createCSV('dataset_iury.csv', $record, false, 'a');
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
