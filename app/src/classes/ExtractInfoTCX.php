<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\Date;
use SimpleXMLElement;
use Waddle\Parsers\TCXParser;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

class ExtractInfoTCX
{

    use Date;

    private $tcxfile; //Estrutura que recebe o nome do dataset
    private $aux; // Estrutra auxiliar para armazenar dados durante o parseamento
    private $tcx; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(string $tcxfile)
    {
        $this->tcxfile = $tcxfile;
        $this->tcx = (new TCXParser())->parse($tcxfile);
        $this->aux = (new SimpleXMLElement(file_get_contents($tcxfile)));
    }

    public function analisando()
    {
        dump($this->tcx);
        dump(get_class_methods($this->tcx));
        dump($this->aux);
        dump(get_class_methods($this->aux));
    }


    public function getCreatorTCX()
    {
        return $this->aux->Author->Name->__toString();
    }

    public function getTypeTCX()
    {
        return $this->tcx->getType();
    }

    public function getDateTimeTCX()
    {
        return $this->tcx->getStartTime("Y-m-d H:i:s");
    }

    // Tempo total em horas
    public function getTotalTimeTCX()
    {
        return strval(BigDecimal::of($this->tcx->getTotalDuration())->dividedBy('3600', 6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Distância total em kilometros
    public function getDistanceTCX()
    {
        return strval(BigDecimal::of($this->tcx->getTotalDistance())->dividedBy('1000', 6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Média de velocidade
    public function getAvgSpeedTCX()
    {
        return strval(BigDecimal::of($this->tcx->getAverageSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Velocidade Máxima
    public function getMaxSpeedTCX()
    {
        return strval(BigDecimal::of($this->tcx->getMaxSpeedInKPH())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getCaloriesTCX()
    {
        return strval(BigDecimal::of($this->tcx->getTotalCalories())->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getAvgHeartTCX()
    {
        return null;
    }

    public function getMinHeartTCX()
    {
        return null;
    }

    public function getMaxHeartTCX()
    {
        return null;
    }

    public function getAvgTempTCX()
    {
        return null;
    }

    public function getAvgCadenceTCX()
    {
        return null;
    }

    public function getMinCadenceTCX()
    {
        return null;
    }

    public function getMaxCadenceTCX()
    {
        return null;
    }

    public function getLatitudeTCX()
    {
        return strval(BigDecimal::of($this->tcx->getGeographicInformation()['center']['lat'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    }

    public function getLongitudeTCX()
    {
        return strval(BigDecimal::of($this->tcx->getGeographicInformation()['center']['lng'])->toScale(9, RoundingMode::HALF_EVEN)->toFloat());
    }

    // Altura Mínima
    public function getLowestTCX()
    {
        return strval(BigDecimal::of($this->tcx->getGeographicInformation()['lowest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    // Altura Máxima
    public function getHighestTCX()
    {
        return strval(BigDecimal::of($this->tcx->getGeographicInformation()['highest'])->toScale(6, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function getElevationGainTCX()
    {
        return null;
    }

    public function getElevationLossTCX()
    {
        return null;
    }
}
