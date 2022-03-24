<?php

declare(strict_types=1);

namespace src\class;

use DirectoryIterator;
use src\traits\Date;
use phpGPX\phpGPX;
use SimpleXMLElement;
use Waddle\Parsers\GPXParser;
use Waddle\Parsers\TCXParser;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use stdClass;

class ExtractInfo
{

    use Date;

    private $gpxfile; //Estrutura que recebe o nome do dataset
    private $aux; // Estrutra auxiliar para armazenar dados durante o parseamento
    private $gpx, $gpx2; // Armazena os dados durante o parseamento de arquivos gpx
    private $tcx; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(string $gpxfile)
    {
        $this->gpxfile = $gpxfile;
        $this->gpx2 = new phpGPX();
        $this->gpx = (new GPXParser())->parse($gpxfile);
        $this->tcx = new TCXParser();
    }


    public function getCreatorGPX()
    {
        return (new SimpleXMLElement(file_get_contents($this->gpxfile)))->attributes()->creator[0]->__toString();
    }

    public function getTypeGPX()
    {
        return $this->gpx->getType();
    }

    public function getDateTimeGPX()
    {
        return $this->gpx->getStartTime("Y-m-d H:i:s");
    }

    // public function parseGPX(string $gpxfile, string $riderID): rideBD
    // {

    //     $ride->totaltime = BigDecimal::of($gpx->getTotalDuration())->dividedBy('3600', 6, RoundingMode::HALF_DOWN)->toFloat(); // Duração da atividade em horas
    //     $ride->distance = BigDecimal::of($gpx->getTotalDistance())->dividedBy('1000', 6, RoundingMode::HALF_DOWN)->toFloat(); // Distância total em kilometros
    //     $ride->calories = BigDecimal::of($gpx->getTotalCalories())->toScale(6, RoundingMode::HALF_DOWN)->toFloat(); // Distância total em kilometros
    //     $ride->avgspeed = BigDecimal::of($gpx->getAverageSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat(); // Velocidade média em kilometros por hora
    //     $ride->maxspeed = BigDecimal::of($gpx->getMaxSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat(); // Velocidade mínima em kilometros por hora
    //     $ride->avgheart = null; // Frequência cardiaca média
    //     $ride->maxheart = null; // Frequência cardiaca máxima
    //     $ride->minheart = null; // Frequência cardiaca mínima
    //     $ride->avgtemp = null; // Temperatura média
    //     $ride->avgcadence = null; // Cadência média
    //     $ride->mincadence = null; // Cadência mínima
    //     $ride->maxcadence = null; // Cadência máxima
    //     $ride->latitude = $gpx->getGeographicInformation()['center']['lat'];
    //     $ride->longitude = $gpx->getGeographicInformation()['center']['lng'];
    //     $ride->highest = $gpx->getGeographicInformation()['highest'];
    //     $ride->lowest = $gpx->getGeographicInformation()['lowest'];
    //     $ride->elevationGain = null; // Ganho de elevação
    //     $ride->elevationLoss = null; // Perda de elevação 

    //     dump("== OUTRA LIB ==");

    //     $gpx = $this->gpx2->load($gpxfile);
    //     dump(get_class_methods($gpx), $gpx);
    //     $stats = $gpx->tracks[0];
    //     dump(get_class_methods($stats), $stats);
    //     $stats = $gpx->tracks[0]->stats;
    //     dump($stats);
    //     dump($ride);

    //     // Obtendo criador do arquivo gpx
    //     $ride_aux->creator = (new SimpleXMLElement(file_get_contents($gpxfile)))->attributes()->creator[0]->__toString();

    //     // Os dados devem possuir valores númericos ou então null
    //     $ride_aux->highest = $stats->maxAltitude;
    //     $ride_aux->lowest = $stats->minAltitude;
    //     dump($ride_aux);
    //     exit;
    //     return $this->addNull($ride);
    // }

    // // Adicionando null nos elementos vazios
    // private function addNull(rideBD $ride): rideBD
    // {
    //     $ride->id = ($ride->id ? strval($ride->id) : null);
    //     $ride->creator = ($ride->creator ? strval($ride->creator) : null);
    //     $ride->type = ($ride->type ? strval($ride->type) : null);
    //     $ride->datetime = ($ride->datetime ? strval($ride->datetime) : null);
    //     $ride->totaltime = ($ride->totaltime ? strval($ride->totaltime) : null);
    //     $ride->distance = ($ride->distance ? strval($ride->distance) : null);
    //     $ride->calories = ($ride->calories ? strval($ride->calories) : null);
    //     $ride->avgspeed = ($ride->avgspeed ? strval($ride->avgspeed) : null);
    //     $ride->minspeed = ($ride->minspeed ? strval($ride->minspeed) : null);
    //     $ride->maxspeed = ($ride->maxspeed ? strval($ride->maxspeed) : null);
    //     $ride->avgheart = ($ride->avgheart ? strval($ride->avgheart) : null);
    //     $ride->maxheart = ($ride->maxheart ? strval($ride->maxheart) : null);
    //     $ride->minheart = ($ride->minheart ? strval($ride->minheart) : null);
    //     $ride->avgtemp = ($ride->avgtemp ? strval($ride->avgtemp) : null);
    //     $ride->avgcadence = ($ride->avgcadence ? strval($ride->avgcadence) : null);
    //     $ride->mincadence = ($ride->mincadence ? strval($ride->mincadence) : null);
    //     $ride->maxcadence = ($ride->maxcadence ? strval($ride->maxcadence) : null);
    //     $ride->latitude = ($ride->latitude ? strval($ride->latitude) : null);
    //     $ride->longitude = ($ride->longitude ? strval($ride->longitude) : null);
    //     $ride->highest = ($ride->highest ? strval($ride->highest) : null);
    //     $ride->lowest = ($ride->lowest ? strval($ride->lowest) : null);

    //     return $ride;
    // }
}
