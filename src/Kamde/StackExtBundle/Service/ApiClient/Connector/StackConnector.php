<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Connector;

use GuzzleHttp\ClientInterface;
use Kamde\StackExtBundle\Service\ApiClient\Request;
use Kamde\StackExtBundle\Service\ApiClient\StackResponse;
use Kamde\StackExtBundle\Service\ApiClient\StackResponseInterface;

class StackConnector extends AbstractConnector
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
     * @param Request $request
     * @return StackResponseInterface
     */
    public function getResponse(Request $request)
    {
        $request->setParameter('site', $this->site);

        return parent::getResponse($request);
    }

    /**
     * @param array $responseBody
     * @return StackResponse
     */
    protected function buildResponse(array $responseBody)
    {
        return new StackResponse($responseBody);
    }
}