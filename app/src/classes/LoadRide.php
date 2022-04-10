<?php

declare(strict_types=1);

namespace src\classes;

use src\traits\GetNames;
use src\models\rideBD;
use src\classes\ExtractInfoGPX;
use src\classes\ExtractInfoTCX;
use SimpleXMLElement;

class LoadRide
{

    private $riderID; // ID do ciclista 
    private $dataset; // Recebe o nome do dataset 
    private $info; // Estrutura para extrair as informações dos arquivos GPX ou TCX
    private $ride; // Estrutura para receber os dados da corrida e persistir no BD

    use GetNames;

    public function __construct(string $dataset, string $riderID, string $activityID)
    {

        $this->dataset = $dataset;
        $this->riderID = $riderID;
        $this->ride = new rideBD();
    }

    public function __get($name)
    {
        return ($this->$name ?? null);
    }

    public function fileExists(string $filename)
    {

        if (file_exists($filename . ".gpx")) {
            return ".gpx";
        }

        if (file_exists($filename . ".tcx")) {
            return ".tcx";
        }

        $this->ride->setFail(true);
        $this->ride->setMessage("Arquivo {$filename} não encontrado");
        return false;
    }

    // Pre processando a string XML
    private function preprocessing(string $file)
    {

        // Pré-processando o arquivo XML
        $search = array('gpxtpx:TrackPointExtension', 'gpxtpx:atemp', 'gpxtpx:hr', 'gpxtpx:cad', 'ele', 'ns3:TrackPointExtension', 'ns3:atemp', 'ns3:hr', 'ns3:cad', 'ns3:ele');
        $replace = array('TrackPoint', 'temperature', 'heartrate', 'cadence', 'elevation', 'TrackPoint', 'temperature', 'heartrate', 'cadence', 'elevation');
        $xml_string = str_replace($search, $replace, file_get_contents($file));

        // Transformando o xml em objeto para manipulação
        return (new SimpleXMLElement($xml_string));
    }

    public function extract(string $file)
    {

        // Identificando extensão do arquivo
        $extension = $this->fileExists($file);

        // Arquivo não encontrado
        if (!$extension) {
            return $this->ride;
        }

        $xml = $this->preprocessing($file . $extension);

        // Extraindo estrutura de nós do arquivo
        $this->info = match ($extension) {
            ".gpx" => new ExtractInfoGPX($xml),
            ".tcx" => new ExtractInfoTCX($xml)
        };

        $this->ride->nodes = $this->info->getNodes();
        return $this->ride;
    }
}
