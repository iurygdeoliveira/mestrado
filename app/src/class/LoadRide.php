<?php

declare(strict_types=1);

namespace src\class;

use DirectoryIterator;
use src\models\rideBD;
use src\class\ExtractInfo;

class LoadRide
{

    private $riderID; // ID do ciclista 
    private $dataset; // Recebe o nome do dataset
    private $fileNames; // Estrutura para receber os nomes dos arquivos GPX ou TCX 
    private $info; // Estrutura para extrair as informações dos arquivos GPX ou TCX
    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    public function __construct(string $dataset, string $riderID)
    {

        $this->dataset = $dataset;
        $this->riderID = $riderID;
        $this->ride = new rideBD();
    }

    // Obtem o nome do arquivo a ser parseado
    private function getName(string $datasetFileName)
    {

        $iterator = new DirectoryIterator($datasetFileName);

        foreach ($iterator as $fileInfo) {

            if ($fileInfo->isDot()) {
                continue;
            }
            yield ($fileInfo->getFilename());
        }
    }

    // Retorna um array contendo o nome dos arquivos de forma ordenada
    public function getFileNames(string $datasetFileName): array
    {


        $fileNames = [];
        foreach ($this->getName($datasetFileName) as $fileName) {
            array_push($fileNames, $fileName);
        }

        sort($fileNames, SORT_NATURAL); // Ordenando o nome dos arquivos
        $total = ['Total de Arquivos' => count($fileNames)];
        array_unshift($fileNames, $total);
        return $fileNames;
    }

    // processa o arquivo que contem os dados
    public function processFile()
    {

        $this->fileNames = $this->getFileNames($this->dataset);

        foreach ($this->fileNames as $filename) {

            if (is_array($filename)) {
                continue;
            }

            $ride = match (pathinfo($filename, PATHINFO_EXTENSION)) {
                "gpx" => $this->parseGPX($this->dataset . $filename),
                "tcx" => $this->parseTCX($this->dataset, $filename),
            };

            yield $ride;
        }
    }


    public function loadRide()
    {

        set_time_limit(300); // Aumentando o tempo limite de processamento

        $riders = [];

        for (; $this->processFile()->valid(); $this->processFile()->next()) {
            dump($this->processFile()->current());
        }
        exit;
        // foreach ($this->processFile() as $ride) {
        //     array_push($riders, $ride);
        // }

        exit;
        return true;
    }

    public function parseGPX(string $gpxfile): rideBD
    {

        $ride = new rideBD();
        $this->info = new ExtractInfo($gpxfile);
        // Extraindo informações do GPX file
        $ride->rider_id = $this->riderID;
        $ride->creator = $this->info->getCreatorGPX(); // Obtendo criador do arquivo gpx
        $ride->type = $this->info->getTypeGPX();
        $ride->datetime = $this->info->getDatetimeGPX();

        // Os dados devem possuir valores númericos ou então null
        // $ride->datetime = $gpx->getStartTime("Y-m-d H:i:s");
        // $ride->totaltime = BigDecimal::of($gpx->getTotalDuration())->dividedBy('3600', 6, RoundingMode::HALF_DOWN)->toFloat(); // Duração da atividade em horas
        // $ride->distance = BigDecimal::of($gpx->getTotalDistance())->dividedBy('1000', 6, RoundingMode::HALF_DOWN)->toFloat(); // Distância total em kilometros
        // $ride->calories = BigDecimal::of($gpx->getTotalCalories())->toScale(6, RoundingMode::HALF_DOWN)->toFloat(); // Distância total em kilometros
        // $ride->avgspeed = BigDecimal::of($gpx->getAverageSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat(); // Velocidade média em kilometros por hora
        // $ride->maxspeed = BigDecimal::of($gpx->getMaxSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat(); // Velocidade mínima em kilometros por hora
        // $ride->avgheart = null; // Frequência cardiaca média
        // $ride->maxheart = null; // Frequência cardiaca máxima
        // $ride->minheart = null; // Frequência cardiaca mínima
        // $ride->avgtemp = null; // Temperatura média
        // $ride->avgcadence = null; // Cadência média
        // $ride->mincadence = null; // Cadência mínima
        // $ride->maxcadence = null; // Cadência máxima
        // $ride->latitude = $gpx->getGeographicInformation()['center']['lat'];
        // $ride->longitude = $gpx->getGeographicInformation()['center']['lng'];
        // $ride->highest = $gpx->getGeographicInformation()['highest'];
        // $ride->lowest = $gpx->getGeographicInformation()['lowest'];
        // $ride->elevationGain = null; // Ganho de elevação
        // $ride->elevationLoss = null; // Perda de elevação 

        // dump("== OUTRA LIB ==");

        // $gpx = $this->gpx2->load($gpxfile);
        // dump(get_class_methods($gpx), $gpx);
        // $stats = $gpx->tracks[0];
        // dump(get_class_methods($stats), $stats);
        // $stats = $gpx->tracks[0]->stats;
        // dump($stats);
        // dump($ride);

        // // Obtendo criador do arquivo gpx
        // $ride_aux->creator = (new SimpleXMLElement(file_get_contents($gpxfile)))->attributes()->creator[0]->__toString();

        // // Os dados devem possuir valores númericos ou então null
        // $ride_aux->highest = $stats->maxAltitude;
        // $ride_aux->lowest = $stats->minAltitude;
        // dump($ride_aux);

        return $this->addNull($ride);
    }

