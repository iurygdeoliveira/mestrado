<?php

declare(strict_types=1);

namespace src\traits;

use Nominatim\Client;
use Nominatim\Response;
use Exception;
use InvalidArgumentException;

trait Geotools
{
    /**
     * Obtém o endereço apartir de uma coordenada GPS
     * 
     * @param float $lat Latitude
     * @param float $lon Longitude
     * @return array|Exception|bool Endereço ou false para endereço não encontrado ou excpetion com erro
     * 
     * Nota: 
     * Em Nominatim\Client austar:
     *  - protected $addressDetails = 1;
     *  - http_build_query($params, '', '&');
     * 
     * Em Nominatim\Response:
     * public function getAddress()
     *  {
     *   return $this->data['address'];
     *  } 
     * 
     */
    public function getAddressFromGPS(float $lat, float $lon): string|bool|array
    {
        $client = new Client();

        try {
            $response = $client->reverse($lat, $lon);

            if ($response->isOK()) {
                return $response->getAddress();
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
