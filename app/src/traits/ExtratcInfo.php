<?php

declare(strict_types=1);

namespace src\traits;

use DateTime;

trait ExtractInfo
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
}
