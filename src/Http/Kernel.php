<?php

namespace Acme\Http;

use DI\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use FastRoute\Dispatcher;
use React\Http\Response;

class Kernel
{
    private $dispatcher;

    public function __construct(
        Dispatcher $dispatcher,
        Container $container
    ) {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    public function handle(RequestInterface $request)/* : ResponseInterface */
    {
        $routeResult = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());
        switch ($routeResult[0]) {
            case Dispatcher::FOUND:
                list($controllerName, $method) = explode('@', $routeResult[1]);
                $controller = $this->container->get($controllerName);
                $response = $controller->$method($request);
                if (is_array($response)) {
                    return new Response(
                        200,
                        ['Content-Type' => 'application/json'],
                        json_encode($response),
                    );
                }
                return new Response(
                    200,
                    ['Content-Type' => 'text/plain'],
                    $response
                );
            break;
        }

        return new Response(
            404,
            array('Content-Type' => 'text/plain'),
            "NOT FOUND\n"
        );
    }
}
