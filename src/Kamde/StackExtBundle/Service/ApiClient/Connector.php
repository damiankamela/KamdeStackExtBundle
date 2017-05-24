<?php

namespace Kamde\StackExtBundle\Service\ApiClient;

use GuzzleHttp\ClientInterface;

class Connector
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
     * @return mixed
     */
    public function getResponse(string $method, string $uri, array $options = [])
    {
        if ('GET' === strtoupper($method)) {
            $uri = $this->normalizeUrl($uri, $options);
            $options = [];
        }

        $response = $this->client->request($method, $uri, $options);

        return \GuzzleHttp\json_decode($response->getBody(), true);
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
}