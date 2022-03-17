<?php

declare(strict_types=1);

namespace src\core;

use Laminas\Diactoros\Response;
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

    protected function dataBegin(string $page = ''): array
    {
        return [
            'title' => $page
        ];
    }

    protected function response(): Response
    {

        $response = new Response();
        $response->getBody()->write(
            $this->serialize($this->result, 'json')
        );

        return $response->withAddedHeader('content-type', 'application/json')
            ->withStatus(200);
    }
}
