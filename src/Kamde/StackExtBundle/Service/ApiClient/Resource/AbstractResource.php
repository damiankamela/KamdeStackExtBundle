<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Resource;

use GuzzleHttp\Exception\RequestException;
use Kamde\StackExtBundle\Service\ApiClient\Connector\StackConnector;
use Kamde\StackExtBundle\Service\ApiClient\Exception\InvalidMethodCallException;
use Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException;
use Kamde\StackExtBundle\Service\ApiClient\Connector\Request;
use Kamde\StackExtBundle\Service\ApiClient\Connector\StackResponseInterface;
use Kamde\StackExtBundle\Traits\ClassNameResolverTrait;

/**
 * @method array getData()
 */
abstract class AbstractResource implements ResourceInterface
{
    use ClassNameResolverTrait;

    /** @var StackConnector */
    protected $connector;

    /** @var int */
    protected $id;

    /**
     * @param StackConnector $connector
     * @param int            $id
     */
    public function __construct(StackConnector $connector, int $id)
    {
        $this->connector = $connector;
        $this->id = $id;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return StackResponseInterface
     * @throws InvalidMethodCallException
     * @throws MethodNotFoundException
     */
    public function __call(string $name, array $arguments)
    {
        if (false === strpos($name, 'get')) {
            throw new MethodNotFoundException($name, get_called_class());
        }

        if ('getData' === $name) {
            $quota = '';
        } else {
            $quota = $this->decamelize(str_replace('get', '', $name), '-');
        }

        $uri = $this->generateUri($quota, $arguments);
        $request = new Request('GET', $uri);

        try {
            return $this->connector->getResponse($request);
        } catch (RequestException $exception) {
            throw new InvalidMethodCallException($name, get_called_class(), $arguments);
        }
    }

    /**
     * @return StackConnector
     */
    public function getConnector()
    {
        return $this->connector;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $resourceName
     * @param array  $extraQuotas
     * @return string
     */
    protected function generateUri(string $resourceName, array $extraQuotas = [])
    {
        $parts = [
            $this->decamelize($this->getResourceName(), '-'),
            $this->getId(),
            $resourceName
        ];

        if(!empty($extraQuotas)) {
            $parts = array_merge($parts, $extraQuotas);
        }

        return implode('/', $parts);
    }

    /**
     * @return string
     */
    protected function getResourceName()
    {
        return str_replace('Resource', '', $this->getShortClassName()) . 's';
    }
}