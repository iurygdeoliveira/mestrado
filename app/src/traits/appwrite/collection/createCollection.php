<?php

declare(strict_types=1);

namespace src\traits\appwrite\collection;

use Appwrite\Client;
use Appwrite\Services\Database;
use Appwrite\AppwriteException;
use Ramsey\Uuid\Uuid;

trait createCollection
{
    /**
     * Retorna uma lista de collections
     * @param string $name Nome da collection
     * @param string $level Nível de permissão, a nível de document ou collection
     * @param array $read Permissões de leitura
     * @param array $write Permissões de escrita
     * @return mixed Retorna o Json com os dados da collection
     */
    public function createCollection(string $name, string $level, array $read, array $write): mixed
    {
        $client = new Client();

        $client
            ->setEndpoint(CONF_APPWRITE_COLLECTION) // Your API Endpoint
            ->setProject(CONF_APPWRITE_PROJECT) // Your project ID
            ->setKey(CONF_APPWRITE_KEY) // Your secret API key
        ;

        try {
            return (new Database($client))->createCollection(uniqid(), $name, $level, $read, $write);
        } catch (AppwriteException $th) {
            return $th->getMessage();
        }
    }
}
