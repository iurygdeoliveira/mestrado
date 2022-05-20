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
use Geocoder\Dumper\WktDumper;

use stdClass;

trait Geotools
{

    private function getAddressFromProvider(object $data)
    {

        $provider = new stdClass();

        if (!empty($data->getAddress())) {

            $aux = $data->getAddress()->toArray();
            $provider->address = ($aux ? $aux['country'] . '|' . $aux['locality'] . '|' . $aux['streetName'] : 'Error getting address');

            $bounds = $data->getAddress()->getBounds()->toArray();
            $provider->bounds = ($bounds ? 'south ' . $bounds['south'] . '|west ' . $bounds['west'] . '|north ' . $bounds['north'] . '|east ' . $bounds['east'] : 'Error getting bounds'
            );
        } else {
            $provider->address = 'Error getting address';
            $provider->bounds = 'Error getting bounds';
        }

        return $provider;
    }


    public function addressFromGeoTools(float $lat, float $lon)
    {
        $geocoder = new ProviderAggregator();
        $httpClient = new GuzzleAdapter();

        $geocoder->registerProviders([
            //new ProviderOpenStreetMap($httpClient, 'https://nominatim.openstreetmap.org', 'CycleVis'),
            //new ProviderGoogleMaps($httpClient, null, CONF_GOOGLE_API_KEY),
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
            $openstreetmap->bounds = 'Error getting bounds';
            $address->openstreetmap = $openstreetmap;
        }

        if ($results[1]->getProviderName() == 'google_maps') {
            $address->google = $this->getAddressFromProvider($results[1]);
        } else {

            $google = new stdClass();
            $google->address = 'Error getting address';
            $google->bounds = 'Error getting bounds';
            $address->google = $google;
        }

        if ($results[2]->getProviderName() == 'bing_maps') {
            $address->bing = $this->getAddressFromProvider($results[2]);
        } else {

            $bing = new stdClass();
            $bing->address = 'Error getting address';
            $bing->bounds = 'Error getting bounds';
            $address->bing = $bing;
        }

        return $address;
    }
}
