<?php

namespace Kamde\StackExtBundle\Service\ApiClient;

use GuzzleHttp\ClientInterface;

class Connector
{
    /** @var ClientInterface */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function test()
    {
        $response = $this->client->request('GET', '/users/5/top-tags');

        dump(\GuzzleHttp\json_encode($response->getBody(), true));
        die;
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
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return mixed
     */
    protected function getResponse(string $method, string $uri, array $options = [])
    {
        $response = $this->client->request($method, $uri, $options);

        return \GuzzleHttp\json_decode($response->getBody(), true);
    }

}