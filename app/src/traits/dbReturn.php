<?php

declare(strict_types=1);

namespace src\traits;

use PDO;
use src\traits\dbError;

trait dbReturn
{
    use dbError;

    public function returnDB($result)
    {
        if ($this->fail) {

            // Se houver falha
            $this->fail = $this->errorDB($this->fail);

            return false;
        } elseif (!$result->rowCount()) {

            // Se não existem resultados
            return null;
        } else {

            // Resultado encontrado

            if ($result->rowCount() == 1) {
                return $result->fetchObject(__CLASS__);
            } else {
                return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
            }
        }
    }
}