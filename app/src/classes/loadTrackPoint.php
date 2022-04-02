<?php

declare(strict_types=1);

namespace src\classes;

use DirectoryIterator;
use src\models\rideBD;
use src\models\trackpointBD;
use src\traits\Date;
use phpGPX\phpGPX;
use SimpleXMLElement;
use stdClass;
use Waddle\Parsers\GPXParser;
use Waddle\Parsers\TCXParser;

class loadTrackPoint
{

    use Date;

    private $data; // Dados a serem salvos no BD
    private $rideBD; // Estrutura para receber os dados da corrida e persistir no BD
    private $trackpointBD; // Estrutura para receber os dados de trackpoint e persistir no BD
    private $gpx; // Armazena os dados durante o parseamento de arquivos gpx
    private $tcx; // Armazena os dados durante o parseamento de arquivos tcx

    public function __construct()
    {
        $this->rideBD = new rideBD();
        $this->gpx_aux = new phpGPX();
        $this->gpx = new GPXParser();
        $this->tcx = new TCXParser();
        $this->data = new stdClass();
    }

    public function readTrackPointsXMLStrava($xml, $ride_id)
    {
        dump($xml);
        $track = $xml->tracks[0];
        dump($track->toArray());
        $segment = $track->segments[0];
        dump($segment);
        dump($segment->stats);
        dump($segment->points[0]->latitude);
        dump($segment->points[1]->latitude);
        dump($segment->points[0]->extensions);

        // $total = count($xml->trk->trkseg->trkpt);
        // set_time_limit(60);
        // for ($i = 0; $i < 5; $i++) {
        //     $this->trackpointBD = new trackpointBD();
        //     $this->trackpointBD->ride_id = strval($ride_id);

        //     if (isset($xml->trk->trkseg->trkpt[$i]->attributes()->lat)) {
        //         $this->trackpointBD->latitude = $xml->trk->trkseg->trkpt[$i]->attributes()->lat->__toString();
        //     }

        //     if (isset($xml->trk->trkseg->trkpt[$i]->attributes()->lon)) {
        //         $this->trackpointBD->longitude = $xml->trk->trkseg->trkpt[$i]->attributes()->lon->__toString();
        //     }

        //     if (isset($xml->trk->trkseg->trkpt[$i]->ele)) {
        //         $this->trackpointBD->elevation = $xml->trk->trkseg->trkpt[$i]->ele->__toString();
        //     }

        //     if (isset($xml->trk->trkseg->trkpt[$i]->time)) {
        //         $this->trackpointBD->datetime = $this->date_fmt_unix($xml->trk->trkseg->trkpt[$i]->time->__toString());
        //     }
        //     $this->trackpointBD->save();
        // }
        dump('terminou');
        exit;
    }

    public function readXMLStrava($xml)
    {


        if (isset($xml->metadata->toArray()['time'])) {
            $this->rideBD->datetime = $this->date_fmt_unix($xml->metadata->toArray()['time']);
            $this->rideBD->dataset = $xml->creator;
            $this->readXMLStrava($xml);
        }

        //$ride_id = $this->rideBD->save();
        //dump($ride_id);
        $this->readTrackPointsXMLStrava($xml, 1);
        exit;
    }

    public function parseGPX(string $dataset, array $fileNames)
    {

        set_time_limit(20);
        // $xml = $this->gpx->parse($dataset . $fileNames[1]);
        // $xml_aux = $this->gpx_aux->load($dataset . $fileNames[1]);
        // dump("xml", $xml);
        // dump("xml_aux", $xml_aux);

        // $stats_xml_aux = $xml_aux->tracks[0]->stats->toArray();
        // $segments_xml_aux = $xml_aux->tracks[0]->segments[0];
        // dump("segments", $segments_xml_aux);
        // dump("temperatura", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->aTemp);
        // dump("frequencia cardiaca", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->hr);
        // dump("cadencia", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->cad);

        $xml = $this->tcx->parse($dataset . $fileNames[1]);
        $xml_aux = new SimpleXMLElement(file_get_contents($dataset . $fileNames[1]));
        dump($xml_aux);

        dump($dataset . $fileNames[1]);

        // se tcx
        dump("Dataset", $xml_aux->Author->Name[0]->__toString());
        //dump("Dataset", $xml_aux->creator);
        dump("type", $xml->getType());
        dump("Hora inicial", $xml->getStartTime("Y-m-d H:i:s"));
        dump("distancia total em metros", $xml->getTotalDistance());
        dump("duração total em segundos", $xml->getTotalDuration());
        dump("total de Calorias", $xml->getTotalCalories());
        dump("Velocidade média em milhas por hora", $xml->getAverageSpeedInMPH());
        dump("Velocidade média em kilometros por hora", $xml->getAverageSpeedInKPH());
        dump("total de calorias", $xml->getTotalCalories());
        dump("velocidade máxima em milhas por hora", $xml->getMaxSpeedInMPH());
        dump("velocidade máxima em kilometros por hora", $xml->getMaxSpeedInKPH());
        dump("Informação Geográfica", $xml->getGeographicInformation());
        dump("altitude máxima", $xml->getGeographicInformation()['highest']);
        dump("altitude minima", $xml->getGeographicInformation()['lowest']);
        dump("latitude", $xml->getGeographicInformation()['center']['lat']);
        dump("longitude", $xml->getGeographicInformation()['center']['lng']);


        $trackpoints = $xml->getLaps()[0];
        dump("trackpoints", $trackpoints->getTrackPoints());

        $point = $trackpoints->getTrackPoints()[0];
        dump("time", $point->getTime("Y-m-d H:i:s"));
        dump("position", $point->getPosition());
        dump("altitude em metros", $point->getAltitude());
        dump("distance em metros", $point->getDistance());
        dump("speed", $point->getSpeed());
        dump("heartRate", $point->getHeartRate());
        dump("calories", $point->getCalories());
        dump("cadence", $point->getCadence());
        // se gpx
        // dump("temperatura", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->aTemp);
        // dump("frequencia cardiaca", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->hr);
        // dump("cadencia", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->cad);
        exit;

        return $xml;
    }

