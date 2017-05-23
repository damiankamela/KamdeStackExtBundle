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
}