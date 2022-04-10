<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\Date;
use src\traits\XmlArray;
use src\traits\ArrayFind;
use SimpleXMLElement;
use stdClass;

class ExtractInfoTCX
{

    use Date, XmlArray, ArrayFind;

    private $xml; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    public function getCreator()
    {
        dump($this->xml);
        exit;
        return $this->xml->attributes()->creator[0]->__toString();
    }


    public function getNodes()
    {

        $nodes = new stdClass();
        $aux = $this->xml2array_parse($this->xml);
        dump($aux);

        $nodes->creator = ($this->multi_array_key_exists('Name', $aux) ? true : null);
        $nodes->datetime = ($this->multi_array_key_exists('Id', $aux) ? true : null);
        $nodes->latitude_final = ($this->multi_array_key_exists('LatitudeDegrees', $aux) ? true : null);
        $nodes->longitude_final = ($this->multi_array_key_exists('LongitudeDegrees', $aux) ? true : null);
        $nodes->latitude_inicial = ($nodes->latitude_final == true ? true : null);
        $nodes->longitude_inicial = ($nodes->longitude_final == true ? true : null);
        $nodes->duration = ($this->multi_array_key_exists('TotalTimeSeconds', $aux) ? true : null);
        $nodes->distance = ($this->multi_array_key_exists('DistanceMeters', $aux) ? true : null);
        $nodes->speed = (($nodes->distance == true) && ($nodes->duration == true) ? true : null);
        $nodes->cadence = ($this->multi_array_key_exists('Cadence', $aux) ? true : null);
        $nodes->heartrate = ($this->multi_array_key_exists('HeartRateBpm', $aux) ? true : null);
        $nodes->temperature = ($this->multi_array_key_exists('temperature', $aux) ? true : null);
        $nodes->calories = ($this->multi_array_key_exists('Calories', $aux) ? true : null);
        $nodes->elevation_gain = ($this->multi_array_key_exists('AltitudeMeters', $aux) ? true : null);
        $nodes->elevation_loss = (($nodes->elevation_gain == true) ? true : null);
        $nodes->total_trackpoints = ($this->multi_array_key_exists('Trackpoint', $aux) ? true : null);

        return $nodes;
    }

    // public function getTypeTCX()
    // {
    //     return $this->tcx->getType();
    // }

    // public function getDateTimeTCX()
    // {
    //     return $this->tcx->getStartTime("Y-m-d H:i:s");
    // }

    // // Tempo total em horas
    // public function getTotalTimeTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getTotalDuration())->dividedBy('3600', 6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Distância total em kilometros
    // public function getDistanceTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getTotalDistance())->dividedBy('1000', 6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Média de velocidade
    // public function getAvgSpeedTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getAverageSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Velocidade Máxima
    // public function getMaxSpeedTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getMaxSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // public function getCaloriesTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getTotalCalories())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // public function getAvgHeartTCX()
    // {
    //     return null;
    // }

    // public function getMinHeartTCX()
    // {
    //     return null;
    // }

    // public function getMaxHeartTCX()
    // {
    //     return null;
    // }

    // public function getAvgTempTCX()
    // {
    //     return null;
    // }

    // public function getAvgCadenceTCX()
    // {
    //     return null;
    // }

    // public function getMinCadenceTCX()
    // {
    //     return null;
    // }

    // public function getMaxCadenceTCX()
    // {
    //     return null;
    // }

    // public function getLatitudeTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getGeographicInformation()['center']['lat'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    // }

    // public function getLongitudeTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getGeographicInformation()['center']['lng'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    // }

    // // Altura Mínima
    // public function getLowestTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getGeographicInformation()['lowest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Altura Máxima
    // public function getHighestTCX()
    // {
    //     return strval(BigDecimal::of($this->tcx->getGeographicInformation()['highest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // public function getElevationGainTCX()
    // {
    //     return null;
    // }

    // public function getElevationLossTCX()
    // {
    //     return null;
    // }
}
