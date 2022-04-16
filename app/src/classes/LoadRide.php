<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\GetNames;
use src\traits\responseJson;
use src\models\rideBD;
use src\classes\ExtractInfoGPX;
use src\classes\ExtractInfoTCX;


class LoadRide
{

    private $riderID; // ID do ciclista 
    private $dataset; // Recebe o nome do dataset 
    private $info; // Estrutura para extrair as informações dos arquivos GPX ou TCX
    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    use GetNames, responseJson;

    public function __construct(string $dataset, string $riderID, string $activityID)
    {

        $this->dataset = $dataset;
        $this->riderID = $riderID;
        $this->ride = new rideBD();
        $this->ride->bootstrap($riderID);
    }

    public function fileExists(string $filename)
    {

        if (file_exists($filename . ".gpx")) {

            return ".gpx";
        }

        if (file_exists($filename . ".tcx")) {
            return ".tcx";
        }

        return false;
    }


    public function preprocessar(string $file)
    {

        // Identificando extensão do arquivo
        $extension = $this->fileExists($file);

        // Arquivo não encontrado
        if (!$extension) {
            return "Arquivo não encontrado";
        }

        $xml_string = file_get_contents($file . $extension);

        //Extraindo estrutura de nós do arquivo
        $this->info = match ($extension) {
            ".gpx" => new ExtractInfoGPX($xml_string),
            ".tcx" => new ExtractInfoTCX($xml_string)
        };

        $this->ride->nodes = $this->info->getNodes();

        if ($this->ride->save()) {
            return true;
        } else {
            return "Erro ao salvar no BD " . $this->ride->message();
        }
    }
}
