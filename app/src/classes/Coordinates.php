<?php

declare(strict_types=1);

namespace src\classes;


use src\traits\responseJson;
use src\classes\Regex;
use src\models\rideBD;


class Coordinates
{

    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    use responseJson;

    public function __construct(string $rider, string $activityID = null)
    {
        // Obtendo id do ciclista
        $id = Regex::match('/\d{1,2}/mius', $rider);
        $this->ride = (new rideBD())->bootstrap($id[0], $activityID);
    }


    public function getBbox()
    {

        $bbox = explode("|", $this->ride->data()->bbox);

        $result = [
            'north' => explode(" ", $bbox[0])[1],
            'south' => explode(" ", $bbox[1])[1],
            'east' => explode(" ", $bbox[2])[1],
            'west' => explode(" ", $bbox[3])[1],
        ];
        return $result;
    }

    public function sendBbox(string $bbox, string $centroid)
    {

        $this->ride->bbox = $bbox;
        $this->ride->centroid = $centroid;

        if ($this->ride->save()) {
            return true;
        } else {
            return "Erro ao salvar no BD " . $this->ride->message();
        }
    }

    public function getPointInitial()
    {

        $point = [];
        array_push($point, $this->ride->data()->latitude_inicial);
        array_push($point, $this->ride->data()->longitude_inicial);

        return $point;
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

    public function getCoordinates()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $latitudes = explode('|', $this->ride->data()->latitudes);
        $longitudes = explode('|', $this->ride->data()->longitudes);

        // Reduzindo tamanho da string
        $slice = function ($valor) {
            if (strlen($valor) > 10) {
                $item = str_split($valor, 10);
                return $item[0];
            } else {
                return $valor;
            }
        };

        $lat = array_map($slice, $latitudes);
        $lon = array_map($slice, $longitudes);

        if (count($lat) == count($lon)) {
            $data = [];

            // Quantidade de requisições para o Google elevation API
            // deve ser até 6000 por minuto
            foreach ($lat as $key => $value) {
                array_push($data, $lat[$key] . "|" . $lon[$key]);
            }

            set_time_limit(30);
            return $data;
        } else {
            return false;
        }
    }
}
