<?php

declare(strict_types=1);

namespace src\traits;

use PDOException;
use PDO;
use src\traits\dbConnection;
use src\traits\dbError;

trait dbDelete
{
    use dbConnection, dbError;

    public function delete(string $entity, string $key, string $value): bool
    {

        try {

            $delete = "DELETE FROM {$entity} WHERE {$key} = :key";

            $conexion = $this->connectDB();
            if ($conexion instanceof PDO) {
                $stmt = $conexion->prepare($delete);
                $stmt->bindValue("key", $value, PDO::PARAM_STR);
                $stmt->execute();
                $this->fail = null;
                return true;
            }

            $this->fail = "Conexão com Banco de Dados não estabelecida";
            return false;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }
}
