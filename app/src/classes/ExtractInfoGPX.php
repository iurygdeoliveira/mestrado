<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\Date;
use src\traits\Haversine;
use Decimal\Decimal;

class ExtractInfoGPX
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
        $aux = array();

        preg_match_all("/<([a-z]|[0-9]|[A-Z]|:)+/mius", $this->xml, $nodes);
        $nodes = array_unique($nodes[0], SORT_REGULAR);

        preg_match_all("/lat|lon/mius", $this->xml, $aux);
        $aux = array_unique($aux[0], SORT_REGULAR);

        $nodes = array_merge($nodes, $aux);

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

        preg_match_all('/creator="[a-zA-Z ]+"/mius', $this->xml, $values);

        if (isset($values[0][0]) && !empty($values[0][0])) {

            $search = array("creator=", '"');
            $replace   = array("", "");
            return str_replace($search, $replace, $values[0][0]);
        } else {
            return null;
        }
    }

    public function getDateTime()
    {
        $values = '';

        preg_match('/<time>[.0-9a-zA-Z:-]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<time>", '<');
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
        preg_match_all('/lat="[-.0-9]+"/mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("lat=", '"');
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

        preg_match_all('/lon="[-.0-9]+"/mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("lon=", '"');
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

        preg_match_all('/<time>[.0-9a-zA-Z:-]+</mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            $search = array("<time>", '<');
            $replace   = array("", "");

            $last = end($values[0]);
            $last = str_replace($search, $replace, $last);

            $first = $values[0][1];
            $first = str_replace($search, $replace, $first);

            return $this->date_difference($first, $last, '%h:%i:%s');
        } else {
            return null;
        }
    }

    /**
     * Retorna a distância total em kilometros apartir das coordenadas de GPS
     *
     * @return string|null $distance Distância em kilometros
     */
    public function getDistance(): string|null
    {

        $values = '';

        // Extraindo longitude latitude
        preg_match_all('/lat="[-.0-9]+" lon="[-.0-9]+"/mius', $this->xml, $values);

        if (isset($values[0]) && !empty($values[0])) {

            // Removendo caracteres desnecessários
            $replace = function ($valor) {
                $search = array("lat=", '"', "lon=");
                $replace   = array("", "", "");
                return str_ireplace($search, $replace, $valor);
            };
            $values = array_map($replace, $values[0]);

            // Calculando distancia entre os pontos
            $distances = [];
            for ($i = 0; $i < count($values) - 1; $i++) {
                $point1 = explode(' ', $values[$i]);
                $point2 = explode(' ', $values[$i + 1]);

                array_push($distances, $this->haversine($point1[0], $point2[0], $point1[1], $point2[1]));
            }

            // Somando as distâncias
            return Decimal::sum($distances)->toFixed(4);
        } else {
            return null;
        }
    }
}
