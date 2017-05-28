<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Connector;

use GuzzleHttp\ClientInterface;
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
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return ResponseInterface
     */
    public function getResponse(string $method, string $uri, array $options = [])
    {
        if ('GET' === strtoupper($method)) {
            $uri = $this->normalizeUrl($uri, $options);
            $options = [];
        }

        $response = $this->client->request($method, $uri, $options);

        return $this->buildResponse($response);
    }

    /**
     * @param       $url
     * @param array $parameters
     * @return string
     */
    protected function normalizeUrl(string $url, array $parameters = [])
    {
        $normalizedUrl = $url;

        if (!empty($parameters)) {
            $normalizedUrl .= (false !== strpos($url, '?') ? '&' : '?') . http_build_query($parameters, '', '&');
        }

        return $normalizedUrl;
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