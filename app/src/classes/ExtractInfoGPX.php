<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\Date;
use src\traits\XmlArray;
use src\traits\ArrayFind;
use SimpleXMLElement;
use stdClass;


class ExtractInfoGPX
{

    use Date, XmlArray, ArrayFind;

    private $xml; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }


    public function getNodes()
    {

        $nodes = array();
        $aux = array();

        preg_match_all("/<([a-z]|[0-9]|[A-Z]|:)+/mius", $this->xml, $nodes);
        $nodes = array_unique($nodes[0], SORT_REGULAR);

        preg_match_all("/lat|lon/mius", $this->xml, $aux);
        $aux = array_unique($aux[0], SORT_REGULAR);

        $nodes = array_merge($nodes, $aux);

        $replace = function ($valor) {
            return str_ireplace('<', '', $valor);
        };
        $nodes = array_map($replace, $nodes);

        $reduce = function ($carry, $item) {
            $carry .= $item . '-';
            return $carry;
        };

        $nodes = array_reduce($nodes, $reduce);
        return $nodes;

        // $aux = $this->xml2array_parse($this->xml);

        // $nodes->creator = ($this->multi_array_key_exists('creator', $aux) ? true : null);
        // $nodes->datetime = ($this->multi_array_key_exists('time', $aux) ? true : null);
        // $nodes->latitude_final = ($this->multi_array_key_exists('lat', $aux) ? true : null);
        // $nodes->longitude_final = ($this->multi_array_key_exists('lon', $aux) ? true : null);
        // $nodes->latitude_inicial = ($nodes->latitude_final == true ? true : null);
        // $nodes->longitude_inicial = ($nodes->longitude_final == true ? true : null);
        // $nodes->duration = ($this->multi_array_key_exists('time', $aux['trk']) ? true : null);
        // $nodes->distance = (($nodes->longitude_final == true) && ($nodes->latitude_final == true) ? true : null);
        // $nodes->speed = (($nodes->distance == true) && ($nodes->duration == true) ? true : null);
        // $nodes->cadence = ($this->multi_array_key_exists('cadence', $aux) ? true : null);
        // $nodes->heartrate = ($this->multi_array_key_exists('heartrate', $aux) ? true : null);
        // $nodes->temperature = ($this->multi_array_key_exists('temperature', $aux) ? true : null);
        // $nodes->calories = ($this->multi_array_key_exists('calories', $aux) ? true : null);
        // $nodes->elevation_gain = ($this->multi_array_key_exists('elevation', $aux) ? true : null);
        // $nodes->elevation_loss = (($nodes->elevation_gain == true) ? true : null);
        // $nodes->total_trackpoints = ($this->multi_array_key_exists('trkpt', $aux) ? true : null);

    }

    // public function getTypeGPX()
    // {
    //     return $this->gpx->getType();
    // }

    // public function getDateTimeGPX()
    // {
    //     return $this->gpx->getStartTime("Y-m-d H:i:s");
    // }

    // // Tempo total em horas
    // public function getTotalTimeGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getTotalDuration())->dividedBy('3600', 6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Distância total em kilometros
    // public function getDistanceGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getTotalDistance())->dividedBy('1000', 6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Média de velocidade
    // public function getAvgSpeedGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getAverageSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Velocidade Máxima
    // public function getMaxSpeedGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getMaxSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // public function getCaloriesGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getTotalCalories())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // public function getAvgHeartGPX()
    // {
    //     return null;
    // }

    // public function getMinHeartGPX()
    // {
    //     return null;
    // }

    // public function getMaxHeartGPX()
    // {
    //     return null;
    // }

    // public function getAvgTempGPX()
    // {
    //     return null;
    // }

    // public function getAvgCadenceGPX()
    // {
    //     return null;
    // }

    // public function getMinCadenceGPX()
    // {
    //     return null;
    // }

    // public function getMaxCadenceGPX()
    // {
    //     return null;
    // }

    // public function getLatitudeGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getGeographicInformation()['center']['lat'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    // }

    // public function getLongitudeGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getGeographicInformation()['center']['lng'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    // }

    // // Altura Mínima
    // public function getLowestGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getGeographicInformation()['lowest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // // Altura Máxima
    // public function getHighestGPX()
    // {
    //     return strval(BigDecimal::of($this->gpx->getGeographicInformation()['highest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // public function getElevationGainGPX()
    // {
    //     return strval(BigDecimal::of($this->aux->tracks[0]->stats->cumulativeElevationGain)->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }

    // public function getElevationLossGPX()
    // {
    //     return strval(BigDecimal::of($this->aux->tracks[0]->stats->cumulativeElevationLoss)->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    // }
}