    // Adicionando null nos elementos vazios
    private function addNull(rideBD $ride): rideBD
    {
        $ride->id = ($ride->id ? strval($ride->id) : null);
        $ride->creator = ($ride->creator ? strval($ride->creator) : null);
        $ride->type = ($ride->type ? strval($ride->type) : null);
        $ride->datetime = ($ride->datetime ? strval($ride->datetime) : null);
        $ride->totaltime = ($ride->totaltime ? strval($ride->totaltime) : null);
        $ride->distance = ($ride->distance ? strval($ride->distance) : null);
        $ride->calories = ($ride->calories ? strval($ride->calories) : null);
        $ride->avgspeed = ($ride->avgspeed ? strval($ride->avgspeed) : null);
        $ride->maxspeed = ($ride->maxspeed ? strval($ride->maxspeed) : null);
        $ride->avgheart = ($ride->avgheart ? strval($ride->avgheart) : null);
        $ride->maxheart = ($ride->maxheart ? strval($ride->maxheart) : null);
        $ride->minheart = ($ride->minheart ? strval($ride->minheart) : null);
        $ride->avgtemp = ($ride->avgtemp ? strval($ride->avgtemp) : null);
        $ride->avgcadence = ($ride->avgcadence ? strval($ride->avgcadence) : null);
        $ride->mincadence = ($ride->mincadence ? strval($ride->mincadence) : null);
        $ride->maxcadence = ($ride->maxcadence ? strval($ride->maxcadence) : null);
        $ride->latitude = ($ride->latitude ? strval($ride->latitude) : null);
        $ride->longitude = ($ride->longitude ? strval($ride->longitude) : null);
        $ride->highest = ($ride->highest ? strval($ride->highest) : null);
        $ride->lowest = ($ride->lowest ? strval($ride->lowest) : null);
        $ride->elevationGain = ($ride->elevationGain ? strval($ride->elevationGain) : null); // Ganho de elevação
        $ride->elevationLoss = ($ride->elevationLoss ? strval($ride->elevationLoss) : null);; // Perda de elevação

        return $ride;
    }

    public function parseTCX(string $dataset, array $fileNames)
    {

        set_time_limit(20);
        // $xml = $this->gpx->parse($dataset . $fileNames[1]);
        // $xml_aux = $this->gpx_aux->load($dataset . $fileNames[1]);
        // dump("xml", $xml);
        // dump("xml_aux", $xml_aux);

        // $stats_xml_aux = $xml_aux->tracks[0]->stats->toArray();
        // $segments_xml_aux = $xml_aux->tracks[0]->segments[0];
        // dump("segments", $segments_xml_aux);
        // dump("temperatura", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->aTemp);
        // dump("frequencia cardiaca", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->hr);
        // dump("cadencia", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->cad);

        // $xml = $this->tcx->parse($dataset . $fileNames[1]);
        // $xml_aux = new SimpleXMLElement(file_get_contents($dataset . $fileNames[1]));
        // dump($xml_aux);

        // dump($dataset . $fileNames[1]);

        // // se tcx
        // dump("Dataset", $xml_aux->Author->Name[0]->__toString());
        // //dump("Dataset", $xml_aux->creator);
        // dump("type", $xml->getType());
        // dump("Hora inicial", $xml->getStartTime("Y-m-d H:i:s"));
        // dump("distancia total em metros", $xml->getTotalDistance());
        // dump("duração total em segundos", $xml->getTotalDuration());
        // dump("total de Calorias", $xml->getTotalCalories());
        // dump("Velocidade média em milhas por hora", $xml->getAverageSpeedInMPH());
        // dump("Velocidade média em kilometros por hora", $xml->getAverageSpeedInKPH());
        // dump("total de calorias", $xml->getTotalCalories());
        // dump("velocidade máxima em milhas por hora", $xml->getMaxSpeedInMPH());
        // dump("velocidade máxima em kilometros por hora", $xml->getMaxSpeedInKPH());
        // dump("Informação Geográfica", $xml->getGeographicInformation());
        // dump("altitude máxima", $xml->getGeographicInformation()['highest']);
        // dump("altitude minima", $xml->getGeographicInformation()['lowest']);
        // dump("latitude", $xml->getGeographicInformation()['center']['lat']);
        // dump("longitude", $xml->getGeographicInformation()['center']['lng']);


        // $trackpoints = $xml->getLaps()[0];
        // dump("trackpoints", $trackpoints->getTrackPoints());

        // $point = $trackpoints->getTrackPoints()[0];
        // dump("time", $point->getTime("Y-m-d H:i:s"));
        // dump("position", $point->getPosition());
        // dump("altitude em metros", $point->getAltitude());
        // dump("distance em metros", $point->getDistance());
        // dump("speed", $point->getSpeed());
        // dump("heartRate", $point->getHeartRate());
        // dump("calories", $point->getCalories());
        // dump("cadence", $point->getCadence());
        // se gpx
        // dump("temperatura", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->aTemp);
        // dump("frequencia cardiaca", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->hr);
        // dump("cadencia", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->cad);
        exit;

        return true;
    }
}
