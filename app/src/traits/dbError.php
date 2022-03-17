<?php

declare(strict_types=1);

namespace src\traits;

use stdClass;
use PDOException;

trait dbError
{

    public function errorDB(PDOException $exception)
    {
        $error = new stdClass();
        $error->message = $exception->getMessage();
        $error->file = $exception->getFile();
        $error->line = $exception->getLine();
        $error->trace = $exception->getTraceAsString();
        return $error;
    }
}
