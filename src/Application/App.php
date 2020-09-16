<?php

namespace Acme\Application;

use Acme\Http\Kernel;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\LoopInterface;

class App
{
    private LoopInterface $loop;

    private ContainerInterface $container;

    public function __construct(LoopInterface $loop, ContainerInterface $container)
    {
        $this->loop = $loop;
        $this->container = $container;
    }

    public function listen($uri)
    {
        $kernel = $this->container->get(Kernel::class);
        $loop = $this->loop;
        $server = new \React\Http\Server(function (ServerRequestInterface $request) use ($kernel, $loop) {
            try {
                $response = $kernel->handle($request);
                return $response;
            } catch (\Throwable $e) {
                echo "\n\n----\n";
                echo $e->getMessage();
                echo "\n\n";
                echo $e->getTraceAsString();
                return new \React\Http\Response(
                    500,
                    array('Content-Type' => 'text/plain'),
                    $e->getMessage()
                );
            }
        });
        $socket = new \React\Socket\Server($uri, $this->loop);
        $server->listen($socket);
        $server->on('error', function (\Throwable $e) {
            echo "\n---\n";
            echo $e->getMessage();
            echo "\n\n";
        });
        echo "Sample API running at http://{$uri}\n";
    }
}
