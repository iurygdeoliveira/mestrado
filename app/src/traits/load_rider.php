<?php

declare(strict_types=1);

namespace src\traits;

use SimpleXMLElement;
use DirectoryIterator;

trait load_rider
{


    public function loadRider(string $dataset): bool
    {

        $iterator = new DirectoryIterator($dataset);

        foreach ($iterator as $fileInfo) {
            dump($fileInfo->getFilename());
        }
        exit;

        $xmlstr = file_get_contents($dataset . 'f1.gpx');
        $xml = new SimpleXMLElement($xmlstr);
        dump($xml->trk->trkseg->trkpt[0]);
        exit;
        return true;
    }
}
