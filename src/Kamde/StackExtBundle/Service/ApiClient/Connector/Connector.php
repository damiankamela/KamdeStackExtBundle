<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Connector;

use GuzzleHttp\ClientInterface;
use Kamde\StackExtBundle\Service\ApiClient\ResponseInterface;

class Connector extends AbstractConnector
{
    /** @var string */
    protected $site;

    /**
     * @param ClientInterface $client
     * @param string          $site
     */
    public function __construct(ClientInterface $client, string $site)
    {
        parent::__construct($client);

        $this->site = $site;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return ResponseInterface
     */
    public function getResponse(string $method, string $uri, array $options = [])
    {
        $options['site'] = $this->site;

        return parent::getResponse($method, $uri, $options);
    }
}