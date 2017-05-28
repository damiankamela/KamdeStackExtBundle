<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Resource;

use GuzzleHttp\Exception\RequestException;
use Kamde\StackExtBundle\Service\ApiClient\Connector\Connector;
use Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException;
use Kamde\StackExtBundle\Service\ApiClient\ResponseInterface;
use Kamde\StackExtBundle\Traits\ClassNameResolverTrait;

/**
 * @method array getData()
 */
abstract class AbstractResource implements ResourceInterface
{
    use ClassNameResolverTrait;

    /** @var Connector */
    protected $connector;

    /** @var int */
    protected $id;

    /**
     * @param Connector $connector
     * @param int       $id
     */
    public function __construct(Connector $connector, int $id)
    {
        $this->connector = $connector;
        $this->id = $id;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return ResponseInterface
     * @throws MethodNotFoundException
     */
    public function __call(string $name, array $arguments)
    {
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
}