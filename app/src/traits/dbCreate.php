<?php

declare(strict_types=1);

namespace src\traits;

use PDOException;
use PDO;
use src\traits\dbConnection;
use src\traits\dbError;
use src\traits\Filter;

trait dbCreate
{
    use dbConnection, Filter, dbError;

    protected function create(array $data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ":" . implode(', :', array_keys($data));

            $insert = "INSERT INTO " . $this->table . " ({$columns}) VALUES ({$values})";

            $conexion = $this->connectDB();
            if ($conexion instanceof PDO) {

                $stmt = $conexion->prepare($insert);
                $stmt->execute($this->filter($data));
                $this->fail = false;
                return $conexion->lastInsertId();
            }

            $this->fail = true;
            $this->message = "Conexão com Banco de Dados não estabelecida.";
            return false;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            $this->message = $exception->getMessage();
            return false;
        }
    }
}
