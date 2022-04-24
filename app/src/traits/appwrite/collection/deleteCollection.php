<?php

declare(strict_types=1);

namespace src\traits\appwrite\collection;

use Appwrite\Client;
use Appwrite\Services\Database;
use Appwrite\AppwriteException;

trait deleteCollection
{
    /**
     * Retorna uma lista de collections
     * @param string $id ID da collection
     * @return mixed Retorna o Json com os dados da collection
     */
    public function deleteCollection(string $id): mixed
    {
        $client = new Client();

        $client
            ->setEndpoint(CONF_APPWRITE_COLLECTION) // Your API Endpoint
            ->setProject(CONF_APPWRITE_PROJECT) // Your project ID
            ->setKey(CONF_APPWRITE_KEY) // Your secret API key
        ;

        try {
            return (new Database($client))->deleteCollection($id);
        } catch (AppwriteException $th) {
            return $th->getMessage();
        }
    }
}
