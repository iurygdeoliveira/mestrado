<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\responseJson;
use src\traits\Csv;
use src\core\View;
use src\traits\Files;
use src\core\Controller;
use src\classes\LoadRide;
use src\classes\Coordinates;
use src\classes\Math;
use src\models\rideBD;
use Laminas\Diactoros\Response;
use stdClass;


class readController extends Controller
{
    use responseJson, Files, Csv;

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

    public function getAddress(string $google, string $bing)
    {

        $addressGoogle = explode("|", $google);
        $addressBing = explode("|", $bing);

        $result = [
            'country' => (isset($addressGoogle[0]) ? $addressGoogle[0] : null),
            'locality' => (isset($addressGoogle[1]) ? $addressGoogle[1] : null)
        ];

        if (empty($result['country'])) {
            $result['country'] = (isset($addressBing[0]) ? $addressBing[0] : null);
        }

        if (empty($result['locality'])) {
            $result['locality'] = (isset($addressBing[1]) ? $addressBing[1] : null);
        }

        return $result;
    }

    public function createOverview(string $directoryPedal, stdClass $data)
    {
        $path = explode('..', $data->path);
        $latitudes = explode('|', $data->latitudes);
        $longitudes = explode('|', $data->longitudes);
        $centroid = str_replace(['[', ']', ','], ['', '', '|'], $data->centroid);
        $address = $this->getAddress($data->address_google, $data->address_bing);
        $distance = explode(' ', $data->distance_haversine);
        $speed = explode(' ', $data->speed_avg);
        $elevationGps = explode(' ', $data->elevation_avg_file);
        $elevationGoogle = explode(' ', $data->elevation_avg_google);
        $elevationBing = explode(' ', $data->elevation_avg_bing);
        $heartrate = explode(' ', $data->heartrate_avg);

        $record = [
            'pedal' => $data->id,
            'path' => $path[1],
            'creator' => $data->creator,
            'coordinateInicial' => $data->latitude_inicial . '|' . $data->longitude_inicial,
            'coordinateFinal' => end($latitudes) . '|' . end($longitudes),
            'country' => $address['country'],
            'locality' => $address['locality'],
            'centroid' => $centroid,
            'bbox' => $data->bbox,
            'datetime' => $data->datetime,
            'duration' => $data->time_total,
            'distance' => $distance[0],
            'elevation_gps' => $elevationGps[0],
            'elevation_google' => $elevationGoogle[0],
            'elevation_bing' => $elevationBing[0],
            'speed_avg' => $speed[0],
            'heartrate_avg' => $heartrate[0],
            'temperature_avg' => $data->temperature_avg,
            'trackpoints' => $data->total_trackpoints
        ];

        $result = $this->createJsonFile($directoryPedal . 'overview', $record);

        if (is_numeric($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function createData(string $directoryPedal, string $index, string $data)
    {

        if (mb_substr($data, -1) == '|') {
            $data = substr_replace($data, "", -1);
        }

        $record = [
            $index => $data
        ];

        $result = $this->createJsonFile($directoryPedal . $index, $record);

        if (is_numeric($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function exportData(): Response
    {

        set_time_limit(0);
        // Obtendo dados da requisição
        $records = [];
        $request = (object)getRequest()->getParsedBody();

        // Buscando dados no BD
        $table = (new rideBD())->bootstrap(strval($request->rider));
        $rows = $table->getRowsNumber();

        // Criando diretorio
        $directory = "Cyclist_" . $request->rider;
        $this->createDirectory(CONF_JSON_CYCLIST, $directory);

        for ($y = 1; $y <= intval($rows); $y++) {
            # code...
            $rider = (new rideBD())->bootstrap(strval($request->rider), strval($y));

            $directoryPedal = $directory . DIRECTORY_SEPARATOR . "pedal$y";
            $this->createDirectory(CONF_JSON_CYCLIST, $directoryPedal);

            $this->createOverview(CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR, $rider->data());

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'latitudes',
                $rider->data()->latitudes
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'longitudes',
                $rider->data()->longitudes
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'elevation_gps',
                $rider->data()->elevation_file
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'elevation_google',
                $rider->data()->elevation_google
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'elevation_bing',
                $rider->data()->elevation_bing
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'time_history',
                $rider->data()->time_history
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'distance_history',
                $rider->data()->distance_history_haversine
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'speed_history',
                $rider->data()->speed_history
            );

            $this->createData(
                CONF_JSON_CYCLIST . $directoryPedal . DIRECTORY_SEPARATOR,
                'heartrate_history',
                $rider->data()->heartrate_history
            );
        }

        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erros
        if (in_array(false, $records)) {
            return $this->responseJson(false, "Erro ao criar CSV do rider $request->id", null);
        }

        return $this->responseJson(true, "CSV do rider $request->rider concluído", "sem retorno de dados");
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
        $data += ['url_export' => url('exportData')];
        $this->view->addData($data, 'resumo');

        // dados para renderização em read_table 
        $data = ['riders' => $this->riders['riders']];
        $data += ['url_readData' => url('readData')];
        $data += ['url_getBbox' => url('bbox')];
        $data += ['url_sendBbox' => url('sendBbox')];
        $data += ['url_identifyFiles' => url('identifyFiles')];
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

    public function identifyFiles(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        // Obtendo dados do dataset
        $this->ride = new LoadRide($request->rider, $request->atividade);

        $result = match ($request->rider) {
            'rider1' => $this->ride->identifyFiles(CONF_RIDER1_DATASET1),
            'rider2' => $this->ride->identifyFiles(CONF_RIDER2_DATASET1),
            'rider3' => $this->ride->identifyFiles(CONF_RIDER3_DATASET1),
            'rider4' => $this->ride->identifyFiles(CONF_RIDER4_DATASET1),
            'rider5' => $this->ride->identifyFiles(CONF_RIDER7_DATASET1),
            'rider6' => $this->ride->identifyFiles(CONF_RIDER1_DATASET2),
            'rider7' => $this->ride->identifyFiles(CONF_RIDER2_DATASET2),
            'rider8' => $this->ride->identifyFiles(CONF_RIDER3_DATASET2),
            'rider9' => $this->ride->identifyFiles(CONF_RIDER5_DATASET2),
            'rider10' => $this->ride->identifyFiles(CONF_RIDER6_DATASET2),
            'rider11' => $this->ride->identifyFiles(CONF_RIDER1_DATASET3),
            'rider12' => $this->ride->identifyFiles(CONF_RIDER3_DATASET3),
            'rider13' => $this->ride->identifyFiles(CONF_RIDER6_DATASET3),
            'rider14' => $this->ride->identifyFiles(CONF_RIDER7_DATASET3),
            'rider15' => $this->ride->identifyFiles(CONF_RIDER8_DATASET3),
            'rider16' => $this->ride->identifyFiles(CONF_RIDER10_DATASET3),
            'rider17' => $this->ride->identifyFiles(CONF_RIDER12_DATASET3),
            'rider18' => $this->ride->identifyFiles(CONF_RIDER13_DATASET3),
            'rider19' => $this->ride->identifyFiles(CONF_RIDER14_DATASET3),
        };

        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erros
        if ($result === true) {
            return $this->responseJson(
                true,
                "Path da $request->atividade salva: ",
                "sem retorno de dados"
            );
        }

        return $this->responseJson(false, $result, null);
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
