<?php

declare(strict_types=1);

namespace src\traits;

use Laminas\Diactoros\Response\JsonResponse;

trait responseJson
{
    /**
     * Retorna um objeto JsonResponse com o resultado da requisição
     *
     * @param string $status Status do retorno da requisição, true ou false
     * @param string $message Mensagem de retorno para o usuario
     * @param string $response Dados de retorno da requisição
     * @return JsonResponse
     */
    public function responseJson($status, $message, $response): JsonResponse
    {
        $data = [
            'status' => $status,
            'message' => $message,
            'response' => $response
        ];

        return new JsonResponse(
            $data,
            200,
            ['Content-Type' => ['application/hal+json']],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );
    }
}
