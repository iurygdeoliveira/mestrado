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

    /**
     * Realiza a extração da estrutura de nós dos arquivos
     *
     * @param string $file Nome do arquivo a ser analisado
     * @return bool|string true para extração com sucesso, string com erro para falha
     */
    public function preprocessar(string $file): bool|string
    {

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

        $this->ride->nodes = $this->info->getNodes();

        if ($this->ride->save()) {
            return true;
        } else {
            return "Erro ao salvar no BD " . $this->ride->message();
        }
    }

    public function extractData(string $file)
    {

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

        // Salvando dados da corrida no BD
        // $this->ride->creator = $this->info->getCreator();
        // $this->ride->datetime = $this->info->getDateTime();


        // Latitude Inicial e Final
        $latitudes = $this->info->getLatitudeFirstEnd();
        $this->ride->latitude_final = (isset($latitudes[1]) ? $latitudes[1] : null);
        $this->ride->latitude_inicial = (isset($latitudes[0]) ? $latitudes[0] : null);

        // Longitude Inicial e Final
        $longitudes = $this->info->getLongitudeFirstEnd();
        $this->ride->longitude_final = (isset($longitudes[1]) ? $longitudes[1] : null);
        $this->ride->longitude_inicial = (isset($longitudes[0]) ? $longitudes[0] : null);

        if (($this->ride->latitude_inicial != null) && ($this->ride->longitude_inicial != null)) {

            $address = $this->info->getAddress($this->ride->latitude_inicial, $this->ride->longitude_inicial);
            $this->ride->country = (isset($address[0]) ? $address[0] : null);
            $this->ride->city = (isset($address[1]) ? $address[1] : null);
            $this->ride->road = (isset($address[2]) ? $address[2] : null);
        } else {
            $this->ride->country = null;
            $this->ride->city = null;
            $this->ride->road = null;
        }


        // $this->ride->duration = $this->info->getDuration();
        // $this->ride->distance = $this->info->getDistance();

        // if (($this->ride->duration != null) && ($this->ride->distance != null)) {
        //     $this->ride->speed = $this->info->getSpeed(
        //         $this->ride->distance,
        //         $this->ride->duration
        //     );
        // } else {
        //     $this->ride->speed = null;
        // }
        // $this->ride->cadence = $this->info->getCadence();
        // $this->ride->heartrate = $this->info->getHeartRate();
        // $this->ride->temperature = $this->info->getTemperature();
        // $this->ride->calories = $this->info->getCalories();
        // $nodes->elevation_gain = ($this->multi_array_key_exists('elevation', $aux) ? true : null);
        // $nodes->elevation_loss = (($nodes->elevation_gain == true) ? true : null);
        // $this->ride->total_trackpoints = $this->info->getTotalTrackpoints();

        if ($this->ride->save()) {
            return true;
        } else {
            return "Erro ao salvar no BD " . $this->ride->message();
        }
    }
}
