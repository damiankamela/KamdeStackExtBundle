<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Resource;

use GuzzleHttp\Exception\RequestException;
use Kamde\StackExtBundle\Service\ApiClient\Connector;
use Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException;
use Kamde\StackExtBundle\Service\ApiClient\Exception\ResourceNotSetException;
use Kamde\StackExtBundle\Traits\ClassNameResolverTrait;

abstract class AbstractResource
{
    use ClassNameResolverTrait;

    /** @var Connector */
    protected $connector;

    /** @var int */
    protected $id;

    /**
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return mixed
     * @throws MethodNotFoundException
     * @throws ResourceNotSetException
     */
    public function __call(string $name, array $arguments)
    {
        if(null === $this->id) {
            throw new ResourceNotSetException('id');
        }

        if(false === strpos($name, 'get')) {
            throw new MethodNotFoundException(sprintf('Method "%s not found in "%s" class.', $name, get_called_class()));
        }

        if('getData' === $name) {
            $resourceName = '';
        } else {
            $resourceName = $this->decamelize(str_replace('get', '', $name), '-');
        }

        $uri = $this->generateUri() . $resourceName;

        try {
            return $this->connector->getResponse('GET', $uri);
        } catch (RequestException $exception) {
            throw new MethodNotFoundException(sprintf('Method "%s" not found in "%s" class.', $name, get_called_class()));
        }
    }

    /**
     * @return Connector
     */
    public function getConnector()
    {
        return $this->connector;
    }

    /**
     * @return string
     */
    protected function generateUri()
    {
        return $this->decamelize($this->getResourceName(), '-') . '/' . $this->getId() . '/';
    }

    /**
     * @return string
     */
    protected function getResourceName()
    {
        return str_replace('Resource', '', $this->getShortClassName()) . 's';
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

}