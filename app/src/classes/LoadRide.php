<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\GetNames;
use src\traits\responseJson;
use src\models\rideBD;
use src\classes\Regex;
use src\classes\ExtractInfoGPX;
use src\classes\ExtractInfoTCX;


class LoadRide
{

    private $ride; // Estrutura para receber os dados da corrida e persistir no BD
    private $info;

    use GetNames, responseJson;

    public function __construct(string $rider, string $activityID = null)
    {
        // Obtendo id do ciclista
        $id = Regex::match('/\d{1,2}/mius', $rider);
        $this->ride = (new rideBD())->bootstrap($id[0], $activityID);
    }


    public function extractData()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        if (!isset($this->ride)) {
            return false;
        }
        // Salvando dados da corrida no BD

        $xmlString = file_get_contents($this->ride->path);
        $this->info = new ExtractInfoGPX($xmlString);

        // if (empty($this->ride->creator)) {
        //     $this->ride->creator = $this->info->getCreator();
        // }

        // if (empty($this->ride->nodes)) {
        //     $this->ride->creator = $this->info->getNodes();
        // }

        if (!empty($this->ride->datetime)) {
            //$this->ride->datetime = $this->info->getDateTime();
            //$this->ride->time_total = $this->info->getTimeTotal();
            $this->ride->time_history = $this->info->getTimeHistory();
            //$this->ride->time_percentage = $this->info->getTimePercentage();
            $this->ride->time_trackpoint = $this->info->getTimeTrackpoint($this->ride->time_history);
        }

        // Latitudes
        // if (empty($this->ride->latitudes)) {

        //     $latitudes = $this->info->getLatitudes();
        //     if ($latitudes) {
        //         $this->ride->latitude_inicial = $latitudes[0];
        //         $this->ride->latitudes = $latitudes[1];
        //     } else {
        //         $this->ride->latitude_inicial = null;
        //         $this->ride->latitudes = null;
        //     }
        // }

        // Longitudes
        // if (empty($this->ride->longitudes)) {

        //     $longitudes = $this->info->getLongitudes();
        //     if ($longitudes) {
        //         $this->ride->longitude_inicial = $longitudes[0];
        //         $this->ride->longitudes = $longitudes[1];
        //     } else {
        //         $this->ride->longitude_inicial = null;
        //         $this->ride->longitudes = null;
        //     }
        // }

        // if (
        //     !empty($this->ride->coordinates_percentage) &&
        //     !empty($this->ride->latitudes) &&
        //     !empty($this->ride->longitudes)
        // ) {
        //    $this->ride->coordinates_percentage = $this->info->getCoordinatesPercentage();
        //     $this->ride->total_coordinates = $this->info->getTotalCoordinates();
        // }

        // if (
        //     !empty($this->ride->latitude_inicial) &&
        //     !empty($this->ride->longitude_inicial)
        // ) {

        // if (empty($this->ride->address_google)) {
        //     $this->ride->address_google = $this->info->getAddressGoogle($this->ride->latitude_inicial, $this->ride->longitude_inicial);
        // }

        // if (empty($this->ride->address_bing)) {
        //     $this->ride->address_bing = $this->info->getAddressBing($this->ride->latitude_inicial, $this->ride->longitude_inicial);
        // }

        // if (!empty($this->ride->elevation_file)) {
        //     $this->ride->elevation_file = $this->info->getElevationFile();
        //     $this->ride->elevation_total_file = $this->info->getElevationTotal($this->ride->elevation_file);
        //     $this->ride->elevation_avg_file = $this->info->getElevationAvg($this->ride->elevation_file);
        //     $this->ride->elevation_percentage_file = $this->info->getPercentage($this->ride->elevation_file);
        // }

        // if (!empty($this->ride->elevation_google)) {
        //     // $this->ride->elevation_google = $this->info->getElevationGoogle($this->ride->latitudes, $this->ride->longitudes);
        //     $this->ride->elevation_total_google = $this->info->getElevationTotal($this->ride->elevation_google);
        //     $this->ride->elevation_avg_google = $this->info->getElevationAvg($this->ride->elevation_google);
        //     $this->ride->elevation_google_percentage = $this->info->getPercentage($this->ride->elevation_google);
        // }

