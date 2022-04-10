<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\Date;
use SimpleXMLElement;
use Decimal\Decimal;
use Faker\Core\File;
use stdClass;
use SplStack;

class ExtractInfo
{

    use Date;

    private $xml; //Estrutura que recebe o nome do dataset

    public function __construct(string $file)
    {

        // Pré-processando o arquivo XML
        $search = array('gpxtpx:TrackPointExtension', 'gpxtpx:atemp', 'gpxtpx:hr', 'gpxtpx:cad', 'ele', 'ns3:TrackPointExtension', 'ns3:atemp', 'ns3:hr', 'ns3:cad', 'ns3:ele');
        $replace = array('TrackPoint', 'temperature', 'heartrate', 'cadence', 'elevation', 'TrackPoint', 'temperature', 'heartrate', 'cadence', 'elevation');
        $xml_string = str_replace($search, $replace, file_get_contents($file));

        // Transformando o xml em objeto para manipulação
        $this->xml = (new SimpleXMLElement($xml_string));
    }

    private function xml2obj(SimpleXMLElement $xml, $force = false)
    {

        $obj = new StdClass();

        $obj->name = $xml->getName();

        $text = trim((string)$xml);
        $attributes = array();
        $children = array();

        foreach ($xml->attributes() as $k => $v) {
            $attributes[$k]  = (string)$v;
        }

        foreach ($xml->children() as $k => $v) {
            $children[] = $this->xml2obj($v, $force);
        }


        if ($force or $text !== '')
            $obj->text = $text;

        if ($force or count($attributes) > 0)
            $obj->attributes = $attributes;

        if ($force or count($children) > 0)
            $obj->children = $children;


        return $obj;
    }

    public function extractNodes($obj)
    {

        $nodes = array();

        if (isset($obj->name)) {
            $nodes[] = $obj->name;
        }

        if (isset($obj->attributes)) {
            $nodes[] = 'attributes';
        }

        if (isset($obj->children)) {

            foreach ($obj->children as $key => $value) {
                $nodes = array_merge($nodes, $this->extractNodes($value));
            }
        }

        return $nodes;
    }


    public function getCreator()
    {
        dump($this->xml);
        return true;
    }

    // public function getNodes()
    // {
    //     $xml2obj = $this->xml2obj($this->xml);

    //     return array_unique($this->extractNodes($xml2obj));
    // }


    public function getTypeGPX()
    {
        return $this->gpx->getType();
    }

    public function getDateTimeGPX()
    {
        return $this->gpx->getStartTime("Y-m-d H:i:s");
    }

    // Tempo total em horas
    public function getTotalTimeGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getTotalDuration())->dividedBy('3600', 6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Distância total em kilometros
    public function getDistanceGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getTotalDistance())->dividedBy('1000', 6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Média de velocidade
    public function getAvgSpeedGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getAverageSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Velocidade Máxima
    public function getMaxSpeedGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getMaxSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getCaloriesGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getTotalCalories())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getAvgHeartGPX()
    {
        return null;
    }

    public function getMinHeartGPX()
    {
        return null;
    }

    public function getMaxHeartGPX()
    {
        return null;
    }

    public function getAvgTempGPX()
    {
        return null;
    }

    public function getAvgCadenceGPX()
    {
        return null;
    }

    public function getMinCadenceGPX()
    {
        return null;
    }

    public function getMaxCadenceGPX()
    {
        return null;
    }

    public function getLatitudeGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getGeographicInformation()['center']['lat'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    }

    public function getLongitudeGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getGeographicInformation()['center']['lng'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    }

    // Altura Mínima
    public function getLowestGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getGeographicInformation()['lowest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Altura Máxima
    public function getHighestGPX()
    {
        // return strval(BigDecimal::of($this->gpx->getGeographicInformation()['highest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getElevationGainGPX()
    {
        // return strval(BigDecimal::of($this->aux->tracks[0]->stats->cumulativeElevationGain)->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getElevationLossGPX()
    {
        // return strval(BigDecimal::of($this->aux->tracks[0]->stats->cumulativeElevationLoss)->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }
}
