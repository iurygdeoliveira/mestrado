<?php

declare(strict_types=1);

namespace src\classes;


use src\traits\responseJson;
use src\classes\Regex;
use src\models\rideBD;


class Distance
{

    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    use responseJson;

    public function __construct(string $rider)
    {
        // Obtendo id do ciclista
        $id = Regex::match('/\d{1,2}/mius', $rider);
        $this->ride = (new rideBD())->bootstrap($id[0]);
    }


    public function maxDistance()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $distances = [];
        foreach ($this->ride->getDistances() as $key => $value) {
            $number = floatval($value->data()->distance_haversine);
            array_push($distances, number_format($number, 2, '.', ''));
        }

        $distance = max($distances);

        set_time_limit(30);
        return $distance;
    }

    public function distances()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $distances = [];
        foreach ($this->ride->getDistances() as $key => $value) {
            array_push($distances, $value->data());
        }

        set_time_limit(30);
        return $distances;
    }
}