    public function parseTCX(string $dataset, array $fileNames)
    {

        set_time_limit(20);
        // $xml = $this->gpx->parse($dataset . $fileNames[1]);
        // $xml_aux = $this->gpx_aux->load($dataset . $fileNames[1]);
        // dump("xml", $xml);
        // dump("xml_aux", $xml_aux);

        // $stats_xml_aux = $xml_aux->tracks[0]->stats->toArray();
        // $segments_xml_aux = $xml_aux->tracks[0]->segments[0];
        // dump("segments", $segments_xml_aux);
        // dump("temperatura", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->aTemp);
        // dump("frequencia cardiaca", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->hr);
        // dump("cadencia", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->cad);

        $xml = $this->tcx->parse($dataset . $fileNames[1]);
        $xml_aux = new SimpleXMLElement(file_get_contents($dataset . $fileNames[1]));
        dump($xml_aux);

        dump($dataset . $fileNames[1]);

        // se tcx
        dump("Dataset", $xml_aux->Author->Name[0]->__toString());
        //dump("Dataset", $xml_aux->creator);
        dump("type", $xml->getType());
        dump("Hora inicial", $xml->getStartTime("Y-m-d H:i:s"));
        dump("distancia total em metros", $xml->getTotalDistance());
        dump("duração total em segundos", $xml->getTotalDuration());
        dump("total de Calorias", $xml->getTotalCalories());
        dump("Velocidade média em milhas por hora", $xml->getAverageSpeedInMPH());
        dump("Velocidade média em kilometros por hora", $xml->getAverageSpeedInKPH());
        dump("total de calorias", $xml->getTotalCalories());
        dump("velocidade máxima em milhas por hora", $xml->getMaxSpeedInMPH());
        dump("velocidade máxima em kilometros por hora", $xml->getMaxSpeedInKPH());
        dump("Informação Geográfica", $xml->getGeographicInformation());
        dump("altitude máxima", $xml->getGeographicInformation()['highest']);
        dump("altitude minima", $xml->getGeographicInformation()['lowest']);
        dump("latitude", $xml->getGeographicInformation()['center']['lat']);
        dump("longitude", $xml->getGeographicInformation()['center']['lng']);


        $trackpoints = $xml->getLaps()[0];
        dump("trackpoints", $trackpoints->getTrackPoints());

        $point = $trackpoints->getTrackPoints()[0];
        dump("time", $point->getTime("Y-m-d H:i:s"));
        dump("position", $point->getPosition());
        dump("altitude em metros", $point->getAltitude());
        dump("distance em metros", $point->getDistance());
        dump("speed", $point->getSpeed());
        dump("heartRate", $point->getHeartRate());
        dump("calories", $point->getCalories());
        dump("cadence", $point->getCadence());
        // se gpx
        // dump("temperatura", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->aTemp);
        // dump("frequencia cardiaca", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->hr);
        // dump("cadencia", $xml_aux->tracks[0]->segments[0]->getPoints()[0]->extensions->trackPointExtension->cad);
        exit;

        return $xml;
    }

    public function getNameFile(string $dataset)
    {

        $iterator = new DirectoryIterator($dataset);

        foreach ($iterator as $fileInfo) {

            if ($fileInfo->isDot()) {
                continue;
            }
            yield ($fileInfo->getFilename());
        }
    }

    public function loadRider(string $dataset, string $riderID)
    {

        $this->rideBD->rider_id = $riderID;

        $fileNames = [];
        foreach ($this->getNameFile($dataset) as $fileName) {
            array_push($fileNames, $fileName);
        }

        sort($fileNames, SORT_NATURAL);

        foreach ($fileNames as $filename) {


            $data = match (pathinfo($filename, PATHINFO_EXTENSION)) {
                "gpx" => $this->parseGPX($dataset, $fileNames),
                "tcx" => $this->parseTCX($dataset, $fileNames)
            };
        }

        exit;
        return true;
    }
}
