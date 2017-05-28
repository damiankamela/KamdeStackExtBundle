<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Resource;

use Kamde\StackExtBundle\Service\ApiClient\Connector\StackConnector;
use Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException;
use Kamde\StackExtBundle\Service\ApiClient\Exception\ResourceNotFoundException;

/**
 * @method UserResource createUserResource(int $id)
 */
class ResourceFactory
{
    /** @var StackConnector */
    protected $connector;

    /**
     * @param StackConnector $connector
     */
    public function __construct(StackConnector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return ResourceInterface
     * @throws MethodNotFoundException
     * @throws ResourceNotFoundException
     */
    public function __call(string $name, array $arguments)
    {
        if (false === strpos($name, 'create')) {
            throw new MethodNotFoundException(sprintf('Method "%s not found in "%s" class.', $name, get_called_class()));
        }

        $resourceClass = __NAMESPACE__ . '\\' . str_replace('create', '', $name);

        if (!class_exists($resourceClass)) {
            throw new ResourceNotFoundException($resourceClass);
        }

        $resourceId = $arguments[0];

        return $this->createResource($resourceClass, $resourceId);
    }

    /**
     * @param string $resourceClass
     * @param int    $id
     * @return ResourceInterface
     */
    protected function createResource(string $resourceClass, int $id)
    {
        $resource = new $resourceClass($this->connector, $id);

        return $resource;
    }
}