        // if (!empty($this->ride->elevation_bing)) {
        //     //     $this->ride->elevation_bing = $this->info->getElevationBing($this->ride->latitudes, $this->ride->longitudes);
        //     $this->ride->elevation_total_bing = $this->info->getElevationTotal($this->ride->elevation_bing);
        //     $this->ride->elevation_avg_bing = $this->info->getElevationAvg($this->ride->elevation_bing);
        //     $this->ride->elevation_bing_percentage = $this->info->getPercentage($this->ride->elevation_bing);
        // }
        // } else {
        //     $this->ride->address_google = null;
        //     $this->ride->address_bing = null;
        //     $this->ride->bbox = null;
        //     $this->ride->centroid = null;
        //     $this->ride->coordinates_percentage = null;
        //     $this->ride->total_coordinates = null;
        //     $this->ride->elevation_file = null;
        //     $this->ride->elevation_percentage_file = null;
        //     $this->ride->elevation_avg_file = null;
        //     $this->ride->elevation_google = null;
        //     $this->ride->elevation_google_percentage = null;
        //     $this->ride->elevation_avg_google = null;
        //     $this->ride->elevation_bing = null;
        //     $this->ride->elevation_bing_percentage = null;
        //     $this->ride->elevation_avg_bing = null;
        // }

        // $this->ride->distance_history_haversine = $this->info->getDistanceHistory();
        // $this->ride->distance_haversine = $this->info->getDistance($this->ride->distance_history_haversine);

        $this->ride->speed_history = $this->info->getSpeedHistory(
            $this->ride->distance_history_haversine,
            $this->ride->time_trackpoint
        );
        // $this->ride->speed_avg = $this->info->getSpeedAVG(
        //     $this->ride->distance_haversine,
        //     $this->ride->time_total
        // );

        // $heartrate = $this->info->getHeartRate();
        // $this->ride->heartrate_history = $this->info->getHeartRateHistory();
        // $this->ride->heartrate_avg = $this->info->getHeartrateAVG();
        // $this->ride->heartrate_percentage = $this->info->getHeartRatePercentage();
        // $this->ride->total_heartrate = $this->info->getHeartRateTotal($this->ride->heartrate_history);

        // $temperature = $this->info->getTemperature();
        // $this->ride->temperature_file = $temperature->file;
        // $this->ride->temperature_php = $temperature->php;
        // $this->ride->temperature_percentage = $this->info->getTemperaturePercentage();


        // $this->ride->total_trackpoints = $this->info->getTotalTrackpoints();

        set_time_limit(30);
        if ($this->ride->save()) {
            return true;
        } else {
            return "Erro ao salvar no BD " . $this->ride->message();
        }
    }

    public function fileExists(string $filename)
    {

        if (file_exists($filename . ".gpx")) {

            return ".gpx";
        }

        if (file_exists($filename . ".tcx")) {
            return ".tcx";
        }

        return false;
    }

    public function identifyFiles(string $path)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        // Identificando extensão do arquivo

        // Salvando dados da corrida no BD

        if (empty($this->ride->path)) {

            $fileNames = $this->getFileNames($path);

            if ($this->ride->id > 1) {
                $id_previous = $this->ride->id - 1;
                $previous = (new rideBD())->bootstrap($this->ride->rider, strval($id_previous));

                $path_previous = $previous->data()->path;
                $extension_previous = pathinfo($path_previous, PATHINFO_EXTENSION);
                $partial = basename($path_previous, "." . $extension_previous);
                $fileNames = array_slice($fileNames, intval($partial) - 1);
            }

            foreach ($fileNames as $key => $value) {

                $xmlString = file_get_contents($this->ride->path);
                $info = new ExtractInfoGPX($xmlString);

                if ($info->getDateTime() == $this->ride->data()->datetime) {
                    $this->ride->path = $path . $value;
                    break;
                }
            }
        }

        set_time_limit(30);
        if ($this->ride->save()) {
            return true;
        } else {
            return "Erro ao salvar no BD " . $this->ride->message();
        }
    }
}
