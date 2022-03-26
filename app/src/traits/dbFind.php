<?php

declare(strict_types=1);

namespace src\traits;

trait dbFind
{
    public function find(?string $terms = null, ?string $params = null, string $columns = "*")
    {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM " . $this->table . " WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->query = "SELECT {$columns} FROM " . $this->table;
        return $this;
    }

    public function findById(int $id, string $columns = "*")
    {
        $find = $this->find("id = :id", "id={$id}", $columns);
        return $find->fetch();
    }
}
