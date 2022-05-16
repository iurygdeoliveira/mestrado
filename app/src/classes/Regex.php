<?php

declare(strict_types=1);

namespace src\classes;

use Spatie\Regex\Regex as RegexSpatie;

class Regex
{

    /**
     *Ele corresponde a todos os padrões no assunto e retorna uma matriz de resultados.
     *
     * @param string pattern O padrão de expressão regular a ser pesquisado.
     * @param string subject A string a ser pesquisada.
     *
     * @return array|string|bool Um array de correspondências ou uma correspondencia ou falso se não houver correspondencias.
     */
    public static function match(string $pattern, string $subject): array|string|bool
    {

        $results = [];
        if (RegexSpatie::matchAll($pattern, $subject)->hasMatch()) {

            $data = RegexSpatie::matchAll($pattern, $subject)->results();

            foreach ($data as $key => $value) {
                array_push($results, $value->result());
            }

            return $results;
        } else {
            return false;
        }
    }
}
