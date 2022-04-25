<?php

declare(strict_types=1);

namespace src\classes;

use Decimal\Decimal;
use src\traits\Date;
use src\traits\Haversine;

class ExtractInfoTCX
{

    use Date, Haversine;

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
}
