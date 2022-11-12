<?php

declare(strict_types=1);

namespace src\controllers;

use Decimal\Decimal;
use src\classes\Math;
use src\traits\responseJson;
use src\traits\Csv;
use src\traits\Files;
use src\traits\Date;
use src\core\View;
use src\core\Controller;
use src\classes\LoadRide;
use src\classes\Coordinates;
use src\models\rideBD;
use Laminas\Diactoros\Response;
use stdClass;


class readController extends Controller
{
    use responseJson, Files, Csv, Date;

    private $ride;
    private $riders; // Recebe os dados dos ciclistas

    public View $view; // Responsavel por renderizar a view home

    public function __construct()
    {
        //$this->view = new View(__DIR__, get_class($this));
        //$this->riders = $this->totalRiders();
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

    public function fixOverview(string $directoryPedal, stdClass $data)
    {

        $record = [
            'pedal' => $data->pedal,
            'path' => $data->path,
            'creator' => $data->creator,
            'coordinateInicial' => $data->coordinateInicial,
            'coordinateFinal' => $data->coordinateFinal,
            'country' => $data->country,
            'locality' => $data->locality,
            'centroid' => $data->centroid,
            'bbox' => $data->bbox,
            'datetime' => $data->datetime,
            'duration' => $data->duration,
            'distance' => $data->distance,
            'elevation_gps' => $data->elevation_gps,
            'elevation_google' => $data->elevation_google,
            'elevation_bing' => $data->elevation_bing,
            'speed_avg' => $data->speed_avg,
            'heartrate_avg' => $data->heartrate_avg,
            'temperature_avg' => $data->temperature_avg,
            'trackpoints' => $data->trackpoints
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

    public function exportDistances()
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();
        $distances = [];
        $attribute = $request->attribute;

        $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $request->cyclist);

        foreach ($pedal as $key => $value) {

            if ($value != 'all_distances.json') {

                $path = $request->cyclist . DIRECTORY_SEPARATOR . $value . DIRECTORY_SEPARATOR . 'overview.json';
                $object = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));

                if (isset($object->$attribute)) {

                    array_push($distances, "distance: {$object->$attribute}, id: " . str_replace('pedal', '', $value));
                } else {
                    dp($path);
                    dpexit($object);
                }

                $reduce = function ($carry, $item) {
                    $carry .= $item . '|';
                    return $carry;
                };

                $this->createData(
                    CONF_JSON_CYCLIST . $request->cyclist . DIRECTORY_SEPARATOR,
                    'all_distances',
                    array_reduce($distances, $reduce)
                );
            }
        }

