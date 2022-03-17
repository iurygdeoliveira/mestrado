<?php

declare(strict_types=1);

namespace src\core;

use src\traits\dbConnection;
use src\traits\dbCreate;
use src\traits\dbDelete;
use src\traits\dbUpdate;
use src\traits\dbRead;
use src\traits\dbError;
use src\traits\dbRequired;
use src\traits\Filter;
use PDO;
use PDOException;
use stdClass;

abstract class Model
{

    use dbConnection, dbCreate, dbDelete, dbUpdate, dbRead, dbError, dbRequired, Filter;

    protected ?object $data;
    protected $fail;
    protected $message;
    protected string $query;
    protected $params;
    protected $order;
    protected $offset;
    protected $limit;

    /**
     * Construir o parametro data com os valores retornados do banco
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }
        $this->data->$name = $value;
    }

    /**
     * Retorna um valor especifico dentro do campo data 
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    public function __isset($name)
    {
        return isset($this->data->$name);
    }


    public function count(string $key = "id")
    {
        try {

            $stmt = $this->connectDB()->prepare($this->query);
            $stmt->execute($this->params);
            $this->fail = null;
            return $stmt->rowCount();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function data(): ?object
    {
        return $this->data;
    }

    public function fail()
    {
        return $this->fail;
    }

    // Colocar try cath nos métodos 
    public function fetch(bool $all = false)
    {

        try {

            $conexion = $this->connectDB();
            if ($conexion instanceof PDO) {

                $stmt = $conexion->prepare($this->query . $this->order . $this->limit . $this->offset);
                $stmt->execute($this->params);
                $this->fail = null;

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

            $this->fail = "Conexão com Banco de Dados não estabelecida";
            return false;
        } catch (PDOException $exception) {
            $this->fail = $this->errorDB($exception);
            return false;
        }
    }

    public function find(?string $terms = null, ?string $params = null, string $columns = "*")
    {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM " . static::$entity . " WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->query = "SELECT {$columns} FROM " . static::$entity;
        return $this;
    }

    public function findById(int $id, string $columns = "*")
    {
        $find = $this->find("id = :id", "id={$id}", $columns);
        return $find->fetch();
    }

    public function message()
    {
        return $this->message;
    }

    public function order(string $columnOrder): Model
    {
        $this->order = " ORDER BY {$columnOrder}";
        return $this;
    }

    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }
}
