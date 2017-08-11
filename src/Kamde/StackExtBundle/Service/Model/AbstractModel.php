<?php

namespace Kamde\StackExtBundle\Service\Model;

use Kamde\StackExtBundle\Service\Resource\ResourceInterface;

abstract class AbstractModel
{
    /** @var ResourceInterface */
    protected $resource;

    /**
     * @param ResourceInterface $resource
     * @return self
     */
    public function setResource(ResourceInterface $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return ResourceInterface
     */
    public function getResource(): ResourceInterface
    {
        return $this->resource;
    }
}