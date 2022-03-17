<?php

declare(strict_types=1);

namespace src\traits;


trait Filter
{


    public function filter($data)
    {

        if (is_array($data)) {

            $filter = [];
            foreach ($data as $key => $value) {
                $filter[$key] = (is_null($value) ? null : filter_var(trim($value), FILTER_SANITIZE_SPECIAL_CHARS));
            }
            return $filter;
        } else {
            $filter = (is_null($data) ? null : filter_var(trim($data), FILTER_SANITIZE_SPECIAL_CHARS));
            return $filter;
        }
    }
}
