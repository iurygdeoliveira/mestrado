<?php

declare(strict_types=1);

namespace src\traits;


use Exception;
use Geocoder\ProviderAggregator;
use Geocoder\Provider\GoogleMaps\GoogleMaps as ProviderGoogleMaps;
use Geocoder\Provider\Nominatim\Nominatim as ProviderOpenStreetMap;
use Geocoder\Provider\BingMaps\BingMaps as ProviderBingMaps;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use League\Geotools\Geotools as GeoLocation;
use League\Geotools\Coordinate\Coordinate;
use Cache\Adapter\PHPArray\ArrayCachePool;
use stdClass;
use Curl\Curl;
use src\classes\Regex;


trait Geotools
{

    use Date;

    private function getAddressFromProvider(object $data)
    {

        $provider = new stdClass();

        if (!empty($data->getAddress())) {

            $aux = $data->getAddress()->toArray();
            $provider->address = ($aux ? $aux['country'] . '|' . $aux['locality'] . '|' . $aux['streetName'] : 'Error getting address');
        } else {
            $provider->address = 'Error getting address';
        }

        return $provider;
    }

    public function addressFromGeoTools(float $lat, float $lon)
    {
        $geocoder = new ProviderAggregator();
        $httpClient = new GuzzleAdapter();

        $geocoder->registerProviders([
            new ProviderOpenStreetMap($httpClient, 'https://nominatim.openstreetmap.org', 'CycleVis'),
            new ProviderGoogleMaps($httpClient, null, CONF_GOOGLE_API_KEY),
            new ProviderBingMaps($httpClient, CONF_BING_API_KEY)
        ]);

        try {
            $geolocation = new GeoLocation();
            $cache = new ArrayCachePool();
            $results = $geolocation->batch($geocoder)->setCache($cache)->reverse(
                new Coordinate([$lat, $lon])
            )->parallel();
        } catch (Exception $e) {
            dumpexit($e->getMessage(), __LINE__, __FILE__, __FUNCTION__);
        }

        $address = new stdClass();

        if ($results[0]->getProviderName() == 'nominatim') {
            $address->openstreetmap = $this->getAddressFromProvider($results[0]);
        } else {

            $openstreetmap = new stdClass();
            $openstreetmap->address = 'Error getting address';
            $address->openstreetmap = $openstreetmap;
        }

        if ($results[1]->getProviderName() == 'google_maps') {
            $address->google = $this->getAddressFromProvider($results[1]);
        } else {

            $google = new stdClass();
            $google->address = 'Error getting address';
            $address->google = $google;
        }

        if ($results[2]->getProviderName() == 'bing_maps') {
            $address->bing = $this->getAddressFromProvider($results[2]);
        } else {

            $bing = new stdClass();
            $bing->address = 'Error getting address';
            $address->bing = $bing;
        }

        return $address;
    }

    public function elevationFromGoogle(array $lat, array $lon)
    {

        $provider = new stdClass();

        if (count($lat) == count($lon)) {
            $data = [];

            // Quantidade de requisições para o Google elevation API
            // deve ser até 6000 por minuto

            foreach ($lat as $key => $value) {

                $url = 'https://maps.googleapis.com/maps/api/elevation/xml?locations=' . $lat[$key] . '%2C' . $lon[$key] . '&key=' . CONF_GOOGLE_API_KEY;
                $curl = new Curl();
                $curl->get($url);

                if ($curl->error) {
                    array_push($data, 'error');
                    //echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
                } else {

                    $response = json_encode($curl->response);
                    $response = Regex::match('/elevation":[.0-9]+/mius', $response);
                    $response = str_replace('elevation":', "", $response);
                    array_push($data, $response);
                    // dumpexit($data, __LINE__, __FILE__, __FUNCTION__);
                }
            }

            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };

            return array_reduce($data, $reduce);
        } else {
            return null;
        }
    }

    public function elevationFromGeoTools(array $lat, array $lon)
    {

        $elevations = new stdClass();
        $elevations->google = $this->elevationFromGoogle($lat, $lon);
        $elevations->bing = null;
        $elevations->srtm = null;

        return $elevations;
    }
}
