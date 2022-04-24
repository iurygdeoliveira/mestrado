<?php

declare(strict_types=1);

namespace src\traits\crud;


trait required
{

    public function required(array $array): bool
    {
        $data = (array)$this->data();
        foreach ($array as $field) {

            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }
}
