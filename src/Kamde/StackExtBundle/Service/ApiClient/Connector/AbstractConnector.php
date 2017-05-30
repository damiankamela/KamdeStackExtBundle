<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Connector;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\MessageInterface;

abstract class AbstractConnector
{
    /** @var ClientInterface|\GuzzleHttp\Client */
    protected $client;

    /**
     * @param array $responseBody
     * @return ResponseInterface
     */
    abstract protected function buildResponse(array $responseBody);

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
        $responseBody = $this->getResponseBody($response);

        return $this->buildResponse($responseBody);
    }

    /**
     * @param MessageInterface $response
     * @return mixed
     */
    protected function getResponseBody(MessageInterface $response)
    {
        return \GuzzleHttp\json_decode($response->getBody(), true);
    }
}