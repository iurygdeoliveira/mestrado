<?php

declare(strict_types=1);

namespace src\traits\crud;

use PDOException;
use PDO;
use src\traits\crud\connection;
use src\traits\Filter;

trait create
{
    use connection, Filter;

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
            $this->fail = true;
            $this->message = $exception->getMessage();
            return false;
        }
    }
}
