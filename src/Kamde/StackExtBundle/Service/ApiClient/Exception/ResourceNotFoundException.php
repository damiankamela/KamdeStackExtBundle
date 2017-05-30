<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Exception;

use Throwable;

class ResourceNotFoundException extends \Exception
{
    /**
     * ResourceNotFoundException constructor.
     * @param string         $resourceClass
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $resourceClass, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('The resource ("%s") was not found.', $resourceClass);

        parent::__construct($message, $code, $previous);
    }
}