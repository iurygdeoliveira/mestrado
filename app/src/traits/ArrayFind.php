<?php

declare(strict_types=1);

namespace src\traits;

trait ArrayFind
{
    public function multi_array_key_exists($needle, $haystack)
    {

        foreach ($haystack as $key => $value) :

            if ($needle == $key) {
                return true;
            }

            if (is_array($value)) :
                if ($this->multi_array_key_exists($needle, $value) == true) {
                    return true;
                } else {
                    continue;
                }
            endif;

        endforeach;

        return false;
    }
}