        return $this->responseJson(true, "Coordenadas encontradas", $distances);
    }

    public function fixDistances()
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();
        $outliers = [];

        $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $request->cyclist);

        // Fix value
        foreach ($pedal as $key => $file) {

            if ($file != 'all_distances.json') {


                // Obtendo overview
                $path =
                    $request->cyclist .
                    DIRECTORY_SEPARATOR .
                    $file .
                    DIRECTORY_SEPARATOR .
                    'overview.json';

                $overview = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));
                $speedAvg = new Decimal($overview->speed_avg);

                if ($speedAvg->compareTo(100) > 0) {
                    $outlier = new stdClass();
                    $outlier->file = $request->cyclist . DIRECTORY_SEPARATOR . $file;
                    $outlier->speedAVG = $speedAvg->toFloat();
                    array_push($outliers, $outlier);
                }

                $distance = new Decimal($overview->distance);

                if ($distance->compareTo(5) < 0) {
                    $outlier = new stdClass();
                    $outlier->file = $request->cyclist . DIRECTORY_SEPARATOR . $file;
                    $outlier->distance = $distance->toFloat();
                    array_push($outliers, $outlier);
                }
            }
        }

        // foreach ($pedal as $file) {

        //     if ($file != 'all_distances.json') {

        //         // Obtendo distancia
        //         $path =
        //             $request->cyclist .
        //             DIRECTORY_SEPARATOR .
        //             $file .
        //             DIRECTORY_SEPARATOR .
        //             'distance_history.json';

        //         $object = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));
        //         $distanceHistory = explode("|", $object->distance_history);

        //         // Obtendo tempo
        //         $path =
        //             $request->cyclist .
        //             DIRECTORY_SEPARATOR .
        //             $file .
        //             DIRECTORY_SEPARATOR .
        //             'time_history.json';

        //         $object = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));
        //         $timeHistory = explode("|", $object->time_history);

        //         // Obtendo overview
        //         $path =
        //             $request->cyclist .
        //             DIRECTORY_SEPARATOR .
        //             $file .
        //             DIRECTORY_SEPARATOR .
        //             'overview.json';

        //         $overview = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));

        //         dp($overview);
        //         dp($overview->trackpoints);
        //         dp($overview->distance);

        //         $avgD = Math::div(
        //             $overview->distance,
        //             $overview->trackpoints,
        //             20
        //         );
        //         dp(['distance by trackpoint', $avgD]);

        //         $avgT = Math::div(
        //             strval($this->timeToHours($overview->duration)),
        //             $overview->trackpoints,
        //             20
        //         );
        //         dp(['time by trackpoint', $avgT]);

        //         $outliers = [];

        //         //dp($distanceHistory);
        //         for ($idx = 0; $idx < count($distanceHistory); $idx++) {

        //             $distance_current = new Decimal($distanceHistory[$idx]);

        //             if ($distance_current->compareTo('0.036') > 0) {

        //                 $diffTime = $this->timeToHours($timeHistory[$idx]) -
        //                     $this->timeToHours($timeHistory[$idx - 1]);

        //                 if ($diffTime >= 0.0002) {

        //                     $outlier = new stdClass();
        //                     $outlier->distance = $distance_current->toFloat();
        //                     $outlier->time =
        //                         $this->timeToHours($timeHistory[$idx]) -
        //                         $this->timeToHours($timeHistory[$idx - 1]);
        //                     $outlier->index = $idx;
        //                     array_push($outliers, $outlier);
        //                 }
        //             }
        //         }

        //         dp(count($outliers));
        //         dpexit($outliers);
        //     }
        // }

        return $this->responseJson(true, "dados corrigidos", $outliers);
    }

    public function fixHeartrate()
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();
        $outliers = [];

        $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $request->cyclist);

        // Fix value

        foreach ($pedal as $key => $file) {

            if ($file != 'all_distances.json') {


                // Obtendo overview
                $path =
                    $request->cyclist .
                    DIRECTORY_SEPARATOR .
                    $file .
                    DIRECTORY_SEPARATOR .
                    'overview.json';

                $overview = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));
                $heartrateAvg = new Decimal($overview->heartrate_avg);

                if ($heartrateAvg->compareTo(200) > 0) {
                    $outlier = new stdClass();
                    $outlier->file = $request->cyclist . DIRECTORY_SEPARATOR . $file;
                    $outlier->heartrateAVG = $heartrateAvg->toFloat();
                    array_push($outliers, $outlier);
                }
            }
        }

        return $this->responseJson(true, "dados corrigidos", $outliers);
    }

    public function fixID()
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();
        $outliers = [];

        $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $request->cyclist);

        // Fix value

        foreach ($pedal as $key => $file) {

            if ($file != 'all_distances.json') {


                // Obtendo overview
                $path =
                    $request->cyclist .
                    DIRECTORY_SEPARATOR .
                    $file .
                    DIRECTORY_SEPARATOR .
                    'overview.json';

                $overview = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));
                $overview->pedal = $key;
                $this->fixOverview(
                    CONF_JSON_CYCLIST .
                        $request->cyclist .
                        DIRECTORY_SEPARATOR .
                        $file .
                        DIRECTORY_SEPARATOR,
                    $overview
                );
            }
        }

        return $this->responseJson(true, "dados corrigidos", null);
    }

    public function readAttribute($cyclist, $path, $file)
    {

        $read =
            $cyclist .
            DIRECTORY_SEPARATOR .
            $path .
            DIRECTORY_SEPARATOR .
            $file .
            ".json";

        $object = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $read));
        return explode("|", $object->$file);
    }

    public function negativeTrackpoints(
        Decimal $trackpoint,
        int $idx,
        string $file,
        array $attribute,
        int &$count
    ) {

        $object = new stdClass();

        if ($trackpoint->isNegative()) {

            $object->idx = $idx;
            $object->pedal = $file;
            $object->trackpoint = $attribute[$idx];
            $count++;
            return $object;
        }
        return null;
    }

    public function above(
        Decimal $trackpoint,
        int $idx,
        string $file,
        array $attribute,
        int &$count,
        string $value,
        string $avg
    ) {

        $object = new stdClass();


        if ($trackpoint->compareTo($value) >= 1) {

            $object->idx = $idx;
            $object->pedal = $file;
            $object->trackpoint = $attribute[$idx];
            $object->avg_by_trackpoint = $avg;
            $count++;
            return $object;
        }
        return null;
    }

    public function timeOutlier(int $idx, string $file, array $attribute, int &$count)
    {

        if (isset($attribute[$idx + 1])) {
            $time1 = $this->timeToHours($attribute[$idx]);
            $time2 = $this->timeToHours($attribute[$idx + 1]);

            if ($time1 > $time2) {

                $object = new stdClass();
                $object->idx = $idx;
                $object->time1 = $attribute[$idx];
                $object->time2 = $attribute[$idx + 1];
                $object->pedal = $file;
                $count++;
                return $object;
            }
        }
        return null;
    }


    public function findOutliers()
    {

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        // Obtendo dados da requisição

        $geral = [];
        for ($i = 1; $i <= 19; $i++) {

            $request = new stdClass();
            $request->cyclist = "Cyclist_$i";
            $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $request->cyclist);
            $outliers = [];
            $result = [];
            foreach ($pedal as $key => $file) {

                if ($file != 'all_distances.json') {

                    //$attribute = $this->readAttribute($request->cyclist, $file, 'speed_history');
                    $attribute = $this->readAttribute($request->cyclist, $file, 'distance_history');
                    //$attribute = $this->readAttribute($request->cyclist, $file, 'heartrate_history');
                    //$attribute = $this->readAttribute($request->cyclist, $file, 'elevation_google');
                    //$attribute = $this->readAttribute($request->cyclist, $file, 'time_history');

                    // Obtendo overview
                    $path =
                        $request->cyclist .
                        DIRECTORY_SEPARATOR .
                        $file .
                        DIRECTORY_SEPARATOR .
                        'overview.json';

                    $overview = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));

                    $trackpointOutlier = [];
                    $count = 0;
                    for ($idx = 0; $idx < count($attribute); $idx++) {

                        $trackpoints = new Decimal($attribute[$idx]);

                        //$object = $this->negativeTrackpoints($trackpoints, $idx, $file, $attribute, $count);
                        $object = $this->above(
                            $trackpoints,
                            $idx,
                            $file,
                            $attribute,
                            $count,
                            '1',
                            Math::div($overview->distance, $overview->trackpoints)
                        );
                        // $object = $this->timeOutlier(
                        //     $idx,
                        //     $file,
                        //     $attribute,
                        //     $count
                        // );

                        if ($object) {
                            array_push($trackpointOutlier, $object);
                        }

                        // negative outliers speed
                        // if ($idx > 0) {

                        //     $object = $this->negativeDistances($speed_current, $idx, $file, $timeHistory, $distanceHistory, $speedHistory);
                        //     $count++;
                        //     array_push($outliers, $object);
                        //     array_push($geral, $object);
                        // }
                    }

                    $percentage = Math::porcentagem($count, $overview->trackpoints);
                    if ((new Decimal($percentage))->compareTo(1) >= 0) {

                        $object = new stdClass();
                        $object->trackpoints = $overview->trackpoints;
                        $object->percentage_trackpoints = Math::porcentagem($count, $overview->trackpoints);
                        $object->total_outliers = $count;
                        $object->distance = $overview->distance;
                        $object->trackpointOutlier = $trackpointOutlier;

                        $path =
                            $request->cyclist .
                            DIRECTORY_SEPARATOR .
                            $file .
                            DIRECTORY_SEPARATOR .
                            'distance_outliers';

                        $this->createJsonFile(CONF_JSON_CYCLIST . $path, [$object]);
                        array_push($outliers, $file);
                    } else {

                        // $object = new stdClass();
                        // $object->trackpoints = $overview->trackpoints;
                        // $object->cyclist = $request->cyclist;
                        // $object->pedal = $file;
                        // $object->result = "0 resultados em $request->cyclist/$file";
                        // //$object->outliers = $outliers;

                        // array_unshift($geral, $object);

                        $path =
                            $request->cyclist .
                            DIRECTORY_SEPARATOR .
                            $file .
                            DIRECTORY_SEPARATOR .
                            'distance_outliers';

                        $this->createJsonFile(CONF_JSON_CYCLIST . $path, ["0 resultados em $request->cyclist/$file"]);
                    }
                }
            }

            array_unshift($result, [
                "Cyclist" => "$request->cyclist",
                "total de pedaladas" => count($pedal),
                "total de outliers" => count($outliers),
                "restantes" => count($pedal) - count($outliers),
                "porcentagem" => Math::porcentagem(count($outliers), count($pedal)),
                "pedal" => $outliers
            ]);

            $path =
                $request->cyclist .
                'result';

            $this->createJsonFile(CONF_JSON_CYCLIST . $path, $result);
            array_push($geral, $result);
        }

        $total_pedaladas = 0;
        $total_outliers = 0;
        $total_restantes = 0;
        foreach ($geral as $key => $value) {
            $total_pedaladas += $value[0]['total de pedaladas'];
            $total_outliers += $value[0]['total de outliers'];
            $total_restantes += $value[0]['restantes'];
        }

        set_time_limit(30);
        return $this->responseJson(true, "outliers", [
            [
                "total geral pedaladas" => $total_pedaladas,
                "total geral outliers" => $total_outliers,
                "total geral restantes" => $total_restantes
            ],
            $geral
        ]);
    }

    public function countData()
    {

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        // Obtendo dados da requisição

        $geral = [];

        $request = new stdClass();
        $request->cyclist = "Cyclist_1";
        //$request = (object)getRequest()->getParsedBody();
        $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $request->cyclist);
        # code...
        foreach ($pedal as $key => $file) {

            if ($file != 'all_distances.json' && $file == 'pedal40') {

                $distanceHistory = $this->readAttribute($request->cyclist, $file, 'distance_history');
                dp(count($distanceHistory));

                $elevation = $this->readAttribute($request->cyclist, $file, 'elevation_bing');
                dp(count($elevation));

                $elevation_google = $this->readAttribute($request->cyclist, $file, 'elevation_google');
                dp(count($elevation_google));

                $elevation_gps = $this->readAttribute($request->cyclist, $file, 'elevation_gps');
                dp(count($elevation_gps));

                $heartrate = $this->readAttribute($request->cyclist, $file, 'heartrate_history');
                dp(count($heartrate));

                $latitudes = $this->readAttribute($request->cyclist, $file, 'latitudes');
                dp(count($latitudes));

                $longitudes = $this->readAttribute($request->cyclist, $file, 'longitudes');
                dp(count($longitudes));

                $speedHistory = $this->readAttribute($request->cyclist, $file, 'speed_history');
                dp(count($speedHistory));

                $timeHistory = $this->readAttribute($request->cyclist, $file, 'time_history');
                dp(count($timeHistory));
            }
        }

        exit;
        set_time_limit(30);
        return $this->responseJson(true, "outliers gerados", $geral);
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

    private function deleteFiles(string $cyclist, string $attribute, int $limit)
    {
        $deleteFiles = [];

        $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $cyclist);

        foreach ($pedal as $key => $value) {
            $path = $cyclist . DIRECTORY_SEPARATOR . $value . DIRECTORY_SEPARATOR . 'overview.json';
            $object = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));

            if (isset($object->$attribute)) {
                if (floatval($object->$attribute) < $limit) {
                    $this->deleteDirectory(CONF_JSON_CYCLIST, $cyclist . DIRECTORY_SEPARATOR . $value);
                    array_push($deleteFiles, $cyclist . DIRECTORY_SEPARATOR . $value);
                }
            } else {
                dp($path);
                dpexit($object);
            }
        }

        return $deleteFiles;
    }


    public function deleteData(): Response
    {

        // Obtendo dados da requisição
        $request = (object)getRequest()->getParsedBody();

        $path = $request->cyclist . 'result.json';

        $result = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));

        foreach ($result[0]->pedal as $key => $value) {
            $this->deleteDirectory(CONF_JSON_CYCLIST, $request->cyclist . DIRECTORY_SEPARATOR . $value);
        }



        // Se result for true, então o dataset/atividade já foram extraídos
        // Se result for diferentes de true, retorna a mensagem de erros
        if ($result) {
            return $this->responseJson(
                true,
                "Pedaladas do $request->cyclist excluídas",
                $result
            );
        } else {
            return $this->responseJson(
                false,
                "Pedaladas do $request->cyclist não excluídas",
                $result
            );
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

    public function createSegment()
    {

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        // Obtendo dados da requisição

        $geral = [];
        $tam = 40;
        // Para segmentos de 50 colocar 40   (15 outlier)
        // Para segmentos de 100 colocar 90  (15 outlier)
        // Para segmentos de 150 colocar 140 (15 outlier)

        $count = 0;
        for ($i = 15; $i <= 15; $i++) {
            # code...
            $request = new stdClass();
            $request->cyclist = "Cyclist_$i";
            $segment = [];
            $avg_pedal = [];
            $pedal = $this->getFileNames(CONF_JSON_CYCLIST . $request->cyclist);

            foreach ($pedal as $key => $file) {

                if ($file != 'all_distances.json') {

                    //$attribute = $this->readAttribute($request->cyclist, $file, 'speed_history');
                    $attribute = $this->readAttribute($request->cyclist, $file, 'distance_history');
                    //$attribute = $this->readAttribute($request->cyclist, $file, 'heartrate_history');
                    //$attribute = $this->readAttribute($request->cyclist, $file, 'elevation_google');


                    // Obtendo overview
                    $path =
                        $request->cyclist .
                        DIRECTORY_SEPARATOR .
                        $file .
                        DIRECTORY_SEPARATOR .
                        'overview.json';

                    $overview = json_decode($this->readJsonFile(CONF_JSON_CYCLIST, $path));

                    $sum = new Decimal(0);
                    $segment = [];
                    $avg = [];
                    $idx1 = 0;
                    $idx2 = 0;

                    for ($idx2 = 0; $idx2 < count($attribute); $idx2++) {

                        $sum = $sum->add($attribute[$idx2]);
                        $meter = $sum->mul(1000);

                        //dp($sum);
                        //dp($meter->toFloat());
                        if ($meter->toFloat() >= $tam) {
                            array_push(
                                $segment,
                                [
                                    "avg" => $overview->distance,
                                    "meter" => $meter->toFloat(),
                                    "idx1" => $idx1,
                                    "idx2" => $idx2,
                                ]
                            );

                            array_push($avg, $meter->toString());
                            $idx1 = $idx2 + 1;
                            $sum = new Decimal(0);
                        }
                    }

                    array_push($avg_pedal, [
                        'cyclist' => $request->cyclist,
                        'pedal' => $file,
                        'avg' => Decimal::avg($avg)
                    ]);
                }
            }


            dp($avg_pedal);
            $avg_cyclist = [];
            foreach ($avg_pedal as $key => $value) {
                array_push($avg_cyclist, $value['avg']);
                //array_push($avg_cyclist, Decimal::avg($value['avg']));
            }

            array_push($geral, [
                'cyclist' => $i,
                'avg' => Decimal::avg($avg_cyclist)
            ]);
        }


        dp($geral);
        $resultado_final = [];
        foreach ($geral as $key => $value) {
            array_push($resultado_final, $value['avg']);
        }
        set_time_limit(30);
        dpexit(Decimal::avg($resultado_final));
        return $this->responseJson(true, "90 M", Decimal::avg($resultado_final));
    }
}
