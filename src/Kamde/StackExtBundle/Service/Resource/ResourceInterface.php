<?php

namespace Kamde\StackExtBundle\Service\Resource;

use Kamde\StackExtBundle\Service\Connector\StackResponseInterface;

/**
 * @method StackResponseInterface getData()
 */
interface ResourceInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function setId(int $id);

    /**
     * @return int
     */
    public function getId();
}