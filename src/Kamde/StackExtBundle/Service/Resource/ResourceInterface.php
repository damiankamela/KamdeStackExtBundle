<?php

namespace Kamde\StackExtBundle\Service\Resource;

/**
 * @method array getData()
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