<?php

declare(strict_types=1);

namespace src\class;

use src\traits\GetNames;
use DirectoryIterator;
use src\models\rideBD;
use src\class\ExtractInfoGPX;
use src\class\ExtractInfoTCX;

class LoadRide
{

    private $riderID; // ID do ciclista 
    private $dataset; // Recebe o nome do dataset
    private $fileNames; // Estrutura para receber os nomes dos arquivos GPX ou TCX 
    private $info; // Estrutura para extrair as informações dos arquivos GPX ou TCX
    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    use GetNames;

    public function __construct(string $dataset, string $riderID)
    {

        $this->dataset = $dataset;
        $this->riderID = $riderID;
        $this->ride = new rideBD();
        $this->ride->bootstrap('ride' . $riderID);
    }

    public function loadRide(string $filename)
    {

        if (file_exists($filename . ".gpx")) {
            $this->parseGPX($filename . ".gpx");
            return $this->ride;
        }

        if (file_exists($filename . ".tcx")) {
            $this->parseTCX($filename . ".tcx");
            return $this->ride;
        }

        $this->ride->setFail(true);
        $this->ride->setMessage("Arquivo não encontrado");
        return $this->ride;
    }

    private function parseGPX(string $gpxfile)
    {

        $this->info = new ExtractInfoGPX($gpxfile);

        // Extraindo informações do GPX file
        $this->ride->creator = $this->info->getCreatorGPX(); // Obtendo criador do arquivo gpx
        $this->ride->type = $this->info->getTypeGPX(); // Obtendo tipo de atividade
        $this->ride->datetime = $this->info->getDatetimeGPX(); // Obtendo datatime de realização da atividade
        $this->ride->totaltime = $this->info->getTotalTimeGPX(); // Obtendo tempo total de realização da atividade
        $this->ride->distance = $this->info->getDistanceGPX(); // Obtendo distância total da atividade
        $this->ride->avgspeed = $this->info->getAvgSpeedGPX(); // Obtendo Velocidade média
        $this->ride->maxspeed = $this->info->getMaxSpeedGPX(); // Obtendo Velocidade Máxima
        $this->ride->calories = $this->info->getCaloriesGPX(); // Obtendo total de calorias
        $this->ride->avgheart = $this->info->getAvgHeartGPX(); // Obtendo frequencia cardiaca média
        $this->ride->minheart = $this->info->getMinHeartGPX(); // Obtendo frequencia cardiaca mínima
        $this->ride->maxheart = $this->info->getMaxHeartGPX(); // Obtendo frequencia cardiaca máxima
        $this->ride->avgtemp = $this->info->getAvgTempGPX(); // Obtendo Temperatura Média
        $this->ride->avgcadence = $this->info->getAvgCadenceGPX(); // Obtendo Cadencia Média
        $this->ride->mincadence = $this->info->getMinCadenceGPX(); // Obtendo Cadencia Mínima
        $this->ride->maxcadence = $this->info->getMaxCadenceGPX(); // Obtendo Cadencia Máxima
        $this->ride->latitude = $this->info->getLatitudeGPX(); // Obtendo Latitude
        $this->ride->longitude = $this->info->getLongitudeGPX(); // Obtendo Longitude
        $this->ride->highest = $this->info->getHighestGPX(); // Obtendo Altura Máxima
        $this->ride->lowest = $this->info->getLowestGPX(); // Obtendo Altura Minima
        $this->ride->elevationGain = $this->info->getElevationGainGPX(); // Obtendo Ganho de elevação
        $this->ride->elevationLoss = $this->info->getElevationLossGPX(); // Obtendo Perda de elevação

    }

    public function parseTCX(string $tcxfile): void
    {

        $this->info = new ExtractInfoTCX($tcxfile);
        //$this->info->analisando();

        $this->ride->creator = $this->info->getCreatorTCX(); // Obtendo criador do arquivo tcx
        $this->ride->type = $this->info->getTypeTCX(); // Obtendo tipo de atividade
        $this->ride->datetime = $this->info->getDatetimeTCX(); // Obtendo datatime de realização da atividade
        $this->ride->totaltime = $this->info->getTotalTimeTCX(); // Obtendo tempo total de realização da atividade
        $this->ride->distance = $this->info->getDistanceTCX(); // Obtendo distância total da atividade
        $this->ride->avgspeed = $this->info->getAvgSpeedTCX(); // Obtendo Velocidade média
        $this->ride->maxspeed = $this->info->getMaxSpeedTCX(); // Obtendo Velocidade Máxima
        $this->ride->calories = $this->info->getCaloriesTCX(); // Obtendo total de calorias
        $this->ride->avgheart = $this->info->getAvgHeartTCX(); // Obtendo frequencia cardiaca média
        $this->ride->minheart = $this->info->getMinHeartTCX(); // Obtendo frequencia cardiaca mínima
        $this->ride->maxheart = $this->info->getMaxHeartTCX(); // Obtendo frequencia cardiaca máxima
        $this->ride->avgtemp = $this->info->getAvgTempTCX(); // Obtendo Temperatura Média
        $this->ride->avgcadence = $this->info->getAvgCadenceTCX(); // Obtendo Cadencia Média
        $this->ride->mincadence = $this->info->getMinCadenceTCX(); // Obtendo Cadencia Mínima
        $this->ride->maxcadence = $this->info->getMaxCadenceTCX(); // Obtendo Cadencia Máxima
        $this->ride->latitude = $this->info->getLatitudeTCX(); // Obtendo Latitude
        $this->ride->longitude = $this->info->getLongitudeTCX(); // Obtendo Longitude
        $this->ride->highest = $this->info->getHighestTCX(); // Obtendo Altura Máxima
        $this->ride->lowest = $this->info->getLowestTCX(); // Obtendo Altura Minima
        $this->ride->elevationGain = $this->info->getElevationGainTCX(); // Obtendo Ganho de elevação
        $this->ride->elevationLoss = $this->info->getElevationLossTCX(); // Obtendo Perda de elevação
    }
}
