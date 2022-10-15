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

        // if (empty($this->ride->creator)) {
        //     $this->ride->creator = $this->info->getCreator();
        // }

        // if (empty($this->ride->nodes)) {
        //     $this->ride->creator = $this->info->getNodes();
        // }

        // if (empty($this->ride->datetime)) {
        //     $this->ride->datetime = $this->info->getDateTime();
        // }

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
        //     empty($this->ride->coordinates_percentage) &&
        //     !empty($this->ride->latitudes) &&
        //     !empty($this->ride->longitudes)
        // ) {
        //     $this->ride->coordinates_percentage = $this->info->getCoordinatesPercentage();
        // }

        if (
            !empty($this->ride->latitude_inicial) &&
            !empty($this->ride->longitude_inicial)
        ) {

            // if (empty($this->ride->address_openstreetmap)) {
            //     $this->ride->address_openstreetmap = $this->info->getAddressOSM($this->ride->latitude_inicial, $this->ride->longitude_inicial);
            // }

            // if (empty($this->ride->address_google)) {
            //     $this->ride->address_google = $this->info->getAddressGoogle($this->ride->latitude_inicial, $this->ride->longitude_inicial);
            // }

            // if (empty($this->ride->address_bing)) {
            //     $this->ride->address_bing = $this->info->getAddressBing($this->ride->latitude_inicial, $this->ride->longitude_inicial);
            // }

            // if (empty($this->ride->elevation_file)) {
            //     $this->ride->elevation_file = $this->info->getElevationFile();
            // }

            // if (empty($this->ride->elevation_google)) {
            //     $this->ride->elevation_google = $this->info->getElevationGoogle($this->ride->latitudes, $this->ride->longitudes);
            // }

            // if (empty($this->ride->elevation_bing)) {
            //     $this->ride->elevation_bing = $this->info->getElevationBing($this->ride->latitudes, $this->ride->longitudes);
            // }
        } else {
            $this->ride->address_openstreetmap = null;
            $this->ride->address_google = null;
            $this->ride->address_bing = null;
            $this->ride->bbox = null;
            $this->ride->elevation_file = null;
            $this->ride->elevation_google = null;
            $this->ride->elevation_bing = null;
        }

        // $duration = $this->info->getDuration();
        // $this->ride->duration_file = $duration->file;
        // $this->ride->duration_php = $duration->php;
        // $this->ride->time_percentage = $this->info->getTimePercentage();


        // $distance = $this->info->getDistance();
        // $this->ride->distance_file = $distance->file;
        // $this->ride->distance_php = $distance->php;

        // $speed = $this->info->getSpeed(
        //     $distance,
        //     $duration
        // );
        // $this->ride->speed_file = $speed->file;
        // $this->ride->speed_php = $speed->php;

        // $cadence = $this->info->getCadence();
        // $this->ride->cadence_file = $cadence->file;
        // $this->ride->cadence_php = $cadence->php;
        // $this->ride->cadence_percentage = $this->info->getCadencePercentage();

        // $heartrate = $this->info->getHeartRate();
        // $this->ride->heartrate_file = $heartrate->file;
        // $this->ride->heartrate_php = $heartrate->php;
        // $this->ride->heartrate_percentage = $this->info->getHeartRatePercentage();

        // $temperature = $this->info->getTemperature();
        // $this->ride->temperature_file = $temperature->file;
        // $this->ride->temperature_php = $temperature->php;
        // $this->ride->temperature_percentage = $this->info->getTemperaturePercentage();

        // $calories = $this->info->getCalories();
        // $this->ride->calories_file = $calories->file;
        // $this->ride->calories_php = $calories->php;
        // $this->ride->calories_percentage = $this->info->getCaloriesPercentage();

        // if (($this->ride->latitude_inicial != null) && ($this->ride->longitude_inicial != null)) {

        //     $altitude = $this->info->getAltitude();
        //     $this->ride->altitude_file = $altitude->file;
        //     $this->ride->altitude_without_threshold_php = $altitude->without_threshold;
        //     $this->ride->altitude_with_threshold_php = $altitude->with_threshold;
        //     $this->ride->altitude_percentage = $this->info->getAltitudePercentage();
        // } else {
        //     $this->ride->altitude_file = null;
        //     $this->ride->altitude_without_threshold_php = null;
        //     $this->ride->altitude_with_threshold_php = null;
        //     $this->ride->altitude_percentage = null;
        // }

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

    // public function readFile(string $file): bool|string
    // {


    //     $xml_string = file_get_contents($file . $extension);


    //     //Extraindo estrutura de nós do arquivo
    //     $this->info = match ($extension) {
    //         ".gpx" => new ExtractInfoGPX($xml_string),
    //         ".tcx" => new ExtractInfoTCX($xml_string)
    //     };

    //     $this->ride->nodes = $this->info->getNodes();

    //     if ($this->ride->save()) {
    //         return true;
    //     } else {
    //         return "Erro ao salvar no BD " . $this->ride->message();
    //     }
    // }

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
                $xml_string = file_get_contents($path . $value);
                $extension = pathinfo($value, PATHINFO_EXTENSION);

                $info = match ($extension) {
                    "gpx" => new ExtractInfoGPX($xml_string),
                    "tcx" => new ExtractInfoTCX($xml_string)
                };

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
