<?php

declare(strict_types=1);

namespace src\traits\crud;


trait preventChange
{

    /**
     * Proteger Dados que não podem sofrer alterações no banco
     */
    public function preventChange(array $preventChange)
    {
        $safe = (array) $this->data;
        foreach ($preventChange as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }
}
