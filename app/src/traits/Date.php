<?php

declare(strict_types=1);

namespace src\traits;

use DateTime;

trait Date
{
    // Horario no formato brasileiro
    public function date_fmt(string $date = "now", string $format = "d/m/Y H\hi"): string
    {
        return (new DateTime($date))->format($format);
    }

    // Horario no formato brasileiro
    public function date_fmt_br(string $date = "now"): string
    {
        return (new DateTime($date))->format(CONF_DATE_BR);
    }

    // Horario no formato unix
    public function date_fmt_unix(string $date = "now"): string
    {
        return (new DateTime($date))->format(CONF_DATE_APP);
    }

    //////////////////////////////////////////////////////////////////////
    //PARA: Date Should In YYYY-MM-DD Format
    //RESULT FORMAT:
    // '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
    // '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
    // '%m Month %d Day'                                            =>  3 Month 14 Day
    // '%d Day %h Hours'                                            =>  14 Day 11 Hours
    // '%d Day'                                                        =>  14 Days
    // '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
    // '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
    // '%h Hours                                                    =>  11 Hours
    // '%a Days                                                        =>  468 Days
    //////////////////////////////////////////////////////////////////////
    public function date_difference(string $date_1, string $date_2, string $differenceFormat = '%a'): string
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    public function timeToHours(string $time): float
    {

        $aux = explode(":", $time);
        $aux[0] = floatval($aux[0]);
        $aux[1] = floatval($aux[1]) / 60;
        $aux[2] = floatval($aux[2]) / 3600;

        return $aux[0] + $aux[1] + $aux[2];
    }
}
