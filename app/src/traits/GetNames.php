<?php

declare(strict_types=1);

namespace src\traits;

use DirectoryIterator;

trait GetNames
{
    // Obtem o nome do arquivo a ser parseado
    private function getName(string $datasetFileName)
    {

        $iterator = new DirectoryIterator($datasetFileName);

        foreach ($iterator as $fileInfo) {

            if ($fileInfo->isDot()) {
                continue;
            }
            yield ($fileInfo->getFilename());
        }
    }

    // Retorna um array contendo o nome dos arquivos de forma ordenada
    public function getFileNames(string $datasetFileName): array
    {


        $fileNames = [];
        foreach ($this->getName($datasetFileName) as $fileName) {
            array_push($fileNames, $fileName);
        }

        sort($fileNames, SORT_NATURAL); // Ordenando o nome dos arquivos

        return $fileNames;
    }
}
