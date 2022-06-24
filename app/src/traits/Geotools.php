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

        if (!empty($data->getAddress())) {

            $aux = $data->getAddress()->toArray();
            return ($aux ? $aux['country'] . '|' . $aux['locality'] . '|' . $aux['streetName'] : 'error');
        } else {
            return 'error';
        }
    }

    public function addressFromOSM(float $lat, float $lon)
    {
        $geocoder = new ProviderAggregator();
        $httpClient = new GuzzleAdapter();

        $geocoder->registerProviders([
            new ProviderOpenStreetMap($httpClient, CONF_URL_OPEN_STREET_MAP, 'CycleVis')
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

        if ($results[0]->getProviderName() == 'nominatim') {
            return $this->getAddressFromProvider($results[0]);
        } else {
            return 'error';
        }
    }

    public function addressFromGoogle(float $lat, float $lon)
    {
        $geocoder = new ProviderAggregator();
        $httpClient = new GuzzleAdapter();

        $geocoder->registerProviders([
            new ProviderGoogleMaps($httpClient, null, $_ENV['CONF_GOOGLE_API_KEY'])
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

        if ($results[0]->getProviderName() == 'google_maps') {
            return $this->getAddressFromProvider($results[0]);
        } else {
            return 'error';
        }
    }

    public function addressFromBing(float $lat, float $lon)
    {
        $geocoder = new ProviderAggregator();
        $httpClient = new GuzzleAdapter();

        $geocoder->registerProviders([
            new ProviderBingMaps($httpClient, $_ENV['CONF_BING_API_KEY'])
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

        if ($results[0]->getProviderName() == 'bing_maps') {
            return $this->getAddressFromProvider($results[0]);
        } else {
            return 'error';
        }
    }

    public function elevationFromGoogle(array $lat, array $lon)
    {

        // Reduzindo tamanho do valor de lagitude e longitude para o tamanho aceito pelo Google
        $slice = function ($valor) {
            if (strlen($valor) > 10) {
                $item = str_split($valor, 10);
                return $item[0];
            } else {
                return $valor;
            }
        };

        $lat = array_map($slice, $lat);
        $lon = array_map($slice, $lon);

        if (count($lat) == count($lon)) {
            $data = [];

            // Quantidade de requisições para o Google elevation API
            // deve ser até 6000 por minuto
            foreach ($lat as $key => $value) {
                array_push($data, "$lat[$key]%2C$lon[$key]");
            }

            // Montando bloco de pontos para realizar a requisição
            $data = array_chunk($data, 510);

            $coordinates = [];
            foreach ($data as $key => $value) {

                $reduce = function ($carry, $item) {
                    $carry .= $item . '%7C';
                    return $carry;
                };

                $reduzido = array_reduce($data[$key], $reduce);
                $reduzido = substr($reduzido, 0, -3);
                array_push($coordinates, $reduzido);
            }

            $result = [];
            foreach ($coordinates as $key => $value) {

                $url = CONF_URL_ELEVATION_GOOGLE . $coordinates[$key] . '&key=' . $_ENV['CONF_GOOGLE_API_KEY'];

                $curl = new Curl();
                $curl->get($url);

                if ($curl->error) {
                    array_push($result, 'error');
                    // dumpexit('Error: ' . $curl->errorCode . ': ' . $curl->errorMessage, __LINE__, __FILE__, __FUNCTION__);
                } else {

                    $response = $curl->response;
                    array_push($result, json_encode($response));
                }
            }

            $elevations = [];
            foreach ($result as $key => $value) {

                $matches = Regex::match('/"elevation":[.0-9]+/mius', $result[$key]);

                if ($matches) {
                    $search = array('elevation":', '"');
                    $replace   = array("", "");
                    $elevations = array_merge($elevations, str_replace($search, $replace, $matches));
                } else {
                    array_push($elevations, 'error');
                }
            }

            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };

            return array_reduce($elevations, $reduce);
        } else {
            return null;
        }
    }
    public function elevationFromBing(array $lat, array $lon)
    {

        // Reduzindo tamanho do valor de lagitude e longitude para o tamanho aceito pelo Google
        $slice = function ($valor) {
            if (strlen($valor) > 10) {
                $item = str_split($valor, 10);
                return $item[0];
            } else {
                return $valor;
            }
        };

        $lat = array_map($slice, $lat);
        $lon = array_map($slice, $lon);

        // {lat1,long1,lat2,long2,latN,longnN}
        if (count($lat) == count($lon)) {
            $data = [];

            // Quantidade de requisições para o Google elevation API
            // deve ser até 6000 por minuto
            foreach ($lat as $key => $value) {
                array_push($data, "$lat[$key],$lon[$key]");
            }

            // Montando bloco de pontos para realizar a requisição
            $data = array_chunk($data, 70);

            $coordinates = [];
            foreach ($data as $key => $value) {

                $reduce = function ($carry, $item) {
                    $carry .= $item . ',';
                    return $carry;
                };

                $reduzido = array_reduce($data[$key], $reduce);
                $reduzido = substr($reduzido, 0, -1);
                array_push($coordinates, $reduzido);
            }

            $result = [];
            foreach ($coordinates as $key => $value) {

                $url = CONF_URL_ELEVATION_BING . $value . '&heights=sealevel&key=' . $_ENV['CONF_BING_API_KEY'];

                $curl = new Curl();
                $curl->get($url);

                if ($curl->error) {
                    array_push($result, 'error');
                } else {

                    $response = $curl->response;
                    // dumpexit($response->resourceSets[0]->resources[0]->elevations, __LINE__, __FILE__, __FUNCTION__);
                    $filtered = (isset($response->resourceSets[0]->resources[0]->elevations) ? $response->resourceSets[0]->resources[0]->elevations : 'error elevation');
                    array_push($result, $filtered);
                }
            }

            $elevations = [];
            foreach ($result as $key => $value) {

                $convert = function ($valor) {
                    return strval($valor);
                };

                if (is_array($result[$key])) {
                    $elevations = array_merge($elevations, array_map($convert, $result[$key]));
                } else {
                    $elevations = array_merge($elevations, [$result[$key]]);
                }
            }

            $reduce = function ($carry, $item) {
                $carry .= $item . '|';
                return $carry;
            };

            return array_reduce($elevations, $reduce);
        } else {
            return null;
        }
    }
}
