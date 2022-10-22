<?php

declare(strict_types=1);

namespace src\classes;

use DateTime;
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

    private function countElements(string $pattern, array $search, array $offset = [])
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

            return $parcial;
        } else {
            return false;
        }
    }

    private function percentageAttribute(string $pattern, array $search, array $offset = [])
    {

        $results = Regex::match($pattern, $this->xml);

        if ($results) {

            $parcial = $this->countElements($pattern, $search, $offset);

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

    public function getPercentage(string $attribute)
    {

        $arrayAttribute = explode('|', $attribute);

        foreach ($arrayAttribute as $key => $value) {
            if (!is_numeric($value)) {
                unset($arrayAttribute[$key]);
            }
        }
        $parcial = strval(count($arrayAttribute));

        $total = $this->getTotalTrackpoints();

        if (!empty($total)) {
            $porcentagem = Math::porcentagem($parcial, $total);
            return strval($porcentagem) . '%';
        } else {
            return 'Erro no valor total de trackpoints';
        }
    }

    public function getTotalCoordinates()
    {

        $total_latitudes = $this->countElements('/lat="[-.0-9]+"/mius', ['lat="', '"']);
        $total_longitudes = $this->countElements('/lon="[-.0-9]+"/mius', ['lon="', '"']);

        $trackpoints = $this->getTotalTrackpoints();
        if ($total_latitudes == $total_longitudes) {
            return strval("true|Lat: $total_latitudes|Lon: $total_longitudes|Trackpoints: $trackpoints");
        } else {
            return strval("false|Lat: $total_latitudes|Lon: $total_longitudes|Trackpoints: $trackpoints");
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

    public function getElevationTotal(string $elevation)
    {

        $arrayElevation = explode('|', $elevation);

        foreach ($arrayElevation as $key => $value) {

            if (!is_numeric($value)) {
                unset($arrayElevation[$key]);
            }
        }
        $total_elevation = strval(count($arrayElevation));
        $trackpoints = $this->getTotalTrackpoints();
        if ($total_elevation == $trackpoints) {
            return strval("true|total: $total_elevation|Trackpoints: $trackpoints");
        } else {
            return strval("false|total: $total_elevation|Trackpoints: $trackpoints");
        }
    }

    public function getElevationAvg(string $elevation)
    {
        $arrayElevation = explode('|', $elevation);

        foreach ($arrayElevation as $key => $value) {

            if (!is_numeric($value)) {
                unset($arrayElevation[$key]);
            }
        }

        return Decimal::avg($arrayElevation)->toFixed(4) . " m";
    }

    public function getElevationPercentage(): string|null
    {
        return $this->percentageAttribute('/<ele>[.0-9]+</mius', ["<ele>", '<']);
    }

    public function getTimeTotal()
    {
        $results = Regex::match('/<time>[.0-9a-zA-Z:-]+</mius', $this->xml);

        if ($results) {

            $search = array("<time>", '<');
            $replace   = array("", "");

            $last = end($results);
            $last = str_replace($search, $replace, $last);

            $first = $results[0];
            $first = str_replace($search, $replace, $first);

            return $this->date_difference($first, $last, '%h:%i:%s');
        } else {

            return null;
        }
    }

    public function getTimeHistory()
    {
        $results = Regex::match('/<time>[.0-9a-zA-Z:-]+</mius', $this->xml);

        if ($results) {

            $search = array("<time>", '<');
            $replace   = array("", "");

            $times = str_replace($search, $replace, $results);

            $trackpoints = intval($this->getTotalTrackpoints());
            if (strval(count($times)) == ($trackpoints + 1)) {
                unset($times[0]);
            }

            foreach ($times as $key => $value) {
                $times[$key] = $this->date_fmt($value, 'H:i:s');
            }

            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };

            return array_reduce($times, $reduce);
        } else {
            return null;
        }
    }

    public function getTimePercentage()
    {
        return $this->percentageAttribute('/<time>[.0-9a-zA-Z:-]+</mius', ["<time>", '<'], [1]);
    }

    public function getTimeTrackpoint(string $timeHistory)
    {
        $timeArray = explode('|', $timeHistory);

        foreach ($timeArray as $key => $value) {

            if ($value == '') {
                unset($timeArray[$key]);
            }
        }

        $timeTrackpoint = [];
        array_push($timeTrackpoint, '0.00000000000000000000');
        for ($i = 1; $i < count($timeArray); $i++) {

            array_push(
                $timeTrackpoint,
                Math::sub(
                    Math::timeToHours($timeArray[$i]),
                    Math::timeToHours($timeArray[$i - 1]),
                    20
                )
            );
        }

        $reduce = function ($carry, $item) {
            $carry .= $item . '|';
            return $carry;
        };

        return array_reduce($timeTrackpoint, $reduce);
    }

    /**
     * Retorna a distância total em kilometros apartir das coordenadas de GPS
     *
     * @return stdClass $distance Distância em kilometros
     */
    public function getDistance(string $distances)
    {

        $distancesArray = explode('|', $distances);

        foreach ($distancesArray as $key => $value) {
            if (!is_numeric($value)) {
                unset($distancesArray[$key]);
            }
        }

        // Somando as distâncias
        return Decimal::sum($distancesArray)->toFixed(2) . " Km";
    }

    public function getDistanceHistory()
    {

        $latitudes = $this->getLatitudes();
        $longitudes = $this->getLongitudes();

        if (empty($latitudes) || empty($longitudes)) {

            return null;
        }

        $latitudes = explode('|', $latitudes[1]);
        $longitudes = explode('|', $longitudes[1]);

        if (count($latitudes) == count($longitudes)) {

            // Calculando distancia entre os pontos
            $distances = [];
            array_push($distances, '0.00');
            for ($i = 1; $i < count($latitudes); $i++) {

                array_push(
                    $distances,
                    Math::haversine(
                        $latitudes[$i - 1],
                        $longitudes[$i - 1],
                        $latitudes[$i],
                        $longitudes[$i]
                    )
                );
            }

            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };

            return array_reduce($distances, $reduce);
        }

        return null;
    }

    /**
     * Calcula a velocidade média em km/h
     *
     */
    public function getSpeedAVG(string $distance, string $time)
    {
        $aux = explode(" ", $distance);
        if (
            $aux[0] != null &&
            $aux[0] != '0.0000' &&
            $aux[0] != '0' &&
            $aux[0] != 0 &&
            $time != null &&
            $time != '0:0:0' &&
            $time != '0' &&
            $time != 0
        ) {

            $hours = Math::timeToHours($time);
            return Math::div($aux[0], $hours, 2) . " Km/h";
        } else {
            return null;
        }
    }

    public function getSpeedHistory(string $distance, string $time)
    {


        $distanceArray = explode('|', $distance);
        $timeArray = explode('|', $time);


        foreach ($distanceArray as $key => $value) {
            if ($value == '') {
                unset($distanceArray[$key]);
            }
        }

        foreach ($timeArray as $key => $value) {
            if ($value == '') {
                unset($timeArray[$key]);
            }
        }

        if (count($distanceArray) == count($timeArray)) {

            // Calculando distancia entre os pontos
            $speed = [];
            for ($i = 0; $i < count($distanceArray); $i++) {

                array_push(
                    $speed,
                    Math::div(
                        $distanceArray[$i],
                        $timeArray[$i],
                        20
                    )
                );
            }

            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };
            return array_reduce($speed, $reduce);
        } else {
            dp($timeArray);
            dp(end($distanceArray));
            dp(end($timeArray));
            dp(count($distanceArray));
            dpexit(count($timeArray));
            return null;
        }
    }


    public function getHeartRateAvg()
    {
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
            return Decimal::avg($heartrates)->toFixed(2) . " bpm";
        } else {
            return null;
        }
    }

    public function getHeartRateHistory()
    {
        $results = Regex::match('/(<gpxtpx:hr>[.0-9]+<)|(<ns3:hr>[.0-9]+)/mius', $this->xml);

        if ($results) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("<gpxtpx:hr>", '<', "<ns3:hr>", "ns3:hr>");
                $replace   = array("", "", "", "");
                return str_ireplace($search, $replace, $valor);
            };
            $heartrates = array_map($replace, $results);

            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };

            return array_reduce($heartrates, $reduce);
        } else {
            return null;
        }
    }

    public function getHeartRateTotal(string $heartrates)
    {

        $arrayheartrates = explode('|', $heartrates);

        foreach ($arrayheartrates as $key => $value) {

            if (!is_numeric($value)) {
                unset($arrayheartrates[$key]);
            }
        }
        $total_heartrates = strval(count($arrayheartrates));
        $trackpoints = $this->getTotalTrackpoints();
        if ($total_heartrates == $trackpoints) {
            return strval("true|total: $total_heartrates|Trackpoints: $trackpoints");
        } else {
            return strval("false|total: $total_heartrates|Trackpoints: $trackpoints");
        }
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
