<?php

namespace Kamde\StackExtBundle\Service\ApiClient;

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