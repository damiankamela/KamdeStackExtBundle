<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Connector;

use GuzzleHttp\ClientInterface;
use Kamde\StackExtBundle\Service\ApiClient\Request;
use Kamde\StackExtBundle\Service\ApiClient\Response;
use Kamde\StackExtBundle\Service\ApiClient\ResponseInterface;
use Psr\Http\Message\MessageInterface;

abstract class AbstractConnector
{
    /** @var ClientInterface|\GuzzleHttp\Client */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param Request $request
     * @return ResponseInterface
     */
    public function getResponse(Request $request)
    {
        $response = $this->client->request($request->getMethod(), $request->getUri(), $request->getParameters());

        return $this->buildResponse($response);
    }

    /**
     * @param MessageInterface $response
     * @return Response
     */
    protected function buildResponse(MessageInterface $response)
    {
        $body = \GuzzleHttp\json_decode($response->getBody(), true);

        return new Response($body);
    }
}