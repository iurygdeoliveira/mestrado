<?php

declare(strict_types=1);

namespace src\traits;


use Exception;
use Geocoder\ProviderAggregator;
use Geocoder\Provider\GoogleMaps\GoogleMaps as ProviderGoogleMaps;
use Geocoder\Provider\Nominatim\Nominatim as ProviderOpenStreetMap;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use League\Geotools\Geotools as GeoLocation;
use League\Geotools\Coordinate\Coordinate;
use Cache\Adapter\PHPArray\ArrayCachePool;
use Geocoder\Dumper\WktDumper;

use stdClass;

trait Geotools
{

    private function getAddressFromOpenStreetMap(object $data)
    {

        $provider = new stdClass();
        $aux = $data->getAddress()->getDisplayName();
        $provider->address = ($aux ? $aux : 'Error getting address');

        $bounds = $data->getAddress()->getBounds()->toArray();
        $provider->bounds = ($bounds ? 'south ' . $bounds['south'] . '|west ' . $bounds['west'] . '|north ' . $bounds['north'] . '|east ' . $bounds['east'] : 'Error getting bounds'
        );

        return $provider;
    }

    private function getAddressFromGoogle(object $data)
    {

        $provider = new stdClass();
        $aux = $data->getAddress()->getFormattedAddress();
        $provider->address = ($aux ? $aux : 'Error getting address');

        $bounds = $data->getAddress()->getBounds()->toArray();
        $provider->bounds = ($bounds ? 'south ' . $bounds['south'] . '|west ' . $bounds['west'] . '|north ' . $bounds['north'] . '|east ' . $bounds['east'] : 'Error getting bounds'
        );

        return $provider;
    }

    public function addressFromGeoTools(float $lat, float $lon)
    {
        $geocoder = new ProviderAggregator();
        $httpClient = new GuzzleAdapter();

        $geocoder->registerProviders([
            new ProviderOpenStreetMap($httpClient, 'https://nominatim.openstreetmap.org', 'CycleVis'),
            new ProviderGoogleMaps($httpClient, null, CONF_GOOGLE_API_KEY),
        ]);

        try {
            $geolocation = new GeoLocation();
            $cache = new ArrayCachePool();
            $results = $geolocation->batch($geocoder)->setCache($cache)->reverse(
                new Coordinate([$lat, $lon])
            )->parallel();
        } catch (Exception $e) {
            dumpexit($e->getMessage());
        }

        $address = new stdClass();

        if ($results[0]->getProviderName() == 'nominatim') {
            $address->openstreetmap = $this->getAddressFromOpenStreetMap($results[0]);
        } else {

            $openstreetmap = new stdClass();
            $openstreetmap->address = 'Error getting address';
            $openstreetmap->bounds = 'Error getting bounds';
            $address->openstreetmap = $openstreetmap;
        }

        if ($results[1]->getProviderName() == 'google_maps') {
            $address->google = $this->getAddressFromGoogle($results[1]);
        } else {

            $google = new stdClass();
            $google->address = 'Error getting address';
            $google->bounds = 'Error getting bounds';
            $address->google = $google;
        }

        return $address;
    }
}
