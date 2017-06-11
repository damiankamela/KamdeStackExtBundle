<?php

namespace Kamde\StackExtBundle\Service;

interface MiddlewareInterface
{
    /**
     * @return callable
     */
    public function getMiddleware();

    /**
     * @return string
     */
    public function getName();

}