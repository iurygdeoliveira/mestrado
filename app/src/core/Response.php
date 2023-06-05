<?php

declare(strict_types=1);

namespace src\core;

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Router;

class Response
{

    public function __construct(Router $router, ServerRequestInterface $request)
    {
        $response = $router->dispatch($request);
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }
}