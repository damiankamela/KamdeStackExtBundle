<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Exception;

use Throwable;

class ResourceNotFoundException extends \Exception
{
    public function __construct(string $resourceClass, string $message = "", $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = sprintf(
                'The resource ("%s")you want to create is not found.',
                $resourceClass
            );
        }

        parent::__construct($message, $code, $previous);
    }
}