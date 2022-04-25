<?php

declare(strict_types=1);

namespace src\traits\crud;

use PDOException;
use PDO;
use src\traits\crud\connection;
use src\traits\Filter;

trait update
{

    use connection, Filter;

    protected function update(array $data, string $terms, string $params)
    {
        try {

            $dataSet = [];
            foreach ($data as $bind => $value) {
                $dataSet[] = "{$bind} = :{$bind}";
            }
            $dataSet = implode(", ", $dataSet);

            parse_str($params, $params); // Convertendo params para array

            $update = "UPDATE " . $this->table . " SET {$dataSet} WHERE {$terms}";

            $conexion = $this->connectDB();
            if ($conexion instanceof PDO) {
                $stmt = $conexion->prepare($update);
                $stmt->execute($this->filter(array_merge($data, $params)));
                $this->fail = false;
                return $stmt->rowCount();
            }

            $this->message = "Conexão com Banco de Dados não estabelecida";
            $this->fail = true;
            return false;
        } catch (PDOException $exception) {
            $this->fail = true;
            $this->message = $exception->getMessage();
            return false;
        }
    }
}
