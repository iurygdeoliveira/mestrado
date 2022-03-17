<?php

declare(strict_types=1);

namespace src\traits;

use PDO;
use src\traits\dbConnection;

trait dbFetch
{
    use dbConnection;

    public function fetch(bool $all = false)
    {
        $stmt = $this->connectDB()->prepare($this->query . $this->order . $this->limit . $this->offset);
        $stmt->execute($this->params);

        // Sem retorno de objetos 
        if (!$stmt->rowCount()) {
            return null;
        }

        // Retornando varios objetos
        if ($all) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
        }

        // Retornando um objeto
        return $stmt->fetchObject(static::class);
    }
}
