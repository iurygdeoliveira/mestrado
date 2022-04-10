<?php

declare(strict_types=1);

namespace src\core;

use Laminas\Diactoros\Response\JsonResponse;
use src\traits\Serialize;
use stdClass;

class Controller
{
    protected $result;
    use Serialize;

    public function __construct()
    {
        $this->result = new stdClass;
    }

    protected function dataTheme(string $page = ''): array
    {

        return [
            'title' => "$page | CycleVis"
        ];
    }

    protected function responseJson($data): JsonResponse
    {

        $response = new JsonResponse(
            $data,
            200,
            ['Content-Type' => ['application/hal+json']],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );

        return $response;
    }
}
