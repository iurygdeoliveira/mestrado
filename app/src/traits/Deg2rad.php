<?php

declare(strict_types=1);

namespace src\traits;

use Decimal\Decimal;
use Exception;

trait Deg2rad
{
    /**
     * Converte graus para radianos usando a extensão decimal.
     *
     * @param string $degrees Valor em graus
     * @return string Valor em radianos
     */

    public function deg2rad(string $degrees): string
    {
        $value = new Decimal($degrees);
        $denominator = new Decimal(strval(180));
        $pi = new Decimal(strval(M_PI));

        try {
            return $value->div($denominator)->mul($pi)->__toString();
        } catch (Exception $e) {
            bardump($e, 'Exception');
        }
    }
}
