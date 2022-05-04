<?php

declare(strict_types=1);

namespace src\classes;

use Decimal\Decimal;
use src\traits\Date;
use src\traits\Haversine;
use src\traits\Geotools;
use Exception;

class ExtractInfoTCX
{

    use Date, Haversine, Geotools;

    private $xml; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }


    public function getNodes()
    {

        $nodes = array();

        preg_match_all("/<([a-z]|[0-9]|[A-Z]|:)+/mius", $this->xml, $nodes);
        $nodes = array_unique($nodes[0], SORT_REGULAR);

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
    }

    public function getCreator()
    {

        $values = '';

        preg_match('/<Name>[0-9a-zA-Z ]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<Name>", '<');
            $replace   = array("", "");
            return str_replace($search, $replace, $values[0]);
        } else {
            return null;
        }
    }

    public function getDateTime()
    {
        $values = '';

        preg_match('/<Id>[.0-9a-zA-Z:-]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<Id>", '<');
            $replace   = array("", "");
            $aux = str_replace($search, $replace, $values[0]);
            return $this->date_fmt_unix($aux);
        } else {
            return null;
        }
    }

    public function getLatitudeFirstEnd()
    {
        $values = '';

        preg_match_all('/<LatitudeDegrees>[-.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<LatitudeDegrees>", '<');
            $replace   = array("", "");

            $last = end($values[0]);
            $last = str_replace($search, $replace, $last);

            $first = $values[0][0];
            $first = str_replace($search, $replace, $first);

            return [$first, $last];
        } else {
            return null;
        }
    }

    public function getLongitudeFirstEnd()
    {
        $values = '';

        preg_match_all('/<LongitudeDegrees>[-.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<LongitudeDegrees>", '<');
            $replace   = array("", "");

            $last = end($values[0]);
            $last = str_replace($search, $replace, $last);

            $first = $values[0][0];
            $first = str_replace($search, $replace, $first);

            return [$first, $last];
        } else {
            return null;
        }
    }

    public function getAddress(string $lat, string $lon)
    {

        if (strlen($lat) > 14) {
            $aux = str_split($lat, 13);
            $lat = $aux[0];
        }

        if (strlen($lon) > 14) {
            $aux = str_split($lon, 13);
            $lon = $aux[0];
        }

        $address = $this->getAddressFromGPS(floatval($lat), floatval($lon));

        if ($address instanceof Exception) {
            return ['Erro ao obter país', 'Erro ao obter cidade', 'Erro ao obter estrada'];
        }

        if ($address == false) {
            return [null, null, null];
        }

        if (!empty($address) && isset($address['municipality'])) {
            $country = (isset($address['country']) ? $address['country'] : null);
            $city = (isset($address['municipality']) ? $address['municipality'] : null);
            $road = (isset($address['road']) ? $address['road'] : null);
            return [$country, $city, $road];
        }

        if (!empty($address) && isset($address['town'])) {
            $country = (isset($address['country']) ? $address['country'] : null);
            $city = (isset($address['town']) ? $address['town'] : null);
            $road = (isset($address['road']) ? $address['road'] : null);
            return [$country, $city, $road];
        }

        return null;
    }

    public function getDuration()
    {
        $values = '';

        preg_match('/<TotalTimeSeconds>[.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<TotalTimeSeconds>", '<');
            $replace   = array("", "");

            $totalTimeSeconds = new Decimal(str_replace($search, $replace, $values[0]));
            $hours = $totalTimeSeconds->div(3600)->floor()->__toString();
            $minutes = $totalTimeSeconds->div(60)->mod(60)->floor()->__toString();
            $seconds = $totalTimeSeconds->mod(60)->__toString();
            return "$hours:$minutes:$seconds";
        }

        $values = '';
        preg_match_all('/<Time>[.0-9a-zA-Z:-]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<Time>", '<');
            $replace   = array("", "");

            $last = end($values[0]);
            $last = str_replace($search, $replace, $last);

            $first = $values[0][0];
            $first = str_replace($search, $replace, $first);

            return $this->date_difference($first, $last, '%h:%i:%s');
        }

        return null;
    }

    /**
     * Retorna a distância total em kilometros apartir das coordenadas de GPS
     *
     * @return string|null $distance Distância em kilometros
     */
    public function getDistance(): string|null
    {

        $values = '';

        preg_match('/<DistanceMeters>[.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<DistanceMeters>", '<');
            $replace   = array("", "");

            $totalDistance = new Decimal(str_replace($search, $replace, $values[0]));
            return $totalDistance->div(1000)->toFixed(4);
        }

        // Extraindo longitude latitude
        preg_match_all('/<LatitudeDegrees>[-.0-9]+</mius', $this->xml, $latitudes);
        preg_match_all('/<LongitudeDegrees>[-.0-9]+</mius', $this->xml, $longitudes);

        if ((isset($latitudes[0]) && !empty($latitudes[0])) && (isset($longitudes[0]) && !empty($longitudes[0]))) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<LatitudeDegrees>", '<LongitudeDegrees>', "<");
                $replace   = array("", "", "");
                return str_ireplace($search, $replace, $valor);
            };
            $latitudes = array_map($replace, $latitudes[0]);
            $longitudes = array_map($replace, $longitudes[0]);

            // Calculando distancia entre os pontos
            $distances = [];
            for ($i = 0; $i < count($latitudes) - 1; $i++) {

                array_push($distances, $this->haversine($latitudes[$i], $latitudes[$i + 1], $longitudes[$i], $longitudes[$i + 1]));
            }

            // Somando as distâncias
            return Decimal::sum($distances)->toFixed(4);
        }

        return null;
    }

    /**
     * Calcula a velocidade média em km/h
     *
     * @param string $distance distância em kilometros
     * @param string $duration tempo em horas:minutos:segundos
     * @return string|null
     */
    public function getSpeed(string $distance, string $duration): string|null
    {
        if (!empty($distance) && !empty($duration)) {

            $distance = new Decimal($distance);
            $duration = explode(':', $duration);

            $hours = new Decimal($duration[0]);
            $minutes = new Decimal($duration[1]);
            $seconds = new Decimal($duration[2]);

            $hours = $hours->add($minutes->div(60));
            $hours = $hours->add($seconds->div(3600));

            return $distance->div($hours)->toFixed(4);
        } else {
            return null;
        }
    }

    /**
     * Retorna a cadência
     */
    public function getCadence(): string|null
    {

        $values = '';

        preg_match('/<Intensity>\n[ ]+<Cadence>[.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array('<Intensity>', '\n', "<Cadence>", '<');
            $replace   = array("", "", "", "");

            return trim(str_replace($search, $replace, $values[0]));
        }

        $values = '';

        // Extraindo longitude latitude
        preg_match_all('/<Cadence>[.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<Cadence>", '<');
                $replace   = array("", "");
                return str_ireplace($search, $replace, $valor);
            };
            $cadences = array_map($replace, $values[0]);
            unset($cadences[0]); // Eliminando o primeiro valor pois é o AVG

            // Somando as distâncias
            return Decimal::avg($cadences)->toFixed(4);
        }

        return null;
    }

    /**
     * Retorna a frequência cardíaca
     */
    public function getHeartRate(): string|null
    {

        $values = '';

        preg_match('/<AverageHeartRateBpm>\n[ ]+<Value>[.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array('<AverageHeartRateBpm>', '\n', "<Value>", '<',);
            $replace   = array("", "", "", "");

            return trim(str_replace($search, $replace, $values[0]));
        }

        $values = '';

        // Extraindo longitude latitude
        preg_match_all('/<HeartRateBpm>\n[ ]+<Value>[.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<HeartRateBpm>", '\n', "<Value>", '<');
                $replace   = array("", "", "", "");
                return trim(str_ireplace($search, $replace, $valor));
            };
            $heartrates = array_map($replace, $values[0]);

            // Somando as distâncias
            return Decimal::avg($heartrates)->toFixed(4);
        }

        return null;
    }

    /**
     * Nos arquivos TCX não existem temperatures
     */
    public function getTemperature(): string|null
    {
        return null;
    }

    /**
     * Retorna o total de calorias
     */
    public function getCalories(): string|null
    {
        $values = '';

        preg_match('/<Calories>[.0-9]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array('<Calories>', '<',);
            $replace   = array("", "");

            return trim(str_replace($search, $replace, $values[0]));
        } else {
            return null;
        }
    }

    /**
     * Retorna o total de trackpoints
     */
    public function getTotalTrackpoints(): string|null
    {
        $values = '';

        // Extraindo longitude latitude
        preg_match_all('/<Trackpoint/mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            // Somando as distâncias
            return strval(count($values[0]));
        } else {
            return null;
        }
    }
}
