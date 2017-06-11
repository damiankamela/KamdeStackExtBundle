<?php

namespace Kamde\StackExtBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

class ClientFactory
{
    /**
     * @param MiddlewareInterface[] $middlewares
     * @param array                $options
     * @param LoggerInterface|null $logger
     *
     * @return ClientInterface
     */
    public function create(array $middlewares = [], array $options = [], LoggerInterface $logger = null)
    {
        $handler = HandlerStack::create();

        if ($logger) {
            $handler->push(Middleware::log($logger, new MessageFormatter(MessageFormatter::DEBUG)));
        }

        foreach ($middlewares as $middleware) {
            $handler->push($middleware->getMiddleware(), $middleware->getName());
        }

        return $this->createClient($handler, $options);
    }

    /**
     * @param HandlerStack $handler
     * @param array        $options
     *
     * @return Client
     */
    protected function createClient(HandlerStack $handler, array $options = [])
    {
        $options['handler'] = $handler;

        return new Client($options);
    }
}