<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\GetNames;
use src\traits\responseJson;
use src\models\rideBD;
use src\classes\ExtractInfoGPX;
use src\classes\ExtractInfoTCX;


class LoadRide
{

    private $riderID; // ID do ciclista 
    private $dataset; // Recebe o nome do dataset 
    private $info; // Estrutura para extrair as informações dos arquivos GPX ou TCX
    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    use GetNames, responseJson;

    public function __construct(string $dataset, string $riderID, string $activityID)
    {

        $this->dataset = $dataset;
        $this->riderID = $riderID;
        $this->ride = new rideBD();
        $this->ride->bootstrap($riderID, $activityID);
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

    public function extractData(string $file)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        // Identificando extensão do arquivo
        $extension = $this->fileExists($file);

        // Arquivo não encontrado
        if (!$extension) {
            return "Arquivo não encontrado";
        }

        $xml_string = file_get_contents($file . $extension);

        //Extraindo estrutura de nós do arquivo
        $this->info = match ($extension) {
            ".gpx" => new ExtractInfoGPX($xml_string),
            ".tcx" => new ExtractInfoTCX($xml_string)
        };


        // // Salvando dados da corrida no BD

        // $this->ride->creator = $this->info->getCreator();
        // $this->ride->nodes = $this->info->getNodes();
        // $this->ride->datetime = $this->info->getDateTime();

        // Latitudes
        $latitudes = $this->info->getLatitudes();

        if ($latitudes) {
            $this->ride->latitude_inicial = $latitudes[0];
            $this->ride->latitudes = $latitudes[1];
        } else {
            $this->ride->latitude_inicial = null;
            $this->ride->latitudes = null;
        }

        // Longitudes
        $longitudes = $this->info->getLongitudes();

        if ($longitudes) {
            $this->ride->longitude_inicial = $longitudes[0];
            $this->ride->longitudes = $longitudes[1];
        } else {
            $this->ride->longitude_inicial = null;
            $this->ride->longitudes = null;
        }
        // $this->ride->coordinates_percentage = $this->info->getCoordinatesPercentage();

        // if (($this->ride->latitude_inicial != null) && ($this->ride->longitude_inicial != null)) {

        //     $result = $this->info->getAddress($this->ride->latitude_inicial, $this->ride->longitude_inicial);
        //     $this->ride->address_openstreetmap = (isset($result->openstreetmap->address) ? $result->openstreetmap->address : null);
        //     $this->ride->address_google = (isset($result->google->address) ? $result->google->address : null);
        //     $this->ride->address_bing = (isset($result->bing->address) ? $result->bing->address : null);
        //     $this->ride->address_strava = (isset($result->strava->address) ? $result->strava->address : null);
        // } else {
        //     $this->ride->address_openstreetmap =  null;
        //     $this->ride->address_google = null;
        //     $this->ride->address_bing = null;
        //     $this->ride->address_strava = null;
        // }

        // if (($this->ride->latitude_inicial != null) && ($this->ride->longitude_inicial != null)) {
        //     $this->ride->bbox = $this->info->getBbox($this->ride->latitudes, $this->ride->longitudes);
        // } else {
        //     $this->ride->bbox = null;
        // }

        if (($this->ride->latitude_inicial != null) && ($this->ride->longitude_inicial != null)) {

            $elevation = $this->info->getElevation($this->ride->latitudes, $this->ride->longitudes);
            $this->ride->elevation_file = (isset($elevation->file) ? $elevation->file : null);
            $this->ride->elevation_google = (isset($elevation->google) ? $elevation->google : null);
            $this->ride->elevation_bing = (isset($elevation->bing) ? $elevation->bing : null);
            $this->ride->elevation_srtm = (isset($elevation->srtm) ? $elevation->srtm : null);
            $this->ride->elevation_percentage = $this->info->getelevationPercentage();
        } else {
            $this->ride->elevation_file = null;
            $this->ride->elevation_google = null;
            $this->ride->elevation_bing = null;
            $this->ride->elevation_srtm = null;
            $this->ride->elevation_percentage = null;
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
}
