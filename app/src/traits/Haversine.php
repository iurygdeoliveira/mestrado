<?php

declare(strict_types=1);

namespace src\traits;

use DateTime;
use Decimal\Decimal;
use src\traits\Deg2rad;

trait Haversine
{
    use deg2rad;
    /**
     * Calculo da distância entre duas coordenadas de GPS utilizando a formula de Haversine com a extensão Decimal do PHP.
     * reference: http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe#PHP
     * @param string $lat1 Latitude Inicial [deg decimal]
     * @param string $lon1 Longitude Inicial [deg decimal]
     * @param string $lat2 Latitude Final [deg decimal]
     * @param string $lon2 Longitude Final [deg decimal]
     * @return string Distancia entre dois pontos [m] 
     */
    public function haversine(string $lat1, string $lat2, string $lon1, string $lon2): string
    {
        $radiusOfEarth = new Decimal(6371); // Earth's radius in kilometers.
        $lat_final = new Decimal($this->deg2rad($lat2));
        $lat_inicial = new Decimal($this->deg2rad($lat1));
        $lon_inicial = new Decimal($this->deg2rad($lon1));
        $lon_final = new Decimal($this->deg2rad($lon2));

        // Depuração dos valores
        // $inicial = [
        //     'lat_inicial' => $lat1,
        //     'lon_inicial' => $lon1,
        //     'lat_final' => $lat2,
        //     'lon_final' => $lon2,
        // ];
        // bardump($inicial, 'inicial');

        // $floatval = [
        //     'lat_inicial' => floatval($lat1),
        //     'lon_inicial' => floatval($lon1),
        //     'lat_final' => floatval($lat2),
        //     'lon_final' => floatval($lon2),
        // ];
        // bardump($floatval, 'floatval');

        // $deg2rad = [
        //     'lat_inicial' => deg2rad(floatval($lat1)),
        //     'lon_inicial' => deg2rad(floatval($lon1)),
        //     'lat_final' => deg2rad(floatval($lat2)),
        //     'lon_final' => deg2rad(floatval($lon2)),
        // ];
        // bardump($deg2rad, 'deg2rad');

        // $decimal = [
        //     'lat_inicial' => $lat_inicial->__toString(),
        //     'lon_inicial' => $lat_final->__toString(),
        //     'lat_final' => $lon_inicial->__toString(),
        //     'lon_final' => $lon_final->__toString(),
        // ];
        // bardump($decimal, 'decimal');

        $diffLatitude = $lat_final->sub($lat_inicial);
        $diffLongitude = $lon_final->sub($lon_inicial);

        $term1 = (new Decimal(strval(sin($diffLatitude->div(2)->toFloat()))))->pow(2);
        $term2 = (new Decimal(strval(cos($lat_inicial->toFloat()))));
        $term3 = (new Decimal(strval(cos($lat_final->toFloat()))));
        $term4 = (new Decimal(strval(sin($diffLongitude->div(2)->toFloat()))))->pow(2);

        $a = $term2->mul($term3)->mul($term4);
        $a = $term1->add($a);

        $term5 = (new Decimal(strval(asin($a->sqrt()->toFloat()))))->mul(2);
        $distance = $radiusOfEarth->mul($term5)->__toString();

        return $distance;
    }
}
