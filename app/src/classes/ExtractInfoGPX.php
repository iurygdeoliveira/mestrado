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

class ExtractInfoGPX
{

    use Date, Geotools;

    private $xml; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }

    public function getCreator()
    {

        $results = Regex::match('/creator="[.a-zA-Z ]+"/mius', $this->xml);

        if ($results) {

            if (count($results) >= 1) {
                $results = $results[0];
            }

            $search = array("creator=", '"');
            $replace   = array("", "");
            return str_replace($search, $replace, $results);
        } else {
            return null;
        }
    }

    public function getNodes()
    {

        $results = Regex::match('/<([a-z]|[0-9]|[A-Z]|:)+|lat|lon/mius', $this->xml);

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

        $results = Regex::match('/<time>[.0-9a-zA-Z:-]+</mius', $this->xml);

        if ($results) {

            if (count($results) >= 1) {
                $results = $results[0];
            }

            $search = array("<time>", "<");
            $replace   = array("", "");
            $value = str_replace($search, $replace, $results);
            return $this->date_fmt_unix($value);
        } else {
            return null;
        }
    }

    public function getLatitudes()
    {

        $results = Regex::match('/lat="[-.0-9]+"/mius', $this->xml);

        if ($results) {

            $search = array("lat=", '"');
            $replace   = array("", "");
            $latitudes = str_replace($search, $replace, $results);

            return [$latitudes[0], implode('|', $latitudes)];
        } else {
            return null;
        }
    }

    public function getLongitudes()
    {

        $results = Regex::match('/lon="[-.0-9]+"/mius', $this->xml);

        if ($results) {

            $search = array("lon=", '"');
            $replace   = array("", "");
            $longitudes = str_replace($search, $replace, $results);

            return [$longitudes[0], implode('|', $longitudes)];
        } else {
            return null;
        }
    }

    private function normalizeCoordinate(string $coordinate)
    {

        if (strlen($coordinate) > 14) {
            $aux = str_split($coordinate, 13);
            return $aux[0];
        }
        return $coordinate;
    }

    public function getAddressOSM(string $latitude, string $longitude)
    {

        $lat = $this->normalizeCoordinate($latitude);
        $lon = $this->normalizeCoordinate($longitude);

        return $this->addressFromOSM(floatval($lat), floatval($lon));
    }

    public function getAddressGoogle(string $latitude, string $longitude)
    {

        $lat = $this->normalizeCoordinate($latitude);
        $lon = $this->normalizeCoordinate($longitude);

        return $this->addressFromGoogle(floatval($lat), floatval($lon));
    }

    public function getAddressBing(string $latitude, string $longitude)
    {

        $lat = $this->normalizeCoordinate($latitude);
        $lon = $this->normalizeCoordinate($longitude);

        return $this->addressFromBing(floatval($lat), floatval($lon));
    }


    private function percentageAttribute(string $pattern, array $search, array $offset = [])
    {

        $results = Regex::match($pattern, $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) use ($search) {

                $replace_array = [];
                foreach ($search as $key => $value) {
                    array_push($replace_array, "");
                }

                return str_ireplace($search, $replace_array, $valor);
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

        $latitudes = $this->percentageAttribute('/lat="[-.0-9]+"/mius', ['lat="', '"']);
        $longitudes = $this->percentageAttribute('/lon="[-.0-9]+"/mius', ['lon="', '"']);

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

    public function getElevationGoogle(string $latitudes, string $longitudes)
    {

        $latitudes = explode('|', $latitudes);
        $longitudes = explode('|', $longitudes);

        return $this->elevationFromGoogle($latitudes, $longitudes);
    }

    public function getElevationBing(string $latitudes, string $longitudes)
    {

        $latitudes = explode('|', $latitudes);
        $longitudes = explode('|', $longitudes);

        return $this->elevationFromBing($latitudes, $longitudes);
    }

    public function getElevationFile()
    {

        $results = Regex::match('/<ele>[.0-9]+</mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<ele>", '<');
                $replace   = array("", "");
                return str_ireplace($search, $replace, $valor);
            };
            $elevations = array_map($replace, $results);

            // Transformando em string
            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };
            $elevations = array_reduce($elevations, $reduce);

            return $elevations;
        }

        return null;
    }

    public function getElevationPercentage(): string|null
    {
        return $this->percentageAttribute('/<ele>[.0-9]+</mius', ["<ele>", '<']);
    }

    public function getDuration()
    {
        $results = Regex::match('/<time>[.0-9a-zA-Z:-]+</mius', $this->xml);

        $duration = new stdClass();
        $duration->file = null; // Em arquivos GPX não existe registro de duração total

        if ($results) {

            $search = array("<time>", '<');
            $replace   = array("", "");

            $last = end($results);
            $last = str_replace($search, $replace, $last);

            $first = $results[0];
            $first = str_replace($search, $replace, $first);

            $duration->php = $this->date_difference($first, $last, '%h:%i:%s');
            return $duration;
        } else {
            $duration->php = null;
            return $duration;
        }
    }

    public function getTimePercentage()
    {
        return $this->percentageAttribute('/<time>[.0-9a-zA-Z:-]+</mius', ["<time>", '<'], [1]);
    }

    /**
     * Retorna a distância total em kilometros apartir das coordenadas de GPS
     *
     * @return stdClass $distance Distância em kilometros
     */
    public function getDistance(): stdClass
    {

        $distance = new stdClass();
        $distance->file = null; // Em arquivos GPX não existe registro de distância total

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

        $results = Regex::match('/(<gpxtpx:cad>[.0-9]+<)|(<ns3:cad>[.0-9]+<)/mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<gpxtpx:cad>", '<', "<ns3:cad>", "ns3:cad>");
                $replace   = array("", "", "", "");
                return str_ireplace($search, $replace, $valor);
            };
            $cadences = array_map($replace, $results);

            // Somando as distâncias
            $cadence->php = Decimal::avg($cadences)->toFixed(4);
            return $cadence;
        }

        return $cadence;
    }

    /**
     * Retorna a porcentagem de cadencia
     */
    public function getCadencePercentage()
    {
        return $this->percentageAttribute('/(<gpxtpx:cad>[.0-9]+<)|(<ns3:cad>[.0-9]+<)/mius', ["<gpxtpx:cad>", '<', "<ns3:cad>", "ns3:cad>"]);
    }

    /**
     * Retorna a Frequência Cardíaca
     */
    public function getHeartRate(): object
    {
        $heartrate = new stdClass();
        $heartrate->file = null; // Em arquivos GPX não existe registro de cadência total
        $heartrate->php = null;

        $results = Regex::match('/(<gpxtpx:hr>[.0-9]+<)|(<ns3:hr>[.0-9]+)/mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<gpxtpx:hr>", '<', "<ns3:hr>", "ns3:hr>");
                $replace   = array("", "", "", "");
                return str_ireplace($search, $replace, $valor);
            };
            $heartrates = array_map($replace, $results);

            // Média das frequências
            $heartrate->php = Decimal::avg($heartrates)->toFixed(4);
        }

        return $heartrate;
    }

    /**
     * Retorna a porcentagem da frequencia cardiaca
     */
    public function getHeartRatePercentage(): string|null
    {
        return $this->percentageAttribute('/(<gpxtpx:hr>[.0-9]+<)|(<ns3:hr>[.0-9]+)/mius', ["<gpxtpx:hr>", '<', "<ns3:hr>", "ns3:hr>"]);
    }

    /**
     * Retorna a Frequência Cardíaca
     */
    public function getTemperature(): object
    {
        $temperature = new stdClass();
        $temperature->file = null; // Em arquivos GPX não existe registro de temperatura total
        $temperature->php = null;

        $results = Regex::match('/(<gpxtpx:atemp>[.0-9]+<)|(<ns3:atemp>[.0-9]+<)/mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<gpxtpx:atemp>", "<ns3:atemp>", '<');
                $replace   = array("", "");
                return str_ireplace($search, $replace, $valor);
            };
            $temperatures = array_map($replace, $results);

            // Somando as distâncias
            $temperature->php = Decimal::avg($temperatures)->toFixed(4);
        }

        return $temperature;
    }

    /**
     * Retorna a porcentagem da Temperatura
     */
    public function getTemperaturePercentage(): string|null
    {
        return $this->percentageAttribute('/(<gpxtpx:atemp>[.0-9]+<)|(<ns3:atemp>[.0-9]+<)/mius', ["<gpxtpx:atemp>", "<ns3:atemp>", '<']);
    }

    /**
     * Nos arquivos GPX não existem Calories
     */
    public function getCalories(): object
    {
        $calories = new stdClass();
        $calories->file = null; // Em arquivos GPX não existe registro de Calorias total
        $calories->php = null;

        return $calories;
    }

    public function getCaloriesPercentage()
    {
        return null;
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
        $elevation->file = null; // Em arquivos GPX não existe registro de elevação total
        $elevation->without_threshold = null;
        $elevation->with_threshold = null;

        $results = Regex::match('/<ele>[.0-9]+</mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<ele>", '<');
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

    /**
     * Retorna o total de trackpoints
     */
    public function getTotalTrackpoints(): string|null
    {

        $results = Regex::match('/<trkpt/mius', $this->xml);

        if ($results) {
            return strval(count($results));
        } else {
            return null;
        }
    }
}
