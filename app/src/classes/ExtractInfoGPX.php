<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\Date;
use phpGPX\phpGPX;
use SimpleXMLElement;
use Waddle\Parsers\GPXParser;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

class ExtractInfoGPX
{

    use Date;

    private $gpxfile; //Estrutura que recebe o nome do dataset
    private $aux; // Estrutra auxiliar para armazenar dados durante o parseamento
    private $gpx; // Armazena os dados durante o parseamento de arquivos gpx
    private $tcx; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(string $gpxfile)
    {
        $this->gpxfile = $gpxfile;
        $this->aux = (new phpGPX())->load($gpxfile);
        $this->gpx = (new GPXParser())->parse($gpxfile);
    }

    public function analisando()
    {
        dump($this->aux);
        exit;
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

    // Tempo total em horas
    public function getTotalTimeGPX()
    {
        return strval(BigDecimal::of($this->gpx->getTotalDuration())->dividedBy('3600', 6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Distância total em kilometros
    public function getDistanceGPX()
    {
        return strval(BigDecimal::of($this->gpx->getTotalDistance())->dividedBy('1000', 6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Média de velocidade
    public function getAvgSpeedGPX()
    {
        return strval(BigDecimal::of($this->gpx->getAverageSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Velocidade Máxima
    public function getMaxSpeedGPX()
    {
        return strval(BigDecimal::of($this->gpx->getMaxSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getCaloriesGPX()
    {
        return strval(BigDecimal::of($this->gpx->getTotalCalories())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
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
        return strval(BigDecimal::of($this->gpx->getGeographicInformation()['center']['lat'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    }

    public function getLongitudeGPX()
    {
        return strval(BigDecimal::of($this->gpx->getGeographicInformation()['center']['lng'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    }

    // Altura Mínima
    public function getLowestGPX()
    {
        return strval(BigDecimal::of($this->gpx->getGeographicInformation()['lowest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Altura Máxima
    public function getHighestGPX()
    {
        return strval(BigDecimal::of($this->gpx->getGeographicInformation()['highest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getElevationGainGPX()
    {
        return strval(BigDecimal::of($this->aux->tracks[0]->stats->cumulativeElevationGain)->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getElevationLossGPX()
    {
        return strval(BigDecimal::of($this->aux->tracks[0]->stats->cumulativeElevationLoss)->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }
}
