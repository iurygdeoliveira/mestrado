<?php

declare(strict_types=1);

namespace src\traits\appwrite\collection;

use Appwrite\Client;
use Appwrite\Services\Database;
use Appwrite\AppwriteException;

trait listCollection
{
    /**
     * Retorna uma lista de collections
     * @param string $jwt Token de Autenticação
     * @param string $search Termo de consulta
     * @return string|array Retorna uma lista de collections ou 'Collection not found'
     */
    public function listCollection(string $jwt, string $search = null, int $limit = null, int $offset = null, string $cursor = null, string $cursorDirection = null, string $orderType = null): string|array|AppwriteException
    {
        $client = new Client();

        $client
            ->setEndpoint(CONF_APPWRITE_COLLECTION) // Your API Endpoint
            ->setProject(CONF_APPWRITE_PROJECT) // Your project ID
            ->setKey(CONF_APPWRITE_KEY) // Your secret API key
            ->setJwt($jwt) // Token
        ;

        try {
            return (new Database($client))->listCollections($search, $limit, $offset, $cursor, $cursorDirection, $orderType);
        } catch (AppwriteException $th) {
            return $th;
        }
    }
}
