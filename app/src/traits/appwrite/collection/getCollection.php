<?php

declare(strict_types=1);

namespace src\traits\appwrite\collection;

use Appwrite\Client;
use Appwrite\Services\Database;
use Appwrite\AppwriteException;

trait getCollection
{
    /**
     * Retorna uma collection
     * @param string $uuid Identificador da collection
     * @return mixed Retorna o Json com os dados da collection
     */
    public function getCollection(string $uuid): mixed
    {
        $client = new Client();

        $client
            ->setEndpoint(CONF_APPWRITE_COLLECTION) // Your API Endpoint
            ->setProject(CONF_APPWRITE_PROJECT) // Your project ID
            ->setKey(CONF_APPWRITE_KEY) // Your secret API key
        ;

        try {
            return (new Database($client))->getCollection($uuid);
        } catch (AppwriteException $th) {
            return $th->getMessage();
        }
    }
}
