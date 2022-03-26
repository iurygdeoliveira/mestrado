<?php

declare(strict_types=1);

namespace src\class;

use src\traits\GetNames;
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

        $this->info = new ExtractInfo($gpxfile);

        // Extraindo informações do GPX file
        $this->ride->creator = $this->info->getCreatorGPX(); // Obtendo criador do arquivo gpx
        $this->ride->type = $this->info->getTypeGPX(); // Obtendo tipo de atividade
        $this->ride->datetime = $this->info->getDatetimeGPX(); // Obtendo datatime de realização da atividade

        // Os dados devem possuir valores númericos ou então null

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

        return $this->addNull();
    }

    // Adicionando null nos elementos vazios
    private function addNull(): void
    {
        $this->ride->id = ($this->ride->id ? strval($this->ride->id) : null);
        $this->ride->creator = ($this->ride->creator ? strval($this->ride->creator) : null);
        $this->ride->type = ($this->ride->type ? strval($this->ride->type) : null);
        $this->ride->datetime = ($this->ride->datetime ? strval($this->ride->datetime) : null);
        $this->ride->totaltime = ($this->ride->totaltime ? strval($this->ride->totaltime) : null);
        $this->ride->distance = ($this->ride->distance ? strval($this->ride->distance) : null);
        $this->ride->calories = ($this->ride->calories ? strval($this->ride->calories) : null);
        $this->ride->avgspeed = ($this->ride->avgspeed ? strval($this->ride->avgspeed) : null);
        $this->ride->maxspeed = ($this->ride->maxspeed ? strval($this->ride->maxspeed) : null);
        $this->ride->avgheart = ($this->ride->avgheart ? strval($this->ride->avgheart) : null);
        $this->ride->maxheart = ($this->ride->maxheart ? strval($this->ride->maxheart) : null);
        $this->ride->minheart = ($this->ride->minheart ? strval($this->ride->minheart) : null);
        $this->ride->avgtemp = ($this->ride->avgtemp ? strval($this->ride->avgtemp) : null);
        $this->ride->avgcadence = ($this->ride->avgcadence ? strval($this->ride->avgcadence) : null);
        $this->ride->mincadence = ($this->ride->mincadence ? strval($this->ride->mincadence) : null);
        $this->ride->maxcadence = ($this->ride->maxcadence ? strval($this->ride->maxcadence) : null);
        $this->ride->latitude = ($this->ride->latitude ? strval($this->ride->latitude) : null);
        $this->ride->longitude = ($this->ride->longitude ? strval($this->ride->longitude) : null);
        $this->ride->highest = ($this->ride->highest ? strval($this->ride->highest) : null);
        $this->ride->lowest = ($this->ride->lowest ? strval($this->ride->lowest) : null);
        $this->ride->elevationGain = ($this->ride->elevationGain ? strval($this->ride->elevationGain) : null); // Ganho de elevação
        $this->ride->elevationLoss = ($this->ride->elevationLoss ? strval($this->ride->elevationLoss) : null);; // Perda de elevação
    }

    public function parseTCX(string $tcxfile): void
    {

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

    }
}
