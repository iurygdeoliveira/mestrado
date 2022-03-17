<?php

declare(strict_types=1);

namespace src\traits;

use src\traits\dbConnection;
use src\traits\dbError;
use PDOException;
use PDO;

trait dbRead
{

    use dbConnection, dbError;
    protected function read(string $select, string $params = null)
    {

        try {

            $conexion = $this->connectDB();
            if ($conexion instanceof PDO) {

                // Preparando select
                $stmt = $conexion->prepare($select);

                if ($params) {
                    parse_str($params, $params); // Convertendo params para array

                    // Configurando parametros do bind, para inteiros ou strings
                    foreach ($params as $key => $value) {
                        if ($key == 'limit' || $key == 'offset') {
                            $stmt->bindValue(":{$key}", $value, PDO::PARAM_INT);
                        } else {
                            $stmt->bindValue(":{$key}", $value, PDO::PARAM_STR);
                        }
                    }
                }
                $stmt->execute();
                $this->fail = null;
                return $stmt;
            }

            $this->fail = "Conexão com Banco de Dados não estabelecida";
            return false;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }
}
