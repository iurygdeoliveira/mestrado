<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\Date;
use src\traits\Geotools;
use src\classes\Regex;
use src\classes\Math;
use Decimal\Decimal;
use stdClass;
use League\Geotools\Polygon\Polygon;
use League\Geotools\Coordinate\Coordinate;

class ExtractInfoTCX
{

    use Date, Geotools;

    private $xml; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }

    public function getCreator()
    {

        $results = Regex::match('/<Name>[0-9a-zA-Z ]+</mius', $this->xml);

        if ($results) {

            if (count($results) >= 1) {
                $results = $results[0];
            }

            $search = array("<Name>", '<');
            $replace   = array("", "");
            return str_replace($search, $replace, $results);
        } else {
            return null;
        }
    }

    public function getNodes()
    {

        $results = Regex::match('/<([a-z]|[0-9]|[A-Z]|:)+/mius', $this->xml);

        $nodes = array_unique($results, SORT_REGULAR);

        $replace = function ($valor) {
            return str_ireplace('<', '', $valor);
        };
        $nodes = array_map($replace, $nodes);

        $reduce = function ($carry, $item) {
            $carry .= $item . '|';
            return $carry;
        };

        $nodes = array_reduce($nodes, $reduce);

        return $nodes;
    }

    public function getDateTime()
    {

        $results = Regex::match('/<Id>[.0-9a-zA-Z:-]+</mius', $this->xml);

        if ($results) {

            if (count($results) >= 1) {
                $results = $results[0];
            }

            $search = array("<Id>", "<");
            $replace   = array("", "");
            $value = str_replace($search, $replace, $results);
            return $this->date_fmt_unix($value);
        } else {
            return null;
        }
    }

    public function getLatitudes()
    {

        $results = Regex::match('/<LatitudeDegrees>[-.0-9]+</mius', $this->xml);

        if ($results) {

            $search = array("<LatitudeDegrees>", '<');
            $replace   = array("", "");
            $latitudes = str_replace($search, $replace, $results);

            return [$latitudes[0], implode('|', $latitudes)];
        } else {
            return null;
        }
    }

    public function getLongitudes()
    {

        $results = Regex::match('/<LongitudeDegrees>[-.0-9]+</mius', $this->xml);

        if ($results) {

            $search = array("<LongitudeDegrees>", '<');
            $replace   = array("", "");
            $longitudes = str_replace($search, $replace, $results);

            return [$longitudes[0], implode('|', $longitudes)];
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

        return $this->addressFromGeoTools(floatval($lat), floatval($lon));
    }

    private function percentageAttribute(string $pattern, array $search, array $offset = [])
    {

        $results = Regex::match($pattern, $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) use ($search) {
                $replace   = array("", "");
                return str_ireplace($search, $replace, $valor);
            };
            $attributes = array_map($replace, $results);

            // Eliminando resultados que não devem ser considerados
            if (!empty($offset)) {
                foreach ($offset as $key => $value) {
                    unset($attributes[$value]);
                }
            }

            $parcial = 0;
            foreach ($attributes as $key => $value) {

                $value = (empty($value) ? false : true);
                if ($value) {
                    $parcial += 1;
                }
            }

            $total = $this->getTotalTrackpoints();

            if (!empty($total)) {
                $porcentagem = Math::porcentagem($parcial, $total);
                return strval($porcentagem) . '%';
            } else {
                return 'Erro no valor total de trackpoints';
            }
        }
    }

    public function getCoordinatesPercentage()
    {

        $latitudes = $this->percentageAttribute('/<LatitudeDegrees>[-.0-9]+</mius', ["<latitudeDegrees>", '<']);
        $longitudes = $this->percentageAttribute('/<LongitudeDegrees>[-.0-9]+</mius', ["<LongitudeDegrees>", '<']);

        if ($latitudes == '100.00%' && $longitudes == '100.00%') {
            return '100%';
        } else {
            return 'latitude: ' . $latitudes . ' and longitude: ' . $longitudes;
        }
    }

    public function getBbox(string $latitudes, string $longitudes)
    {
        // Convertendo string para array
        $latitudes = explode('|', $latitudes);
        $longitudes = explode('|', $longitudes);

        // Convertendo valores para float
        $convert = function ($valor) {
            return floatval($valor);
        };
        $latitudes = array_map($convert, $latitudes);
        $longitudes = array_map($convert, $longitudes);

        // Montando Poligono
        if (count($latitudes) == count($longitudes)) {
            $coordinates = [];
            foreach ($latitudes as $key => $latitude) {
                array_push($coordinates, new Coordinate([$latitude, $longitudes[$key]]));
            }

            $polygon = new Polygon($coordinates);
            $east = $polygon->getBoundingBox()->getEast();
            $north = $polygon->getBoundingBox()->getNorth();
            $west = $polygon->getBoundingBox()->getWest();
            $south = $polygon->getBoundingBox()->getSouth();
            return 'north ' . $north . '|south ' . $south . '|east ' . $east . '|west ' . $west;
        } else {
            return null;
        }
    }

    public function getDuration()
    {

        $results = Regex::match('/<TotalTimeSeconds>[.0-9]+</mius', $this->xml);
        $duration = new stdClass();

        if ($results) {

            $search = array("<TotalTimeSeconds>", '<');
            $replace   = array("", "");

            $totalTimeSeconds = str_replace($search, $replace, $results[0]);
            $duration->file = Math::secondsToTime(intval($totalTimeSeconds));
        } else {
            $duration->file = null;
        }

        $results = Regex::match('/<time>[.0-9a-zA-Z:-]+</mius', $this->xml);

        if ($results) {

            $search = array("<time>", "<Time>", '<');
            $replace   = array("", "", "");

            $last = end($results);
            $last = str_replace($search, $replace, $last);

            $first = $results[0];
            $first = str_replace($search, $replace, $first);

            $duration->php = $this->date_difference($first, $last, '%h:%i:%s');
            return $duration;
        }

        $duration->file = null;
        $duration->php = null;
        return $duration;
    }

    public function getTimePercentage()
    {
        return $this->percentageAttribute('/<time>[.0-9a-zA-Z:-]+</mius', ["<time>", "<Time>", '<']);
    }

    /**
     * Retorna a distância total em kilometros apartir das coordenadas de GPS
     *
     * @return object $distance Distância em kilometros
     */
    public function getDistance(): object
    {

        $results = Regex::match('/<DistanceMeters>[.0-9]+</mus', $this->xml);

        $distance = new stdClass();
        $distance->file = null;

        if ($results) {

            $search = array("<DistanceMeters>", '<');
            $replace   = array("", "");

            $totalDistance = new Decimal(str_replace($search, $replace, $results[0]));
            $distance->file = $totalDistance->div(1000)->toFixed(4);
        }

        $latitudes = $this->getLatitudes();
        $longitudes = $this->getLongitudes();

        if (empty($latitudes) || empty($longitudes)) {

            $distance->php = null;
            return $distance;
        }

        $latitudes = explode('|', $latitudes[1]);
        $longitudes = explode('|', $longitudes[1]);

        if (count($latitudes) == count($longitudes)) {

            // Calculando distancia entre os pontos
            $distances = [];
            for ($i = 0; $i < count($latitudes) - 1; $i++) {

                array_push($distances, Math::haversine($latitudes[$i], $longitudes[$i], $latitudes[$i + 1], $longitudes[$i + 1]));
            }

            // Somando as distâncias
            $distance->php = Decimal::sum($distances)->toFixed(4);
            return $distance;
        }

        $distance->php = null;
        return $distance;
    }

    /**
     * Calcula a velocidade média em km/h
     *
     * @param stdClass $distance distância em kilometros
     * @param stdClass $duration tempo em horas:minutos:segundos
     * @return stdClass Velocidade média em km/h
     *
     */
    public function getSpeed(stdClass $distance, stdClass $duration): stdClass
    {
        $speed = new stdClass();
        $speed->file = null;
        $speed->php = null;

        if (
            $distance->php != null &&
            $distance->php != '0.0000' &&
            $distance->php != '0' &&
            $distance->php != 0 &&
            $duration->php != null &&
            $duration->php != '0:0:0' &&
            $duration->php != '0' &&
            $duration->php != 0
        ) {

            $hours = Math::timeToHours($duration->php);
            $speed->php = Math::div($distance->php, $hours, 4);
        }

        if (
            $distance->file != null &&
            $distance->file != '0.0000' &&
            $distance->file != '0' &&
            $distance->file != 0 &&
            $duration->file != null &&
            $duration->file != '0:0:0' &&
            $duration->file != '0' &&
            $duration->file != 0
        ) {

            $hours = Math::timeToHours($duration->file);
            $speed->file = Math::div($distance->file, $hours, 4);
        }

        return $speed;
    }

    /**
     * Retorna a cadência
     */
    public function getCadence(): stdClass
    {

        $cadence = new stdClass();
        $cadence->file = null; // Em arquivos GPX não existe registro de cadência total
        $cadence->php = null;

        $results = Regex::match('/Intensity>\n[ ]+<Cadence>[.0-9]+</mius', $this->xml);

        if ($results) {

            $search = array('Intensity>', '\n', "<Cadence>", '<');
            $replace   = array("", "", "", "");

            $cadence->file = trim(str_replace($search, $replace, $results[0]));
        }

        $results = Regex::match('/<Cadence>[.0-9]+</mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<Cadence>", '<');
                $replace   = array("", "");
                return str_ireplace($search, $replace, $valor);
            };
            $cadences = array_map($replace, $results);
            unset($cadences[0]); // Eliminando o primeiro valor pois é o AVG

            $cadence->php = Decimal::avg($cadences)->toFixed(4);
        }

        return $cadence;
    }

    /**
     * Retorna a porcentagem de cadencia
     */
    public function getCadencePercentage()
    {
        return $this->percentageAttribute('/<Cadence>[.0-9]+</mius', ["<Cadence>", '<'], [1]);
    }

    /**
     * Retorna a frequência cardíaca
     */
    public function getHeartRate(): object
    {

        $heartrate = new stdClass();
        $heartrate->file = null;
        $heartrate->php = null;

        $results = Regex::match('/<AverageHeartRateBpm>\n[ ]+<Value>[.0-9]+</mius', $this->xml);

        if ($results) {

            $search = array('<AverageHeartRateBpm>', '\n', "<Value>", '<',);
            $replace   = array("", "", "", "");

            $heartrate->file = trim(str_replace($search, $replace, $results[0]));
        }

        $results = Regex::match('/<HeartRateBpm>\n[ ]+<Value>[.0-9]+</mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<HeartRateBpm>", '\n', "<Value>", '<');
                $replace   = array("", "", "", "");
                return trim(str_ireplace($search, $replace, $valor));
            };
            $heartrates = array_map($replace, $results);

            // Somando as distâncias
            $heartrate->php = Decimal::avg($heartrates)->toFixed(4);
        }

        return $heartrate;
    }

    /**
     * Retorna a acurácia da frequencia cardica
     */
    public function getHeartRatePercentage()
    {
        return $this->percentageAttribute('/<HeartRateBpm>\n[ ]+<Value>[.0-9]+</mius', ["<HeartRateBpm>", '\n', "<Value>", '<']);
    }


    /**
     * Nos arquivos TCX não existem temperatures
     */
    public function getTemperature(): object
    {
        $temperature = new stdClass();
        $temperature->file = null;
        $temperature->php = null;
        return $temperature;
    }

    public function getTemperaturePercentage()
    {
        return null;
    }

    /**
     * Retorna o total de calorias
     */
    public function getCalories(): object
    {
        $calories = new stdClass();
        $calories->file = null;
        $calories->php = null; // Em arquivos TCX não existe registro de calorieas por trackpoint

        $results = Regex::match('/<Calories>[.0-9]+</mius', $this->xml);

        if ($results) {

            $search = array('<Calories>', '<',);
            $replace   = array("", "");

            $calories->file = trim(str_replace($search, $replace, $results[0]));
        }

        return $calories;
    }

    public function getCaloriesPercentage()
    {
        return 'Sem registro por trackpoint, apenas registro de calorias totais';
    }

    public function get_with_threshold(array $elevations)
    {
        return null;
    }

    public function get_without_threshold(array $elevations)
    {

        $gain = [];
        $loss = [];
        for ($i = 0; $i < count($elevations) - 1; $i++) {

            $result = floatval(Math::sub($elevations[$i + 1], $elevations[$i], 4));
            if ($result > 0) {
                array_push($gain, strval($result));
            } else {
                array_push($loss, strval($result));
            }
        }

        $gain_sum = Decimal::sum($gain)->toFixed(4);
        $loss_sum = Decimal::sum($loss)->toFixed(4);

        return Math::add($gain_sum, $loss_sum, 4);
    }

    /**
     * Retorna altitude
     *
     * @return object $distance Altitude em metros
     */
    public function getAltitude(): object
    {
        $elevation = new stdClass();
        $elevation->file = null; // Em arquivos TCX não existe registro de elevação total
        $elevation->without_threshold = null;
        $elevation->with_threshold = null;

        $results = Regex::match('/<AltitudeMeters>[.0-9]+</mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<AltitudeMeters>", '<');
                $replace   = array("", "");
                return str_ireplace($search, $replace, $valor);
            };
            $elevations = array_map($replace, $results);

            // Somando as distâncias
            $elevation->without_threshold = $this->get_without_threshold($elevations);
            $elevation->with_threshold = $this->get_with_threshold($elevations);
        }

        return $elevation;
    }

    public function getAltitudePercentage(): string|null
    {
        return $this->percentageAttribute('/<AltitudeMeters>[.0-9]+</mius', ["<AltitudeMeters>", '<']);
    }

    /**
     * Retorna o total de trackpoints
     */
    public function getTotalTrackpoints(): string|null
    {

        $results = Regex::match('/<Trackpoint/mius', $this->xml);

        if ($results) {

            return strval(count($results));
        } else {
            return null;
        }
    }
}
