<?php

declare(strict_types=1);

namespace src\classes;


use src\traits\responseJson;
use src\classes\Regex;
use src\models\rideBD;


class Pedalada
{

    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    use responseJson;

    public function __construct(string $rider)
    {
        // Obtendo id do ciclista
        $id = Regex::match('/\d{1,2}/mius', $rider);
        $this->ride = (new rideBD())->bootstrap($id[0]);
    }


    public function obterPedaladas()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $pedaladas = $this->ride->getPedaladas();

        set_time_limit(30);
        return $pedaladas;
    }
}